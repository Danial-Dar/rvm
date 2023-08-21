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
    <div class="px-3">
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
    </div>
    @php
    if(auth()->user()->role !== "company")
        $dncTimeURL = 'user.dnc-time.store';
    else
        $dncTimeURL = 'company.dnc-time.store';
    @endphp
    <form action="{{route($dncTimeURL)}}" method="post" enctype="multipart/form-data" style="padding: 10px 10px 10px 10px;">
      @csrf

        <div class="card">
            <div class="px-3 py-3">
                <h5>Campaign Hours</h5>
                <span class="text-muted">We will deliver your campaign between the hours you specify.</span>
            </div>
            <div class="card-body">
                <div class="row mt-20">
                    <div class="col-2">
                        <div class="form-group mb-20">
                            <input type="checkbox" class="" name="days[]" value="Monday" @if(in_array('Monday',$checkedDays)) checked @endif /> Monday
                        </div>
                    </div>
                    <div class="col-4 monDropdown" id="" @if(in_array('Monday',$checkedDays)) style="display:block;" @else style="display:none;" @endif >
                        <div class="form-group mb-20">
                            {{-- <input type="time" name="from_time" id="from_time" class="form-control" placeholder="From Time" onchange="setTime()"> --}}
                            <select name="from_time[]" class="form-control" id="mon_from_time" onchange="setTime('mon')">
                                <option value="">Select From Time</option>
                                @foreach ($timeArray as $key=>$value)
                                    <option value={{$key}} @if(isset($fromTime['Monday']) && $fromTime['Monday'] ==  $key) selected @endif>{{$value}}</option>
                                @endforeach
                                {{-- <option value="00:00">12:00 AM</option>
                                <option value="00:30">12:30 AM</option>
                                <option value="01:00">01:00 AM</option>
                                <option value="01:30">01:30 AM</option>
                                <option value="02:00">02:00 AM</option>
                                <option value="02:30">02:30 AM</option>
                                <option value="03:00">03:00 AM</option>
                                <option value="03:30">03:30 AM</option>
                                <option value="04:00">04:00 AM</option>
                                <option value="04:30">04:30 AM</option>
                                <option value="05:00">05:00 AM</option>
                                <option value="05:30">05:30 AM</option>
                                <option value="06:00">06:00 AM</option>
                                <option value="06:30">06:30 AM</option>
                                <option value="07:00">07:00 AM</option>
                                <option value="07:30">07:30 AM</option>
                                <option value="08:00">08:00 AM</option>
                                <option value="08:30">08:30 AM</option>
                                <option value="09:00">09:00 AM</option>
                                <option value="09:30">09:30 AM</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="10:30">10:30 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="11:30">11:30 AM</option>
                                <option value="12:00">12:00 PM</option>
                                <option value="12:30">12:30 PM</option>
                                <option value="13:00">01:00 PM</option>
                                <option value="13:30">01:30 PM</option>
                                <option value="14:00">02:00 PM</option>
                                <option value="14:30">02:30 PM</option>
                                <option value="15:00">03:00 PM</option>
                                <option value="15:30">03:30 PM</option>
                                <option value="16:00">04:00 PM</option>
                                <option value="16:30">04:30 PM</option>
                                <option value="17:00">05:00 PM</option>
                                <option value="17:30">05:30 PM</option>
                                <option value="18:00">06:00 PM</option>
                                <option value="18:30">06:30 PM</option>
                                <option value="19:00">07:00 PM</option>
                                <option value="19:30">07:30 PM</option>
                                <option value="20:00">08:00 PM</option>
                                <option value="20:30">08:30 PM</option>
                                <option value="21:00">09:00 PM</option>
                                <option value="21:30">09:30 PM</option>
                                <option value="22:00">10:00 PM</option>
                                <option value="22:30">10:30 PM</option>
                                <option value="23:00">11:00 PM</option>
                                <option value="23:30">11:30 PM</option>
                                <option value="23:59">11:59 PM</option> --}}

                            </select>

                        </div>
                    </div>
                    <div class="col-2 monDropdown" id="" @if(in_array('Monday',$checkedDays)) style="display:block;" @else style="display:none;" @endif>
                        to
                    </div>
                    <div class="col-4 monDropdown" id="" @if(in_array('Monday',$checkedDays)) style="display:block;" @else style="display:none;" @endif>
                        <div class="form-group mb-20">
                            <select name="to_time[]" class="form-control" id="mon_to_time" onchange="setTime('mon')">
                                <option value="">Select To Time</option>
                                @foreach ($timeArray as $key=>$value)
                                    <option value={{$key}} @if(isset($toTime['Monday']) && $toTime['Monday'] ==  $key) selected @endif>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>{{-- monday row end --}}
                <div class="row mt-20">
                    <div class="col-2">
                        <div class="form-group mb-20">
                            <input type="checkbox" class="" name="days[]" value="Tuesday" @if(in_array('Tuesday',$checkedDays)) checked @endif /> Tuesday
                        </div>
                    </div>
                    <div class="col-4 tueDropdown" @if(in_array('Tuesday',$checkedDays)) style="display:block;" @else style="display:none;" @endif>
                        <div class="form-group mb-20">

                            <select name="from_time[]" class="form-control" id="tue_from_time" onchange="setTime('tue')">
                                <option value="">Select From Time</option>
                                @foreach ($timeArray as $key=>$value)
                                    <option value={{$key}} @if(isset($fromTime['Tuesday']) && $fromTime['Tuesday'] ==  $key) selected @endif>{{$value}}</option>
                                @endforeach

                            </select>

                        </div>
                    </div>
                    <div class="col-2 tueDropdown" @if(in_array('Tuesday',$checkedDays)) style="display:block;" @else style="display:none;" @endif>
                        to
                    </div>
                    <div class="col-4 tueDropdown" @if(in_array('Tuesday',$checkedDays)) style="display:block;" @else style="display:none;" @endif>
                        <div class="form-group mb-20">
                            <select name="to_time[]" class="form-control" id="tue_to_time" onchange="setTime('tue')">
                                <option value="">Select To Time</option>
                                @foreach ($timeArray as $key=>$value)
                                    <option value={{$key}} @if(isset($toTime['Tuesday']) && $toTime['Tuesday'] ==  $key) selected @endif>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>{{-- tue row end --}}
                <div class="row mt-20">
                    <div class="col-2">
                        <div class="form-group mb-20">
                            <input type="checkbox" class="" name="days[]" value="Wednesday" @if(in_array('Wednesday',$checkedDays)) checked @endif /> Wednesday
                        </div>
                    </div>
                    <div class="col-4 wedDropdown" @if(in_array('Wednesday',$checkedDays)) style="display:block;" @else style="display:none;" @endif>
                        <div class="form-group mb-20">
                            <select name="from_time[]" class="form-control" id="wed_from_time" onchange="setTime('wed')">
                                <option value="">Select From Time</option>
                                @foreach ($timeArray as $key=>$value)
                                    <option value={{$key}} @if(isset($fromTime['Wednesday']) && $fromTime['Wednesday'] ==  $key) selected @endif>{{$value}}</option>
                                @endforeach

                            </select>

                        </div>
                    </div>
                    <div class="col-2 wedDropdown" @if(in_array('Wednesday',$checkedDays)) style="display:block;" @else style="display:none;" @endif>
                        to
                    </div>
                    <div class="col-4 wedDropdown" @if(in_array('Wednesday',$checkedDays)) style="display:block;" @else style="display:none;" @endif>
                        <div class="form-group mb-20">
                            <select name="to_time[]" class="form-control" id="wed_to_time" onchange="setTime('wed')">
                                <option value="">Select To Time</option>
                                @foreach ($timeArray as $key=>$value)
                                    <option value={{$key}} @if(isset($toTime['Wednesday']) && $toTime['Wednesday'] ==  $key) selected @endif>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>{{-- wed row end --}}
                <div class="row mt-20">
                    <div class="col-2">
                        <div class="form-group mb-20">
                            <input type="checkbox" class="" name="days[]" value="Thursday" @if(in_array('Thursday',$checkedDays)) checked @endif /> Thursday
                        </div>
                    </div>
                    <div class="col-4 thurDropdown" @if(in_array('Thursday',$checkedDays)) style="display:block;" @else style="display:none;" @endif>
                        <div class="form-group mb-20">
                            <select name="from_time[]" class="form-control" id="thur_from_time" onchange="setTime('thur')">
                                <option value="">Select From Time</option>
                                @foreach ($timeArray as $key=>$value)
                                    <option value={{$key}} @if(isset($fromTime['Thursday']) && $fromTime['Thursday'] ==  $key) selected @endif>{{$value}}</option>
                                @endforeach

                            </select>

                        </div>
                    </div>
                    <div class="col-2 thurDropdown" @if(in_array('Thursday',$checkedDays)) style="display:block;" @else style="display:none;" @endif>
                        to
                    </div>
                    <div class="col-4 thurDropdown" @if(in_array('Thursday',$checkedDays)) style="display:block;" @else style="display:none;" @endif>
                        <div class="form-group mb-20">
                            <select name="to_time[]" class="form-control" id="thur_to_time" onchange="setTime('thur')">
                                <option value="">Select To Time</option>
                                @foreach ($timeArray as $key=>$value)
                                    <option value={{$key}} @if(isset($toTime['Thursday']) && $toTime['Thursday'] ==  $key) selected @endif>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>{{-- thur row end --}}
                <div class="row mt-20">
                    <div class="col-2">
                        <div class="form-group mb-20">
                            <input type="checkbox" class="" name="days[]" value="Friday" @if(in_array('Friday',$checkedDays)) checked @endif /> Friday
                        </div>
                    </div>
                    <div class="col-4 friDropdown" @if(in_array('Friday',$checkedDays)) style="display:block;" @else style="display:none;" @endif>
                        <div class="form-group mb-20">
                            <select name="from_time[]" class="form-control" id="fri_from_time" onchange="setTime('fri')">
                                <option value="">Select From Time</option>
                                @foreach ($timeArray as $key=>$value)
                                    <option value={{$key}} @if(isset($fromTime['Friday']) && $fromTime['Friday'] ==  $key) selected @endif>{{$value}}</option>
                                @endforeach

                            </select>

                        </div>
                    </div>
                    <div class="col-2 friDropdown" @if(in_array('Friday',$checkedDays)) style="display:block;" @else style="display:none;" @endif>
                        to
                    </div>
                    <div class="col-4 friDropdown" @if(in_array('Friday',$checkedDays)) style="display:block;" @else style="display:none;" @endif>
                        <div class="form-group mb-20">
                            <select name="to_time[]" class="form-control" id="fri_to_time" onchange="setTime('fri')">
                                <option value="">Select To Time</option>
                                @foreach ($timeArray as $key=>$value)
                                    <option value={{$key}} @if(isset($toTime['Friday']) && $toTime['Friday'] ==  $key) selected @endif>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>{{-- fri row end --}}
                <div class="row mt-20">
                    <div class="col-2">
                        <div class="form-group mb-20">
                            <input type="checkbox" class="" name="days[]" value="Saturday" @if(in_array('Saturday',$checkedDays)) checked @endif /> Saturday
                        </div>
                    </div>
                    <div class="col-4 satDropdown" @if(in_array('Saturday',$checkedDays)) style="display:block;" @else style="display:none;" @endif>
                        <div class="form-group mb-20">
                            <select name="from_time[]" class="form-control" id="sat_from_time" onchange="setTime('sat')">
                                <option value="">Select From Time</option>
                                @foreach ($timeArray as $key=>$value)
                                    <option value={{$key}} @if(isset($fromTime['Saturday']) && $fromTime['Saturday'] ==  $key) selected @endif>{{$value}}</option>
                                @endforeach

                            </select>

                        </div>
                    </div>
                    <div class="col-2 satDropdown" @if(in_array('Saturday',$checkedDays)) style="display:block;" @else style="display:none;" @endif>
                        to
                    </div>
                    <div class="col-4 satDropdown" @if(in_array('Saturday',$checkedDays)) style="display:block;" @else style="display:none;" @endif>
                        <div class="form-group mb-20">
                            <select name="to_time[]" class="form-control" id="sat_to_time"  onchange="setTime('sat')">
                                <option value="">Select To Time</option>
                                @foreach ($timeArray as $key=>$value)
                                    <option value={{$key}} @if(isset($toTime['Saturday']) && $toTime['Saturday'] ==  $key) selected @endif>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>{{-- fri row end --}}
                <div class="row mt-20">
                    <div class="col-2">
                        <div class="form-group mb-20">
                            <input type="checkbox" class="" name="days[]" value="Sunday" @if(in_array('Sunday',$checkedDays)) checked @endif /> Sunday
                        </div>
                    </div>
                    <div class="col-4 sunDropdown" @if(in_array('Sunday',$checkedDays)) style="display:block;" @else style="display:none;" @endif>
                        <div class="form-group mb-20">
                            <select name="from_time[]" class="form-control" id="sun_from_time" onchange="setTime('sun')">
                                <option value="">Select From Time</option>
                                @foreach ($timeArray as $key=>$value)
                                    <option value={{$key}} @if(isset($fromTime['Sunday']) && $fromTime['Sunday'] ==  $key) selected @endif>{{$value}}</option>
                                @endforeach

                            </select>

                        </div>
                    </div>
                    <div class="col-2 sunDropdown" @if(in_array('Sunday',$checkedDays)) style="display:block;" @else style="display:none;" @endif>
                        to
                    </div>
                    <div class="col-4 sunDropdown" @if(in_array('Sunday',$checkedDays)) style="display:block;" @else style="display:none;" @endif>
                        <div class="form-group mb-20">
                            <select name="to_time[]" class="form-control" id="sun_to_time" onchange="setTime('sun')">
                                <option value="">Select To Time</option>
                                @foreach ($timeArray as $key=>$value)
                                    <option value={{$key}} @if(isset($toTime['Sunday']) && $toTime['Sunday'] ==  $key) selected @endif>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>{{-- sun row end --}}

            </div>
            <div class="form-group mb-20 ml-20 mt-10 modal-footer" style="float: right">
                <button type="submit" class="btn btn-primary">Update Campaign Hours</button>
            </div>
        </div>
        <div class="card mt-20 mb-20" >
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group mt-20">
                            <h5>Timezone</h5><br/>
                            <span class="text-muted">Note: Any time selected from drop down will block dial activity to occur at that time slot.</span>
                            <input type="text" name="timezone" id="timeZone" class="form-control mt-2" placeholder="Time Zone" value="America/Mexico_City" disabled>
                        </div>
                    </div>
                </div>
            </div>
         </div>
    </form>
</div>




{{-- <input type="hidden" id="recordingStoreUrl" value="{{route('user.recording.ajaxStore')}}"> --}}
<script>
    $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).val() === "Monday"){
                if($(this).is(":checked")){
                    $('.monDropdown').show();
                    $('#mon_from_time').attr('required',true);
                    $('#mon_to_time').attr('required',true);
                }
                else if($(this).is(":not(:checked)")){
                    $('.monDropdown').hide();
                    $('#mon_from_time').attr('required',false);
                    $('#mon_to_time').attr('required',false);
                    $('option:selected', $('#mon_from_time')).prop("selected", false);
                    $('option:selected', $('#mon_to_time')).prop("selected", false);
                }
            }else if($(this).val() === "Tuesday"){
                if($(this).is(":checked")){
                    $('.tueDropdown').show();
                    $('#tue_from_time').attr('required',true);
                    $('#tue_to_time').attr('required',true);
                }
                else if($(this).is(":not(:checked)")){
                    $('.tueDropdown').hide();
                    $('#tue_from_time').attr('required',false);
                    $('#tue_to_time').attr('required',false);
                    $('option:selected', $('#tue_from_time')).prop("selected", false);
                    $('option:selected', $('#tue_to_time')).prop("selected", false);
                }
            }else if($(this).val() === "Wednesday"){
                if($(this).is(":checked")){
                    $('.wedDropdown').show();
                    $('#wed_from_time').attr('required',true);
                    $('#wed_to_time').attr('required',true);
                }
                else if($(this).is(":not(:checked)")){
                    $('.wedDropdown').hide();
                    $('#wed_from_time').attr('required',false);
                    $('#wed_to_time').attr('required',false);
                    $('option:selected', $('#wed_from_time')).prop("selected", false);
                    $('option:selected', $('#wed_to_time')).prop("selected", false);
                }
            }else if($(this).val() === "Thursday"){
                if($(this).is(":checked")){
                    $('.thurDropdown').show();
                    $('#thur_from_time').attr('required',true);
                    $('#thur_to_time').attr('required',true);
                }
                else if($(this).is(":not(:checked)")){
                    $('.thurDropdown').hide();
                    $('#thur_from_time').attr('required',false);
                    $('#thur_to_time').attr('required',false);
                    $('option:selected', $('#thur_from_time')).prop("selected", false);
                    $('option:selected', $('#thur_to_time')).prop("selected", false);
                }
            }else if($(this).val() === "Friday"){
                if($(this).is(":checked")){
                    $('.friDropdown').show();
                    $('#fri_from_time').attr('required',true);
                    $('#fri_to_time').attr('required',true);
                }
                else if($(this).is(":not(:checked)")){
                    $('.friDropdown').hide();
                    $('#fri_from_time').attr('required',false);
                    $('#fri_to_time').attr('required',false);
                    $('option:selected', $('#fri_from_time')).prop("selected", false);
                    $('option:selected', $('#fri_to_time')).prop("selected", false);
                }
            }else if($(this).val() === "Saturday"){
                if($(this).is(":checked")){
                    $('.satDropdown').show();
                    $('#sat_from_time').attr('required',true);
                    $('#sat_to_time').attr('required',true);
                }
                else if($(this).is(":not(:checked)")){
                    $('.satDropdown').hide();
                    $('#sat_from_time').attr('required',false);
                    $('#sat_to_time').attr('required',false);
                    $('option:selected', $('#sat_from_time')).prop("selected", false);
                    $('option:selected', $('#sat_to_time')).prop("selected", false);
                }
            }else if($(this).val() === "Sunday"){
                if($(this).is(":checked")){
                    $('.sunDropdown').show();
                    $('#sun_from_time').attr('required',true);
                    $('#sun_to_time').attr('required',true);
                }
                else if($(this).is(":not(:checked)")){
                    $('.sunDropdown').hide();
                    $('#sun_from_time').attr('required',false);
                    $('#sun_to_time').attr('required',false);
                    $('option:selected', $('#sun_from_time')).prop("selected", false);
                    $('option:selected', $('#sun_to_time')).prop("selected", false);
                }
            }

        });
    });
</script>
<script>
    function setTime(day){
        if(day === "mon"){
            $('#mon_from_time').attr('required',true);
            $('#mon_to_time').attr('required',true);
            if($('#mon_from_time').val() !== '' && $('#mon_to_time').val() !== ''){

                var monFromTime = $('#mon_from_time').val();
                var monToTime = $('#mon_to_time').val();

                if(monToTime <= monFromTime){
                    alert('Please select valid time.');

                    $('option:selected', $('#mon_from_time')).prop("selected", false)
                    $('option:selected', $('#mon_to_time')).prop("selected", false)
                }else{
                    return true;
                }
            }
        }else if(day === "tue"){
            $('#tue_from_time').attr('required',true);
            $('#tue_to_time').attr('required',true);
            if($('#tue_from_time').val() !== '' && $('#tue_to_time').val() !== ''){

                var tueFromTime = $('#tue_from_time').val();
                var tueToTime = $('#tue_to_time').val();

                if(tueToTime <= tueFromTime){
                    alert('Please select valid time.');
                    $('option:selected', $('#tue_from_time')).prop("selected", false)
                    $('option:selected', $('#tue_to_time')).prop("selected", false)
                }else{
                    return true;
                }
            }
        }else if(day === "wed"){
            $('#wed_from_time').attr('required',true);
            $('#wed_to_time').attr('required',true);
            if($('#wed_from_time').val() !== '' && $('#wed_to_time').val() !== ''){

                var wedFromTime = $('#wed_from_time').val();
                var wedToTime = $('#wed_to_time').val();

                if(wedToTime <= wedFromTime){
                    alert('Please select valid time.');
                    $('option:selected', $('#wed_from_time')).prop("selected", false)
                    $('option:selected', $('#wed_to_time')).prop("selected", false)
                }else{
                    return true;
                }
            }
        }else if(day === "thur"){
            $('#thur_from_time').attr('required',true);
            $('#thur_to_time').attr('required',true);
            if($('#thur_from_time').val() !== '' && $('#thur_to_time').val() !== ''){

                var thurFromTime = $('#thur_from_time').val();
                var thurToTime = $('#thur_to_time').val();

                if(thurToTime <= thurFromTime){
                    alert('Please select valid time.');
                    $('option:selected', $('#thur_from_time')).prop("selected", false)
                    $('option:selected', $('#thur_to_time')).prop("selected", false)
                }else{
                    return true;
                }
            }
        }else if(day === "fri"){
            $('#fri_from_time').attr('required',true);
            $('#fri_to_time').attr('required',true);
            if($('#fri_from_time').val() !== '' && $('#fri_to_time').val() !== ''){

                var friFromTime = $('#fri_from_time').val();
                var friToTime = $('#fri_to_time').val();

                if(friToTime <= friFromTime){
                    alert('Please select valid time.');
                    $('option:selected', $('#fri_from_time')).prop("selected", false)
                    $('option:selected', $('#fri_to_time')).prop("selected", false)
                }else{
                    return true;
                }
            }
        }else if(day === "sat"){
            $('#sat_from_time').attr('required',true);
            $('#sat_to_time').attr('required',true);
            if($('#sat_from_time').val() !== '' && $('#sat_to_time').val() !== ''){

                var satFromTime = $('#sat_from_time').val();
                var satToTime = $('#sat_to_time').val();

                if(satToTime <= satFromTime){
                    alert('Please select valid time.');
                    $('option:selected', $('#sat_from_time')).prop("selected", false)
                    $('option:selected', $('#sat_to_time')).prop("selected", false)
                }else{
                    return true;
                }
            }
        }else if(day === "sun"){
            $('#sun_from_time').attr('required',true);
            $('#sun_to_time').attr('required',true);
            if($('#sun_from_time').val() !== '' && $('#sun_to_time').val() !== ''){

                var sunFromTime = $('#sun_from_time').val();
                var sunToTime = $('#sun_to_time').val();

                if(sunToTime <= sunFromTime){
                    alert('Please select valid time.');
                    $('option:selected', $('#sun_from_time')).prop("selected", false)
                    $('option:selected', $('#sun_to_time')).prop("selected", false)
                }else{
                    return true;
                }
            }
        }




    }//function end

    // function timeSplit(val){
    //     let timeSplit = val.split(':'),
    //         hours,
    //         minutes,
    //         meridian;
    //     hours = timeSplit[0];
    //     minutes = timeSplit[1];
    //     if (hours > 12) {
    //         meridian = 'PM';
    //         hours -= 12;
    //     } else if (hours < 12) {
    //         meridian = 'AM';
    //         if (hours == 0) {
    //         hours = 12;
    //         }
    //     } else {
    //         meridian = 'PM';
    //     }
    //     let time = hours + ':' + minutes + ' ' + meridian;
    //     // let time = hours + ':' + minutes;
    //     return time;
    // }

    $('#alert-success').delay(3000).fadeOut();
    $('#alert-danger').delay(3000).fadeOut();
    function closeAlert()
    {
        $('#alert-success').css('display','none');
        $('#alert-danger').css('display','none');
    }

</script>

@endsection
