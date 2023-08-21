<?php
namespace App\Http\Controllers\Nova;

use Exception;
use App\Models\Email;
use Laravel\Nova\Nova;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\User;

class EmailController extends Controller
{
    public function uploadList(Request $request)
    {
        $ext = explode('.',$request->file->getClientOriginalName());
        if (end($ext) !== 'csv') {
            return response()->json([
                'success' => false,
                'message' => 'Please Upload Csv File Only',
            ], 200);
        }
        $user = Nova::user($request);
        $user_id = $user->id;
        $company_id = $user->company_id;

        try {
            $file = file($request->file);
            $fileRows = count($file);
            $file1 = fopen($request->file('file'), 'r');
            $csv = [];
            while (($result = fgetcsv($file1)) !== false) {
                $csv[] = $result[0];
            }

            $data = [];
            $dncNumberArray = [];
            for ($i = 0; $i < $fileRows; ++$i) {
                $raw_number = preg_replace('/[^0-9]/', '', $csv[$i]);
                if (strlen($raw_number) == 10 || strlen($raw_number) == 11) {
                    array_push($dncNumberArray, preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $csv[$i]));
                }
            }

            $uniqueNumberArray = array_unique($dncNumberArray);
            if ($uniqueNumberArray !== null) {
                foreach ($uniqueNumberArray as $num) {
                   // $formatNumber = formatNumber($num);
                   // if ($formatNumber) {
                   	 if (filter_var($num, \FILTER_VALIDATE_EMAIL)) {
                        $data[] = [
                            'email' => $num,
                            'raw_number' => $num,
                            'user_id' => $user_id,
                            'company_id' => $company_id,
                            'user_type' => $user->role,
                            'email_type' => 'csv',
                            'upload_type' => 'CSV Upload',
                            'created_at' => now()->toDateTimeString(),
                            'updated_at' => now()->toDateTimeString(),
                        ];
                    }
                }
            }
            unset($csv);
            $chunk_count = 500;

            if (count($data) > 0) {
                $chunks = array_chunk($data, $chunk_count);

                foreach ($chunks as $chunk) {
                    Email::insert($chunk);
                }
            }
            fclose($file1);

            unset($dncNumberArray);
            // return redirect()->back()->with('success','DNC List added Successfully.');
            return response()->json([
                'success' => true,
                'message' => 'Email List Added Successfully',
            ], 200);
        } catch (Exception $e) {
            // return redirect()->back()->with('error','DNC List adding failed');
            return response()->json([
                'message' => 'Email List Adding Failed',
                'excepton' => $e->getMessage(),
                'msg' => $e->getTrace(),
            ], 400);
        }
    }
}