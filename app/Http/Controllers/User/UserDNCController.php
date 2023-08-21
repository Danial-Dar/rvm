<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DNC;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserDNC;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserDNCController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        if (!$company_id){
//            TODO! implement proper error handling.
            abort(403, 'Please define company of user.');
        }
        $q = DNC::query();
        if ($request->search != null) {
            $dncSearch = $request->search;
            $q->where(function($query) use($dncSearch){
                $query->where('number', 'LIKE', "%{$dncSearch}%")
                    ->orWhere('raw_number', 'LIKE', "%{$dncSearch}%");
                  
            });
            // $q->where('number', 'like','%' . $request->search. '%')->orwhere('raw_number', 'like','%' . $request->search. '%');
        }
//
//        $company = auth()->user()->company_id;
//        $company_users = User::where('company_id', $company)->get();
//        foreach ($company_users as $user) {
//            $user_id[] = $user->id;
//        }
        if(auth()->user()->role == "company"){
            $dnc_list = $q->Where('company_id', $company_id)->orderBy('id','desc')->paginate(10);
        }else{
            $dnc_list = $q->Where('user_id', $user_id)->Where('company_id', $company_id)->orderBy('id','desc')->paginate(10);
        }
        
        
        // $dnc_list = DNC::Where('company_id', $company_id)->paginate(20);

        // $user_id = auth()->user()->id;
        // $dnc_list = DNC::Where('user_id', $user_id)->paginate(20);

        return view('user.dnc.index', compact('dnc_list'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;


        $request->validate([
            'number' => 'required|min:14|max:14',
        ]);

        $formatNumber = formatNumber($request->number);

        // $raw_number = preg_replace('/[^0-9]/', '', $request->number);
        if($formatNumber){
            $dnc = new DNC;
            $dnc->number = $request->number;
            $dnc->user_id = $user_id;
            $dnc->company_id = $company_id;
            $dnc->user_type = auth()->user()->role;
            $dnc->raw_number = $formatNumber;
            $dnc->dnc_type = 'individual';
            $dnc->save();
        }
        
        return redirect()->back()->with('success','DNC Number Added Successfully.');

    }

    public function delete(Request $request)
    {
       	$dnc_id = $request->id;
        $dnc = DNC::find($dnc_id);
        $dnc->delete();

        return redirect()->back()->with('success','DNC Number deleted Successfully.');

    }

    public function show(Request $request){

    }

    public function uploadList(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;

        try
        {
            $file = file($request->file);
            $fileRows = count($file);

            $file1 = fopen($request->file('file'), 'r');
            $csv = array();
            while (($result = fgetcsv($file1)) !== false)
            {
                $csv[] = $result[0];
            }

            $data = [];
            // $failData = [];
            $dncNumberArray=[];
            for ($i=0; $i < $fileRows ; $i++) {
                $raw_number = preg_replace('/[^0-9]/', '', $csv[$i]);
                if(strlen($raw_number) == 10  || strlen($raw_number) == 11){
                    array_push($dncNumberArray,preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $csv[$i]));
                    // $data[] = [
                    //     'number'=> preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $csv[$i]),
                    //     'raw_number'=> $raw_number,
                    //     'user_id' => $user_id,
                    //     'company_id' => $company_id,
                    //     'user_type' => auth()->user()->role,
                    //     'created_at' => now()->toDateTimeString(),
                    //     'updated_at' => now()->toDateTimeString(),
                    // ];
                }
                // else{
                //     $failData[] = [
                //         'number'=> $csv[$i],
                //         'raw_number'=> $raw_number,
                //         'user_id' => $user_id,
                //         'company_id' => $company_id,
                //         'user_type' => auth()->user()->role,
                //         'created_at' => now()->toDateTimeString(),
                //         'updated_at' => now()->toDateTimeString(),
                //     ];
                // }
                
            }
            $uniqueNumberArray = array_unique($dncNumberArray);
            if($uniqueNumberArray !== null){
                foreach($uniqueNumberArray as $num){
                    $formatNumber = formatNumber($num);
                    if($formatNumber){
                        $data[] = [
                            'number'=> preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $num),
                            'raw_number'=> $formatNumber,
                            'user_id' => $user_id,
                            'company_id' => $company_id,
                            'user_type' => auth()->user()->role,
                            'dnc_type'=>  'csv',
                            'created_at' => now()->toDateTimeString(),
                            'updated_at' => now()->toDateTimeString(),
                        ];
                    }
                    
                }
            }//unique number if end
            unset($csv);
           
            $chunk_count = 500;
            if(count($data) > 0){
                $chunks = array_chunk($data, $chunk_count);
           
                foreach ($chunks as $chunk) {
                    
                    DNC::insert($chunk);
                }
            }
            fclose($file1);
            unset($dncNumberArray);
            return redirect()->back()->with('success','DNC List added Successfully.');
        } catch(Exception $e){
            // dd($e->getMessage());
            return redirect()->back()->with('error','DNC List adding failed');
        }
    }
}
