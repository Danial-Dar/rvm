@extends('layouts.app')
@section('content')
<style>
    #date{width:180px; margin: 0 20px 20px 20px;}
    #date > span:hover{cursor: pointer;}
    .loader
{
    display: none;
    width:200px;
    height: 200px;
    position: fixed;
    top: 50%;
    left: 50%;
    text-align:center;
    margin-left: -50px;
    margin-top: -100px;
    z-index:2;
    overflow: auto;
}
</style>
<div class="contents">
    <div class="container-fluid">
        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main user-member justify-content-sm-between ">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Billings</h3>
                        </div>
                        <div class="col-lg-6 mb-3">
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
                                    <div class="alert alert-danger" id="alert-danger2">
                                        <ul>
                                            <button  style="float:right; background: none;border: none; " onclick="closeAlert()">x</button>
                                            <li>{{session('error')}}</li></ul>
                                    </div>
                            @endif
                        </div>
                    </div>

                    <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30">

                        <input type="hidden" id="billingURL" value="{{url('company/billing/')}}">
                        <input type="hidden" id="billingDataURL" value="{{route('company.billing.get_billing_data')}}">

                        <input type="hidden" id="smsbillingDataURL" value="{{route('company.sms.billing.get_billing_data')}}">

                        {{-- <label for="company">Select Company</label>
                        <select name="company" id="company" class="form-control col-4" onchange="companyFunction();loadSmsBilling();">
                            <option value="">Select Company...</option>
                            <option value="all">All</option>
                            @foreach($companies as $company)
                                <option value="{{$company->id}}">{{$company->name}}</option>
                            @endforeach

                        </select> --}}
                        <div class="row">

                            <div class="col-lg-4 mb-20">
                                <label for="company">Select Date Range</label>
                                <input type="text" name="datetimes" id="dateRange" class="form-control" onchange="companyFunction();;loadSmsBilling();"/>
                             </div>

                          </div>
                        <br>

                        <br>
                        <div class="table-responsive"  id="summary_table_div" style="display: none;margin-bottom:2rem;">
                            <table id="summary_table" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr class="userDatatable-header">
                                    <th>
                                        <span class="userDatatable-title">Type</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Quantity</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Total Sum</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>




                        <div class="table-responsive"  id="caller_id_data_table_div" style="">
                            <h2>CallerId Details</h2>
                            <table id="caller_id_data_table" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr class="userDatatable-header">
                                    {{-- <th>
                                        <span class="userDatatable-title">SetName</span>
                                    </th> --}}

                                    <th>
                                        <span class="userDatatable-title">Quantity</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Company</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Price</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>



                        <div class="table-responsive"  id="all_company" style="display: none;">
                            <table id="all_company_table" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr class="userDatatable-header">
                                    <th>
                                        <span class="userDatatable-title">Description</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Type</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Quantity</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">User</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Company</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Price</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="sms-section">
                            <div class="table-responsive"  id="sms_summary_table_div" style="display: none;margin-bottom:2rem;">
                                <h4>SMS Billing</h4>
                                <table id="sms_summary_table" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <span class="userDatatable-title">Type</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Amount</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive"  id="sms_all_company" style="display: none;">
                                <table id="sms_all_company_table" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr class="userDatatable-header">
                                            <th>
                                                <span class="userDatatable-title">Description</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Type</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Amount</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">User</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">Company</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="loader">
             <center>
                 <div class="spinner-border" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
             </center>
        </div>

    </div>
</div>

<script type="text/javascript">
    $(function(){
        // companyFunction();
        // $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
        //     companyFunction();
        // });
       $('#filter_col').hide();

        $('input[name="datetimes"]').daterangepicker({
            // timePicker: true,
            startDate: moment().startOf('month'),
            endDate: moment().endOf('month'),
            alwaysShowCalendars:true,
            locale: {
            format: 'YYYY-MM-DD'
            },
        });

    });
    function closeAlert()
    {

        $('#alert-danger2').css('display' , "none");
        $('#alert-success').css('display' , "none");
        $('#alert-danger').css('display' , "none");
    }
    async function loadSmsBilling()
    {
        let baseUrl = $('#smsbillingDataURL').val();
        let dateRange = $('#dateRange').val();
        dateRange = dateRange.split(' - ');
        let startDate = dateRange[0];
        let endDate = dateRange[1];
        let types= ['Unregistered','10DLC Group','Toll Free Group Name'];
        var currencyFormatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
        });
        var currencyFormatterQ = new Intl.NumberFormat('en-US', {
            currency: 'USD',
        });

        var table3 = $('#sms_all_company_table').DataTable();
        var rows = table3
                    .rows()
                    .remove()
                    .draw();
        var table4 = $('#sms_summary_table').DataTable();
        var rows = table4
                    .rows()
                    .remove()
                    .draw();

        $('.loader').show()
        await axios.get(baseUrl, {
            params: {
                start_date: startDate,
                end_date: endDate
            }
        })
        .then((response) => {
            if(response.data){
                let arr = [];
                Object.keys(response.data).forEach(function(key) {
                    table3.row.add([
                        response.data[key].description,
                        response.data[key].type,
                        response.data[key].amount,
                        response.data[key].user_id,
                        response.data[key].company_id,
                    ]).draw( false );
                    $('.loader').hide()
                });
                var result = [];
                let tem = {};
                response.data.reduce(function(res, value) {
                if (!tem[value.type]) {
                    tem[value.type] = { type: value.type, amount: parseFloat(value.amount) };
                    result.push(res[value.type])
                }
                tem[value.type].amount += parseFloat(value.amount);
                return tem;
                }, {});

                let total = 0;

                Object.keys(tem).forEach(function(key) {
                    table4.row.add([
                        tem[key].type,
                        tem[key].amount
                    ]).draw( false );

                    total = total + tem[key].amount;
                });

                table4.row.add([
                    'Total',
                    total
                ]).draw( false );

                $('#sms_all_company').show();
                $('#sms_summary_table_div').show();
            }
        });
    }
</script>
<script>
    var callerIdTable=null;

    $(function(){
        var table = $('#all_company_table').DataTable({
            lengthChange: false,
            "order": [],
            "dom": 'lBfrtip',
            buttons: [{
                extend: 'csv',
                footer: false,
                exportOptions: {
                    columns: [4,3,1,2,0,5]
                }
            }]
        });
        table.buttons().container().appendTo( '#example_wrapper .col-md-6:eq(0)' );
        var table2 = $('#summary_table').DataTable({
            lengthChange: false,
            "order": [],
            "dom": 'lBfrtip',
            buttons: [{
                extend: 'csv',
                footer: false,
                exportOptions: {
                    columns: [0,1,2]
                }
            }]
        });
        table2.buttons().container().appendTo( '#example_wrapper .col-md-6:eq(0)' );


        callerIdTable=$('#caller_id_data_table').DataTable({
            dom: 'Blfrtip',
            buttons: [
                // 'copy',
                'csv',
                // 'excel', 'pdf', 'print'
            ],
            "order": [[1, 'asc']]
        });
    });

    async function companyFunction(){
        let baseUrl = $('#billingDataURL').val();
        let dateRange = $('#dateRange').val();
        dateRange = dateRange.split(' - ');
        let startDate = dateRange[0];
        let endDate = dateRange[1];
        let types= ['RVM','BOT','PRESS-1','PHONE','INCOMING'];
        var currencyFormatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
        });
        var currencyFormatterQ = new Intl.NumberFormat('en-US', {
            // style: 'currency',
            currency: 'USD',
        });
        $('.loader').show();
        await axios.get(baseUrl, {
        params: {
                start_date: startDate,
                end_date: endDate
            }
        })
        .then((response) => {
            if(response.data){
                $('#all_company').show();
                $('#summary_table_div').show();

                var table = $('#all_company_table').DataTable();
                var rows = table
                    .rows()
                    .remove()
                    .draw();
                var table2 = $('#summary_table').DataTable();
                var rows2 = table2
                    .rows()
                    .remove()
                    .draw();
                callerIdTable.rows().remove().draw();
                let rvm_sum  = 0;
                let press_1_sum  = 0;
                let bot_sum  = 0;
                let number_sum  = 0;
                let per_minute_sum  = 0;

                let rvm_quantity  = 0;
                let press_1_quantity  = 0;
                let bot_quantity  = 0;
                let number_quantity  = 0;
                let per_minute_quantity  = 0;

                let totaLICLQuantity = 0;
                let totaLICLPrice = 0;

                Object.keys(response.data.billing).forEach(function(key) {
                    company =  response.data.billing[key]
                    if(response.data.billing[key].type === "RVM"){
                        rvm_sum = response.data.billing[key].price !== null ? rvm_sum + parseFloat(response.data.billing[key].price) : 0;
                        rvm_quantity = response.data.billing[key].quantity !== null ? rvm_quantity + parseFloat(response.data.billing[key].quantity) : 0;
                    }
                    if(response.data.billing[key].type === "BOT"){
                        bot_sum = response.data.billing[key].price !== null ? bot_sum + parseFloat(response.data.billing[key].price) : 0;
                        bot_quantity = response.data.billing[key].quantity !== null ? bot_quantity + parseFloat(response.data.billing[key].quantity) :0;
                    }
                    if(response.data.billing[key].type === "PRESS-1"){
                        press_1_sum = response.data.billing[key].price !== null ? press_1_sum + parseFloat(response.data.billing[key].price) : 0;
                        press_1_quantity = response.data.billing[key].quantity !== null ? press_1_quantity + parseFloat(response.data.billing[key].quantity) : 0;
                    }
                    if(response.data.billing[key].type === "PHONE"){
                        number_sum = response.data.billing[key].price !== null ? number_sum + parseFloat(response.data.billing[key].price) : 0;
                        number_quantity = response.data.billing[key].quantity !== null ? number_quantity + parseFloat(response.data.billing[key].quantity) : 0;
                    }
                    if(response.data.billing[key].type === "INCOMING"){
                        per_minute_sum = response.data.billing[key].price !== null ? per_minute_sum + parseFloat(response.data.billing[key].price) : 0;
                        per_minute_quantity = response.data.billing[key].quantity !== null ? per_minute_quantity + parseFloat(response.data.billing[key].quantity) : 0;
                    }

                    totaLICLQuantity  = totaLICLQuantity + response.data.billing[key].quantity;
                    totaLICLPrice     = totaLICLPrice + response.data.billing[key].price;

                    table.row.add( [
                        response.data.billing[key].name,
                        response.data.billing[key].type,
                        response.data.billing[key].quantity,
                        response.data.billing[key].user_name,
                        response.data.billing[key].company_name,
                        response.data.billing[key].price !== null ? currencyFormatter.format(parseFloat(response.data.billing[key].price).toFixed(2)) : '$ '+ 0,

                    ]).draw( false );

                });


                 // callerid billing
                 var totalCIRCount=0;
                var totalCIRPricSum=0;
                var crate=parseFloat('0'+response.data.callerid_billing.rate);
                if(Object.hasOwn(response.data, 'callerid_billing') ){
                    response.data.callerid_billing.list.forEach(function(list, key) {
                        totalCIRCount+=parseFloat( '0'+list.contacts_count );
                        totalCIRPricSum+=parseFloat( '0'+list.contacts_count ) * crate;

                        callerIdTable.row.add( [
                            list.name,
                            list.contacts_count,
                            list.company.name,
                            currencyFormatter.format( (parseFloat( '0'+list.contacts_count ) * crate).toFixed(2) ),
                        ]).draw();

                    });
                }
                totaLICLQuantity+=totalCIRCount;
                totaLICLPrice+=totalCIRPricSum;
                // /callerd billing



                table.row.add( [
                    'Total',
                    '',
                    currencyFormatterQ.format(parseFloat(totaLICLQuantity).toFixed(2)),
                    '',
                    '',
                    currencyFormatter.format(parseFloat(totaLICLPrice).toFixed(2))

                ]).draw( false );
                //BILLING TABLE END
                types.forEach(type => {
                    if(type === "RVM"){
                        table2.row.add( [
                            type,
                            rvm_quantity,
                            currencyFormatter.format(parseFloat(rvm_sum).toFixed(2))

                        ]).draw( false );
                    }
                    if(type === "BOT"){
                        table2.row.add( [
                            type,
                            bot_quantity,
                            currencyFormatter.format(parseFloat(bot_sum).toFixed(2))

                        ]).draw( false );
                    }
                    if(type === "PRESS-1"){
                        table2.row.add( [
                            type,
                            press_1_quantity,
                            currencyFormatter.format(parseFloat(press_1_sum).toFixed(2))

                        ]).draw( false );
                    }
                    if(type === "PHONE"){
                        table2.row.add( [
                            type,
                            number_quantity,
                            currencyFormatter.format(parseFloat(number_sum).toFixed(2))

                        ]).draw( false );
                    }
                    if(type === "INCOMING"){
                        table2.row.add( [
                            type,
                            per_minute_quantity,
                            currencyFormatter.format(parseFloat(per_minute_sum).toFixed(2))

                        ]).draw( false );
                    }

                });



                //calllerid
                table2.row.add( [
                    'Caller Id Reputation',
                    totalCIRCount,
                    currencyFormatter.format(parseFloat(totalCIRPricSum).toFixed(2))

                ]).draw( false );


                let totalTypeSum = rvm_sum + press_1_sum + bot_sum + number_sum + per_minute_sum +totalCIRPricSum;
                let totalQuantitySum = rvm_quantity + press_1_quantity + bot_quantity + number_quantity + per_minute_quantity + totalCIRCount
                table2.row.add( [
                    'Total',
                    currencyFormatterQ.format(parseFloat(totalQuantitySum).toFixed(2)),
                    currencyFormatter.format(parseFloat(totalTypeSum).toFixed(2))

                ]).draw( false );

                $('.loader').hide();
            }
        });
    }

</script>
<script>
    $(document).ready(function() {

        $('#alert-success').delay(7000).fadeOut();
        $('#alert-danger').delay(7000).fadeOut();
        $('#alert-danger2').delay(7000).fadeOut();

    });

</script>
@endsection
