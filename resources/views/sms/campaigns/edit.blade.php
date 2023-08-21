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
 .cursor-pointer{
    cursor: pointer;
}
#message{
    border: 2px solid #ccc;
    border-radius: 8px;
}
.character-container {
    justify-content: flex-end;
    width: 50%;
    display: flex;
}
.modal-backdrop {
    z-index: 10000;
}
.my-badge {
  display: inline-block;
  padding: 0.25em 0.4em;
  font-size: 75%;
  font-weight: 700;
  line-height: 1;
  text-align: center;
  white-space: nowrap;
  vertical-align: baseline;
  border-radius: 0.25rem;
  transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.none {
    display: none;
}
.message-window{
    padding: 4px 9px;
    display: inline-block;
    max-width: 60%;
    background: #d7d7d7;
    margin: 15px 0 15px;
    border-radius: 12px;
}
.btn.btn-light1 {
    background: #dcdcdc;
}
.w-1-2{
    width: 50%;
}
.randomizer, .shortcode {
    font-size: 11px;
    padding-top: 4px;
    margin-bottom: 3px;
}
textarea.form-control:focus {
    box-shadow: none;
}
.onoffswitch1 {
    position: relative;
    width: 100px;
    -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
}

.onoffswitch1-checkbox {
    display: none;
}

.onoffswitch1-label {
    display: block; overflow: hidden; cursor: pointer;
    border: 2px solid #999999; border-radius: 30px;
    position: relative;
}

.onoffswitch1-inner {
    display: block; width: 200%; margin-left: -100%;
    -moz-transition: margin 0.1s ease-in 0s; -webkit-transition: margin 0.1s ease-in 0s;
    -o-transition: margin 0.1s ease-in 0s; transition: margin 0.1s ease-in 0s;
}

.onoffswitch1-inner:before, .onoffswitch1-inner:after {
    display: block; float: left; width: 50%; height: 30px; padding: 0; line-height: 30px;
    font-size: 14px; color: white; font-family: Trebuchet, Arial, sans-serif; font-weight: bold;
    -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;
    border-radius: 30px;
    box-shadow: 0px 15px 0px rgba(0,0,0,0.08) inset;
}

.onoffswitch1-inner:before {
    content: "Edit";
    padding-left: 10px;
    background-color: #007bff; color: #FFFFFF;
    border-radius: 30px 0 0 30px;
}

.onoffswitch1-inner:after {
    content: "Preview";
    padding-right: 10px;
    background-color: #EEEEEE; color: #999999;
    text-align: right;
    border-radius: 0 30px 30px 0;
}

.onoffswitch1-switch {
    display: block; width: 30px; margin: 0px;
    background: #FFFFFF;
    border: 2px solid #999999; border-radius: 30px;
    position: absolute; top: 0; bottom: 0;
    right: 66px;
    -moz-transition: all 0.1s ease-in 0s; -webkit-transition: all 0.1s ease-in 0s;
    -o-transition: all 0.1s ease-in 0s; transition: all 0.1s ease-in 0s;
    background-image: -moz-linear-gradient(center top, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0) 80%);
    background-image: -webkit-linear-gradient(center top, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0) 80%);
    background-image: -o-linear-gradient(center top, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0) 80%);
    background-image: linear-gradient(center top, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0) 80%);
    box-shadow: 0 1px 1px white inset;
}

.onoffswitch1-checkbox:checked + .onoffswitch1-label .onoffswitch1-inner {
    margin-left: 0;
}

.onoffswitch1-checkbox:checked + .onoffswitch1-label .onoffswitch1-switch {
    right: 0px;
}
div.checkbox.switcher label, div.radio.switcher label {
  padding: 0;
}
div.checkbox.switcher label *, div.radio.switcher label * {
  vertical-align: middle;
}
div.checkbox.switcher label input, div.radio.switcher label input {
  display: none;
}
div.checkbox.switcher label input + span, div.radio.switcher label input + span {
  position: relative;
  display: inline-block;
  margin-right: 10px;
  width: 56px;
  height: 28px;
  background: #f2f2f2;
  border: 1px solid #eee;
  border-radius: 50px;
  transition: all 0.3s ease-in-out;
}
div.checkbox.switcher label input + span small, div.radio.switcher label input + span small {
  position: absolute;
  display: block;
  width: 50%;
  height: 100%;
  background: #fff;
  border-radius: 50%;
  transition: all 0.3s ease-in-out;
  left: 0;
}
div.checkbox.switcher label input:checked + span, div.radio.switcher label input:checked + span {
  background: #269bff;
  border-color: #269bff;
}
div.checkbox.switcher label input:checked + span small, div.radio.switcher label input:checked + span small {
  left: 50%;
}

</style>
<div class="contents" style="padding-top: 120px !important;">
    <form id="campaignUpdateForm" action="{{route('user.sms_campaign.update',['id'=>$campaign->id])}}" method="post" enctype="multipart/form-data" style="padding: 10px 10px 10px 10px;" onsubmit="loader()">
        @csrf
      <h5>Edit SMS Campaign</h5>
      <input type="hidden" name="has_banned_words" id="has_banned_words" value="0">
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
                        <p>Message Builder</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-4" style="pointer-events:none;" id="step4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
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
                            <select name="campaign_type" id="campaign_type" class="form-control selectpicker" required>
                                <option value="" selected disabled>Select campaign Type</option>
                                <option value="{{$campaign->campaign_type}}" selected>{{$campaign->campaign_type}}</option>
                            </select>
                        </div>

                        <label>Campaign Name</label>
                        <div class="form-group mb-20">
                            <input type="text" name="campaign_name" id="campaign_name" class="form-control" placeholder="Campaign Name"
                             onkeyup="$('#campaign_name').val() !== '' ? $('#campaign_name').removeClass('border-error') : $('#campaign_name').addClass('border-error')"
                             value="{{$campaign->campaign_name}}" autofocus onfocus="var temp_value=this.value; this.value=''; this.value=temp_value" required>
                        </div>
                        <label>Caller Id Forward To Number</label>
                        <div class="row" id="forward_number_content">
                            <div class="col-12">
                                <div class="form-group mb-20">
                                    <input type="text"  minlength="14" maxlength="14" name="forward_number" id="forward_number"
                                    placeholder="Add Caller Id Forward To Number (XXX) XXX-XXX"
                                    class="form-control mask_input" required
                                    onkeyup="$('#forward_number').val() !== '' ? $('#forward_number').removeClass('border-error') : $('#forward_number').addClass('border-error')"
                                    autofocus value="{{$campaign->forward_to_sms_number}}">
                                </div>
                            </div>
                        </div>
                        {{-- forward number end --}}
                        <label>Receive Response</label>
                        <div class="form-group mb-20 mt-20" id="campaignResponseDiv">
                            <select name="receive_response" id="receive_response" class="form-control selectpicker" required>
                                <option value="" selected disabled>Select Receive Response</option>
                                <option value="{{$campaign->receive_response}}" selected>{{$campaign->receive_response}}</option>
                            </select>
                        </div>
                        <label>Domain URL</label>
                        <div class="form-group mb-20">
                            <input type="text" name="domain_url" id="domain_url" class="form-control" placeholder="Domain URL"
                             onkeyup="$('#domain_url').val() !== '' ? $('#domain_url').removeClass('border-error') : $('#domain_url').addClass('border-error')" required
                             onfocus="var temp_value=this.value; this.value=''; this.value=temp_value" value="{{$campaign->domain_url}}">
                        </div>
                        <button class="btn btn-primary nextBtn pull-right" type="button" style="float:right;">Next</button>
                    </div>
                </div>
            </div>
            {{-- step 1 completed --}}
            {{-- step 2 --}}
            <div class="row setup-content" id="step-2">
                <div class="col-md-12">
                    <div class="col-md-12" >
                        <div>
                            <h5 style="color:#4e4d4dd6" class="mt-10"> 2. Select List of Contacts</h5>
                            <div class="form-group mb-20 mt-20" id="contactListContent">
                                <select name="recipient[]" id="recipient" class="form-control selectpicker" multiple required disabled>
                                    @foreach($contact_lists as $list)
                                        @if($campaign->sms_contact_list_id !== null && in_array($list->id,$campaign->sms_contact_list_id))
                                            <option value="{{$list->id}}" selected>{{$list->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer mt-10">
                            <button class="btn btn-primary prevBtn pull-right" type="button" style="">Previous</button>
                            <button class="btn btn-primary nextBtn pull-right" type="button" style="">Next</button>
                        </div>
                        {{-- <button class="btn btn-primary nextBtn pull-right" type="button" style="float: right">Next</button> --}}
                    </div>
                </div>
            </div>
            {{-- step 2 completed --}}
            {{-- step 3 start --}}
            <div class="row setup-content" id="step-3">
                <div class="col-md-12">
                    <h5 class="mt-10" style="color:#4e4d4dd6"> 3. Message Builder</h5>
                    <div class="mb-2">
                        <div class="onoffswitch1">
                            <input type="checkbox" name="onoffswitch1" class="onoffswitch1-checkbox" id="myonoffswitch1" checked>
                            <label class="onoffswitch1-label" for="myonoffswitch1">
                                <span class="onoffswitch1-inner"></span>
                                <span class="onoffswitch1-switch"></span>
                            </label>
                        </div>
                    </div>
                    <div id="message-preview-container" class="none">
                        <div class="message-window">
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" id="regenrate-sytax">generate spintax</button>
                        </div>
                    </div>
                    <div id="message-edit-container">
                        <div class="form-group mb-1">
                            <textarea name="message" id="message" rows="12" cols="12" class="form-control" required
                            onkeyup="$('#message').val() !== '' ? $('#message').removeClass('border-error') : $('#message').addClass('border-error')">{{$campaign->message}}</textarea>
                        </div>
                        <div class="character-container">
                            <div>
                                <p class="ml-2"><span id="character_length">{{strlen($campaign->message)}}</span>/<span id="total_character_length">160</span></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="w-1-2 d-flex flex-wrap">
                                <button class="shortcode btn btn-light1 btn-rounded btn-sm" type="button" val="FNAME">FNAME</button>
                                <button class="ml-1 shortcode btn btn-light1 btn-rounded btn-sm" type="button" val="LNAME">LNAME</button>
                                <button class="ml-1 randomizer btn btn-light1 btn-rounded btn-sm" type="button" val="Words Randomizer Syntax">Words Randomizer Syntax</button>
                                <button class="ml-1 shortcode btn btn-light1 btn-rounded btn-sm" type="button" val="DOMAIN">DOMAIN</button>
                            </div>
                            <div class="w-1-2 d-flex flex-wrap">
                                <button class="shortcode btn btn-light1 btn-rounded btn-sm" type="button" val="Custom1">Custom1</button>
                                <button class="ml-1 shortcode btn btn-light1 btn-rounded btn-sm" type="button" val="Custom2">Custom2</button>
                                <button class="ml-1 shortcode btn btn-light1 btn-rounded btn-sm" type="button" val="Custom3">Custom3</button>
                                <button class="ml-1 shortcode btn btn-light1 btn-rounded btn-sm" type="button" val="Email">Email</button>
                            </div>
                        </div>
                        {{-- <p>Please add variations with comma seperated</p>
                        <div class="form-group d-flex" id="">
                            <input type="text" class="form-control" id="message_variations" name="message_variations" value="{{$campaign->variations}}" placeholder="Please add variations with comma seperated." />
                        </div> --}}
                        <div class="form-group d-flex" id="allow_long_message_div">
                            <div class="checkbox switcher" id="allow_long_message_container">
                                <label for="allow_long_message">
                                    <input type="checkbox"  class="custom-control-input" id="allow_long_message" name="allow_long_message" value="Yes" style="width:15px;box-shadow:none;"
                                    @if($campaign->allow_long_message) checked @endif />
                                  <span><small></small></span>
                                  <small>Allow Long Messages You'll be billed for 1
                                    message per 160 Characters.</small>
                                </label>
                              </div>
                        </div>
                        <div class="form-group d-flex" >
                            <div class="alert alert-danger" id="message_errors" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="modal-footer mt-10">
                        <button class="btn btn-primary prevBtn pull-right" type="button" style="">Previous</button>
                        <button class="btn btn-primary nextBtn pull-right" type="button" style="">Next</button>
                    </div>
                </div>
            </div>
            {{-- step 3 completed --}}
            {{-- step 4 start --}}
            <div class="row setup-content" id="step-4">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <h5 class="mt-10" style="color:#4e4d4dd6"> 4. Send Speed</h5>
                        <div class="form-group mb-20">
                        <div class="slidecontainer">
                            <input type="range" min="2000" max="10000000" value="{{$campaign->drops_per_hour}}" class="slider" name="drops_per_hour" id="myRange" >

                            <p>Messages Per Hour: <strong> <input class="form-control" type="number" max="10000000" value="{{$campaign->drops_per_hour}}"
                                onchange ="updateDropsPerHourSliderRangeValue(this.value)" name="" id="dropsPerHourSliderRange"> </strong></p>
                        </div>
                        </div>

                        <div class="modal-footer mt-10">
                            <button class="btn btn-primary prevBtn pull-right" type="button" style="">Previous</button>
                            <button class="btn btn-primary nextBtn pull-right" type="button" style="">Next</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- step 4 completed --}}
            {{-- step 5 start --}}
            <div class="row setup-content" id="step-5">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <h5 class="mt-10" style="color:#4e4d4dd6"> 5. Update Campaign</h5>
                        <div class="form-group mb-20 ml-20 mt-20">
                            <button class="btn btn-primary prevBtn mr-20" type="button" style="">Previous</button>
                            <button type="button" onclick="submitForm()" class="btn btn-primary mr-20">Update</button>
                        </div>

                    </div>
                </div>
            </div>
            {{-- step 5 completed --}}
        </div>
      </div>
    </form>
    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" id="randomizer-modal" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h4>Words Randomizer Syntax</h4>
                </div>
                <div class="modal-body">
                    <div class="mb-5"><p>Randomize words in your Ad Text to improve campaign performance by using syntax <br>
                    @{{{word1|word2|word3}}}</p>
                </div>
                <div>
                    <div>Example</div>
                    <div>Hi, we have a great @{{{gift|offer|discount}}} for you</div>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-randomizer" class="btn btn-primary">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>


<input type="hidden" id="getSmsBannedWordURL" value="{{route('user.get_banned_words')}}">

<script>
    var has_banned_words = 0;
    $(document).ready(function () {
        if($('#allow_long_message').val().length > 160){
            $('#allow_long_message_container').show()
        }else{
            $('#allow_long_message_container').hide()
        }
        $('textarea').on('change keyup paste', function(e) {
            has_banned_words = 0;
            if(this.value.length < 160){
                $('#allow_long_message_container').hide()
            }else{
                $('#allow_long_message_container').show()
                if(document.querySelector('#allow_long_message:checked') !== null){
                    $('#character_length').text(this.value.length)
                    $('#message_errors').hide();
                   return;
                }else{
                    this.value = this.value.substring(0, 160);
                }
            }
            $('#character_length').text(this.value.length)
            $('#message_errors').hide();
        });



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
                    $('#message_errors').hide();
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

                if($('#forward_number').val().length < 14){
                    isValid = false;
                    $("#forward_number" ).addClass("border-error");
                    $('#forward_number').get(0).reportValidity();
                    return false;
                }else{
                    isValid = true;
                    $( "#forward_number" ).removeClass("border-error");
                }

                if($('#receive_response').val() === null){
                    isValid = false;
                    $('#campaignResponseDiv').find('button').addClass("border-error");
                    // $('#campaign_type').focus();
                    $('#receive_response').get(0).reportValidity();
                    return false;
                }else{
                    isValid = true;
                    $('#campaignResponseDiv').find('button').removeClass("border-error");
                }

                if($('#domain_url').val() === ""){
                    isValid = false;
                    $("#domain_url" ).addClass("border-error");
                    $('#domain_url').get(0).reportValidity();
                    return false;
                }else{
                    var expression = /[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)?/gi;
                    var regex = new RegExp(expression);
                    var t = $('#domain_url').val();
                    if(t.match(regex) == null) {
                        $("#domain_url" ).addClass("border-error");
                        $('#domain_url').get(0).reportValidity();
                        return false;
                    }
                    isValid = true;
                    $( "#domain_url" ).removeClass("border-error");
                }

                if (isValid){
                    nextStepWizard.removeAttr('disabled').trigger('click');
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

                if (isValid){
                    nextStepWizard.removeAttr('disabled').trigger('click');
                }

            }

            if(curStepBtn === "step-3"){

                if($('#message').val() === ""){
                    isValid = false;
                    $("#message" ).addClass("border-error");
                    $('#message').get(0).reportValidity();
                    $('#message_errors').hide();
                    return false;
                }else{
                        let ajaxData = new FormData();
                        ajaxData.append( 'message', $('#message').val());

                        $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        contentType: false,
                        processData:false,
                        url: $('#getSmsBannedWordURL').val(),
                        data: ajaxData,
                        success: function (data) {
                            isValid = true;
                            let bannedWords = data['bannedWords'];
                            message = $("#message").val();
                            let notAllowedWords = [];
                            bannedWords.forEach(word => {
                                var regex = new RegExp('(?:^|[^\\pL0-9_])(?:' + word.word + ')(?=$|[^\\pL0-9_])', 'i');
                                var valid = !regex.test(message);
                                if(!valid) {
                                    notAllowedWords.push(word.word)
                                }
                            });
                            if(notAllowedWords.length == 0){
                                has_banned_words = 0;
                                // nextStepWizard.removeAttr('disabled').trigger('click');
                            }else{
                                has_banned_words = 1;
                            }

                            if(isValid){
                                $('#progressBar1').addClass('bg-success');
                                $('#progressBar2').addClass('bg-success');
                                $('#progressBar3').addClass('bg-success');
                                $('#progressBar4').addClass('progress-bar');
                                $('#step3').addClass('btn-success');
                                $('#step3').removeClass('btn-primary');
                            }

                            if (isValid){
                                nextStepWizard.removeAttr('disabled').trigger('click');
                            }


                        },
                        error: function (error) {
                            isValid = false;
                            $( "#message" ).addClass("border-error");
                            console.log('An error occurred.');
                            console.log(error);
                        },
                    });
                }

                // if(isValid){
                //     $('#progressBar1').addClass('bg-success');
                //     $('#progressBar2').addClass('bg-success');
                //     $('#progressBar3').addClass('bg-success');
                //     $('#progressBar4').addClass('progress-bar');
                //     $('#step3').addClass('btn-success');
                //     $('#step3').removeClass('btn-primary');
                // }

            }

            if(curStepBtn === "step-4"){

                $('#progressBar1').addClass('bg-success');
                $('#progressBar2').addClass('bg-success');
                $('#progressBar3').addClass('bg-success');
                $('#progressBar4').addClass('bg-success');
                $('#progressBar5').addClass('progress-bar');
                $('#step4').addClass('btn-success');
                $('#step4').removeClass('btn-primary');

                if (isValid){
                    nextStepWizard.removeAttr('disabled').trigger('click');
                }
            }
            if(curStepBtn === "step-5"){
                $('#progressBar1').addClass('bg-success');
                $('#progressBar2').addClass('bg-success');
                $('#progressBar3').addClass('bg-success');
                $('#progressBar4').addClass('bg-success');
                $('#progressBar5').addClass('bg-success');
                $('#step5').addClass('btn-success');
                $('#step5').removeClass('btn-primary');

                if (isValid){
                    nextStepWizard.removeAttr('disabled').trigger('click');
                }
            }

            // if(isValid){
            //     $('#progressBar1').addClass('bg-success');
            //     $('#progressBar2').addClass('progress-bar');
            //     $('#step1').addClass('btn-success');
            //     $('#step1').removeClass('btn-primary');
            // }
            // if (isValid){
            //     nextStepWizard.removeAttr('disabled').trigger('click');
            // }
        });
        $('div.setup-panel div a.btn-primary').trigger('click');

        $('.mask_input').mask('(000) 000-0000');

        $('select').selectpicker({size: '10'});

        $('.datepicker').datepicker();

        $('#datetimepicker1').datetimepicker();
        $('.selectpicker').selectpicker({size:10});

        $('#later_date').hide();
        $('#alert-success').delay(3000).fadeOut();
        $('#alert-danger').delay(3000).fadeOut();
        var slider = document.getElementById("myRange");
        var output = document.getElementById("dropsPerHourSliderRange");
        output.value = slider.value;

        slider.oninput = function() {
            output.value = this.value;
        }

    });

    function loader()
    {

        $('#loader-modal').modal('show');
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

    function closeAlert()
    {
        $('#alert-success').css('display','none');
        $('#alert-danger').css('display','none');
    }
    function submitForm()
    {
        $('#has_banned_words').val(has_banned_words);
        $('#recipient').prop('disabled', false);
        $('#campaignUpdateForm').submit();
    }
</script>

@endsection
