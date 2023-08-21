@extends('layouts.app')
@section('content')
<style>
.progress-bar-container{
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content:center;
    min-width: 220px;
}
.progress.list  {
    flex-grow: 1;
    height: 32px;
    /* transform: rotate(180deg);
        background: -webkit-linear-gradient(left,
            blue 0%,
            #90ee90 35%,
            yellow 75%,
            red 100%
        );
    */
}

.progress-text.list {
	font-weight: 800;
    font-size: large;
	/* padding: 3px 30px 2px 10px; */
    margin: 8px;
}

.percantage-progrebar{
    background: white;
    font-size: large;
}
.repute-status{
    height: 20px;
}
.bg-orange{
    background-color: #FFA500;
}
.bg-yellow{
    background-color: #FFD700;
}
.texte{
    min-width: 110px;
}

</style>
@php

function reputationStatus($list){
    $msg="";
    if(!$list->reputation_score)
        return 'Pending';
    if($list->reputation_score <=100){
         $msg = "Good";
    }
    if($list->reputation_score <= 75){
       $msg = "Fair";
    }
    if($list->reputation_score <= 50){
       $msg = "Bad";
    }
    if($list->reputation_score <= 25){
       $msg = "Terrible";
    }
    return $msg;
}
function reputationColor($s){
    $msg="";
    if($s <=100){
         $msg = "primary";
    }
    if($s <= 75){
       $msg = "yellow";
    }
    if($s <= 50){
       $msg = "orange";
    }
    if($s <= 25){
       $msg = "danger";
    }
    return $msg;
}
function message($type,$n){
    $msg='';
    if($type=='robokiller'){
        if($n->robokiller_status=='positive'){
            $msg .="RoboKiller classified this number as good number and suggests that calls from it should be allowed.
            Number has more positive feedbacks.";
        }else if($n->robokiller_status=='negative'){
            $msg .="RoboKiller suggests that calls from it should be blocked.
             Number has more negative feedbacks";
        }else{
            $msg .="RoboKiller has no classification for a number.
            Or Number has no feedback or they are not consistent";
        }
    }
    if($type=='nomorobo'){
        if($n->nomorobo_status)
            $msg .='Nomorobo conside this number to be a robocall number';
        else
            $msg .='Nomorobo not consider this number to be a robocall number';
    }
    if($type=='internal'){
        if($n->internal_flag=="Y"){
            $msg .='It is an internal number ';
        }else{
            $msg .='It is not an internal number';
        }
    }
    if($type=='ftc'){
        if($n->ftc_status=="Y"){
            $msg .='FTC consider this number to be a DNC number';
        }else{
            $msg .='FTC not consider this number to be a DNC number';
        }
    }
    return $msg;


}

@endphp

<div class="contents">
    <div class="container-fluid">
        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main user-member justify-content-sm-between ">
                    <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                        <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                            <h4 class="text-capitalize fw-500 breadcrumb-title">Reputation Checked Contact List</h4>
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
                        @if(auth()->user()->role !== "company")
                            <a href="#" class="btn px-15 btn-primary" data-toggle="modal" data-target="#add_contact_list_modal" style="background-color: #003B76"> <i class="las la-plus fs-16"></i>Add/Upload</a>
                        @endif
                        <div class="modal fade" id="add_contact_list_modal" tabindex="-1" role="dialog" aria-labelledby="add_contact_list_modalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Add Contact List</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" style="padding: 20px 75px 20px 75px">
                                    {{-- {{route('user.contact-list.store')}} --}}
                                        <form action="{{route('callerid.mapContacts')}}" method="POST" enctype="multipart/form-data" onsubmit="loader()">
                                            @csrf

                                            @if(!empty($companies))
                                            <div class="form-group mb-20">
                                                <label for="seletType">Company</label>
                                                <select name="company" id="seletCompany" class="form-control select2" required  onchange="numberFunction()">
                                                    @foreach ($companies as $company )
                                                        <option selected value="{{$company->id}}">{{$company->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @endif
                                            <div class="form-group mb-20">
                                                <label for="seletType">Type</label>
                                                <select name="type" id="seletType" class="form-control select2"  onchange="numberFunction()">
                                                    <option selected value="individual">Individual</option>
                                                    <option value="csv">Upload CSV</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-20 " id="csv_div" >
                                                <label for="recording">Upload CSV</label>
                                                <input type="file" name="file" id="file" class="form-control" accept=".csv" onchange="csvValidate()" >
                                            </div>
                                            <div class="form-group mb-20 " id="individual_div">
                                                <label for="recording">Number</label>
                                                <input type="text" name="number" id="number"  class="form-control" >
                                            </div>


                                            <div class="modal-footer">

                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" data-backdrop="static" data-keyboard="false" style="background-color: #003B76">Add</button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="loader-modal" tabindex="-1" role="dialog" aria-labelledby="loader_modalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Your Contact List Is Adding</h5>

                                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                                        {{-- <span aria-hidden="true">&times;</span>
                                        </button> --}}
                                    </div>
                                    <div class="modal-body text-center" style="padding: 20px 75px 20px 75px">
                                        <div class="spinner-border text-info spin"></div>
                                        <div id='seconds-counter'> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30 mt-30">
                        <div style="float:left;margin-bottom: 5px;">
                            <a class="btn btn-sm btn-success" href="{{ route('callerid.exportContacts' ) }}" target="_blank" rel="noopener noreferrer">CSV
                            <span data-feather="download" data-toggle="tooltip" data-placement="bottom" title="Download">CSV</span></a>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr class="userDatatable-header">
                                    <th>
                                        <span class="userDatatable-title">Number</span>
                                    </th>
                                   <th>
                                        <span class="userDatatable-title" >Reputation</span>
                                    </th>
                                    @if (!empty($companies))
                                    <th>
                                        <span class="userDatatable-title ">By Company</span>
                                    </th>
                                    @endif
                                    <th>
                                        <span class="userDatatable-title ">Created At</span>
                                    </th>

                                    <th>
                                        <span class="userDatatable-title ">Updated At</span>
                                    </th>
                                    <th>
                                        <span class="userDatatable-title ">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($lists as $list)
                                    <tr>
                                        <td>{{$list->number}}</td>
                                        <td>
                                            <div class="progress-bar-container">
                                                <div class="progress list" data-toggle="modal" data-target="#reputation_progress_{{$list->id}}">
                                                    <span style="width:{{$list->reputation_score}}%;" class="progress-bar bg-{{reputationColor($list->reputation_score)}}" role="progressbar" aria-valuemin="0" aria-valuemax="100"></span>
                                                </div>
                                                <div class="progress-text list">{{ reputationStatus($list) }}</div>
                                            </div>
                                        </td>
                                        @if (!empty($companies))
                                        <td> {{ Str::ucfirst($list->company->name) }} </td>
                                        @endif
                                        <td>{{ $list->created_at }}</td>
                                        <td>{{ $list->updated_at }}</td>
                                        <td>
                                            {{-- Delete button Start --}}
                                            <div>
                                                <a href="#" data-toggle="modal" data-target="#delete_number_{{$list->id}}"><span data-feather="trash-2" data-toggle="tooltip" data-placement="bottom" title="Delete Number"></span></a>
                                                <!-- Confirmation Modal -->
                                                <div class="modal fade delete_number" id="delete_number_{{$list->id}}" role="dialog" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content  radius-xl">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title fw-500" id="staticBackdropLabel">Delete Number</h6>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span data-feather="x"></span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="delete_number-modal">
                                                                    <div class="form-group mb-20">
                                                                        <p>Are You Sure You Want To Delete This Number?</p>
                                                                    </div>
                                                                    <div class="d-flex ">
                                                                        <a class="btn btn-danger mr-10" href="{{ route('callerid.contact.delete', $list->id) }}"> Yes </a>
                                                                        <button data-dismiss="modal" class="btn btn-light btn-default ">
                                                                            cancel
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal Ends -->
                                            </div>
                                            {{-- Delete button End --}}



                                        </td>

                                        {{-- <td>
                                        <!-- <a href="" class="edit" id="view-list"  ><span data-feather="eye" data-toggle="tooltip" data-placement="bottom" title="View Contact List"></span></a> -->
                                           <div class=" d-inline-block">
                                                @if($list->is_billed)
                                                    <span class="bg-danger  rounded-pill userDatatable-content-status"> Billed </span>
                                                @elseif($list->status == 'active')
                                                    <span class="bg-success  rounded-pill userDatatable-content-status"> Not Billed </span>
                                                @endif
                                            </div>
                                         </td> --}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            {{ $lists->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@foreach($lists as $list)

{{-- start Reputation Check Report Models --}}

<div class="modal fade " id="reputation_progress_{{$list->id}}" tabindex="-1" role="dialog" aria-labelledby="reputation_progress_Title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Reputation Check Report</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="container">
                @php
                $robokiller=$nomorobo=$internal=$ftc=$overall=0;

                if ($list->robokiller_status != 'negative')$robokiller=100;
                if (!$list->nomorobo_status) $nomorobo=100; //0 means a robocall 1 meanz not
                if ($list->internal_flag != 'Y')$internal=100;
                if ($list->ftc_status != 'Y' ) $ftc=100;

                // $robokiller=20;$nomorobo=41;$internal=61;$ftc=81;
                $overall= intval(($robokiller+$nomorobo+$internal+$ftc)/4);
                @endphp

                <div class="progress-bar-container" data-toggle="modal" data-target="#reputation_message_robokiller_{{$list->id}}" >
                    <div class="texte">RoboKiller : </div>
                    <div class="progress list bg-warning ">
                        <span style="width:{{$robokiller}}%;" class="progress-bar bg-{{reputationColor($robokiller)}}" role="progressbar" aria-valuemin="0" aria-valuemax="100"></span>
                    </div>
                    <div class="progress-text list">{{ $robokiller }}</div>
                </div>
                <div class="progress-bar-container" data-toggle="modal" data-target="#reputation_message_nomorobo_{{$list->id}}" >
                    <div class="texte">NomoRobo : </div>
                    <div class="progress list bg-warning">
                        <span style="width:{{$nomorobo}}%;" class="progress-bar bg-{{reputationColor($nomorobo)}}" role="progressbar" aria-valuemin="0" aria-valuemax="100"></span>
                    </div>
                    <div class="progress-text list">{{ $nomorobo }}</div>
                </div>
                <div class="progress-bar-container" data-toggle="modal" data-target="#reputation_message_internal_{{$list->id}}" >
                    <div class="texte">Intenal Flaged : </div>
                    <div class="progress list bg-warning">
                        <span style="width:{{$internal}}%;" class="progress-bar bg-{{reputationColor($internal)}}" role="progressbar" aria-valuemin="0" aria-valuemax="100"></span>
                    </div>
                    <div class="progress-text list">{{ $internal }}</div>
                </div>
                <div class="progress-bar-container" data-toggle="modal" data-target="#reputation_message_ftc_{{$list->id}}" >
                    <div class="texte">FTC : </div>
                    <div class="progress list bg-warning">
                        <span style="width:{{$ftc}}%;" class="progress-bar bg-{{reputationColor($ftc)}}" role="progressbar" aria-valuemin="0" aria-valuemax="100"></span>
                    </div>
                    <div class="progress-text list">{{ $ftc }}</div>
                </div>

                <br>
                <hr>
                <div class="progress-bar-container">
                    <div class="texte">Over All : </div>
                    <div class="progress list">
                        <span style="width:{{$overall}}%;" class="progress-bar bg-{{reputationColor($overall)}}" role="progressbar" aria-valuemin="0" aria-valuemax="100"></span>
                    </div>
                    <div class="progress-text list">{{ $overall }}</div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>
{{-- end Reputation Check Report Models --}}


{{-- start Reputation each Models --}}
<div class="modal fade " id="reputation_message_robokiller_{{$list->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    {{message('robokiller', $list)}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="reputation_message_nomorobo_{{$list->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    {{message('nomorobo', $list)}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="reputation_message_ftc_{{$list->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    {{message('ftc', $list)}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="reputation_message_internal_{{$list->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    {{message('internal', $list)}}
                </div>
            </div>
        </div>
    </div>
</div>
{{-- end Reputation each Models --}}

@endforeach



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script>
    $(document).ready(function(){
        $('#number').mask('1(000) 000-0000');

    });
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

    function numberFunction()
    {
        var type = $('#seletType').val();

        if (type == 'csv') {
            $('#csv_div').show();
            $('#individual_div').hide();

            $("#file").prop('required',true);
            $("#number").prop('required',false);

            $("#submit_button").prop('disabled',false);
        }
        else if (type == 'individual') {
            $('#csv_div').hide();
            $('#individual_div').show();

            $("#number").prop('required',true);
            $("#file").prop('required',false);

            $("#submit_button").prop('disabled',false);
        }else{
            $('#csv_div').hide();
            $('#individual_div').hide();
            $("#submit_button").prop('disabled',true);
        }
    }


    function loader()
    {
        $('#loader-modal').modal({
            backdrop: 'static',
            keyboard: false
        });

        // $('.spin').show();
        $('#loader-modal').modal('show');
        // var seconds = 0;
        // var el = document.getElementById('seconds-counter');

        // function incrementSeconds() {
        // seconds += 1;
        // el.innerText = "Your List is adding since " + seconds + " seconds.";
        // }

        // var cancel = setInterval(incrementSeconds, 1000);
        // window.onbeforeunload = function(e) {
        //     window.open(document.URL,"_blank");
        //     return 'You can not close the window until data uploading.';
        // };
    }
    async function startCheckReputaion(List_id){
        let Url = @json(route('user.contact-list.reputation-check') );
        await  axios.get(Url+'?id='+List_id).then((response) => {
                // $('#confirm_list_repute'+List_id).modal('hide');
                // $('#button_list_repute'+List_id).hide();
                location.reload();
        }).catch((err)=>{
            cosole.log(err);
            // location.reload();
        });
    }


    $(document).ready(function() {

        numberFunction();
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
