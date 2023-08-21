<?php

namespace App\Http\Controllers\Nova;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SmsContactList;
use App\Jobs\SmsUploadContactList;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Jobs\SmsUploadContactListFromlistInput;
use App\Models\SmsContact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SmsContactListController extends Controller
{
    public function uploadList(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;

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

        // $col = array_search("phone_number", $header);
        $col = implode(',', $header);
        $pattern = '/(phone|cell|number|mobile|contact)/i';

        unset($csv);

        if (preg_match($pattern, strtolower($col)) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Please add a phone column to your CSV.',
            ], 400);
        } else {
            $request->file->move(storage::path('contact-lists'), $fileName);
            $list_name = $request->name;

            $queue_name = Str::random(10);
            $list = new SmsContactList();
            $list->name = $list_name;
            $list->user_id = $user_id;
            $list->company_id = $company_id;
            $list->path = 'contact-lists/'.$fileName;
            $list->filename = $fileName;
            $list->total_contacts = $fileRows - 1;
            $list->status = 'preprocessing';
            $list->jobs = $queue_name;
            $list->job_status = 'pending';
            $list->save();

            $fileRows = $list->total_contacts;
            $list_id = $list->id;

            $csv_header_index = 0;
            $csv_header_value = 'number';

            SmsUploadContactList::dispatchAfterResponse($list_id, $fileName, $user_id, $company_id, $queue_name, $fileRows, $csv_header_index, $csv_header_value);

            return response()->json([
                'success' => true,
                'message' => 'Contact List Uploaded Successfully.',
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $params = $request->all();
        Log::info($params);
        $user_id = $params[0]['custom_fields']['id'];
        $list_id = $params[0]['custom_fields']['list_id'];
        $user = User::Find($user_id);
        $contacts = [];
        $data = [];
        Log::info($user_id);
        foreach ($params as $row) {
            $data = $row['row_data'];
            $data['user_id'] = $user_id;
            $data['company_id'] = $user->company_id;
            $data['sms_contact_list_id'] = $list_id;
            $data['raw_number'] = formatNumber($data['number']);
            $data['status'] = 'active';
            $data['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $data['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

            $contacts[] = $data;
        }
        $list = SmsContactList::withTrashed()->Find($list_id)->restore();

        $cont_list = SmsContactList::Find($list_id);
        $cont_list->status = 'active';
        $cont_list->save();

        Log::info($contacts);

        if (count($contacts) > 0) {
            SmsContact::insert($contacts);
        }


        // $user = Auth::user();
        // $user_id = $user->id;
        // if (preg_match('/[^a-z0-9 _]+/i', $request->name)) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Special Characters Are Not Allowed.',
        //     ], 200);
        // }
        // if ($user->role === 'admin') {
        //     if (!($company_id = $request->company_id)) {
        //         $error = 'Company is needed to be select.';

        //         return response()->json(['status' => 'error', 'message' => $error], 422);
        //     }
        // } else {
        //     if (($user->company_id == null)) {
        //         $error = 'This might be a test user with no company associated with it.';

        //         return response()->json(['status' => 'error', 'message' => $error], 422);
        //     }
        //     $company_id = $user->company_id;
        // }
        // $data = $request->file;
        // $fileRows = count($data);

        // $name = $request->name;
        // $fileName = $name.'.csv';

        // $path = storage::path('sms-contact-lists');
        // if(!\File::isDirectory($path)){

        //     \File::makeDirectory($path, 0777, true, true);

        // }
        // $f = fopen(storage::path('sms-contact-lists').'\\'.$fileName, 'w');

        // if ($f === false) {
        //     exit('Error opening the file '.$fileName);
        // }

        // foreach ($data as $row) {
        //     fputcsv($f, $row);
        // }
        // fclose($f);

        // $queue_name = Str::random(10);
        // $list = new SmsContactList();
        // $list->name = $request->name ?? 'name';
        // $list->user_id = $user_id;
        // $list->company_id = $company_id;
        // $list->path = 'sms-contact-lists/';
        // $list->filename = $fileName;
        // $list->total_contacts = $fileRows ?? 0;
        // $list->status = 'preprocessing';
        // $list->jobs = $queue_name;
        // $list->job_status = 'pending';
        // $list->save();

        // dispatch(new SmsUploadContactListFromlistInput(
        //     $list->id,
        //     $request->file
        // ));

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Contact List Uploaded Successfully.',
        // ], 200);
    }

    public function createSmsContatList($name)
    {
        $list = new SmsContactList();
        $list->name = $name;
        $list->status = 'preprocessing';
        $list->user_id = Auth::user()->id;
        $list->company_id = Auth::user()->company_id;
        $list->save();

        $list_id = $list->id;

        $list->delete();

        return response()->json([
            'id' => $list_id,
        ], 200);
    }
}
