<?php

namespace App\Http\Controllers\Nova;

use App\Http\Controllers\Controller;
use App\Jobs\ReputationCheckContactList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\ContactList;
use App\Jobs\UploadContactList;
use App\Jobs\UploadContactListCsvBox;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContactListController extends Controller
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
            $list = new ContactList();
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

            UploadContactList::dispatchAfterResponse($list_id, $fileName, $user_id, $company_id, $queue_name, $fileRows, $csv_header_index, $csv_header_value);

            return response()->json([
                'success' => true,
                'message' => 'Contact List Uploaded Successfully.',
            ], 200);
        }
    }

    public function createContactList($name)
    {
        // if (preg_match('/[^a-z0-9 _]+/i', $name)) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Special Characters Are Not Allowed.',
        //     ], 200);
        // }
        // $checkName = ContactList::where('name',$name)->first();
        // if($checkName){
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Contact List name already exists',
        //     ], 200);
        // }
        $contact_list = new ContactList;
        $contact_list->name = $name;
        $contact_list->user_id = Auth::user()->id;
        $contact_list->company_id = Auth::user()->company_id;
        $contact_list->path = 'CSv Box';
        $contact_list->total_contacts = 0;
        $contact_list->status = 'preprocessing';
        $contact_list->save();

        $list_id = $contact_list->id;

        $contact_list->delete();

        return response()->json([
            'id' => $list_id,
        ], 200);
    }

    public function createCirContactList($name)
    {
        $contact_list = new ContactList;
        $contact_list->name = $name;
        $contact_list->user_id = Auth::user()->id;
        $contact_list->company_id = Auth::user()->company_id;
        $contact_list->path = 'CSv Box';
        $contact_list->total_contacts = 0;
        $contact_list->status = 'preprocessing';
        $contact_list->type = 'cir';
        $contact_list->save();

        $list_id = $contact_list->id;

        $contact_list->delete();

        return response()->json([
            'id' => $list_id,
        ], 200);
    }

    public function storeCirContactList(Request $request)
    {
        $params = $request->all();
        Log::info($params);
        // $user_id = $params['custom_fields']['id'];
        $list_id = $params['custom_fields']['list_id'];

        ReputationCheckContactList::dispatchAfterResponse($list_id);

        return response()->json([
            'success' => true,
            'message' => 'Cir Contact List Added Successfully',
        ], 200);
    }

    public function storeCirContactListWebhook(Request $request)
    {
        $params = $request->all();
        $list_id = $params[0]['custom_fields']['list_id'];

        ReputationCheckContactList::dispatchAfterResponse($list_id);
    }

    public function storeContactList(Request $request)
    {
        $params = $request->all();
        Log::info($params);
        $user_id = $params[0]['custom_fields']['id'];
        $list_id = $params[0]['custom_fields']['list_id'];
        $user = User::Find($user_id);
        $company_id = $user->company_id;
        // $queue_name = Str::random(10);
        // $fileName = 'file';
        // $fileRows = 0;

        // $csv_header_index = 0;
        // $csv_header_value = 'number';

        UploadContactListCsvBox::dispatchAfterResponse($list_id, $user_id, $company_id, $params);

        return response()->json([
            'success' => true,
            'message' => 'Contact List Uploaded Successfully.',
        ], 200);
    }

    public function store(Request $request)
    {
        ini_set('memory_limit', '-1');
        $ext = explode('.',$request->file->getClientOriginalName());
        if (preg_match('/[^a-z0-9 _]+/i', $request->name)) {
            return response()->json([
                'success' => false,
                'message' => 'Special Characters Are Not Allowed.',
            ], 200);
        }
        if (end($ext) !== 'csv') {
            return response()->json([
                'success' => false,
                'message' => 'Please Upload Csv File Only',
            ], 200);
        }
        $checkName = ContactList::where('name',$request->name)->first();
        if($checkName){
            return response()->json([
                'success' => false,
                'message' => 'Contact List name already exists',
            ], 200);
        }
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;

        $data = $request->file;
        //  $check = count($data);
        $name = $request->name;
        $fileName = 'cl-'.time().'.csv';

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

        $file1 = fopen( storage_path() . '/app/contact-lists/'.$fileName, 'r');
        $csv = [];
        while (($result = fgetcsv($file1)) !== false) {
            // $csv[] = $result[0];
            $csv[] = $result;
        }

        if(!count($csv)){

        return response()->json([
            'success' => false,
            'message' => 'Empty csv file',
        ], 200);
    }

        $queue_name = Str::random(10);
        $list = new ContactList();
        $list->name = $name;
        $list->user_id = $user_id;
        $list->company_id = $company_id;
        $list->path = 'contact-lists/'.$fileName;
        $list->filename = $fileName;
        $list->total_contacts = count($csv);
        $list->status = 'preprocessing';
        $list->jobs = $queue_name;
        $list->job_status = 'pending';
        $list->save();

        $fileRows = $list->total_contacts;
        $list_id = $list->id;

        $csv_header_index = 0;
        $csv_header_value = 'number';

        UploadContactList::dispatchAfterResponse($list_id, $fileName, $user_id, $company_id, $queue_name, $fileRows, $csv_header_index, $csv_header_value);

        return response()->json([
            'success' => true,
            'message' => 'Contact List Uploaded Successfully.',
        ], 200);
    }

    public function getContactHeatMap(Request $request, $id)
    {
        $sql = "SELECT
        COUNT(*) AS value,
        CONCAT('US-',acl.location_code) as id
        from contacts cc
        LEFT JOIN area_code_location acl on TRIM(SUBSTRING(cc.number, 3, 3)) = acl.area_code
        WHERE cc.number IS NOT NULL AND acl.location_code IS NOT NULL
        AND cc.contact_list_id = $id
        GROUP BY acl.location_code";

        $data = collect(DB::select(DB::raw($sql)))->toArray();

        return response()->json(['query' => $data],200);
    }

    public function getDncContactHeatMap(Request $request, $id)
    {
        $sql = "SELECT
        COUNT(*) AS value,
        CONCAT('US-',acl.location_code) as id
        from contacts cc
        LEFT JOIN area_code_location acl on TRIM(SUBSTRING(cc.number, 3, 3)) = acl.area_code
        WHERE cc.number IS NOT NULL AND acl.location_code IS NOT NULL
        AND cc.contact_list_id = $id
        GROUP BY acl.location_code";

        $data = collect(DB::select(DB::raw($sql)))->toArray();

        return response()->json(['query' => $data],200);
    }

    public function getLergPiechart($id)
    {
        $cond = "WHERE contact_list_id = '$id'";
        $sql = "SELECT COUNT(*) as total,lerg_category
            from contacts
            $cond
            GROUP BY lerg_category
        ";

        $lergPie = collect(DB::select(DB::raw($sql)))->toArray();

        return response()->json(['query' => $lergPie],200);
    }

    public function getMobilePiechart($id)
    {
        $cond = "WHERE lerg_category = 'Mobile' AND contact_list_id = '$id'";
        $sql = "SELECT COUNT(*) as total,lerg_company_name
            from contacts
            $cond
            GROUP BY lerg_company_name
        ";

        $mobilePie = collect(DB::select(DB::raw($sql)))->toArray();

        return response()->json(['query' => $mobilePie],200);
    }

    public function getVoipPiechart($id)
    {
        $cond = "WHERE lerg_category = 'VOIP' AND contact_list_id = '$id'";
        $sql = "SELECT COUNT(*) as total,lerg_company_name
            from contacts
            $cond
            GROUP BY lerg_company_name
        ";

        $voipPie = collect(DB::select(DB::raw($sql)))->toArray();

        return response()->json(['query' => $voipPie],200);
    }

    public function getFixedPiechart($id)
    {
        $cond = "WHERE lerg_category = 'FIXED' AND contact_list_id = '$id'";
        $sql = "SELECT COUNT(*) as total,lerg_company_name
            from contacts
            $cond
            GROUP BY lerg_company_name
        ";

        $fixedPie = collect(DB::select(DB::raw($sql)))->toArray();

        return response()->json(['query' => $fixedPie],200);
    }
}
