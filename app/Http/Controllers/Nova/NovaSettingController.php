<?php

namespace App\Http\Controllers\Nova;

use App\Http\Controllers\Controller;
use App\Models\NovaSetting;
use Illuminate\Http\Request;
use Laravel\Nova\Nova;

class NovaSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Nova::user($request);
        $settings = NovaSetting::Where('user_id', $user->id)->first();
        if ($settings == null) {
            return response()->json(
                [
                    'data' => ['fileds' => null, 'status' => false],
                ],200
            );
        }else {
            $fields = $settings->fields;

            return response()->json(
                [
                    'data' => ['status' => true ,'fileds' => json_decode($fields)],
                ],200
            );
        }
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
        $user = Nova::user($request);
        $params = $request->json()->all();

        $settings = NovaSetting::first();
        if ($settings == null) {
            $setting = new  NovaSetting;
            $setting->key = 'admin-settings';
            $setting->fields = json_encode($params);
            $setting->user_id = $user->id;
            $setting->save();
        }else {
            $settings->fields = json_encode($params);
            $settings->save();
        }
        return response()->json(
            [
                'data' => ['message' => 'Settings Updated Successfully.', 'status' => true],
            ],200
        );
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
