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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">SMS Campaigns</h4>
                            <span class="sub-title ml-sm-25 pl-sm-25"> </span>
                            @if ($errors->any())
                                <div class="alert alert-danger" id="alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <button  style="float:right; background: none;border: none; " onclick="closeAlert()">
                                            x
                                        </button>
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(session('success'))
                                    <div class="alert alert-success" id="alert-success">
                                        <ul>
                                            <button  style="float:right; background: none;border: none; " onclick="closeAlert()" >
                                                x
                                            </button>
                                        <li>{{session('success')}}</li></ul>
                                    </div>
                            @endif
                        </div>
                    </div>
                    @if(auth()->user()->role !== "admin" && auth()->user()->role !== "company")
                        <div class="action-btn">
                            <a href="{{route('user.sms_campaigns.create')}}" class="btn px-15 btn-primary" style="background-color: #003B76">
                                <i class="las la-plus fs-16"></i>Add New Campaign</a>
                        </div>
                    @endif

                    <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30 mt-30">
                        @if(auth()->user()->role == "user" || auth()->user()->role == "company")
                            <?php
                                $searchURL = 'user.sms_campaigns';
                            ?>
                        @elseif(auth()->user()->role == "admin")
                            <?php
                                $searchURL = 'admin.sms_campaigns';
                            ?>
                        @endif
                        <form action="{{ route($searchURL) }}" method="get">
                            <div class="row mb-2 ml-1">
                                <input type="text" class="form-control col-2 mr-1" name="search" id="search" value={{request()->get('search')}}>

                                <button type="submit" class="btn btn-primary col-1">Search</button>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr class="userDatatable-header">
                                    <th>
                                        <span class="userDatatable-title">Campaign Name</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">User Name</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Number Of Receipents</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Status</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Type</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Send Speed</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Created At</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Last Ran</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                    @foreach($campaigns as $key => $campaign)
                                        <tr>
                                            <td>
                                                {{$campaign->campaign_name}}
                                            </td>
                                            <td>
                                                @if($campaign->user){{$campaign->user->first_name}} {{$campaign->user->last_name}}@endif
                                            </td>
                                            <td>
                                                @if($campaign->campaignStats != null)
                                                    {{$campaign->campaignStats->contact_count}}
                                                @else
                                                    N/A
                                                @endif

                                            </td>
                                            <td>

                                                @if($campaign->status == "played")
                                                    <span class="bg-opacity-info color-info rounded-pill userDatatable-content-status">Playing</span>
                                                @elseif($campaign->status == "preprocessing")
                                                        <span class="bg-opacity-success color-success rounded-pill userDatatable-content-status">Preprocessing</span>
                                                @elseif($campaign->status == "paused")
                                                        <span class="bg-opacity-warning color-warning rounded-pill userDatatable-content-status">Paused</span>
                                                @elseif($campaign->status == "inactive")
                                                        <span class="bg-opacity-danger color-danger rounded-pill userDatatable-content-status">Deleted</span>
                                                @elseif($campaign->status == "flagged")
                                                    <span class="bg-opacity-danger color-danger rounded-pill userDatatable-content-status">Flagged</span>
                                                @elseif($campaign->status == "pending")
                                                     <span class="bg-opacity-info color-info rounded-pill userDatatable-content-status">Pending</span>
                                                @elseif($campaign->status == "finished")
                                                    <span class="bg-opacity-success color-success rounded-pill userDatatable-content-status">Finished</span>
                                                @endif

                                            </td>
                                            <td>
                                                {{$campaign->campaign_type}}
                                            </td>
                                            <td>
                                                {{$campaign->drops_per_hour .' / HR'}}
                                            </td>
                                            <td>
                                                {{ Carbon\Carbon::parse($campaign->created_at)->format('m-d-Y H:i:s A') }}
                                            </td>
                                            <td>
                                                @if($campaign->campaignStats != null)
                                                    {{ isset($campaign->campaignStats->last_ran) ? Carbon\Carbon::parse($campaign->campaignStats->last_ran)->format('m-d-Y H:i:s A') : 'N/A' }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                            @if(auth()->user()->role == "user")
                                                <?php
                                                    $changeStatusURL = 'user.sms_campaigns.change_status';
                                                    $showContactListURL = 'user.sms_campaigns.showContactList';
                                                    $exportURL = 'user.sms_campaigns.exportCampaign';

                                                ?>
                                            @elseif(auth()->user()->role == "admin")
                                                <?php
                                                    $changeStatusURL = 'admin.sms_campaigns.change_status';
                                                    $showContactListURL = 'admin.sms_campaigns.showContactList';
                                                    $exportURL = 'admin.sms_campaigns.exportCampaign';
                                                ?>
                                            @endif
                                            @if(auth()->user()->role !== "company")
                                                <ul class="orderDatatable_actions mb-0 " style="white-space:nowrap; ">
                                                    <li style="display:inline;">
                                                        <a href="{{ route('user.sms_campaigns.load_conversations', ['id'=>$campaign->id]) }}" style="display: inline-flex;"><span data-feather="message-square" data-toggle="tooltip" data-placement="bottom" title="Messages"></span></a>
                                                    </li>
                                                    @if($campaign->status == "paused")
                                                        <li style="display:inline;">
                                                            <a href="{{ route($changeStatusURL, ['status'=>'resume','id'=>$campaign->id]) }}" style="display: inline-flex;"><span data-feather="play" data-toggle="tooltip" data-placement="bottom" title="Resume Campaign"></span></a>
                                                        </li>
                                                        @if(auth()->user()->role == "user")
                                                            <li style="display:inline;">
                                                                <a href="{{ route('user.sms_campaign.edit', ['id'=>$campaign->id]) }}" style="display: inline-flex;"><span data-feather="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Campaign"></span></a>
                                                            </li>
                                                        @endif
                                                    @endif
                                                    @if($campaign->status == "played" || $campaign->status == "pending")
                                                        <li style="display:inline;">
                                                            <a href="{{ route($changeStatusURL, ['status'=>'pause','id'=>$campaign->id]) }}" style="display: inline-flex;"><span data-feather="pause" data-toggle="tooltip" data-placement="bottom" title="Pause Campaign"></span></a>
                                                        </li>
                                                    @endif
                                                    @if($campaign->status != "inactive")
                                                        <li style="display:inline;">
                                                            <a href="{{ route($changeStatusURL, ['status'=>'inactive','id'=>$campaign->id]) }}" style="display: inline-flex;"><span data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Delete Campaign"></span></a>
                                                        </li>
                                                    @endif
                                                    <?php $resetStatusArray = ['preprocessing','played'];?>
                                                    @if(!in_array($campaign->status,$resetStatusArray))

                                                        <li style="display:inline;">
                                                            <a href="" style="display: inline-flex;" data-toggle="modal"
                                                            data-target="#reset_campaign{{$campaign->id}}">
                                                            <span data-feather="refresh-cw" data-toggle="tooltip" data-placement="bottom" title="Reset Campaign"></span></a>
                                                        </li>
                                                    @endif


                                                        <!-- Confirmation Modal -->
                                                        <div class="modal fade reset_campaign" id="reset_campaign{{$campaign->id}}" role="dialog" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content  radius-xl">
                                                                    <div class="modal-header">
                                                                        <h6 class="modal-title fw-500" id="staticBackdropLabel">Reset Campaign</h6>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span data-feather="x"></span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="delete_user-modal">
                                                                            <div class="form-group mb-20">
                                                                                <p>Are You Sure You Want To Reset This Campaign?</p>
                                                                            </div>
                                                                            <div class="button-group d-flex pt-25">
                                                                                <button class="btn btn-danger btn-default fw-400 btn-squared text-capitalize"><a href="{{ route($changeStatusURL, ['status'=>'reset','id'=>$campaign->id]) }}" class=" fw-400 text-capitalize" style="color: white; text-decoration: none; margin: 5px;">
                                                                                    Yes
                                                                                </a></button>
                                                                                <button data-dismiss="modal" class="btn btn-light btn-default btn-squared fw-400 text-capitalize b-light color-light">
                                                                                    cancel
                                                                                </button>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Modal Ends -->

                                                        <li style="display:inline-block;">
                                                            <a href="{{ route( $showContactListURL, $campaign->id) }}" class="edit" id="view-list"  ><span data-feather="eye" data-toggle="tooltip" data-placement="bottom" title="View Contact List"></span></a>
                                                        </li>
                                                        <li style="display:inline-block;">
                                                            <a href="{{ route($exportURL, $campaign->id) }}" target="_blank" rel="noopener noreferrer">
                                                            <span data-feather="download" data-toggle="tooltip" data-placement="bottom" title="Download CSV"></span></a>
                                                        </li>
                                                        <li style="display:inline-block;">
                                                            <a href="#" data-toggle="modal" data-target="#view_campaign_stats{{$campaign->id}}" onclick="loadStats({{$campaign->id}})">
                                                               <span data-feather="pie-chart" data-toggle="tooltip" data-placement="bottom" title="View Stats"></span>
                                                            </a>
                                                        </li>
                                                        <li style="display:inline-block;">

                                                            <a href="#" data-toggle="modal" data-target="#update_campaign_send_speed" onclick="editSendSpeed({{$campaign->id}})">
                                                               <span data-feather="activity" data-toggle="tooltip" data-placement="bottom" title="Update Send Speed"></span>
                                                            </a>

                                                        </li>
                                                </ul>
                                            @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $campaigns->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if(auth()->user()->role == "user" || auth()->user()->role == "company")
<?php
    $updateSpeedURL = 'user.sms_campaigns.update_send_speed';

?>
@elseif(auth()->user()->role == "admin")
<?php
     $updateSpeedURL = 'admin.sms_campaigns.update_send_speed';
?>
@endif
{{-- send speed modal --}}
<div class="modal fade" id="update_campaign_send_speed" tabindex="-1" role="dialog" aria-labelledby="update_campaign_send_speedTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Campaign Send Speed</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{route($updateSpeedURL)}}" id="campaignSendSpeedForm" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="campaignSendSpeedId" value="">
                <div class="form-group mb-20">
                    <div class="slidecontainer">
                        <input type="range" min="2000" max="10000000"
                        value="" class="slider myRange"
                         name="drops_per_hour" id="myRange"
                         oninput="changeSendSpeedSlider(this.value)">
                        <p>Messages Per Hour: <strong> <input class="form-control" type="number" max="10000000"
                            onchange ="updateDropsPerHourSliderRangeValue(this.value)"
                            name="" class="dropsPerHourSliderRange" id="dropsPerHourSliderRange"
                            value=""> </strong></p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onClick="$('#campaignSendSpeedForm').submit();">Messages Per Hour</button>
                    <div style="display: none;" class="test-call-loader spinner-border spinner-border-sm"></div>
                </div>
            </form>

        </div>
        </div>
    </div>
</div>
{{-- send speed modal end --}}

<div class="modal fade" id="view_campaign_stats" tabindex="-1" role="dialog" aria-labelledby="view_campaign_statsTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Campaign Stats</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-6">
                    {{-- <h6 style="font-size: medium;">Sent: <span id="statsSentCampaigns"></span></h6> --}}
                    <p style="font-size: medium;"><strong> Sent:</strong>
                        <span style="color: rgb(23, 167, 211);" id="statsSentCampaigns"></span>
                    </p>
                </div>
                <div class="col-6">
                    <p style="font-size: medium;"><strong> Pending: </strong>
                        <span style="color: blue;" id="statsPendingCampaigns"></span>
                    </p>
                    {{-- <h6 style="font-size: medium;">Pending: <span id="statsPendingCampaigns"></span></h6> --}}
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-6">
                    <p style="font-size: medium;"><strong> Transfer:</strong>
                        <span style="color: green;" id="statsCampaignSuccess"></span>
                    </p>
                </div>
                <div class="col-6">
                    <p style="font-size: medium;"><strong> DNC Calls: </strong>
                        <span style="color: red;"id="statsCampaignDNC"></span>
                    </p>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-6">
                    <p style="font-size: medium;"><strong> Reset Count:</strong>
                        <span style="color: rgb(161, 121, 10);" id="statsResetCampaigns"></span>
                    </p>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-6">
                    <strong> Status:</strong>
                </div>
                <div class="col-4">
                    <div style="font-size: medium;" id="statsCampaignStatus">

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

@if(auth()->user()->role == "user")
    <input type="hidden" id="loadStatsURL" value="{{route('user.sms_campaigns.getStats')}}" />
    <input type="hidden" id="getSendSpeedURL" value="{{route('user.sms_campaigns.get_send_speed')}}" />
@elseif(auth()->user()->role == "admin")
    <input type="hidden" id="loadStatsURL" value="{{route('admin.sms_campaigns.getStats')}}" />
    <input type="hidden" id="getSendSpeedURL" value="{{route('admin.sms_campaigns.get_send_speed')}}" />
@endif


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

    function editSendSpeed(id){
       $('#update_campaign_send_speed').modal('show');
       $('#dropsPerHourSliderRange').val('')
       $('#myRange').val('0')
       $.ajax({
            type: 'GET',
            contentType: false,
            processData:false,
            url: $('#getSendSpeedURL').val()+'?id='+id,
            success: function (response) {
                // console.log(response)
                if(response != null){

                    $('#campaignSendSpeedId').val(response['id'])
                    $('#dropsPerHourSliderRange').val(response['drops_per_hour'])
                    $('#myRange').val(response['drops_per_hour'])
                }
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);

            },
        });
    }

    function changeSendSpeedSlider(range,id) {
        $('#dropsPerHourSliderRange').val(range)
        $('#myRange').val(range)
    }

    function updateDropsPerHourSliderRangeValue(value,id){

      if(parseInt(value) > 10000000 || parseInt(value) < 2000 ){

        alert('Range must be from 2000 to 10000000');
        $('#myRange').val('2000');
        $('#dropsPerHourSliderRange').val('2000')
      }else{
        $('#myRange').val(value);
      }

    }
    function closeAlert()
    {
        document.getElementById('alert-success').style.display = "none";
        document.getElementById('alert-danger').style.display = "none";
    }

    function loadStats(id){
       $('#view_campaign_stats').modal('show');
       $('#statsSentCampaigns').text('');
       $('#statsCampaignStatus').html('');
        $.ajax({
            type: 'GET',
            contentType: false,
            processData:false,
            url: $('#loadStatsURL').val()+'?id='+id,
            success: function (response) {

                if(response !== null){

                    // reset campaign counter
                    if(response['reset_count'] != null){
                        $('#statsResetCampaigns').text(response['reset_count']);
                    }else{
                        $('#statsResetCampaigns').text('0');
                    }

                    // campaign success
                    if(response['campaign_stats'] !== null){
                        if(response['campaign_stats']['contact_count'] !== 0 && response['campaign_stats']['success_count'] !== 0){
                            if(isNaN(response['campaign_stats']['success_count']) || typeof response['campaign_stats']['success_count'] === "undefined"
                            || response['campaign_stats']['success_count'] === null){
                                response['campaign_stats']['success_count'] = 0;
                            }
                            if(isNaN(response['campaign_stats']['contact_count']) || typeof response['campaign_stats']['contact_count'] === "undefined"
                            || response['campaign_stats']['contact_count'] === null){
                                response['campaign_stats']['contact_count'] = 0;
                            }
                            // let successText = response['campaign_stats']['success_count'] +' '+ '('+ (Math.round((response['campaign_stats']['success_count'] / response['campaign_stats']['contact_count']) * 100 , 2)+ '%)');
                            let successText = response['campaign_stats']['success_count'] +' '+ '('+ (parseFloat(response['campaign_stats']['success_count']) / parseFloat(response['campaign_stats']['contact_count']) * 100 ).toFixed(2).replace(/(\.0+|0+)$/, '')+ '%)';
                            $('#statsCampaignSuccess').text(successText);
                        }else{
                            $('#statsCampaignSuccess').text('0 (0 %)');
                        }

                    }else {

                        $('#statsCampaignSuccess').text('0 (0 %)');
                    }

                    // campaign dnc
                    if(response['campaign_stats'] !== null){
                            if(response['campaign_stats']['contact_count'] !== 0 && response['campaign_stats']['dnc_count'] !== 0){
                                if(isNaN(response['campaign_stats']['dnc_count']) || typeof response['campaign_stats']['dnc_count'] === "undefined"
                                || response['campaign_stats']['dnc_count'] === null){
                                    response['campaign_stats']['dnc_count'] = 0;
                                }
                                if(isNaN(response['campaign_stats']['contact_count']) || typeof response['campaign_stats']['contact_count'] === "undefined"
                                || response['campaign_stats']['contact_count'] === null){
                                    response['campaign_stats']['contact_count'] = 0;
                                }
                                // let dncText = response['campaign_stats']['dnc_count'] +' '+  '('+(Math.round((response['campaign_stats']['dnc_count'] / response['campaign_stats']['contact_count']) * 100 , 2)+ '%)');
                                let dncText = response['campaign_stats']['dnc_count'] +' '+  '('+(parseFloat(response['campaign_stats']['dnc_count']) / parseFloat(response['campaign_stats']['contact_count']) * 100 ).toFixed(2).replace(/(\.0+|0+)$/, '')+ '%)';
                                $('#statsCampaignDNC').text(dncText);
                            }else{
                                $('#statsCampaignDNC').text('0 (0 %)');
                            }

                        }else {

                            $('#statsCampaignDNC').text('0 (0 %)');
                        }

                    // campaign sent
                    if(response['campaign_stats'] !== null){
                        if(response['campaign_stats']['contact_count'] !== 0 && response['campaign_stats']['sent_count'] !== 0){
                            if(isNaN(response['campaign_stats']['sent_count']) || typeof response['campaign_stats']['sent_count'] === "undefined"
                            || response['campaign_stats']['sent_count'] === null){
                                response['campaign_stats']['sent_count'] = 0;
                            }
                            if(isNaN(response['campaign_stats']['contact_count']) || typeof response['campaign_stats']['contact_count'] === "undefined"
                            || response['campaign_stats']['contact_count'] === null){
                                response['campaign_stats']['contact_count'] = 0;
                            }
                            // let successText = response['campaign_stats']['sent_count'] +' '+ '('+ (Math.round((response['campaign_stats']['sent_count'] / response['campaign_stats']['contact_count']) * 100 , 2)+ '%)');
                            let successText = response['campaign_stats']['sent_count'] +' '+ '('+ (parseFloat(response['campaign_stats']['sent_count']) / parseFloat(response['campaign_stats']['contact_count']) * 100 ).toFixed(2).replace(/(\.0+|0+)$/, '')+ '%)';
                            $('#statsSentCampaigns').text(successText);
                        }else{
                            $('#statsSentCampaigns').text('0 (0 %)');
                        }

                    }else {

                        $('#statsSentCampaigns').text('0 (0 %)');
                    }

                    // campaign pending
                    if(response['campaign_stats'] !== null){
                        if(response['campaign_stats']['contact_count'] !== 0 || response['campaign_stats']['sent_count'] !== 0){
                            if(isNaN(response['campaign_stats']['sent_count']) || typeof response['campaign_stats']['sent_count'] === "undefined"
                            || response['campaign_stats']['sent_count'] === null){
                                response['campaign_stats']['sent_count'] = 0;
                            }
                            if(isNaN(response['campaign_stats']['contact_count']) || typeof response['campaign_stats']['contact_count'] === "undefined"
                            || response['campaign_stats']['contact_count'] === null){
                                response['campaign_stats']['contact_count'] = 0;
                            }
                            if(isNaN(response['campaign_stats']['dnc_count']) || typeof response['campaign_stats']['dnc_count'] === "undefined"
                            || response['campaign_stats']['dnc_count'] === null){
                                response['campaign_stats']['dnc_count'] = 0;
                            }
                            console.log('dnc_count--->',parseFloat(response['campaign_stats']['dnc_count']))
                            console.log('contact_count--->',parseFloat(response['campaign_stats']['contact_count']))
                            console.log('sent_count--->',parseFloat(response['campaign_stats']['sent_count']))
                            let pending = parseFloat(response['campaign_stats']['contact_count']) - parseFloat(response['campaign_stats']['sent_count']) - parseFloat(response['campaign_stats']['dnc_count']);
                            console.log('pending--->',pending)
                            if(pending !== 0){
                                let pendingText = pending +' '+  '('+(parseFloat(pending) / parseFloat(response['campaign_stats']['contact_count']) * 100 ).toFixed(2).replace(/(\.0+|0+)$/, '')+ '%)';
                                $('#statsPendingCampaigns').text(pendingText);
                            }else{
                                $('#statsPendingCampaigns').text('0 (0 %)');
                            }

                        }else{
                            $('#statsPendingCampaigns').text('0 (0 %)');
                        }


                    }else {

                        $('#statsPendingCampaigns').text('0 (0 %)');
                    }



                    // campaign status
                    if(response['status'] == "played")
                        if(response['dnc_time_exists'] === 1){
                            $('#statsCampaignStatus').html('<span class="bg-opacity-warning color-warning rounded-pill userDatatable-content-status">Not Sending - Out of Hours</span>');
                        }else{
                            $('#statsCampaignStatus').html('<span class="bg-opacity-info color-info rounded-pill userDatatable-content-status">Playing</span>');
                        }
                    else if(response['status'] == "preprocessing"){
                        $('#statsCampaignStatus').html('<span class="bg-opacity-success color-success rounded-pill userDatatable-content-status">Preprocessing</span>');
                    }
                    else if(response['status'] == "paused"){
                        $('#statsCampaignStatus').html('<span class="bg-opacity-warning color-warning rounded-pill userDatatable-content-status">Paused</span>');
                    }
                    else if(response['status'] == "inactive"){
                        $('#statsCampaignStatus').html('<span class="bg-opacity-danger color-danger rounded-pill userDatatable-content-status">Deleted</span>');
                    }
                    else if(response['status'] == "flagged") {
                        $('#statsCampaignStatus').html('<span class="bg-opacity-danger color-danger rounded-pill userDatatable-content-status">Flagged</span>');
                    }
                    else if(response['status'] == "pending"){
                        if(response['dnc_time_exists'] === 1){
                            $('#statsCampaignStatus').html('<span class="bg-opacity-warning color-warning rounded-pill userDatatable-content-status">Not Sending - Out of Hours</span>');
                        }
                        else{
                            $('#statsCampaignStatus').html('<span class="bg-opacity-info color-info rounded-pill userDatatable-content-status">Pending</span>');
                        }
                    }else if(response['status'] == "finished"){
                        $('#statsCampaignStatus').html('<span class="bg-opacity-success color-success rounded-pill userDatatable-content-status">Finished</span>');
                    }

                }else{
                    console.log('No campaign available');
                }

            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);

            },
        });
    }
</script>
@endsection
