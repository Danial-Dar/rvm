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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">DNC</h4>
                            <span class="sub-title ml-sm-25 pl-sm-25"> </span>
                           @if ($errors->any())
                                <div class="alert alert-danger" id="alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <button  style="float:right; background: none;border: none; " onclick="closeAlert()">x</button><li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(session('success'))
                                    <div class="alert alert-success" id="alert-success">
                                        <ul>
                                        <button  style="float:right; background: none;border: none; " onclick="closeAlert()">x</button>
                                        <li>{{session('success')}}</li></ul>
                                    </div>
                            @endif
                            @if(session('error'))
                                    <div class="alert alert-danger" id="alert-danger">
                                        <ul>
                                             <button  style="float:right; background: none;border: none; " onclick="closeAlert()" >x</button>
                                            <li>{{session('error')}}</li>
                                        </ul>
                                    </div>
                            @endif
                        </div>
                    </div>
                    <div class="action-btn">
                        <a href="#" class="btn px-15 btn-primary"  data-toggle="modal" data-target="#add_dnc_modal" style="background-color: #003B76"> <i class="las la-plus fs-16"></i>Add New Number</a>

                        <div class="modal fade" id="add_dnc_modal" tabindex="-1" role="dialog" aria-labelledby="add_recording_modalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Add DNC Number</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" style="padding: 20px 75px 20px 75px">
                                        @php
                                            if(auth()->user()->role !== "company")
                                                $dncStoreURL ="user.dnc-list.store";
                                            else
                                                $dncStoreURL ="company.dnc-list.store";

                                        @endphp
                                        <form action="{{route($dncStoreURL)}}" method="POSt" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group mb-20">
                                                <input type="text" name="number" id="dnc_number" class="form-control" placeholder="Number" minlength="14" maxlength="14" required>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" style="background-color: #003B76">Add DNC Number</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30 mt-30">
                    <div>
                    @php
                        if(auth()->user()->role !== "company")
                            $dncSearchURL ="user.dnc-list";
                        else
                            $dncSearchURL ="company.dnc-list";

                    @endphp
                    <form action="{{route($dncSearchURL)}}" method="get">
                        <div class="row mb-2 ml-1">
                            <input type="text" class="form-control col-4 mr-1" name="search" id="search" value="{{\Request::get('search')}}">

                            <button type="submit" class="btn btn-primary col-1">Search</button>
                        </div>
                    </form>
                    <a href="#" class="btn px-15 btn-primary"  data-toggle="modal" data-target="#upload_dnc_list">Upload List</a>
                    <div class="modal fade" id="upload_dnc_list" tabindex="-1" role="dialog" aria-labelledby="add_recording_modalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Upload List</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" style="padding: 20px 75px 20px 75px">
                                        @php
                                            if(auth()->user()->role !== "company")
                                                $dncURL ="user.upload.dnc-list";
                                            else
                                                $dncURL ="company.upload.dnc-list";

                                        @endphp
                                        <form action="{{route($dncURL)}}" method="POSt" enctype="multipart/form-data" onsubmit="loader()">
                                            @csrf
                                            <div class="form-group mb-20">
                                            <input type="file" name="file" id="file" class="form-control" accept=".csv" onchange="csvValidate()" required>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" style="background-color: #003B76">Upload</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="loader-modal" tabindex="-1" role="dialog" aria-labelledby="loader_modalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Your List Is Adding</h5>

                                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                                        {{-- <span aria-hidden="true">&times;</span>
                                        </button> --}}
                                    </div>
                                    <div class="modal-body text-center" style="padding: 20px 75px 20px 75px">
                                        <div class="spinner-border text-info spin"></div>
                                        <div id='seconds-counter'> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                        <div class="" style="margin-top: 20px;">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr class="userDatatable-header">
                                    <th scope="col">
                                        <span class="userDatatable-title">Number</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">User</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Date Added</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($dnc_list as $dnc)

                                        <tr>
                                            <td>{{$dnc->number}}</td>
                                            <td>{{$dnc->user->first_name.''.$dnc->user->last_name}}</td>
                                            <td>{{ $dnc->created_at->format('m-d-Y H:i:s A') }}</td>
                                            <td>
                                                <ul class="orderDatatable_actions mb-0 ">
                                                    <li>
                                                       <a href="" data-toggle="modal" data-target="#delete_dnc{{$dnc->id}}"><span data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Delete Number"></span></a>
                                                        <!-- Confirmation Modal -->
                                                        <div class="modal fade delete_dnc" id="delete_dnc{{$dnc->id}}" role="dialog" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content  radius-xl">
                                                                    <div class="modal-header">
                                                                        <h6 class="modal-title fw-500" id="staticBackdropLabel">Delete Number</h6>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span data-feather="x"></span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="delete_dnc-modal">
                                                                            <div class="form-group mb-20">
                                                                                <p>Are You Sure You Want To Delete This Number?</p>
                                                                            </div>
                                                                            <div class="d-flex">
                                                                                @php
                                                                                    if(auth()->user()->role !== "company")
                                                                                        $dncDeleteURL ="user/dnc-delete/";
                                                                                    else
                                                                                        $dncDeleteURL ="company/dnc-delete/";

                                                                                @endphp
                                                                                <a href="{{url($dncDeleteURL.$dnc->id)}}" style="text-decoration: none;">
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
                                                   {{--  <li>
                                                        <a href="{{ url('user/dnc-delete/'.$dnc->id) }}" target="" rel="noopener noreferrer">
                                                        <span data-feather="trash" data-toggle="tooltip" data-placement="bottom" title="Delete"></span></a>
                                                    </li> --}}
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                             {{ $dnc_list->appends(request()->except('page'))->links() }}
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
        lengthChange: false,
        "bPaginate": false,
        "bInfo": false,
        searching: false,
    } );
        // if(session('success'))
        //     var toast = $('.toast').toast({
        //         animation: true,
        //         autohide: true,
        //         delay: 4000
        //     })
        //     toast.toast('show')
        //
        $('#dnc_number').mask('(000) 000-0000');
        $('#alert-success').delay(3000).fadeOut();
        $('#alert-danger').delay(3000).fadeOut();
    });
    function closeAlert()
    {
      //  document.getElementById('alert-success').style.display = "none";
        //document.getElementById('alert-danger').style.display = "none";
        $('#alert-success').fadeOut();
        $('#alert-danger').fadeOut();
    }

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

    function loader()
    {
        $('#loader-modal').modal({
            backdrop: 'static',
            keyboard: false
        });

        // $('.spin').show();
        $('#loader-modal').modal('show');
        // var seconds = 0;
        // var el = document.getElementById('seconds-counter');

        // function incrementSeconds() {
        // seconds += 1;
        // el.innerText = "Your List is adding since " + seconds + " seconds.";
        // }

        // var cancel = setInterval(incrementSeconds, 1000);
        // window.onbeforeunload = function(e) {
        //     window.open(document.URL,"_blank");
        //     return 'You can not close the window until data uploading.';
        // };
    }
</script>
@endsection
