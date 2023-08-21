<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Company;
use App\Models\Setting;
use App\Models\Campaign;
use App\Models\ContactList;
use Illuminate\Http\Request;
use App\Models\CampaignContact;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BillingController extends Controller
{
    public function index()
    {
        $companies = Company::get();
        $users = User::get();
        if (auth()->user()->role == 'admin') {
            return view('admin.billing.index', compact('companies', 'users'));
        } elseif (auth()->user()->role == 'user') {
            return view('user.billing.index');
        } elseif (auth()->user()->role == 'company') {
            return view('company.billing.index');
        }
    }

    public function all_company(Request $request)
    {
        $companies = Company::all();
        foreach ($companies as $company) {
            $company['sum'] = CampaignContact::Where('company_id', $company->id)->sum('price');

            $company['rvm_sum'] = CampaignContact::with('campaign')->WhereHas('campaign', function ($query) {
                $query->where('campaign_type', 'rvm');
            })->Where('company_id', $company->id)->sum('price');

            $company['bot_sum'] = CampaignContact::with('campaign')->WhereHas('campaign', function ($query) {
                $query->where('campaign_type', 'bot');
            })->Where('company_id', $company->id)->sum('price');

            $company['press_sum'] = CampaignContact::with('campaign')->WhereHas('campaign', function ($query) {
                $query->where('campaign_type', 'press-1');
            })->Where('company_id', $company->id)->sum('price');
        }

        return $companies;
    }

    public function getBillingData(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $userConditionCC = '';
        $userConditionMN = '';
        $userConditionICL = '';
        $compConditionCC = '';
        $compConditionMN = '';
        $compConditionICL = '';

        if (auth()->user()->role == 'admin') {
            $company = $request->company;
            if ($company !== null) {
                $compConditionCC = $company !== 'all' ? "AND cc.company_id = $company" : '';
                $compConditionMN = $company !== 'all' ? "AND mn.company_id = $company" : '';
                $compConditionICL = $company !== 'all' ? "AND icl.company_id = $company" : '';
            }
        } elseif (auth()->user()->role == 'user') {
            $compId = auth()->user()->company_id;
            $userId = auth()->user()->id;

            $compConditionCC = "AND cc.company_id = $compId";
            $compConditionMN = "AND mn.company_id::INT = $compId";
            $compConditionICL = "AND icl.company_id = $compId";
            $userConditionCC = "AND cc.user_id = $userId";
            $userConditionMN = "AND mn.user_id::INT = $userId";
            $userConditionICL = "AND icl.user_id = $userId";
        } elseif (auth()->user()->role == 'company') {
            $compId = auth()->user()->company_id;
            $compConditionCC = "AND cc.company_id = $compId";
            $compConditionMN = "AND mn.company_id = $compId";
            $compConditionICL = "AND icl.company_id = $compId";
        }
        // $userId = $request->user_id;
        // $users = collect();
        // if($company != "all"){
        //     $users = User::Where('company_id', $company)->get();
        // }

        // if($userId !== null){
        //     $userConditionCC = $userId !== 'all' ? "AND cc.user_id = $userId" : '';
        //     $userConditionMN = $userId !== 'all' ? "AND mn.user_id = $userId" : '';
        //     $userConditionICL = $userId !== 'all' ? "AND icl.user_id = $userId" : '';
        // }
        // $userConditionCC
        // $userConditionMN
        // $userConditionICL
        // $sql = sprintf("
        // (
        //     SELECT -- cc.updated_at::DATE,
        //         cc.user_id,
        //         (CONCAT(MAX(u.first_name), MAX(u.last_name))) AS user_name,
        //         MAX(comp.name) AS company_name,
        //         cc.company_id,
        //         COUNT(*)                                AS quantity,
        //         UPPER(c.campaign_type) AS type,
        //         MAX(c.name)   AS name,
        //        MAX(us.value::DECIMAL)        AS unit_price,
        //        SUM(price)::DECIMAL      AS price
        //     FROM campaign_contacts cc
        //             LEFT JOIN campaigns c ON c.id = cc.campaign_id
        //             LEFT JOIN users u ON u.id = cc.user_id
        //             LEFT JOIN companies comp ON comp.id = cc.company_id
        //             LEFT JOIN company_settings us ON cc.company_id = us.company_id AND us.key = (CONCAT(c.campaign_type, '_call_price'))
        //             LEFT JOIN api_settings s ON s.slug = c.campaign_type
        //     WHERE cc.status = 'initiated'
        //     $compConditionCC
        //     $userConditionCC
        //     AND cc.updated_at::DATE BETWEEN '$startDate'::DATE AND '$endDate'::DATE
        //     GROUP BY cc.user_id, cc.company_id,c.id, c.campaign_type
        //     ORDER BY cc.user_id, cc.company_id, type
        // )
        // UNION
        // (
        //     SELECT -- mn.created_at::DATE,
        //         mn.user_id,
        //         (CONCAT(MAX(u.first_name), MAX(u.last_name))) AS user_name,
        //         MAX(comp.name) AS company_name,
        //         mn.company_id,
        //         COUNT(*)                                AS quantity,
        //         'PHONE'                                 AS type,
        //         'Number Purchase'                       AS name,
        //         MAX(us.value::DECIMAL)                       AS unit_price,
        //         (COUNT(*)::DECIMAL * MAX(us.value::DECIMAL))::DECIMAL AS price
        //     FROM my_numbers mn
        //             LEFT JOIN company_settings us ON mn.company_id = us.company_id AND us.key = 'number_price'
        //             LEFT JOIN users u ON u.id = mn.user_id
        //             LEFT JOIN companies comp ON comp.id = mn.company_id
        //     WHERE mn.created_at::DATE BETWEEN '$startDate'::DATE AND '$endDate'::DATE
        //     $compConditionMN
        //     $userConditionMN
        //     GROUP BY mn.user_id, mn.company_id
        //     ORDER BY mn.user_id, mn.company_id, type
        // )
        // UNION
        // (
        //     SELECT -- icl.created_at::DATE,
        //            icl.user_id,
        //            (CONCAT(MAX(u.first_name), MAX(u.last_name))) AS user_name,
        //         MAX(comp.name) AS company_name,
        //            icl.company_id,
        //            COUNT(*)                                AS quantity,
        //            'INCOMING'                              AS type,
        //            'Incoming Call Price'                   AS name,
        //            MAX(us.value::DECIMAL)                      AS unit_price,
        //            SUM(icl.call_price::DECIMAL)                          AS price
        //     FROM incoming_call_logs icl
        //         LEFT JOIN company_settings us ON icl.company_id = us.company_id AND us.key = 'per_minute_call_price'
        //         LEFT JOIN users u ON u.id = icl.user_id
        //         LEFT JOIN companies comp ON comp.id = icl.company_id
        //     WHERE icl.created_at::DATE BETWEEN '$startDate'::DATE AND '$endDate'::DATE
        //     $compConditionICL
        //     $userConditionICL
        //     AND icl.user_id IS NOT NULL
        //     GROUP BY icl.user_id, icl.company_id
        //     ORDER BY icl.user_id, icl.company_id, type
        // )

        // ");
//         return $sql;

        $sql = sprintf("
        (
            SELECT -- cc.updated_at::DATE,
                cc.user_id::INT,
                (CONCAT(MAX(u.first_name), MAX(u.last_name))) AS user_name,
                MAX(comp.name) AS company_name,
                cc.company_id::INT,
                COUNT(*)                                AS quantity,
                UPPER(c.campaign_type) AS type,
                MAX(c.name)   AS name,
               MAX(us.value::DECIMAL)        AS unit_price,
               SUM(price)::DECIMAL      AS price
            FROM campaign_contacts cc
                    LEFT JOIN campaigns c ON c.id = cc.campaign_id::INT
                    LEFT JOIN users u ON u.id = cc.user_id::INT
                    LEFT JOIN companies comp ON comp.id = cc.company_id::INT
                    LEFT JOIN company_settings us ON cc.company_id::INT = us.company_id::INT AND us.key = (CONCAT(c.campaign_type, '_call_price'))
                    LEFT JOIN api_settings s ON s.slug = c.campaign_type
            WHERE cc.status = 'initiated'
            $compConditionCC
            $userConditionCC
            AND cc.updated_at::DATE BETWEEN '$startDate'::DATE AND '$endDate'::DATE
            GROUP BY cc.user_id, cc.company_id,c.id, c.campaign_type
            ORDER BY cc.user_id, cc.company_id, type
        )
        UNION
        (
            SELECT -- mn.created_at::DATE,
                mn.user_id::INT,
                (CONCAT(MAX(u.first_name), MAX(u.last_name))) AS user_name,
                MAX(comp.name) AS company_name,
                mn.company_id::INT,
                COUNT(*)                                AS quantity,
                'PHONE'                                 AS type,
                'Number Purchase'                       AS name,
                MAX(us.value::DECIMAL)                       AS unit_price,
                (COUNT(*)::DECIMAL * MAX(us.value::DECIMAL))::DECIMAL AS price
            FROM my_numbers mn
                    LEFT JOIN company_settings us ON mn.company_id::INT = us.company_id::INT AND us.key = 'number_price'
                    LEFT JOIN users u ON u.id = mn.user_id::INT
                    LEFT JOIN companies comp ON comp.id = mn.company_id::INT
            WHERE mn.created_at::DATE BETWEEN '$startDate'::DATE AND '$endDate'::DATE
            $compConditionMN
            $userConditionMN
            GROUP BY mn.user_id, mn.company_id
            ORDER BY mn.user_id, mn.company_id, type
        )
        UNION
        (
            SELECT -- icl.created_at::DATE,
                   icl.user_id::INT,
                   (CONCAT(MAX(u.first_name), MAX(u.last_name))) AS user_name,
                MAX(comp.name) AS company_name,
                   icl.company_id::INT,
                   COUNT(*)                                AS quantity,
                   'INCOMING'                              AS type,
                   'Incoming Call Price'                   AS name,
                   MAX(us.value::DECIMAL)                      AS unit_price,
                   SUM(icl.call_price::DECIMAL)                          AS price
            FROM incoming_call_logs icl
                LEFT JOIN company_settings us ON icl.company_id::INT = us.company_id::INT AND us.key = 'per_minute_call_price'
                LEFT JOIN users u ON u.id = icl.user_id::INT
                LEFT JOIN companies comp ON comp.id = icl.company_id::INT
            WHERE icl.created_at::DATE BETWEEN '$startDate'::DATE AND '$endDate'::DATE
            $compConditionICL
            $userConditionICL
            AND icl.user_id IS NOT NULL
            GROUP BY icl.user_id, icl.company_id
            ORDER BY icl.user_id, icl.company_id, type
        )
        ");

        $billableItems = DB::select(DB::raw($sql));
        // dd($billableItems);
        // callerid billing
        $company = $request->company;
        $contact_lists = [];

        $settingPricePerNumberCheck = Setting::where('type', 'reputation')->firstWhere('key', 'price_per_number');
        $pricePerCheck = $settingPricePerNumberCheck ? $settingPricePerNumberCheck->value : '0.5';

        if (auth()->user()->role == 'admin') {
            $contact_lists = ContactList::with([
                'contacts'
                // =>function($query) use ($startDate, $endDate){
                //     $query->select(['reputation_date','number','created_at']);
                //     if ($startDate && $endDate) {
                //         $query->whereBetween('reputation_date', [$startDate, $endDate]);
                //     }

                //     return $query;
                // },
                ,
                'company'
                // =>function($query) use  ($company){
                //     $query->select(['name']);
                //     if ($company != 'all' && $company) {
                //         $query->where('company_id', $company);
                //     }
                //     return $query;
                // }

                ])
            ->withCount('contacts')
            ->whereIn('reputation_check_status', ['inprocess', 'failed', 'complete'])
            ->whereHas('contacts', function ($query) use ($startDate, $endDate) {
                // dd($startDate, $endDate, $company);

                if ($startDate && $endDate) {
                    $query->whereBetween('reputation_date', [$startDate, $endDate]);
                }

                return $query;
            })->whereHas('company',function($query) use ($company) {
                if ($company != 'all' && $company) {
                    $query->where('company_id', $company);
                }
                return $query;
            })
            ->get();
        } elseif (auth()->user()->role == 'user') {
            $compId = auth()->user()->company_id;
            $userId = auth()->user()->id;

            $contact_lists = ContactList::with(['contacts', 'company'])
            ->withCount('contacts')
            // ->whereIn('reputation_check_status', ['inprocess', 'failed', 'complete'])
            ->whereHas('contacts', function ($query) use ($startDate, $endDate, $compId) {
                $query->where('company_id', $compId);
                if ($startDate && $endDate) {
                    $query->whereBetween('reputation_date', [$startDate, $endDate]);
                }

                return $query;
            })->get();
        } elseif (auth()->user()->role == 'company') {
            $compId = auth()->user()->company_id;
            $contact_lists = ContactList::with(['contacts', 'company'])
            ->withCount('contacts')
            // ->whereIn('reputation_check_status', ['inprocess', 'failed', 'complete'])
            ->whereHas('contacts', function ($query) use ($startDate, $endDate, $compId) {
                $query->where('company_id', $compId);
                if ($startDate && $endDate) {
                    $query->whereBetween('reputation_date', [$startDate, $endDate]);
                }

                return $query;
            })->get();
        }

        // ,'users'=>$users
        return response()->json(['billing' => $billableItems, 'callerid_billing' => ['list' => $contact_lists, 'rate' => $pricePerCheck]]);
    }

    public function specific_company($id)
    {
        $users = User::Where('company_id', $id)->get();

        return $users;
    }

    public function all_user($id)
    {
        $users = User::Where('company_id', $id)->get();
        foreach ($users as $user) {
            $user['sum'] = CampaignContact::Where('user_id', $user->id)->sum('price');

            $user['rvm_sum'] = CampaignContact::with('campaign')->WhereHas('campaign', function ($query) {
                $query->where('campaign_type', 'rvm');
            })->Where('user_id', $user->id)->sum('price');

            $user['bot_sum'] = CampaignContact::with('campaign')->WhereHas('campaign', function ($query) {
                $query->where('campaign_type', 'bot');
            })->Where('user_id', $user->id)->sum('price');

            $user['press_sum'] = CampaignContact::with('campaign')->WhereHas('campaign', function ($query) {
                $query->where('campaign_type', 'press-1');
            })->Where('user_id', $user->id)->sum('price');
        }

        // $users = User::Where('company_id', $id)
        //     ->withSum('campaign_contacts as rvm_sum', 'price' )->WhereHas('campaign_contacts', function ($query) {
        //         $query->with('campaign')->where('price', '!=', null)->WhereHas('campaign', function ($query) {
        //                     $query->where('campaign_type', 'rvm');
        //                     });
        //         })
        //     ->withSum('campaign_contacts as bot_sum', 'price' )->WhereHas('campaign_contacts', function ($query) {
        //         $query->with('campaign')->where('price', '!=', null)->WhereHas('campaign', function ($query) {
        //                     $query->where('campaign_type', 'bot');
        //                     });
        //         })
        //     ->get();
        // dd($users);
        return $users;
    }

    public function specific_user($id)
    {
        //------------------previous query----------------
        // $campaigns = Campaign::Where('user_id', $id)->get();

        // foreach ($campaigns as $campaign) {
        //     $campaign['sum'] = CampaignContact::Where('campaign_id', $campaign->id)->sum('price');
        // }

        //-------------------optimized query--------------
        $campaigns = Campaign::withSum('campaignContacts as sum', 'price')->WhereHas('campaignContacts', function ($query) {
            $query->where('price', '!=', null);
        })->Where('user_id', $id)->get();

        return $campaigns;
    }
}
