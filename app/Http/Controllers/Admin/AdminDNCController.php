<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminDNC;
use App\Models\DNC;
use Exception;
class AdminDNCController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $q = DNC::query();
        if ($request->search != null) {
            $q->where('number', 'like','%' . $request->search. '%')->orwhere('raw_number', 'like','%' . $request->search. '%');
        }
        $dnc_list = $q->with('company')->orderBy('id','desc')->paginate(10);
        
        return view('admin.dnc.index', compact('dnc_list'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|min:14|max:14',
        ]);

        // $raw_number = preg_replace('/[^0-9]/', '', $request->number);
        $formatNumber = formatNumber($request->number);
        if($formatNumber){
            $dnc = new DNC;
            $dnc->number = $request->number;
            $dnc->user_id = auth()->user()->id;
            $dnc->user_type = auth()->user()->role;
            $dnc->raw_number = $formatNumber;
            $dnc->dnc_type = 'individual';
            $dnc->save();
        }
        
        

        return redirect()->back()->with('success','DNC Number Added Successfully.');

    }

    public function delete(Request $request)
    {
       	$dnc_id = $request->id;

        $dnc = DNC::find($dnc_id);
        $dnc->delete();

        return redirect()->back()->with('success','DNC Number deleted Successfully.');

    }
}
