<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmsBillingController extends Controller
{
    public function index()
    {
        return view('user.sms.billing.index');
    }

    public function getBillingData(Request $request){

        $user = auth()->user();
        $params = $request->all();
        $query = DB::table('sms_billings')->where('created_at','>=', Carbon::createFromFormat('Y-m-d', $params['start_date'])->startOfDay()->format('Y-m-d H:i:d'))->where('created_at', '<=', Carbon::createFromFormat('Y-m-d', $params['end_date'])->startOfDay()->format('Y-m-d H:i:d'));

        if($user->role == 'company') {
            $query = $query->where('company_id', $user->company_id);
        }
        if($user->role == 'user') {
            $query = $query->where('user_id', $user->id);
        }
        return $query->get();
    }
}
