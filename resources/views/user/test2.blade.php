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

	
	<body>
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
            <div id="myGrid" style="height: 100%;" class="ag-theme-alpine"></div>
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
                <form action="{{route('user.my_groups.update_my_number3')}}" method="post">
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
        </div>
    </div>
		<script>var __basePath = './';</script>
		<script src="https://unpkg.com/@ag-grid-enterprise/all-modules@26.2.0/dist/ag-grid-enterprise.min.js">
		</script>
		<script>
		</script>
	</body>

<script>
//var filterParams = { values: countries };
function cellClass(params)
{
    return (params.value == 'active') ? 'rag-green' : 'rag-red-pur';
}
var columnDefs = [
  // this row just shows the row index, doesn't use any data from the row
  
    { field: "number", sortable: true, filter: 'agNumberColumnFilter', filterParams: {
      filterOptions: ['contains','equals','notequal'],
      suppressAndOrCondition: true,
    },minWidth: 91 },
    { field: "raw_forward_to_number", sortable: true, filter: 'agNumberColumnFilter', filterParams: {
      filterOptions: ['contains','equals','notequal'],
      suppressAndOrCondition: true,
    },minWidth: 91 },
    { field: "user.first_name", sortable: true, filter: 'agSetColumnFilter', filterParams: {
      filterOptions: ['equals'],
      suppressAndOrCondition: true,
    },minWidth: 91,floatingFilter: true },
    { field: "type", sortable: true, filter: 'agSetColumnFilter', filterParams: { values: ['individual', 'uploaded', 'csv', 'CALLZY OWNED'] },minWidth: 91,floatingFilter: true },
    { field: "status", sortable: true, filter: true,minWidth: 91,floatingFilter: true , cellClass: cellClass },
    { field: "Actions", sortable: false, filter: false,minWidth: 91 ,
        cellRenderer: params => {
            
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
var gridOptions = {
  columnDefs: columnDefs,
  autoGroupColumnDef: autoGroupColumnDef,
  groupSelectsChildren: true,
  defaultColDef: {
    flex: 1,
    minWidth: 150,
    sortable: true,
    resizable: true,
    floatingFilter: true,
  },
  rowSelection: 'multiple',
  rowModelType: 'infinite',
  cacheBlockSize: 100,
  cacheOverflowSize: 2,
  maxConcurrentDatasourceRequests: 2,
  infiniteInitialRowCount: 1,
  maxBlocksInCache: 2,
  // debug: true,
  getRowNodeId: function (item) {
    return item.id;
  },
  components: {
    loadingCellRenderer: function (params) {
      if (params.value !== undefined) {
        return params.value;
      } else {
        return '<img src="https://www.ag-grid.com/example-assets/loading.gif">';
      }
    },
  },
};

function sortAndFilter(allOfTheData, sortModel, filterModel) {
  return sortData(sortModel, filterData(filterModel, allOfTheData));
}

function sortData(sortModel, data) {
  var sortPresent = sortModel && sortModel.length > 0;
  if (!sortPresent) {
    return data;
  }
  // do an in memory sort of the data, across all the fields
  var resultOfSort = data.slice();
  resultOfSort.sort(function (a, b) {
    for (var k = 0; k < sortModel.length; k++) {
      var sortColModel = sortModel[k];
      var valueA = a[sortColModel.colId];
      var valueB = b[sortColModel.colId];
      // this filter didn't find a difference, move onto the next one
      if (valueA == valueB) {
        continue;
      }
      var sortDirection = sortColModel.sort === 'asc' ? 1 : -1;
      if (valueA > valueB) {
        return sortDirection;
      } else {
        return sortDirection * -1;
      }
    }
    // no filters found a difference
    return 0;
  });
  return resultOfSort;
}

function filterData(filterModel, data) {
    
  var filterPresent = filterModel && Object.keys(filterModel).length > 0;
  if (!filterPresent) {
    return data
  }
  

  var resultOfFilter = [];
  for (var i = 0; i < data.length; i++) {
    var item = data[i];

    if (filterModel.number) {
        
      var number = parseInt(item.number);
      var allowedNumber = parseInt(filterModel.number.filter);
      
      if (filterModel.number.type == 'equals') {
     
        if (number !== allowedNumber) {
            
          continue;
        }
      } else if (filterModel.number.type == 'contains') {
        if (!item.number.includes(filterModel.number.filter)) {
          continue;
        }
      }else if(filterModel.number.type == 'notequal'){
           if (number === allowedNumber) {
            continue;
        }
      }
    }

    if (filterModel.raw_forward_to_number) {
        
      var number = parseInt(item.raw_forward_to_number);
      var allowedNumber = parseInt(filterModel.raw_forward_to_number.filter);
      
      if (filterModel.raw_forward_to_number.type == 'equals') {
     
        if (number !== allowedNumber) {
            
          continue;
        }
      } else if (filterModel.raw_forward_to_number.type == 'contains') {
          console.log(filterModel.raw_forward_to_number.filter)
          
              console.log('teri maa ki ankh'+item.raw_forward_to_number)
            if (!item.raw_forward_to_number.includes(filterModel.raw_forward_to_number.filter)) {
            continue;
            }
          
      }else if(filterModel.raw_forward_to_number.type == 'notequal'){
           if (number === allowedNumber) {
            continue;
        }
      }
    }

    

   // if (filterModel.country) {
   //   if (filterModel.country.values.indexOf(item.country) < 0) {
   //     continue;
   //   }
  // }

    resultOfFilter.push(item);
  }
console.log(resultOfFilter);
  return resultOfFilter;
}

document.addEventListener('DOMContentLoaded', function () {
  var gridDiv = document.querySelector('#myGrid');
  new agGrid.Grid(gridDiv, gridOptions);

  
  fetch('http://127.0.0.1:8000/user/test2')
    .then((response) => response.json())
    .then(function (data) {
      
      var dataSource = {
        rowCount: null, 
        getRows: function (params) {
          console.log('asking for ' + params.startRow + ' to ' + params.endRow);
          setTimeout(function () {
            var dataAfterSortingAndFiltering = sortAndFilter(
              data,
              params.sortModel,
              params.filterModel
            );
            var rowsThisPage = dataAfterSortingAndFiltering.slice(
              params.startRow,
              params.endRow
            );
            // if on or after the last page, work out the last row.
            var lastRow = -1;
            if (dataAfterSortingAndFiltering.length <= params.endRow) {
              lastRow = dataAfterSortingAndFiltering.length;
            }
            // call the success callback
            params.successCallback(rowsThisPage, lastRow);
          }, 500);
        },
      };

      gridOptions.api.setDatasource(dataSource);
    });
});
</script>
