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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">User Details</h4>
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
                            @if(session('error'))
                                    <div class="alert alert-danger" id="alert-danger">
                                        <ul><li>{{session('error')}}</li></ul>
                                    </div>
                            @endif 
                        </div>
                    </div>

                    <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30 mt-30">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                          <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="campaign-tab" data-toggle="tab" href="#campaign" role="tab" aria-controls="campaign" aria-selected="true">Campaign</a>
                          </li>
                          <li class="nav-item" role="presentation">
                            <a class="nav-link" id="contact-list-tab" data-toggle="tab" href="#contact-list" role="tab" aria-controls="contact-list" aria-selected="false">Contact List</a>
                          </li>
                          <li class="nav-item" role="presentation">
                            <a class="nav-link" id="recording-tab" data-toggle="tab" href="#recording" role="tab" aria-controls="recording" aria-selected="false">Recordings</a>
                          </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                          <div class="tab-pane fade show active" id="campaign" role="tabpanel" aria-labelledby="campaign-tab">
                               <div class="table-responsive" style="margin-top: 1rem">
                                    <table id="example" class="table table-striped table-bordered" style="width:100%;">
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
                                                <span class="userDatatable-title">Successfull</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Pending</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Failed</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Status</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Type</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Created At</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Last Ran</span>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if($campaigns->isNotEmpty())
                                                @foreach($campaigns as $key => $campaign)
                                                <tr>
                                                    <td>
                                                        {{$campaign->name}}
                                                    </td>
                                                    <td>
                                                        {{$campaign->user->first_name}} {{$campaign->user->last_name}}
                                                    </td>
                                                    <td>
                                                        {{$campaign->campaign_contacts_count}}
                                                    </td>
                                                    <td>
                                                        {{$campaign->success}} 
                                                        @if($campaign->success != 0 && $campaign->campaign_contacts_count != 0)
                                                            ({{($campaign->success / $campaign->campaign_contacts_count) * 100 }} %)
                                                        @else
                                                            (0 %)
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{$campaign->pending}}
                                                        @if($campaign->pending != 0 && $campaign->campaign_contacts_count != 0)
                                                            ({{($campaign->pending / $campaign->campaign_contacts_count) * 100 }} %)
                                                        @else
                                                            (0 %)
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{$campaign->fail}}
                                                        @if($campaign->fail != 0 && $campaign->campaign_contacts_count != 0)
                                                            ({{($campaign->fail / $campaign->campaign_contacts_count) * 100 }} %)
                                                        @else
                                                            (0 %)
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($campaign->status == "played")
                                                            <span class="bg-opacity-info color-info rounded-pill userDatatable-content-status">Playing</span>
                                                        @elseif($campaign->status == "paused")
                                                            <span class="bg-opacity-warning color-warning rounded-pill userDatatable-content-status">Paused</span>
                                                        @elseif($campaign->status == "inactive")
                                                            <span class="bg-opacity-danger color-danger rounded-pill userDatatable-content-status">Deleted</span>
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
                                                        {{ Carbon\Carbon::parse($campaign->created_at)->format('m-d-Y H:i:s A') }}
                                                    </td>
                                                    <td>
                                                        {{ isset($campaign->last_ran) ? Carbon\Carbon::parse($campaign->last_ran->updated_at)->format('m-d-Y H:i:s A') : '' }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            
                                            @endif
                                        </tbody>
                                       
                                    </table>
                                </div>
                          </div>
                          <div class="tab-pane fade" id="contact-list" role="tabpanel" aria-labelledby="contact-list-tab">
                              <div class="table-responsive" style="margin-top: 1rem">
                                <table id="example1" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr class="userDatatable-header">
                                            <th>
                                                <span class="userDatatable-title">Name</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Total Contacts</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Uploaded By</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Status</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Created At</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($lists->isNotEmpty())
                                            @foreach($lists as $list)
                                            <tr>
                                                <td>{{$list->name}}</td>
                                                <td>{{$list->total_contacts}}</td>
                                                <td>{{$list->user->first_name .''. $list->user->last_name}} </td>
                                                <td>
                                                    <div class=" d-inline-block">
                                                        @if($list->status == 'deleted')
                                                        <span class="bg-danger  rounded-pill userDatatable-content-status"> Deleted </span>
                                                        @else
                                                        <span class="bg-success  rounded-pill userDatatable-content-status"> Active </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>{{$list->created_at}}</td>
                                            </tr>                                                    
                                            @endforeach
                                        
                                        @endif
                                    </tbody>
                                </table>
                              </div>
                          </div>
                          <div class="tab-pane fade" id="recording" role="tabpanel" aria-labelledby="recording-tab">
                            <div class="table-responsive" style="margin-top: 1rem">
                                <table id="example2" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr class="userDatatable-header">
                                            <th>
                                                <span class="userDatatable-title">Name</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Status</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Play/Pause</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Created At</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($recordings->isNotEmpty())
                                            @foreach($recordings as $rec)
                                            <?php $path = storage_path('app/recordings/'.$rec->filename); ?>
                                            <tr>
                                                <td>{{$rec->name}}</td>
                                                <td>
                                                    @if($rec->status = 1)
                                                        <div class="userDatatable-content d-inline-block">
                                                            <span class="bg-opacity-success  color-success rounded-pill userDatatable-content-status active">active</span>
                                                        </div>
                                                    @else
                                                        <div class="userDatatable-content d-inline-block">
                                                            <span class="bg-opacity-danger  color-danger rounded-pill userDatatable-content-status active">inactive</span>
                                                        </div>
                                                    @endif  
                                                </td>
                                                <td>
                                                    <a href="javascipt::void(0)" class="btn px-15 btn-success"  data-toggle="modal" data-target="#admin_user_listen_recording_modal" onclick="getUserListenAudioLink('{{$rec->filename}}')" style="background-color: #003B76"> <i class="la la-file-audio-o fs-16"></i> Listen Recording</a>
                                                      <div class="modal fade" id="admin_user_listen_recording_modal" tabindex="-1" role="dialog" aria-labelledby="add_recording_modalTitle" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle">Listen Recording</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body" style="padding: 20px 75px 20px 75px">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                        <div class="spinner-border sb" id="spinner-border" role="status" style="margin-left: 140px;">
                                                                                <span class="sr-only">Loading...</span>
                                                                            </div>
                                                                        </div>
                                                                        <audio id="adminAudio" controls style="display: none;" class="adminAudio">
                                                                            <source id="adminAudioSource" src="" type="audio/wav"> 
                                                                        </audio>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </td>
                                                 <td>{{$rec->created_at}}</td>
                                            </tr>
                                            @endforeach
                                       
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
        
    </div>
</div>

<script type="text/javascript">
    function getUserListenAudioLink(filename){
        $('.adminAudio').fadeOut('fast');
        $('.sb').fadeIn('fast');
        setTimeout(function() {
        $('.sb').fadeOut('fast');
        $('.adminAudio').fadeIn('fast');
        }, 2000); // <-- time in milliseconds
        // console.log(filename);
        $.ajax({
            url: '{{url('user/listen-recording')}}',
            contentType: "application/json; charset=utf-8", 
            data:{filename: filename},
            success: function(result){
                // $("#div1").html(result);
                // console.log(result);
                var audio = document.getElementById('adminAudio');

                var source = document.getElementById('adminAudioSource');
                source.src = result;

                audio.load(); //call this to just preload the audio without playing
                audio.play(); //call this to play the song right away
      }});
    }
    $(document).ready(function() {
        $('#admin_user_listen_recording_modal').on('hidden.bs.modal', function (e) {
            var audio = document.getElementById('adminAudio');
            audio.pause();
        });
    } );
</script>
<script>
    $(document).ready(function() {
        $('#example').DataTable( {
        "order": []
        } );
        $('#example1').DataTable( {
        "order": []
        } );
        $('#example2').DataTable( {
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
    $('#alert-success').delay(7000).fadeOut();
    $('#alert-danger').delay(7000).fadeOut();
    }); 

    
</script>
@endsection