<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Models\Recording;

class RecordingController extends Controller
{
    public function index()
    {
        $recordings = Recording::with('company','user')->get();
        return view('admin.recordings.index', compact('recordings'));
    }

    public function destroy($id)
    {
        $audio = Recording::where('id',$id)->first();

        $campaigns = Campaign::WhereIn('status',['played', 'pending'])
                     ->Where('recording_id', $id)
                     ->count();
        // dd($campaigns);

        if($campaigns > 0){

            return redirect()->back()->with('error','Recording are currently Used In Active Campaigns.');

        }

        $audio->delete();
        return redirect()->back()->with('success','Recording deleted Successfully.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'user_name' => 'required',
        ]);
        $recording = Recording::where('id' ,$request->id)->first();
    }
}
