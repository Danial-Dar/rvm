<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $q = Invoice::query();
        $filters = [];

        if($request->invoice_number != null){
            $filters['invoice_number'] = $request->invoice_number;
            $q->ApplyFilters($filters);
        }
        if($request->status != null){
            $filters['status'] = $request->status;
            $q->ApplyFilters($filters);
        }
        if($user->role == "user"){
            $invoices = $q->with('user','company')->where('user_id',$user_id)->orderBy('id', 'desc')->PaginateData(10);
        }else if($user->role == "admin"){
            $invoices = $q->with('user','company')->orderBy('id', 'desc')->PaginateData(10);

        }else if($user->role == "company"){
            $invoices = $q->with('user','company')->where('company_id',$company_id)->orderBy('id', 'desc')->PaginateData(10);
        }

        $whereCC = '';
        $wherePH = '';
        if ($user->role == "user") {
            $whereCC = "AND cc.user_id = $user_id ";
            $wherePH = "AND mn.user_id = $user_id ";
        }else if($user->role == "company"){
            $whereCC = "AND cc.company_id = $company_id ";
            $wherePH = "AND mn.company_id = $company_id ";
        }
        $sql = "
(
    SELECT cc.updated_at::DATE,
           cc.user_id,
           cc.company_id,
           COUNT(*)                                AS quantity,
           UPPER(c.campaign_type)      AS type,
           c.name,
           us.value        AS company_unit_price,
           s.call_price    AS unit_price,
           SUM(price)      AS price
    FROM campaign_contacts cc
             LEFT JOIN campaigns c ON c.id = cc.campaign_id
             LEFT JOIN user_settings us ON cc.user_id = us.user_id AND us.key = (CONCAT(c.campaign_type, '_call_price'))
             LEFT JOIN api_settings s ON s.slug = c.campaign_type
    WHERE cc.status = 'initiated'
      AND cc.updated_at::DATE =  NOW()::DATE
      ".$whereCC."
    GROUP BY cc.updated_at::DATE, cc.user_id, cc.company_id, c.campaign_type, c.name, us.value, s.call_price
    ORDER BY cc.user_id, cc.company_id, type
)
UNION
(
    SELECT mn.created_at::DATE,
           mn.user_id,
           mn.company_id,
           COUNT(*)                                AS quantity,
           'PHONE'                                 AS type,
           'Number Purchase'                       AS name,
           NULL                                    AS company_unit_price,
           us.value::DECIMAL                       AS unit_price,
           (COUNT(*)::DECIMAL * us.value::DECIMAL) AS price
    FROM my_numbers mn
             LEFT JOIN company_settings us ON mn.company_id = us.company_id AND us.option = 'number_price'
    WHERE mn.created_at::DATE =  NOW()::DATE
    ".$wherePH."
    GROUP BY mn.created_at::DATE, mn.user_id, mn.company_id, us.value
    ORDER BY mn.user_id, mn.company_id, type
)
        ";
        $billableItems = DB::select(DB::raw($sql));

        return view('user.invoice.index', compact('invoices', 'billableItems'));
    }

    public function viewInvoice(Request $request){
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $invoice = Invoice::find($request->id)->with('user','company','items')->first();

        return view('user.invoice.view', compact('invoice'));
    }

    public function updateInvoice(Request $request){

    }
    public function deleteInvoice(Request $request){
        return redirect()->back()->with('success','invoice deleted successfully');
    }
}
