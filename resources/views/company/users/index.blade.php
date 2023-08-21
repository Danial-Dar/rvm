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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">Manage Users</h4>
                            <span class="sub-title ml-sm-25 pl-sm-25"> Note: Company and Admin stats are not calculated.</span>
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
                    <div class="action-btn">
                        <a href="#" class="btn px-15 btn-primary"  data-toggle="modal" data-target="#add_user_modal" style="background-color: #003B76"> <i class="las la-plus fs-16"></i>Add New User</a>
                        <!-- Modal -->
                        <div class="modal fade" id="add_user_modal" tabindex="-1" role="dialog" aria-labelledby="add_user_modalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Add User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                    <form action="{{route('company.user.create')}}" method="POSt" enctype="multipart/form-data">
                                <div class="modal-body" style="padding: 20px 75px 20px 75px">

                                    @csrf
                                    <input type="hidden" name="company" class="form-control" value="{{auth()->user()->company_id}}" >
                                    <div class="form-group mb-20">
                                        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" required>
                                    </div>
                                    <div class="form-group mb-20">
                                        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" required>
                                    </div>
                                    <div class="form-group mb-20">
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                                    </div>
                                    <div class="form-group mb-20">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="password" required>
                                    </div>
                                   {{--  <label for="image">User Image</label>
                                    <div class="form-group mb-20">
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                     --}}
                                    <div class="form-group mb-20">
                                       <select name="role" id="role" class="form-control" onchange="companyOption(event)">
                                            <option value="" Selected disabled>Select Role</option>
                                            {{-- <option value="admin">Admin</option> --}}
                                            {{-- <option value="company">Company</option> --}}
                                            {{-- <option value="manager">Manager</option> --}}
                                            <option value="user">User</option>
                                        </select>
                                    </div>

                                   {{--  <div class="form-group mb-20" id="create_company" style="display: none;">
                                       <select name="company" id="company" class="form-control">
                                            <option value="" Selected disabled>Select Company</option>
                                            @foreach($companies as $company)
                                                <option value="{{$company->id}}">{{$company->name}}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" style="background-color: #003B76">Save changes</button>
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
                                        <span class="userDatatable-title">First Name</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Last Name</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Email</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Sent</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Pending</span>
                                    </th>
                                    <!-- <th>
                                        <span class="userDatatable-title">Initiated</span>
                                    </th> -->
                                    <th>
                                        <span class="userDatatable-title">Company</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Role</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Status</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php $role = array('admin','company') ?>
                                    @foreach($users as $user)
                                    
                                        <tr>
                                            <td><a target="_blank" style="color:black;" href="{{route('user.detail',$user->id)}}">{{$user->first_name}}</a></td>
                                            <td>{{$user->last_name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>
                                                @if(!in_array($user->role,$role))
                                                    @if($user->total_contact_count != null || $user->total_sent_count != null)
                                                        {{$user->total_sent_count}}
                                                        @if($user->total_contact_count != 0 && $user->total_sent_count != 0)
                                                            ({{round(($user->total_sent_count / $user->total_contact_count) * 100 , 2 )}} %)
                                                        @else
                                                            (0 %)
                                                        @endif
                                                    @else
                                                        0 (0 %)
                                                    @endif
                                                @else
                                                    -
                                                @endif

                                                {{-- {{$user->initiated}}
                                                @if($user->initiated != 0 && $user->campaign_contacts_count != 0)
                                                    ({{round(($user->initiated / $user->campaign_contacts_count) * 100 , 2 )}} %)
                                                @else
                                                    (0 %)
                                                @endif --}}
                                            </td>
                                            <td>
                                                @if(!in_array($user->role,$role))
                                                    @if($user->total_contact_count != null || $user->total_sent_count != null)
                                                        <?php $pending = $user->total_contact_count != 0  ? $user->total_contact_count - $user->total_sent_count - $user->total_dnc_count : 0; ?> 
                                                        {{$pending}}
                                                        @if($pending != 0)
                                                            ({{round(($pending / $user->total_contact_count) * 100 , 2 )}} %)
                                                        @else
                                                            (0 %)
                                                        @endif
                                                    @else
                                                        0 (0 %)
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                                {{-- {{$user->pending}}
                                                @if($user->pending != 0 && $user->campaign_contacts_count != 0)
                                                    ({{round(( $user->pending / $user->campaign_contacts_count) * 100 , 2) }} %)
                                                @else
                                                    (0 %)
                                                @endif --}}
                                            </td>
                                            <td>{{isset($user->company->name) ? $user->company->name : 'N/A'}}</td>
                                            
                                            {{-- <!-- @if($user->role == "user" && $user->company !== null)
                                                <td>{{$user->company->name}}</td>
                                            @else
                                                <td>N/A</td>
                                            @endif --> --}}
                                            <td>{{$user->role}}</td>
                                            <td>
                                                @if($user->status == 1)
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
                                            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap">
                                            <li>
                                            <a href="#" class="edit" id="edit-customers"  data-id="{{ $user->id }}" data-toggle="modal" data-target="#update_user_modal{{$user->id}}"  ><span data-feather="edit" data-toggle="tooltip" data-placement="bottom" title="Edit User"></span></a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="update_user_modal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="update_user_modalTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="update_user_modalTitle">Update User</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body"  style="padding: 20px 75px 20px 75px">
                                                    <form action="{{route('company.user.update')}}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="id" id="id" class="form-control" value="{{$user->id}}" >
                                                        <input type="hidden" name="company" class="form-control" value="{{$user->company_id}}" >
                                                        <div class="form-group mb-20">
                                                            <div class="form-group mb-20">
                                                                <input type="text" name="first_name" id="user_firstname" class="form-control" placeholder="First Name" value="{{$user->first_name}}" required>
                                                            </div>
                                                        <div class="form-group mb-20">
                                                            <input type="text" name="last_name" id="user_lastname" class="form-control" placeholder="Last Name" value="{{$user->last_name}}" required>
                                                        </div>
                                                        <div class="form-group mb-20">
                                                            <input type="email" name="email" id="user_email" class="form-control" placeholder="Email" value="{{$user->email}}" required>
                                                        </div>
                                                        <div class="form-group mb-20">
                                                            <input type="password" name="password" id="user_password" class="form-control"  placeholder="password" >
                                                        </div>
                                                        <!-- @if($user->role == "user")
                                                        <div class="form-group mb-20">
                                                        <select name="role" id="user_role" class="form-control" >
                                                            <option value="user" @if($user->role == "user") echo selected @endif >User</option>
                                                            <option value="admin" @if($user->role == "admin") echo selected @endif>Admin</option>
                                                            </select>
                                                        </div>
                                                        @endif -->
                                                        {{-- <label for="image">User Image</label>
                                                        <div class="form-group mb-20">
                                                            <input type="file" name="image" class="form-control">
                                                        </div> --}}
                                                        {{-- @if($user->role == "user")
                                                        <div class="form-group mb-20">
                                                            <select name="company" id="user_company" class="form-control" >
                                                            @foreach($companies as $company)

                                                                <option value="{{$company->id}}" @if($user->company_id == $company->id) echo selected @endif >{{$company->name}}</option>
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                        @endif --}}
                                                        <!-- <div class="form-group mb-20">
                                                        <select name="status" id="user_status" class="form-control" >
                                                            <option value="1" @if($user->status == "1") echo selected @endif >Active</option>
                                                            <option value="0" @if($user->status == "0") echo selected @endif>In-Active</option>
                                                            </select>
                                                        </div> -->
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary" style="background-color: #003B76">Save changes</button>
                                                        </div>
                                                    </form>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </li>
                                            @if($user->status != 0 && $user->id != 1)
                                                <li>
                                                    <a href="" data-toggle="modal" data-target="#delete_user{{$user->id}}"><span data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Delete User"></span></a>
                                                    <!-- Confirmation Modal -->
                                                    <div class="modal fade delete_user" id="delete_user{{$user->id}}" role="dialog" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content  radius-xl">
                                                                <div class="modal-header">
                                                                    <h6 class="modal-title fw-500" id="staticBackdropLabel">Delete User</h6>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span data-feather="x"></span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="delete_user-modal">
                                                                        <div class="form-group mb-20">
                                                                            <p>Are You Sure You Want To Delete This User?</p>
                                                                        </div>
                                                                        <div class="button-group d-flex pt-25">
                                                                            <a class="btn btn-danger btn-default btn-squared text-capitalize" href="{{ url('company/users/delete/'.$user->id) }}">
                                                                                Yes
                                                                            </a>
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
                                                </li>
                                            @endif
                                            @if($user->status == 0)
                                                <li>
                                                    <a href="{{ url('company/users/activate/'.$user->id) }}"><span data-feather="check" data-toggle="tooltip" data-placement="bottom" title="Activate User"></span></a>
                                                </li>
                                            @endif
                                            
                                            @if(!in_array($user->role,$role))
                                                <li style="display:inline-block;">
                                                    <a href="#" data-toggle="modal" data-target="#view_user_stats{{$user->id}}">
                                                        <span data-feather="pie-chart" data-toggle="tooltip" data-placement="bottom" title="View Stats"></span>
                                                    </a>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="view_user_stats{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="view_user_statsTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">User Stats</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p style="font-size: medium;"><strong> Successfull:</strong>
                                                                <span style="color: green;">
                                                                    @if($user->total_contact_count != null || $user->total_success_count != null)
                                                                        {{$user->total_success_count}}
                                                                        @if($user->total_contact_count != 0 && $user->total_success_count != 0)
                                                                            ({{round(($user->total_success_count / $user->total_contact_count) * 100 , 2 )}} %)
                                                                        @else
                                                                            (0 %)
                                                                        @endif
                                                                    
                                                                    @else
                                                                        0 (0 %)
                                                                    @endif
                                                                </span>
                                                                {{-- <span style="color: green;">{{$user->success}}
                                                                    @if($user->success != 0 && $user->campaign_contacts_count != 0)
                                                                        ({{round(($user->success / $user->campaign_contacts_count) * 100 ,2 ) }} %)
                                                                    @else
                                                                        (0 %)
                                                                    @endif
                                                                </span> --}}
                                                            </p>
                                                            <p style="font-size: medium;"><strong> Initiated: </strong>
                                                                <span style="color: blue;">
                                                                    {{-- {{$user->initiated}}
                                                                    @if($user->initiated != 0 && $user->campaign_contacts_count != 0)
                                                                        ({{round(($user->initiated / $user->campaign_contacts_count) * 100 , 2) }} %)
                                                                    @else
                                                                        (0 %)
                                                                    @endif --}}
                                                                    @if($user->total_contact_count != null || $user->total_initiated_count != null)
                                                                        {{$user->total_initiated_count}}
                                                                        @if($user->total_contact_count != 0 && $user->total_initiated_count != 0)
                                                                            ({{round(($user->total_initiated_count / $user->total_contact_count) * 100 , 2 )}} %)
                                                                        @else
                                                                            (0 %)
                                                                        @endif
                                                                    
                                                                    @else
                                                                        0 (0 %)
                                                                    @endif
                                                                </span>
                                                            </p>
                                                            <p style="font-size: medium;"><strong> Sent:</strong>
                                                                <span style="color: green;">
                                                                    @if($user->total_contact_count != null || $user->total_sent_count != null)
                                                                        {{$user->total_sent_count}}
                                                                        @if($user->total_contact_count != 0 && $user->total_sent_count != 0)
                                                                            ({{round(($user->total_sent_count / $user->total_contact_count) * 100 , 2 )}} %)
                                                                        @else
                                                                            (0 %)
                                                                        @endif
                                                                    
                                                                    @else
                                                                        0 (0 %)
                                                                    @endif
                                                                </span>
                                                            </p>
                                                            <p style="font-size: medium;"><strong> Pending: </strong>
                                                                <span style="color: yellowgreen;">
                                                                    {{-- {{$user->pending}}
                                                                    @if($user->pending != 0 && $user->campaign_contacts_count != 0)
                                                                        ({{round(($user->pending / $user->campaign_contacts_count) * 100 , 2) }} %)
                                                                    @else
                                                                        (0 %)
                                                                    @endif --}}
                                                                    @if($user->total_contact_count != null || $user->total_sent_count != null)
                                                                        <?php $pending = $user->total_contact_count != 0  ? $user->total_contact_count - $user->total_sent_count - $user->total_dnc_count : 0; ?> 
                                                                        {{$pending}}
                                                                        @if($pending != 0)
                                                                            ({{round(($pending / $user->total_contact_count) * 100 , 2 )}} %)
                                                                        @else
                                                                            (0 %)
                                                                        @endif
                                                                    @else
                                                                        0 (0 %)
                                                                    @endif
                                                                </span>
                                                            </p>
                                                            <p style="font-size: medium;"><strong> Failed: </strong>
                                                                <span style="color: red;">
                                                                    {{-- {{$user->fail}}
                                                                    @if($user->fail != 0 && $user->campaign_contacts_count != 0)
                                                                        ({{round(($user->fail / $user->campaign_contacts_count) * 100 , 2) }} %)
                                                                    @else
                                                                        (0 %)
                                                                    @endif --}}
                                                                    @if($user->total_contact_count != null || $user->total_failed_count != null)
                                                                        {{$user->total_failed_count}}
                                                                        @if($user->total_contact_count != 0 && $user->total_failed_count != 0)
                                                                            ({{round(($user->total_failed_count / $user->total_contact_count) * 100 , 2 )}} %)
                                                                        @else
                                                                            (0 %)
                                                                        @endif
                                                                    
                                                                    @else
                                                                        0 (0 %)
                                                                    @endif
                                                                </span>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </li>
                                            @endif
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

    function companyOption(e)
    {
        var role = e.target.value;

        if (role == 'user') {
            $("#create_company").show();
            $("#company").prop("required", true)
        }else{
            $("#create_company").hide();
            $("#company").prop("required", false)
            $("#company option[value='']").prop("selected", true)
        }
    }
</script>
@endsection
