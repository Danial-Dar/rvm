<?php

namespace App\Http\Controllers\Cir;

use App\Models\Company;
use App\Models\Contact;
use App\Models\ContactList;
use Illuminate\Support\Str;
use App\Rules\ValidUsNumber;
use Illuminate\Http\Request;
use App\Jobs\UploadCirNumbers;
use App\Models\AreaCodeLocation;
use Illuminate\Support\Collection;
use App\Jobs\ReputationCheckNumber;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CalleridContactExport;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ReputationCheckContactList;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

class CirNumberManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $companies = [];
        if (Auth()->user()->role == 'admin') {
            $companies = Company::where('status', 1)->get();
        }

        $lists = Contact::Where('type', 'cir')
        ->Where('status', 'active')
        // where('reputation_checked', true)
        ->with(['company', 'contactList'])
        ->when(Auth()->user()->role != 'admin' && Auth()->user()->company_id != null, function ($q) {
            return $q->Where('company_id', Auth::user()->company_id);
        })->orderBy('id', 'desc')->paginate(20);

        return view('callerid.list.show', compact('lists', 'companies'));
    }

    private function checkReputationIndividual($contact_list_id, $contact)
    {
        if ($access_token = getRobokillerAccessToken()) {
            return dispatch_sync(
                new ReputationCheckNumber(
                    $contact->id,
                    $access_token,
                )
            );
        } else {
            return false;
        }
    }

    public function mapContactList(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        if ($user->role == 'admin') {
            if (!($company_id = $request->company)) {
                $error = 'Company is needed to be select.';

                return back() - with(compact('error'));
            }
        } else {
            if (!(Auth::user()->company_id == null)) {
                $error = 'This might be a test user with no company associated with it.';

                return back() - with(compact('error'));
            }
            $company_id = $user->company_id;
        }

        $request->validate([
            'file' => 'required_if:type,==,csv',
            'number' => 'required_if:type,==,individual',
            'type' => 'required|in:csv,individual',
        ]);

        if ($request->type == 'individual') {
            $validator = Validator::make(
                $request->all(),
                ['number' => [new ValidUsNumber()]]
            );
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
        }

        if ($request->type == 'csv') {
            $fileName = time().'.csv';
            $file = file($request->file('file'));
            $fileRows = count($file);
            // $fileRows = $fileRows - 1;
            $uploadFileName = $request->file('file')->getClientOriginalName();

            $upload = $request->file('file');
            $filepath = $upload->getRealPath();

            $csv = [];
            $file1 = fopen($filepath, 'r');
            $csv = array_map('str_getcsv', file($upload));
            $header = array_shift($csv);
            // Seperate the header from data
            $col = implode(',', $header);
            $pattern = '/(phone|cell|number|mobile|contact)/i';

            unset($csv);
            if (preg_match($pattern, strtolower($col)) === 0) {
                return redirect()->back()->with('error', 'Please add a phone column to your CSV.');
            } else {
                $request->file->move(storage::path('cir-lists'), $fileName);

                return view('callerid.list.map_contacts', compact('header', 'user_id', 'company_id', 'fileName', 'fileRows'));
            }
        } else {
            //add number under General contctlist
            $contactList = ContactList::firstOrCreate([
                'name' => 'CirList_general',
                'company_id' => $company_id,
                'user_id' => $user_id,
                'type' => 'cir',
            ], [
                'path' => '',
                'status' => 'active',
                'total_contacts' => 0,
                'reputation_check_status' => 'complete',
            ]);

            $formated = formatNumber($request->number);
            Log::info('maskUsNumber($formated):'.maskUsNumber($formated));
            $area = AreaCodeLocation::select('location_code')->firstWhere('area_code', getStateCodeNumber($formated));
            $contact = Contact::updateOrCreate([
                'contact_list_id' => $contactList->id,
                'number' => maskUsNumber($formated),
                'user_id' => $user_id,
                'company_id' => $company_id,
                // 'number' => preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $request->number),
                'type' => 'cir',
            ], [
                'company_name' => $contactList->company->name,
                'raw_number' => $formated,
                'cir_state' => $area->location_code,
                'status' => 'active',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ]);
            $contactList->total_contacts = Contact::Where('contact_list_id', $contactList->id)->count();
            $contactList->save();

            if ($this->checkReputationIndividual($contactList->id, $contact)) {
                $success = 'Number has Added Successfully.';

                return redirect()->route('callerid.list')->with(compact('success'));
            } else {
                $error = 'Number has Added Unsuccessfully.';

                return redirect()->route('callerid.list')->with(compact('error'));
            }
        }
    }

    public function mapContactListUpload(Request $request)
    {
        $user_id = $request->user_id;
        $company_id = $request->company_id;

        $fileName = $request->fileName;
        $fileRows1 = $request->fileRows;
        // dd($request->all());
        $csv_header_index = $request->csv_header_index;
        $csv_header_value = $request->csv_header_value;
        $queue_name = 'CirList_'.Str::random(10);

        $path = 'cir-lists/'.$fileName;
        $total_contacts = $fileRows1 - 1;
        $contactList = ContactList::firstOrCreate([
            'name' => $queue_name,
            'company_id' => $company_id,
            'user_id' => $user_id,
            'type' => 'cir',
        ], [
            'path' => '',
            'status' => 'active',
            'total_contacts' => 0,
            'reputation_check_status' => 'inprocess',
        ]);

        Bus::chain([
            new UploadCirNumbers(
                $contactList->id,
                $fileName,
                $request->fileRows,
                $csv_header_index,
                $csv_header_value
            ),
            new ReputationCheckContactList(
                $contactList->id,
            ),
        ])->dispatch();

        $success = 'Request Success. List will be Uploaded and Check in a while.';

        return redirect()->route('callerid.list')->with(compact('success'));
    }

    public function validateCsv(Request $request)
    {
        $upload = $request->file('file');

        $filepath = $upload->getRealPath();

        $csv = [];
        $file1 = fopen($filepath, 'r');
        $csv = array_map('str_getcsv', file($upload));
        $header = array_shift($csv);
        // Seperate the header from data

        // $col = array_search("phone_number", $header);
        $col = implode(',', $header);
        $pattern = '/(phone|cell|number|mobile|contact)/i';

        unset($csv);
        if (preg_match($pattern, strtolower($col)) === 0) {
            return response()->json(['success' => true]);
        // return redirect()->back()->with('error','Please add a phone column to your CSV.');
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function paginate($items, $newId, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, ['path' => url('callerid/list/'.$newId)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Contact::find($id)->update(['status' => 'deleted']);

        return redirect()->back()->with('success', 'Number Deleted Successfully');
    }

    public function exportContacts()
    {
        $role = Auth()->user()->role;
        if ($role != 'admin' && Auth()->user()->company_id == null) {
            $error = 'This might be a test user with no company associated with it.';

            return back() - with(compact('error'));
        }
        if ($role != 'admin') {
            return Excel::download(new CalleridContactExport(Auth()->user()->company_id, 'company'), 'callerid_contact_list.csv');
        } else {
            return Excel::download(new CalleridContactExport(Auth()->user()->company_id, 'super'), 'callerid_contact_list_admin.csv');
        }
    }
}
