@extends('layouts.app')
@section('content')
<style>
.progress {
    position: relative;
    height: 25px;
}
.progress > .progress-type {
    position: absolute;
    left: 0px;
    font-weight: 800;
    padding: 3px 30px 2px 10px;
    color: rgb(255, 255, 255);
    /* background-color: rgba(25, 25, 25, 0.2); */
    margin: 8px;
}
.progress > .progress-completed {
    position: absolute;
    right: 0px;
    font-weight: 800;
    padding: 3px 10px 2px;
    margin: 8px;
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
                            <h4 class="text-capitalize fw-500 breadcrumb-title">Contact Lists View</h4>
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
                        <div style="float:left;margin-bottom: 5px;">
                            <a class="btn btn-sm btn-success" href="{{ route('admin.contact-list.adminExportContactListContacts', \Request::route('id')) }}" target="_blank" rel="noopener noreferrer">CSV
                            <span data-feather="download" data-toggle="tooltip" data-placement="bottom" title="Download">CSV</span></a>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr class="userDatatable-header">
                                    <th>
                                        <span class="userDatatable-title">Number</span>
                                    </th>
                                    <th>Reputation</th>
                                    <th>
                                        <span class="userDatatable-title">Status</span>
                                    </th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $list)
                                <tr>
                                    <td>{{$list->number}}</td>

                                    {{-- reputation --}}
                                    <td>
                                        @if($list->reputation_checked)
                                            @php
                                                $class='';
                                                if($list->reputation_score > 79 )
                                                    $class='success';
                                                elseif($list->reputation_score > 69)
                                                    $class='info';
                                                elseif($list->reputation_score > 39 )
                                                    $class='warning';
                                                else $class='danger';
                                            @endphp

                                            <div class="progress" data-toggle="modal" data-target="#reputation_progress_{{$list->id}}">
                                                <div data-percentage="0%" style="width: {{$list->reputation_score}}%;" class="progress-bar progress-bar-{{$class}}" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">{{$list->reputation_score}}%</span>
                                                </div>
                                                {{-- <span class="progress-type">Reputation</span> --}}
                                                <span class="progress-completed">{{$list->reputation_score}}%</span>
                                            </div>

                                            <div class="modal fade" id="reputation_progress_{{$list->id}}" tabindex="-1" role="dialog" aria-labelledby="reputation_progress_Title" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Reputation Check Report</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-3 bg-success m-2" style="height:150px"><p class="p-2 text-white">Robokiller</p></div>
                                                            <div class="col-3 bg-success m-2" style="height:150px"><p class="p-2 text-white">Robokiller</p></div>
                                                            <div class="col-3 bg-success m-2" style="height:150px"><p class="p-2 text-white">Robokiller</p></div>
                                                            <div class="col-3 bg-success m-2" style="height:150px"><p class="p-2 text-white">Robokiller</p></div>
                                                            <div class="col-3 bg-success m-2" style="height:150px"><p class="p-2 text-white">Robokiller</p></div>

                                                        </div>
                                                        {{-- if ($number->robokiller_status) $checks--;
                                                        if ($number->nomorobo_status) $checks--;
                                                        if ($number->internal_flag == 'Y') $checks--;
                                                        if ($number->ftc_status) $checks--; --}}




                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @else
                                            UnChecked
                                        @endif
                                    </td>
                                    {{-- // reputation --}}

                                    <td>
                                        <div class=" d-inline-block">
                                        @if($list->status == 'deleted')
                                        <span class="bg-danger  rounded-pill userDatatable-content-status"> Deleted </span>
                                        @else
                                        <span class="bg-success  rounded-pill userDatatable-content-status"> {{$list->status}} </span>
                                        @endif
                                        </div>

                                    </td>
                                </tr>
                                @endforeach

                                </tbody>
                            </table>
                            {{ $data->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<script>
    function csvValidate()
    {
        var fileInput = document.getElementById('file');
        var filePath = fileInput.value;
        var allowedExtensions = /(\.csv)$/i;
        if(!allowedExtensions.exec(filePath)){
            alert('Only CSV files are allowed');
            fileInput.value = '';
            return false;
        }
    }

    $(document).ready(function() {
        // $('#example').DataTable( {
        //  } );
        // if(session('success'))
        //     var toast = $('.toast').toast({
        //         animation: true,
        //         autohide: true,
        //         delay: 4000
        //     })
        //     toast.toast('show')
        // endif
    });
</script>
@endsection
