<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bot;
use Illuminate\Http\Request;

class BotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bots = Bot::all();
        return view('admin.settings.bot.index', compact('bots'));
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
        $request->validate([
            'bot_id' => 'required',
            'bot_name' => 'required'
        ]);

        $bot = new Bot;
        $bot->bot_id = $request->bot_id;
        $bot->bot_name = $request->bot_name;

        $bot->save();

        return redirect()->back()->with('success','New Bot Created Successfully.');
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
    public function update(Request $request)
    {
        $request->validate([
            'bot_id' => 'required',
            'bot_name' => 'required'
        ]);

        $bot = Bot::Where('id', $request->id)->first();
        $bot->bot_id = $request->bot_id;
        $bot->bot_name = $request->bot_name;

        $bot->save();

        return redirect()->back()->with('success','Bot Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bot = Bot::Where('id', $id)->first();
        $bot->delete();

        return redirect()->back()->with('success','Bot Deleted Successfully.');
    }
}
