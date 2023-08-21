@extends('layouts.app')
@section('content')
<style type="text/css">
.bootstrap-select>.dropdown-toggle
 {
     width: 50%;
 }
 .bootstrap-select .dropdown-menu
 {
    min-width: 51%;
    position: initial !important;
 }
</style>
<div class="contents">
    <div class="container-fluid">
        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main user-member justify-content-sm-between ">
                    <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                        <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                            <h4 class="text-capitalize fw-500 breadcrumb-title">My Numbers</h4>
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
                                            <li>{{session('success')}}</li>
                                        </ul>
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
                    <div class="row">
                        <div class="col-6">
                                <a href="#" class="btn px-5 btn-primary"  data-toggle="modal" data-target="#upload_sw_list">Upload List</a>
                                <div class="modal fade" id="upload_sw_list" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Upload List</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" style="padding: 20px 75px 20px 75px">
                                               
                                                <form action="{{route('admin.upload.sw-list')}}" method="POSt" enctype="multipart/form-data" onsubmit="loader()">
                                                    @csrf
                                                    <div class="form-group mb-20">
                                                    <input type="file" name="file" id="file" class="form-control" accept=".csv" onchange="csvValidate()" required>
                                                    </div>
        
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" id="addSwListSubmitBtn"
                                                         class="btn btn-primary" style="background-color: #003B76">Upload</button>
                                                         <div style="display: none;" class="contact-list-validate-loader spinner-border spinner-border-sm"></div>
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
                        <div class="col-6">
                            <a href="#" class="btn px-5 btn-primary" data-toggle="modal" data-target="#purchase_new_number" 
                            style="background-color: #003B76;display: inline-flex;"> 
                            <i class="las la-plus fs-14"></i>Purchase</a>
    
                            <div class="modal fade" id="purchase_new_number" tabindex="-1" role="dialog" aria-labelledby="purchase_new_numberTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Purchase New Number</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('admin.my_numbers.search')}}" method="post">
                                         @csrf 
                                            <div class="form-group mb-20">
                                                <select name="filter" id="filter" class="form-control" onchange="numberLimit()" required>
                                                    <option value="" selected disabled>Search For Number</option>
                                                    <option value="contains">Containing</option>
                                                    <option value="starts_with">Starting With</option>
                                                    <option value="ends_with">Ending With</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-20">
                                                <input type="text" name="number" id="number" class="form-control" placeholder="Any" required/>
                                            </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" style="background-color: #003B76">Search</button>
                                            </div>
                                     </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Ends -->
                        </div>
                    </div>
                    
                    
                    <?php
                        
                        $tab = "number";
                        if(\Request::exists('search')  || \Request::get('page')){
                            $tab = "number";
                        }elseif( \Request::exists('callzy_search') || \Request::get('callzy')){
                            $tab = "callzy";
                        }
                        
                    ?>
                    <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30 mt-30">
                        {{-- tabs start --}}
                        <nav>
                          <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            
                            <a class="nav-link <?php if($tab == "number") echo "active"; else echo ""; ?>"
                                 id="nav-number-tab" data-toggle="tab" href="#nav-number" role="tab" aria-controls="nav-number" 
                                 aria-selected="true">Client Numbers</a>
                            <a class="nav-link <?php if($tab == "callzy") echo "active"; else echo ""; ?>" 
                                id="nav-callzy-number-tab" data-toggle="tab" href="#nav-callzy-number" 
                            role="tab" aria-controls="nav-callzy-number" aria-selected="true">Callzy Numbers</a>
                           
                          </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">

                          <div class="tab-pane fade <?php if($tab == "number") echo "show active"; else echo ""; ?>" id="nav-number" role="tabpanel" aria-labelledby="nav-number-tab" style="margin-top: 1rem;">
                             <div class="">
                                 <form action="{{route('admin.numbers')}}" method="get">
                                     <div class="row mb-2 ml-1">
                                        <input type="text" class="form-control col-2 mr-1" name="search" id="search" value="{{\Request::get('search')}}">
                                        
                                        <button type="submit" class="btn btn-primary col-1">Search</button>
                                     </div>
                                 </form>
                                <table id="numberDatatable" class="table table-striped table-bordered" style="width:100%;">
                                    <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <span class="userDatatable-title">Caller ID</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Forward Number</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Status</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Created At</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Type</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Added By</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Actions</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($clientNumbers as $number)
                                        <tr>
                                            <td>{{$number->number}}</td>
                                            <td>{{$number->forward_to_number}}</td>
                                            <td>
                                                    @if($number->status == 'active')
                                                    <div class="userDatatable-content d-inline-block">
                                                        <span class="bg-opacity-success  color-success rounded-pill userDatatable-content-status active">active</span>
                                                    </div>
                                                    @else
                                                    <div class="userDatatable-content d-inline-block">
                                                        <span class="bg-opacity-danger  color-danger rounded-pill userDatatable-content-status active">Deleted</span>
                                                    </div>
                                                    @endif 
                                            </td>
                                            <td>{{$number->created_at}}</td>
                                            <td>{{$number->type}}</td>
                                            <td>{{$number->user->first_name}}</td>
                                            <td>
                                                @if($number->status == 'active')
                                                <ul class="mb-0 flex-wrap">
                                                    <li style="display:inline;">
                                                        <a href="" class="edit" id="edit-list" data-toggle="modal" data-target="#edit_number{{$number->id}}"><span data-feather="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Number"></span></a>
                                                        <div class="modal fade" id="edit_number{{$number->id}}" tabindex="-1" role="dialog" aria-labelledby="add_new_groupTitle" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle">Edit Number</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                    @php
                                                                        if(auth()->user()->role == "user")
                                                                            $groupUpdateMyNumberURL = 'user.my_groups.update_my_number';
                                                                        else
                                                                            $groupUpdateMyNumberURL = 'admin.my_groups.update_my_number';
                                                                    @endphp
                                                                        <form action="{{route($groupUpdateMyNumberURL,[$number->id,'search='])}}" method="post">
                                                                            @csrf
                                                                            @if($number->type == 'ClientNumber') 
                                                                                <div class="form-group mb-20">
                                                                                    <label for="">Forward</label>
                                                                                    <input 
                                                                                    type="text" name="forward_to_number"
                                                                                    minlength="14" maxlength="14"
                                                                                    id="forward_to_number" class="form-control forward_to_number" 
                                                                                    placeholder="Forward Number" value="{{$number->forward_to_number}}" >
                                                                                </div>
                                                                            @else
                                                                                <div class="form-group mb-20">
                                                                                    <label for="">Caller Id</label>
                                                                                    <input type="text" 
                                                                                    name="my_number" 
                                                                                    minlength="14" maxlength="14"
                                                                                    id="my_number" class="form-control my_number" 
                                                                                    placeholder="My Number" value="{{$number->number}}" required >
                                                                                </div>
                                                                                <div class="form-group mb-20">
                                                                                    <label for="">Forward</label>
                                                                                    <input type="text" minlength="14" 
                                                                                    maxlength="14" name="forward_to_number" id="forward_to_number" 
                                                                                    class="form-control forward_to_number" placeholder="Forward Number" 
                                                                                    value="{{$number->forward_to_number}}">
                                                                                </div>
                                                                            @endif
                                                                            
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn btn-primary" style="background-color: #003B76">Update Number</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li style="display:inline;">
                                                        <a href="" data-toggle="modal" data-target="#delete_number{{$number->id}}" ><span data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Delete Number"></span></a>
                                                        <!-- Confirmation Modal -->
                                                        <div class="modal fade delete_number" id="delete_number{{$number->id}}" role="dialog" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                                                            <div class="button-group d-flex pt-25">

                                                                                <a href="{{url('admin/my-numbers/delete/'.$number->id)}}" style="text-decoration: none;">
                                                                                    <button type="button" class="btn btn-danger" >Yes</button>
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
                                                </ul>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {!! $clientNumbers->appends(request()->except('page','callzy'))->links() !!}
                            </div>
                          </div>
                          {{-- my number tab end --}}
                          {{-- callzy tab start --}}
                          <div class="tab-pane fade  <?php if($tab == "callzy") echo "show active"; else echo ""; ?>" id="nav-callzy-number" role="tabpanel" aria-labelledby="nav-callzy-number-tab" style="margin-top: 1rem;">
                            <div class="">
                                <form action="{{route('admin.numbers')}}" method="get">
                                    <div class="row mb-2 ml-1">
                                       <input type="text" class="form-control col-2 mr-1" name="callzy_search" id="callzy_search" value="{{\Request::get('callzy_search')}}">
                                       
                                       <button type="submit" class="btn btn-primary col-1">Search</button>
                                    </div>
                                </form>
                               <table id="callzyNumberDatatable" class="table table-striped table-bordered" style="width:100%;">
                                   <thead>
                                   <tr class="userDatatable-header">
                                       <th>
                                           <span class="userDatatable-title">Caller ID</span>
                                       </th>
                                       {{-- <th>
                                           <span class="userDatatable-title">Forward Number</span>
                                       </th> --}}
                                       <th>
                                           <span class="userDatatable-title">Status</span>
                                       </th>
                                       <th>
                                           <span class="userDatatable-title">Created At</span>
                                       </th>
                                       {{-- <th>
                                           <span class="userDatatable-title">Type</span>
                                       </th>
                                       <th>
                                           <span class="userDatatable-title">Added By</span>
                                       </th> --}}
                                       <th>
                                           <span class="userDatatable-title">Actions</span>
                                       </th>
                                   </tr>
                                   </thead>
                                   <tbody>
                                       @foreach($callzyNumbers as $number)
                                       
                                            <tr>
                                                <td>{{$number->phone_number}}</td>
                                                {{-- <td>{{$number->forward_to_number}}</td> --}}
                                                <td>
                                                        @if($number->status == 'active')
                                                            <div class="userDatatable-content d-inline-block">
                                                                <span class="bg-opacity-success  color-success rounded-pill userDatatable-content-status active">active</span>
                                                            </div>
                                                        @else
                                                            <div class="userDatatable-content d-inline-block">
                                                                <span class="bg-opacity-danger  color-danger rounded-pill userDatatable-content-status active">Deleted</span>
                                                            </div>
                                                        @endif 
                                                </td>
                                                <td>{{$number->created_at}}</td>
                                                {{-- <td>{{$number->type}}</td>
                                                <td>{{$number->user->first_name}}</td> --}}
                                                <td>
                                                    @if($number->status == 'active')
                                                        <ul class="mb-0 flex-wrap">
                                                            {{-- <li style="display:inline;">
                                                                <a href="" class="edit" id="edit-list" data-toggle="modal" data-target="#edit_callzy_number{{$number->id}}"><span data-feather="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Number"></span></a>
                                                                <div class="modal fade" id="edit_callzy_number{{$number->id}}" tabindex="-1" role="dialog" aria-labelledby="add_new_groupTitle" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLongTitle">Edit Number</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                @php
                                                                                    if(auth()->user()->role == "user")
                                                                                        $groupUpdateCallzyMyNumberURL = 'user.my_groups.update_my_number';
                                                                                    else
                                                                                        $groupUpdateCallzyMyNumberURL = 'admin.my_groups.update_my_number';
                                                                                @endphp
                                                                                <form action="{{route($groupUpdateCallzyMyNumberURL,[$number->id,'callzy_search='])}}" method="post">
                                                                                    @csrf
                                                                                    @if($number->type == 'CallzyOwned') 
                                                                                        <div class="form-group mb-20">
                                                                                            <label for="">Forward</label>
                                                                                            <input 
                                                                                            type="text" name="forward_to_number"
                                                                                            minlength="14" maxlength="14"
                                                                                            id="forward_to_number" class="form-control forward_to_number" 
                                                                                            placeholder="Forward Number" value="{{$number->forward_to_number}}">
                                                                                        </div>
                                                                                    @else
                                                                                        <div class="form-group mb-20">
                                                                                            <label for="">Caller Id</label>
                                                                                            <input type="text" 
                                                                                            name="my_number" 
                                                                                            minlength="14" maxlength="14"
                                                                                            id="my_number" class="form-control my_number" 
                                                                                            placeholder="My Number" value="{{$number->number}}" required >
                                                                                        </div>
                                                                                        <div class="form-group mb-20">
                                                                                            <label for="">Forward</label>
                                                                                            <input type="text" minlength="14" 
                                                                                            maxlength="14" name="forward_to_number" id="forward_to_number" 
                                                                                            class="form-control forward_to_number" placeholder="Forward Number" 
                                                                                            value="{{$number->forward_to_number}}">
                                                                                        </div>
                                                                                    @endif
                                                                                    
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                        <button type="submit" class="btn btn-primary" style="background-color: #003B76">Update Number</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li> --}}
                                                            <li style="display:inline;">
                                                                <a href="" data-toggle="modal" data-target="#delete_callzy_number{{$number->id}}" ><span data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Delete Number"></span></a>
                                                                <!-- Confirmation Modal -->
                                                                <div class="modal fade delete_number" id="delete_callzy_number{{$number->id}}" role="dialog" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                                                                    <div class="button-group d-flex pt-25">

                                                                                        <a href="{{url('admin/my-numbers/delete/'.$number->id.'?callzy_search=')}}" style="text-decoration: none;">
                                                                                            <button type="button" class="btn btn-danger" >Yes</button>
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
                                                        </ul>
                                                    @endif
                                                </td>
                                            </tr>
                                       @endforeach
                                   </tbody>
                               </table>
                               {!! $callzyNumbers->appends(request()->except('page','callzy'))->links() !!}
                           </div>
                         </div>
                          {{-- callzy tab end --}}
                        
                        </div>
                       {{-- tabs end --}}
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<input type="hidden" id="validateSwListCsvUrl" value="{{route('admin.contact-list.validate_csv')}}">
<script>
    $(document).ready(function() {
        $('#numberDatatable').DataTable( {
            "order": [],
            "bPaginate": false,
            "bInfo": false,
            searching: false,
        } );
        
        $('#callzyNumberDatatable').DataTable( {
            "order": [],
            "bPaginate": false,
            "bInfo": false,
            searching: false,
        } );
       
    
    $('#new_number').mask('(000) 000-0000');
    $('#number').mask('00000');
    
    $('.my_number').mask('(000) 000-0000');
    $('.forward_to_number').mask('(000) 000-0000');

    $('#alert-success').delay(7000).fadeOut();
    $('#alert-danger').delay(7000).fadeOut();

    $('.selectpicker').selectpicker({size:10});
    
    });

    // function csvValidate()
    // {
    //     var fileInput = document.getElementById('file');
    //     var filePath = fileInput.value;
    //     var allowedExtensions = /(\.csv)$/i;
    //     if(!allowedExtensions.exec(filePath)){
    //         alert('Only CSV files are allowed');
    //         fileInput.value = '';
    //         return false;
    //     }
    // }

    function loader()
    {
        $('#loader-modal').modal({
            backdrop: 'static',
            keyboard: false
        });

        $('#loader-modal').modal('show');
    }

    function numberLimit()
    {
        var x = document.getElementById("filter").value;
        $("#number").val('');
        if (x == "contains") {
            
            document.getElementById("number").maxLength = "5";
            document.getElementById("number").minLength = "3";
        }
        if (x == "starts_with") {
            document.getElementById("number").maxLength = "3";
            document.getElementById("number").minLength = "3";
        }
        if (x == "ends_with") {
            document.getElementById("number").maxLength = "4";
            document.getElementById("number").minLength = "3";
        }
        if (x == "") {
            document.getElementById("number").maxLength = "0";
        }
    }

    function closeAlert()
    {
        $('#alert-success').hide();
        $('#alert-danger').hide();
    }

    function csvValidate()
    {
        var fileInput = document.getElementById('file');
        var filePath = fileInput.value;

        var allowedExtensions = /(\.csv)$/i;
        // console.log(filePath,allowedExtensions);
        if(!allowedExtensions.exec(filePath)){
            alert('Please choose a csv file');
            fileInput.value = '';
            return false;
        }

        let ajaxData = new FormData();
            ajaxData.append( 'file', $( '#file' )[0].files[0]);
            $('#addSwListSubmitBtn').css('pointer-events','none');
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: false,
            processData:false,
            url: document.getElementById('validateSwListCsvUrl').value,
            data: ajaxData,
            success: function (data) {
                // console.log(data['success'])
                if(data['success']){
                    $('#addSwListSubmitBtn').css('pointer-events','none');
                    alert('Please add a phone column to your CSV.');
                    fileInput.value = '';
                }else{
                    $('#addSwListSubmitBtn').css('pointer-events','');
                }
            },
            beforeSend: function(){
                $('.contact-list-validate-loader').show()
            },
            complete: function(){
                $('.contact-list-validate-loader').hide();
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    }
</script>
@endsection