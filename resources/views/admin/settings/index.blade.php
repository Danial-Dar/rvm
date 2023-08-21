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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">Api Setting</h4>
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

                    <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30 mt-30">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr class="userDatatable-header">
                                    <th>
                                        <span class="userDatatable-title">Name</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <!-- RVM API SETTINGS Start-->
                                    <tr>
                                        <td>RVM</td>

                                        <td>
                                            <ul class="orderDatatable_actions mb-0">
                                                <li>
                                                    <a href="#" class="edit" id="view_rvm"  data-id="rvm" data-toggle="modal" data-target="#view_rvm_modal"  ><span data-feather="eye" data-toggle="tooltip" data-placement="bottom" title="View Rvm"></span></a>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="view_rvm_modal" tabindex="-1" role="dialog" aria-labelledby="view_rvm_modalTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="update_company_modalTitle">Rvm Api Settings</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body"  style="padding: 20px 75px 20px 75px">
                                                                    <form action="{{route('admin/api-setting.store')}}" method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <input type="hidden" name="id" value="{{$rvm_api_setting !== null ? $rvm_api_setting->id : 0 }}">
                                                                        <input type="hidden" name="slug" value="{{$rvm_api_setting !== null ? $rvm_api_setting->slug : 'rvm' }}">
                                                                        <label>End Point</label>
                                                                        <div class="form-group mb-20">
                                                                            <input type="text" name="end_point" id="" class="form-control" value="{{$rvm_api_setting !== null ? $rvm_api_setting->end_point : '' }}" placeholder="End Point" required>
                                                                        </div>
                                                                        <label>Carrier Address</label>
                                                                        <div class="form-group mb-20">
                                                                            <input type="text" name="carrier_address" value="{{$rvm_api_setting !== null ? $rvm_api_setting->carrier_address : '' }}" id="" class="form-control" placeholder="Carrier Address" required>
                                                                        </div>
                                                                        <label>Prefix</label>
                                                                        <div class="form-group mb-20">
                                                                            <input type="text" name="prefix" value="{{$rvm_api_setting !== null ? $rvm_api_setting->prefix : '' }}" id="" class="form-control" placeholder="Add Prefix" >
                                                                        </div>
                                                                        <label>Call Price</label>
                                                                        <div class="form-group mb-20">
                                                                            <input type="decimal" name="call_price" value="{{$rvm_api_setting !== null ? $rvm_api_setting->call_price : '' }}" class="call_price form-control" placeholder="Add Call Price" required>
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

                                            </ul>
                                        </td>
                                    </tr>
                                    <!-- RVM API SETTINGS Ends-->


                                    <!-- BOT API SETTINGS Start-->
                                    <tr>
                                        <td>BOT</td>

                                        <td>
                                            <ul class="orderDatatable_actions mb-0">
                                                <li>
                                                    <a href="#" class="edit" id="view_bot"  data-id="bot" data-toggle="modal" data-target="#view_bot_modal">
                                                        <span data-feather="plus-circle" data-toggle="tooltip" data-placement="bottom" title="Add Bot"></span></a>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="view_bot_modal" tabindex="-1" role="dialog" aria-labelledby="view_bot_modalTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="update_company_modalTitle">Bot Api Settings</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body"  style="padding: 20px 75px 20px 75px">
                                                                    <form action="{{route('admin/api-setting.store')}}" method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <input type="hidden" name="id" value="{{$bot_api_setting !== null ? $bot_api_setting->id : 0 }}">
                                                                        <input type="hidden" name="slug" value="{{$bot_api_setting !== null ? $bot_api_setting->slug : 'rvm' }}">
                                                                        <label>End Point</label>
                                                                        <div class="form-group mb-20">
                                                                            <input type="text" name="end_point" id="" class="form-control" value="{{$bot_api_setting !== null ? $bot_api_setting->end_point : '' }}" placeholder="End Point" required>
                                                                        </div>
                                                                        <label>Carrier Address</label>
                                                                        <div class="form-group mb-20">
                                                                            <input type="text" name="carrier_address" value="{{$bot_api_setting !== null ? $bot_api_setting->carrier_address : '' }}" id="" class="form-control" placeholder="Carrier Address" required>
                                                                        </div>
                                                                        <label>Prefix</label>
                                                                        <div class="form-group mb-20">
                                                                            <input type="text" name="prefix" value="{{$bot_api_setting !== null ? $bot_api_setting->prefix : '' }}" id="" class="form-control" placeholder="Add Prefix">
                                                                        </div>
                                                                        <label>Transfer Destination</label>
                                                                        <div class="form-group mb-20">
                                                                            <input type="text" name="transfer_dest" value="{{$bot_api_setting !== null ? $bot_api_setting->transfer_dest : '' }}" class="form-control" placeholder="Add Transfer Destination" required>
                                                                        </div>
                                                                        <label>Call Price</label>
                                                                        <div class="form-group mb-20">
                                                                            <input type="number" name="call_price" value="{{$bot_api_setting !== null ? $bot_api_setting->call_price : '' }}" class="call_price form-control" placeholder="Add Call Price" required>
                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-primary" style="background-color: #003B76">Save changes</button>                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>

                                                <li>
                                                    <a href="{{route('admin.api-setting.bot')}}" class="edit" id=""  data-id="">
                                                        <span data-feather="eye" data-toggle="tooltip" data-placement="bottom" title="View Bot"></span></a>
                                                </li>

                                            </ul>
                                        </td>
                                    </tr>
                                    <!-- BOT API SETTINGS Ends-->



                                    <!-- PRESS-1 API SETTINGS Start-->
                                    <tr>
                                        <td>Press 1</td>

                                        <td>
                                            <ul class="orderDatatable_actions mb-0">
                                                <li>
                                                    <a href="#" class="edit" id="view_press_1"  data-id="press_1" data-toggle="modal" data-target="#view_press_1_modal"  ><span data-feather="eye" data-toggle="tooltip" data-placement="bottom" title="View Press-1"></span></a>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="view_press_1_modal" tabindex="-1" role="dialog" aria-labelledby="view_press_1_modalTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="update_company_modalTitle">Press-1 Api Settings</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body"  style="padding: 20px 75px 20px 75px">
                                                                    <form action="{{route('admin/api-setting.store')}}" method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <input type="hidden" name="id" value="{{$press_api_setting !== null ? $press_api_setting->id : 0 }}">
                                                                        <input type="hidden" name="slug" value="{{$press_api_setting !== null ? $press_api_setting->slug : 'press-1' }}">
                                                                        <label>End Point</label>
                                                                        <div class="form-group mb-20">
                                                                            <input type="text" name="end_point" id="" class="form-control" value="{{$press_api_setting !== null ? $press_api_setting->end_point : '' }}" placeholder="End Point" required>
                                                                        </div>
                                                                        <label>Carrier Address</label>
                                                                        <div class="form-group mb-20">
                                                                            <input type="text" name="carrier_address" value="{{$press_api_setting !== null ? $press_api_setting->carrier_address : '' }}" id="" class="form-control" placeholder="Carrier Address" required>
                                                                        </div>
                                                                        <label>Prefix</label>
                                                                        <div class="form-group mb-20">
                                                                            <input type="text" name="prefix" value="{{$press_api_setting !== null ? $press_api_setting->prefix : '' }}" id="" class="form-control" placeholder="Add Prefix" >
                                                                        </div>
                                                                        <label>Call Price</label>
                                                                        <div class="form-group mb-20">
                                                                            <input type="decimal" name="call_price" value="{{$press_api_setting !== null ? $press_api_setting->call_price : '' }}" class="call_price form-control" placeholder="Add Call Price" required>
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

                                            </ul>
                                        </td>
                                    </tr>
                                    <!-- PRESS-1 API SETTINGS Ends-->

                                    <!-- Caller Id Reputauion API SETTINGS Start-->
                                    <tr>
                                        <td>Caller Id</td>

                                        <td>
                                            <ul class="orderDatatable_actions mb-0">
                                                <li>
                                                    <a href="#" class="edit" id="reputation_1"  data-id="press_1" data-toggle="modal" data-target="#view_reputation_1_modal"  ><span data-feather="eye" data-toggle="tooltip" data-placement="bottom" title="Caller Id Reputation"></span></a>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="view_reputation_1_modal" tabindex="-1" role="dialog" aria-labelledby="view_reputation_1_modalTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="update_company_modalTitle">Caller Id Reputation Api Settings</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body"  style="padding: 20px 75px 20px 75px">
                                                                    @php
                                                                        $robokiller_username=$reputation_settings->firstWhere('key', 'robokiller_username');
                                                                        $robokiller_password=$reputation_settings->firstWhere('key', 'robokiller_password');
                                                                        $ftc_api_key=$reputation_settings->firstWhere('key', 'ftc_api_key');
                                                                        $price_per_number=$reputation_settings->firstWhere('key', 'price_per_number');
                                                                    @endphp
                                                                    <form action="{{route('admin/setting.reput.store')}}" method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <input type="hidden" name="type" value="reputation">
                                                                        <label>RooboKiller Username</label>
                                                                        <div class="form-group mb-20">
                                                                            <input type="text" name="robokiller_username" id="" class="form-control" value="{{ $robokiller_username != null ? $robokiller_username->value : '' }}" placeholder="Robokiller Username" required>
                                                                        </div>
                                                                        <label>RooboKiller Password</label>
                                                                        <div class="form-group mb-20">
                                                                            <input type="text" name="robokiller_password" value="{{ $robokiller_password != null ? $robokiller_password->value : '' }}" id="" class="form-control" placeholder="Robokiller Password" required>
                                                                        </div>
                                                                        <label>Ftc Api Key</label>
                                                                        <div class="form-group mb-20">
                                                                            <input type="text" name="ftc_api_key" value="{{ $ftc_api_key != null ? $ftc_api_key->value : '' }}" id="" class="form-control" placeholder="FTC api key" >
                                                                        </div>
                                                                        <label>Pice Per Number check</label>
                                                                        <div class="form-group mb-20">
                                                                            <input type="number" step=".01" min="0" max="99999" name="price_per_number" value="{{ $price_per_number != null ? $price_per_number->value : '' }}" id="" class="form-control" placeholder="price per number" >
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

                                            </ul>
                                        </td>
                                    </tr>
                                    <!-- Caller Id Reputauion SETTINGS Ends-->
                                </tbody>
                            </table>
                        </div>
                    </div>




                    <!-- <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30 mt-30">
                       <h3>RVM</h3>
                        <form action="{{route('admin/api-setting.store')}}" method="POSt" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$rvm_api_setting !== null ? $rvm_api_setting->id : 0 }}">
                            <input type="hidden" name="slug" value="{{$rvm_api_setting !== null ? $rvm_api_setting->slug : 'rvm' }}">
                             <div class="row">
                                <div class="col-md-4">
                                    <label>End Point</label>
                                    <div class="form-group mb-20">
                                        <input type="text" name="end_point" id="" class="form-control" value="{{$rvm_api_setting !== null ? $rvm_api_setting->end_point : '' }}" placeholder="End Point" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Carrier Address</label>
                                    <div class="form-group mb-20">
                                        <input type="text" name="carrier_address" value="{{$rvm_api_setting !== null ? $rvm_api_setting->carrier_address : '' }}" id="" class="form-control" placeholder="Carrier Address" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Prefix</label>
                                    <div class="form-group mb-20">
                                        <input type="text" name="prefix" value="{{$rvm_api_setting !== null ? $rvm_api_setting->prefix : '' }}" id="" class="form-control" placeholder="Add Prefix" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Call Price</label>
                                    <div class="form-group mb-20">
                                        <input type="decimal" name="call_price" value="{{$rvm_api_setting !== null ? $rvm_api_setting->call_price : '' }}" class="call_price form-control" placeholder="Add Call Price" required>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" style="background-color: #003B76">Update Setting</button>
                            </div>
                        </form>
                    </div> -->

                    <!-- <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30 mt-30">
                        <h3>BOT</h3>
                        <form action="{{route('admin/api-setting.store')}}" method="POSt" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$bot_api_setting !== null ? $bot_api_setting->id : 0 }}">
                            <input type="hidden" name="slug" value="{{$bot_api_setting !== null ? $bot_api_setting->slug : 'bot' }}">
                             <div class="row">
                                <div class="col-md-4">
                                    <label>End Point</label>
                                    <div class="form-group mb-20">
                                        <input type="text" name="end_point" id="" class="form-control" value="{{$bot_api_setting !== null ? $bot_api_setting->end_point : '' }}" placeholder="End Point" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Carrier Address</label>
                                    <div class="form-group mb-20">
                                        <input type="text" name="carrier_address" value="{{$bot_api_setting !== null ? $bot_api_setting->carrier_address : '' }}" id="" class="form-control" placeholder="Carrier Address" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Prefix</label>
                                    <div class="form-group mb-20">
                                        <input type="text" name="prefix" value="{{$bot_api_setting !== null ? $bot_api_setting->prefix : '' }}" id="" class="form-control" placeholder="Add Prefix" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Call Price</label>
                                    <div class="form-group mb-20">
                                        <input type="decimal" name="call_price" value="{{$bot_api_setting !== null ? $bot_api_setting->call_price : '' }}" id="" class="call_price form-control" placeholder="Add Call Price" required>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" style="background-color: #003B76">Update Setting</button>
                            </div>
                        </form>
                    </div>

                    <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30 mt-30">
                        <h3>Press-1</h3>
                        <form action="{{route('admin/api-setting.store')}}" method="POSt" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$press_api_setting !== null ? $press_api_setting->id : 0 }}">
                            <input type="hidden" name="slug" value="{{$press_api_setting !== null ? $press_api_setting->slug : 'press-1' }}">
                             <div class="row">
                                <div class="col-md-4">
                                    <label>End Point</label>
                                    <div class="form-group mb-20">
                                        <input type="text" name="end_point" id="" class="form-control" value="{{$press_api_setting !== null ? $press_api_setting->end_point : '' }}" placeholder="End Point" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Carrier Address</label>
                                    <div class="form-group mb-20">
                                        <input type="text" name="carrier_address" value="{{$press_api_setting !== null ? $press_api_setting->carrier_address : '' }}" id="" class="form-control" placeholder="Carrier Address" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Prefix</label>
                                    <div class="form-group mb-20">
                                        <input type="text" name="prefix" value="{{$press_api_setting !== null ? $press_api_setting->prefix : '' }}" id="" class="form-control" placeholder="Add Prefix" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Call Price</label>
                                    <div class="form-group mb-20">
                                        <input type="decimal" name="call_price" value="{{$press_api_setting !== null ? $press_api_setting->call_price : '' }}" id="" class="form-control call_price" placeholder="Add Call Price" required>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" style="background-color: #003B76">Update Setting</button>
                            </div>
                        </form>
                    </div> -->
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

        $('.call_price').mask('0.000');
    });
</script>
@endsection
