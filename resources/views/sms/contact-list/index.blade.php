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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">Sms Contact Lists</h4>
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
                                    <div class="alert alert-danger" id="alert-danger-2">
                                        <ul>
                                        <button  style="float:right; background: none;border: none; " onclick="closeAlert()" >x</button>
                                        <li>{{session('error')}}</li></ul>
                                    </div>
                            @endif
                            
                        </div>
                    </div>

                    <div class="action-btn">
                        @if(auth()->user()->role !== "admin" && auth()->user()->role !== "company")
                            <a href="#" class="btn px-15 btn-primary" data-toggle="modal" data-target="#add_contact_list_modal" style="background-color: #003B76"> <i class="las la-plus fs-16"></i>Upload New Contact List</a>
                        @endif
                        <div class="modal fade" id="add_contact_list_modal" tabindex="-1" role="dialog" aria-labelledby="add_contact_list_modalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Add Contact List</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" style="padding: 20px 75px 20px 75px">
                                    {{-- {{route('user.contact-list.store')}} --}}
                                        <form action="{{route('user.sms_contact-list.mapContacts')}}" method="POST" enctype="multipart/form-data" onsubmit="loader()">
                                            @csrf
                                            <div class="form-group mb-20">
                                                <input type="text" name="name" id="name" class="form-control" placeholder="List Name" required>
                                            </div>
                                            <div class="form-group mb-20">
                                                <label for="recording">Upload Contact List</label>
                                                <input type="file" name="file" id="file" class="form-control" accept=".csv" onchange="csvValidate()" required>
                                            </div>


                                            <div class="modal-footer">

                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" data-backdrop="static" data-keyboard="false" style="background-color: #003B76">Add Contact List</button>

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
                                        <h5 class="modal-title" id="exampleModalLongTitle">Your Contact List Is Adding</h5>

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

                    <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30 mt-30">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
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
                                        <span class="userDatatable-title">Success</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Fail</span>
                                    </th>
                                    {{-- <th>
                                        <span class="userDatatable-title">Selected Phone Column</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Job Status</span>
                                    </th> --}}
                                    <th>
                                        <span class="userDatatable-title">Status</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Created At</span>
                                    </th>
                                    @if(auth()->user()->role !== "company")
                                    <th>
                                        <span class="userDatatable-title">Actions</span>
                                    </th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($lists as $list)
                                        <tr>
                                            <td>{{$list->name}}</td>
                                            <td>{{$list->total_contacts}}</td>
                                            <td>@if($list->user){{$list->user->first_name}} {{$list->user->last_name}}@endif</td>
                                            <td>{{$list->success != null ? $list->success : 0}}</td>
                                            <td>{{$list->failed != null ? $list->failed : 0}}</td>
                                            <td>
                                                <div class=" d-inline-block">
                                                    @if($list->status == 'deleted')
                                                        <span class="bg-danger  rounded-pill userDatatable-content-status"> Deleted </span>
                                                    @elseif($list->status == 'preprocessing')
                                                        <span class="bg-opacity-success color-success rounded-pill userDatatable-content-status"> {{$list->status}} </span>
                                                    @else
                                                        <span class="bg-success  rounded-pill userDatatable-content-status"> {{$list->status}} </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{$list->created_at}}</td>
                                            @if(auth()->user()->role !== "company")
                                            <td>
                                                @if(auth()->user()->role == "user")
                                                    <?php 
                                                        $listShowURL = 'user.sms_contact-list.show';
                                                        $deleteShowURL = 'user.sms_contact-list.delete';
                                                        $exportURL = 'user.sms_contact-list.exportContactListContacts';
                                                    ?>
                                                @elseif(auth()->user()->role == "admin")
                                                    <?php 
                                                        $listShowURL = 'admin.sms_contact-list.show';
                                                        $deleteShowURL = 'admin.sms_contact-list.delete';
                                                        $exportURL = 'admin.sms_contact-list.exportContactListContacts';
                                                    ?>
                                                @endif
                                               @if(auth()->user()->role !== "company")
                                                    <ul class="orderDatatable_actions mb-0 ">
                                                        <li>
                                                            <a href="{{ route($listShowURL, $list->id) }}" class="edit" id="view-list"  ><span data-feather="eye" data-toggle="tooltip" data-placement="bottom" title="View Contact List"></span></a>
                                                        </li>
                                                        @if($list->status != 'deleted')
                                                        <li>
                                                            <a href="" data-toggle="modal" data-target="#confirm_list_delete{{$list->id}}"><span data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Delete List"></span></a>
                                                        </li>
                                                        <!-- Delete Confirmation Modal -->
                                                            <div class="modal fade" id="confirm_list_delete{{$list->id}}" tabindex="-1" role="dialog" aria-labelledby="confirm_list_deleteTitle" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle">Delete List</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form action="{{ route($deleteShowURL, ['id'=>$list->id]) }}" method="get" id="delete_list{{$list->id}}">
                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            Are you sure you want to delete the list ?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            <button type="button"  onclick="checkCampigns({{$list->id}})" id="check_for_campaigns" class="btn btn-danger">Yes</button>
                                                                        </div>
                                                                    </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        {{-- download to csv --}}

                                                        <li>
                                                            <a href="{{ route($exportURL, $list->id) }}" target="_blank" rel="noopener noreferrer">
                                                            <span data-feather="download" data-toggle="tooltip" data-placement="bottom" title="Download"></span></a>
                                                        </li>
                                                    </ul>
                                                @endif
                                            </td>
                                            @endif
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
<!-- Modal for deleting -->
<div class="modal fade" id="delete_contact_list" tabindex="-1" role="dialog" aria-labelledby="delete_listLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-top: 10%;">
        <div class="modal-content">
        <div class="modal-body">
        <div class="row">
            <div class="col-md-3">
            <h4>Deleting List</h4>
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
@if(auth()->user()->role == "user")
    <input type="hidden" id="checkCampignsURL" value="{{url('user/sms_contact-list/campaigns')}}">
@else
    <input type="hidden" id="checkCampignsURL" value="{{url('admin/sms_contact-list/campaigns')}}">
@endif
<script>

    function csvValidate()
    {
        var fileInput = document.getElementById('file');
        var filePath = fileInput.value;
        var allowedExtensions = /(\.csv)$/i;
        if(!allowedExtensions.exec(filePath)){
            alert('Please choose a csv file');
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

    $(document).ready(function() {


    //     $('#example').DataTable( {
    //     "order": [],
    //     buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
    // } );

    var table = $('#example').DataTable( {
        lengthChange: false,
        "order": [],
        buttons: [{
            extend: 'csv',
            footer: false,
            exportOptions: {
                columns: [0,1,2,3,4,5,6]
            }
        }]
    } );

    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
        // console.log(table)
    $('#alert-success').delay(7000).fadeOut();
    $('#alert-danger').delay(7000).fadeOut();
    $('#alert-danger-2').delay(7000).fadeOut();
    //$('#alert-success2').delay(7000).fadeOut();
    //$('#alert-danger2').delay(7000).fadeOut();
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

<script>
    async function checkCampigns(List_id)
    {
      $('#confirm_list_delete'+List_id).modal('toggle');
      $('#delete_contact_list').modal('show');
      let baseUrl = $('#checkCampignsURL').val();
      // '/rvm-laravel/user/contact-list/campaigns/'+List_id
      await  axios.get(baseUrl+'/'+List_id)
        .then((response) => {
            console.log(response.data)
            if(response.data == true){
                alert('unable to delete! list being used in campign')
                setTimeout(function(){ $('#delete_contact_list').modal('hide'); }, 1000);
            }
            else if(response.data == false){
                $('#delete_list'+List_id).submit();
            }

        });
    }


    function closeAlert()
    {
        //$('#alert-success2').css('display','none');
        //$('#alert-danger2').css('display','none');
        $('#alert-danger-2').css('display','none');
        document.getElementById('alert-success').style.display = "none";
        document.getElementById('alert-danger').style.display = "none";
    }
</script>
@endsection
