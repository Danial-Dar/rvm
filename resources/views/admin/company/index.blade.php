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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">Manage Companies</h4>
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
                        <a href="#" class="btn px-15 btn-primary"  data-toggle="modal" data-target="#add_company_modal" style="background-color: #003B76"> <i class="las la-plus fs-16"></i>Add New Company</a>
                        <!-- Modal -->
                        <div class="modal fade" id="add_company_modal" tabindex="-1" role="dialog" aria-labelledby="add_company_modalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Add Company</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="padding: 20px 75px 20px 75px">
                                <form action="{{route('admin.company.store')}}" method="POSt">
                                    @csrf
                                    <div class="form-group mb-20">
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Company Name" required>
                                    </div>
                                    <div class="form-group mb-20">
                                        <label for="">Rvm Call Price</label>
                                        <input type="hidden" name="settings[rvm_call_price][label]" id="settings_rvm_call_price_label" class="form-control" value="Rvm Call Price" >
                                        <input type="decimal" name="settings[rvm_call_price][value]" min="0" max="500000"
                                        id="settings_rvm_call_price_value" class="form-control price_mask" value="0.004" placeholder="Rvm Call Price" required>
                                    </div>
                                    <div class="form-group mb-20">
                                        <label for="">Bot Call Price</label>
                                        <input type="hidden" name="settings[bot_call_price][label]" id="settings_bot_call_price_label" class="form-control" value="Bot Call Price" >
                                        <input type="decimal" name="settings[bot_call_price][value]" min="0" max="500000" id="settings_bot_call_price_value"
                                        class="form-control price_mask" value="0.004" placeholder="Bot Call Price"  required>
                                    </div>
                                    <div class="form-group mb-20">
                                        <label for="">Press-1 Call Price</label>
                                        <input type="hidden" name="settings[press-1_call_price][label]" id="settings_press-1_call_price_label" class="form-control" value="Press-1 Call Price" >
                                        <input type="decimal" name="settings[press-1_call_price][value]" min="0" max="500000" id="settings_press-1_call_price_value"
                                        class="form-control price_mask" value="0.004" placeholder="Press-1 Call Price" required>
                                    </div>
                                    <div class="form-group mb-20">
                                        <label for="">Number Price</label>
                                        <input type="hidden" name="settings[number_price][label]" id="settings_number_price_label" class="form-control" value="Number Price" >
                                        <input type="decimal" name="settings[number_price][value]" min="0" max="500000" id="settings_number_price_value"
                                        class="form-control price_mask" value="2.000" placeholder="Number Price" required>
                                    </div>
                                    <div class="form-group mb-20">
                                        <label for="">Per Minute Call Price</label>
                                        <input type="hidden" name="settings[per_minute_call_price][label]" id="settings_per_minute_call_price_label" class="form-control" value="Incoming Call Price (Multiplier)" >
                                        <input type="decimal" name="settings[per_minute_call_price][value]" min="0" max="500000" id="settings_per_minute_call_price_value"
                                        class="form-control price_mask" value="1.400" placeholder="Call Price" required>
                                    </div>
                                    {{-- <span><b>*Note DNC Time set for new company default Monday - Sunday no Calls 8 PM - 11:59 PM and no calls from 12 AM to 6 AM.</b> </span> --}}
                                    <span><b>*Note Campaign Hours set for new company default Monday - Friday 9 AM to 5 PM.</b> </span>
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
                                        <span class="userDatatable-title">Name</span>
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
                                    @foreach($companies as $company)
                                        <tr>
                                            <td>{{$company->name}}</td>
                                            <td>
                                                @if($company->status == 1)
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
                                                        {{-- <a href="#" class="edit" id="update_daily_limit"  data-id="{{ $company->id }}" data-toggle="modal" data-target="#update_daily_limit{{$company->id}}"  ><span data-feather="phone-outgoing" data-toggle="tooltip" data-placement="bottom" title="Update Daily Send Limit"></span></a> --}}
                                                        <a href="#" class="edit" id="update_daily_limit" onclick="updateDailyLimit({{$company->id}})"  ><span data-feather="phone-outgoing" data-toggle="tooltip" data-placement="bottom" title="Update Daily Send Limit"></span></a>
                                                        <a href="#" class="edit" id="edit-company"  data-id="{{ $company->id }}" data-toggle="modal" data-target="#update_company_modal{{$company->id}}"  ><span data-feather="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Company"></span></a>
                                                        <!-- Modal -->
                                                        

                                                        <div class="modal fade" id="update_company_modal{{$company->id}}" tabindex="-1" role="dialog" aria-labelledby="update_company_modalTitle" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                                <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="update_company_modalTitle">Update Company</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body"  style="padding: 20px 75px 20px 75px">
                                                                <form action="{{route('admin.company.update')}}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id" id="id" class="form-control" value="{{$company->id}}" >
                                                                    <div class="form-group mb-20">
                                                                        <input type="text" name="name" id="company_name" class="form-control" placeholder="Company Name" value="{{$company->name}}" required>
                                                                    </div>
                                                                    <?php
                                                                        $models = array();
                                                                        if($company->company_settings->isNotEmpty()){
                                                                            foreach ($company->company_settings as $model) {
                                                                                $models[$model->key] = $model->value;
                                                                            }
                                                                        }

                                                                    ?>
                                                                    <div class="form-group mb-20">
                                                                        <label for="">Rvm Call Price</label>
                                                                        <input type="hidden" name="settings[rvm_call_price][label]"
                                                                        id="" class="form-control"
                                                                        value="Rvm Call Price" >
                                                                        <input type="decimal" name="settings[rvm_call_price][value]"
                                                                        min="0" max="500000" id=""
                                                                        class="form-control price_mask" value="{{isset($models['rvm_call_price'])  ? $models['rvm_call_price'] : '0.004'  }}"
                                                                        placeholder="Rvm Call Price">
                                                                    </div>
                                                                    <div class="form-group mb-20">
                                                                        <label for="">Bot Call Price</label>
                                                                        <input type="hidden" name="settings[bot_call_price][label]" id="" class="form-control" value="Bot Call Price" >
                                                                        <input type="decimal" name="settings[bot_call_price][value]" min="0" max="500000"
                                                                        id="" class="form-control price_mask" value="{{isset($models['bot_call_price']) ? $models['bot_call_price'] : '0.004' }}" placeholder="Bot Call Price">
                                                                    </div>

                                                                    <div class="form-group mb-20">
                                                                        <label for="">Press-1 Call Price</label>
                                                                        <input type="hidden" name="settings[press-1_call_price][label]" id="" class="form-control" value="Press-1 Call Price" >
                                                                        <input type="decimal" name="settings[press-1_call_price][value]" min="0" max="500000" id=""
                                                                        class="form-control price_mask" value="{{isset($models['press-1_call_price']) ? $models['press-1_call_price'] : '0.004'}}" placeholder="Press-1 Call Price">
                                                                    </div>
                                                                    <div class="form-group mb-20">
                                                                        <label for="">Number Price</label>
                                                                        <input type="hidden" name="settings[number_price][label]" id="" class="form-control" value="Number Price" >
                                                                        <input type="decimal" name="settings[number_price][value]" min="0" max="500000" id=""
                                                                        class="form-control price_mask" value="{{isset($models['number_price']) ? $models['number_price'] : '2.000'}}" placeholder="Number Price">
                                                                    </div>
                                                                    <div class="form-group mb-20">
                                                                        <label for="">Per Minute Call Price</label>
                                                                        <input type="hidden" name="settings[per_minute_call_price][label]" id="settings_per_minute_call_price_label" class="form-control" value="Per Minute Call Price" >
                                                                        <input type="decimal" name="settings[per_minute_call_price][value]" min="0" max="500000" id=""
                                                                        class="form-control price_mask" value="{{isset($models['per_minute_call_price']) ? $models['per_minute_call_price'] : '1.400'}}" placeholder="Per Minute Call Price">
                                                                    </div>
                                                                    <div class="form-group mb-20">
                                                                    <select name="status" id="company_status" class="form-control" >
                                                                        <option value="1" @if($company->status == "1") echo selected @endif >Active</option>
                                                                        <option value="0" @if($company->status == "0") echo selected @endif>In-Active</option>
                                                                        </select>
                                                                    </div>
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
                                    @endforeach
                                    <div class="modal fade" id="update_daily_limit_modal" tabindex="-1" role="dialog" aria-labelledby="update_daily_limit_modalTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="update_company_modalTitle">Update Daily Limit</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body"  style="padding: 20px 75px 20px 75px">
                                                    <form action="{{route('admin.update.company.dailylimit')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" id="id_daily_limit" name="id_daily_limit" value="">
                                                        <label for="from_time">Daily limit</label>
                                                        <input type="hidden" name="settings[daily_max_limit][label]" id="settings_daily_max_limit_label" class="form-control" value="Daily limit" >
                                                        {{-- <input type="number" name="settings[daily_max_limit][value]" min="0" max="10000000" id="settings_daily_max_limit_value" class="form-control" value= "{{ $count != 0 ? isset($models['daily_max_limit']) ? $models['daily_max_limit'] : '' : '' }}" placeholder="Daily limit" required> --}}
                                                        <input type="number" name="settings[daily_max_limit][value]" min="0" max="10000000" id="settings_daily_max_limit_value" class="form-control" value= "" placeholder="Daily limit" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" style="background-color: #003B76">Save changes</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<input type="hidden" value="{{url('admin/display/company/daily-limit')}}" id="url">

<script>
    $(document).ready(function() {
        $('#example').DataTable( {
        "order": []
    } );
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
        $('.price_mask').mask('0.000');
    });

    async function updateDailyLimit(id)
    {
        console.log(id)
        var url = $('#url').val()
        $('#update_daily_limit_modal').modal('show')
        await axios.get(url+'/'+id)
            .then((response) => { 
                console.log(response.data.value);
                // if(response.data.value){

                    
                    $('#settings_daily_max_limit_value').val(response.data.value)
                    $('#id_daily_limit').val(id)
                // }
                 

            });
    }
</script>
@endsection
