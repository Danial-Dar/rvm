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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">Invoice # {{$invoice->invoice_number}}</h4>
                            <span class="sub-title ml-sm-25 pl-sm-25"> </span>
                        </div>
                    </div>

                    <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30 mt-30">

                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr class="userDatatable-header">

                                    <th scope="col">
                                        <span class="userDatatable-title">Company</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">User</span>
                                    </th>


                                    <th scope="col">
                                        <span class="userDatatable-title">Email</span>
                                    </th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{$invoice->company->name}}</td>
                                    <td>{{$invoice->user->first_name}}</td>
                                    <td>{{$invoice->user->email}}</td>


                                </tr>
                                </tbody>
                            </table>

                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr class="userDatatable-header">

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

                                </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td>{{$invoice->invoice_date}}</td>
                                            <td>{{$invoice->due_date}}</td>
                                            <td>{{$invoice->paid_status}}</td>
                                            <td>{{$invoice->status}}</td>
                                            <td>{{number_format($invoice->tax, 2)}}</td>
                                            <td>{{number_format($invoice->sub_total, 2)}}</td>
                                            <td>{{number_format($invoice->total, 2)}}</td>

                                        </tr>
                                </tbody>
                            </table>
                            <h4 class="text-capitalize fw-500 breadcrumb-title">Invoice Items</h4>

                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr class="userDatatable-header">
                                    <th scope="col">
                                        <span class="userDatatable-title">Quantity</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Code</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Name</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Price</span>
                                    </th>

                                    <th scope="col">
                                        <span class="userDatatable-title">Total</span>
                                    </th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoice['items'] as $item)
                                    <tr>
                                        <td>{{$item->quantity}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->description}}</td>
                                        <td>{{number_format($item->price, 3)}}</td>
                                        <td>{{number_format($item->total, 2)}}</td>
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
