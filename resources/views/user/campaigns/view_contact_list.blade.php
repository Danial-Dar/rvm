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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">View Campaign Contact List</h4>
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
                                    <th scope="col">
                                        <span class="userDatatable-title">Name</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                    @if(count($contact_lists) > 0)
                                        @foreach($contact_lists as $list)
                                            @if(isset($list))
                                                <tr>
                                                    <td>
                                                        {{$list->name}}
                                                    </td>
                                                    <td>
                                                        <ul class="orderDatatable_actions mb-0 " style="white-space:nowrap; ">

                                                            <li style="display:inline;">
                                                                <a href="{{ route('user.campaign.showContactListStatus', ['contact_list_id'=>$list->id,'campaign_id'=>$campaign->id]) }}" class="edit" id="view-list"  ><span data-feather="eye" data-toggle="tooltip" data-placement="bottom" title="View List"></span></a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endif

                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2">No Contact List Available</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
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
        "order": []
    } );
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
