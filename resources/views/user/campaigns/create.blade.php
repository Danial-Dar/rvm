@extends('layouts.app')
@section('content')
<style>
.form-control {
    border: none;
    border-bottom: 1px solid #cbd0d6;
    width: 50%;
}
.loader
{

   width:200px;
   height: 200px;
   position: relative;
   text-align:center;
   overflow: auto;
   z-index: 2;
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
        <div class="alert alert-danger" id="alert-danger" style="width:20% !important;">
            <ul>
              <button  style="float:right; background: none;border: none; " onclick="closeAlert()">x</button>
                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
            <div class="alert alert-success" id="alert-success" style="width:20% !important;">
                <ul> <button  style="float:right; background: none;border: none; " onclick="closeAlert()">x</button><li>{{session('success')}}</li></ul>
            </div>
    @endif

    <form action="{{route('user.campaign.store')}}" method="post" enctype="multipart/form-data" style="padding: 10px 10px 10px 10px;" onsubmit="loader()">
      @csrf
    <h5>Create Campaign</h5>
        <div class="card">
            <div class="card-body">
                <h5 style="color:#4e4d4dd6"> 1. Campaign Information</h5>

                <div class="row mt-20">
                    <div class="col-md-12">
                        <div class="form-group mb-20">
                            <select name="campaign_type" id="campaign_type" class="form-control" onchange="fetchBotData(this.value)" required>
                                <option value="" selected disabled>Select campaign Type</option>
                                <option value="rvm">RVM</option>
                                <option value="bot">BOT</option>
                                <option value="press-1">Press-1</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-20"  id="bot_dropdown" style="display:none;">
                    <div class="col-md-12">
                        <div class="form-group mb-20">
                            <select name="bot_type" id="bot_type" class="form-control">
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-20">
                    <input type="text" name="campaign_name" id="campaign_name" class="form-control" placeholder="Campaign Name"  required >
                </div>
                <label style="display: none;" id="randomLabel">Caller Id</label>
                <div class="row mb-4">
                  <div class="col-md-12">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">

                      {{-- <label class="btn btn-info mr-2">
                        <input type="radio" name="caller_id_button" id="client_number_button"
                        autocomplete="off" value="client_numbers" onclick="callerIdButtonChange(this.value)"> Client Numbers
                      </label>
                      <label class="btn btn-info mr-2">
                        <input type="radio" name="caller_id_button" id="callzy_number_button"
                        autocomplete="off" value="callzy_numbers" onclick="callerIdButtonChange(this.value)"> Callzy Numbers
                      </label>
                      <label class="btn btn-info mr-2">
                        <input type="radio" name="caller_id_button" id="individual_button"
                        autocomplete="off" value="individual" onclick="callerIdButtonChange(this.value)"> Individual
                      </label> --}}
                      {{-- <label class="btn btn-info mr-2">
                        <input type="radio" name="caller_id_button" id="outside_number_button" autocomplete="off" value="outside_numbers" onclick="callerIdButtonChange(this.value)"> Outside Numbers
                      </label>

                      <label class="btn btn-info mr-2">
                        <input type="radio" name="caller_id_button" id="group_button" autocomplete="off" value="group" onclick="callerIdButtonChange(this.value)"> Group
                      </label> --}}
                      {{-- style="display:none;" --}}
                      <label class="btn btn-info" style="display: none;" id="randomRadioBtn">
                        <input type="radio" name="caller_id_button" id="random_button"
                        autocomplete="off" value="random" onclick="callerIdButtonChange(this.value)"> Random
                      </label>
                    </div>
                  </div>

                </div>

                {{-- <div class="row" id="client_number_content" style="display: none;">
                   <div class="form-group mb-20 col-6">
                      <select name="caller_id[]" id="callerIdMulti" multiple class="form-control selectpicker" data-live-search="true" >
                          <option value="" disabled>Please select</option>
                      </select>

                  </div>
                </div>
                <div class="row" id="callzy_number_content" style="display: none;">
                  <div class="form-group mb-20 col-6">
                     <select name="caller_id[]" id="callerIdCallzyMulti" multiple class="form-control selectpicker" data-live-search="true" >
                         <option value="" disabled>Please select</option>
                     </select>
                 </div>
                </div>

                <div class="row" id="individual_content" style="display: none;">
                   <div class="form-group mb-20">
                      <div class="form-group mb-20">
                         <input type="text"  minlength="14" maxlength="14" name="caller_id_individual" id="caller_id"
                         placeholder="Add Caller id (XXX) XXX-XXX" class="form-control caller_id mask_input" style="">
                      </div>
                  </div>
                </div> --}}
                <div class="row" id="random_content" style="display: none;">
                  <div class="form-group mb-20">
                    <input type="text"  minlength="3" maxlength="3" name="caller_id_random" id="caller_id_random"
                    placeholder="Add Random Number XXX" class="form-control caller_id_random" style="" value="">
                 </div>
               </div>

              <label>Caller Id Forward To Number</label>
              <div class="row" id="ci_forward_number_content">
                <div class="col-12">
                   <div class="form-group mb-20">
                      <input type="text"  minlength="14" maxlength="14" name="ci_forward_number" id="ci_forward_number"
                      placeholder="Add Caller Id Forward To Number (XXX) XXX-XXX" class="form-control mask_input" required>
                   </div>
               </div>
             </div>
             <label>Voice Mail Forward To Number</label>
             <div class="row" id="vm_forward_number_content">
               <div class="col-12">
                  <div class="form-group mb-20">
                     <input type="text"  minlength="14" maxlength="14" name="vm_forward_number" id="vm_forward_number"
                     placeholder="Add Voice Mail Forward To Number (XXX) XXX-XXX" class="form-control mask_input" required>
                  </div>
              </div>
            </div>

                <div  id="press-1_fields" style="display:none;">

                  <div class="row mb-4 mt-4">
                    <div class="form-group col-md-12">
                        <label>Transfer To Number</label>
                        <div class="mb-20">
                          <input type="text"  minlength="14" maxlength="14" name="transfer_to_number"
                          id="transfer_to_number" placeholder="Add Transfer To Number (XXX) XXX-XXX" class="form-control mask_input" style="">
                        </div>
                    </div>
                  </div>

                  <div class="row mb-4 mt-4">
                    <div class="form-group col-md-12">
                        <label>Opt In Number</label>
                        <div class="mb-20">
                          <select name="opt_in_number" id="opt_in_number" class="form-control" onchange="opt_Val()">
                            <option value="">Select One</option>
                            @for ($i = 0; $i < 10; $i++)
                                <option value="{{$i}}">{{$i}}</option>
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
                          <select name="opt_out_number" id="opt_out_number" class="form-control" onchange="opt_Val()">
                            <option value="">Select One</option>
                            @for ($i = 0; $i < 10; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                          </select>
                        </div>
                        <label for="" style="color: #17a2b8">*Note: Opt out Number is the number a user will press on their phone to be placed on the do not call list</label>
                    </div>
                  </div>

                </div>
            </div>
        </div>
        <div class="card mt-20" id="recordingContent">
            <div class="card-body">
                <h5 style="color:#4e4d4dd6"> 2. Choose a recording</h5>
                <div class="form-group mb-20">
                    <select name="recording" id="recording" class="form-control selectpicker" onchange="getListenAudioLink(this.value)" required>
                        <option disabled>Click to select Recording for RVM</option>

                    </select>
                </div>
                <div id="listen_section">
                    <audio id="audio" controls>
                        <source id="audioSource" src="" type="audio/wav">
                    </audio>
                </div>
                 <div class="action-btn">
                    <a href="#" class="btn px-15 btn-primary"  data-toggle="modal" data-target="#add_recording_modal"> <i class="las la-plus fs-16"></i>Upload New Recording</a>
                     {{-- loader model --}}
                   <div class="modal fade" id="loader-modal-recording" tabindex="-1" role="dialog" aria-labelledby="loader_modalTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Your Recording Is Adding</h5>
                          </div>
                          <div class="modal-body text-center" style="padding: 20px 75px 20px 75px">
                              <div class="spinner-border text-info spin"></div>
                              <div id='seconds-counter-recording'> </div>
                          </div>
                        </div>
                      </div>
                   </div>
                  {{-- loader model end --}}
                </div>
            </div>
        </div>
        <div class="card mt-20" id="optoutRecordingContent" style="display: none;">
          <div class="card-body">
              <h5 style="color:#4e4d4dd6"> 2a. Choose a optout recording</h5>
              <div class="form-group mb-20">
                  <select name="optout_recording" id="optout_recording" class="form-control selectpicker" onchange="getListenOptoutAudioLink(this.value)">
                      <option disabled>Click to select optout Recording for RVM</option>
                  </select>
              </div>
              <div id="listen_optout_section">
                  <audio id="optout_audio" controls>
                      <source id="optoutAudioSource" src="" type="audio/wav">
                  </audio>
              </div>
               <div class="action-btn">
                  <a href="#" class="btn px-15 btn-primary"  data-toggle="modal" data-target="#add_optout_recording_modal">
                    <i class="las la-plus fs-16"></i>Upload New Optout Recording</a>
                   {{-- loader model --}}
                 <div class="modal fade" id="loader-modal-optout-recording" tabindex="-1" role="dialog" aria-labelledby="loader_modalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">Your Optout Recording Is Adding</h5>
                        </div>
                        <div class="modal-body text-center" style="padding: 20px 75px 20px 75px">
                            <div class="spinner-border text-info spin"></div>
                            <div id='seconds-counter-optout-recording'> </div>
                        </div>
                      </div>
                    </div>
                 </div>
                {{-- loader model end --}}
              </div>
          </div>
      </div>
        <div class="card mt-20" id="contactListContent">
            <div class="card-body">
                <h5 style="color:#4e4d4dd6"> 3. Select List of Contacts</h5>
                <div class="form-group mb-20" >
                    <select name="recipient[]" id="recipient" class="form-control selectpicker" multiple required>
                     <option disabled>Choose a Recipient List</option>

                    </select>
                </div>
                <div class="action-btn">
                    <a href="#" class="btn px-15 btn-primary" data-toggle="modal" data-target="#add_contact_list_modal"> <i class="las la-plus fs-16"></i>Upload New Contact List</a>

                  {{-- loader model --}}
                   <div class="modal fade" id="loader-modal-contact-list" tabindex="-1" role="dialog" aria-labelledby="loader_modalTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Your Contact List Is Adding</h5>
                          </div>
                          <div class="modal-body text-center" style="padding: 20px 75px 20px 75px">
                              <div class="spinner-border text-info spin"></div>
                              <div id='seconds-counter-contact-list'> </div>
                          </div>
                        </div>
                      </div>
                   </div>
                  {{-- loader model end --}}
                </div>
            </div>
        </div>
        <div class="card mt-20" >
            <div class="card-body">
                <h5 style="color:#4e4d4dd6"> 4. Send Speed</h5>
                <div class="form-group mb-20">
                  <div class="slidecontainer">
                    <input type="range" min="500" max="10000000" value="500" class="slider" name="drops_per_hour" id="myRange" >
                    {{-- <p>Drops Per Hour: <strong> <span id="demo"></span> </strong></p> --}}
                    <p>Drops Per Hour: <strong> <input class="form-control" type="number" max="10000000" onchange ="updateDropsPerHourSliderRangeValue(this.value)" name=""id="dropsPerHourSliderRange"> </strong></p>
                  </div>
                </div>
            </div>
        </div>
        <div class="card mt-20 mb-20" >

            <div class="card-body">
                <h5 style="color:#4e4d4dd6"> 5. Set Campaign Send Time</h5>
                <div class="form-group mb-20 ml-20 mt-20">
                  <button type="submit"  class="btn btn-primary mr-20">Send Now</button>
                  <button type="button" onclick="campaignTimeShow()" class="btn btn-primary">Send Later</button>
                  <button type="button" onclick="testApiCallModal()" class="btn btn-primary ml-20">Test Call</button> 
                </div>
                <div class="container" id="later_date">
                    <div class="row">
                        <div class='col-sm-6'>
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' name="campaign_time" id="campaignTimeInput" class="form-control" placeholder="Select Date to send Later" />
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                </div>
                                <button type="submit" class="btn btn-primary mt-20 ml-20 ">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="loader-modal" tabindex="-1" role="dialog" aria-labelledby="loader_modalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Your Campaign Is Adding</h5>

                            </div>
                            <div class="modal-body text-center" style="padding: 20px 75px 20px 75px">
                                <div class="spinner-border text-info spin"></div>
                                <div id='seconds-counter'> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
    </form>
</div>
{{-- recording modal --}}
<div class="modal fade" id="add_recording_modal" tabindex="-1" role="dialog" aria-labelledby="add_recording_modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Add Recording</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body" style="padding: 20px 75px 20px 75px">
              <form action="" id="recordingCampaignForm" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group mb-20">
                      <label for="">Recording Name</label>
                      <input type="text" name="name" id="recordingCampaignFormName" style="border: 1px solid #ced4da !important;" class="form-control" placeholder="Recording Name" required>
                  </div>
                  <div class="form-group mb-20">
                      <label for="recording">Upload Recording</label>
                      <input type="file" name="file" id="recordingCampaignFormFile" style="border: 1px solid #ced4da !important;" class="form-control" required accept=".mp3,.wav">
                  </div>


                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="button" onclick="addRecording(event)" class="btn btn-primary">Add Recording</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>
{{-- optout recording modal --}}
<div class="modal fade" id="add_optout_recording_modal" tabindex="-1" role="dialog" aria-labelledby="add_optout_recording_modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Add Optout Recording</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body" style="padding: 20px 75px 20px 75px">
              <form action="" id="optputRecordingCampaignForm" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group mb-20">
                      <label for="">Recording Name</label>
                      <input type="text" name="name" id="optoutRecordingCampaignFormName" style="border: 1px solid #ced4da !important;" class="form-control" placeholder="Recording Name" required>
                  </div>
                  <div class="form-group mb-20">
                      <label for="recording">Upload Recording</label>
                      <input type="file" name="file" id="optoutRecordingCampaignFormFile" style="border: 1px solid #ced4da !important;" class="form-control" required accept=".mp3,.wav">
                  </div>


                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="button" onclick="addOptoutRecording(event)" class="btn btn-primary">Add Recording</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>
{{-- contact list modal form --}}
<div class="modal fade" id="add_contact_list_modal" tabindex="-1" role="dialog" aria-labelledby="add_contact_list_modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Contact List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 20px 75px 20px 75px">
                <form action="" method="POSt" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-20">
                        <label for="">Contact List Name</label>
                        <input type="text" name="name" id="campaignContactListName" class="form-control" placeholder="List Name" required style="border: 1px solid #ced4da !important;">
                    </div>
                    <div class="form-group mb-20">
                        <label for="">Upload Contact List</label>
                        <input type="file" name="file" id="campaignContactListFile" class="form-control" accept=".csv" onchange="csvValidate()" required style="border: 1px solid #ced4da !important;">
                    </div>


                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" onclick="createContactList(event)" class="btn btn-primary">Add Contact List</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
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
                      <label for="">From Number</label>
                      <input disabled type="text" name="from_number" id="testApiCallFromNumber" style="border: 1px solid #ced4da !important;" class="form-control" placeholder="From Number" required maxlength="14">
                  </div>
                  <div class="form-group mb-20">
                      <label for="recording">To Number</label>
                      <input type="text" name="to_number" id="testApiCallToNumber" style="border: 1px solid #ced4da !important;" class="form-control" placeholder="To Number" required maxlength="14">
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
<input type="hidden" id="recordingStoreUrl" value="{{route('user.recording.ajaxStore')}}">
<input type="hidden" id="contactListStoreUrl" value="{{route('user.contact-list.ajaxStore')}}">
<input type="hidden" id="testCallApiUrl" value="{{route('user.campaigns.test_call')}}">
<input type="hidden" id="getAllCallerIdsURL" value="{{route('user.campaign.get_caller_ids')}}">
{{-- <input type="hidden" id="getGroupFirstNumber" value="{{route('user.my_groups.getFirstNumber')}}">

<input type="hidden" id="getAllCallerGroupsURL" value="{{route('user.campaign.get_caller_groups')}}"> --}}
<input type="hidden" id="getAllContactListURL" value="{{route('user.campaign.get_campaign_contact_list')}}">
<input type="hidden" id="getAllRecordingsURL" value="{{route('user.campaign.get_campaign_recordings')}}">
<script type="text/javascript">
  $(document).ready(function(){
    $('#testApiCallFromNumber').mask('(000) 000-0000');
    $('#testApiCallToNumber').mask('(000) 000-0000');
    $('#caller_id_random').mask('000');

    $('INPUT[id="recordingCampaignFormFile"]').change(function () {
      var ext = this.value.match(/\.(.+)$/)[1];
      switch (ext) {
          case 'mp3':
          case 'wav':
              break;
          default:
              alert('This file type is not supported.');
              this.value = '';
      }
  });



  });
</script>
<script>
$(document).ready(function(){
  // -------------- fetch all numbers not in group  ----------------
  // let callerIdSelect = $('#client_number_content button');
  // let callerFlag = false;

  // let callerIdCallzySelect = $('#callzy_number_content button');
  // let callerCallzyFlag = false;


  // // all numbers
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
  //             url: $('#getAllCallerIdsURL').val()+'?type=client',
  //             success: function (response) {
  //               callerFlag = true;
  //               if(response.length >0){
  //                   $('#callerIdMulti').empty();
  //                   for(let i=0;i<response.length;i++){
  //                     $('#callerIdMulti').append('<option value="'+response[i].id+'">'+response[i].number+'</option>');
  //                   }
  //               }else{
  //                 $('#callerIdMulti').append('<option value="" disabled>No Numbers Found</option>');
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

  // // callzy numbers
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
  //                     $('#callerIdCallzyMulti').append('<option value="'+response[i].id+'">'+response[i].number+'</option>');
  //                   }
  //               }else{
  //                 $('#callerIdCallzyMulti').append('<option value="" disabled>0 Number Found</option>');
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

  // -------------- fetch all contact list  ----------------
  let contactListSelect = $('#contactListContent button');
  let contactListFlag = false;
  contactListSelect.click(function(){
      if(contactListFlag === false){
          $('#recipient').empty();
          $('.contact-list-loader').remove();
          contactListSelect.append('<div class="contact-list-loader spinner-border spinner-border-sm"></div>');
          $.ajax({
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: false,
            processData:false,
            url: $('#getAllContactListURL').val(),
            success: function (response) {
              contactListFlag = true;
              if(response.length >0){

                  for(let i=0;i<response.length;i++){
                    $('#recipient').append('<option value="'+response[i].id+'">'+response[i].name+'</option>')

                  }
              }else{
                alert('No list found.');
              }
              $('#recipient').selectpicker('refresh');
              console.log('Contact list loaded successful.');
            },
            beforeSend: function(){
                $('.contact-list-loader').show()
            },
            complete: function(){
                $('.contact-list-loader').hide();
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
          });
      }

  });

// -------------- fetch all recordings  ----------------
  let recordingSelect = $('#recordingContent button');
  let recordingFlag = false;
  recordingSelect.click(function(){
      if(recordingFlag === false){
          $('.recording-loader').remove();
          recordingSelect.append('<div class="recording-loader spinner-border spinner-border-sm"></div>');
          $.ajax({
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: false,
            processData:false,
            url: $('#getAllRecordingsURL').val(),
            success: function (response) {
              recordingFlag = true;

              if(response.length >0){
                  $('#recording').empty();
                  $('#recording').append('<option disabled  Selected>Click to select Recording for RVM</option>');
                  for(let i=0;i<response.length;i++){
                    $('#recording').append('<option value="'+response[i].id+'">'+response[i].name+'</option>')

                  }
              }else{
                alert('0 recording found.');
              }
              $('#recording').selectpicker('refresh');
              console.log('Recording loaded successful.');
            },
            beforeSend: function(){
                $('.recording-loader').show()
            },
            complete: function(){
                $('.recording-loader').hide();
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
          });
      }

  });

  // -------------- fetch all optout recordings  ----------------
  let OptoutRecordingSelect = $('#optoutRecordingContent button');
  let OptoutRecordingFlag = false;

  OptoutRecordingSelect.click(function(){
    if(OptoutRecordingFlag === false){
        $('.recording-loader').remove();
        recordingSelect.append('<div class="recording-loader spinner-border spinner-border-sm"></div>');
        $.ajax({
          type: 'GET',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          contentType: false,
          processData:false,
          url: $('#getAllRecordingsURL').val(),
          success: function (response) {
            OptoutRecordingFlag = true;

            if(response.length >0){
                $('#optout_recording').empty();
                $('#optout_recording').append('<option disabled  Selected>Click to select optout Recording for RVM</option>');
                for(let i=0;i<response.length;i++){
                  $('#optout_recording').append('<option value="'+response[i].id+'">'+response[i].name+'</option>')

                }
            }else{
              alert('0 recording found.');
            }
            $('#optout_recording').selectpicker('refresh');
            console.log('Recording loaded successful.');
          },
          beforeSend: function(){
              $('.recording-loader').show()
          },
          complete: function(){
              $('.recording-loader').hide();
          },
          error: function (data) {
              console.log('An error occurred.');
              console.log(data);
          },
        });
    }

  });


});


  function callerCsvValidate()
  {
      var fileInput = document.getElementById('upload_csv_file');
      var filePath = fileInput.value;
      var allowedExtensions = /(\.csv)$/i;
      if(!allowedExtensions.exec(filePath)){
          alert('Please choose a csv file');
          fileInput.value = '';
          return false;
      }
  }

  function callerIdButtonChange(value){

    // if(value === "client_numbers"){

    //   $('#client_number_content').css('display','block');
    //   $('#individual_content').css('display','none');
    //   $('#callzy_number_content').css('display','none');
    //   $('#caller_id').val('');
    //   $('#callerIdMulti').attr('required',true);
    //   $('#caller_id').attr('required',false);
    //   $('#callerIdCallzyMulti').attr('required',false);
    //   $('#callerIdCallzyMulti').selectpicker('deselectAll');
    //   $('#random_content').css('display','none');
    //   $('#caller_id_random').attr('required',false);
    //   $('#caller_id_random').val('');

    // }else if(value === "individual"){
    //   $('#client_number_content').css('display','none');
    //   $('#individual_content').css('display','block');
    //   $('#callzy_number_content').css('display','none');
    //   $('#callerIdMulti').selectpicker('deselectAll');
    //   $('#callerIdMulti').attr('required',false);
    //   $('#caller_id').attr('required',true);
    //   $('#callerIdCallzyMulti').attr('required',false);
    //   $('#callerIdCallzyMulti').selectpicker('deselectAll');
    //   $('#random_content').css('display','none');
    //   $('#caller_id_random').attr('required',false);
    //   $('#caller_id_random').val('');

    // }else if(value === "callzy_numbers"){

    //   $('#callzy_number_content').css('display','block');
    //   $('#client_number_content').css('display','none');
    //   $('#individual_content').css('display','none');
    //   $('#caller_id').val('');
    //   $('#callerIdMulti').selectpicker('deselectAll');
    //   $('#callerIdCallzyMulti').attr('required',true);
    //   $('#callerIdMulti').attr('required',false);
    //   $('#caller_id').attr('required',false);
    //   $('#random_content').css('display','none');
    //   $('#caller_id_random').attr('required',false);
    //   $('#caller_id_random').val('');

    // }else
    if(value === "random"){
      // $('#callzy_number_content').css('display','none');
      // $('#client_number_content').css('display','none');
      // $('#individual_content').css('display','none');
      // $('#caller_id').val('');
      // $('#callerIdMulti').selectpicker('deselectAll');
      // $('#callerIdCallzyMulti').selectpicker('deselectAll');
      // $('#callerIdMulti').attr('required',false);
      // $('#callerIdCallzyMulti').attr('required',false);
      // $('#caller_id').attr('required',false);
      $('#random_content').css('display','block');
      $('#caller_id_random').attr('required',true);
    }
    $('#testApiCallFromNumber').val('');
  }


  function testApiCallModal(){
    $('#test_api_call_modal').modal('show');
    $('#testApiCallToNumber').val('');
    // $('#testApiCallFromNumber').val('');
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

    // if($('#upload_csv_file')[0].files.length !== 0){
    //   if(($('#callerIdMulti').selectpicker('val').length > 0 ||
    //   $('#callerMyGroup').selectpicker('val').length > 0) ||
    //   $('#caller_id').val() !== "" || $('#callerIdMulti').selectpicker('val').length > 0 ||
    //   $('#callerIdCallzyMulti').selectpicker('val').length > 0 || $('#callerIdOutsideMulti').selectpicker('val').length > 0 ){
    //     $('#testApiCallFromNumber').prop('disabled',true);
    //   }else{

    //     $('#testApiCallFromNumber').removeAttr('disabled');
    //   }
    // }else{
    //   $('#testApiCallFromNumber').prop('disabled',true);
    // }

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

    if($('#testApiCallFromNumber').val() === "" ){
      alert('Please add caller id ');
      $( "#testApiCallFromNumber" ).focus();
      return false;
    }
    // if($('#caller_id_button').)

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
                // $('#alert_test_call_success').css('display','block');
                // $('#testCallApiMsg').text('Your call is initiated.');
            }
          }else{
            // alert('Test call is failed please try again.');
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
            // $('#alert_test_call_success').css('display','none');
            // $('#testCallApiMsg').text('');
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
        // setTimeout(function () {
        //     $('#alert_test_call_success').css('display','none');
        // }, 2000);

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
  function loader()
    {

        $('#loader-modal').modal('show');
        // var seconds = 0;
        // var el = document.getElementById('seconds-counter');

        // function incrementSeconds() {
        // seconds += 1;
        // el.innerText = "Your Campaign is adding since " + seconds + " seconds.";
        // }

        // var cancel = setInterval(incrementSeconds, 1000);
    }

    function contactListLoader()
    {
       $('#loader-modal-contact-list').modal({
            backdrop: 'static',
            keyboard: false
        });
      $('#add_contact_list_modal').modal('hide');
      $('#loader-modal-contact-list').modal('show');


        // $('.spin').show();
        // var seconds = 0;
        // var el = document.getElementById('seconds-counter-contact-list');

        // function incrementSeconds() {
        //   seconds += 1;
        //   el.innerText = "Your Contact List is adding since " + seconds + " seconds.";
        // }

        // var cancel = setInterval(incrementSeconds, 1000);

    }

    function recordingLoader()
    {
      $('#loader-modal-recording').modal({
            backdrop: 'static',
            keyboard: false
        });
        // $('.spin').show();
        $('#add_recording_modal').modal('hide');
        $('#loader-modal-recording').modal('show');

        // var seconds = 0;
        // var el = document.getElementById('seconds-counter-recording');

        // function incrementSeconds() {
        // seconds += 1;
        // el.innerText = "Your Recording is adding since " + seconds + " seconds.";
        // }

        // var cancel = setInterval(incrementSeconds, 1000);
    }
    function optoutRecordingLoader()
    {
      $('#loader-modal-optout-recording').modal({
            backdrop: 'static',
            keyboard: false
        });
        // $('.spin').show();
        $('#add_optout_recording_modal').modal('hide');
        $('#loader-modal-optout-recording').modal('show');

        // var seconds = 0;
        // var el = document.getElementById('seconds-counter-optout-recording');

        // function incrementSeconds() {
        //   seconds += 1;
        //   el.innerText = "Your Recording is adding since " + seconds + " seconds.";
        // }

        // var cancel = setInterval(incrementSeconds, 1000);
    }

    function csvValidate()
    {
        var fileInput = document.getElementById('campaignContactListFile');
        var filePath = fileInput.value;

        var allowedExtensions = /(\.csv)$/i;
        // console.log(filePath,allowedExtensions);
        if(!allowedExtensions.exec(filePath)){
            alert('Please choose a csv file');
            fileInput.value = '';
            return false;
        }
    }

    function updateDropsPerHourSliderRangeValue(value){
      // $('#myRange').slider().slider('value', value);

      if(parseInt(value) > 10000000 || parseInt(value) < 500 ){

        alert('Range must be from 500 to 10000000');
        $('#myRange').val('0');
        $('#dropsPerHourSliderRange').val('')
        // $('#demo').text('0');
      }else{
        $('#myRange').val(value);
        // $('#demo').text(value);
      }

      // $('#myRange').slider('refresh');
    }

// function mp3WavValidate()
// {
//     var fileInput = document.getElementById('recordingCampaignFormFile');
//     var filePath = fileInput.value;
//     var allowedExtensions = /(\.mp3|wav)$/i;
//     if(!allowedExtensions.exec(filePath)){
//         alert('Only mp3 or wav files are allowed');
//         fileInput.value = '';
//         return false;
//     }
// }

function createContactList(e){
  e.preventDefault();
  if($( '#campaignContactListName' ).val() === '')
  {
    alert('List Name is required');
    return;
  }
  if($( '#campaignContactListFile' )[0].files.length === 0){
     alert('File is required');
    return;
  }
  contactListLoader();

  let ajaxData = new FormData();
  ajaxData.append( 'name', $( '#campaignContactListName' ).val());
  ajaxData.append( 'file', $( '#campaignContactListFile' )[0].files[0]);

  $('#recipient').empty();

  $.ajax({
      type: 'POST',
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      contentType: false,
      processData:false,
      url: document.getElementById('contactListStoreUrl').value,
      data: ajaxData,
      success: function (data) {

          $('#campaignContactListName' ).val('');
          $('#campaignContactListFile' ).val('');
          setTimeout(function () {
              $('#loader-modal-contact-list').modal('hide');
          }, 1000);
          // $('#recipient').append('<option Selected disabled>Click to select Recording for RVM</option>');
          var response = data['contactList'];
          if(response !== null){
              for(let i=0;i<response.length;i++){
                $('#recipient').append('<option value="'+response[i].id+'">'+response[i].name+'</option>')
              }
          }else{
            alert('contact list not added');
          }
          $('#recipient').selectpicker('refresh');
          console.log('Submission was successful.');
          $('#add_contact_list_modal').modal('hide');

      },
      error: function (data) {
          console.log('An error occurred.');
          console.log(data);
      },
  });
}
function addRecording(e)
{
    e.preventDefault();
    if($( '#recordingCampaignFormName' ).val() === '')
    {
      alert('Name is required');
      return;
    }
    if($( '#recordingCampaignFormFile' )[0].files.length === 0){
       alert('File is required');
      return;
    }
    recordingLoader();
    let ajaxData = new FormData();
    ajaxData.append( 'name', $( '#recordingCampaignFormName' ).val());
    ajaxData.append( 'file', $( '#recordingCampaignFormFile' )[0].files[0]);

     $('#recording').empty();

    $.ajax({
        type: 'POST',
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        contentType: false,
        processData:false,
        url: document.getElementById('recordingStoreUrl').value,
        data: ajaxData,
        success: function (data) {

            $('#recordingCampaignFormName' ).val('');
            $('#recordingCampaignFormFile' ).val('');

             setTimeout(function () {
              $('#loader-modal-recording').modal('hide');
          }, 1000);

            $('#recording').append('<option Selected disabled>Click to select Recording for RVM</option>');
            var response = data['recording'];
            if(response !== null){
                for(let i=0;i<response.length;i++){
                  $('#recording').append('<option value="'+response[i].id+'">'+response[i].name+'</option>')
                }
            }else{
              alert('recording not added');
            }
            $('#recording').selectpicker('refresh');
            console.log('Submission was successful.');
            // console.log(data);
            $('#add_recording_modal').modal('hide');
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
}

function addOptoutRecording(e)
{
    e.preventDefault();
    if($( '#optoutRecordingCampaignFormName' ).val() === '')
    {
      alert('Name is required');
      return;
    }

    if($('#optoutRecordingCampaignFormFile' )[0].files.length === 0){
       alert('File is required');
      return;
    }
    optoutRecordingLoader();
    let ajaxData = new FormData();
    ajaxData.append( 'name', $( '#optoutRecordingCampaignFormName' ).val());
    ajaxData.append( 'file', $( '#optoutRecordingCampaignFormFile' )[0].files[0]);

     $('#optout_recording').empty();

    $.ajax({
        type: 'POST',
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        contentType: false,
        processData:false,
        url: document.getElementById('recordingStoreUrl').value,
        data: ajaxData,
        success: function (data) {

            $('#optoutRecordingCampaignFormName' ).val('');
            $('#optoutRecordingCampaignFormFile' ).val('');

             setTimeout(function () {
              $('#loader-modal-optout-recording').modal('hide');
          }, 1000);

            $('#optout_recording').append('<option Selected disabled>Click to select optout Recording for RVM</option>');
            var response = data['recording'];
            if(response !== null){
                for(let i=0;i<response.length;i++){
                  $('#optout_recording').append('<option value="'+response[i].id+'">'+response[i].name+'</option>')
                }
            }else{
              alert('recording not added');
            }
            $('#optout_recording').selectpicker('refresh');
            console.log('Recording added successfully.');
            // console.log(data);
            $('#add_optput_recording_modal').modal('hide');
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
}



$(function () {
	$('select').selectpicker({
   size: '10'
});
  $('.datepicker').datepicker();
});

$('#later_date').hide();
$('#listen_section').hide();
$('#listen_optout_section').hide();

function getListenAudioLink(id){
  $.ajax({
        url: '{{url('user/listen-recording')}}',
        contentType: "application/json; charset=utf-8",
        data:{recording_id: id},
        success: function(result){
        // $("#div1").html(result);
        $('#listen_section').show();
        var audio = document.getElementById('audio');

        var source = document.getElementById('audioSource');
        source.src = result;

        audio.load(); //call this to just preload the audio without playing
        audio.play(); //call this to play the song right away
  }});
}
function getListenOptoutAudioLink(id){
  $.ajax({
        url: '{{url('user/listen-recording')}}',
        contentType: "application/json; charset=utf-8",
        data:{recording_id: id},
        success: function(result){
        // $("#div1").html(result);
        $('#listen_optout_section').show();
        var audio = document.getElementById('optout_audio');

        var source = document.getElementById('optoutAudioSource');
        source.src = result;

        audio.load(); //call this to just preload the audio without playing
        audio.play(); //call this to play the song right away
  }});
}
function campaignTimeShow()
{
     // let select = $('select').selectpicker({size:10});
      $('#later_date').show();
      $('#campaignTimeInput').attr('required', true);
}

function campaignTimeHide()
{
      let select = $('select').selectpicker({size:10});
      $('#later_date').hide();
      select.attr('required', false);
}

function fetchBotData(value){

  if(value ==="bot"){
    $('#bot_dropdown').show();
    $('#randomRadioBtn').hide();
    $('#randomLabel').hide();

    $('#bot_type').empty();
    $.ajax({
        url: '{{url('user/campaigns/get_all_bot')}}',
        contentType: "application/json; charset=utf-8",
        //data:{bot: bot},
        success: function(result){
          if(result.length > 0){
            $('#bot_type').attr('required',true);
            $('#bot_type').append('<option value="" selected disabled>Select Bot</option>');
            for(let i=0;i<result.length;i++){
              $('#bot_type').append('<option value="'+result[i].id+'">'+result[i].bot_name+'</option>');
            }
            $('#bot_type').selectpicker('refresh');
          }

    }});

  }else{
    $('#bot_dropdown').hide();
    $('#bot_type').attr('required',false);
  }
  if(value ==="press-1"){
    $('#randomRadioBtn').show();
    $('#press-1_fields').show();
    $('#randomLabel').show();
    $('#optoutRecordingContent').show();
    $('#transfer_to_number').attr('required', true);
    $('#opt_in_number').attr('required', true);
    $('#opt_out_number').attr('required', true);
    // $('#alpha').hide();
    // $('#alpha_notes').hide();
    $('#optoutRecordingContent').show();
    $('#optout_recording').attr('required', true);
  }
  else{
    $('#press-1_fields').hide();
    $('#randomRadioBtn').hide();
    $('#randomLabel').hide();
    $('#transfer_to_number').attr('required', false);
    $('#opt_in_number').attr('required', false);
    $('#opt_out_number').attr('required', false);
    // $('#alpha').show();
    // $('#alpha_notes').show();
    $('#optoutRecordingContent').hide();
    $('#optout_recording').attr('required', false);
  }
}

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

//to add multiple caller id's
$(document).ready(function() {


  $('.mask_input').mask('(000) 000-0000');
});

$(function () {
	$('#datetimepicker1').datetimepicker();
  $('.selectpicker').selectpicker({size:10});
});

</script>
<script>
$('#alert-success').delay(3000).fadeOut();
$('#alert-danger').delay(3000).fadeOut();
function closeAlert()
{
    $('#alert-success').css('display','none');
    $('#alert-danger').css('display','none');
}
var slider = document.getElementById("myRange");
var output = document.getElementById("dropsPerHourSliderRange");
output.value = slider.value;

slider.oninput = function() {
  output.value = this.value;
}
</script>

@endsection
