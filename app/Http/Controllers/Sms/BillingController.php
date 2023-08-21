<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\SmsBilling;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::get();
        $users = User::get();
        if(auth()->user()->role == "admin"){
            return view('sms.billing.index', compact('companies', 'users'));
        }else if(auth()->user()->role == "user"){
            return view('sms.billing.index');
        }else if(auth()->user()->role == "company"){
            return view('sms.billing.index');
        }
    }

    public function getBillingData(Request $request){
        $params = $request->all();
        $query = DB::table('sms_billings')->where('created_at','>=', Carbon::createFromFormat('Y-m-d', $params['start_date'])->startOfDay()->format('Y-m-d H:i:d'))->where('created_at', '<=', Carbon::createFromFormat('Y-m-d', $params['end_date'])->startOfDay()->format('Y-m-d H:i:d'));

        if(isset($params['company']) && !is_null($params['company'])) {
            return $query->where('company_id', $params['company'])->get();
        }

        $user = auth()->user();

        if($user->role == 'company') {
            $query->where('company_id', $user->company_id);
        }

        return $query->get();
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
