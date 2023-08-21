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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">Map a Column to Number</h4>
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
                        <form method="POST" enctype="multipart/form-data" action="{{route('callerid.mapContactsUpload')}}" id="columnMapForm">
                            @csrf
                           @if(count($header) > 0)
                               @foreach ($header as $key=>$value)
                                   <div class="input-group mb-2 col-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                            <input name="csv_header_index" value={{$key}} type="radio" aria-label="Radio button for following text input"
                                            onclick="setHeaderValue('{{$value}}')">
                                            </div>
                                        </div>
                                        <input name="" type="text" disabled class="form-control" aria-label="Header Column" value={{$value}}>

                                    </div>
                               @endforeach
                               <input type="hidden" name="user_id" value="{{$user_id}}">
                               <input type="hidden" name="company_id" value="{{$company_id}}">
                               <input type="hidden" name="fileName" value="{{$fileName}}">
                               <input type="hidden" name="fileRows" value="{{$fileRows}}">
                               <input type="hidden" name="csv_header_value" id="csv_header_value" value="">
                               <button type="button" onclick="checkColumn(event)" class="btn btn-primary" style="background-color: #003B76">Add Numbers From List</button>
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
    function setHeaderValue(value){
        $('#csv_header_value').val(value);
    }
    function checkColumn(event){
        event.preventDefault();
        if($("input[name='csv_header_index']:checked").length === 0){
            alert('Please select which option is related to phone number');
            return false;
        }else{
            $('#columnMapForm').submit();
        }
    }
</script>
@endsection
