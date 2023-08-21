@extends('layouts.app')
@section('content')
<style>
    table.dataTable.stripe tbody tr.selected,table.dataTable.display tbody tr.selected{background-color:#acbad4}
</style>
<div class="contents">
    <div class="container-fluid">
        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main user-member justify-content-sm-between ">
                    <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                        <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                            {{-- @if($filter == "contains")
                                <h4 class="text-capitalize fw-500 breadcrumb-title">Available Numbers That Contains {{$value}}</h4>
                            @endif
                            @if($filter == "starts_with")
                                <h4 class="text-capitalize fw-500 breadcrumb-title">Available Numbers That Starts With {{$value}}</h4>
                            @endif
                            @if($filter == "ends_with")
                                <h4 class="text-capitalize fw-500 breadcrumb-title">Available Numbers That Ends With {{$value}}</h4>
                            @endif --}}
                            <h4 class="text-capitalize fw-500 breadcrumb-title">Available Numbers</h4>

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
                        <div class="table-responsive">

                            @if(auth()->user()->role == "admin")
                                <?php $url = "admin.my_numbers.purchase";  ?>
                            @elseif(auth()->user()->role == "user")
                                <?php $url = "user.my_numbers.purchase"; ?>
                            @endif

                        <form action="{{route($url)}}" id="purchase_form" name="purchase_form" method="post">
                            @csrf
                            <table id="example" class="display" style="width:100%">
                                <thead>
                                <tr class="userDatatable-header">
                                    <th scope="col">
                                        <span class="userDatatable-title">Number</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Npa</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Nxx</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Xxxx</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">State</span>
                                    </th>
                                    <th scope="col">
                                        <span class="userDatatable-title">Ratecenter</span>
                                    </th>

                                </tr>
                                </thead>
                                <tbody>
                                    @if(count($results['result']) > 0)
                                        @foreach($results['result'] as $number)
                                            <tr>
                                                {{-- <td>{{$number->e164}}</td> --}}
                                                <td>{{$number['number']}}</td>
                                                <td>{{$number['npa']}}</td>
                                                <td>{{$number['nxx']}}</td>
                                                <td>{{$number['xxxx']}}</td>
                                                <td>{{$number['state']}}</td>
                                                <td>{{$number['ratecenter']}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <input type="hidden" id="secret" name="secret" required>
                            @if(count($results['result']) > 0)
                                @if(auth()->user()->role == "admin")
                                    <button type="button" onclick="getSelectedValue(event)"  class="btn btn-primary">Purchase Numbers</button>
                                @else
                                    <button type="button" id="button" class="btn btn-primary">Purchase Numbers</button>
                                @endif
                            @endif

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
                                        <div class="form-group mb-20">
                                            <input type="text" name="forward_number" id="forward_number" class="form-control" placeholder="Add Forward Number" maxlength="14"
                                            minlength="14"/>
                                        </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" onclick="validateForwardNumber(event)" style="background-color: #003B76">Purchase</button>
                                        </div>
                                 </form>
                                </div>
                            </div>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<script>
    $(document).ready(function() {
        $('#forward_number').mask('(000) 000-0000');
        var table = $('#example').DataTable();

        $('#example tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('selected');
        } );
        // $( "#example tr" ).click(function() {
        //     var d = table.rows('.selected').data();
        //     console.log(d )
        // });


        $('#button').click( function () {
            var newarray=[];
            var d = table.rows('.selected').data();
            for (var i=0; i < d.length ;i++){
                newarray.push({
                    "number": d[i][0],
                    "npa": d[i][1],
                    "nxx": d[i][2],
                    "xxxx": d[i][3],
                    "state": d[i][4],
                    "ratecenter": d[i][5],
                });
                // newarray.push('-');
            }
            console.log(JSON.stringify(newarray))
            $('#secret').val(JSON.stringify(newarray))
            var sec = $('#secret').val()
            // console.log(sec)
            if (sec != "") {
                $('#purchase_new_number').modal('show');
                // $('#purchase_form').submit()
            }else{
                alert("Please First Select Number")
            }

        } );
    });

    function getSelectedValue(event){
        event.preventDefault()
        var newarray=[];
        var table = $('#example').DataTable();
        var d = table.rows('.selected').data();
        for (var i=0; i < d.length ;i++){
            // newarray.push(d[i][0]);
            newarray.push({
                "number": d[i][0],
                "npa": d[i][1],
                "nxx": d[i][2],
                "xxxx": d[i][3],
                "state": d[i][4],
                "ratecenter": d[i][5],
            });
        }
        // console.log(JSON.stringify(newarray))
        $('#secret').val(JSON.stringify(newarray))
        var sec = $('#secret').val()
        // console.log(sec)
        if (sec != "") {
            $('#purchase_form').submit()
        }else{
            alert("Please First Select Number")
        }
    }

    function validateForwardNumber(event){
        event.preventDefault();
        var forwardToNumber = $('#forward_number').val();
        // console.log(forwardToNumber.length)
        // if(forwardToNumber.length === 0){
        //     $('#purchase_form').submit();
        // }else
        if(forwardToNumber.length < 14 ){

            // alert('Please add complete forward number.');
            $('#forward_number').get(0).reportValidity();
            return false;
        }else if(forwardToNumber.length === 14){
            $('#purchase_form').submit();
        }

    }

</script>
@endsection
