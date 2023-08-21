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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">SW Numbers</h4>
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

                    <div class="action-btn" style="position: absolute;top: 0;right: 1%;">
                        <a href="#" class="btn px-15 btn-primary" data-toggle="modal" data-target="#purchase_new_number" 
                        style="background-color: #003B76;display: inline-flex;margin-top:1rem;"> 
                        <i class="las la-plus fs-16"></i>Purchase New Number</a>

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
                                    <form action="{{route('admin.sw_numbers.search')}}" method="post">
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
                    
                   
                    <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30 mt-30">
                       
                        <div class="">
                            <form action="{{route('admin.sw_numbers')}}" method="get">
                                <div class="row mb-2 ml-1">
                                   <input type="text" class="form-control col-2 mr-1" name="search" id="search" value="{{\Request::get('search')}}">
                                   
                                   <button type="submit" class="btn btn-primary col-1">Search</button>
                                </div>
                            </form>
                           <table id="swNumberDatatable" class="table table-striped table-bordered" style="width:100%;">
                               <thead>
                                <tr class="userDatatable-header">
                                    <th>
                                        <span class="userDatatable-title">Friendly Name</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Phone Number</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Area Code</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Resource Id</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Rate Center</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Region</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">iso Country</span>
                                    </th>
                                    <th>
                                            <span class="userDatatable-title">Capabilities</span>
                                    </th>
                                </tr>
                               </thead>
                               <tbody>
                                   @if($sw_numbers->isNotEmpty())
                                    @foreach($sw_numbers as $number)
                                    
                                            <tr>
                                                <td>{{$number->friendly_name}}</td>
                                                <td>{{$number->phone_number}}</td>
                                                <td>{{$number->area_code}}</td>
                                                <td>{{$number->resource_id}}</td>
                                                <td>{{$number->rate_center}}</td>
                                                <td>{{$number->region}}</td>
                                                <td>{{$number->iso_country}}</td>
                                                <td>{{$number->capabilities}}</td>
                                            </tr>
                                    @endforeach
                                @else
                                    <tr class="odd"><td valign="top" align="center" colspan="8" class="dataTables_empty">No data available in table</td></tr>
                                @endif
                               </tbody>
                           </table>
                           {!! $sw_numbers->appends(request()->except('page'))->links() !!}
                       </div>
                   
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#swnumberDatatable').DataTable( {
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
</script>
@endsection