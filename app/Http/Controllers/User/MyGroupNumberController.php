<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MyNumber;
use App\Models\MyGroup;
use App\Models\MyGroupNumber;
class MyGroupNumberController extends Controller
{
    public function addNewMyNumberGroup(Request $request)
    {
        $request->validate([
            'group_name' => 'required',
        ]);

        $group = new MyGroup;
        $group->name = $request->group_name;
        $group->user_id = auth()->user()->id;
		$group->company_id = auth()->user()->company_id;
        $group->status = 'active';
        $group->save();

        if($request->my_number_id !== null){

        	if($request->forward_to_number !== null){
        		$myNumbers = MyNumber::whereIn('id',$request->my_number_id)->update([
		        	"forward_to_number"=>$request->forward_to_number,
		        	"raw_forward_to_number"=>preg_replace('/[^0-9]/', '', $request->forward_to_number),
		        ]);
        	}
        	
	        $myNumbers = $request->my_number_id;

	        foreach($myNumbers as $number){
	        	$myGroupNumber = new MyGroupNumber;
	        	$myGroupNumber->my_group_id  = $group->id;
	        	$myGroupNumber->my_number_id = $number;
	        	$myGroupNumber->save();
	        }
        }

        if($request->file !== null){

        	$file = file($request->file);
			$fileRows = count($file);
	        
	        $upload = $request->file('file');
	        
	        $filepath = $upload->getRealPath();

	        $csv = array();
	        $file1 = fopen($filepath, 'r');

	        while (($result = fgetcsv($file1)) !== false)
	        {
	            $csv[] = $result[0];
	        }

	        $data = [];
			$numbersArray = [];
	        for ($i=0; $i < $fileRows ; $i++) {
	            $raw_number = preg_replace('/[^0-9]/', '', $csv[$i]);
				if(strlen($raw_number) == 10  || strlen($raw_number) == 11){
					array_push($numbersArray,preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $csv[$i]));
					// $number = new MyNumber;
					// $number->user_id = auth()->user()->id;
					// $number->number = preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $csv[$i]);
					// $number->raw_number = preg_replace('/[^0-9]/', '', $csv[$i]);
					// $number->forward_to_number = ($request->forward_to_number !== null ? $request->forward_to_number: null);
					// $number->raw_forward_to_number = ($request->forward_to_number !== null ? preg_replace('/[^0-9]/', '', $request->forward_to_number) : null);
					// $number->status = 'active';
					// $number->type = 'csv';
					// $number->company_id = auth()->user()->company_id;

					// $number->save();

					// $myGroupNumber = new MyGroupNumber;
					// $myGroupNumber->my_group_id  = $group->id;
					// $myGroupNumber->my_number_id = $number->id;
					// $myGroupNumber->save();
				}
			}//for loop end
			$uniqueNumberArray = array_unique($numbersArray);
			if($uniqueNumberArray !== null){
				foreach($uniqueNumberArray as $num){
					$number = new MyNumber;
					$number->user_id = auth()->user()->id;
					$number->number = preg_replace('/[^0-9~!@#$%^&*()-._+\/]+/', '', $num);
					$number->raw_number = preg_replace('/[^0-9]/', '', $num);
					$number->forward_to_number = ($request->forward_to_number !== null ? $request->forward_to_number: null);
					$number->raw_forward_to_number = ($request->forward_to_number !== null ? preg_replace('/[^0-9]/', '', $request->forward_to_number) : null);
					$number->status = 'active';
					$number->type = 'csv';
					$number->company_id = auth()->user()->company_id;

					$number->save();

					$myGroupNumber = new MyGroupNumber;
					$myGroupNumber->my_group_id  = $group->id;
					$myGroupNumber->my_number_id = $number->id;
					$myGroupNumber->save();
				}//foreach loop end
			}//unique number if end

			unset($csv);
			unset($numbersArray);
			fclose($file1);
        }
		
		if (auth()->user()->role == "admin" || auth()->user()->role == "company") {
			return redirect()->back()->with('success','New Group Created Successfully.');
		}else {
			return redirect()->route('user.my_numbers')->with('success','New Group Created Successfully.');
		}
        // return redirect()->back()->with('success','New Group Created Successfully.');
    }

	public function showMyNumberGroup(Request $request,$id)
    {
    	$myGroup = MyGroup::find($id);
    	// $groupNumber = MyGroupNumber::where('my_group_id',$id)->orderBy('id','DESC')->get();
    	// $myNumbers =  [];
    	// if($groupNumber->isNotEmpty()){
    	// 	foreach ($groupNumber as $value) {
        //         if($value !== null){
        //             array_push($myNumbers,$value->my_number_id);
        //         }
    			
    	// 	}
    	// }
		
		$numbersList = MyNumber::whereIn('id', function($query) use($id) {
			$query->select('my_number_id')->from('my_group_numbers')->where('my_group_id',$id);
		})->Where('status', 'active')->paginate(10);

		// $numbersList = collect($myNumbers);
		// dd($numbersList);
		// 'myGroup','myNumbers',
    	return view('user.my_group_number.view_group_number', compact('numbersList'));
       
    }

    public function updateMyNumberGroup(Request $request,$id)
    {
    	$group = MyGroup::find($id);
        $group->name = $request->group_name;
        $group->save();
        return redirect()->back()->with('success','Group Updated Successfully.');
    }
	public function updateGroupMyNumber(Request $request,$id)
    {
		$request->validate([
            'my_number' => 'min:14|max:14',
            // 'forward_to_number' => 'min:14|max:14',
        ]);
		if($request->forward_to_number != null){
			$request->validate([
				'forward_to_number' => 'min:14|max:14',
			]);
		}
    	$number = MyNumber::find($id);
        if($request->my_number !== null){
            $number->number = $request->my_number;
        }
        if($request->forward_to_number !== null){
            $number->forward_to_number = $request->forward_to_number;
        }
        $number->save();

		if(auth()->user()->role == "user"){
			$myNumberURL = 'user.my_numbers';
		}else if(auth()->user()->role == "admin"){
			$myNumberURL = 'admin.numbers';
		}

		if($request->exists('search')){
			return redirect()->route($myNumberURL,'search')->with('success','Number Updated Successfully.');
		}elseif($request->exists('callzy_search')){
			return redirect()->route($myNumberURL,'callzy_search')->with('success','Number Updated Successfully.');
		}elseif($request->exists('client_search')){
			return redirect()->route($myNumberURL,'client_search')->with('success','Number Updated Successfully.');
		}
		else{
			return redirect()->back()->with('success','Number Updated Successfully.');
		}
        
    }
    

    public function deleteMyNumberGroup(Request $request,$id)
    {
        $groupNumber = MyGroupNumber::where('my_group_id',$id)->get();
        // dd($groupNumber);
        if($groupNumber->isNotEmpty()){
        	foreach($groupNumber as $num){
        		// $my_numbers = MyNumber::where('id',$num->my_number_id)->delete();
        		$my_group_numbers = MyGroupNumber::where('id',$num->id)->delete();
        	}
        }

        $group = MyGroup::where('id',$id)->delete();

        return redirect()->back()->with('success','Group deleted successfully');
    }


	public function getMyGroupFirstNumber(Request $request){
		$id = $request->id;
		$groupId = MyGroupNumber::where('my_group_id',$id)->first();
		if($groupId !== null){
			$number = MyNumber::find($groupId->my_number_id);
		}else{
			$number = null;
		}

		return response()->json($number);
	}
    

}
