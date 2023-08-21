<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MyGroup;
use App\Models\MyNumber;
use App\Models\SwNumber;
use Exception;
use Illuminate\Http\Request;
use SignalWire\Rest\Client;
use Illuminate\Support\Facades\Auth;
class NumberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = MyNumber::query();

        // $callzy = MyNumber::query();
        $callzy = SwNumber::query();

        if ($request->search != null) {

            $numberSearch = $request->search;
            $q->where(function($query) use($numberSearch){
                $query->where('number', 'LIKE', "%{$numberSearch}%")
                    ->orWhere('raw_number', 'LIKE', "%{$numberSearch}%")
                    ->orWhere('forward_to_number', 'LIKE', "%{$numberSearch}%")
                    ->orWhere('raw_forward_to_number', 'LIKE', "%{$numberSearch}%")
                    ->orWhere('created_at', 'LIKE', "%{$numberSearch}%");
            });
        }
        $clientNumbers = $q->with('user')->where('status', 'active')->where('type','ClientNumber')->orderBy('id','desc')->paginate(10);
        if ($request->callzy_search != null) {


            $callzySearch = $request->callzy_search;
            $callzy->where(function($query) use($callzySearch){
                $query->where('friendly_name', 'LIKE', "%{$callzySearch}%")
                ->orWhere('phone_number', 'LIKE', "%{$callzySearch}%")
                ->orWhere('created_at', 'LIKE', "%{$callzySearch}%");
            });
        }

        $callzyNumbers =  $callzy->where('status', 'active')->orderBy('id','desc')->paginate(
            $perPage = 10, $columns = ['*'], $pageName = 'callzy'
        );
        // 'clientNumbers',
        return view('admin.numbers.index', compact('callzyNumbers','clientNumbers'));
    }
    public function sw_index(Request $request)
    {

        $q = SwNumber::query();

        if ($request->search != null) {

            $numberSearch = $request->search;
            $q->where(function($query) use($numberSearch){
                $query->where('phone_number', 'LIKE', "%{$numberSearch}%");
            });
        }
        $sw_numbers = $q->orderBy('id','desc')->paginate(10);

        return view('admin.numbers.sw_index',compact('sw_numbers'));
    }

    public function sw_search(Request $request){

        $sw_token_id = config('app.sw_admin_token_id');
        $sw_project_id = config('app.sw_admin_project_id');
        $sw_space_url = config('app.sw_admin_space_url');

        $filter = $request->filter;
        $value = $request->number;

        $client = new Client($sw_project_id, $sw_token_id, array("signalwireSpaceUrl" => $sw_space_url));
        $results = $client->availablePhoneNumbers('US')->local->read(
            array($filter => $value)
        );
        // dd(htmlentities($results[0]));
        return view('admin.numbers.sw_search', compact('results', 'filter', 'value'));
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
            $swNumberArray=[];
            for ($i=0; $i < $fileRows ; $i++) {
                $raw_number = preg_replace('/[^0-9]/', '', $csv[$i]);
                if(strlen($raw_number) == 10  || strlen($raw_number) == 11){
                    array_push($swNumberArray,preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $csv[$i]));

                }


            }

            $uniqueNumberArray = array_unique($swNumberArray);

            if($uniqueNumberArray !== null){
                foreach($uniqueNumberArray as $num){
                    $formatNumber = formatNumber($num);
                    $data[] = [
                        'friendly_name'=> $formatNumber ? $formatNumber : preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $num),
                        'phone_number'=> $formatNumber ? $formatNumber :  preg_replace('/[^0-9]/', '', $num),
                        'status' => 'active',
                        'created_at' => now()->toDateTimeString(),
                        'updated_at' => now()->toDateTimeString(),
                    ];


                }
            }//unique number if end
            unset($csv);
            // dd($data);
            $chunk_count = 500;
            if(count($data) > 0){
                $chunks = array_chunk($data, $chunk_count);

                foreach ($chunks as $chunk) {

                    SwNumber::insert($chunk);
                }
            }
            fclose($file1);
            unset($swNumberArray);
            return redirect()->route('admin.numbers','callzy_search=')->with('success','SW Number List added Successfully.');
        } catch(Exception $e){
            // dd($e->getMessage());
            return redirect()->back()->with('error','SW Number List adding failed');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
