@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/ag-grid-community/dist/styles/ag-grid.css">
    <link rel="stylesheet" href="https://unpkg.com/ag-grid-community/dist/styles/ag-theme-alpine.css">
@endsection
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
.ag-paging-row-summary-panel-number,.ag-paging-number{
    font-weight: bold;
}

</style>

	
<body>
<div class="contents">
    <div class="container-fluid">
        <div class="row">
            <div class="breadcrumb-main user-member justify-content-sm-between ">
                <div class="d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                    <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                        <h4 class="text-capitalize fw-500 breadcrumb-title">Incoming Call Log</h4>
                        <span class="sub-title ml-sm-25 pl-sm-25"> incoming call log</span>
                    </div>
                </div>
            </div>
        </div>
        <button  class="btn btn-success mb-3" onclick="onBtnExport()">CSV</button>
        <div class="card">
            <div class="card-body">
                <div id="myGrid" style="height: 500px;width:100%;" class="ag-theme-alpine"></div>
                <div class="row mt-3 d-flex" style="">
                    <div class="col-12">
                        {{-- <button class="btn btn-primary btn-sm" onclick="onBtPrevious()"><</button>
                        <button  class="btn btn-primary btn-sm" onclick="onBtNext()">></button> --}}

                        <div class="ag-paging-panel ag-unselectable" id="ag-26">
                            <span class="ag-paging-row-summary-panel" role="status" style="margin-right: 10px;">
                                <span id="ag-26-first-row" ref="lbFirstRowOnPage" class="ag-paging-row-summary-panel-number">0</span>
                                <span id="ag-26-to">to</span>
                                <span id="ag-26-last-row" ref="lbLastRowOnPage" class="ag-paging-row-summary-panel-number">0</span>
                                <span id="ag-26-of">of</span>
                                <span id="ag-26-row-count" ref="lbRecordCount" class="ag-paging-row-summary-panel-number">0</span>
                            </span>
                            <span class="ag-paging-page-summary-panel" role="presentation">
                                <div ref="btFirst" class="ag-paging-button ag-disabled" role="button" aria-label="First Page" tabindex="0" aria-disabled="true" onclick="onBtnFirst()">
                                    <span class="ag-icon ag-icon-first" unselectable="on" role="presentation"></span>
                                </div>
                                <div ref="btPrevious" id="btn-previous" class="ag-paging-button ag-disabled" role="button" aria-label="Previous Page" tabindex="0" aria-disabled="true" onclick="onBtPrevious()">
                                    <span class="ag-icon ag-icon-previous" unselectable="on" role="presentation"></span>
                                </div>
                                <span class="ag-paging-description" role="status">
                                    <span id="ag-26-start-page">Page</span>
                                    <span id="ag-26-start-page-number" ref="lbCurrent" class="ag-paging-number">0</span>
                                    <span id="ag-26-of-page">of</span>
                                    <span id="ag-26-of-page-number" ref="lbTotal" class="ag-paging-number">0</span>
                                </span>
                                <div ref="btNext" class="ag-paging-button" role="button" aria-label="Next Page" tabindex="0" aria-disabled="false" onclick="onBtNext()">
                                    <span class="ag-icon ag-icon-next" unselectable="on" role="presentation"></span>
                                </div>
                                <div ref="btLast" class="ag-paging-button ag-disabled" role="button" aria-label="Last Page" tabindex="0" aria-disabled="true" onclick="onBtnLast()">
                                    <span class="ag-icon ag-icon-last" unselectable="on" role="presentation"></span>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

{{-- <script src="https://unpkg.com/ag-grid-community/dist/ag-grid-community.min.noStyle.js"></script> --}}
<script src="https://unpkg.com/ag-grid-community@27.0.0/dist/ag-grid-community.min.js"></script>
{{-- <script src="https://unpkg.com/@ag-grid-enterprise/all-modules@26.2.0/dist/ag-grid-enterprise.min.js"></script> --}}
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.34/moment-timezone.min.js"></script>

@if(auth()->user()->role == "user")
    <input type="hidden" id="getCallLogURL" value="{{route('user.get_incoming_call_log')}}"/>
@elseif(auth()->user()->role == "admin")
    <input type="hidden" id="getCallLogURL" value="{{route('admin.get_incoming_call_log')}}"/>
@elseif(auth()->user()->role == "company")
    <input type="hidden" id="getCallLogURL" value="{{route('company.get_incoming_call_log')}}"/>
@endif
<script type="text/javascript" charset="utf-8">

    let filter = [];
    // specify the columns
    var filterParams = {
        comparator: function (filterLocalDateAtMidnight, cellValue) {
            // var dateAsString = cellValue;
            // if (dateAsString == null) return -1;
            //     var dateParts = dateAsString.split('/');
            //     var cellDate = new Date(
            //         Number(dateParts[2]),
            //         Number(dateParts[1]) - 1,
            //         Number(dateParts[0])
            //     );
                var cellDate = new Date(cellValue);
                // filterLocalDateAtMidnight = moment(filterLocalDateAtMidnight).format('DD/MM/Y');
            
            if (filterLocalDateAtMidnight.getTime() === cellDate.getTime()) {
                return 0;
            }

            if (cellDate < filterLocalDateAtMidnight) {
                return -1;
            }

            if (cellDate > filterLocalDateAtMidnight) {
                return 1;
            }
        },
        browserDatePicker: true,
        buttons: ['reset', 'apply'],
        debounceMs: 200,
        newRowsAction: 'keep',
        suppressAndOrCondition:true,
        filterOptions:['equals','notEqual','greaterThan','lessThan','inRange']
    };
    const columnDefs = [
        { field: "Id", sortable: true, filter: false,
            // filterParams: {
            //     buttons: ['reset'],
            //     debounceMs: 200,
            //     newRowsAction: 'keep',
            //     suppressAndOrCondition:true,
            //     filterOptions:['contains','notContains','equals','notEqual','startsWith','endsWith']
            // }
        },
        { field: "Company", sortable: true, filter: true,
            filterParams: {
                buttons: ['reset'],
                debounceMs: 200,
                newRowsAction: 'keep',
                suppressAndOrCondition:true,
                filterOptions:['contains','notContains','equals','notEqual','startsWith','endsWith']
            }
        },
        { field: "User", sortable: true, filter: true,
            filterParams: {
                buttons: ['reset'],
                debounceMs: 200,
                newRowsAction: 'keep',
                suppressAndOrCondition:true,
                filterOptions:['contains','notContains','equals','notEqual','startsWith','endsWith']
            }
        },
        { field: "Campaign", sortable: true, filter: true,
            filterParams: {
                buttons: ['reset'],
                debounceMs: 200,
                newRowsAction: 'keep',
                suppressAndOrCondition:true,
                filterOptions:['contains','notContains','equals','notEqual','startsWith','endsWith']
            }
        },
        { field: "Type", sortable: true, filter: true,
            filterParams: {
                buttons: ['reset'],
                debounceMs: 200,
                newRowsAction: 'keep',
                suppressAndOrCondition:true,
                filterOptions:['contains','notContains','equals','notEqual','startsWith','endsWith']
            }
        },
        { field: "Duration", sortable: true, filter: true,
            filterParams: {
                buttons: ['reset'],
                debounceMs: 200,
                newRowsAction: 'keep',
                suppressAndOrCondition:true,
                filterOptions:['contains','notContains','equals','notEqual','startsWith','endsWith']
            }
        },
        { field: "From", sortable: true, filter: true,
            filterParams: {
                buttons: ['reset'],
                debounceMs: 200,
                newRowsAction: 'keep',
                suppressAndOrCondition:true,
                filterOptions:['contains','notContains','equals','notEqual','startsWith','endsWith']
            }
        },
        { field: "ForwardTo", sortable: true, filter: true,
            filterParams: {
                buttons: ['reset'],
                debounceMs: 200,
                newRowsAction: 'keep',
                suppressAndOrCondition:true,
                filterOptions:['contains','notContains','equals','notEqual','startsWith','endsWith']
            }
        },
        { field: "CreatedAt", sortable: true,filter: 'agDateColumnFilter',
            filterParams: filterParams,
            // cellRenderer: (data) => {
            //     // console.log(data)
            //     return new Date(data.value).toLocaleDateString('en-US', { timeZone: 'America/Mexico_City' })
            // }
        }
    ];

    // specify the data
    const rowData = null;
    var page = 1;
    // let the grid know which columns and what data to use
    const gridOptions = {
        columnDefs: columnDefs,
        rowData: rowData,
        groupSelectsChildren: true,
        defaultColDef: {
            flex: 1,
            minWidth: 150,
            sortable: true,
            resizable: true,
            floatingFilter: true,
        },
        rowSelection: 'multiple',
        // rowModelType: 'serverSide',
        // serverSideStoreType: 'partial',
        // cacheBlockSize: 100,
        // cacheOverflowSize: 2,
        // maxConcurrentDatasourceRequests: 2,
        // infiniteInitialRowCount: 1,
        // maxBlocksInCache: 2,
        animateRows: true,
        pagination: true,
        // paginationAutoPageSize: true,
        paginationPageSize: 100,
        // onPaginationChanged: onPaginationChanged,
        blockLoadDebounceMillis : 1000,
        suppressPaginationPanel: true,
        suppressScrollOnNewData: true,
        // debug: true,
        onFilterChanged: onFilterChanged,
        suppressAndOrCondition:true,
        enableCellChangeFlash: true,
        // onModelUpdated:onModelUpdated,
        // onFirstDataRendered:onFirstDataRendered,
        // onRowDataChanged:onRowDataChanged,
        getRowNodeId: (data) => data.Id,
        overlayLoadingTemplate:
        '<span class="ag-overlay-loading-center">Loading....</span>',
        components: {
            loadingCellRenderer: function (params) {
                // console.log('params',params)
                if (params.value !== undefined) {
                    return params.value;
                } else {
                    return '<img src="https://www.ag-grid.com/example-assets/loading.gif">';
                }
            },
        },
    };

    
    // lookup the container we want the Grid to use
    const eGridDiv = document.querySelector('#myGrid');
    function onBtShowLoading() {
        gridOptions.api.showLoadingOverlay();
    }
    function onBtHide() {
        gridOptions.api.hideOverlay();
    }
    // function getParams() {
    //     return {
    //         columnSeparator: getValue('#columnSeparator'),
    //     };
    // }
    function onBtnExport() {
        // var params = getParams();
        // if (params.columnSeparator) {
        //     alert(
        //     'NOTE: you are downloading a file with non-standard separators - it may not render correctly in Excel.'
        //     );
        // }
        gridOptions.api.exportDataAsCsv(',');
    }
    // create the grid passing in the div to use together with the columns & data we want to use
    new agGrid.Grid(eGridDiv, gridOptions);
    onBtShowLoading();

    // fetch the row data to use and one ready provide it to the Grid via the Grid API
    let limit = gridOptions.paginationPageSize;
    
    fetchData(limit,page,filter);

    async function fetchData(limit,page,filter){
        
        let baseUrl = $('#getCallLogURL').val()+'?page='+page+'&limit='+limit;
        
        await axios.post(baseUrl, {
            // params: {
            //     page: page,
            //     limit: limit,
                
            // },
            data: {
                filter: JSON.stringify(filter),
            },
        })
        .then(response => {
            
            if(response.data){
                let dataArray = [];
                let keys = [];
                
                if(response.data.data.length > 0){
                    response.data.data.map((value,key) => {
                        dataArray.push({
                            Id: value['id'] ? value['id'] : '0',
                            Company: value['company'] ? value['company']['name'] : 'N/A',
                            User: value['user'] ? value['user']['first_name'] : 'N/A',
                            Campaign: value['campaign'] ? value['campaign']['name'] : 'N/A',
                            Type: value['campaign'] ? value['campaign']['campaign_type'] : 'N/A',
                            Duration: moment.utc(value['duration']*1000).format('m[M] s[S]'),
                            From: value['From'],
                            ForwardTo: value['forward_to'],
                            CreatedAt:  new Date(value['created_at']).toLocaleDateString('en-US', { timeZone: 'America/Mexico_City' }),
                        })
                      
                        keys.push(key)
                    });

                    

                    $('#ag-26-start-page-number').text(response.data.current_page)
                    $('#ag-26-of-page-number').text(parseInt(response.data.total / parseInt(response.data.per_page)))
                    $('#ag-26-first-row').text(response.data.from)
                    $('#ag-26-last-row').text(response.data.to)
                    $('#ag-26-row-count').text(response.data.total)
                    
                    // gridOptions.api.setRowData([]);
                    // gridOptions.api.setRowData(dataArray);
                    // let rowData = [];
                    // gridOptions.api.forEachNode(node => console.log('rowD',node.data));
                    // console.log(dataArray)

                   let filterIds = []
                    gridOptions.api.forEachNodeAfterFilter((rowNode, index) => {
                        
                        filterIds.push(rowNode.data)
                        // const res2 = gridOptions.api.applyTransaction({ remove: rowNode.data.Id});
                        // console.log('node ' + index+ ' ids',rowNode.data.Id);
                    });
                   
                    if(filterIds.length>0){
                        
                        // const res1 = gridOptions.api.applyTransaction({ add: dataArray,addIndex:keys});
                        const res2 = gridOptions.api.applyTransaction({ remove: filterIds});
                        // gridOptions.api.setRowData(dataArray);
                        const res1 = gridOptions.api.applyTransaction({ add: dataArray});
                        
                       
                    }else{
                        const res1 = gridOptions.api.applyTransaction({ add: dataArray,addIndex:keys});
                    }
                  
                    // if(res1.update.length === 0){
                        
                    //     const res = gridOptions.api.applyTransaction({ add: dataArray,addIndex:keys });
                    // }
                    
                   
                    // gridOptions.api.redrawRows();
                    // gridOptions.api.refreshCells({'force':true})
                  
                
                    
                }else{
                    
                    $('#ag-26-start-page-number').text(0)
                    $('#ag-26-of-page-number').text(0)
                    $('#ag-26-first-row').text(0)
                    $('#ag-26-last-row').text(0)
                    $('#ag-26-row-count').text(0)
                    
                    const res = gridOptions.api.applyTransaction({ add: dataArray});
                  
                }
             
                if(response.data.current_page === 1){
                    document.getElementById("btn-previous").style.pointerEvents = "none";
                }else{
                    document.getElementById("btn-previous").style.pointerEvents = "auto";
                }
                
               
                // console.log(res)
                
                // let nextPage = (new URL(data.next_page_url)).searchParams;
                // let pageParam = nextPage.get("page");
                
                // page = pageParam;
                // gridOptions.api.paginationIsLastPageFound = false;
            
                
                // let dataSource = getServerSideDatasource(dataArray,data)
                // gridOptions.api.setServerSideDatasource(dataSource);

                onBtHide();
            }
        })
        .catch(function (error) {
            throw error
        });

       
    }

    function onBtNext(){
        gridOptions.api.paginationGoToNextPage();
        page = page+1;
        onBtShowLoading();
        fetchData(limit,page,filter);
    }

    function onBtPrevious(){
        gridOptions.api.paginationGoToPreviousPage();
        page = page-1 !== -1 || page-1 !== 0 ? page-1 : 1;
        onBtShowLoading();
        fetchData(limit,page,filter);
    }

    function onBtnFirst(){
        gridOptions.api.paginationGoToFirstPage();
        page = 1;
        onBtShowLoading();
        fetchData(limit,page,filter);
    }

    function onBtnLast(){
        gridOptions.api.paginationGoToLastPage();
        page = parseInt($('#ag-26-of-page-number').text());
        onBtShowLoading();
        fetchData(limit,page,filter);
    }

    // function onPaginationChanged(event) {
        
    //     // console.log('page',event)
    //     if (event.newPage) {
    //         // var value = document.getElementById('page-size').value;
    //         // gridOptions.api.paginationSetPageSize(Number(value));
    //         // console.log('page',value)
    //         page = page+1;
    //         // page = page+1;
    //         fetchData(limit,page,filter);
    //     }
    // }

    function onFilterChanged(e){
        if(e.api.getFilterModel()){
            let CompObjIndex = filter.findIndex((obj => obj.name == 'company'));
            let UserObjIndex = filter.findIndex((obj => obj.name == 'user'));
            let CampObjIndex = filter.findIndex((obj => obj.name == 'campaign'));
            let TypeObjIndex = filter.findIndex((obj => obj.name == 'type'));
            let DurationObjIndex = filter.findIndex((obj => obj.name == 'duration'));
            let FromObjIndex = filter.findIndex((obj => obj.name == 'from'));
            let ForwardObjIndex = filter.findIndex((obj => obj.name == 'forward_to'));
            let CreatedObjIndex = filter.findIndex((obj => obj.name == 'created_at'));

            if(e.api.getFilterModel().Company){
                if(CompObjIndex === -1){
                    filter.push({
                        name:'company',
                        search: e.api.getFilterModel().Company.filter,
                        type: e.api.getFilterModel().Company.type,
                    })
                }else{
                    // console.log(filter[CompObjIndex])
                    if(filter[CompObjIndex] && filter[CompObjIndex].name === "company"){
                        filter[CompObjIndex] = {
                            name: 'company',
                            search: e.api.getFilterModel().Company.filter,
                            type: e.api.getFilterModel().Company.type
                        }
                    }
                    
                    
                    // filter[CompObjIndex].name = 'company';
                    // filter[CompObjIndex].search = e.api.getFilterModel().Company.filter;
                    // filter[CompObjIndex].type = e.api.getFilterModel().Company.type;
                }
                
            }
            else{
               
                // filter.splice(CompObjIndex, 1);
                let objx = filter.find(o => o.name === 'company');
                if(objx){
                    filter = filter.filter(function( obj ) {
                        return obj.name !== objx.name;
                    });
                }
                
                
            }
            
            if(e.api.getFilterModel().User){
                
                if(UserObjIndex === -1){
                    
                    filter.push({
                        name:'user',
                        search: e.api.getFilterModel().User.filter,
                        type: e.api.getFilterModel().User.type,
                    })
                   
                }else{
                    if(filter[UserObjIndex] && filter[UserObjIndex].name === "user"){
                        filter[UserObjIndex] = {
                            name: 'user',
                            search: e.api.getFilterModel().User.filter,
                            type: e.api.getFilterModel().User.type
                        }
                    }
                    
                    // filter[UserObjIndex].name = 'user';
                    // filter[UserObjIndex].search = e.api.getFilterModel().User.filter;
                    // filter[UserObjIndex].type = e.api.getFilterModel().User.type;
                }
                
            }else{
                // filter.splice(UserObjIndex, 1);
                let objz = filter.find(o => o.name === 'user');
                if(objz){
                    filter = filter.filter(function( obj ) {
                        return obj.name !== objz.name;
                    });
                }
                
            }
            
            // console.log(filter)
            if(e.api.getFilterModel().Campaign){
                
                if(CampObjIndex === -1){
                    filter.push({
                        name:'campaign',
                        search: e.api.getFilterModel().Campaign.filter,
                        type: e.api.getFilterModel().Campaign.type,
                    })
                }else{
                    if(filter[UserObjIndex] && filter[UserObjIndex].name === "campaign"){
                        filter[CampObjIndex] = {
                            name: 'campaign',
                            search: e.api.getFilterModel().Campaign.filter,
                            type: e.api.getFilterModel().Campaign.type
                        }
                    }
                   
                }
                
            }
            else{
                // filter.splice(CampObjIndex, 1);
                let objy = filter.find(o => o.name === 'campaign');
                if(objy){
                    filter = filter.filter(function( obj ) {
                        return obj.name !== objy.name;
                    });
                }
            }
          
            if(e.api.getFilterModel().Type){
                
                if(TypeObjIndex === -1){
                    
                    filter.push({
                        name:'type',
                        search: e.api.getFilterModel().Type.filter,
                        type: e.api.getFilterModel().Type.type,
                    })
                   
                }else{
                    if(filter[TypeObjIndex] && filter[TypeObjIndex].name === "type"){
                        filter[TypeObjIndex] = {
                            name: 'type',
                            search: e.api.getFilterModel().Type.filter,
                            type: e.api.getFilterModel().Type.type
                        }
                    }
                }
                
            }else{
                // filter.splice(TypeObjIndex, 1);
                let objz = filter.find(o => o.name === 'type');
                if(objz){
                    filter = filter.filter(function( obj ) {
                        return obj.name !== objz.name;
                    });
                }
                
            }
            if(e.api.getFilterModel().Duration){
                
                if(DurationObjIndex === -1){
                    
                    filter.push({
                        name:'duration',
                        search: e.api.getFilterModel().Duration.filter,
                        type: e.api.getFilterModel().Duration.type,
                    })
                   
                }else{
                    if(filter[DurationObjIndex] && filter[DurationObjIndex].name === "duration"){
                        filter[DurationObjIndex] = {
                            name: 'duration',
                            search: e.api.getFilterModel().Duration.filter,
                            type: e.api.getFilterModel().Duration.type
                        }
                    }
                }
                
            }else{
                let objz = filter.find(o => o.name === 'duration');
                if(objz){
                    filter = filter.filter(function( obj ) {
                        return obj.name !== objz.name;
                    });
                }
                
            }
            if(e.api.getFilterModel().From){
                
                if(FromObjIndex === -1){
                    
                    filter.push({
                        name:'from',
                        search: e.api.getFilterModel().From.filter,
                        type: e.api.getFilterModel().From.type,
                    })
                   
                }else{
                    if(filter[FromObjIndex] && filter[FromObjIndex].name === "from"){
                        filter[FromObjIndex] = {
                            name: 'from',
                            search: e.api.getFilterModel().From.filter,
                            type: e.api.getFilterModel().From.type
                        }
                    }
                }
                
            }else{
                let objz = filter.find(o => o.name === 'from');
                if(objz){
                    filter = filter.filter(function( obj ) {
                        return obj.name !== objz.name;
                    });
                }
                
            }
            if(e.api.getFilterModel().ForwardTo){
                
                if(ForwardObjIndex === -1){
                    
                    filter.push({
                        name:'forward_to',
                        search: e.api.getFilterModel().ForwardTo.filter,
                        type: e.api.getFilterModel().ForwardTo.type,
                    })
                   
                }else{
                    if(filter[ForwardObjIndex] && filter[ForwardObjIndex].name === "forward_to"){
                        filter[ForwardObjIndex] = {
                            name: 'forward_to',
                            search: e.api.getFilterModel().ForwardTo.filter,
                            type: e.api.getFilterModel().ForwardTo.type
                        }
                    }
                }
                
            }else{
                let objz = filter.find(o => o.name === 'forward_to');
                if(objz){
                    filter = filter.filter(function( obj ) {
                        return obj.name !== objz.name;
                    });
                }
                
            }
            // console.log(e.api.getFilterModel().CreatedAt)
            if(e.api.getFilterModel().CreatedAt){
                
                if(CreatedObjIndex === -1){
                    
                    filter.push({
                        name:'created_at',
                        
                        search: e.api.getFilterModel().CreatedAt.dateFrom,
                        dateTo: e.api.getFilterModel().CreatedAt.dateTo,
                        // search: moment(e.api.getFilterModel().CreatedAt.dateFrom).format('Y-MM-DD'),
                        // dateTo: moment(e.api.getFilterModel().CreatedAt.dateTo).format('Y-MM-DD'),
                        type: e.api.getFilterModel().CreatedAt.type,
                    })
                   
                }else{
                    if(filter[CreatedObjIndex] && filter[CreatedObjIndex].name === "created_at"){
                        filter[CreatedObjIndex] = {
                            name: 'created_at',
                            // search: moment(e.api.getFilterModel().CreatedAt.dateFrom).format('Y-MM-DD'),
                            // dateTo: moment(e.api.getFilterModel().CreatedAt.dateTo).format('Y-MM-DD'),
                            search: e.api.getFilterModel().CreatedAt.dateFrom,
                            dateTo: e.api.getFilterModel().CreatedAt.dateTo,
                            type: e.api.getFilterModel().CreatedAt.type
                        }
                    }
                }
                
            }else{
                let objz = filter.find(o => o.name === 'created_at');
                if(objz){
                    filter = filter.filter(function( obj ) {
                        return obj.name !== objz.name;
                    });
                }
                
            }

            // console.log(filter)
            onBtShowLoading();
            fetchData(limit,page,filter);

            // const filterModel = gridOptions.api.getFilterModel();
            // // console.log(filterModel)
            // localStorage.setItem('filterModel', JSON.stringify(filterModel));
            // const filterModel = JSON.parse(localStorage.getItem('filterModel'));
            // if (filterModel) {
            //     gridOptions.api.setFilterModel(filterModel);
            // }
          
        }

        
    }
    // function onModelUpdated(params){
        
    //     if(params.newData !== undefined){
    //         const filterModel = JSON.parse(localStorage.getItem('filterModel'));
        
    //         // gridOptions.api.setFilterModel(filterModel); 
    //         if (filterModel) {
    //             // params.api.setFilterModel(filterModel);
    //             // gridOptions.api.onFilterChanged();
                
    //         }
    //     }
        
    // }

    // function onRowDataChanged(params){
        // const filterModel = JSON.parse(localStorage.getItem('filterModel'));
        // if (filterModel) {
        //     params.api.setFilterModel(filterModel);
        // }
    //     console.log(params) ;
    // }

    // function onFirstDataRendered(params){
    //     console.log('p',params)
    //     const filterModel = JSON.parse(localStorage.getItem('filterModel'));
    //     if (filterModel) {
    //         params.api.setFilterModel(filterModel);
    //     }
    // }
    // function getServerSideDatasource(server,data) {
    //     return {
    //         getRows: function (params) {
    //             console.log('[Datasource] - rows requested by grid: ', params);

    //             var response = server
    //             // adding delay to simulate real server call
             
    //             setTimeout(function () {
    //                 if (response) {
    //                 // call the success callback
    //                     params.request.startRow = data.from
    //                     params.request.endRow = data.to
    //                     // gridOptions.api.paginationSetPageSize(parseInt(data.per_page))
    //                     params.success({
    //                         rowData: response,
    //                         rowCount: data.total,
    //                     });
    //                 } else {
    //                     // inform the grid request failed
    //                     params.fail();
    //                 }
    //             }, 200);
    //         },
    //     };
    // }

  </script>



</body>

@endsection