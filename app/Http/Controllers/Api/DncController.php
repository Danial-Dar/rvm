<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\UploadDncApi;
use App\Models\DNC;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DncController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dncs = DNC::Where('user_id', $user->id)->paginate(1000);
        return response(['Dncs' => $dncs]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required'
        ]);
        if ($validator->fails()) {
            return response(['Error' => $validator->messages()->first()]);
        }
        $raw_number = preg_replace('/[^0-9]/', '', $request->number);

        // dd('+'.$raw_number);

        if (strlen($raw_number) != 10 ) {
            return response(['Error' => "Number is invalid"]);
        }

        $user = Auth::user();

        $dnc = new DNC();
        $dnc->number = $request->number;
        $dnc->user_id = $user->id;
        $dnc->company_id = $user->company_id;
        $dnc->raw_number = '+'.$raw_number;
        $dnc->dnc_type = $user->role;
        $dnc->upload_type = 'Single Api';
        $dnc->save();

        return response(['Message' => 'Dnc Created Successfully', 'Dnc' => $dnc]);
    }

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

            UploadDncApi::dispatchAfterResponse($user->id, $user->company_id, $user->role, $numbers_array);

            return response()->json([
                'success' => true,
                'message' => 'Dnc Uploading Process Started.',
            ], 200);
        }
    }

    public function show($id)
    {
        $dnc = DNC::find($id);
        return response(['Dnc' => $dnc]);
    }

    public function destroy($id)
    {
        $dnc = DNC::find($id);
        $dnc->delete();
        return response(['Message' => "Dnc Deleted Successfully"]);
    }
}
