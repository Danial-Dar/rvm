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
                            <h3>Logs By Day</h3>
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
                        <div class="table-responsive">
                            <label for=""><h5>Select Date To Fetch Logs:</h5></label>
                            <input type="date" id="date" name="date" onchange="dateFunction()">
                            <input type="hidden" id="checkLogsURL" value="{{url('admin/logs/view/')}}">

                            <div id="logs_info" style="display:none">

                                <textarea class="form-control" name="logs_detail" id="logs_detail" cols="80" rows="20" readonly></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="loader" style="text-align:center">
             <div class="spinner-border" role="status">
                  <span class="sr-only">Loading...</span>
            </div>
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
    async function dateFunction(){
        var x = document.getElementById("date").value;
        console.log(x)
        let baseUrl = $('#checkLogsURL').val();
        $('.loader').show()
        await axios.get(baseUrl+'/'+x)
            .then((response) => {
                if(response.data){
                    $('.loader').hide();
                    $('#logs_info').show();
                    $('#logs_detail').val(response.data)
                    var $textarea = $('#logs_detail');
                    $textarea.scrollTop($textarea[0].scrollHeight);

                }
                else {
                    $('.loader').hide();

                    $('#logs_info').hide()
                    alert("No Logs Found For Selected Date");
                }

            });


    }
</script>
<script>
    $(document).ready(function() {
        $('#example').DataTable( {
        "order": []
    } );

    $('#alert-success').delay(7000).fadeOut();
    $('#alert-danger').delay(7000).fadeOut();
    $('#alert-danger2').delay(7000).fadeOut();
    if(session('success'))
    var toast = $('.toast').toast({
        animation: true,
        autohide: true,
        delay: 4000
    })
    toast.toast('show')
    endif
    });

</script>
@endsection
