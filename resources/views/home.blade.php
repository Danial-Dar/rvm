@extends('layouts.app')
@section('content')
<div class="contents">
    <div class="container-fluid">
        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main user-member justify-content-sm-between ">
                    <h3>Campaigns</h3>
                    <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr class="userDatatable-header">
                                    <th>
                                        <span class="userDatatable-title">Campaign Name</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">User Name</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Number Of Receipents</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Report</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Successfull</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title">Failed</span>
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
        $('#example').DataTable( {
        "order": []
    } );
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