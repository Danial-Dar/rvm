@extends('layouts.app')
@section('content')
<style>
.rag-red {
  background-color: lightcoral;
}
.rag-red-pure {
  background-color: red;
}
.rag-green {
  background-color: lightgreen;
}
.rag-amber {
  background-color: lightsalmon;
}

</style>
<script src="https://unpkg.com/ag-grid-community/dist/ag-grid-community.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/ag-grid-community/dist/styles/ag-grid.css">
  <link rel="stylesheet" href="https://unpkg.com/ag-grid-community/dist/styles/ag-theme-alpine.css">
<div class="contents">
    <div class="container-fluid">
        <div class="row">
            <div class="breadcrumb-main user-member justify-content-sm-between ">
                <div class="d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                    <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                        <h4 class="text-capitalize fw-500 breadcrumb-title">Order List</h4>
                        <span class="sub-title ml-sm-25 pl-sm-25"> Orders</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="d-flex mb-3">
                <button onclick="onBtnExport()" class="btn btn-primary mr-2" tabindex="0" aria-controls="client_listing" type="button"><span>Export CSV</span></button>
            </div>
        </div>
        <div class="row">
            <div class="d-flex mb-3">
                <div class="example-header">
                    Page Size:
                    <select onchange="onPageSizeChanged()" id="page-size">
                            <option value="10" selected>10</option>
                            <option value="100">100</option>
                            <option value="500">500</option>
                            <option value="1000">1000</option>
                        </select>
                </div>
            </div>
        </div>
        <div class="row" id='messageBox' style="display: none">
            <div class="col-lg-12">
                <div class="alert alert-success" id="alert-success">
                    <ul>
                        <li id='message'>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="ag-theme-alpine" id="myGrid" style="height: 600px;width:100%;">

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Refund Modal -->
<div class="modal fade" id="refundModal" tabindex="-1" role="dialog" aria-labelledby="refundModalLabel" aria-hidden="true">
    <form class="modal-dialog" role="document" onsubmit="refund(event)" id="refund_amount_form">
        @csrf
        <div class="modal-content" style="margin-top:20%;">
            <div class="modal-header" >
                <h5 class="modal-title" id="refundModalLabel">Request Refund</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="order_id" name="order_id" value="">
                <div class="form-group mb-20">
                <label for="refundable_amount">Refundable Amount</label>
                    <input type="number" value=""  step=".01" name="refundable_amount"  id="refundable_amount" class="form-control"  disabled>
                </div>
                <div class="form-group mb-20">
                    <label for="refund_amount">Refundable Amount</label>
                    <input type="number" required  max="" id="refund_amount" step=".01" name="refund_amount" class="form-control"  value="">
                </div>
                <div class="form-group mb-20">
                    <label for="refund_reason">Refund Reason</label>
                    <textarea type="text" id="refund_reason" name="refund_reason" class="form-control"  placeholder="Refund Reason" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit Request</button>
            </div>
        </div>
    </form>
</div>
<!-- -----Edit Modal------ -->
<div class="modal fade" id="edit_number" tabindex="-1" role="dialog" aria-labelledby="add_new_groupTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Number</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('user.my_groups.update_my_number2')}}" method="post">
                    @csrf
                     
                    <div class="form-group mb-20">
                        <label for="">Forward</label>
                        <input 
                        type="text" name="forward_to_number"
                        minlength="14" maxlength="14"
                        id="callzy_forward_to_number" class="form-control forward_to_number" 
                        placeholder="Forward Number" value="" required >
                    </div>
                    <input type="hidden" id="edit_id" name="edit_id"> 
                    
                    <div class="form-group mb-20">
                        <label for="">Caller Id</label>
                        <input type="text" 
                        name="my_number" 
                        minlength="14" maxlength="14"
                        id="my_number" class="form-control my_number" 
                        placeholder="My Number" value="" required >
                    </div>
                    <div class="form-group mb-20">
                        <label for="">Forward</label>
                        <input type="text" minlength="14" 
                        maxlength="14" name="forward_to_number" id="uploaded_forward_to_number" 
                        class="form-control forward_to_number" placeholder="Forward Number" 
                        value="" required>
                    </div>
                    
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" style="background-color: #003B76">Update Number</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Spinner Modal  -->
<div class="modal fade" id="spinner" tabindex="-1" role="dialog" aria-labelledby="spinnerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                    <p>This may take a moment...</p>
                    </div>
                    <div class="col-md-2">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- send mail modal -->
            <div class="modal fade" id="sendMailModal" tabindex="-1" role="dialog" aria-labelledby="sendMailModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="margin-top: 10%;">
                    <div class="modal-content">
                    <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                        <h4>Sending Email</h4>
                        <p>This may take a moment...</p>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>


                    </div>
                    </div>
                </div>
            </div>


            <!-- Generate Pdf modal -->
            <div class="modal fade" id="generateModal" tabindex="-1" role="dialog" aria-labelledby="generateModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="margin-top: 10%;">
                    <div class="modal-content">
                    <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                        <h4>Generating Pdf</h4>
                        <p>This may take a moment...</p>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>


                    </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="generateModalSuccess" tabindex="-1" role="dialog" aria-labelledby="generateModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="margin-top: 10%;">
                    <div class="modal-content">
                    <div class="modal-body">
                    <div class="row">
                            <div class="col col-5"></div>
                            <div class="col">

                                    <i class="fa fa-check-square-o fa-5x" style="color: green;" aria-hidden="true"></i>
                        </div>
                                    </div>
                    <div class="row">
                        <div class="col-md-3">
                        <h4>Pdf Generated Successfully</h4>
                        </div>
                        
                    </div>


                    </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="generateModalError" tabindex="-1" role="dialog" aria-labelledby="generateModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="margin-top: 10%;">
                    <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col col-5"></div>
                            <div class="col">

                        <i class="fa fa-times fa-5x" style="color: red; " aria-hidden="true"></i>
                        </div>

                    </div>
                    <div class="row">
                    <div class="col col-3"></div>

                        <div class="col-md-3">
                        <h4>PDF Generation Failed</h4>
                        <p>Please Check Json Format</p>
                        </div>
                        
                    </div>


                    </div>
                    </div>
                </div>
            </div>

            <!-- download pdf modal -->
            <div class="modal fade" id="downloadModal" tabindex="-1" role="dialog" aria-labelledby="downloadModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="margin-top: 10%;">
                    <div class="modal-content">
                    <div class="modal-body">
                    <div class="row">

                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                            <h4>Downloading Pdf</h4>
                            <p>This may take a moment...</p>
                            </div>
                    </div>                                                            
                    <div class="row">
                    <div class="col-md-5"></div>
                        <br>
                    <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>

                        </div>
                    </div>


                    </div>
                    </div>
                </div>
            </div>
            
            <!-- delete modal -->
            
            <div class="modal fade delete-member" id="delete-member" role="dialog" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content  radius-xl">



                        <div class="modal-header">
                            <h6 class="modal-title fw-500" id="staticBackdropLabel">Delete Order</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span data-feather="x"></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="delete-member-modal">
                                <form action="{{ url('/order/delete_order') }}" method="POST">
                                @csrf
                                <input type="hidden" id="dilogeId" name="id" value="">
                                    <div class="form-group mb-20">
                                        <p>Are You Sure You Want To Delete This Order!</p>
                                    </div>


                                    <div class="button-group d-flex pt-25">
                                        <button
                                            class="btn btn-danger btn-default btn-squared text-capitalize" type="submit">
                                            Delete Order
                                        </button>
                                        <button data-dismiss="modal"
                                            class="btn btn-light btn-default btn-squared fw-400 text-capitalize b-light color-light">
                                            cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- chargeback model -->
            <div class="modal fade" id="chargebackModal" tabindex="-1" role="dialog" aria-labelledby="chargebackModalLabel" aria-hidden="true">
                <form class="modal-dialog" role="document" onsubmit="chargebackRequest(event);">
                    <div class="modal-content" style="margin-top:20%;">
                        <div class="modal-header" >
                            <h5 class="modal-title" id="refundModalLabel">Request ChargeBack</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="order_id" name="order_id">
                            
                            <div class="form-group mb-20">
                                <label for="chargeback_reason">ChargeBack Reason</label>
                                <textarea type="text" id="chargeback_reason" name="chargeback_reason" class="form-control"  placeholder="Chargeback Reason" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit Request</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- cancel subs modal -->
            <div class="modal fade" id="cancel_subscription_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Cancel Subscription</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you Sure you Want to Cancel the Subscription ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" onclick="cancelPayment()" data-dismiss="modal" >Yes</button>
                        </div>
                    </div>
                </div>
            </div>

              <!--  Modal Ends here-->
              <div class="modal fade" id="spinner_for_cancelpayment" tabindex="-1" role="dialog" aria-labelledby="spinnerModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                        <h4>Cancelling Payment</h4>
                                        <p>This may take a moment...</p>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="spinner-border" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<input type="hidden" id="updateUserURL" value = "{{url('/order/edit/')}}">

<script  type="text/javascript" charset="utf-8">
    function onPageSizeChanged(newPageSize) {
        var value = document.getElementById('page-size').value;
        gridOptions.api.paginationSetPageSize(Number(value));
    }
    function cellClass(params)
    {
        return (params.value == 'active') ? 'rag-green' : 'rag-red-pur';
    }
    function onBtnExport() {
  gridOptions.api.exportDataAsCsv();
}
    async  function cancelPayment()
    {
        $('#spinner_for_cancelpayment').modal('toggle');
        let order_id = document.getElementById('order_id').value;
        await axios.post('order/cancelPayment/'+ order_id);
        $('#spinner_for_cancelpayment').modal('toggle');
        window.location.href = window.location.href
    }
   async function chargebackRequest(event){
    event.preventDefault();
        let order_id = document.getElementById('order_id').value;
        let reason = document.getElementById('chargeback_reason').value;
        $('#chargebackModal').modal('toggle');
        $("#spinner").modal('toggle');
        await axios.post('/refund-request/'+ order_id, {//admin
            reason: reason
        });
       
        $("#spinner").modal('toggle');
        window.location.href = window.location.href
    }
    function downloadUri(file){
                    
    var link = document.createElement("a");
    link.download = 'file';
    link.href = file;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    delete link;
    console.log('downloading...')
    }
    function edit(e)
    {

        e.preventDefault()
    }
    var orderData = @json($numbers);
    console.log(orderData)
    const columnDefs = [
        { field: "number", sortable: true, filter: true,minWidth: 91,floatingFilter: true },
        { field: "forward_to_number", sortable: true, filter: true,minWidth: 91,floatingFilter: true },
        { field: "user.first_name", sortable: true, filter: true,minWidth: 91,floatingFilter: true },
        { field: "type", sortable: true, filter: true,minWidth: 91,floatingFilter: true },
        { field: "status", sortable: true, filter: true,minWidth: 91,floatingFilter: true , cellClass: cellClass , 
        
            cellRenderer: params => {
                if(params.data.status == 'active')
                {
                   return 'Active';
                } 
                else if(params.data.status == 'deleted')
                {
                    return 'Deleted';
                }
                
            }
        },
        
        { field: "created_at", sortable: true, filter: true,minWidth: 91,floatingFilter: true },

        { field: "Actions", sortable: false, filter: false,minWidth: 91 ,
            cellRenderer: params => { 
                var downloadHref = '/order/download/' + params.data.id //admin

                const eDiv = document.createElement('div');
                
                const editBtn =   "<ul class=\"orderDatatable_actions mb-0 d-flex flex-wrap\"><li><a class=\"edit\"><span data-feather=\"edit\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Edit Number\"></span></a></li>"
                
                //const btnDeleteOrder =   "<li><a class=\"remove delete-btn\"  data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Delete Order\"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"feather feather-trash-2\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Delete Order\" aria-describedby=\"tooltip13360\"><polyline points=\"3 6 5 6 21 6\"></polyline><path d=\"M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2\"></path><line x1=\"10\" y1=\"11\" x2=\"10\" y2=\"17\"></line><line x1=\"14\" y1=\"11\" x2=\"14\" y2=\"17\"></line></svg></a></li>"
                                
                eDiv.innerHTML = editBtn ;

                //Event lister to edit order
                const editModalBtn = eDiv.querySelectorAll('.edit')[0];
                editModalBtn.addEventListener('click', async () => {
                    $('#edit_number').modal('show');
                    $('#callzy_forward_to_number').val(params.data.forward_to_number);
                    $('#uploaded_forward_to_number').val(params.data.forward_to_number);
                    $('#my_number').val(params.data.number);
                    $('#edit_id').val(params.data.id);
                });

                return eDiv;
            }
        },
        
        

    ];
    
    const autoGroupColumnDef = {
           headerName: "Model",
           field: "model",
           cellRenderer:'agGroupCellRenderer',
           cellRendererParams: {
               checkbox: true
           }
       }
       
       // let the grid know which columns and what data to use
       const gridOptions = {
           columnDefs: columnDefs,
           autoGroupColumnDef: autoGroupColumnDef,
           groupSelectsChildren: true,
           rowSelection: 'multiple',
           rowData: orderData,
           //pagination: true,
           //paginationPageSize: 10,
           //paginationNumberFormatter: function (params) {
           //     return '|' + params.value.toLocaleString() + '|';
           // },
       };
       
       // lookup the container we want the Grid to use
       const eGridDiv = document.querySelector('#myGrid');
       
       // create the grid passing in the div to use together with the columns & data we want to use
       new agGrid.Grid(eGridDiv, gridOptions);
       
       const getSelectedRows = () => {
           const selectedNodes = gridOptions.api.getSelectedNodes()
           const selectedData = selectedNodes.map( node => node.data )
           const selectedDataStringPresentation = selectedData.map( node => `${node.make} ${node.model}` ).join(', ')
           alert('Selected nodes: ' + selectedDataStringPresentation);
       }
</script>
<script>
    async function refund(evt)
    {
        evt.preventDefault();
        var amount = document.getElementById('refund_amount').value;
        var reason = document.getElementById('refund_reason').value;
        var id = document.getElementById('order_id').value;
        $('#refundModal').modal('toggle');
        $("#spinner").modal('toggle');
        await axios.post('/refund-amount/'+id, {//admin
            amount: amount,
            reason: reason
        });
        $("#spinner").modal('toggle');
        window.location.href = window.location.href
    }
</script>
@endsection
