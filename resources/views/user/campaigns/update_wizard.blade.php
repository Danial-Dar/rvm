@extends('layouts.app')
@section('content')
<style>

.stepwizard-step p {
    margin-top: 10px;
}
/* .has-error{
    color: red !important;
} */
.border-error{
    border: 1px solid red !important;
}

.stepwizard-row {
    display: table-row;
}

.stepwizard {
    display: table;
    width: 100%;
    position: relative;
}

.stepwizard-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;
}

/* .stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-order: 0;

} */
.progress {
  position: absolute;
  top: 14px;
  bottom: 0;
  width: 100%;
  height: 1px !important;
  background-color: #ccc;
  transition: width .2s;
  right: 15px;
}
.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}

.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
  border: 1px solid #ccc;
}
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
    <form action="{{route('user.campaign.update',['id'=>$campaign->id])}}" id="campaignUpdateForm" method="post" enctype="multipart/form-data" style="padding: 10px 10px 10px 10px;">
        @csrf
      <h5>Update Campaign</h5>
      <div class="card">
        <div class="card-body">
            {{-- stepper steps --}}
            <div class="stepwizard">
                <div class="stepwizard-row setup-panel">
                    <div class="progress" style="height: 1px;" id="progress">
                        <div class="progress-bar" id="progressBar1" role="progressbar"  style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="" id="progressBar2" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="" id="progressBar3" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="" id="progressBar4" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="" id="progressBar5" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-1" style="pointer-events:none;" id="step1" type="button" class="btn btn-primary btn-circle">1</a>
                        <p>Setup Campaign</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-2" style="pointer-events:none;" id="step2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                        <p>List Contacts</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-3" style="pointer-events:none;" id="step3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                        <p>Record Message</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-4" style="pointer-events:none;" id="step4" style="pointer-events:none;" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
                        <p>Send Speed</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-5" style="pointer-events:none;" id="step5" type="button" class="btn btn-default btn-circle" disabled="disabled">5</a>
                        <p>Schedule Delivery</p>
                    </div>
                </div>
            </div>
            {{-- stepper content --}}
            <div class="row setup-content" id="step-1">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <h5 style="color:#4e4d4dd6" class="mt-10"> Campaign Information</h5>
                        <div class="form-group mb-20 mt-20" id="campaignTypeDiv">
                            <select name="campaign_type" id="campaign_type" class="form-control" required>
                                <option value="" selected disabled>Select campaign Type</option>
                                <option value="{{$campaign->campaign_type}}" selected>{{$campaign->campaign_type}}</option>

                            </select>
                        </div>

                        <div class="row mt-20" id="bot_dropdown" @if($campaign->campaign_type == "bot") style="display:block;" @else style="display:none;" @endif>
                            <div class="col-md-12">
                                <div class="form-group mb-20">
                                    <select name="bot_type" id="bot_type" class="form-control"
                                    onchange="$('#bot_dropdown').find('button').removeClass('border-error')">
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
                        <div class="form-group mb-20">
                            <input type="text" name="campaign_name" id="campaign_name" class="form-control" placeholder="Campaign Name"
                             onkeyup="$('#campaign_name').val() !== '' ? $('#campaign_name').removeClass('border-error') : $('#campaign_name').addClass('border-error')"
                             required value="{{$campaign->name}}" autofocus onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
                        </div>
                        {{-- caller id start --}}
                        {{-- <label @if($campaign->campaign_type == "press-1") style="display: block;"  @else style="display: none;" @endif id="randomLabel">Caller Id</label> --}}
                        {{-- <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-info" @if($campaign->campaign_type == "press-1") style="display: block;"  @else style="display: none;" @endif id="randomRadioBtn">
                                    <input type="radio" name="caller_id_button" id="random_button"
                                    autocomplete="off" value="random" onclick="callerIdButtonChange(this.value)"
                                    @if($campaign->is_random) checked  @endif> Random
                                    </label>
                                </div>
                            </div>
                        </div> --}}
                        {{-- <div class="row" id="random_content" @if($campaign->campaign_type == "press-1") style="display: block;"  @else style="display: none;" @endif >
                            <div class="form-group mb-20 px-3">
                              <input type="text"  minlength="3" maxlength="3" name="caller_id_random" id="caller_id_random"
                              placeholder="Add Random Number XXX" class="form-control caller_id_random"
                              onkeyup="$('#caller_id_random').val() !== '' ? $('#caller_id_random').removeClass('border-error') : $('#caller_id_random').addClass('border-error')"
                              @if($campaign->is_random && $campaign->campaign_type == "press-1") required  @endif value="{{$campaign->random}}">
                           </div>
                         </div> --}}
                        {{-- caller id end --}}
                        {{-- forward number start --}}
                        <label>Caller Id Forward To Number</label>
                        <div class="row" id="ci_forward_number_content">
                            <div class="col-12">
                                <div class="form-group mb-20">
                                    <input type="text"  minlength="14" maxlength="14" name="ci_forward_number" id="ci_forward_number"
                                    placeholder="Add Caller Id Forward To Number (XXX) XXX-XXX"
                                    class="form-control mask_input"
                                    required onkeyup="$('#ci_forward_number').val() !== '' ? $('#ci_forward_number').removeClass('border-error') : $('#ci_forward_number').addClass('border-error')"
                                    value="{{$campaign->ci_forward_number}}">
                                </div>
                            </div>
                        </div>
                        <label @if($campaign->campaign_type != "press-1") style="display:block;" @else style="display:none;" @endif>Voice Mail Forward To Number</label>
                        <div class="row" id="vm_forward_number_content" @if($campaign->campaign_type != "press-1") style="display:block;" @else style="display:none;" @endif>
                            <div class="col-12">
                                <div class="form-group mb-20">
                                    <input type="text"  minlength="14" maxlength="14" name="vm_forward_number" id="vm_forward_number"
                                    placeholder="Add Voice Mail Forward To Number (XXX) XXX-XXX" class="form-control mask_input"
                                    onkeyup="$('#vm_forward_number').val() !== '' ? $('#vm_forward_number').removeClass('border-error') : $('#vm_forward_number').addClass('border-error')"
                                    value="{{$campaign->vm_forward_number}}" @if($campaign->campaign_type != "press-1") required @endif>
                                </div>
                            </div>
                        </div>
                        {{-- forward number end --}}
                        {{-- press-1 fields start --}}
                        <div  id="press-1_fields" @if($campaign->campaign_type == "press-1") style="display: block;"  @else style="display: none;" @endif>

                            <div class="row mb-4 mt-4">
                              <div class="form-group col-md-12">
                                  <label>Transfer To Number</label>
                                  <div class="mb-20">
                                    <input type="text"  minlength="14" maxlength="14" name="transfer_to_number"
                                    id="transfer_to_number" placeholder="Add Transfer To Number (XXX) XXX-XXX" class="form-control mask_input"
                                    onkeyup="$('#transfer_to_number').val() !== '' ? $('#transfer_to_number').removeClass('border-error') : $('#transfer_to_number').addClass('border-error')"
                                    value="{{$campaign->transfer_to_number}}"
                                    @if($campaign->campaign_type == "press-1") required ="required" @endif>
                                  </div>
                              </div>
                            </div>

                            <div class="row mb-4 mt-4">
                              <div class="form-group col-md-12">
                                  <label>Opt In Number</label>
                                  <div class="mb-20" id="optInDiv">
                                    <select name="opt_in_number" id="opt_in_number" class="form-control" onchange="opt_Val()">
                                      <option value="">Select One</option>
                                      @for ($i = 0; $i < 10; $i++)
                                          <option value="{{$i}}" @if ($campaign->opt_in_number == $i) echo selected @endif>{{$i}}</option>
                                      @endfor
                                    </select>
                                  </div>
                                  <label for="" style="color: #17a2b8">*Note: Opt in Number is the number a user will press to be connected to your Transfer to number</label>
                              </div>
                            </div>

                            <div class="row mb-4 mt-4">
                              <div class="form-group col-md-12">
                                  <label>Opt Out Number</label>
                                  <div class="mb-20" id="optOutDiv">
                                    <select name="opt_out_number" id="opt_out_number" class="form-control" onchange="opt_Val()">
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
                        {{-- press-1 fields end --}}
                        <button class="btn btn-primary nextBtn pull-right" type="button" style="float: right">Next</button>
                    </div>
                </div>
            </div>
            <div class="row setup-content" id="step-2">
                <div class="col-md-12">
                    <div class="col-md-12" >
                        <div>
                            <h5 style="color:#4e4d4dd6" class="mt-10"> 2. Select List of Contacts</h5>
                            <div class="form-group mb-20 mt-20" id="contactListContent">
                                
                                <select name="recipient[]" id="recipient" class="form-control selectpicker" multiple required disabled>
                                    @foreach($contact_lists as $list)
                                        @if($campaign->contact_list_ids !== null && in_array($list->id,$campaign->contact_list_ids))
                                            <option value="{{$list->id}}" selected>{{$list->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <button class="btn btn-primary nextBtn pull-right" type="button" style="float: right">Next</button> --}}
                        <div class="modal-footer mt-10">
                            <button class="btn btn-primary prevBtn pull-right" type="button" style="">Previous</button>
                            <button class="btn btn-primary nextBtn pull-right" type="button" style="">Next</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row setup-content" id="step-3">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <h5 style="color:#4e4d4dd6" class="mt-10"> 3. Choose a recording</h5>
                        <div class="form-group mb-20" id="recordingContent">
                            <select name="recording" id="recording" class="form-control selectpicker" required onchange="getListenAudioLink(this.value)">
                                <option Selected disabled>Click to select Recording for RVM</option>
                                @foreach($recordings as $rec)
                                    <option value="{{$rec->id}}" {{$campaign->recording_id == $rec->id ? "Selected" : ''}}>{{$rec->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="listen_section">
                            <audio id="audio" controls>
                                <source id="audioSource" src="" type="audio/wav">
                            </audio>
                        </div>

                        {{-- optout recording start --}}
                        <div class="mt-20" id="optoutRecordingContent" @if ($campaign->campaign_type == "press-1")
                            style="display: block;" @else style="display: none;" @endif>
                            <h5 style="color:#4e4d4dd6"> 3a. Choose a optout recording</h5>
                            <div class="form-group mb-20">
                                <select name="optout_recording" id="optout_recording" class="form-control selectpicker" onchange="getListenOptoutAudioLink(this.value)">
                                    <option Selected disabled>Click to select Optout Recording for RVM</option>
                                    @foreach($recordings as $rec)
                                        <option value="{{$rec->id}}" {{$campaign->recording_output_id == $rec->id ? "Selected" : ''}}>{{$rec->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="listen_optout_section">
                                <audio id="optout_audio" controls>
                                    <source id="optoutAudioSource" src="" type="audio/wav">
                                </audio>
                            </div>

                        </div>
                        {{-- optout recording end --}}
                        {{-- optin recording start --}}
                        <div class="mt-20" id="optinRecordingContent" @if ($campaign->campaign_type == "press-1")
                            style="display: block;" @else style="display: none;" @endif>
                            <h5 style="color:#4e4d4dd6"> 3b. Choose a Optin recording</h5>
                            <div class="form-group mb-20">
                                <select name="optin_recording" id="optin_recording" class="form-control selectpicker" onchange="getListenOptinAudioLink(this.value)">
                                    <option disabled>Click to select optin Recording for RVM</option>
                                    @foreach($recordings as $rec)
                                        <option value="{{$rec->id}}" {{$campaign->recording_optin_id == $rec->id ? "Selected" : ''}}>{{$rec->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="listen_optin_section">
                                <audio id="optin_audio" controls>
                                    <source id="optinAudioSource" src="" type="audio/wav">
                                </audio>
                            </div>
                        </div>
                        {{-- optin recording end --}}
                        {{-- <button class="btn btn-primary nextBtn pull-right" type="button" style="float: right">Next</button> --}}
                        <div class="modal-footer mt-10">
                            <button class="btn btn-primary prevBtn pull-right" type="button" style="">Previous</button>
                            <button class="btn btn-primary nextBtn pull-right" type="button" style="">Next</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row setup-content" id="step-4">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <h5 class="mt-10" style="color:#4e4d4dd6"> 4. Send Speed</h5>
                        <div class="form-group mb-20">
                        <div class="slidecontainer">
                            <input type="range" min="2000" max="10000000" value="{{$campaign->drops_per_hour}}" class="slider" name="drops_per_hour" id="myRange" >
                            {{-- <p>Drops Per Hour: <strong> <span id="demo"></span> </strong></p> --}}
                            <p>Drops Per Hour: <strong> <input class="form-control" type="number" max="10000000" onchange ="updateDropsPerHourSliderRangeValue(this.value)"
                                name=""id="dropsPerHourSliderRange" value="{{$campaign->drops_per_hour}}"> </strong></p>
                        </div>
                        </div>
                        {{-- <button class="btn btn-primary nextBtn pull-right" type="button" style="float: right">Next</button> --}}
                        <div class="modal-footer mt-10">
                            <button class="btn btn-primary prevBtn pull-right" type="button" style="">Previous</button>
                            <button class="btn btn-primary nextBtn pull-right" type="button" style="">Next</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row setup-content" id="step-5">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <h5 class="mt-10" style="color:#4e4d4dd6"> 5. Update Campaign</h5>
                        <div class="form-group mb-20 ml-20 mt-20">
                            {{-- <button type="submit"  class="btn btn-primary mr-20">Update</button> --}}
                            <button class="btn btn-primary prevBtn mr-20" type="button" style="">Previous</button>
                            <button type="button" onclick="$('#recipient').prop('disabled', false);$('#campaignUpdateForm').submit();" class="btn btn-primary mr-20">Update</button>
                            {{-- <button type="button" onclick="campaignTimeShow()" class="btn btn-primary">Send Later</button> --}}
                            <button type="button" onclick="testApiCallModal()" class="btn btn-primary">Test Call</button>
                        </div>

                    </div>
                </div>
            </div>
            {{-- stepper content end --}}
        </div>{{-- card body end --}}
      </div>{{-- card end --}}

    </form>
</div>

{{-- modal forms start --}}
{{-- recording modal --}}
{{-- <div class="modal fade" id="add_recording_modal" tabindex="-1" role="dialog" aria-labelledby="add_recording_modalTitle" aria-hidden="true">
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
  </div> --}}
  {{-- optout recording modal --}}
  {{-- <div class="modal fade" id="add_optout_recording_modal" tabindex="-1" role="dialog" aria-labelledby="add_optout_recording_modalTitle" aria-hidden="true">
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
  </div> --}}
  {{-- contact list modal form --}}
  {{-- <div class="modal fade" id="add_contact_list_modal" tabindex="-1" role="dialog" aria-labelledby="add_contact_list_modalTitle" aria-hidden="true">
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
  </div> --}}

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
{{-- modal forms end --}}
<input type="hidden" id="recordingStoreUrl" value="{{route('user.recording.ajaxStore')}}">
<input type="hidden" id="contactListStoreUrl" value="{{route('user.contact-list.ajaxStore')}}">
<input type="hidden" id="testCallApiUrl" value="{{route('user.campaigns.test_call')}}">
<input type="hidden" id="press1TestCallApiUrl" value="{{route('user.campaigns.press1_test_call')}}">
<input type="hidden" id="getAllCallerIdsURL" value="{{route('user.campaign.get_caller_ids')}}">
<input type="hidden" id="getAllContactListURL" value="{{route('user.campaign.get_campaign_contact_list')}}">
<input type="hidden" id="getAllRecordingsURL" value="{{route('user.campaign.get_campaign_recordings')}}">

<script>
    $(document).ready(function () {
        var navListItems = $('div.setup-panel div a'),
                allWells = $('.setup-content'),
                allNextBtn = $('.nextBtn');
                allPrevBtn = $('.prevBtn');

        allWells.hide();

        navListItems.click(function (e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                    $item = $(this);

            if (!$item.hasClass('disabled')) {
                navListItems.removeClass('btn-primary').addClass('btn-default');
                $item.addClass('btn-primary');
                allWells.hide();
                $target.show();
                $target.find('input:eq(0)').focus();
            }
        });

        allPrevBtn.click(function(){
            var curStep = $(this).closest(".setup-content"),
                preStep = $(this).closest(".setup-content").prev(),
                curStepBtn = curStep.attr("id"),
                preStepBtn = preStep.attr("id"),
                nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a"),
                curInputs = curStep.find("input[type='text'],input[type='url'],#campaign_type"),
                preInputs = preStep.find("input[type='text'],input[type='url'],#campaign_type"),
                isValid = true;
                // console.log(preStep,preStepBtn)
                if(preStepBtn === "step-1"){
                    $('#progressBar1').removeClass('bg-success');
                    $('#progressBar2').removeClass('progress-bar');
                    $('#step1').removeClass('btn-success');
                    $('#step1').addClass('btn-primary');
                }
                if(preStepBtn === "step-2"){
                    $('#progressBar2').removeClass('bg-success');
                    $('#progressBar3').removeClass('progress-bar');

                    $('#step2').removeClass('btn-success');
                    $('#step2').addClass('btn-primary');

                }
                if(preStepBtn === "step-3"){

                    $('#progressBar3').removeClass('bg-success');
                    $('#progressBar4').removeClass('progress-bar');
                    $('#step3').removeClass('btn-success');
                    $('#step3').removeClass('btn-primary');

                }
                if(preStepBtn === "step-4"){

                    $('#progressBar4').removeClass('bg-success');
                    $('#progressBar5').removeClass('progress-bar');
                    $('#step4').removeClass('btn-success');
                    $('#step4').addClass('btn-primary');

              }
                prevStepWizard.removeAttr('disabled').trigger('click');
        });

        allNextBtn.click(function(){
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                curInputs = curStep.find("input[type='text'],input[type='url'],#campaign_type"),
                isValid = true;

            $(".form-group .form-control").removeClass("border-error");
            $('#progressBar').css('background-color','#007bff');
            // step 1 validation

            if(curStepBtn === "step-1"){


                if($('#campaign_type').val() === null){
                    isValid = false;
                    $('#campaignTypeDiv').find('button').addClass("border-error");
                    // $('#campaign_type').focus();
                    $('#campaign_type').get(0).reportValidity();
                    return false;
                }else{
                    isValid = true;
                    $('#campaignTypeDiv').find('button').removeClass("border-error");
                }
                if($('#campaign_type').val() !== null && $('#campaign_type').val() === 'bot'){
                    if($('#bot_type').val() === null){
                        isValid = false;
                        $('#bot_dropdown').find('button').addClass("border-error");
                        $('#bot_type').focus();
                        $('#bot_type').get(0).reportValidity();
                        return false;
                    }else{
                        isValid = true;
                        $('#bot_dropdown').find('button').removeClass("border-error");
                    }
                }

                if($('#campaign_name').val() === ""){
                    isValid = false;
                    $( "#campaign_name" ).addClass("border-error");
                    // $( "#campaign_name" ).focus();
                    $('#campaign_name').get(0).reportValidity();
                    return false;
                }else{
                    isValid = true;
                    $( "#campaign_name" ).removeClass("border-error");
                }
                if($('#ci_forward_number').val().length < 14){
                    isValid = false;
                    $("#ci_forward_number" ).addClass("border-error");
                    $('#ci_forward_number').get(0).reportValidity();
                    return false;
                }else{
                    isValid = true;
                    $( "#ci_forward_number" ).removeClass("border-error");
                }
                if($('#campaign_type').val() !== null && $('#campaign_type').val() !== 'press-1'){
                    if($('#vm_forward_number').val().length < 14){
                        isValid = false;
                        $( "#vm_forward_number" ).addClass("border-error");
                        $('#vm_forward_number').get(0).reportValidity();
                        return false;
                    }else{
                        isValid = true;
                        $( "#vm_forward_number" ).removeClass("border-error");
                    }
                }

                if($('#campaign_type').val() !== null && $('#campaign_type').val() === 'press-1'){
                    // radio button validation
                    // if(document.getElementById('random_button').checked){
                    //     isValid = true;
                    //     $( "#randomRadioBtn" ).removeClass("border-error");
                    //     if($('#caller_id_random').val().length < 3){
                    //         isValid = false;
                    //         $( "#caller_id_random" ).addClass("border-error");
                    //         $('#caller_id_random').get(0).reportValidity();
                    //         return false;
                    //     }else{
                    //         isValid = true;
                    //         $( "#caller_id_random" ).removeClass("border-error");
                    //     }

                    // }else{

                    //     isValid = false;
                    //     $('#randomRadioBtn').addClass("border-error");
                    //     document.getElementById('random_button').focus();
                    //     $('#random_button').get(0).reportValidity();
                    //     return false;
                    // }
                     // transfer to number validation
                    if($('#transfer_to_number').val().length < 14){
                        isValid = false;
                        $( "#transfer_to_number" ).addClass("border-error");
                        $('#transfer_to_number').get(0).reportValidity();
                        return false;
                    }else{
                        isValid = true;
                        $( "#transfer_to_number" ).removeClass("border-error");
                    }

                    // optin optout validation
                    if($('#opt_in_number').val() === null || $('#opt_in_number').val() === ""){
                        isValid = false;
                        $('#optInDiv').find('button').addClass("border-error");
                        $('#opt_in_number').get(0).reportValidity();
                        return false;
                    }else{
                        isValid = true;
                        $('#optInDiv').find('button').removeClass("border-error");
                    }
                    if($('#opt_out_number').val() === null || $('#opt_out_number').val() === ""){
                        isValid = false;
                        $('#optOutDiv').find('button').addClass("border-error");
                        $('#opt_out_number').get(0).reportValidity();
                        return false;
                    }else{
                        isValid = true;
                        $('#optOutDiv').find('button').removeClass("border-error");
                    }


                }
                if(isValid){
                    $('#progressBar1').addClass('bg-success');
                    $('#progressBar2').addClass('progress-bar');
                    $('#step1').addClass('btn-success');
                    $('#step1').removeClass('btn-primary');
                }
            }


            // step 2 validation

            if(curStepBtn === "step-2"){

                if($('#recipient').val().length === 0){
                    isValid = false;
                    $('#contactListContent').find('button').addClass("border-error");
                    $('#recipient').get(0).reportValidity();
                }else{
                    isValid = true;
                    $('#contactListContent').find('button').removeClass("border-error");
                }
                if(isValid){
                    $('#progressBar1').addClass('bg-success');
                    $('#progressBar2').addClass('bg-success');
                    $('#progressBar3').addClass('progress-bar');

                    $('#step2').addClass('btn-success');
                    $('#step2').removeClass('btn-primary');
                }

            }
            if(curStepBtn === "step-3"){

                if($('#recording').val() === null || $('#recording').val() === ""){
                    isValid = false;
                    $('#recordingContent').find('button').addClass("border-error");
                    $('#recording').get(0).reportValidity();
                    return false;
                }else{
                    isValid = true;
                    $('#recordingContent').find('button').removeClass("border-error");
                }
                if($('#campaign_type').val() !== null && $('#campaign_type').val() === 'press-1'){
                    if($('#optout_recording').val() === null || $('#optout_recording').val() === ""){
                        isValid = false;
                        $('#optoutRecordingContent').find('button').addClass("border-error");
                        $('#optout_recording').get(0).reportValidity();
                        return false;
                    }else{
                        isValid = true;
                        $('#optoutRecordingContent').find('button').removeClass("border-error");
                    }

                    if($('#optin_recording').val() === null || $('#optin_recording').val() === ""){
                        isValid = false;
                        $('#optinRecordingContent').find('button').addClass("border-error");
                        $('#optin_recording').get(0).reportValidity();
                        return false;
                    }else{
                        isValid = true;
                        $('#optinRecordingContent').find('button').removeClass("border-error");
                    }

                }
                if(isValid){
                    $('#progressBar1').addClass('bg-success');
                    $('#progressBar2').addClass('bg-success');
                    $('#progressBar3').addClass('bg-success');
                    $('#progressBar4').addClass('progress-bar');
                    $('#step3').addClass('btn-success');
                    $('#step3').removeClass('btn-primary');
                }

            }
            if(curStepBtn === "step-4"){

                $('#progressBar1').addClass('bg-success');
                $('#progressBar2').addClass('bg-success');
                $('#progressBar3').addClass('bg-success');
                $('#progressBar4').addClass('bg-success');
                $('#progressBar5').addClass('progress-bar');
                $('#step4').addClass('btn-success');
                $('#step4').removeClass('btn-primary');
            }
            if(curStepBtn === "step-5"){
                $('#progressBar1').addClass('bg-success');
                $('#progressBar2').addClass('bg-success');
                $('#progressBar3').addClass('bg-success');
                $('#progressBar4').addClass('bg-success');
                $('#progressBar5').addClass('bg-success');
                $('#step5').addClass('btn-success');
                $('#step5').removeClass('btn-primary');
            }


            // for(var i=0; i<curInputs.length; i++){
            //     if (!curInputs[i].validity.valid){
            //         isValid = false;
            //         $(curInputs[i]).closest(".form-group .form-control").addClass("border-error");
            //         // $(curInputs[i]).attr("data-id", "campaign_type").addClass("border-error");

            //         // $('#campaignTypeDiv').find('button').addClass("border-error");
            //     }
            // }
            // console.log(isValid)
            if (isValid){
                nextStepWizard.removeAttr('disabled').trigger('click');
            }

        });

        $('div.setup-panel div a.btn-primary').trigger('click');
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){

      $('#testApiCallFromNumber').mask('(000) 000-0000');
      $('#testApiCallToNumber').mask('(000) 000-0000');
      $('.mask_input').mask('(000) 000-0000');
      $('#caller_id_random').mask('000');

      $('select').selectpicker({size: '10'});

      $('.datepicker').datepicker();

      $('#datetimepicker1').datetimepicker();
      $('.selectpicker').selectpicker({size:10});

      $('#later_date').hide();
      $('#listen_section').hide();
      $('#listen_optout_section').hide();
      $('#listen_optin_section').hide();
      $('#alert-success').delay(3000).fadeOut();
      $('#alert-danger').delay(3000).fadeOut();

        var slider = document.getElementById("myRange");
        var output = document.getElementById("dropsPerHourSliderRange");
        output.value = slider.value;

        slider.oninput = function() {
            output.value = this.value;
        }

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
function getListenAudioLink(id){
        $('#recordingContent').find('button').removeClass('border-error');
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
                // audio.play(); //call this to play the song right away
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
                // audio.play(); //call this to play the song right away
        }});
    }
    function getListenOptinAudioLink(id){
        $.ajax({
                url: '{{url('user/listen-recording')}}',
                contentType: "application/json; charset=utf-8",
                data:{recording_id: id},
                success: function(result){
                // $("#div1").html(result);
                $('#listen_optin_section').show();
                var audio = document.getElementById('optin_audio');

                var source = document.getElementById('optinAudioSource');
                source.src = result;

                audio.load(); //call this to just preload the audio without playing
                // audio.play(); //call this to play the song right away
        }});
    }
// function fetchBotData(value){
//     // $('#campaign_type').removeClass('border-error');
//     $('#campaignTypeDiv').find('button').removeClass("border-error");
//     $('#bot_dropdown').find('button').removeClass("border-error");
//     if(value ==="bot"){
//         $('#bot_dropdown').show();
//         $('#randomRadioBtn').hide();
//         $('#randomLabel').hide();

//         $('#bot_type').empty();
//         $.ajax({
//             url: '{{url('user/campaigns/get_all_bot')}}',
//             contentType: "application/json; charset=utf-8",
//             //data:{bot: bot},
//             success: function(result){
//                 if(result.length > 0){
//                 $('#bot_type').attr('required',true);
//                 $('#bot_type').append('<option value="" selected disabled>Select Bot</option>');
//                 for(let i=0;i<result.length;i++){
//                     $('#bot_type').append('<option value="'+result[i].id+'">'+result[i].bot_name+'</option>');
//                 }
//                     $('#bot_type').selectpicker('refresh');
//                 }

//         }});

//     }else{
//         $('#bot_dropdown').hide();
//         $('#bot_type').attr('required',false);
//     }
//     if(value ==="press-1"){
//         $('#randomRadioBtn').show();
//         $('#press-1_fields').show();
//         $('#randomLabel').show();
//         $('#optoutRecordingContent').show();
//         $('#transfer_to_number').attr('required', true);
//         $('#opt_in_number').attr('required', true);
//         $('#opt_out_number').attr('required', true);
//         // $('#alpha').hide();
//         // $('#alpha_notes').hide();
//         $('#optoutRecordingContent').show();
//         $('#optout_recording').attr('required', true);
//     }
//     else{
//         $('#random_content').css('display','none');
//         $('#press-1_fields').hide();
//         $('#randomRadioBtn').hide();
//         $('#randomLabel').hide();
//         $('#transfer_to_number').attr('required', false);
//         $('#opt_in_number').attr('required', false);
//         $('#opt_out_number').attr('required', false);
//         // $('#alpha').show();
//         // $('#alpha_notes').show();
//         $('#optoutRecordingContent').hide();
//         $('#optout_recording').attr('required', false);
//     }
// }

// function callerIdButtonChange(value){
//    if(value === "random"){
//      $('#random_content').css('display','block');
//      $('#caller_id_random').attr('required',true);
//    }else{
//     $('#random_content').css('display','none');
//    }
//    $('#testApiCallFromNumber').val('');
//  }

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

    if(campaignId !== null & campaignId === "press-1"){
        var optinRecording = $('#optin_recording option:selected').val();
        if(optinRecording === null || optinRecording ===  ''){
            alert('Please select optin recording');
            return false;
        }
        var optoutRecording = $('#optout_recording').val();
        if(optoutRecording == null || optoutRecording ===  ''){
            alert('Please select optout recording');
            return false;
        }
    }

    let ajaxData = new FormData();
    ajaxData.append( 'number_from', $( '#testApiCallFromNumber' ).val());
    ajaxData.append( 'number_to', $( '#testApiCallToNumber' ).val());
    ajaxData.append( 'slug', campaignId);
    ajaxData.append( 'alpha_from', '');

    if(campaignId !== null & campaignId === "press-1"){
        ajaxData.append( 'recording_id', recording);
        ajaxData.append( 'optout_recording', optoutRecording);
        ajaxData.append( 'optin_recording', $('#optin_recording option:selected').val());
        ajaxData.append( 'opt_in_number',  $('#opt_in_number').val());
        ajaxData.append( 'opt_out_number',  $('#opt_out_number').val());
        ajaxData.append( 'transfer_to_number',  $('#transfer_to_number').val());
    }else{
        ajaxData.append( 'recording_id', recording);
    }


    $.ajax({
      type: 'POST',
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      contentType: false,
      processData:false,
      url: (campaignId !== null & campaignId === "press-1") ? document.getElementById('press1TestCallApiUrl').value : document.getElementById('testCallApiUrl').value,
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

    // function loader()
    // {

    //     $('#loader-modal').modal('show');
    //     // var seconds = 0;
    //     // var el = document.getElementById('seconds-counter');

    //     // function incrementSeconds() {
    //     // seconds += 1;
    //     // el.innerText = "Your Campaign is adding since " + seconds + " seconds.";
    //     // }

    //     // var cancel = setInterval(incrementSeconds, 1000);
    // }

    // function contactListLoader()
    // {
    //    $('#loader-modal-contact-list').modal({
    //         backdrop: 'static',
    //         keyboard: false
    //     });
    //   $('#add_contact_list_modal').modal('hide');
    //   $('#loader-modal-contact-list').modal('show');


    //     // $('.spin').show();
    //     // var seconds = 0;
    //     // var el = document.getElementById('seconds-counter-contact-list');

    //     // function incrementSeconds() {
    //     //   seconds += 1;
    //     //   el.innerText = "Your Contact List is adding since " + seconds + " seconds.";
    //     // }

    //     // var cancel = setInterval(incrementSeconds, 1000);

    // }

    // function recordingLoader()
    // {
    //   $('#loader-modal-recording').modal({
    //         backdrop: 'static',
    //         keyboard: false
    //     });
    //     // $('.spin').show();
    //     $('#add_recording_modal').modal('hide');
    //     $('#loader-modal-recording').modal('show');

    //     var seconds = 0;
    //     var el = document.getElementById('seconds-counter-recording');

    //     function incrementSeconds() {
    //     seconds += 1;
    //     el.innerText = "Your Recording is adding since " + seconds + " seconds.";
    //     }

    //     var cancel = setInterval(incrementSeconds, 1000);
    // }
    // function optoutRecordingLoader()
    // {
    //   $('#loader-modal-optout-recording').modal({
    //         backdrop: 'static',
    //         keyboard: false
    //     });
    //     // $('.spin').show();
    //     $('#add_optout_recording_modal').modal('hide');
    //     $('#loader-modal-optout-recording').modal('show');

    //     // var seconds = 0;
    //     // var el = document.getElementById('seconds-counter-optout-recording');

    //     // function incrementSeconds() {
    //     //   seconds += 1;
    //     //   el.innerText = "Your Recording is adding since " + seconds + " seconds.";
    //     // }

    //     // var cancel = setInterval(incrementSeconds, 1000);
    // }

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

      if(parseInt(value) > 10000000 || parseInt(value) < 2000 ){

        alert('Range must be from 2000 to 10000000');
        $('#myRange').val('2000');
        $('#dropsPerHourSliderRange').val('2000')
        // $('#demo').text('0');
      }else{
        $('#myRange').val(value);
        // $('#demo').text(value);
      }

      // $('#myRange').slider('refresh');
    }


    // function createContactList(e){
    //     e.preventDefault();
    //     if($( '#campaignContactListName' ).val() === '')
    //     {
    //         alert('List Name is required');
    //         return;
    //     }
    //     if($( '#campaignContactListFile' )[0].files.length === 0){
    //         alert('File is required');
    //         return;
    //     }
    //     contactListLoader();

    //     let ajaxData = new FormData();
    //     ajaxData.append( 'name', $( '#campaignContactListName' ).val());
    //     ajaxData.append( 'file', $( '#campaignContactListFile' )[0].files[0]);

    //     $('#recipient').empty();

    //     $.ajax({
    //         type: 'POST',
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         contentType: false,
    //         processData:false,
    //         url: document.getElementById('contactListStoreUrl').value,
    //         data: ajaxData,
    //         success: function (data) {

    //             $('#campaignContactListName' ).val('');
    //             $('#campaignContactListFile' ).val('');
    //             setTimeout(function () {
    //                 $('#loader-modal-contact-list').modal('hide');
    //             }, 1000);
    //             // $('#recipient').append('<option Selected disabled>Click to select Recording for RVM</option>');
    //             var response = data['contactList'];
    //             if(response !== null){
    //                 for(let i=0;i<response.length;i++){
    //                     $('#recipient').append('<option value="'+response[i].id+'">'+response[i].name+'</option>')
    //                 }
    //             }else{
    //                 alert('contact list not added');
    //             }
    //             $('#recipient').selectpicker('refresh');
    //             console.log('Submission was successful.');
    //             $('#add_contact_list_modal').modal('hide');

    //         },
    //         error: function (data) {
    //             console.log('An error occurred.');
    //             console.log(data);
    //         },
    //     });
    // }
    // function addRecording(e)
    // {
    //     e.preventDefault();
    //     if($( '#recordingCampaignFormName' ).val() === '')
    //     {
    //         alert('Name is required');
    //         return;
    //     }
    //     if($( '#recordingCampaignFormFile' )[0].files.length === 0){
    //         alert('File is required');
    //         return;
    //     }
    //     recordingLoader();
    //     let ajaxData = new FormData();
    //     ajaxData.append( 'name', $( '#recordingCampaignFormName' ).val());
    //     ajaxData.append( 'file', $( '#recordingCampaignFormFile' )[0].files[0]);

    //     $('#recording').empty();

    //     $.ajax({
    //         type: 'POST',
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         contentType: false,
    //         processData:false,
    //         url: document.getElementById('recordingStoreUrl').value,
    //         data: ajaxData,
    //         success: function (data) {

    //             $('#recordingCampaignFormName' ).val('');
    //             $('#recordingCampaignFormFile' ).val('');

    //             setTimeout(function () {
    //             $('#loader-modal-recording').modal('hide');
    //         }, 1000);

    //             $('#recording').append('<option Selected disabled>Click to select Recording for RVM</option>');
    //             var response = data['recording'];
    //             if(response !== null){
    //                 for(let i=0;i<response.length;i++){
    //                 $('#recording').append('<option value="'+response[i].id+'">'+response[i].name+'</option>')
    //                 }
    //             }else{
    //             alert('recording not added');
    //             }
    //             $('#recording').selectpicker('refresh');
    //             console.log('Submission was successful.');
    //             // console.log(data);
    //             $('#add_recording_modal').modal('hide');
    //         },
    //         error: function (data) {
    //             console.log('An error occurred.');
    //             console.log(data);
    //         },
    //     });
    // }

    // function addOptoutRecording(e)
    // {
    //     e.preventDefault();
    //     if($( '#optoutRecordingCampaignFormName' ).val() === '')
    //     {
    //     alert('Name is required');
    //     return;
    //     }

    //     if($('#optoutRecordingCampaignFormFile' )[0].files.length === 0){
    //     alert('File is required');
    //     return;
    //     }
    //     optoutRecordingLoader();
    //     let ajaxData = new FormData();
    //     ajaxData.append( 'name', $( '#optoutRecordingCampaignFormName' ).val());
    //     ajaxData.append( 'file', $( '#optoutRecordingCampaignFormFile' )[0].files[0]);

    //     $('#optout_recording').empty();

    //     $.ajax({
    //         type: 'POST',
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         contentType: false,
    //         processData:false,
    //         url: document.getElementById('recordingStoreUrl').value,
    //         data: ajaxData,
    //         success: function (data) {

    //             $('#optoutRecordingCampaignFormName' ).val('');
    //             $('#optoutRecordingCampaignFormFile' ).val('');

    //             setTimeout(function () {
    //             $('#loader-modal-optout-recording').modal('hide');
    //         }, 1000);

    //             $('#optout_recording').append('<option Selected disabled>Click to select optout Recording for RVM</option>');
    //             var response = data['recording'];
    //             if(response !== null){
    //                 for(let i=0;i<response.length;i++){
    //                 $('#optout_recording').append('<option value="'+response[i].id+'">'+response[i].name+'</option>')
    //                 }
    //             }else{
    //             alert('recording not added');
    //             }
    //             $('#optout_recording').selectpicker('refresh');
    //             console.log('Recording added successfully.');
    //             // console.log(data);
    //             $('#add_optput_recording_modal').modal('hide');
    //         },
    //         error: function (data) {
    //             console.log('An error occurred.');
    //             console.log(data);
    //         },
    //     });
    // }
    // function getListenAudioLink(id){
    //     $('#recordingContent').find('button').removeClass('border-error');
    //     $.ajax({
    //             url: '{{url('user/listen-recording')}}',
    //             contentType: "application/json; charset=utf-8",
    //             data:{recording_id: id},
    //             success: function(result){
    //             // $("#div1").html(result);
    //             $('#listen_section').show();
    //             var audio = document.getElementById('audio');

    //             var source = document.getElementById('audioSource');
    //             source.src = result;

    //             audio.load(); //call this to just preload the audio without playing
    //             audio.play(); //call this to play the song right away
    //     }});
    // }
    // function getListenOptoutAudioLink(id){
    //     $.ajax({
    //             url: '{{url('user/listen-recording')}}',
    //             contentType: "application/json; charset=utf-8",
    //             data:{recording_id: id},
    //             success: function(result){
    //             // $("#div1").html(result);
    //             $('#listen_optout_section').show();
    //             var audio = document.getElementById('optout_audio');

    //             var source = document.getElementById('optoutAudioSource');
    //             source.src = result;

    //             audio.load(); //call this to just preload the audio without playing
    //             audio.play(); //call this to play the song right away
    //     }});
    // }
    // function campaignTimeShow()
    // {
    //     // let select = $('select').selectpicker({size:10});
    //     $('#later_date').show();
    //     $('#campaignTimeInput').attr('required', true);
    // }

    // function campaignTimeHide()
    // {
    //     let select = $('select').selectpicker({size:10});
    //     $('#later_date').hide();
    //     select.attr('required', false);
    // }
    function opt_Val()
    {

        var opt_in = $('#opt_in_number').val();
        var opt_out = $('#opt_out_number').val();

        if (opt_in !== ""){
            $('#optInDiv').find('button').removeClass("border-error");
        }
        if (opt_out !== ""){
            $('#optOutDiv').find('button').removeClass("border-error");
        }

        if (opt_in !== "" && opt_out !== "") {

            if (opt_in == opt_out) {
                alert('Opt Out Number Must be different From Opt In Number');
                $('#opt_out_number').selectpicker('val','');
            }
        }
    }
    function closeAlert()
    {
        $('#alert-success').css('display','none');
        $('#alert-danger').css('display','none');
    }
</script>
@endsection
