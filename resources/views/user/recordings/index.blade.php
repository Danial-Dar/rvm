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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">Recordings</h4>
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
                            @if(session('error'))
                                    <div class="alert alert-danger" id="alert-danger">
                                        <ul>
                                        <button  style="float:right; background: none;border: none; " onclick="closeAlert()" >x</button>
                                        <li>{{session('error')}}</li></ul>
                                    </div>
                            @endif
                        </div>
                    </div>
                    <div class="action-btn">
                        @if(auth()->user()->role == "user")
                            <a href="#" class="btn px-15 btn-primary"  data-toggle="modal" data-target="#add_recording_modal" style="background-color: #003B76"> <i class="las la-plus fs-16"></i>Upload New Recording</a>
                        @endif
                        <!-- Modal To add recording -->
                        <div class="modal fade" id="add_recording_modal" tabindex="-1" role="dialog" aria-labelledby="add_recording_modalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Add Recording</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" style="padding: 20px 75px 20px 75px">
                                        <form action="{{route('user.recording.store')}}" method="POSt" enctype="multipart/form-data"  id="submit_recording_button">
                                            @csrf
                                            <div class="form-group mb-20">
                                                <input type="text" name="name" id="name" class="form-control" placeholder="Recording Name" required>
                                            </div>
                                            <div class="form-group mb-20">
                                                <label for="recording">Upload Recording</label>
                                                <input type="file" name="file" id="file" class="form-control" required accept=".mp3,.wav">
                                            </div>


                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" style="background-color: #003B76">Add Recording</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal ends Here -->
                        <!-- Modal for upload loader -->
                        <div class="modal fade" id="upload_recording" tabindex="-1" role="dialog" aria-labelledby="delete_listLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document" >
                                <div class="modal-content">
                                <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-3">
                                    <h4>Your recording is being uploaded</h4>
                                    <p>This may take a moment...</p>
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Ends -->
                    </div>
                    <div class="ajaxspinner"></div>
                    <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30 mt-30">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr class="userDatatable-header">
                                    <th scope="col">
                                        <span class="userDatatable-title">Name</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">User</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Status</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Play/Pause</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Created At</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($recordings as $rec)
                                    <?php
                                     $path = storage_path('app/recordings/'.$rec->filename); ?>
                                        <tr>
                                            <td>{{$rec->name}}</td>
                                            <td>{{!is_null($rec->user) ? $rec->user->first_name.''.$rec->user->last_name : 'N/A'}}</td>
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
                                                <a href="javascipt::void(0)" class="btn px-15 btn-success"  data-toggle="modal" data-target="#listen_recording_modal" onClick="getListenAudioLink('{{$rec->filename}}' , '{{$rec->id}}')" style="background-color: #003B76"> <i class="la la-file-audio-o fs-16"></i> Listen Recording</a>
                                                {{-- <audio controls>
                                                    <source src="{{$rec->recording_path}}" type="audio/mp3">

                                                </audio> --}}
                                                <!-- modal to listen recording -->
                                                <div class="modal fade" id="listen_recording_modal" tabindex="-1" role="dialog" aria-labelledby="add_recording_modalTitle" aria-hidden="true">
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
                                                                <div class="col-md-12 align-items-center">
                                                                    <div class="spinner-border sb" id="spinner-border" role="status" style="margin-left: 140px;">
                                                                        <span class="sr-only">Loading...</span>
                                                                    </div>
                                                                    <audio id="audio" controls style="display: none;" class="audio_recording">
                                                                        <source id="audioSource" src="" type="audio/wav">

                                                                    </audio>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal ends  -->
                                            </td>
                                            <td>{{$rec->created_at}}</td>
                                            <td>
                                                @if(auth()->user()->role !== "company")
                                                    <ul class="orderDatatable_actions mb-0 ">
                                                        <li>
                                                        <a href="" data-toggle="modal" data-target="#delete_audio{{$rec->id}}"><span data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Delete Audio"></span></a>
                                                            <!-- Confirmation Modal -->
                                                            <div class="modal fade delete_audio" id="delete_audio{{$rec->id}}" role="dialog" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content  radius-xl">
                                                                        <div class="modal-header">
                                                                            <h6 class="modal-title fw-500" id="staticBackdropLabel">Delete Audio</h6>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span data-feather="x"></span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="delete_audio-modal">
                                                                                <div class="form-group mb-20">
                                                                                    <p>Are You Sure You Want To Delete This audio?</p>
                                                                                </div>
                                                                                <div class="d-flex">
                                                                                    <a  href="{{url('user/recordings/delete/'.$rec->id)}}" style="text-decoration: none;">
                                                                                    <button type="button" class="btn btn-danger" >Yes</button>
                                                                                    </a>
                                                                                    <button data-dismiss="modal" class="btn btn-light btn-default btn-squared fw-400 text-capitalize b-light color-light" style="margin-left: 15px;">
                                                                                        cancel
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Modal Ends -->
                                                        </li>
                                                        <li>
                                                            <a href="{{ url('/recordings/download/'.$rec->id) }}" target="_blank" rel="noopener noreferrer">
                                                            <span data-feather="download" data-toggle="tooltip" data-placement="bottom" title="Download"></span></a>
                                                        </li>
                                                    </ul>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@php
    if(auth()->user()->role !== "company")
        $recordingListernURL ="user/listen-recording";
    else
        $recordingListernURL ="company/listen-recording";

@endphp

@php
    $session = Session::has('success');
@endphp
<script>
    // function mp3Validate()
    // {
    //     var fileInput = document.getElementById('file');
    //     var filePath = fileInput.value;
    //     var allowedExtensions = /(\.mp3)$/i;
    //     if(!allowedExtensions.exec(filePath)){
    //         alert('Only mp3 files are allowed');
    //         fileInput.value = '';
    //         return false;
    //     }
    // }
    $(document).ready(function() {
        $('#listen_recording_modal').on('hidden.bs.modal', function (e) {
            var audio = document.getElementById('audio');
            audio.pause();

        });
        $('INPUT[type="file"]').change(function () {
            var ext = this.value.match(/\.(.+)$/)[1];
            switch (ext) {
                case 'mp3':
                case 'wav':
                    break;
                default:
                    alert('This file type is not supported.');
                    this.value = '';
            }
        });
    } );
    function getListenAudioLink(filename, id){
        // console.log(filename);
        $('.audio_recording').fadeOut('fast');
        $('.sb').fadeIn('fast');
        setTimeout(function() {
        $('.sb').fadeOut('fast');
        $('.audio_recording').fadeIn('fast');
        }, 2000); // <-- time in milliseconds

        $.ajax({
            url: '{{url($recordingListernURL)}}',
            contentType: "application/json; charset=utf-8",
            data:{filename: filename},
            success: function(result){
                // $("#div1").html(result);
                // console.log(result);
             var audio = document.getElementById('audio');

              var source = document.getElementById('audioSource');
              source.src = result;

              audio.load(); //call this to just preload the audio without playing
              audio.play(); //call this to play the song right away

      }});
    }
    $(document).ready(function() {
        $('#example').DataTable( {
        "order": [],
        // "language": {
        // "emptyTable": "No data to show"
        // }
    } );
    $('#alert-success').delay(7000).fadeOut();
    $('#alert-danger').delay(7000).fadeOut();

    // if(Session::has('success'))
    //     var toast = $('.toast').toast({
    //         animation: true,
    //         autohide: true,
    //         delay: 4000
    //     })
    //     toast.toast('show')
    // endif
    });

   $('#submit_recording_button').submit(function(){
        $('#add_recording_modal').modal('toggle')
        $('#upload_recording').modal('toggle')
    })

    function closeAlert()
    {
        document.getElementById('alert-success').style.display = "none";
        document.getElementById('alert-danger').style.display = "none";
    }
</script>
@endsection
