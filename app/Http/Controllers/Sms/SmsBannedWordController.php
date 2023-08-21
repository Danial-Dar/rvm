<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\SmsBannedWord;
use Carbon\Carbon;
class SmsBannedWordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $q = SmsBannedWord::query();

        $sms_banned_word = $q
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('sms.banned_word.index',compact('sms_banned_word'));
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
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;

        $banned = new SmsBannedWord;
        $banned->user_id = $user_id;
        $banned->company_id = $company_id;
        $banned->word = $request->word;
        $banned->section = $request->section;
        $banned->save();
        return redirect()->route('admin.sms_banned_word')->with('success','Banned Word Added Successfully.');
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

    }


    public function getSmsBannedWord(Request $request)
    {
        $bannedWords = SmsBannedWord::get();

        return response()->json(['bannedWords'=>$bannedWords]);
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
        $banned = SmsBannedWord::find($id);
        $banned->word = $request->word;
        $banned->section = $request->section;
        $banned->save();
        return redirect()->route('admin.sms_banned_word')->with('success','Banned Word Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banned = SmsBannedWord::find($id);
        $banned->delete();
        return redirect()->back()->with('success','Banned Word deleted Successfully.');
    }
}
