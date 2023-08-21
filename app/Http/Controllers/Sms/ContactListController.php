<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmsContact;
use App\Models\SmsContactList;
use App\Models\SmsCampaign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SmsContactListExport;
use App\Jobs\SmsUploadContactList;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ContactListController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;
        if (!$company_id && $role == 'user') {
            // TODO! implement proper error handling.
            abort(403, 'Please define company of user.');
        }
        $q = SmsContactList::query();
        if ($role == 'user') {
            $q->Where('user_id', $user_id)->Where('company_id', $company_id);
        }
        if ($role == 'company') {
            $q->where('company_id', $user->company_id);
        }
        $lists = $q->orderBy('id', 'desc')->get();

        return view('sms.contact-list.index', compact('lists'));
    }

    public function mapContactList(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;

        $request->validate([
            'file' => 'required',
            'name' => 'required',
        ]);

        $fileName = time().'.csv';

        $file = file($request->file('file'));

        $fileRows = count($file);
        // $fileRows = $fileRows - 1;

        $uploadFileName = $request->file('file')->getClientOriginalName();

        // $fileName = $user_id.'_'.pathinfo($uploadFileName, PATHINFO_FILENAME).'_'.$fileRows.'.csv';

        //  $upload = storage_path().'/app/contact-lists/'.$fileName;
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
        $pattern2 = '/(first_name|last_name|first name|last name|firstname|lastname)/i';
        unset($csv);

        if (preg_match($pattern, strtolower($col)) === 0) {
            return redirect()->back()->with('error', 'Please add a phone column to your CSV.');
        } else {
            if (preg_match($pattern2, strtolower($col)) === 0) {
                return redirect()->back()->with('error', 'Please add a first_name,last_name column to your CSV.');
            } else {
                $request->file->move(storage::path('sms/contact-lists'), $fileName);

                $list_name = $request->name;

                return view('sms.contact-list.map_contacts', compact('header', 'user_id', 'company_id', 'fileName', 'fileRows', 'list_name'));
            }
        }
    }

    public function mapContactListUpload(Request $request)
    {
        // dd($request->all());
        // $upload = storage_path().'/app/sms/contact-lists/'.$request->fileName;
        // $csv = array();
        // $file1 = fopen($upload, 'r');

        // while (($result = fgetcsv($file1)) !== false)
        // {
        //     $csv[] = $result;
        // }

        // $number_arrays=[];
        // $updatedFileRows = 0;
        // if(count($csv) > 0){
        //     $data = [];
        //     $x=0;
        //     for ($i=1; $i < $request->fileRows ; $i++) {
        //         $raw_number = preg_replace('/[^0-9]/', '', $csv[$i][$request->csv_phone_key]);
        //         if(strlen($raw_number) == 10  || strlen($raw_number) == 11){
        //             $number_arrays[$x]['number']=$csv[$i][$request->csv_phone_key];
        //             $number_arrays[$x]['first_name']=$csv[$i][$request->csv_first_name_key];
        //             $number_arrays[$x]['last_name']=$csv[$i][$request->csv_last_name_key];
        //             // array_push($number_arrays['number'],$csv[$i][$request->csv_phone_key]);
        //             // array_push($number_arrays['first_name'],$csv[$i][$request->csv_first_name_key]);
        //             // array_push($number_arrays['last_name'],$csv[$i][$request->csv_last_name_key]);
        //             $x++;
        //         }

        //     }
        //     $unique_number_array = array_unique($number_arrays, SORT_REGULAR);

        //     $updatedFileRows = count($unique_number_array);
        //     if($unique_number_array !== null && $updatedFileRows > 0){
        //         foreach($unique_number_array as $num){

        //             $formatNumber = formatNumber($num['number']);
        //             if($formatNumber){
        //                 $data[] = [
        //                     // 'number'=> $csv[$i],
        //                     'number'=> preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $num['number']),
        //                     'sms_contact_list_id' => $request->list_id,
        //                     'user_id' => $request->user_id,
        //                     'company_id' => $request->company_id,
        //                     'first_name' => $num['first_name'],
        //                     'last_name' => $num['last_name'],
        //                     'status' => "active",
        //                     'raw_number' => $formatNumber,
        //                     // 'raw_number' => preg_replace('/[^0-9]/', '', $num),
        //                     'created_at' => now()->toDateTimeString(),
        //                     'updated_at' => now()->toDateTimeString(),
        //                 ];
        //             }

        //         }
        //     }

        // }
        // dd($data);
        $user_id = $request->user_id;
        $company_id = $request->company_id;
        $fileName = $request->fileName;
        $fileRows1 = $request->fileRows;
        $list_name = $request->list_name;

        $csv_header_index = $request->csv_header_index;
        $csv_header_value = $request->csv_header_value;

        $csv_first_name_value = $request->csv_first_name_value;
        $csv_first_name_key = $request->csv_first_name_key;

        $csv_last_name_value = $request->csv_last_name_value;
        $csv_last_name_key = $request->csv_last_name_key;

        $csv_phone_value = $request->csv_phone_value;
        $csv_phone_key = $request->csv_phone_key;

        $queue_name = Str::random(10);
        $list = new SmsContactList();
        $list->name = $list_name;
        $list->user_id = $user_id;
        $list->company_id = $company_id;
        $list->path = 'sms/contact-lists/'.$fileName;
        $list->filename = $fileName;
        $list->total_contacts = $fileRows1 - 1;
        $list->status = 'preprocessing';
        $list->jobs = $queue_name;
        $list->job_status = 'pending';
        $list->save();
        // dd($csv_header_value);

        $fileRows = $list->total_contacts;
        $list_id = $list->id;

        SmsUploadContactList::dispatchAfterResponse(
            $list_id,
            $fileName,
            $user_id,
            $company_id,
            $queue_name,
            $fileRows,
            $csv_first_name_value,
            $csv_first_name_key,
            $csv_last_name_value,
            $csv_last_name_key,
            $csv_phone_value,
            $csv_phone_key
        );

        $success = 'Contact List Added Successfully.';

        return redirect()->route('user.sms_contact-list.contact-list')->with(compact('success'));
    }

    public function ajaxStore(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;

        // code after job
        $fileName = time().'.csv';

        $file = file($request->file);

        $request->file->move(storage::path('sms/contact-lists'), $fileName);

        $fileRows = count($file);

        // dd($fileRows);

        $queue_name = Str::random(10);

        $list = new SmsContactList();
        $list->name = $request->name;
        $list->user_id = $user_id;
        $list->company_id = $company_id;
        $list->path = 'sms/contact-lists/'.$fileName;
        $list->filename = $fileName;
        $list->total_contacts = $fileRows - 1;
        $list->status = 'active';
        $list->jobs = '';
        $list->job_status = 'pending';
        $list->save();

        $lists = SmsContactList::where('user_id', $user_id)->where('company_id', $company_id)->where('status', '!=', 'deleted')->get();

        return response()->json(['contactList' => $lists, 'success' => 'Contact List Added Successfully.']);
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
        $pattern2 = '/(first_name|last_name|first name|last name|firstname|lastname)/i';

        unset($csv);
        if (preg_match($pattern, strtolower($col)) === 0) {
            return response()->json(['success' => true]);
        // return redirect()->back()->with('error','Please add a phone column to your CSV.');
        } else {
            if (preg_match($pattern2, strtolower($col)) === 0) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function show($id)
    {
        $list = SmsContactList::Where('id', $id)->first();

        $data = SmsContact::Where('sms_contact_list_id', $id)->paginate(20);

        return view('sms.contact-list.show', compact('data'));
    }

    public function destroy($id)
    {
        $contact_list = SmsContactList::find($id);
        $file_path = storage_path().'/app/sms/contact-lists/'.$contact_list->filename;
        if (file_exists($file_path)) {
            unlink(storage_path('app/sms/contact-lists/'.$contact_list->filename));
        }

        $contacts = SmsContact::where('sms_contact_list_id', $id)->update(['status' => 'deleted']);

        $contact_list->status = 'deleted';
        // $contact_list->deleted_at = Carbon::now();
        $contact_list->save();

        return redirect()->back()->with('success', 'List Deleted Successfully');
    }

    public function checkContactsCampaigns($id)
    {
        $status = ['played', 'paused', 'pending'];
        $campaigns = SmsCampaign::whereJsonContains('sms_contact_list_id', ["$id"])->whereIn('status', $status)->get();
        if (count($campaigns) != 0) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function exportContactListContacts($contact_list_id)
    {
        $id = $contact_list_id;
        if ($id != null) {
            return Excel::download(new SmsContactListExport($id), 'contact_list.csv');
        }
    }
}
