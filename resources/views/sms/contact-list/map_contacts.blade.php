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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">Map Contacts</h4>
                            <span class="sub-title ml-sm-25 pl-sm-25"> </span>
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
                            
                        </div>
                    </div>
                    <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30 mt-30">
                        <form method="POST" enctype="multipart/form-data" action="{{route('user.sms_contact-list.mapContactsUpload')}}" id="columnMapForm">
                            @csrf
                           @if(count($header) > 0)
                               @foreach ($header as $key=>$value)
                                   <div class="input-group mb-2 col-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                            <input  id="" name="csv_header_index" value={{$key}} type="checkbox" onclick="setHeaderValue('{{$value}}','{{$key}}')">
                                            </div>
                                        </div>
                                        <input name="" type="text" disabled class="form-control" aria-label="Header Column" value={{$value}}>
                                        
                                    </div>
                               @endforeach
                               <input type="hidden" name="user_id" value="{{$user_id}}">
                               <input type="hidden" name="company_id" value="{{$company_id}}">
                               <input type="hidden" name="fileName" value="{{$fileName}}">
                               <input type="hidden" name="fileRows" value="{{$fileRows}}">
                               <input type="hidden" name="list_name" value="{{$list_name}}">
                               <input type="hidden" name="csv_phone_value" id="csv_phone_value" value="">
                               <input type="hidden" name="csv_phone_key" id="csv_phone_key" value="">
                               <input type="hidden" name="csv_first_name_value" id="csv_first_name_value" value="">
                               <input type="hidden" name="csv_first_name_key" id="csv_first_name_key" value="">
                               <input type="hidden" name="csv_last_name_value" id="csv_last_name_value" value="">
                               <input type="hidden" name="csv_last_name_key" id="csv_last_name_key" value="">
                               <button type="button" onclick="checkColumn(event)" class="btn btn-primary" style="background-color: #003B76">Add Contact List</button>
                           @endif
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>


<script>
    
    $(document).ready(function() {
        $('#alert-success').delay(7000).fadeOut();
        $('#alert-danger').delay(7000).fadeOut();
    // if(session('success'))
    //     var toast = $('.toast').toast({
    //         animation: true,
    //         autohide: true,
    //         delay: 4000
    //     })
    //     toast.toast('show')
    //     endif
    });
    function setHeaderValue(value,key){
        let  firstNameArray = ['first_name','first name','firstname'];
        let  lastNameArray = ['last_name','last name','lastname'];
        let  phoneNameArray = ['phone','cell','number','mobile','contact'];
        let val = value.toLowerCase();
        const firstNameExists = firstNameArray.findIndex(element => {
            if (element.includes(val)) {
                return true;
            }
        });

        const lastNameExists = lastNameArray.findIndex(element => {
            if (element.includes(val)) {
                return true;
            }
        });

        const phoneNameExists = phoneNameArray.findIndex(element => {
            if (element.includes(val)) {
                return true;
            }
        });
        
        if(firstNameExists !== -1){
            $('#csv_first_name_value').val(value);
            $('#csv_first_name_key').val(key);
        }
        if(lastNameExists !== -1){
            $('#csv_last_name_value').val(value);
            $('#csv_last_name_key').val(key);
        }

        if(phoneNameExists !== -1){
            $('#csv_phone_value').val(value);
            $('#csv_phone_key').val(key);
        }
        
        // $('#csv_header_value').val(value);
    }
    function checkColumn(event){
        event.preventDefault();
        // $("input[name='[]']:checked").length === 0 && 
        if($("input[name='csv_header_index']:checked").length <3){
            alert('Please select which option is related to phone number, first_name and last_name');
            return false;
        }else{
            $('#columnMapForm').submit();
        }
    }
</script>
@endsection