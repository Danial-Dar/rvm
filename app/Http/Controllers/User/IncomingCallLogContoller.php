<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\IncomingCallLog;
class IncomingCallLogContoller extends Controller
{
    public function index(Request $request){
        return view('user.incoming_call_log.index');
    }

    public function getIncomingCallLog(Request $request){

        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $q = IncomingCallLog::query();

        if($user->role == "user"){
            $q->where('user_id',$user_id)->where('company_id',$company_id);
        }else if($user->role == "company"){
            $q->where('company_id',$company_id);
        }
        $filterTypes = ['contains','notContains','equals','notEqual','startsWith','endsWith','blank','notBlank'];
        $filter = json_decode($request->data['filter'],true);

        if($filter !== null && count($filter)  > 0){
            foreach ($filter as $key => $value) {
                $keyName = $value['name'];
                $keySearch = $value['search'];
                $dateTo = isset($value['dateTo']) ? $value['dateTo'] : null;
                $keyType = $value['type'];
                if($keyName == "company"){
                    if($keyType == "contains"){
                        $q->whereHas('company', function ($query) use($keySearch) {
                            // $query->where('name', 'LIKE', "%{$keySearch}%");
                            $query->whereRaw('LOWER(name) LIKE ? ',['%'.trim(strtolower($keySearch)).'%']);
                       });
                    }else if($keyType == "notContains"){
                        $q->whereHas('company', function ($query) use($keySearch) {
                            $query->whereRaw('LOWER(name) NOT LIKE ? ',['%'.trim(strtolower($keySearch)).'%']);
                       });
                        
                    }else if($keyType == "equals"){
                        $q->whereHas('company', function ($query) use($keySearch) {
                            $query->where(\DB::raw('LOWER(name)'),$keySearch);
                       });
                        
                    }else if($keyType == "notEqual"){
                        $q->whereHas('company', function ($query) use($keySearch) {
                            $query->where(\DB::raw('LOWER(name)'),'!=',$keySearch);
                       });
                        
                    }else if($keyType == "startsWith"){
                        $q->whereHas('company', function ($query) use($keySearch) {
                            $query->whereRaw('LOWER(name) LIKE ? ',[trim(strtolower($keySearch)).'%']);
                       });
                        
                    }else if($keyType == "endsWith"){
                        $q->whereHas('company', function ($query) use($keySearch) {
                            $query->whereRaw('LOWER(name) LIKE ? ',['%'.trim(strtolower($keySearch))]);
                       });
                        
                    }
                }//check company filter

                if($keyName == "user"){
                    if($keyType == "contains"){
                        $q->whereHas('user', function ($query) use($keySearch) {
                            // $query->where('first_name', 'LIKE', "%{$keySearch}%");
                            $query->whereRaw('LOWER(first_name) LIKE ? ',['%'.trim(strtolower($keySearch)).'%']);
                        });
                    }else if($keyType == "notContains"){
                        $q->whereHas('user', function ($query) use($keySearch) {
                            $query->whereRaw('LOWER(first_name) NOT LIKE ? ',['%'.trim(strtolower($keySearch)).'%']);
                        });
                        
                    }else if($keyType == "equals"){
                        $q->whereHas('user', function ($query) use($keySearch) {
                            $query->where(\DB::raw('LOWER(first_name)'),$keySearch);
                       });
                        
                    }else if($keyType == "notEqual"){
                        $q->whereHas('user', function ($query) use($keySearch) {
                            $query->where(\DB::raw('LOWER(first_name)'),'!=',$keySearch);
                       });
                        
                    }else if($keyType == "startsWith"){
                        $q->whereHas('user', function ($query) use($keySearch) {
                            $query->whereRaw('LOWER(first_name) LIKE ? ',[trim(strtolower($keySearch)).'%']);
                       });
                        
                    }else if($keyType == "endsWith"){
                        $q->whereHas('user', function ($query) use($keySearch) {
                            $query->whereRaw('LOWER(first_name) LIKE ? ',['%'.trim(strtolower($keySearch))]);
                       });
                        
                    }
                }//check user filter

                if($keyName == "campaign"){
                    if($keyType == "contains"){
                        $q->whereHas('campaign', function ($query) use($keySearch) {
                            $query->whereRaw('LOWER(name) LIKE ? ',['%'.trim(strtolower($keySearch)).'%']);
                        });
                    }else if($keyType == "notContains"){
                        $q->whereHas('campaign', function ($query) use($keySearch) {
                            $query->whereRaw('LOWER(name) NOT LIKE ? ',['%'.trim(strtolower($keySearch)).'%']);
                        });
                        
                    }else if($keyType == "equals"){
                        $q->whereHas('campaign', function ($query) use($keySearch) {
                            $query->where(\DB::raw('LOWER(name)'),$keySearch);
                       });
                        
                    }else if($keyType == "notEqual"){
                        $q->whereHas('campaign', function ($query) use($keySearch) {
                            $query->where(\DB::raw('LOWER(name)'),'!=',$keySearch);
                       });
                        
                    }else if($keyType == "startsWith"){
                        $q->whereHas('campaign', function ($query) use($keySearch) {
                            $query->whereRaw('LOWER(name) LIKE ? ',[trim(strtolower($keySearch)).'%']);
                       });
                        
                    }else if($keyType == "endsWith"){
                        $q->whereHas('campaign', function ($query) use($keySearch) {
                            $query->whereRaw('LOWER(name) LIKE ? ',['%'.trim(strtolower($keySearch))]);
                       });
                        
                    }
                }//check campaign filter

                if($keyName == "type"){
                    if($keyType == "contains"){
                        $q->whereHas('campaign', function ($query) use($keySearch) {
                            $query->whereRaw('LOWER(campaign_type) LIKE ? ',['%'.trim(strtolower($keySearch)).'%']);
                        });
                    }else if($keyType == "notContains"){
                        $q->whereHas('campaign', function ($query) use($keySearch) {
                            $query->whereRaw('LOWER(campaign_type) NOT LIKE ? ',['%'.trim(strtolower($keySearch)).'%']);
                        });
                        
                    }else if($keyType == "equals"){
                        $q->whereHas('campaign', function ($query) use($keySearch) {
                            $query->where(\DB::raw('LOWER(campaign_type)'),$keySearch);
                       });
                        
                    }else if($keyType == "notEqual"){
                        $q->whereHas('campaign', function ($query) use($keySearch) {
                            $query->where(\DB::raw('LOWER(campaign_type)'),'!=',$keySearch);
                       });
                        
                    }else if($keyType == "startsWith"){
                        $q->whereHas('campaign', function ($query) use($keySearch) {
                            $query->whereRaw('LOWER(campaign_type) LIKE ? ',[trim(strtolower($keySearch)).'%']);
                       });
                        
                    }else if($keyType == "endsWith"){
                        $q->whereHas('campaign', function ($query) use($keySearch) {
                            $query->whereRaw('LOWER(campaign_type) LIKE ? ',['%'.trim(strtolower($keySearch))]);
                       });
                        
                    }
                }//check type filter

                if($keyName == "duration"){
                    if($keyType == "contains"){
                        $q->where('duration','LIKE','%'.(int) $keySearch.'%');
                    }else if($keyType == "notContains"){
                        $q->where('duration','NOT LIKE','%'.(int) $keySearch.'%');
                        
                    }else if($keyType == "equals"){
                        $q->where('duration',(int) $keySearch);
                        
                    }else if($keyType == "notEqual"){
                        $q->where('duration','!=',(int) $keySearch);
                        
                    }else if($keyType == "startsWith"){
                        $q->where('duration','LIKE',(int) $keySearch.'%');
                        
                    }else if($keyType == "endsWith"){
                        $q->where('duration','LIKE','%'.(int) $keySearch);
                        
                    }
                }//check duration filter

                if($keyName == "from"){
                    if($keyType == "contains"){
                        $q->where('From','LIKE','%'.$keySearch.'%');
                    }else if($keyType == "notContains"){
                        $q->where('From','NOT LIKE','%'.$keySearch.'%');
                        
                    }else if($keyType == "equals"){
                        $q->where('From',$keySearch);
                        
                    }else if($keyType == "notEqual"){
                        $q->where('From','!=',$keySearch);
                        
                    }else if($keyType == "startsWith"){
                        $q->where('From','LIKE',$keySearch.'%');
                        
                    }else if($keyType == "endsWith"){
                        $q->where('From','LIKE','%'.$keySearch);
                        
                    }
                }//check from filter

                if($keyName == "forward_to"){
                    if($keyType == "contains"){
                        $q->where('forward_to','LIKE','%'.$keySearch.'%');
                    }else if($keyType == "notContains"){
                        $q->where('forward_to','NOT LIKE','%'.$keySearch.'%');
                        
                    }else if($keyType == "equals"){
                        $q->where('forward_to',$keySearch);
                        
                    }else if($keyType == "notEqual"){
                        $q->where('forward_to','!=',$keySearch);
                        
                    }else if($keyType == "startsWith"){
                        $q->where('forward_to','LIKE',$keySearch.'%');
                        
                    }else if($keyType == "endsWith"){
                        $q->where('forward_to','LIKE','%'.$keySearch);
                        
                    }
                }//check forward_to filter

                if($keyName == "created_at"){
                    $from = \Carbon\Carbon::parse($keySearch);
                    // $from = \Carbon\Carbon::createFromFormat('m/d/Y', $keySearch, 'America/Mexico_City');
                    // dd($from);
                    if($keyType == "equals"){
                        
                        $q->whereDate(\DB::raw('created_at::DATE'),''.$from.'');
                        
                    }else if($keyType == "notEqual"){
                        $q->whereDate(\DB::raw('created_at::DATE'),'!=',''.$from.'');
                        
                    }else if($keyType == "greaterThan"){
                        $q->whereDate(\DB::raw('created_at::DATE'),'>',''.$from.'');
                        
                    }else if($keyType == "lessThan"){
                        $q->whereDate(\DB::raw('created_at::DATE'),'<',''.$from.'');
                        
                    }else if($keyType == "inRange" && $dateTo !== null){
                        $to = \Carbon\Carbon::parse($dateTo);
                        $q->whereBetween(\DB::raw('created_at::DATE'), [$from, $to]);
                        // $q->where(\DB::raw('created_at::DATE'),'<',\Carbon\Carbon::parse($keySearch)->format('Y-m-d'));
                        
                    }
                }//check forward_to filter
            }
        }

        $limit = $request->limit;
        // $page = $request->page;
        
        $callLogs = $q->with('campaign','user','company')->orderBy('id','desc')->paginate($limit);

        return response()->json($callLogs);

    }




}
