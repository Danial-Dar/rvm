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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">BOT API Settings</h4>
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
                        <a href="#" class="btn px-15 btn-primary"  data-toggle="modal" data-target="#add_bot_modal" style="background-color: #003B76"> <i class="las la-plus fs-16"></i>Add New Bot Setting</a>
                        <!-- Modal -->
                        <div class="modal fade" id="add_bot_modal" tabindex="-1" role="dialog" aria-labelledby="add_bot_modalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Add Bot Setting</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="padding: 20px 75px 20px 75px">
                                <form action="{{route('admin.api-setting.bot.store')}}" method="POSt">
                                    @csrf
                                    <label for="bot_name">Bot Name:</label>
                                    <div class="form-group mb-20">
                                        <input type="text" name="bot_name" id="bot_name" class="form-control" placeholder="Bot Name" required>
                                    </div>

                                    <label for="bot_id">Bot Id:</label>
                                    <div class="form-group mb-20">
                                        <input type="text" name="bot_id" id="bot_id" class="form-control" placeholder="Bot Id" required>
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" style="background-color: #003B76">Add Bot</button>
                                </div>
                                </form>
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
                                        <span class="userDatatable-title">Bot Name</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Bot Id</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($bots as $bot)
                                        <tr>
                                            <td>
                                                {{$bot->bot_name}}
                                            </td>
                                            <td>
                                                {{$bot->bot_id}}
                                            </td>
                                            <td>
                                                <ul class="orderDatatable_actions mb-0 ">
                                                    <li>
                                                        <a href="#" class="edit" id="edit_bot"  data-id="{{ $bot->id }}" data-toggle="modal" data-target="#edit_bot_modal{{$bot->id}}"  ><span data-feather="edit" data-toggle="tooltip" data-placement="bottom" title="Edit"></span></a>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="edit_bot_modal{{$bot->id}}" tabindex="-1" role="dialog" aria-labelledby="edit_bot_modalTitle" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="update_company_modalTitle">Edit Bot Settings</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body"  style="padding: 20px 75px 20px 75px">
                                                                        <form action="{{route('admin.api-setting.bot.update')}}" method="POST" enctype="multipart/form-data">
                                                                            @csrf
                                                                            <input type="hidden" name="id" value="{{$bot->id}}">
                                                                            <label>Bot Name:</label>
                                                                            <div class="form-group mb-20">
                                                                                <input type="text" name="bot_name" id="bot_name" class="form-control" value="{{$bot->bot_name}}" placeholder="" required>
                                                                            </div>                              
                                                                            <label>Bot Id:</label>
                                                                            <div class="form-group mb-20">
                                                                                <input type="text" name="bot_id" value="{{$bot->bot_id}}" id="bot_id" class="form-control" placeholder="" required>
                                                                            </div>

                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn btn-primary" style="background-color: #003B76">Update</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    
                                                    <li>
                                                        <a href="#" class="edit" id="remove_bot"  data-id="{{ $bot->id }}" data-toggle="modal" data-target="#remove_bot_modal{{$bot->id}}"  ><span data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Delete"></span></a>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="remove_bot_modal{{$bot->id}}" tabindex="-1" role="dialog" aria-labelledby="remove_bot_modalTitle" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="update_company_modalTitle">Delete Bot Settings</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="delete_bot-modal">
                                                                            <div class="form-group mb-20">
                                                                                <p>Are You Sure You Want To Delete This Bot?</p>
                                                                            </div>
                                                                            <div class="d-flex">
                                                                                <a href="{{url('admin/api-setting/bot/delete/'.$bot->id)}}" style="text-decoration: none;">
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
                                                    </li>
                                                    
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


<script>
    $(document).ready(function() {
        $('#example').DataTable( {
        "order": []
    } );
    $('#alert-success').delay(3000).fadeOut();
    $('#alert-danger').delay(3000).fadeOut();
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