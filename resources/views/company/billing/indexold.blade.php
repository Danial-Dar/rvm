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
                                                   
                            <input type="hidden" id="billingURL" value="{{url('company-admin/billing/')}}">
                            
                            <br>
                            
                            <label for="user">Select User</label>
                            <select name="user" id="user" class="form-control col-4" onchange="userFunction()">
                                <option value="">Select User...</option>
                                <option value="all">All</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                @endforeach
                            </select>
                            
                            <br>
                            <div class="table-responsive"  id="all_user" style="display: none;"> 
                                <table id="all_user_table" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <span class="userDatatable-title">User Name</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Total Sum</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Rvm Sum</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Bot Sum</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Press-1 Sum</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive"  id="specific_user" style="display: none;"> 
                                <table id="specific_user_table" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <span class="userDatatable-title">Campaign Name</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Sum</span>
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
    function closeAlert()
    {
        
        $('#alert-danger2').css('display' , "none");
        $('#alert-success').css('display' , "none");
        $('#alert-danger').css('display' , "none");
    }
</script>
<script>
    

    
    async function userFunction(){
        var x = document.getElementById("user").value;
        // var y = document.getElementById("company").value;
        let baseUrl = $('#billingURL').val();
        console.log(baseUrl+'/user/'+x)
        if (x == "all") {
            var table = $('#specific_user_table').DataTable();
            var rows = table
                .rows()
                .remove()
                .draw();

            $('#specific_user').hide()
            $('.loader').show()
            await axios.get(baseUrl+'/user/'+x)
            .then((response) => { 
                if(response.data){
                    console.log(response.data);
                    $('#all_user').show();
                    var table = $('#all_user_table').DataTable();
                    var rows = table
                        .rows()
                        .remove()
                        .draw();
                    Object.keys(response.data).forEach(function(key) {
                        user =  response.data[key]
                        table.row.add( [
                            response.data[key].first_name,
                            response.data[key].sum,
                            response.data[key].rvm_sum,
                            response.data[key].bot_sum,
                            response.data[key].press_sum,
                        ]).draw( false );    
                    });
                    $('.loader').hide();

                }
                 

            });
        }
        else if (x == "") {
            var table = $('#all_user_table').DataTable();
                    var rows = table
                        .rows()
                        .remove()
                        .draw();

                    $('#all_user').hide()

            var table = $('#specific_user_table').DataTable();
            var rows = table
                .rows()
                .remove()
                .draw();

            $('#specific_user').hide()
        }
        else if (x != "all" && x != "") {
            var table = $('#all_user_table').DataTable();
            var rows = table
                .rows()
                .remove()
                .draw();

            $('#all_user').hide();
            $('.loader').show()
            await axios.get(baseUrl+'/user/'+x)
            .then((response) => { 
                if(response.data){
                    console.log(response.data);
                    $('#specific_user').show();
    
                    var table = $('#specific_user_table').DataTable();
                    var rows = table
                        .rows()
                        .remove()
                        .draw();
                    Object.keys(response.data).forEach(function(key) {
                        user =  response.data[key]
                        table.row.add( [
                            response.data[key].name,
                            response.data[key].sum,
                        ]).draw( false );    
                    });
                    $('.loader').hide()
                }
            });
        }
        
        
        
        
    }
    

</script>
<script>
    $(document).ready(function() {
        $('#all_company_table').DataTable( {
        "campaigns": []
    } );

    $('#alert-success').delay(7000).fadeOut();
    $('#alert-danger').delay(7000).fadeOut();
    $('#alert-danger2').delay(7000).fadeOut();
    // if(session('success'))
    // var toast = $('.toast').toast({
    //     animation: true,
    //     autohide: true,
    //     delay: 4000
    // })
    // toast.toast('show')
    // endif
    });
    
</script>
@endsection