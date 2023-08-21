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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">View My Group Number List</h4>
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
                                        <ul><button  style="float:right; background: none;border: none; " onclick="closeAlert()" >x</button><li>{{session('success')}}</li></ul>
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
                                        <span class="userDatatable-title">Number</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Forward Number</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Status</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Created At</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Type</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Added By</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if($numbersList->isNotEmpty())
                                        @foreach($numbersList as $num)
                                            <tr>
                                                <td>
                                                    {{$num->number}}
                                                </td>
                                                <td>{{$num->forward_to_number}}</td>
                                                <td>
                                                    @if($num->status == 'active')
                                                        <div class="userDatatable-content d-inline-block">
                                                            <span class="bg-opacity-success  color-success rounded-pill userDatatable-content-status active">active</span>
                                                        </div>
                                                    @else
                                                        <div class="userDatatable-content d-inline-block">
                                                            <span class="bg-opacity-danger  color-danger rounded-pill userDatatable-content-status active">Deleted</span>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{$num->created_at}}</td>
                                                <td>{{$num->type}}</td>
                                                <td>{{$num->user->first_name}}</td>
                                                <td>
                                                    @if($num->status == 'active')
                                                        <ul class="orderDatatable_actions mb-0 " style="white-space:nowrap; ">
                                                            @if(auth()->user()->role == 'user')
                                                            <li style="display:inline;">
                                                                <a href="" class="edit" id="edit-list" style="display: inline-flex;" data-toggle="modal" data-target="#edit_number{{$num->id}}"><span data-feather="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Number"></span></a>
                                                            </li>
                                                            <div class="modal fade" id="edit_number{{$num->id}}" tabindex="-1" role="dialog" aria-labelledby="add_new_groupTitle" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLongTitle">Edit Number</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="{{route('user.my_groups.update_my_number',$num->id)}}" method="post">
                                                                                @csrf
                                                                                <div class="form-group mb-20">
                                                                                    <input type="text" name="my_number"
                                                                                    id="my_number" class="form-control my_number"
                                                                                    placeholder="My Number"
                                                                                    minlength="14"
                                                                                    maxlength="14"
                                                                                    value="{{$num->number}}" required >

                                                                                </div>

                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                    <button type="submit" class="btn btn-primary" style="background-color: #003B76">Update Number</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            <li style="display:inline;">
                                                                <a href="" data-toggle="modal" data-target="#delete_number{{$num->id}}" ><span data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Delete Group"></span></a>
                                                                <!-- Confirmation Modal -->
                                                                <div class="modal fade delete_number" id="delete_number{{$num->id}}" role="dialog" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content  radius-xl">
                                                                            <div class="modal-header">
                                                                                <h6 class="modal-title fw-500" id="staticBackdropLabel">Delete Number</h6>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span data-feather="x"></span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="delete_number-modal">
                                                                                    <div class="form-group mb-20">
                                                                                        <p>Are You Sure You Want To Delete This Number?</p>
                                                                                    </div>
                                                                                    <div class="d-flex">
                                                                                        @php
                                                                                            if(auth()->user()->role === "user")
                                                                                                $groupMyNumberDeleteURL = 'user/my-numbers/delete/';
                                                                                            else
                                                                                                $groupMyNumberDeleteURL = 'admin/my-numbers/delete/';
                                                                                        @endphp
                                                                                        <a href="{{url($groupMyNumberDeleteURL.$num->id)}}" style="text-decoration: none;">
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
                                                        </ul>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    {{-- @else
                                        <tr>
                                            <td>No Group Number Available</td>
                                        </tr> --}}
                                    @endif
                                </tbody>
                            </table>
                            {!! $numbersList->appends(request()->except('page'))->links() !!}
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
    $('.my_number').mask('(000) 000-0000');
    $('#alert-success').delay(7000).fadeOut();
    $('#alert-danger').delay(7000).fadeOut();
    // if(session('success'))
    // var toast = $('.toast').toast({
    //     animation: true,
    //     autohide: true,
    //     delay: 4000
    // })
    // toast.toast('show')
    // endif
});

    function closeAlert()
    {
        document.getElementById('alert-success').style.display = "none";
        document.getElementById('alert-danger').style.display = "none";
    }
</script>
@endsection
