<?php

namespace App\Http\Controllers\Nova\Callerid;

use App\Models\Company;
use App\Models\Contact;
use App\Models\ContactList;
use Illuminate\Support\Str;
use App\Rules\ValidUsNumber;
use Illuminate\Http\Request;
use App\Models\AreaCodeLocation;
use App\Jobs\ReputationCheckNumber;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use App\Exports\CalleridContactExport;
use App\Jobs\CirContactListDispatcher;
use App\Jobs\ReputationCheckContactList;
use App\Jobs\UploadCirContactList;
use Illuminate\Support\Facades\Validator;
use App\Jobs\UploadCirNumbersFromlistInput;

class CirContactListController extends Controller
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

    private function checkReputationIndividual($contact_list_id, $contact)
    {
        if ($access_token = getRobokillerAccessToken()) {
            return dispatch_sync(
                new ReputationCheckNumber(
                    $contact->id,
                    $access_token
                )
            );
        } else {
            return false;
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $request->validate([
            'file' => 'required_if:type,==,csv',
            'number' => 'required_if:type,==,individual',
            'type' => 'required|in:csv,individual',
        ]);

        if ($request->type == 'individual') {
            //Log::notice('migcrotime strat:'.microtime(true));
            $validator = Validator::make(
                $request->all(),
                ['number' => [new ValidUsNumber()]]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation Error',
                    'errors' => $validator->messages()->get('*'),
                ]);
            }

            //add number under General contctlist
            $contactList = ContactList::where([
                    'name' => 'CirList_Individual',
                    'company_id' => $company_id,
                    'type' => 'cir',
                ])->first();
            if ($contactList) {
                $contactList->update(
                    [
                        'status' => 'active',
                        'total_contacts' => $contactList->total_contacts + 1,
                        'reputation_check_status' => 'complete',
                    ]
                );
            } else {
                $contactList = ContactList::create([
                    'name' => 'CirList_Individual',
                    'company_id' => $company_id,
                    'user_id' => $user_id,
                    'type' => 'cir',
                    'path' => '',
                    'status' => 'active',
                    'total_contacts' => 0,
                    'reputation_check_status' => 'complete',
                ]);
            }

            $formated = formatNumber($request->number);
            if (!$formated) {
                return response()->json(['status' => 'error', 'message' => 'Not a valid us Number !']);
            }

            // Log::info('maskUsNumber($formated):'.maskUsNumber($formated));
            $area = AreaCodeLocation::select('location_code')->firstWhere('area_code', getStateCodeNumber($formated));
            // dd(getStateCodeNumber($formated), $area);
            if (!$area) {
                return response()->json(['status' => 'error', 'message' => 'Number is Not Form Registerd Area Codes!']);
            }
            /*echo "<pre>";print_r($contactList);

            exit;*/
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
                // 'created_at' => now()->toDateTimeString(),
                // 'updated_at' => now()->toDateTimeString(),
            ]);
            $contactList->total_contacts = Contact::Where('contact_list_id', $contactList->id)->count();
            $contactList->save();
            Log::notice('migcrotime before dispatch:'.microtime(true));

            ReputationCheckNumber::dispatchAfterResponse($contact->id);

            $success = 'Number has Added Successfully.';
            Log::notice('migcrotime afterdispattch:'.microtime(true));

            return response()->json(['status' => 'success', 'message' => $success]);
        } 
        
        // elseif ($request->type == 'csv') {
        //     if (!$request->meta) {
        //         return response()->json(['status' => 'error', 'message' => 'Need Meta Data'], 422);
        //     }
        //     $meta = (object) $request->meta;
        //     // meta:{
        //     //     chunksize:this.chunkSize,
        //     //     chunk_total:chunksTotals,
        //     //     index:i,
        //     //     totals:totals,
        //     //     unique:uniqueKey
        //     // }

        //     Cache::add($meta->unique.'.'.$meta->index, $request->file);
        //     if ($meta->index < ($meta->chunk_total - 1)) {
        //         $success = 'Request Success.';
        //     } else {
        //         $list_name = 'CirList_'.Str::random(10);
        //         $contactList = ContactList::firstOrCreate([
        //             'name' => $list_name,
        //             // 'jobs' => $meta->unique,
        //             'company_id' => $company_id,
        //             'user_id' => $user_id,
        //             'type' => 'cir',
        //         ], [
        //             'path' => '',
        //             'status' => 'active',
        //             'total_contacts' => 0,
        //             'reputation_check_status' => 'inprocess',
        //         ]);

        //         dispatch(new CirContactListDispatcher($contactList, $meta));

        //         $success = 'Request Success. List will be Uploaded and Checkin will Start in a small while.';
        //     }

        //     return response()->json(['status' => 'success', 'message' => $success, 'meta' => $meta]);
        // } 
        
        else {
            return false;
        }
    }

    public function upload(Request $request){
        $ext = explode('.',$request->file->getClientOriginalName());
        if (end($ext) !== 'csv') {
            return response()->json([
                'success' => false,
                'message' => 'Please Upload Csv File Only',
            ], 200);
        }
        // dd('HEllo');
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;

        $data = $request->file;
        // $fileRows = count($data);

        $type = $request->type;
        $fileName = 'CirList_'.Str::random(10).'.csv';

        $upload_path = storage_path() . '/app/contact-lists/';
        $request->file->move($upload_path, $fileName);
        // $f = fopen(storage_path() . '/app/contact-lists/'.$fileName, 'w');

        // if ($f === false) {
        //     exit('Error opening the file '.$fileName);
        // }

        // foreach ($data as $row) {
        //     fputcsv($f, $row);
        // }
        // fclose($f);



        $queue_name = Str::random(10);
        $list = new ContactList();
        $list->name = $fileName;
        $list->user_id = $user_id;
        $list->company_id = $company_id;
        $list->path = 'contact-lists/'.$fileName;
        $list->filename = $fileName;
        $list->total_contacts = 100000;
        $list->status = 'active';
        $list->type = 'cir';
        $list->reputation_check_status = 'inprocess';
        $list->jobs = $queue_name;
        $list->job_status = 'pending';
        $list->save();

        $fileRows = $list->total_contacts;
        $list_id = $list->id;

        $csv_header_index = 0;
        $csv_header_value = 'number';

        // UploadContactList::dispatchAfterResponse($list_id, $fileName, $user_id, $company_id, $queue_name, $fileRows, $csv_header_index, $csv_header_value);
         UploadCirContactList::dispatchAfterResponse($list_id, $fileName, $user_id, $company_id, $queue_name, $fileRows, $csv_header_index, $csv_header_value);
            // dd('Heellloo');
        return response()->json([
            'success' => true,
            'message' => 'Contact List Uploaded Successfully.',
        ], 200);
    }

    public function getCompanies(Request $request)
    {
        $companies = Company::all();

        return response()->json(['companies' => $companies]);
    }

    public function exportContacts($contact_list_id)
    {
        $role = Auth()->user()->role;
        if ($role != 'admin' && Auth()->user()->company_id == null) {
            $error = 'This might be a test user with no company associated with it.';

            return back() - with(compact('error'));
        }
        if ($role != 'admin') {
            return Excel::download(new CalleridContactExport(Auth()->user()->company_id, 'company'), 'callerid_contact_list.csv');
        } else {
            return Excel::download(new CalleridContactExport(Auth()->user()->company_id, 'company'), 'callerid_contact_list_admin.csv');
        }
    }
}
