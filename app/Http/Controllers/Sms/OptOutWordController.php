<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use App\Models\OptOutWord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OptOutWordController extends Controller
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

        $q = OptOutWord::query();

        $opt_out_words = $q
            ->orderBy('id', 'desc');
        if (auth()->user()->role == "user") {
            $opt_out_words = $opt_out_words->where('user_id', $user->id)->get();
            return view('user.sms.opt_out_word.index', compact('opt_out_words'));
        }

        $opt_out_words = $opt_out_words->paginate(10);

        return view('sms.opt_out_word.index',compact('opt_out_words'));
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

        $opt_out_word = new OptOutWord();
        $opt_out_word->user_id = $user_id;
        $opt_out_word->company_id = $company_id;
        $opt_out_word->word = $request->word;
        $opt_out_word->section = $request->section;
        $opt_out_word->save();

        if (auth()->user()->role == "user") {
            return redirect()->route('user.opt_out_word')->with('success','OptOut Word Added Successfully.');
        }
        return redirect()->route('admin.opt_out_word')->with('success','OptOut Word Added Successfully.');
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
        $opt_out_word = OptOutWord::find($id);
        $opt_out_word->word = $request->word;
        $opt_out_word->section = $request->section;
        $opt_out_word->save();
        if (auth()->user()->role == "user") {
            return redirect()->route('user.opt_out_word')->with('success','OptOut Word Updated Successfully.');
        }
        return redirect()->route('admin.opt_out_word')->with('success','OptOut Word Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $opt_out_word = OptOutWord::find($id);
        $opt_out_word->delete();
        if (auth()->user()->role == "user") {
            return redirect()->back()->with('success','OptOut Word deleted Successfully.');
        }
        return redirect()->back()->with('success','OptOut Word deleted Successfully.');
    }
}
