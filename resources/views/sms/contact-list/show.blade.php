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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">Contact Lists View</h4>
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
                    <div class="action-btn">
                        <!-- <a href="#" class="btn px-15 btn-primary" data-toggle="modal" data-target="#add_contact_list_modal" style="background-color: #003B76"> <i class="las la-plus fs-16"></i>Upload New Contact List</a> -->
                        
                    </div>
                    <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30 mt-30">
                        <div style="float:left;margin-bottom: 5px;">
                            @if(auth()->user()->role == "user")
                                <?php 
                                    $exportURL = 'user.sms_contact-list.exportContactListContacts';
                                ?>
                            @elseif(auth()->user()->role == "admin")
                                <?php 
                                    $exportURL = 'admin.sms_contact-list.exportContactListContacts';
                                ?>
                            @endif
                            <a class="btn btn-sm btn-success" href="{{ route($exportURL, \Request::route('id')) }}" target="_blank" rel="noopener noreferrer">CSV
                            <span data-feather="download" data-toggle="tooltip" data-placement="bottom" title="Download">CSV</span></a>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr class="userDatatable-header">
                                    <th>
                                        <span class="userDatatable-title">Number</span>
                                    </th>
                                    <!-- <th>
                                        <span class="userDatatable-title"></span>
                                   </th> -->
                                     <th>
                                        <span class="userDatatable-title">Status</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $list)
                                    <tr>
                                        <td>{{$list->number}}</td>
                                        
                                        <td>
                                        <!-- <a href="" class="edit" id="view-list"  ><span data-feather="eye" data-toggle="tooltip" data-placement="bottom" title="View Contact List"></span></a> -->
                                           <div class=" d-inline-block">
                                                @if($list->status == 'deleted')
                                                    <span class="bg-danger  rounded-pill userDatatable-content-status"> Deleted </span>
                                                @elseif($list->status == 'active')
                                                    <span class="bg-success  rounded-pill userDatatable-content-status"> Active </span>
                                                @elseif($list->status == 'inactive')
                                                    <span class="bg-danger  rounded-pill userDatatable-content-status"> InActive </span>
                                                @endif
                                            </div>    
                                         </td>
                                    </tr>
                                @endforeach
                                    
                                </tbody>
                            </table>
                            {{ $data->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>


<script>
    function csvValidate()
    { 
        var fileInput = document.getElementById('file');
        var filePath = fileInput.value; 
        var allowedExtensions = /(\.csv)$/i; 
        if(!allowedExtensions.exec(filePath)){ 
            alert('Only CSV files are allowed');
            fileInput.value = ''; 
            return false; 
        }
    }

    $(document).ready(function() {
        // $('#example').DataTable( {
        //  } );
        // if(session('success'))
        //     var toast = $('.toast').toast({
        //         animation: true,
        //         autohide: true,
        //         delay: 4000
        //     })
        //     toast.toast('show')
        // endif
    }); 
</script>
@endsection