<?php

namespace App\Http\Controllers\Nova\Billing;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Laravel\Nova\Nova;

class BillingController extends Controller
{
    public function getBalances(Request $request)
    {
        $query = Balance::query();

        $user = Nova::user();

        if($user->role == 'user') {
            $query->where('user_id', $user->id);
        }

        if(!is_null($request->company_id)) {
            $query->where('company_id', $request->company_id);
        }

        $from = Carbon::parse($request->from_date);
        $to = Carbon::parse($request->to_date);
        if(!is_null($request->from_date) && !is_null($request->to_date)) {
            // $query->where('created_at', '>=', Carbon::parse($request->from_date));
            // $query->where('created_at', '<=', Carbon::parse($request->to_date));
            $query->whereBetween('balances.created_at', [$from,$to]);
        }


        $query->with(['user', 'company']);

        return $query->paginate(25);
    }
    public function getvaluesByTypes(Request $request)
    {
        $query = DB::table('balances')->select(DB::raw('sum(amount) as amount, sum(quantity) as quantity, type'))->groupBy('type');

        $user = Nova::user();

        if($user->role == 'user') {
            $query->where('user_id', $user->id);
        }

        if(!is_null($request->company_id)) {
            $query->where('company_id', $request->company_id);
        }
        $from = Carbon::parse($request->from_date);
        $to = Carbon::parse($request->to_date);
        if(!is_null($request->from_date) && !is_null($request->to_date)) {
            // $query->where('created_at', '>=', Carbon::parse($request->from_date));
            // $query->where('created_at', '<=', Carbon::parse($request->to_date));
            $query->whereBetween('balances.created_at', [$from,$to]);
        }

        $query = $query->get();

        $total_amount = number_format($query->sum('amount'), 2);

        $total_quantity = number_format($query->sum('quantity'));

        $query = $query->map(function($item, $key) {
            return ['amount' => '$'.number_format($item->amount, 2), 'quantity' => number_format($item->quantity), 'type' => $item->type];
        });

        $query = $query->push(['amount' => '$'.$total_amount, 'quantity' => $total_quantity, 'type' => 'Total']);

        return Response::json(['value_by_type' => $query], 200);
    }

    public function getValuesByMainTypes(Request $request)
    {
        $query = DB::table('balances')->select(DB::raw('sum(amount) as amount, count(campaign_id) as quantity, main_type'))->groupBy('main_type');

        $user = Nova::user();

        if($user->role == 'user') {
            $query->where('user_id', $user->id);
        }

        if(!is_null($request->company_id)) {
            $query->where('company_id', $request->id);
        }

        if(!is_null($request->company_id)) {
            $query->where('company_id', $request->company_id);
        }
        $from =  Carbon::parse($request->from_date);
        $to = Carbon::parse($request->to_date);
        if(!is_null($request->from_date) && !is_null($request->to_date)) {
            // $query->where('created_at', '>=', Carbon::parse($request->from_date));
            // $query->where('created_at', '<=', Carbon::parse($request->to_date));
            $query->whereBetween('balances.created_at', [$from,$to]);
        }

        $query = $query->get();

        $total_amount = number_format($query->sum('amount'), 2);

        $total_quantity = number_format($query->sum('quantity'));

        $query = $query->map(function($item, $key) {
            return ['amount' => '$'.number_format($item->amount, 2), 'quantity' => number_format($item->quantity), 'main_type' => $item->main_type];
        });

        $query = $query->push(['amount' => '$'.$total_amount, 'quantity' => $total_quantity, 'main_type' => 'Total']);

        return Response::json(['value_by_main_type' => $query], 200);
    }

    public function getValuesByCampaignId(Request $request){
        $query = Balance::query();

        $user = Nova::user();

        if($user->role == 'user') {
            $query->where('campaigns.user_id', $user->id);
        }

        if(isset($request->company_id) && !is_null($request->company_id)) {
            $query->where('balances.company_id', $request->company_id);
        }

        // if(!is_null($request->company_id)) {
        //     $query->where('company_id', $request->company_id);
        // }

        if(isset($request->from_date) && !is_null($request->from_date)  && isset($request->to_date) && !is_null($request->to_date)) {
            // $query->where('balances.created_at', '>=', Carbon::parse($request->from_date));
            // $query->where('balances.created_at', '<=', Carbon::parse($request->to_date));
            $from = Carbon::parse($request->from_date);
            $to =Carbon::parse($request->to_date);
            $query->whereBetween('balances.created_at', [$from,$to]);
        }
        $query = $query->join('campaigns', 'balances.campaign_id', '=', 'campaigns.id');
        $query = $query ->select(DB::raw("sum(balances.amount) as amount, campaigns.name as campaign_name,campaigns.campaign_type as campaign_type, TRIM(TO_CHAR(balances.created_at, 'MM/DD/YYYY')) as date"));
        $query = $query->groupBy('campaigns.id',"date");
        $query = $query->paginate(25);

        // $total_amount = number_format($query->sum('amount'), 2);

        // $total_quantity = number_format($query->sum('quantity'));

        // $query = $query->map(function($item, $key) {
        //     return ['amount' => number_format($item->amount, 2), 'quantity' => number_format($item->quantity), 'main_type' => $item->main_type];
        // });

        // $query = $query->push(['amount' => $total_amount]);

        return Response::json(['value_by_campaign_id' => $query], 200);
    }



    public function payments(Request $request)
    {
        $query = Balance::query();

        $user = Nova::user();

        if($user->role == 'user') {
            $query->where('company_id', $user->company_id);
        }

        if(!is_null($request->company_id)) {
            $query->where('company_id', $request->company_id);
        }

        $from = Carbon::parse($request->from_date);
        $to = Carbon::parse($request->to_date);
        if(!is_null($request->from_date) && !is_null($request->to_date)) {
            // $query->where('created_at', '>=', Carbon::parse($request->from_date));
            // $query->where('created_at', '<=', Carbon::parse($request->to_date));
            $query->whereBetween('balances.created_at', [$from,$to]);
        }


        $query->where('type', 'PAYMENT');

        $query->with(['user', 'company']);

        $query->orderBy('id', 'DESC');


        return $query->get();
    }

    public function getPaymentGroupedByDate(Request $request) {
        // payments group by date
        $query = Balance::query();

        $query ->select(DB::raw("sum(balances.amount) as total, TRIM(TO_CHAR(balances.created_at, 'MM/DD/YYYY')) as date"));

        $query->groupBy('date');

        $query->where('type', 'PAYMENT');

        $start = $request->from_date !== null ? Carbon::parse($request->from_date): '';
        $end = $request->to_date !== null ? Carbon::parse($request->to_date): '';

        if($start == '' && $end == '') {
            $query->where('created_at', '>', now()->subDays(35)->endOfDay());
        } else {
            $query->where('created_at', '>', $start->format('Y-m-d H:i:s'))->where('created_at', '<', $end->format('Y-m-d H:i:s'));
        }

        $user = Nova::user();

        if($user->role == 'user') {
            $query->where('user_id', $user->id);
        }

        if(isset($request->company_id) && !is_null($request->company_id)) {
            $query->where('balances.company_id', $request->company_id);
        }

        return Response::json(['payment_grouped_by_date' => $query->get()->toArray()], 200) ;
    }

    public function getUsageGroupedByDate(Request $request) {
        // usage group by date

        $query = Balance::query();

        $start = $request->from_date !== null ? Carbon::parse($request->from_date): '';
        $end = $request->to_date !== null ? Carbon::parse($request->to_date): '';

        $query ->select(DB::raw("sum(-1 * balances.amount) as total, TRIM(TO_CHAR(balances.created_at, 'MM/DD/YYYY')) as date"));

        $query->groupBy('date');

        $query->whereRaw("type != 'PAYMENT'");

        $query->where('balances.amount', '<', '0');

        if($start == '' && $end == '') {
            $query->where('created_at', '>', now()->subDays(35)->endOfDay());
        } else {
            $query->where('created_at', '>', $start->format('Y-m-d H:i:s'))->where('created_at', '<', $end->format('Y-m-d H:i:s'));
        }

        $user = Nova::user();

        if($user->role == 'user') {
            $query->where('user_id', $user->id);
        }

        if(isset($request->company_id) && !is_null($request->company_id)) {
            $query->where('balances.company_id', $request->company_id);
        }

        return Response::json(['usage_grouped_by_date' => $query->get()->toArray()], 200) ;
    }
}
