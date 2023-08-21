<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MyNumber;
use App\Models\MyGroup;
use App\Models\SwNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MyNumberController extends Controller
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

    public function index(Request $request)
    {

        $client = MyNumber::query();
        $callzy = SwNumber::query();

        if ($request->client_search != null) {

            $clientSearch = $request->client_search;
            $client->where(function($query) use($clientSearch){
                $query->where('number', 'LIKE', "%{$clientSearch}%")
                    ->orWhere('raw_number', 'LIKE', "%{$clientSearch}%")
                    ->orWhere('forward_to_number', 'LIKE', "%{$clientSearch}%")
                    ->orWhere('raw_forward_to_number', 'LIKE', "%{$clientSearch}%")
                    ->orWhere('created_at', 'LIKE', "%{$clientSearch}%");
            });
        }
        if(auth()->user()->role == "company"){
            $clientNumbers =  $client->with('user')->Where('company_id', auth()->user()->company_id)->where('status', 'active')->where('type','ClientNumber')->orderBy('id','desc')->paginate(
                $perPage = 10, $columns = ['*'], $pageName = 'client'
            );
        }else{
            $clientNumbers =  $client->with('user')->Where('user_id', auth()->user()->id)->where('status', 'active')->where('type','ClientNumber')->orderBy('id','desc')->paginate(
                $perPage = 10, $columns = ['*'], $pageName = 'client'
            );
        }


        if ($request->callzy_search != null) {

            $callzySearch = $request->callzy_search;
            $callzy->where(function($query) use($callzySearch){
                $query->where('friendly_name', 'LIKE', "%{$callzySearch}%")
                    ->orWhere('phone_number', 'LIKE', "%{$callzySearch}%")
                    ->orWhere('created_at', 'LIKE', "%{$callzySearch}%");
            });
        }

        if(auth()->user()->role == "user"){
            $callzyNumbers =  $callzy->where('status', 'active')->orderBy('id','desc')->paginate(
                $perPage = 10, $columns = ['*'], $pageName = 'callzy'
            );
        }else{
            $callzyNumbers = $callzy->paginate();
        }

        return view('user.my_numbers.index', compact('callzyNumbers','clientNumbers'));
    }

    public function upload_newnumber(Request $request)
    {
        $request->validate([
            'new_number' => 'required |min:14|max:14',
        ]);

        $number = new MyNumber;
        $number->user_id = auth()->user()->id;
        $number->number = $request->new_number;
        $number->raw_number = preg_replace('/[^0-9]/', '', $request->new_number);
        $number->status = 'active';
        $number->type = 'uploaded';
        $number->company_id = auth()->user()->company_id;

        $number->save();

        return redirect()->route('user.my_numbers','search=')->with('success','New Number Uploaded Successfully.');
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

       dd($request->all());
    }

    public function search_newnumber(Request $request)
    {
        // dd($request->all());
        $filter = $request->filter;
        $value = $request->number;
        $clientAuthorization = 'Authorization: Basic NjNlZmUzYjUtMWQ0YS00Y2NiLWE1YmYtMTY4Y2Y5MTc2OTcyOlBUNmQ4ZWY3MTcxMTc0ODdhZmNjMGFkNDA2YmQ4YmFiZmZmMmI0YTRhNzU1OGI5OTIz';
        $adminAuthorization = 'Authorization: Basic MTgxMDgxYzItYjM3OC00NTNlLWFhYzMtNmZhODRiZmU5OTYxOlBUMjBkOTFlZTkxMmEyNzIzYWU2MTM2ODk2N2E4ZmQzMGUzY2RlZDQ1ZjIxNTdlZWU1';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://vultik.signalwire.com/api/relay/rest/phone_numbers/search?'.$filter.'='.$value,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                // 'Authorization: Basic MTgxMDgxYzItYjM3OC00NTNlLWFhYzMtNmZhODRiZmU5OTYxOlBUNjZmN2Q1NjlmMWY5ZDg5NzZhZjEwZGQ3YzQxOWMyMjQ0YzkzMGRmMjY3NDM1YjE0'
                auth()->user()->role =="user" ? $clientAuthorization : $adminAuthorization
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response);
        // dd($response->errors);
        if(isset($response->data)){
            $results = $response->data;
        }else{
            $results = [];
        }


        return view('user.my_numbers.results', compact('results', 'filter', 'value'));

        // return redirect()->back()->with('success','Working On This Feature.');
    }

    public function purchase_newnumber(Request $request)
    {

        // dd($request->forward_number);
        $clientAuthorization = 'Authorization: Basic NjNlZmUzYjUtMWQ0YS00Y2NiLWE1YmYtMTY4Y2Y5MTc2OTcyOlBUNmQ4ZWY3MTcxMTc0ODdhZmNjMGFkNDA2YmQ4YmFiZmZmMmI0YTRhNzU1OGI5OTIz';
        $adminAuthorization = 'Authorization: Basic MTgxMDgxYzItYjM3OC00NTNlLWFhYzMtNmZhODRiZmU5OTYxOlBUMjBkOTFlZTkxMmEyNzIzYWU2MTM2ODk2N2E4ZmQzMGUzY2RlZDQ1ZjIxNTdlZWU1';
        $numbers = $request->secret;
        $array = explode (",", $numbers);


        foreach ($array as $number) {

            $params['number'] = $number;
            $params['call_handler'] = "laml_webhooks";
            $params['call_request_url'] = auth()->user()->role =="user" ? "https://rvm.vultik.com/client-forward" : "https://rvm.vultik.com/signal-forward"; //client-forward
            $params['call_request_method'] = "POST";
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://vultik.signalwire.com/api/relay/rest/phone_numbers/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>json_encode($params),

            CURLOPT_HTTPHEADER => array(
                // 'Authorization: Basic MTgxMDgxYzItYjM3OC00NTNlLWFhYzMtNmZhODRiZmU5OTYxOlBUNjZmN2Q1NjlmMWY5ZDg5NzZhZjEwZGQ3YzQxOWMyMjQ0YzkzMGRmMjY3NDM1YjE0',
                auth()->user()->role =="user" ? $clientAuthorization : $adminAuthorization,
                'Content-Type: application/json'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $json_response = json_decode($response);
            // dd($response,$json_response->errors[0]->detail);
            if(auth()->user()->role =="user"){
                $my_number = new MyNumber;
                $my_number->user_id = auth()->user()->id;
                $my_number->number = $number;
                $my_number->status = "active";
                $my_number->type = auth()->user()->role =="user" ? "ClientNumber" : "CallzyOwned";
                $my_number->company_id = auth()->user()->company_id;
                $formatNumber = formatNumber($number);
                // $my_number->raw_number = preg_replace('/[^0-9]/', '', $number);
                $my_number->raw_number = $formatNumber;
                if ($request->forward_number) {
                    $my_number->forward_to_number = $request->forward_number;
                    $formatForwardNumber = formatNumber($request->forward_number);
                    // $raw_forward_number = preg_replace('/[^0-9]/', '', $request->forward_number);
                    // dd($raw_forward_number);
                    $my_number->raw_forward_to_number = $formatForwardNumber;
                }
                $my_number->purchase_response = json_encode($response);
                $my_number->purchase_response_id = $json_response->id;

                $my_number->save();

                if ($request->forward_number)
                {
                    $curl = curl_init();
                    $forward_params['name'] = $my_number->raw_number;
                    $forward_params['call_handler'] = "laml_webhooks";
                    $forward_params['call_request_url'] = "https://rvm.vultik.com/client-forward";
                    $forward_params['call_request_method'] = "POST";
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://vultik.signalwire.com/api/relay/rest/phone_numbers/'.$json_response->id,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'PUT',
                    CURLOPT_POSTFIELDS => json_encode($forward_params),
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        auth()->user()->role =="user" ? $clientAuthorization : $adminAuthorization,
                        // 'Authorization: Basic MTgxMDgxYzItYjM3OC00NTNlLWFhYzMtNmZhODRiZmU5OTYxOlBUZTUwMTE2MjE0MWU4MjlhZjIyNzQ1YTY3NTA1OWVhYTA3MTU3OGJhYzJjYzQyMjhk'
                    ),
                    ));

                    $response_update = curl_exec($curl);

                    curl_close($curl);
                }
            }else{
                if(isset($json_response->errors)){
                    return redirect()->route('admin.numbers','callzy_search=')->with('error',$json_response->errors[0]->detail);
                }else{
                    $sw_number = new SwNumber;
                    $sw_number->friendly_name = $number;
                    $sw_number->phone_number = $number;
                    $sw_number->purchase_response = json_encode($response);
                    $sw_number->purchase_response_id = $json_response->id;
                    $sw_number->status = "active";
                    $sw_number->save();
                }

            }


        }

        if(auth()->user()->role =="user"){
            return redirect()->route('user.my_numbers','client_search=')->with('success','New Number Purchased Successfully.');
        }else if(auth()->user()->role =="admin"){
            return redirect()->route('admin.numbers','callzy_search=')->with('success','New Number Purchased Successfully.');
        }

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
    public function destroy(Request $request,$id)
    {
        $clientAuthorization = 'Authorization: Basic NjNlZmUzYjUtMWQ0YS00Y2NiLWE1YmYtMTY4Y2Y5MTc2OTcyOlBUNmQ4ZWY3MTcxMTc0ODdhZmNjMGFkNDA2YmQ4YmFiZmZmMmI0YTRhNzU1OGI5OTIz';
        $adminAuthorization = 'Authorization: Basic MTgxMDgxYzItYjM3OC00NTNlLWFhYzMtNmZhODRiZmU5OTYxOlBUMjBkOTFlZTkxMmEyNzIzYWU2MTM2ODk2N2E4ZmQzMGUzY2RlZDQ1ZjIxNTdlZWU1';
        if(auth()->user()->role =="user"){
            $number=MyNumber::findOrFail($id);
        }else{
            $number=SwNumber::findOrFail($id);
        }

        if ($number->purchase_response_id != "") {
            $created_date = Carbon::parse($number->created_at)->format('Y-m-d');
            $release_date = Carbon::parse($created_date)->addDays(14)->format('Y-m-d');
            $current_date = Carbon::now()->format('Y-m-d');
            if ($current_date > $release_date) {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://vultik.signalwire.com/api/relay/rest/phone_numbers/'.$number->purchase_response_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'DELETE',
                CURLOPT_HTTPHEADER => array(
                    auth()->user()->role =="user" ? $clientAuthorization : $adminAuthorization,
                    // 'Authorization: Basic MTgxMDgxYzItYjM3OC00NTNlLWFhYzMtNmZhODRiZmU5OTYxOlBUNjZmN2Q1NjlmMWY5ZDg5NzZhZjEwZGQ3YzQxOWMyMjQ0YzkzMGRmMjY3NDM1YjE0'
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                if ($response == "") {
                    $number->status = 'deleted';
                    $number->save();

                    return redirect()->back()->with('success','Number deleted successfully');
                }
                else {
                    // return redirect()->back()->with('error',$response);
                }
            }else {
                return redirect()->back()->with('error','was purchased too recently to release. Please wait until '.Carbon::parse($release_date)->addDays(1)->format('Y-m-d').' to release this number, or contact Support for assistance');
            }

        }
        $number->status = 'deleted';
        $number->save();

        if(auth()->user()->role == "user"){
			$myNumberURL = 'user.my_numbers';
		}else if(auth()->user()->role == "admin"){
			$myNumberURL = 'admin.numbers';
		}

        if($request->exists('search')){
			return redirect()->route($myNumberURL,'search')->with('success','Number Deleted Successfully.');
		}elseif($request->exists('callzy_search')){
			return redirect()->route($myNumberURL,'callzy_search')->with('success','Number Deleted Successfully.');
		}
		else{
			return redirect()->back()->with('success','Number Deleted Successfully.');
		}
    }
}
