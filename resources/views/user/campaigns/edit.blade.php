@extends('layouts.app')
@section('content')
<style>
.form-control {
    border: none;
    border-bottom: 1px solid #cbd0d6;
    width: 50%;
}

[placeholder]:focus::-webkit-input-placeholder
 {
    transition: text-indent 0.4s 0.4s ease;
    text-indent: -100%;
    opacity: 1;
 }
 .card
 {
     width: 75%;
 }
 .card-body
 {
    padding: 40px 0px 40px 40px;
 }
 .btn.btn-light
 {
    background: #f9f9f9;
 }
 .bootstrap-select>.dropdown-toggle
 {
     width: 50%;
 }
 .bootstrap-select .dropdown-menu
 {
    min-width: 51%;
    position: initial !important;
 }

</style>
<div class="contents" style="padding-top: 120px !important;">
@if ($errors->any())
    <div class="alert alert-danger" id="alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session('success'))
        <div class="alert alert-success" id="alert-success">
            <ul><li>{{session('success')}}</li></ul>
        </div>
@endif
    <form action="{{route('user.campaign.update',['id'=>$campaign->id])}}" method="post" enctype="multipart/form-data" style="padding: 10px 10px 10px 10px;">
    @csrf
    <h5>Edit Campaign</h5>
        <div class="card">
            <div class="card-body">
                <h5 style="color:#4e4d4dd6"> 1. Campaign Information</h5>
                <div class="row mt-20">
                    <div class="col-md-12">
                        <div class="form-group mb-20">
                            <select name="campaign_type" id="campaign_type" class="form-control" onchange="fetchBotData(this.value)" readonly>
                              <option value="{{$campaign->campaign_type}}" selected>{{$campaign->campaign_type}}</option>
                          </select>
                        </div>
                    </div>
                </div>


                @if($campaign->campaign_type == "bot")
                  <div class="row mt-20"  id="bot_dropdown">
                    <div class="col-md-12">
                        <div class="form-group mb-20">
                            <label for="">Select Bot Type</label>
                            <select name="bot_type" id="bot_type" class="form-control">
                                <option value="" disabled selected>Select Bot</option>
                                @if($bots->isNotEmpty())
                                  @foreach ($bots as $bot)
                                      <option value="{{$bot->id}}" @if($campaign->bot_id == $bot->id) Selected @endif>{{$bot->bot_name}}</option>
                                  @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                  </div>
                @endif
                {{-- -------------updated bot_code end-------------- --}}
                <?php
                    $callerContentOpen = "";
                    // $myNum      = $count_myNumbers;
                    // $callzyNum  = $count_callzyNumbers;
                    // $indiNum  = $count_individual;
                    // if($myNum  > 0){
                    //   $callerContentOpen = "client_number_content";
                    // }elseif($callzyNum > 0){
                    //   $callerContentOpen = "callzy_number_content";
                    // }elseif($indiNum > 0){
                    //   $callerContentOpen = "individual_content";
                    // }
                    if($campaign->is_random){
                      $callerContentOpen = "random_content";
                    }

                ?>

                <div class="form-group mb-20">
                    <input type="text" name="campaign_name" id="campaign_name" class="form-control" placeholder="Campaign Name" value="{{$campaign->name}}"  required>
                </div>
                @if($campaign->is_random && $campaign->campaign_type == "press-1")
                  <label>Caller Id</label>
                @endif
                <div class="row mb-3">
                 <div class="col-md-12">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">

                      {{-- <label class="btn btn-info mr-2">
                        <input @if(count($myNumbers)  > 0) checked  @endif type="radio" name="caller_id_button"
                         id="my_number_button" autocomplete="off" value="client_numbers" onclick="callerIdButtonChange(this.value)"> All Numbers
                      </label>
                      <label class="btn btn-info mr-2">
                        <input @if(count($callzyNumbers)  > 0) checked  @endif type="radio" name="caller_id_button"
                        id="callzy_number_button" autocomplete="off" value="callzy_numbers"
                        onclick="callerIdButtonChange(this.value)"> Callzy Numbers
                      </label>
                      <label class="btn btn-info mr-2">
                        <input @if(count($individual)  > 0) checked  @endif type="radio"
                        name="caller_id_button" id="individual_button" autocomplete="off" value="individual"
                        onclick="callerIdButtonChange(this.value)"> Individual
                      </label> --}}
                      @if($campaign->campaign_type == "press-1")
                        <label class="btn btn-info">
                          <input @if($campaign->is_random) checked  @endif type="radio" name="caller_id_button"
                          id="random_button" autocomplete="off" value="random" onclick="callerIdButtonChange(this.value)"> Random
                        </label>
                      @endif
                    </div>
                  </div>

                </div>
{{--
                <div class="row" id="client_number_content"  @if($callerContentOpen =="client_number_content") style="display: block;" @else style="display: none;"  @endif >
                   <div class="form-group mb-20 col-6">
                      <select name="caller_id[]" id="callerIdMulti" multiple class="form-control selectpicker" data-live-search="true">
                          <option value="" disabled>Please select</option>

                          @if(count($myNumbers) > 0)
                            @foreach($myNumbers as $number)
                              <option value="{{$number['id'].'_'.'client'}}" Selected>{{$number['number']}}</option>
                            @endforeach
                          @endif

                      </select>
                  </div>
                </div>
                <div class="row" id="callzy_number_content" @if($callerContentOpen  =="callzy_number_content") style="display: block;" @else style="display: none;"  @endif >
                  <div class="form-group mb-20 col-6">
                     <select name="caller_id[]" id="callerIdCallzyMulti" multiple class="form-control selectpicker" data-live-search="true" >
                         <option value="" disabled>Please select</option>

                          @if(count($callzyNumbers) > 0)
                            @foreach($callzyNumbers as $number)
                              <option value="{{$number['id'].'_'.'callzy'}}" Selected>{{$number['number']}}</option>
                            @endforeach
                          @endif
                     </select>
                  </div>
                </div>
                 <div class="row" id="individual_content" @if($callerContentOpen  =="individual_content") style="display: block;" @else style="display: none;"  @endif>
                   <div class="form-group mb-20 col-6">
                      <div class="form-group mb-20 input_fields_wrap">
                        @if(count($individual) > 0)
                              @foreach($individual as $number)
                                <input
                                type="text"
                                maxlength="14"
                                minlength="14"
                                name="caller_id_individual"
                                id="caller_id"
                                placeholder="Add Caller id (XXX) XXX-XXX"
                                class="form-control caller_id mask_input" style=""
                                value="{{$number['number']}}">
                              @endforeach
                        @else
                            <input
                            type="text"
                            maxlength="14"
                            minlength="14"
                            name="caller_id_individual"
                            id="caller_id"
                            placeholder="Add Caller id (XXX) XXX-XXX"
                            class="form-control caller_id mask_input" style="">
                        @endif

                      </div>
                  </div>
                </div> --}}

                @if($campaign->campaign_type == "press-1")
                  <div class="row" id="random_content" @if($campaign->is_random) style="display: block;" @else style="display: none;"  @endif>
                    <div class="col-12">
                      <div class="form-group mb-20">
                          <input
                          type="text"
                          maxlength="3"
                          minlength="3"
                          name="caller_id_random"
                          id="caller_id_random"
                          placeholder="Add Random Number XXX"
                          class="form-control caller_id_random" style=""
                          @if($campaign->is_random && $campaign->campaign_type == "press-1") required  @endif
                          value="{{$campaign->random}}"
                          >

                      </div>
                  </div>
                </div>
                @endif
              <label>Caller Id Forward To Number</label>
              <div class="row" id="ci_forward_number_content">
                <div class="col-12">
                   <div class="form-group mb-20">
                      <input type="text"  minlength="14" maxlength="14" name="ci_forward_number" id="ci_forward_number"
                      placeholder="Add Caller Id Forward To Number (XXX) XXX-XXX" class="form-control mask_input" required value="{{$campaign->ci_forward_number}}">
                   </div>
               </div>
             </div>
             <label>Voice Mail Forward To Number</label>
             <div class="row" id="vm_forward_number_content">
                <div class="col-12">
                    <div class="form-group mb-20">
                      <input type="text"  minlength="14" maxlength="14" name="vm_forward_number" id="vm_forward_number"
                      placeholder="Add Voice Mail Forward To Number (XXX) XXX-XXX" class="form-control mask_input" required value="{{$campaign->vm_forward_number}}">
                    </div>
                </div>
              </div>
                @if ($campaign->campaign_type == "press-1")
                  <div  id="press-1_fields">

                    <div class="row mb-4 mt-4">
                      <div class="form-group col-md-12">
                          <label>Transfer To Number</label>
                          <div class="mb-20">
                            <input type="text"  maxlength="14" minlength="14"
                            name="transfer_to_number" id="transfer_to_number"
                            placeholder="Add Transfer To Number (XXX) XXX-XXX"
                            class="form-control mask_input"
                            value="{{$campaign->transfer_to_number}}" style=""
                            @if($campaign->campaign_type == "press-1") required ="required" @else required="" @endif >
                          </div>
                      </div>
                    </div>

                    <div class="row mb-4 mt-4">
                      <div class="form-group col-md-12">
                          <label>Opt In Number</label>
                          <div class="mb-20">
                            <select name="opt_in_number" id="opt_in_number" class="form-control" onchange="opt_Val()" @if($campaign->campaign_type == "press-1") required ="required" @else required="" @endif>
                              <option value="">Select One</option>
                              @for ($i = 0; $i < 10; $i++)
                                  <option value="{{$i}}" @if ($campaign->opt_in_number == $i) echo selected @endif >{{$i}}</option>
                              @endfor
                            </select>
                          </div>
                          <label for="" style="color: #17a2b8">*Note: Opt in Number is the number a user will press to be connected to your Transfer to number</label>
                      </div>
                    </div>

                    <div class="row mb-4 mt-4">
                      <div class="form-group col-md-12">
                          <label>Opt Out Number</label>
                          <div class="mb-20">
                            <select name="opt_out_number" id="opt_out_number" class="form-control" onchange="opt_Val()" @if($campaign->campaign_type == "press-1") required ="required" @else required="" @endif>
                              <option value="">Select One</option>
                              @for ($i = 0; $i < 10; $i++)
                                  <option value="{{$i}}" @if ($campaign->opt_out_number == $i) echo selected @endif>{{$i}}</option>
                              @endfor
                            </select>
                          </div>
                          <label for="" style="color: #17a2b8">*Note: Opt out Number is the number a user will press on their phone to be placed on the do not call list</label>
                      </div>
                    </div>


                  </div>
                @endif
            </div>
        </div>
        <div class="card mt-20" >
            <div class="card-body">
              <h5 style="color:#4e4d4dd6"> 2. Choose a recording</h5>
              <div class="form-group mb-20">
                  <select name="recording" id="recording" class="form-control" required>
                      <option Selected disabled>Click to select Recording for RVM</option>
                      @foreach($recordings as $rec)
                          <option value="{{$rec->id}}" {{$campaign->recording_id == $rec->id ? "Selected" : ''}}>{{$rec->name}}</option>
                      @endforeach
                  </select>
              </div>
            </div>
        </div>
        @if ($campaign->campaign_type == "press-1")
          <div class="card mt-20" >
            <div class="card-body">
              <h5 style="color:#4e4d4dd6"> 2a. Choose a optout recording</h5>
              <div class="form-group mb-20">
                  <select name="optout_recording" id="optout_recording" class="form-control" required>
                      <option Selected disabled>Click to select Optout Recording for RVM</option>
                      @foreach($recordings as $rec)
                          <option value="{{$rec->id}}" {{$campaign->recording_output_id == $rec->id ? "Selected" : ''}}>{{$rec->name}}</option>
                      @endforeach
                  </select>
              </div>
            </div>
        </div>
        @endif
        <div class="card mt-20" >
            <div class="card-body">
                <h5 style="color:#4e4d4dd6"> 3. Select List of Contacts</h5>
                <div class="form-group mb-20">
                    <select name="recipient[]" id="recipient" class="form-control" multiple required>
                    <!-- <option Selected disabled>Choose a Recipient List</option> -->
                    @foreach($contact_lists as $list)
                        <option value="{{$list->id}}" {{$campaign->contact_list_ids !== null ? in_array($list->id,$campaign->contact_list_ids) ? "Selected" : '' : ''}}>{{$list->name}}</option>
                    @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card mt-20" >
            <div class="card-body">
                <h5 style="color:#4e4d4dd6"> 4. Send Speed</h5>
                <div class="form-group mb-20">
                  <div class="slidecontainer">
                    <input type="range" min="500" max="10000000" value="{{$campaign->drops_per_hour}}" class="slider" name="drops_per_hour" id="myRange" >
                    {{-- <p>Drops Per Hour: <strong> <span id="demo"></span> </strong></p> --}}
                    <p>Drops Per Hour: <strong> <input class="form-control" type="number" max="10000000" onchange ="updateDropsPerHourSliderRangeValue(this.value)" name="drops_per_hour_input"id="dropsPerHourSliderRange" value="{{$campaign->drops_per_hour}}"> </strong></p>
                  </div>
                </div>
            </div>
        </div>
        <div class="card mt-20 mb-20" >
            <div class="card-body">
                <h5 style="color:#4e4d4dd6"> 5. update Campaign</h5>
                <div class="form-group mb-20 ml-20 mt-20">
                  <button type="submit"  class="btn btn-primary mr-20">Update</button>
                  <button type="button" onclick="testApiCallModal()" class="btn btn-primary">Test Call</button>
                  <!-- <button type="button" onclick="campaignEditTimeShow()" class="btn btn-primary">Send Later</button> -->
                </div>
                <div class="container" id="later_date2">
                    <div class="row">
                        <div class='col-sm-6'>
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker2'>
                                    <input type='text' name="campaign_time" class="form-control" value="" placeholder="Select Date to send Later" />
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                </div>
                                <button type="submit" class="btn btn-primary mt-20 ml-20 ">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
    </form>
</div>

{{-- test call modal --}}
<div class="modal fade" id="test_api_call_modal" tabindex="-1" role="dialog" aria-labelledby="test_api_call_modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Test Call</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body" style="padding: 20px 75px 20px 75px">
              <form action="" id="testApiCallForm" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group mb-20">
                      <label for="recording">From Number</label>
                      <input disabled type="text" name="from_number" id="testApiCallFromNumber" style="border: 1px solid #ced4da !important;" class="form-control" placeholder="From Number" required>
                  </div>
                  <div class="form-group mb-20">
                      <label for="recording">To Number</label>
                      <input type="text" name="to_number" id="testApiCallToNumber" style="border: 1px solid #ced4da !important;" class="form-control" placeholder="To Number" required>
                  </div>


                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="button" onclick="checkTestCall(event)" class="btn btn-primary">Test Call</button>
                      <div style="display: none;" class="test-call-loader spinner-border spinner-border-sm"></div>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>
<input type="hidden" id="campaign_edit_start_date" value="{{$campaign->start_date}}" />
<input type="hidden" id="dropsPerHourValue" value="{{$campaign->drops_per_hour}}" />
<input type="hidden" id="testCallApiUrl" value="{{route('user.campaigns.test_call')}}">
{{-- <input type="hidden" id="getGroupFirstNumber" value="{{route('user.my_groups.getFirstNumber')}}"> --}}
<input type="hidden" id="campaignBotIdHidden" value="{{$campaign->bot_id}}">
<input type="hidden" id="getAllCallerIdsURL" value="{{route('user.campaign.get_caller_ids')}}">
<script type="text/javascript">
  $(document).ready(function(){
    $('#testApiCallFromNumber').mask('(000) 000-0000');
    $('#testApiCallToNumber').mask('(000) 000-0000');
    $('#caller_id_random').mask('000');


    // -------------- fetch all numbers not in group  ----------------
  // let callerIdSelect = $('#client_number_content button');
  // let callerFlag = false;

  // let callerIdCallzySelect = $('#callzy_number_content button');
  // let callerCallzyFlag = false;

  //{{-- //let myNumbersObject = @json($myNumbers).length > 0 ? @json($myNumbers) : []; --}}
    //{{-- //let callzyNumbersObject = @json($callzyNumbers).length > 0 ? @json($callzyNumbers) : []; --}}

    // all numbers
    // callerIdSelect.click(function(){

    //     if(callerFlag === false){
    //       $('.caller-loader').remove();
    //           callerIdSelect.append('<div class="caller-loader spinner-border spinner-border-sm"></div>');

    //           $.ajax({
    //             type: 'GET',
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },
    //             contentType: false,
    //             processData:false,
    //             url:$('#getAllCallerIdsURL').val()+'?type=client',
    //             success: function (response) {
    //               callerFlag = true;
    //               if(response.length >0){
    //                   $('#callerIdMulti').empty();
    //                   for(let i=0;i<response.length;i++){
    //                     if(myNumbersObject.length >0){
    //                       myNumbersObject.filter((item)=>{
    //                           if(item.id === response[i].id){
    //                             $('#callerIdMulti').append('<option value="'+response[i].id+'_'+'mynumber'+'" selected>'+response[i].number+'</option>');
    //                           }else{
    //                             $('#callerIdMulti').append('<option value="'+response[i].id+'_'+'mynumber'+'">'+response[i].number+'</option>');
    //                           }
    //                       });
    //                     }else{
    //                       $('#callerIdMulti').append('<option value="'+response[i].id+'_'+'mynumber'+'">'+response[i].number+'</option>');
    //                     }


    //                   }
    //               }else{
    //                 alert('No numbers available.');
    //               }
    //               $('#callerIdMulti').selectpicker('refresh');
    //               console.log('Number loaded was successful.');
    //             },
    //             beforeSend: function(){
    //                 $('.caller-loader').show();
    //             },
    //             complete: function(){
    //                 $('.caller-loader').hide();
    //             },
    //             error: function (data) {
    //                 console.log('An error occurred.');
    //                 console.log(data);
    //             },
    //           });
    //     }

    // });

    // callzy numbers
  // callerIdCallzySelect.click(function(){

  //     if(callerCallzyFlag === false){
  //       $('.caller-loader').remove();
  //           callerIdCallzySelect.append('<div class="caller-loader spinner-border spinner-border-sm"></div>');

  //           $.ajax({
  //             type: 'GET',
  //             headers: {
  //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //             },
  //             contentType: false,
  //             processData:false,
  //             url: $('#getAllCallerIdsURL').val()+'?type=callzy',
  //             success: function (response) {
  //               callerCallzyFlag = true;
  //               if(response.length >0){
  //                   $('#callerIdCallzyMulti').empty();

  //                   for(let i=0;i<response.length;i++){
  //                     if(callzyNumbersObject.length >0){
  //                         callzyNumbersObject.filter((item)=>{
  //                             if(item.id === response[i].id){
  //                               $('#callerIdCallzyMulti').append('<option value="'+response[i].id+'_'+'callzy'+'" selected>'+response[i].number+'</option>');
  //                             }else{
  //                               $('#callerIdCallzyMulti').append('<option value="'+response[i].id+'_'+'callzy'+'">'+response[i].number+'</option>');
  //                             }
  //                         });
  //                       }else{
  //                         $('#callerIdCallzyMulti').append('<option value="'+response[i].id+'_'+'callzy'+'">'+response[i].number+'</option>');
  //                       }

  //                   }
  //               }else{
  //                 alert('No numbers available.');
  //               }
  //               $('#callerIdCallzyMulti').selectpicker('refresh');

  //               console.log('Callzy Number loaded was successful.');
  //             },
  //             beforeSend: function(){
  //                 $('.caller-loader').show();
  //             },
  //             complete: function(){
  //                 $('.caller-loader').hide();
  //             },
  //             error: function (data) {
  //                 console.log('An error occurred.');
  //                 console.log(data);
  //             },
  //           });
  //     }

  // });


  });
</script>
<script>
$(function () {
	$('select').selectpicker({
   size: '10'
  });
  $('.datepicker').datepicker();
});
$('#later_date2').hide();

function opt_Val()
{
  var opt_in = $('#opt_in_number').val();
  var opt_out = $('#opt_out_number').val();

  if (opt_in !== "" && opt_out !== "") {
    if (opt_in == opt_out) {
      alert('Opt Out Number Must be different From Opt In Number');
      $('#opt_out_number').selectpicker('val','');
    }
  }
}
function fetchBotData(value){

  if(value ==="bot"){
    $('#bot_dropdown').show();
    $('#bot_type').empty();
    var bot_id = $('#campaignBotIdHidden').val();
    $.ajax({
        url: '{{url('user/campaigns/get_all_bot')}}',
        contentType: "application/json; charset=utf-8",
        //data:{bot: bot},
        success: function(result){
          if(result.length > 0){
            $('#bot_type').append('<option value="" selected disabled>Select Bot</option>');
            for(let i=0;i<result.length;i++){
              $('#bot_type').append('<option value="'+result[i].id+'">'+result[i].bot_name+'</option>');

            }
            $('#bot_type').selectpicker('refresh');
          }

    }});

  }else{
    $('#bot_dropdown').hide();
  }

}

function callerIdButtonChange(value){

    // if(value === "client_numbers"){

    //   $('#client_number_content').css('display','block');
    //   $('#individual_content').css('display','none');
    //   $('#callzy_number_content').css('display','none');
    //   $('#random_content').css('display','none');

    //   $('#callerIdCallzyMulti').selectpicker('deselectAll');
    //   $('#caller_id').val('');
    //   $('#caller_id_random').val('');

    //   $('#caller_id').attr('required',false);
    //   $('#callerIdMulti').attr('required',true);
    //   $('#caller_id_random').attr('required',false);
    //   $('#callerIdCallzyMulti').attr('required',false);

    // }else if(value === "individual"){

    //   $('#client_number_content').css('display','none');
    //   $('#individual_content').css('display','block');
    //   $('#callzy_number_content').css('display','none');
    //   $('#random_content').css('display','none');
    //   $('#caller_id_random').val('');
    //   $('#callerIdMulti').selectpicker('deselectAll');
    //   $('#callerIdCallzyMulti').selectpicker('deselectAll');

    //   $('#caller_id').attr('required',true);
    //   $('#callerIdMulti').attr('required',false);
    //   $('#caller_id_random').attr('required',false);
    //   $('#callerIdCallzyMulti').attr('required',false);

    // }else if(value === "callzy_numbers"){

    //   $('#callzy_number_content').css('display','block');
    //   $('#client_number_content').css('display','none');
    //   $('#individual_content').css('display','none');
    //   $('#random_content').css('display','none');

    //   $('#caller_id_random').val('');
    //   $('#caller_id').val('');
    //   $('#callerIdMulti').selectpicker('deselectAll');

    //   $('#caller_id').attr('required',false);
    //   $('#callerIdMulti').attr('required',false);
    //   $('#caller_id_random').attr('required',false);
    //   $('#callerIdCallzyMulti').attr('required',true);
    // }else

    if(value === "random"){
      // $('#callzy_number_content').css('display','none');
      // $('#client_number_content').css('display','none');
      // $('#individual_content').css('display','none');
      $('#random_content').css('display','block');

      // $('#caller_id').val('');
      // $('#callerIdMulti').selectpicker('deselectAll');
      // $('#callerIdCallzyMulti').selectpicker('deselectAll');

      // $('#caller_id').attr('required',false);
      // $('#callerIdMulti').attr('required',false);
      $('#caller_id_random').attr('required',true);
      // $('#callerIdCallzyMulti').attr('required',false);


    }
    $('#testApiCallFromNumber').val('');
  }



function testApiCallModal(){
  $('#test_api_call_modal').modal('show');
  $('#testApiCallToNumber').val('');
  // console.log(caller_id)
    $.ajax({
      type: 'GET',
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      contentType: false,
      processData:false,
      url: $('#getAllCallerIdsURL').val()+'?type=testcall',
      success: function (response) {
        if(response != null){
          // console.log(response['raw_number'])
          $('#testApiCallFromNumber').val(response['number']);

        }
        console.log('Client Number fetch successful.');
      },
      error: function (data) {
          console.log('An error occurred.');
          console.log(data);
      },
    });
  // if($('#callerIdMulti').selectpicker('val').length > 0){
  //   $('#testApiCallFromNumber').val($("#callerIdMulti option[value='"+$('#callerIdMulti').selectpicker('val')[0]+"']").text());
  // }else if($('#caller_id').val() !== ""){
  //   $('#testApiCallFromNumber').val($('#caller_id').val());
  // }else if($('#callerIdCallzyMulti').selectpicker('val').length > 0){
  //   $('#testApiCallFromNumber').val($("#callerIdCallzyMulti option[value='"+$('#callerIdCallzyMulti').selectpicker('val')[0]+"']").text());
  // }

}

function checkTestCall(e){
    e.preventDefault();

    if($('#testApiCallFromNumber').val() === ""){
      alert('Please add caller id');
      $( "#testApiCallFromNumber" ).focus();
      return false;
    }

    if($('#testApiCallToNumber').val() === "" || $('#testApiCallToNumber').val().length < 14){
      alert('Please provide complete number.');
      $( "#testApiCallToNumber" ).focus();
      return false;
    }

    var campaignId = $('#campaign_type').val();
    if(campaignId == null){
       alert('Please select campaign type');
      return false;
    }

    var recording = $('#recording').val();
    if(recording == null){
       alert('Please select recording');
      return false;
    }

    let ajaxData = new FormData();
    ajaxData.append( 'number_from', $( '#testApiCallFromNumber' ).val());
    ajaxData.append( 'number_to', $( '#testApiCallToNumber' ).val());
    ajaxData.append( 'slug', campaignId);
    ajaxData.append( 'alpha_from', '');
    ajaxData.append( 'recording_id', recording);


    $.ajax({
      type: 'POST',
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      contentType: false,
      processData:false,
      url: document.getElementById('testCallApiUrl').value,
      data: ajaxData,
      success: function (response) {
        //console.log(response);
        if(response !== ""){
          let responseResult = JSON.parse(response);
          // console.log(response);
          if(responseResult.success){
            if(responseResult.data.status === "initiated"){

                flash( 'Your call is initiated.',{

                  // text color
                  'ftColor' : 'white',

                  // or 'top'
                  'vPosition' : 'top',

                  // or 'left'
                  'hPosition' : 'right',

                  // duration of animation
                  'fadeIn' : 400,
                  'fadeOut' : 400,

                  // click to close
                  'clickable' : true,

                  // auto hides after a duration time
                  'autohide' : true,

                  // timout
                  'duration' : 3000

                });
            }
          }else{
            flash( 'Test call is failed please try again.',{

                // background color
                'bgColor' : '#C0392B',

                // text color
                'ftColor' : 'white',

                // or 'top'
                'vPosition' : 'top',

                // or 'left'
                'hPosition' : 'right',

                // duration of animation
                'fadeIn' : 400,
                'fadeOut' : 400,

                // click to close
                'clickable' : true,

                // auto hides after a duration time
                'autohide' : true,

                // timout
                'duration' : 3000

              });
          }
        }else{
          flash( 'Some error occurred please try again or contact site administrator.',{

                // background color
                'bgColor' : '#C0392B',

                // text color
                'ftColor' : 'white',

                // or 'top'
                'vPosition' : 'top',

                // or 'left'
                'hPosition' : 'right',

                // duration of animation
                'fadeIn' : 400,
                'fadeOut' : 400,

                // click to close
                'clickable' : true,

                // auto hides after a duration time
                'autohide' : true,

                // timout
                'duration' : 3000

              });
        }



        $('#test_api_call_modal').modal('hide');

      },
      beforeSend: function(){
          $('.test-call-loader').show();
      },
      complete: function(){
          $('.test-call-loader').hide();
      },
      error: function (data) {
          console.log('An error occurred.');
          console.log(data);
          flash( data,{
            // background color
            'bgColor' : '#C0392B',

            // text color
            'ftColor' : 'white',

            // or 'top'
            'vPosition' : 'top',

            // or 'left'
            'hPosition' : 'right',

            // duration of animation
            'fadeIn' : 400,
            'fadeOut' : 400,

            // click to close
            'clickable' : true,

            // auto hides after a duration time
            'autohide' : true,

            // timout
            'duration' : 3000

          });
      },
    });


}

function campaignEditTimeShow()
{
      $('#later_date2').show();
      select.attr('required', true);
}

function campaignEditTimeHide()
{
      $('#later_date2').hide();
      select.attr('required', false);
}

 function updateDropsPerHourSliderRangeValue(value){

  if(parseInt(value) > 10000000 || parseInt(value) < 500 ){

        alert('Range must be from 500 to 10000000');

      let defaultValue = $('#dropsPerHourValue').val();
      if(defaultValue != null){
        $('#dropsPerHourSliderRange').val(defaultValue);
        $('#myRange').val(defaultValue);
      }else{
        $('#dropsPerHourSliderRange').val('500');
        $('#myRange').val('500');
      }

      // $('#demo').text('0');
    }else{
      $('#myRange').val(value);
      // $('#demo').text(value);
    }

    // $('#myRange').slider('refresh');
  }



//to add multiple caller id's
$(document).ready(function() {
  $('.mask_input').mask('(000) 000-0000');
});

$(function () {
	$('#datetimepicker2').datetimepicker({
    defaultDate:document.getElementById('campaign_edit_start_date').value
  });
});


</script>
<script>
var slider = document.getElementById("myRange");
var output = document.getElementById("dropsPerHourSliderRange");
output.value = slider.value;

slider.oninput = function() {
  output.value = this.value;
}
</script>
@endsection
