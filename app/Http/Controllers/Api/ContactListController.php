<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\UploadContactListApi;
use App\Models\ContactList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactListController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $lists = ContactList::Where('user_id', $user->id)->get();
        return response(['Contact lists' => $lists]);
    }

    public function store(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'file' => 'required|mimes:csv,txt'
        ]);
        if ($validator->fails()) {
            return response(['Error' => $validator->messages()->first()]);
        }
        $user = Auth::user();
        $file = file($request->file('file'));

        $fileRows = count($file);

        $upload = $request->file('file');

        $filepath = $upload->getRealPath();

        $csv = [];
        $file1 = fopen($filepath, 'r');
        $csv = array_map('str_getcsv', file($upload));
        $header = array_shift($csv);

        $numbers_array = call_user_func_array("array_merge", $csv);

        $col = implode(',', $header);
        $pattern = '/(phone|cell|number|mobile|contact)/i';

        if (preg_match($pattern, strtolower($col)) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Please add a phone column to your CSV.',
            ], 400);
        } else {
            $list = new ContactList();
            $list->name = $request->name;
            $list->user_id = $user->id;
            $list->company_id = $user->company_id;
            $list->path = 'Api';
            $list->total_contacts = $fileRows - 1;
            $list->status = 'preprocessing';
            $list->save();

            $list_id = $list->id;

            $list->delete();

            UploadContactListApi::dispatchAfterResponse($user->id, $user->company_id, $list_id, $numbers_array);

            return response()->json([
                'success' => true,
                'message' => 'Contact List Uploading Process Started.',
            ], 200);
        }
    }

    public function show($id)
    {
        $list = ContactList::find($id);
        return response(['Contact List' => $list]);
    }

    public function destroy($id)
    {
        $list = ContactList::find($id);
        $list->delete();
        return response(['Message' => "Contact List Deleted Successfully"]);
    }

    public function upload(Request $request)
    {
        return $request->all();
    }

}
