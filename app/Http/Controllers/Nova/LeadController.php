<?php

namespace App\Http\Controllers\Nova;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->all();
        Log::info($params);
        $user_id = $params[0]['custom_fields']['id'];
        $list_id = $params[0]['custom_fields']['list_id'];
        $user = User::Find($user_id);
        $leads = [];
        $data = [];
        Log::info($user_id);
        foreach ($params as $row) {
            $data = $row['row_data'];
            $data['user_id'] = $user_id;
            $data['company_id'] = $user->company_id;
            $data['lead_list_id'] = $list_id;

            $leads[] = $data;
        }
        $list = LeadList::withTrashed()->Find($list_id)->restore();

        Log::info($leads);

        if (count($leads) > 0) {
            Lead::insert($leads);
        }
    }

    public function createLeadList($name)
    {
        $lead_list = new LeadList;
        $lead_list->name = $name;
        $lead_list->user_id = Auth::user()->id;
        $lead_list->company_id = Auth::user()->company_id;
        $lead_list->save();

        $list_id = $lead_list->id;

        $lead_list->delete();

        return response()->json([
            'id' => $list_id,
        ], 200);
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
