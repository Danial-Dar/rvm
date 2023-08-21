<?php

namespace App\Http\Controllers\Nova\Company;

use App\Http\Controllers\Controller;
use App\Mail\LowBalanceMail;
use App\Models\Balance;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Laravel\Nova\Nova;

class CompanyController extends Controller
{
    public function index()
    {
        $query = Company::query();

        $user = Nova::user();
        if($user->role == 'user') {
            $query->where('id', $user->company_id);
        }

        return Response::json(['companies' => $query->get()], 200);
    }

    public function companyBalance(Request $request)
    {
        $balance = Balance::Where('company_id', $request->company_id)->sum('amount');

        return $balance;
    }


    public function lowBalanceMail(Request $request){
        $query = Company::query()->get();

        foreach ($query as $company) {

            $sumAmount = DB::table('companies')
                    ->join('balances', 'companies.id', '=', 'balances.company_id')
                    ->where('companies.id', $company->id)
                    ->sum('balances.amount');


            $emailAddressWithRoleUsers = DB::table('companies')
                    ->join('users', 'companies.id', '=', 'users.company_id')
                    ->where('companies.id', $company->id)
                    ->where('users.role', 'user')
                    ->select('users.email')
                    ->get();

            foreach ($emailAddressWithRoleUsers as $emailAddressWithRoleUser) {
                if ($sumAmount > 0 && $sumAmount < 1000) {
                    echo $company->id ."->". $sumAmount. "  ";
                    echo $emailAddressWithRoleUser->email;
                    echo "<br>";

                 Mail::to($emailAddressWithRoleUser->email)->send(new LowBalanceMail());
                }
            }
        }

        // return Response::json(['companies' => $test ], 200);
    }

}
