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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">View Campaign Contacts</h4>
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
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr class="userDatatable-header">
                                    <th>
                                        <span class="userDatatable-title">Number</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Status</span>
                                    </th>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if($campaign_contact->isNotEmpty())
                                        @foreach($campaign_contact as $cp_contact)
                                            <tr>
                                                <td>
                                                    {{$cp_contact->number}}
                                                </td>
                                                <td>
                                                    @if(isset($contactDncArray) && count($contactDncArray) > 0)
                                                        @if(in_array($cp_contact->id,$contactDncArray))
                                                         <span class="bg-info  rounded-pill userDatatable-content-status" style="width:min-content">DNC Number</span>
                                                        @else
                                                         <span class="bg-success  rounded-pill userDatatable-content-status" style="width:min-content">{{$cp_contact->status}}</span>
                                                        @endif
                                                    @else
                                                        <span class="bg-success  rounded-pill userDatatable-content-status" style="width:min-content">{{$cp_contact->status}}</span>
                                                    @endif
                                                    {{-- @if($cp_contact->status == "pending")
                                                    <span class="bg-info  rounded-pill userDatatable-content-status" style="width:min-content">Pending</span>
                                                      @else
                                                      <span class="bg-warning color-warning rounded-pill userDatatable-content-status" style="width:min-content">No status</span>
                                                    @endif --}}
                                                </td>
                                                
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2"class="text-center">No Contacts Available</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            {{ $campaign_contact->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>


<script>
   $(document).ready(function() {
    // if(session('success'))
    // var toast = $('.toast').toast({
    //     animation: true,
    //     autohide: true,
    //     delay: 4000
    // })
    // toast.toast('show')
    // endif
    }); 
</script>
@endsection