<?php

namespace App\Http\Controllers\Nova;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Nova;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function payment(Request $request)
    {
        $params = $request->json()->all();

        $balance = new Balance;
        if ($request->user_id) {
            $user = User::find($params['user_id']);
            $balance->user_id = $user->id;
            $balance->company_id = $user->company_id;
        }elseif ($request->company_id) {
            $user = Auth::user();
            $balance->user_id = $user->id;
            $balance->company_id = $params['company_id'];
        }
        $balance->amount = $params['amount'];
        $balance->type = 'PAYMENT';
        // $balance->description = 'Payment Added; Amount '.$params['amount'].'; Date: '.now();
        $balance->description = $params['payment_description'];
        // $balance->payment_description = $params['payment_description'];
        $balance->save();

        if ($user->balance >> -1000) {
            $user->low_balance_check = false;
            $user->save();
        }

        return response()->json(
            [
                'data' => ['message' => 'Payment Received Successfully.','success'=>true],
            ],200
        );

        // $params = $request->json()->all();

        // $curl = curl_init();


        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://secure.nmi.com/api/transact.php',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS => array(
        //         'security_key' => '6457Thfj624V5r7WUwc5v6a68Zsd6YEm',
        //         'ccnumber' => $params['card']['number'],
        //         'ccexp' => $params['card']['expiration'],
        //         'amount' => $params['amount'],
        //         'cvv' => $params['card']['cvc']
        //     ),
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);

        // $string = (string) $response;

        // $arrResponse = explode('&', $string, -1);

        // if ($arrResponse[1] == 'responsetext=SUCCESS') {
        //     $balance = new Balance;
        //     $user = Nova::user($request);
        //     $balance->user_id = $user->id;
        //     $balance->company_id = $user->company_id;
        //     $balance->amount = $params['amount'];
        //     $balance->type = 'PAYMENT';
        //     $balance->description = 'Payment Added; Amount '.$params['amount'].'; Date: '.now();
        //     $balance->save();

        //     return response()->json(
        //         [
        //             'data' => ['message' => 'Payment Received Successfully.','success'=>true],
        //         ],200
        //     );
        // }
        // else {
        //     return response()->json(
        //         [
        //             'data' => ['message' => 'Error In Payment Process.','success'=>false],
        //         ],500
        //     );
        // }


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
