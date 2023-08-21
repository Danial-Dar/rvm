<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactList;
use App\Models\Contact;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContactListExport;
use Exception;

class ContactListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        // $user_id = auth()->user()->id;
        $lists = ContactList::with('company')->where('type', '<>','cir')->get();
        return view('admin.contact_list.index', compact('lists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required',
    //         'name' => 'required',
    //     ]);

    //     $fileName = time().'.csv';
    //     // dd($fileName);
    //     $file = file($request->file);
    //     $request->file->move(storage::path('contact-lists'), $fileName);

    //     // $file = file($request->file);

    //     $fileRows = count($file);

    //     $recording = new ContactList;
    //     $recording->name = $request->name;
    //     $recording->user_id = auth()->user()->id;
    //     $recording->path = 'contact-lists/'.$fileName;
    //     $recording->filename = $fileName;
    //     $recording->total_contacts = $fileRows;
    //     $recording->save();

    //     return redirect()->back()->with('success','Contact List Added Successfully.');
    // }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Contact::Where('contact_list_id', $id)->where('type', '<>','cir')->paginate(20);

        return view('admin.contact_list.show', compact('data'));
        // $list = ContactList::Where('id', $id)->first();
        // // $list_file = Storage::get('contact-lists/'.$list->filename);
        // $readFile = storage_path('app/contact-lists/'.$list->filename);
        // $file_content = file($readFile);
        // // $dum = $file_content->paginate(10);

        // // $paginate = new Paginator($file_content, 20000);
        // $data = $this->paginate($file_content,$id);
        // // dd($paginate);
        // // var_dump($file);
        // // dd($data);
        // return view('admin.contact_list.show', compact('data'));
    }
    public function checkReputation(Request $request)
    {
        dd($request->all());
    }

    public function paginate($items, $newId, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page,  ['path' => url('user/contact-list/' . $newId)]);
    }

    public function destroy($id)
    {
        $contact_list = ContactList::find($id);
        $contacts = Contact::where('contact_list_id', $id)->get();
        try {
            $contact_list->status = "deleted";
            $contact_list->save();
            foreach ($contacts as $cont) {
                $cont->status = 'deleted';
                $cont->save();
            }
            return redirect()->back()->with('success', 'List Deleted Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('errors', 'List Deleted Successfully');
        }
    }

    public function checkContactsCampaigns($id)
    {
        $status = ['played', 'paused', 'pending'];
        $campaigns = Campaign::whereJsonContains('contact_list_id', ["$id"])->whereIn('status', $status)->get();
        if (count($campaigns) != 0) {

            return 'true';
        } else {

            return 'false';
        }
    }

    public function adminExportContactListContacts($contact_list_id)
    {

        $id = $contact_list_id;
        if ($id != null) {
            return Excel::download(new ContactListExport($id), 'contact_list.csv');;
        }
    }
}
