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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">Sms OptOut Words</h4>
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
                            <a href="#" class="btn px-15 btn-primary" data-toggle="modal" data-target="#add_contact_list_modal" style="background-color: #003B76">
                                <i class="las la-plus fs-16"></i>Add OptOut Word</a>
                        <div class="modal fade" id="add_contact_list_modal" tabindex="-1" role="dialog" aria-labelledby="add_contact_list_modalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Add OptOut Word</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" style="padding: 20px 75px 20px 75px">
                                    {{-- {{route('user.contact-list.store')}} --}}
                                        <form action="{{route('admin.opt_out_word.store')}}" method="POST" enctype="multipart/form-data" onsubmit="loader()">
                                            @csrf
                                            <div class="form-group mb-20">
                                                <input type="text" name="word" id="word" class="form-control" placeholder="OptOut Word" required>
                                            </div>
                                            <div class="form-group mb-20">
                                                <label for="recording">Section</label>
                                                <select required class="form-control" name="section" id="section">
                                                    <option value="">Select Section</option>
                                                    <option value="inbound">Inbound</option>
                                                    <option value="outbound">Outbound</option>
                                                </select>
                                            </div>

                                            <div class="modal-footer">

                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" data-backdrop="static" data-keyboard="false" style="background-color: #003B76">Save</button>

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
                                        <span class="userDatatable-title">Word</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Section</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Created At</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($opt_out_words as $word)
                                        <tr>
                                            <td>{{$word->word}}</td>
                                            <td>{{$word->section}}</td>
                                            <td>{{$word->created_at}}</td>
                                            <td>


                                                <ul class="orderDatatable_actions mb-0 ">
                                                    <li>
                                                        <a class="edit" id="view-otp-out-word" href="" data-toggle="modal" data-target="#update_opt_out_word{{$word->id}}" ><span data-feather="eye" data-toggle="tooltip" data-placement="bottom" title="View OptOut Word"></span></a>
                                                        <div class="modal fade" id="update_opt_out_word{{$word->id}}" tabindex="-1" role="dialog" aria-labelledby="confirm_list_deleteTitle" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">Update OptOut Word</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form action="{{ route('admin.opt_out_word.update', ['id'=>$word->id]) }}" method="post" id="edit_opt_out_word{{$word->id}}">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <div class="form-group mb-20">
                                                                            <input type="text" name="word" id="word" class="form-control" placeholder="OptOut Word" required
                                                                            value="{{$word->word}}">
                                                                        </div>
                                                                        <div class="form-group mb-20">
                                                                            <label for="recording">Section</label>
                                                                            <select required class="form-control" name="section" id="section">
                                                                                <option value="">Select Section</option>
                                                                                <option value="inbound" @if($word->section =="inbound") Selected @endif>Inbound</option>
                                                                                <option value="outbound" @if($word->section =="outbound") Selected @endif>Outbound</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                                    </div>
                                                                </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <a href="" data-toggle="modal" data-target="#confirm_list_delete{{$word->id}}">
                                                            <span data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Delete OptOut Word"></span></a>
                                                    </li>
                                                    <!-- Delete Confirmation Modal -->
                                                    <div class="modal fade" id="confirm_list_delete{{$word->id}}" tabindex="-1" role="dialog" aria-labelledby="confirm_list_deleteTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">Delete OptOut Word</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('admin.opt_out_word.delete', ['id'=>$word->id]) }}" method="get" id="delete_list{{$word->id}}">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete the OptOut Word ?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" id="check_for_campaigns" class="btn btn-danger">Yes</button>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </ul>
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
<!-- Modal for deleting -->
<div class="modal fade" id="delete_opt_out_word_list" tabindex="-1" role="dialog" aria-labelledby="delete_listLabel" aria-hidden="true">
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

<script>


    function loader()
    {
        $('#loader-modal').modal({
            backdrop: 'static',
            keyboard: false
        });

        // $('.spin').show();
        $('#loader-modal').modal('show');

    }

    $(document).ready(function() {

    var table = $('#example').DataTable( {
        lengthChange: false,
        "order": [],
    } );

    $('#alert-success').delay(7000).fadeOut();
    $('#alert-danger').delay(7000).fadeOut();
    $('#alert-danger-2').delay(7000).fadeOut();

    });
</script>

<script>



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
