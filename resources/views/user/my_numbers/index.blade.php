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
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main user-member justify-content-sm-between ">
                    @if(auth()->user()->role == "admin")
                        <a href="#" class="btn px-5 btn-primary"  data-toggle="modal" data-target="#upload_sw_list" style="position: absolute;top:0;right:13rem">Upload List</a>

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
                    @endif
                    <div class="action-btn" style="position: absolute;top: 0;right: 1%;">
                        <a href="#" class="btn px-15 btn-primary" data-toggle="modal" data-target="#purchase_new_number"
                        @if(auth()->user()->role == "company")
                        style="display:none" @else style="background-color: #003B76;display: inline-flex;" @endif> <i class="las la-plus fs-16"></i>Purchase New Number</a>

                        @if(auth()->user()->role != "company")
                            <div class="modal fade" id="purchase_new_number" tabindex="-1" role="dialog" aria-labelledby="purchase_new_numberTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Purchase New Number</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php
                                        if(auth()->user()->role == "user"){
                                            $searchURL = 'user.my_numbers.search';
                                        }else if(auth()->user()->role == "admin"){
                                            $searchURL = 'admin.my_numbers.search';
                                        }
                                    ?>
                                    <form action="{{route($searchURL)}}" method="post">
                                        @csrf
                                        <div class="modal-body">

                                                {{-- <div class="form-group mb-20">
                                                    <select name="filter" id="filter" class="form-control" onchange="numberLimit()" required>
                                                        <option value="" selected disabled>Search For Number</option>
                                                        <option value="contains">Containing</option>
                                                        <option value="starts_with">Starting With</option>
                                                        <option value="ends_with">Ending With</option>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-20">
                                                    <input type="text" name="number" id="number" class="form-control" placeholder="Any" required/>
                                                </div> --}}
                                            <div class="form-group mb-20">
                                                <select name="state" id="state" class="form-control" required onchange="getRateCenter(this.value)">
                                                    <option value="" selected disabled>Select State</option>
                                                    @if(is_null($call48States['error']))
                                                        @foreach ($call48States['data'] as $state)
                                                        <option value="{{$state['state_code']}}">{{$state['state_name']}}</option>
                                                        @endforeach
                                                    @endif

                                                </select>
                                            </div>
                                            <div class="form-group mb-20">
                                                <select name="ratecenter" id="ratecenter" class="form-control">
                                                    <option value="" selected disabled>Select Ratecenter</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-20">
                                                <input type="text" name="npa" id="npa" class="form-control" placeholder="npa"/>
                                            </div>
                                            <div class="form-group mb-20">
                                                <input type="text" name="nxx" id="nxx" class="form-control" placeholder="nxx"/>
                                            </div>
                                            <div class="form-group mb-20">
                                                <input type="text" name="limit" id="limit" class="form-control" placeholder="limit" required/>
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
                        @endif
                    </div>

                    <?php

                        $tab = "client";
                        if(\Request::exists('client_search')  || \Request::get('client')){
                            $tab = "client";
                        }elseif( \Request::exists('callzy_search') || \Request::get('callzy')){
                            $tab = "callzy";
                        }

                    ?>
                    <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30 mt-30">
                        {{-- tabs start --}}
                        <nav>
                          <div class="nav nav-tabs" id="nav-tab" role="tablist">

                            <a class="nav-link <?php if($tab == "client") echo "active"; else echo ""; ?>" id="nav-client-number-tab" data-toggle="tab" href="#nav-client-number"
                                role="tab" aria-controls="nav-client-number" aria-selected="true">Client Numbers</a>
                            <a class="nav-link <?php if($tab == "callzy") echo "active"; else echo ""; ?>"
                                id="nav-callzy-number-tab" data-toggle="tab" href="#nav-callzy-number"
                            role="tab" aria-controls="nav-callzy-number" aria-selected="true" @if(auth()->user()->role == "company")
                            style="display:none" @else style="display:block" @endif>Callzy Numbers</a>
                          </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">

                          {{-- client tab start --}}
                          <div class="tab-pane fade <?php if($tab == "client") echo "show active"; else echo ""; ?>" id="nav-client-number" role="tabpanel" aria-labelledby="nav-client-number-tab" style="margin-top: 1rem;">
                            <div class="">
                                <?php
                                    if(auth()->user()->role == "company")
                                    {
                                        $numberURL = 'company.my_numbers';
                                    }else  if(auth()->user()->role == "user"){
                                        $numberURL = 'user.my_numbers';
                                    }else if(auth()->user()->role == "admin"){
                                        $numberURL = 'admin.numbers';
                                    }
                                ?>
                                <form action="{{route($numberURL)}}" method="get">
                                    <div class="row mb-2 ml-1">
                                       <input type="text" class="form-control col-2 mr-1" name="client_search" id="client_search" value="{{\Request::get('client_search')}}">

                                       <button type="submit" class="btn btn-primary col-1">Search</button>
                                    </div>
                                </form>
                               <table id="clientNumberDatatable" class="table table-striped table-bordered" style="width:100%;">
                                   <thead>
                                   <tr class="userDatatable-header">
                                       <th scope="col">
                                           <span class="userDatatable-title">Caller ID</span>
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
                                                    @if(auth()->user()->role == "user")
                                                        @if($number->status == 'active')
                                                            <ul class="mb-0 flex-wrap">
                                                                <li style="display:inline;">
                                                                    <a href="" class="edit" id="edit-list" data-toggle="modal" data-target="#edit_client_number{{$number->id}}"><span data-feather="hash" data-toggle="tooltip" data-placement="bottom" title="NumberConfig"></span></a>
                                                                    <div class="modal fade" id="edit_client_number{{$number->id}}" tabindex="-1" role="dialog" aria-labelledby="add_new_groupTitle" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="exampleModalLongTitle">Number Config</h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form action="{{route('user.update_my_number',[$number->id,'client_search='])}}" method="post">
                                                                                        @csrf
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input" type="radio" name="ivr_enabled" id="ivr_enabled_{{$number->id}}"
                                                                                            @if($number->ivr_enabled == false) checked  @endif value="No" onclick="enableIvrSettings({{$number->id}},this.value)">
                                                                                            <label class="form-check-label" for="flexRadioDefault1">
                                                                                              Forward
                                                                                            </label>
                                                                                          </div>
                                                                                          <div class="form-check">
                                                                                            <input class="form-check-input" type="radio" name="ivr_enabled" id="ivr_enabled_{{$number->id}}"
                                                                                            @if($number->ivr_enabled) checked  @endif value="Yes"  onclick="enableIvrSettings({{$number->id}},this.value)">
                                                                                            <label class="form-check-label" for="flexRadioDefault2">
                                                                                              Enable an IVR
                                                                                            </label>
                                                                                          </div>
                                                                                        {{-- @if($number->type == 'ClientNumber')
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
                                                                                        @endif --}}
                                                                                        <div class="form-group mb-20 mt-2" id="forward_div_{{$number->id}}"
                                                                                            @if($number->ivr_enabled == false)
                                                                                            style="display:block;" @else style="display:none;" @endif>
                                                                                            {{-- <label for="">Forward</label> --}}
                                                                                            <input type="text" minlength="14"
                                                                                            maxlength="14" name="forward_to_number" id="forward_to_number"
                                                                                            class="form-control forward_to_number" placeholder="Forward Number"
                                                                                            value="{{$number->forward_to_number}}">
                                                                                        </div>
                                                                                        {{-- <div class="form-group mb-20">
                                                                                            <div class="row">
                                                                                                <input type="checkbox"
                                                                                                style="width:12px;margin-left:1.5rem;margin-right:5px;box-shadow:none;"
                                                                                                name="ivr_enabled" id="ivr_enabled_{{$number->id}}" class="form-control"
                                                                                                @if($number->ivr_enabled) checked  @endif
                                                                                                value="Yes"
                                                                                                onclick="enableIvrSettings({{$number->id}})"
                                                                                                >
                                                                                                <label style="margin-top:3px;" for="ivr_enabled">Check to enable an IVR</label>
                                                                                            </div>

                                                                                        </div> --}}

                                                                                        <div id="ivr_settings_{{$number->id}}" class="form-group mb-20 mt-2 ivr_settings" @if($number->ivr_enabled)
                                                                                            style="display:block;" @else style="display:none;" @endif>
                                                                                            <p>Upload or Select Audio</p>

                                                                                            <select name="recording" id="recording" class="form-control selectpicker">
                                                                                                <option disabled selected>Click to select Recording</option>
                                                                                                @if($recordings->isNotEmpty())
                                                                                                    @foreach($recordings as $rec)
                                                                                                        <option @if($number->recording_id !==  null && $rec->id == $number->recording_id) selected @endif value="{{$rec->id}}">{{$rec->name}}</option>
                                                                                                    @endforeach
                                                                                                @endif
                                                                                            </select>
                                                                                            <div class="action-btn mt-2 mb-2">
                                                                                                <a href="#" class="btn btn-sm btn-primary"  data-toggle="modal"
                                                                                                data-target="#add_recording_modal">
                                                                                                <i class="las la-plus fs-16"></i>Upload New Recording</a>
                                                                                                 {{-- loader model --}}
                                                                                               <div class="modal fade" id="loader-modal-recording" tabindex="-1" role="dialog" aria-labelledby="loader_modalTitle" aria-hidden="true">
                                                                                                  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                                                                    <div class="modal-content">
                                                                                                      <div class="modal-header">
                                                                                                        <h5 class="modal-title" id="exampleModalLongTitle">Your Recording Is Adding</h5>
                                                                                                      </div>
                                                                                                      <div class="modal-body text-center" style="padding: 20px 75px 20px 75px">
                                                                                                          <div class="spinner-border text-info spin"></div>
                                                                                                          <div id='seconds-counter-recording'> </div>
                                                                                                      </div>
                                                                                                    </div>
                                                                                                  </div>
                                                                                               </div>
                                                                                              {{-- loader model end --}}
                                                                                            </div>

                                                                                            <label>Optin Digit</label>
                                                                                            <div class="mb-20">
                                                                                                <select name="continue_digit" id="opt_in_number" class="form-control"
                                                                                                onchange="opt_Val()">
                                                                                                    <option value="">Select One</option>
                                                                                                    @for ($i = 0; $i < 10; $i++)
                                                                                                        <option value="{{$i}}" @if($number->continue_digit !== null && $number->continue_digit ==  $i) selected @endif>{{$i}}</option>
                                                                                                    @endfor
                                                                                                </select>
                                                                                            </div>
                                                                                            <label>Opt Out Digit</label>
                                                                                            <div class="mb-20">
                                                                                            <select name="optout_digit" id="opt_out_number" class="form-control"
                                                                                            onchange="opt_Val()">
                                                                                                <option value="">Select One</option>
                                                                                                @for ($i = 0; $i < 10; $i++)
                                                                                                    <option value="{{$i}}" @if($number->optout_digit !== null && $number->optout_digit ==  $i) selected @endif>{{$i}}</option>
                                                                                                @endfor
                                                                                            </select>
                                                                                            </div>
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
                                                                </li>
                                                                {{-- <li style="display:inline;">
                                                                    <a href="" data-toggle="modal" data-target="#delete_client_number{{$number->id}}" ><span data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Delete Number"></span></a>

                                                                    <div class="modal fade delete_number" id="delete_client_number{{$number->id}}" role="dialog" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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

                                                                                            <a href="{{url('user/my-numbers/delete/'.$number->id.'?client_search=')}}" style="text-decoration: none;">
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

                                                                </li> --}}
                                                            </ul>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                       @endforeach
                                   </tbody>
                               </table>
                               {!! $clientNumbers->appends(request()->except('page','callzy'))->links() !!}
                           </div>
                         </div>
                          {{-- client tab end --}}
                          {{-- @if(auth()->user()->role == "user") --}}
                          {{-- callzy tab start --}}
                            <div class="tab-pane fade <?php if($tab == "callzy") echo "show active"; else echo ""; ?>" id="nav-callzy-number" role="tabpanel" aria-labelledby="nav-callzy-number-tab" style="margin-top: 1rem;">
                                <div class="">
                                    <?php
                                        if(auth()->user()->role == "company")
                                        {
                                            $numberURL = 'company.my_numbers';
                                        }else  if(auth()->user()->role == "user"){
                                            $numberURL = 'user.my_numbers';
                                        }else if(auth()->user()->role == "admin"){
                                            $numberURL = 'admin.numbers';
                                        }
                                    ?>
                                    <form action="{{route($numberURL)}}" method="get">
                                        <div class="row mb-2 ml-1">
                                        <input type="text" class="form-control col-2 mr-1" name="callzy_search" id="callzy_search" value="{{\Request::get('callzy_search')}}">

                                        <button type="submit" class="btn btn-primary col-1">Search</button>
                                        </div>
                                    </form>
                                    <table id="callzyNumberDatatable" class="table table-striped table-bordered" style="width:100%;">
                                        <thead>
                                        <tr class="userDatatable-header">
                                            <th scope="col">
                                                <span class="userDatatable-title">Caller ID</span>
                                            </th>
                                            <th scope="col">
                                                <span class="userDatatable-title">Status</span>
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
                                                        {{-- <td>
                                                            @if($number->status == 'active')
                                                                <ul class="mb-0 flex-wrap">
                                                                    <li style="display:inline;">
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
                                                                                        <form action="{{route('user.my_groups.update_my_number',[$number->id,'callzy_search='])}}" method="post">
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
                                                                    </li>
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

                                                                                                <a href="{{url('user/my-numbers/delete/'.$number->id.'?client_search=')}}" style="text-decoration: none;">
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
                                                        </td> --}}
                                                        <td>
                                                            {{-- @if(auth()->user()->role == "admin")
                                                                @if($number->status == 'active')
                                                                    <ul class="mb-0 flex-wrap">
                                                                        <li style="display:inline;">
                                                                            <a href="" data-toggle="modal" data-target="#delete_callzy_number{{$number->id}}" ><span data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Delete Number"></span></a>

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

                                                                        </li>
                                                                    </ul>
                                                                @endif
                                                            @endif --}}
                                                        </td>
                                                    </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {!! $callzyNumbers->appends(request()->except('page','client'))->links() !!}
                                </div>
                            </div>
                         {{-- @endif --}}
                          {{-- callzy tab end --}}
                        </div>
                       {{-- tabs end --}}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- recording modal --}}
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
                <form action="" id="recordingCampaignForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-20">
                        <label for="">Recording Name</label>
                        <input type="text" name="name" id="recordingName" style="border: 1px solid #ced4da !important;" class="form-control" placeholder="Recording Name" required>
                    </div>
                    <div class="form-group mb-20">
                        <label for="recording">Upload Recording</label>
                        <input type="file" name="file" id="recordingFile" style="border: 1px solid #ced4da !important;" class="form-control" required accept=".mp3,.wav">
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" onclick="addRecording(event)" class="btn btn-primary">Add Recording</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
@if(auth()->user()->role == "admin")
    <input type="hidden" id="getCall48StateRateCenterURL" value="{{route('admin.my_numbers.getStateRateCenter')}}"/>
    <input type="hidden" id="validateSwListCsvUrl" value="{{route('admin.contact-list.validate_csv')}}">
@elseif(auth()->user()->role == "user")
    <input type="hidden" id="getCall48StateRateCenterURL" value="{{route('user.my_numbers.getStateRateCenter')}}"/>
    {{-- <input type="hidden" id="getAllRecordingsURL" value="{{route('user.campaign.get_campaign_recordings')}}"> --}}
    <input type="hidden" id="recordingStoreUrl" value="{{route('user.recording.ajaxStore')}}">
@endif

<script>
    $(document).ready(function() {

        $('#clientNumberDatatable').DataTable( {
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


        // var x = document.getElementById("filter").value;
        // $("#number").val('');
        // if (x == "contains") {

        //     document.getElementById("number").maxLength = "5";
        //     document.getElementById("number").minLength = "3";
        // }
        // if (x == "starts_with") {
        //     document.getElementById("number").maxLength = "3";
        //     document.getElementById("number").minLength = "3";
        // }
        // if (x == "ends_with") {
        //     document.getElementById("number").maxLength = "4";
        //     document.getElementById("number").minLength = "3";
        // }
        // if (x == "") {
        //     document.getElementById("number").minLength = "0";
        //     document.getElementById("number").maxLength = "0";
        // }

        $('#new_number').mask('(000) 000-0000');
        $('#number').mask('00000');

        $('.my_number').mask('(000) 000-0000');
        $('.forward_to_number').mask('(000) 000-0000');

        $('#alert-success').delay(7000).fadeOut();
        $('#alert-danger').delay(7000).fadeOut();

        $('.selectpicker').selectpicker({size:10});

        // enable ivr settings
        // let numberId = $('#my_number_id').val()
        // -------------- fetch all recordings  ----------------
    //     let recordingSelect = $(`#ivr_settings_${numberId} button`);
    //     let recordingFlag = false;

    //     recordingSelect.click(function(){
    //         if(recordingFlag === false){
    //             $('.recording-loader').remove();
    //             recordingSelect.append('<div class="recording-loader spinner-border spinner-border-sm"></div>');
    //             $.ajax({
    //                 type: 'GET',
    //                 headers: {
    //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                 },
    //                 contentType: false,
    //                 processData:false,
    //                 url: $('#getAllRecordingsURL').val(),
    //                 success: function (response) {
    //                 recordingFlag = true;

    //                 if(response.length >0){
    //                     $('#recording').empty();
    //                     $('#recording').append('<option disabled  Selected>Click to select Recording</option>');
    //                     for(let i=0;i<response.length;i++){
    //                         $('#recording').append('<option value="'+response[i].id+'">'+response[i].name+'</option>')
    //                     }
    //                 }else{
    //                     alert('0 recording found.');
    //                 }
    //                 $('#recording').selectpicker('refresh');
    //                 console.log('Recording loaded successful.');
    //                 },
    //                 beforeSend: function(){
    //                     $('.recording-loader').show()
    //                 },
    //                 complete: function(){
    //                     $('.recording-loader').hide();
    //                 },
    //                 error: function (data) {
    //                     console.log('An error occurred.');
    //                     console.log(data);
    //                 },
    //             });
    //         }

    //     });


    });

    function enableIvrSettings(numberId,value){

        if(value ===  "No"){
            $(`#forward_div_${numberId}`).show();
            $(`#ivr_settings_${numberId}`).hide();
        }else if(value ===  "Yes"){
            $(`#forward_div_${numberId}`).hide();
            $(`#ivr_settings_${numberId}`).show();
        }

        // console.log(`#ivr_settings_${numberId}`)
        // if($(`#ivr_enabled_${numberId}`).prop("checked") == true){
        //     $(`#ivr_settings_${numberId}`).show();
        //     $(`#ivr_enabled_${numberId}`).val('Yes');
        // }
        // else if($(`#ivr_enabled_${numberId}`).prop("checked") == false){
        //     $(`#ivr_settings_${numberId}`).hide();
        //     $(`#ivr_enabled_${numberId}`).val('No');
        // }

    }

    function recordingLoader()
    {
      $('#loader-modal-recording').modal({
            backdrop: 'static',
            keyboard: false
        });
        // $('.spin').show();
        $('#add_recording_modal').modal('hide');
        $('#loader-modal-recording').modal('show');
    }

    function addRecording(e)
    {
        e.preventDefault();
        if($( '#recordingName' ).val() === '')
        {
            alert('Name is required');
            return;
        }
        if($( '#recordingFile' )[0].files.length === 0){
            alert('File is required');
            return;
        }
        recordingLoader();
        let ajaxData = new FormData();
        ajaxData.append( 'name', $( '#recordingName' ).val());
        ajaxData.append( 'file', $( '#recordingFile' )[0].files[0]);

        $('#recording').empty();

        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: false,
            processData:false,
            url: document.getElementById('recordingStoreUrl').value,
            data: ajaxData,
            success: function (data) {

                $('#recordingName' ).val('');
                $('#recordingFile' ).val('');

                setTimeout(function () {
                    $('#loader-modal-recording').modal('hide');
                }, 1000);

                $('#recording').append('<option Selected disabled>Click to select Recording</option>');
                var response = data['recording'];
                if(response !== null){
                    for(let i=0;i<response.length;i++){
                        $('#recording').append('<option value="'+response[i].id+'">'+response[i].name+'</option>')
                    }
                }else{
                 alert('recording not added');
                }
                $('#recording').selectpicker('refresh');
                console.log('Submission was successful.');
                // console.log(data);
                $('#add_recording_modal').modal('hide');
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    }

    function opt_Val()
    {
        var opt_in = $('#opt_in_number').val();
        var opt_out = $('#opt_out_number').val();

        if (opt_in !== "" && opt_out !== "") {
            if (opt_in == opt_out) {
                alert('Opt Out Number Must be different From Opt In Number');
                $('#opt_out_number').val('');
            }
        }
    }

    function loader()
    {
        $('#loader-modal').modal({
            backdrop: 'static',
            keyboard: false
        });

        $('#loader-modal').modal('show');
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

    async function getRateCenter(val){
        $('#ratecenter').empty();
        let baseUrl = $('#getCall48StateRateCenterURL').val();
        await axios.post(baseUrl, {
            // params: {
            //     page: page,
            //     limit: limit,

            // },
            data: {
                state_id: val,
            },
        })
        .then(response => {
            if(response['data']['error'] === null){
                let data = response['data']['data'];
                $('#ratecenter').append('<option disabled  Selected>Select Ratecenter</option>');
                for(let i=0;i<data.length;i++){
                  $('#ratecenter').append('<option value="'+data[i].rate_center+'">'+data[i].rate_center+'</option>')

                }
            }
        });
    }

    function closeAlert()
    {
        //document.getElementById('alert-success').style.display = "none";
        //document.getElementById('alert-danger').style.display = "none";
        $('#alert-success').hide();
        $('#alert-danger').hide();
    }
</script>
@endsection
