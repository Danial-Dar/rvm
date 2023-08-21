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
                                    <th>
                                        <span class="userDatatable-title">Number</span>
                                    </th>
                                   
                                </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(count($results) > 0)
                                        @foreach($results as $number)
                                            @if(isset($number->properties) && count($number->properties))
                                                <tr>
                                                    <td>{{$number->properties->phoneNumber}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <input type="hidden" id="secret" name="secret" required>
                            @if(count($results) > 0)
                                <button type="button" id="button" class="btn btn-primary">Purchase Numbers</button>
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
                                            minlength="14" />
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
    
        $('#button').click( function () {
            var newarray=[];      
            var d = table.rows('.selected').data()  ;
            for (var i=0; i < d.length ;i++){
            newarray.push(d[i][0]);
            }
            // console.log(newarray)
            $('#secret').val(newarray)
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
    
    
     
    function validateForwardNumber(event){
        event.preventDefault();
        var forwardToNumber = $('#forward_number').val();
        // console.log(forwardToNumber.length)
        if(forwardToNumber.length === 0){
            $('#purchase_form').submit();
        }else if(forwardToNumber.length < 14 ){
            
            alert('Please add complete forward number.');
            return false;
        }else if(forwardToNumber.length === 14){
            $('#purchase_form').submit();
        }
     
    }
    
</script>
@endsection