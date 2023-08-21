@extends('layouts.app')
@section('content')
<div class="contents">
    <div class="container-fluid">
        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main user-member justify-content-sm-between ">
                    <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                        <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                            <h4 class="text-capitalize fw-500 breadcrumb-title">
                                @if(auth()->user()->role == "company")
                                    Company Settings
                                @else
                                    User Settings
                                @endif
                            </h4>
                            <span class="sub-title ml-sm-25 pl-sm-25"></span>
                            @if ($errors->any())
                                <div class="alert alert-danger" id="alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <button  style="float:right; background: none;border: none; " onclick="closeAlert('alert-danger')">x</button>
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(session('success'))
                                    <div class="alert alert-success" id="alert-success">
                                        <ul>
                                        <button  style="float:right; background: none;border: none; " onclick="closeAlert('alert-success')">x</button>
                                        <li>{{session('success')}}</li></ul>
                                    </div>
                            @endif
                        </div>
                    </div>
                    <div class=" global-shadow border p-30 bg-white radius-xl w-100 mb-30 mt-30">
                        <div class="modal-body" style="padding: 20px 75px 20px 75px">
                            @php
                                if(auth()->user()->role !== "company")
                                    $addSettingURL ="user.user_setting.store";
                                else
                                    $addSettingURL ="company.user_setting.store";

                            @endphp
                            <form action="{{route($addSettingURL)}}" method="POSt" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group mb-20">
                                    <label for="from_time">Daily limit</label>
                                    <input type="hidden" name="settings[daily_max_limit][label]" id="settings_daily_max_limit_label" class="form-control" value="Daily limit" >
                                    <input type="number" name="settings[daily_max_limit][value]" min="0" max="10000000" id="settings_daily_max_limit_value" class="form-control" value= "{{ $count != 0 ? isset($models['daily_max_limit']) ? $models['daily_max_limit'] : '' : '' }}" placeholder="Daily limit" required>
                                </div>
                                @if(auth()->user()->role == "company")
                                    <div class="form-group mb-20">
                                        <label for="">Rvm Call Price</label>
                                        <input type="hidden" name="settings[rvm_call_price][label]" id="settings_rvm_call_price_label" class="form-control" value="Rvm Call Price" >
                                        <input type="decimal" name="settings[rvm_call_price][value]" min="0" max="500000" id="settings_rvm_call_price_value" class="form-control" value="{{$count != 0 ? isset($models['rvm_call_price'])  ? $models['rvm_call_price'] : '' : '' }}" placeholder="Rvm Call Price">
                                    </div>

                                    <div class="form-group mb-20">
                                        <label for="">Bot Call Price</label>
                                        <input type="hidden" name="settings[bot_call_price][label]" id="settings_bot_call_price_label" class="form-control" value="Bot Call Price" >
                                        <input type="decimal" name="settings[bot_call_price][value]" min="0" max="500000" id="settings_bot_call_price_value" class="form-control" value="{{$count != 0 ? isset($models['bot_call_price']) ? $models['bot_call_price'] : '' : '' }}" placeholder="Bot Call Price">
                                    </div>

                                    <div class="form-group mb-20">
                                        <label for="">Press-1 Call Price</label>
                                        <input type="hidden" name="settings[press-1_call_price][label]" id="settings_press-1_call_price_label" class="form-control" value="Press-1 Call Price" >
                                        <input type="decimal" name="settings[press-1_call_price][value]" min="0" max="500000" id="settings_press-1_call_price_value" class="form-control" value="{{$count != 0 ? isset($models['press-1_call_price']) ? $models['press-1_call_price'] : '' : '' }}" placeholder="Press-1 Call Price">
                                    </div>
                                    <div class="form-group mb-20">
                                        <label for="">Number Price</label>
                                        <input type="hidden" name="settings[number_price][label]" id="settings_number_price_label" class="form-control" value="Number Price" >
                                        <input type="decimal" name="settings[number_price][value]" min="0" max="500000" id="settings_number_price_value" 
                                        class="form-control" value="{{$count != 0 ? isset($models['number_price']) ? $models['number_price'] : '' : '' }}" placeholder="Number Price">
                                    </div>
                                    <div class="form-group mb-20">
                                        <label for="">Per Minute Call Price</label>
                                        <input type="hidden" name="settings[per_minute_call_price][label]" id="settings_per_minute_call_price_label" class="form-control" value="Per Minute Call Price" >
                                        <input type="decimal" name="settings[per_minute_call_price][value]" min="0" max="500000" id="settings_per_minute_call_price_value" 
                                        class="form-control" value="{{$count != 0 ? isset($models['per_minute_call_price']) ? $models['per_minute_call_price'] : '' : '' }}" placeholder="Call Price">
                                    </div>
                                @endif

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" style="background-color: #003B76">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<script>

    $(document).ready(function() {
        $('#example').DataTable( {
        "order": ['1']
    } );
        $('#alert-success').delay(7000).fadeOut();
        $('#alert-danger').delay(7000).fadeOut();
    });
    function closeAlert(id)
    {
        document.getElementById(id).style.display = "none";
    }
</script>
@endsection
