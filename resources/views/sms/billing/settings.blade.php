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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">SMS Billing Setting</h4>
                            <span class="sub-title ml-sm-25 pl-sm-25"> </span>
                            @if ($errors->any())
                                <div class="alert alert-danger" id="alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <button  style="float:right; background: none;border: none; " onclick="closeAlert()">x</button>
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(session('success'))
                                    <div class="alert alert-success" id="alert-success">
                                        <ul>
                                        <button  style="float:right; background: none;border: none; " onclick="closeAlert()" >x</button>
                                        <li>{{session('success')}}</li></ul>
                                    </div>
                            @endif
                        </div>
                    </div>
                    @if(auth()->user()->role !== "admin")
                        <div class="action-btn">
                            <a href="{{route('user.sms_campaigns.create')}}" class="btn px-15 btn-primary" style="background-color: #003B76">
                                <i class="las la-plus fs-16"></i>Add New Campaign</a>
                        </div>
                    @endif

                    <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30 mt-30">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr class="userDatatable-header">
                                    <th>
                                        <span class="userDatatable-title">Type</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Rate</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                    @foreach($sms_billing_settings as $key => $setting)
                                        <tr>
                                            <td>
                                                {{$setting->type}}
                                            </td>
                                            <td>
                                                {{$setting->rate}}
                                            </td>
                                            <td>
                                                <li style="display:inline;">
                                                    <a href="" style="display: inline-flex;" data-toggle="modal"
                                                    data-target="#change_setting{{$setting->id}}">
                                                    <span data-feather="edit" data-toggle="tooltip" data-placement="bottom" title="Update"></span></a>
                                                </li>
                                                <div class="modal fade reset_campaign" id="change_setting{{$setting->id}}" role="dialog" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content  radius-xl">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title fw-500" id="staticBackdropLabel">Change Setting</h6>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span data-feather="x"></span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.sms.billing_settings.update', ['id' => $setting->id])}}" id="campaignSendSpeedForm" method="post" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="hidden" name="id" id="campaignSendSpeedId" value="">
                                                                    <div class="form-group mb-3">
                                                                        <select class="form-control" name="type" value="{{$setting->type}}">
                                                                            <option value="PER_MESSAGE" {{$setting->type == 'PER_MESSAGE'?'selected': ''}}>PER_MESSAGE</option>
                                                                            <option value="MONTHLY"  {{$setting->type == 'MONTHLY'?'selected': ''}}>MONTHLY</option>
                                                                            <option value="INBOUND" {{$setting->type == 'INBOUND'?'selected': ''}}>INBOUND</option>
                                                                            <option value="OUTBOUND" {{$setting->type == 'OUTBOUND'?'selected': ''}}>OUTBOUND</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mb-20">
                                                                        <input class="form-control" type="number" value="{{$setting->rate}}" name="rate">
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $sms_billing_settings->appends(request()->except('page'))->links() }}
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
            "order": [],
            "bPaginate": false,
            "bInfo": false,
            searching: false,
        } );
        $('#alert-success').delay(7000).fadeOut();
        $('#alert-danger').delay(7000).fadeOut();

    });
</script>
@endsection
