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

                        <input type="hidden" id="billingURL" value="{{url('admin/sms/billing/')}}">
                        <input type="hidden" id="billingDataURL" value="{{route('admin.sms.billing.get_billing_data')}}">

                        {{-- <label for="company">Select Company</label>
                        <select name="company" id="company" class="form-control col-4" onchange="companyFunction()">
                            <option value="">Select Company...</option>
                            <option value="all">All</option>
                            @foreach($companies as $company)
                                <option value="{{$company->id}}">{{$company->name}}</option>
                            @endforeach

                        </select> --}}
                        <div class="row">

                            <div class="col-lg-4 mb-20">
                                <label for="company">Select Company</label>
                                <select name="company" id="company" class="form-control" onchange="companyFunction()">
                                    <option value="">Select Company...</option>
                                    @foreach($companies as $company)
                                        <option value="{{$company->id}}">{{$company->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-lg-4 mb-20">
                                <label for="company">Select Date Range</label>
                                <input type="text" name="datetimes" id="dateRange" class="form-control" />
                             </div>

                          </div>

                          {{-- <div class="row">
                                <div class="col-lg-4 mb-20" id="filter_col" style="display: none;">
                                    <label for="company">Select Type</label>
                                    <select name="search_by_type" id="search_by_type" class="form-control" onchange="companyFunction()">
                                        <option value="">Select Type...</option>
                                        <option value="RVM">RVM</option>
                                        <option value="BOT">BOT</option>
                                        <option value="PREES-1">PREES-1</option>
                                        <option value="PHONE">PHONE</option>
                                        <option value="INCOMING">INCOMING</option>

                                    </select>
                                </div>
                          </div> --}}
                        <br>
                        {{-- <div id="user_select" style="display: none">
                            <label for="user">Select User</label>
                            <select name="user" id="user" class="form-control col-4" onchange="companyFunction()">
                                <option value="">Select User...</option>
                                <option value="all">All</option>


                            </select>
                        </div> --}}
                        <br>
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

        $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
            companyFunction();
        });
       $('#filter_col').hide();

        $('input[name="datetimes"]').daterangepicker({
            // timePicker: true,
            startDate: moment().startOf('month'),
            endDate: moment().endOf('month'),
            alwaysShowCalendars:true,
            locale: {
            format: 'YYYY-MM-DD'
            },

            // ranges: {
            //     'Today': [moment(), moment()],
            //     'This Week': [moment().startOf('isoWeek'), moment()],
            //     //'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            //     //'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            //     'Last Week': [moment().startOf('week').subtract(7,'days'), moment().endOf('week').subtract(7, 'days')],
            //     //'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            //     'This Month': [moment().startOf('month'), moment().endOf('month')],
            //     'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            // }
        },
        // function(start, end, label) {
        //         console.log(start, end)
        //         if($('#company').val() !== ""){
        //             $('#company').trigger("change");
        //         }

        // }
        );

    });
    function closeAlert()
    {

        $('#alert-danger2').css('display' , "none");
        $('#alert-success').css('display' , "none");
        $('#alert-danger').css('display' , "none");
    }
</script>
<script>

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
    });
    async function companyFunction(){
        var x = document.getElementById("company").value;

        let baseUrl = $('#billingDataURL').val();
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

        var table = $('#all_company_table').DataTable();

        $('.loader').show()
        await axios.get(baseUrl, {
            params: {
                start_date: startDate,
                end_date: endDate,
                company:x,
            }
        })
        .then((response) => {
            if(response.data){
                Object.keys(response.data).forEach(function(key) {
                    table.row.add([
                        response.data[key].description,
                        response.data[key].type,
                        response.data[key].amount,
                        response.data[key].user_id,
                        response.data[key].company_id,
                    ]).draw( false );
                    $('.loader').hide()
                }
            );
            $('#all_company').show();
            }
        });
    }

</script>
<script>
    $(document).ready(function() {
        // $('#all_company_table').DataTable( {
        //     "campaigns": []
        // } );

    $('#alert-success').delay(7000).fadeOut();
    $('#alert-danger').delay(7000).fadeOut();
    $('#alert-danger2').delay(7000).fadeOut();

    });

</script>
@endsection
