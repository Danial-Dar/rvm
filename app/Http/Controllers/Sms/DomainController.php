<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
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

        $q = Domain::query();

        $domains = $q
            ->orderBy('id', 'desc');
        if (auth()->user()->role == "user") {
            $domains = $domains->where('user_id', $user->id)->get();
            return view('user.sms.domain.index', compact('domains'));
        }

        $domains = $domains->paginate(10);

        return view('sms.domain.index',compact('domains'));
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

        $domain = new Domain();
        $domain->user_id = $user_id;
        $domain->company_id = $company_id;
        $domain->url = $request->url;
        $domain->section = $request->section;
        $domain->save();

        if (auth()->user()->role == "user") {
            return redirect()->route('user.domain')->with('success','Domain Added Successfully.');
        }
        return redirect()->route('admin.domain')->with('success','Domain Added Successfully.');
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
        $domain = Domain::find($id);
        $domain->url = $request->url;
        $domain->section = $request->section;
        $domain->save();
        if (auth()->user()->role == "user") {
            return redirect()->route('user.domain')->with('success','OptOut Word Updated Successfully.');
        }
        return redirect()->route('admin.domain')->with('success','OptOut Word Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $domain = Domain::find($id);
        $domain->delete();
        if (auth()->user()->role == "user") {
            return redirect()->back()->with('success','Domain deleted Successfully.');
        }
        return redirect()->back()->with('success','Domain deleted Successfully.');
    }
}
