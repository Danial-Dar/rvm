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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">Invoices</h4>
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

                    @php

                        if(auth()->user()->role == "user"){
                            $invoiceSearchURL ="user.invoices";
                        }else if(auth()->user()->role == "admin"){
                            $invoiceSearchURL ="admin.invoices";
                        }else{
                            $invoiceSearchURL ="company.invoices";
                        }

                    @endphp




                    <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30 mt-30">
                        <form action="{{route($invoiceSearchURL)}}" method="get">
                            <div class="row mb-2 ml-1">
                                <input type="text" placeholder="Invoice No" class="form-control col-2 mr-1" name="invoice_number" id="invoice_number" value="{{\Request::get('invoice_number')}}">
                                <select class="form-control col-2 mr-1" name="status" id="status">
                                    <option value="">Select Status</option>
                                    <option value="DRAFT" {{\Request::get('status') ==  "DRAFT"  ? 'selected' : ''}}>DRAFT</option>
                                    <option value="SENT" {{\Request::get('status') ==  "SENT"  ? 'selected' : ''}}>SENT</option>
                                    <option value="VIEWED" {{\Request::get('status') ==  "VIEWED"  ? 'selected' : ''}}>VIEWED</option>
                                    <option value="OVERDUE" {{\Request::get('status') ==  "OVERDUE"  ? 'selected' : ''}}>OVERDUE</option>
                                    <option value="COMPLETED" {{\Request::get('status') ==  "COMPLETED"  ? 'selected' : ''}}>COMPLETED</option>
                                    <option value="DUE" {{\Request::get('status') ==  "DUE"  ? 'selected' : ''}}>DUE</option>
                                    <option value="UNPAID" {{\Request::get('status') ==  "UNPAID"  ? 'selected' : ''}}>UNPAID</option>
                                    <option value="PARTIALLY_PAID" {{\Request::get('status') ==  "PARTIALLY_PAID"  ? 'selected' : ''}}>PARTIALLY PAID</option>
                                    <option value="PAID" {{\Request::get('status') ==  "PAID"  ? 'selected' : ''}}>PAID</option>
                                </select>
                                <button type="submit" class="btn btn-primary col-1">Search</button>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr class="userDatatable-header">
                                    @php if (auth()->user()->role == "admin"): @endphp
                                    <th scope="col">
                                        <span class="userDatatable-title">Company</span>
                                    </th>
                                    @php endif; @endphp
                                    @php if (auth()->user()->role == "admin" || auth()->user()->role == "company"): @endphp
                                    <th scope="col">
                                        <span class="userDatatable-title">User</span>
                                    </th>
                                    @php endif; @endphp
                                    <th scope="col">
                                        <span class="userDatatable-title">Invoice #</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Invoice Date</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Due Date</span>
                                    </th>

                                    <th scope="col">
                                        <span class="userDatatable-title">Paid Status</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Status</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Tax</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Sub Total</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Total</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoices as $invoice)
                                        <tr>
                                            @php if (auth()->user()->role == "admin"): @endphp
                                                <td>{{$invoice->company->name}}</td>
                                            @php endif; @endphp
                                            @php if (auth()->user()->role == "admin" || auth()->user()->role == "company"): @endphp
                                                <td>{{$invoice->user->first_name}} {{$invoice->user->last_name}}</td>
                                            @php endif; @endphp

                                            <td>{{$invoice->invoice_number}}</td>
                                            <td>{{$invoice->invoice_date}}</td>
                                            <td>{{$invoice->due_date}}</td>
                                            <td>{{$invoice->paid_status}}</td>
                                            <td>{{$invoice->status}}</td>
                                            <td>{{$invoice->tax}}</td>
                                            <td>{{$invoice->sub_total}}</td>
                                            <td>{{$invoice->total}}</td>
                                            <td>
                                                <ul class="orderDatatable_actions mb-0 ">
                                                    <li>
                                                        <a href="{{ route(auth()->user()->role.'.invoice.view', $invoice->id) }}" class="edit" id="view-invoice"  ><span data-feather="eye" data-toggle="tooltip" data-placement="bottom" title="View Invoice"></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="" data-toggle="modal" data-target="#edit_invoice_{{$invoice->id}}">
                                                            <span data-feather="edit" data-toggle="tooltip" data-placement="bottom" title="Edit invoice"></span></a>
                                                    </li>
                                                    @if($invoice->status != 'deleted')
                                                        <li>
                                                            <a href="" data-toggle="modal" data-target="#confirm_invoice_delete{{$invoice->id}}"><span data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Delete invoice"></span></a>
                                                        </li>
                                                    <!-- Delete Confirmation Modal -->
                                                        <div class="modal fade" id="confirm_invoice_delete{{$invoice->id}}" tabindex="-1" role="dialog" aria-labelledby="confirm_invoice_deleteTitle" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Invoice</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <?php
                                                                    if(auth()->user()->role == "user")
                                                                    {
                                                                        $deleteUrl = 'user.invoice.delete';
                                                                    }else if(auth()->user()->role == "admin"){
                                                                        $deleteUrl = 'admin.invoice.delete';
                                                                    }else if(auth()->user()->role == "company"){
                                                                        $deleteUrl = 'company.invoice.delete';
                                                                    }
                                                                ?>
                                                                <form action="{{ route('user.invoice.delete', ['id'=>$invoice->id]) }}" method="get" id="delete_invoice{{$invoice->id}}">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        Are you sure you want to delete the invoice ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="button"  onclick="checkCampigns({{$invoice->id}})" id="check_for_campaigns" class="btn btn-danger">Yes</button>
                                                                    </div>
                                                                </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $invoices->appends(request()->except('page'))->links() }}


                            <h4 class="text-capitalize fw-500 breadcrumb-title">Not yet billed items</h4>

                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr class="userDatatable-header">
                                    <th>
                                        <span class="userDatatable-title">Quantity</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Code</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Name</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Price</span>
                                    </th>

                                    <th>
                                        <span class="userDatatable-title">Total</span>
                                    </th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($billableItems as $item)
                                    <tr>
                                        <td>{{$item->quantity}}</td>
                                        <td>{{$item->type}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{number_format($item->unit_price, 3)}}</td>
                                        <td>{{number_format($item->price, 2)}}</td>
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

        var table = $('#example').DataTable( {
            lengthChange: false,
            "order": [],
            "bPaginate": false,
            "bInfo": false,
            searching: false,
            // buttons: [{
            //     extend: 'csv',
            //     footer: false,
            //     exportOptions: {
            //         columns: [0,1,3,4]
            //     }
            // }]
        } );

        // table.buttons().container()
        //     .appendTo( '#example_wrapper .col-md-6:eq(0)' );
            // console.log(table)
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
