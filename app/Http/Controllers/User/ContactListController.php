<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Contact;
use App\Models\Campaign;
use App\Models\ContactList;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\UploadContactList;
use App\Exports\ContactListExport;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

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
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        if (!$company_id) {
            //            TODO! implement proper error handling.
            abort(403, 'Please define company of user.');
        }

        //        $company = auth()->user()->company_id;
        //        $company_users = User::where('company_id', $company)->get();
        //        foreach ($company_users as $user) {
        //            $user_id[] = $user->id;
        //        }
        $lists = ContactList::Where('company_id', $company_id)->Where('type','<>', 'cir')->orderBy('id', 'desc')->get();
        // dd($lists);
        // $user_id = auth()->user()->id;
        // $lists = ContactList::Where('user_id', $user_id)->get();

        return view('user.contact_list.index', compact('lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    public function mapContactList(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;

        $request->validate([
            'file' => 'required',
            'name' => 'required',
        ]);

        $fileName = time().'.csv';

        $file = file($request->file('file'));

        $fileRows = count($file);
        // $fileRows = $fileRows - 1;

        $uploadFileName = $request->file('file')->getClientOriginalName();

        // $fileName = $user_id.'_'.pathinfo($uploadFileName, PATHINFO_FILENAME).'_'.$fileRows.'.csv';

        //  $upload = storage_path().'/app/contact-lists/'.$fileName;
        $upload = $request->file('file');

        $filepath = $upload->getRealPath();

        $csv = [];
        $file1 = fopen($filepath, 'r');
        $csv = array_map('str_getcsv', file($upload));
        $header = array_shift($csv);
        // Seperate the header from data

        // $col = array_search("phone_number", $header);
        $col = implode(',', $header);
        $pattern = '/(phone|cell|number|mobile|contact)/i';

        unset($csv);
        if (preg_match($pattern, strtolower($col)) === 0) {
            return redirect()->back()->with('error', 'Please add a phone column to your CSV.');
        } else {
            // dd($col,$header);
            $request->file->move(storage::path('contact-lists'), $fileName);
            // $path = storage_path().'/app/contact-lists/'.$fileName;
            // $request->session()->forget('csv_map_list_id');
            // if(!file_exists($path)){
            //     $request->file->move(storage::path('contact-lists'), $fileName);
            //     $queue_name =  Str::random(10);
            //     $list = new ContactList;
            //     $list->name = $request->name;
            //     $list->user_id = $user_id;
            //     $list->company_id = $company_id;
            //     $list->path = 'contact-lists/'.$fileName;
            //     $list->filename = $fileName;
            //     $list->total_contacts = $fileRows - 1;
            //     $list->status = "active";
            //     $list->jobs = $queue_name;
            //     $list->job_status = 'pending';
            //     $list->save();
            //     $request->session()->put('csv_map_list_id', $list->id);
            // }else{
            //     $list = ContactList::where('filename',$fileName)->first();
            //     if($list != null){
            //         $request->session()->put('csv_map_list_id', $list->id);
            //     }

            // }
            // $list_id = $request->session()->get('csv_map_list_id');
            $list_name = $request->name;

            return view('user.contact_list.map_contacts', compact('header', 'user_id', 'company_id', 'fileName', 'fileRows', 'list_name'));
        }
    }

    public function mapContactListUpload(Request $request)
    {
        $user_id = $request->user_id;
        $company_id = $request->company_id;
        $fileName = $request->fileName;
        $fileRows1 = $request->fileRows;
        $list_name = $request->list_name;

        $csv_header_index = $request->csv_header_index;
        $csv_header_value = $request->csv_header_value;
        $queue_name = Str::random(10);
        $list = new ContactList();
        $list->name = $list_name;
        $list->user_id = $user_id;
        $list->company_id = $company_id;
        $list->path = 'contact-lists/'.$fileName;
        $list->filename = $fileName;
        $list->total_contacts = $fileRows1 - 1;
        $list->status = 'preprocessing';
        $list->jobs = $queue_name;
        $list->job_status = 'pending';
        $list->save();
        // dd($csv_header_value);
        // $contactList = ContactList::find($list_id);
        // $fileName = $list->filename;
        // $user_id = $list->user_id;
        // $company_id = $list->company_id;
        // $queue_name = $list->jobs;
        $fileRows = $list->total_contacts;
        $list_id = $list->id;
        // UploadContactList::dispatch($list_id, $fileName, $user_id,$company_id, $queue_name, $fileRows,$csv_header_index,$csv_header_value)->onQueue($queue_name);
        // exec('php artisan exec:uploadcontact '.$list_id);

        UploadContactList::dispatchAfterResponse($list_id, $fileName, $user_id, $company_id, $queue_name, $fileRows, $csv_header_index, $csv_header_value);

        // $upload = storage_path().'/app/contact-lists/'.$fileName;
        // // $upload = $request->file('file');
        // // $filepath = $upload->getRealPath();

        // $csv = array();
        // $file1 = fopen($upload, 'r');

        // while (($result = fgetcsv($file1)) !== false)
        // {
        //     // $csv[] = $result[0];
        //     $csv[] = $result;
        // }
        // $number_arrays=[];
        // $updatedFileRows = 0;
        // if(count($csv) > 0){
        //     $data = [];

        //     for ($i=1; $i <= $fileRows ; $i++) {
        //         $raw_number = preg_replace('/[^0-9]/', '', $csv[$i][$csv_header_index]);
        //         if(strlen($raw_number) == 10  || strlen($raw_number) == 11){
        //             array_push($number_arrays,$csv[$i][$csv_header_index]);

        //         }

        //     }
        //     $unique_number_array = array_unique($number_arrays);
        //     $updatedFileRows = count($unique_number_array);
        //     if($unique_number_array !== null && $updatedFileRows > 0){
        //         foreach($unique_number_array as $num){
        //             $data[] = [
        //                 // 'number'=> $csv[$i],
        //                 'number'=> preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $num),
        //                 'contact_list_id' => $list_id,
        //                 'user_id' => $user_id,
        //                 'company_id' => $company_id,
        //                 'status' => "active",
        //                 // 'raw_number' => preg_replace('/[^0-9]/', '', $csv[$i]),
        //                 'raw_number' => preg_replace('/[^0-9]/', '', $num),
        //                 'created_at' => now()->toDateTimeString(),
        //                 'updated_at' => now()->toDateTimeString(),
        //             ];
        //         }
        //     }

        //     $chunk_count = 500;
        //     if(count($data) > 0){
        //         $chunks = array_chunk($data, $chunk_count);

        //         foreach ($chunks as $chunk) {
        //             $insert = Contact::insert($chunk);
        //         }
        //     }

        // }
        // fclose($file1);
        // // $fileRows = $fileRows - 1;

        // $updateContactList = ContactList::find($list_id);
        // $successEntry = Contact::where('contact_list_id',$list_id)->count();
        // $failedEntry = $fileRows - $successEntry;
        // // $failedEntry = $updatedFileRows - $successEntry;
        // $updateContactList->success = $successEntry;
        // $updateContactList->failed = $failedEntry;
        // $updateContactList->total_contacts = $fileRows;
        // $updateContactList->selected_phone_column = $csv_header_value;
        // $updateContactList->job_status = 'success';
        // $updateContactList->save();

        $success = 'Contact List Added Successfully.';

        return redirect()->route('user.contact-list')->with(compact('success'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;

        $request->validate([
            'file' => 'required',
            'name' => 'required',
        ]);

        $fileName = time().'.csv';

        $file = file($request->file);

        $request->file->move(storage::path('contact-lists'), $fileName);

        $fileRows = count($file);

        // dd($fileRows);

        $queue_name = Str::random(10);

        $list = new ContactList();
        $list->name = $request->name;
        $list->user_id = $user_id;
        $list->company_id = $company_id;
        $list->path = 'contact-lists/'.$fileName;
        $list->filename = $fileName;
        $list->total_contacts = $fileRows;
        $list->status = 'active';
        $list->jobs = $queue_name;
        $list->job_status = 'pending';
        $list->save();

        $list_id = $list->id;
        //list_id,filename,
        UploadContactList::dispatch($list_id, $fileName, $user_id, $company_id, $queue_name, $fileRows)->onQueue($queue_name);
        exec('php artisan exec:uploadcontact '.$list->id);
        // $params = [
        //     'contact_list_id' => $list->id,
        // ];
        // \Artisan::call('exec:uploadcontact',$params);

        // $upload = storage_path().'/app/contact-lists/'.$fileName;
        // // $upload = $request->file('file');
        // // $filepath = $upload->getRealPath();

        // $csv = array();
        // $file1 = fopen($upload, 'r');

        // while (($result = fgetcsv($file1)) !== false)
        // {
        //     $csv[] = $result[0];
        // }

        // $data = [];

        // for ($i=0; $i < $fileRows ; $i++) {
        //     // $raw_number = preg_replace('/[^0-9]/', '', $csv[$i]);
        //     $data[] = [
        //         'number'=> $csv[$i],
        //         'contact_list_id' => $list->id,
        //         'user_id' => $user_id,
        //         'company_id' => $company_id,
        //         'status' => "active",
        //         'raw_number' => preg_replace('/[^0-9]/', '', $csv[$i]),
        //         'created_at' => now()->toDateTimeString(),
        //         'updated_at' => now()->toDateTimeString(),
        //     ];
        // }
        // // dd($data);
        // // // $chunk_count = $fileRows / 500;

        // $chunk_count = 500;
        // // // dd($chunk_count);

        // $chunks = array_chunk($data, $chunk_count);
        // foreach ($chunks as $chunk) {
        //     $insert = Contact::insert($chunk);
        // }

        // $updateContactList = ContactList::find($list->id);
        // $updateContactList->job_status = 'success';
        // $updateContactList->save();

        // $successEntry = Contact::where('contact_list_id',$list->id)->count();
        // $failedEntry = $fileRows - $successEntry;

        // (int)$fileRows - (int)$successEntry
        // dd($failed);

        // foreach ($csv as $key => $f) {

        //     $contact = new Contact;
        //     $contact->number = $f;
        //     $contact->contact_list_id = $list->id;
        //     $contact->status = "active";
        //     $contact->save();
        // }

        $success = 'Contact List Added Successfully.';

        return redirect()->back()
            // ->with(['success'=>'Contact List Added Successfully.','successEntry'=>$success,'failedEntry'=>$failed]);
            // ->with(compact('success', 'successEntry', 'failedEntry'));
            ->with(compact('success'));
        // ->with('failedEntry',$failed);
    }

    public function ajaxStore(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;

        // code after job
        $fileName = time().'.csv';

        $file = file($request->file);

        $request->file->move(storage::path('contact-lists'), $fileName);

        $fileRows = count($file);

        // dd($fileRows);

        $queue_name = Str::random(10);

        $list = new ContactList();
        $list->name = $request->name;
        $list->user_id = $user_id;
        $list->company_id = $company_id;
        $list->path = 'contact-lists/'.$fileName;
        $list->filename = $fileName;
        $list->total_contacts = $fileRows - 1;
        $list->status = 'active';
        $list->jobs = null;
        $list->job_status = 'pending';
        $list->save();

        // $list_id = $list->id;
        // //list_id,filename,
        // UploadContactList::dispatch($list_id, $fileName, $user_id,$company_id, $queue_name, $fileRows)->onQueue($queue_name);
        // exec('php artisan exec:uploadcontact '.$list->id);

        // old code before job
        // $fileName = time().'.csv';

        // $file = file($request->file);
        // // $request->file->move(storage::path('contact-lists'), $fileName);

        // $fileRows = count($file);

        // $list = new ContactList;
        // $list->name = $request->name;
        // $list->user_id = $user_id;
        // $list->company_id = $company_id;
        // $list->path = 'contact-lists/'.$fileName;
        // $list->filename = $fileName;
        // $list->total_contacts = $fileRows;
        // $list->status = "active";
        // $list->save();

        // $upload = $request->file('file');
        // $filepath = $upload->getRealPath();

        // $csv = array();
        // $file1 = fopen($filepath, 'r');

        // while (($result = fgetcsv($file1)) !== false)
        // {
        //     $csv[] = $result[0];
        // }

        // $data = [];

        // for ($i=0; $i < $fileRows ; $i++) {
        //     $data[] = [
        //         'number'=> $csv[$i],
        //         'contact_list_id' => $list->id,
        //         'user_id' => $user_id,
        //         'company_id' => $company_id,
        //         'status' => "active",
        //         'raw_number' => preg_replace('/[^0-9]/', '', $csv[$i]),
        //         'created_at' => now()->toDateTimeString(),
        //         'updated_at' => now()->toDateTimeString(),
        //     ];
        // }
        // $chunk_count = 500;
        // // dd($chunk_count);

        // $chunks = array_chunk($data, $chunk_count);

        // foreach ($chunks as $chunk) {
        //     Contact::insert($chunk);
        // }

        // foreach ($csv as $key => $f) {

        //     $contact = new Contact;
        //     $contact->number = $f[0];
        //     $contact->contact_list_id = $list->id;
        //     $contact->status = "active";
        //     $contact->save();
        // }

        $lists = ContactList::where('user_id', $user_id)->where('company_id', $company_id)->where('status', '!=', 'deleted')->get();

        return response()->json(['contactList' => $lists, 'success' => 'Contact List Added Successfully.']);
    }

    public function validateCsv(Request $request)
    {
        $upload = $request->file('file');

        $filepath = $upload->getRealPath();

        $csv = [];
        $file1 = fopen($filepath, 'r');
        $csv = array_map('str_getcsv', file($upload));
        $header = array_shift($csv);
        // Seperate the header from data

        // $col = array_search("phone_number", $header);
        $col = implode(',', $header);
        $pattern = '/(phone|cell|number|mobile|contact)/i';

        unset($csv);
        if (preg_match($pattern, strtolower($col)) === 0) {
            return response()->json(['success' => true]);
        // return redirect()->back()->with('error','Please add a phone column to your CSV.');
        } else {
            return response()->json(['success' => false]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $list = ContactList::Where('id', $id)->Where('type','<>', 'cir')->first();

        $data = Contact::Where('contact_list_id', $id)->Where('type','<>', 'cir')->paginate(20);
        // dd($data);
        // $readFile = storage_path('app/contact-lists/'.$list->filename);
        // $file_content = file($readFile);
        // $data = $this->paginate($file_content,$id);

        return view('user.contact_list.show', compact('data'));
    }

    public function paginate($items, $newId, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, ['path' => url('user/contact-list/'.$newId)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact_list = ContactList::find($id);
        $file_path = storage_path().'/app/contact-lists/'.$contact_list->filename;
        if (file_exists($file_path)) {
            unlink(storage_path('app/contact-lists/'.$contact_list->filename));
        }
        //-------------------------previous query----------------------
        // $contacts = Contact::where('contact_list_id' , $id)->get();
        // try{
        //     $contact_list->status = "deleted";
        //     $contact_list->status = "deleted";
        // $contact_list->save();
        //     foreach($contacts as $cont){
        //         $cont->status = 'deleted';
        //         $cont->save();
        //     }
        //     return redirect()->back()->with('success','List Deleted Successfully');
        // } catch (Exception $e){
        //     return redirect()->back()->with('errors','List Deleted Successfully');
        // }

        //------------------------optimized query------------------------

        $contacts = Contact::where('contact_list_id', $id)->update(['status' => 'deleted']);

        $contact_list->status = 'deleted';
        $contact_list->deleted_at = Carbon::now();
        $contact_list->save();

        return redirect()->back()->with('success', 'List Deleted Successfully');
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

    public function upload_contacts(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;

        $request->validate([
            'file' => 'required',
            'name' => 'required',
        ]);

        $fileName = time().'.csv';

        $file = file($request->file);
        // $request->file->move(storage::path('contact-lists'), $fileName);

        $fileRows = count($file);

        $list = new ContactList();
        $list->name = $request->name;
        $list->user_id = $user_id;
        $list->company_id = $company_id;
        $list->path = 'contact-lists/'.$fileName;
        $list->filename = $fileName;
        $list->total_contacts = $fileRows;
        $list->save();

        $upload = $request->file('file');
        $filepath = $upload->getRealPath();

        $csv = [];
        $file1 = fopen($filepath, 'r');

        while (($result = fgetcsv($file1)) !== false) {
            $csv[] = $result;
        }

        foreach ($csv as $key => $f) {
            $raw_number = preg_replace('/[^0-9]/', '', $f[0]);
            if (strlen($raw_number) == 10 || strlen($raw_number) == 11) {
                $contact = new Contact();
                $contact->number = preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $f[0]);
                $contact->contact_list_id = $list->id;
                $contact->user_id = $user_id;
                $contact->company_id = $company_id;
                $contact->raw_number = preg_replace('/[^0-9]/', '', $f[0]);
                $contact->save();
            }
        }

        return redirect()->back()->with('success', 'Contact List Added Successfully.');
    }

    public function test()
    {
        return view('user.contact_list.test');
    }

    public function exportContactListContacts($contact_list_id)
    {
        $id = $contact_list_id;
        if ($id != null) {
            return Excel::download(new ContactListExport($id), 'contact_list.csv');
        }
    }
}
