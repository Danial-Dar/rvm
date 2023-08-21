 <template>
     <div>

         <Head title="Agent Dashboard" />

         <Heading class="mb-6" style="margin-left: 10px">Agent Dashboard</Heading>

         <div class="flex" style="margin: 10px;">

             <div
                 class="bg-white dark:bg-gray-800 rounded-lg shadow relative px-6 py-4 md:col-span-4 min-h-40 h-full flex-1">
                 <div class="h-6 flex items-center mb-4">
                     <h3 class="mr-3 leading-tight text-sm font-bold">Total Active Campaign</h3>

                 </div>
                 <div class="flex items-center mb-4">
                     <div class="rounded-lg bg-primary-500 text-white h-14 w-14 flex items-center justify-center">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                         </svg>
                     </div>
                     <div class="ml-4">
                         <p class="flex items-center text-4xl">1.09 K</p>
                         <div>
                             <p class="flex items-center font-bold text-sm"><span
                                     class="text-gray-400 font-semibold"></span></p>
                         </div>
                     </div>
                 </div>
             </div>

             <div
                 class="ml-auto bg-white dark:bg-gray-800 rounded-lg shadow relative px-6 py-4 md:col-span-4 min-h-40 h-full flex-1 ml-2 mr-2">
                 <div class="h-6 flex items-center mb-4">
                     <h3 class="mr-3 leading-tight text-sm font-bold">Total Paused Campaign</h3>

                 </div>
                 <div class="flex items-center mb-4">
                     <div class="rounded-lg bg-primary-500 text-white h-14 w-14 flex items-center justify-center">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                         </svg>
                     </div>
                     <div class="ml-4">
                         <p class="flex items-center text-4xl">0.55 K</p>
                         <div>
                             <p class="flex items-center font-bold text-sm"><span
                                     class="text-gray-400 font-semibold"></span></p>
                         </div>
                     </div>
                 </div>
             </div>

             <div
                 class="ml-auto bg-white dark:bg-gray-800 rounded-lg shadow relative px-6 py-4 md:col-span-4 min-h-40 h-full flex-1">
                 <div class="h-6 flex items-center mb-4">
                     <h3 class="mr-3 leading-tight text-sm font-bold">Campaign Send Rate</h3>

                 </div>
                 <div class="flex items-center mb-4">
                     <div class="rounded-lg bg-primary-500 text-white h-14 w-14 flex items-center justify-center">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                         </svg>
                     </div>
                     <div class="ml-4">
                         <p class="flex items-center text-4xl">80.81 m</p>
                         <div>
                             <p class="flex items-center font-bold text-sm"><span
                                     class="text-gray-400 font-semibold"></span></p>
                         </div>
                     </div>
                 </div>
             </div>

         </div>

         <!-- <div class="card-wrapper">

             <div class="card shadow" style="background: #049901;">
                 <div class="card-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                         <path stroke-linecap="round" stroke-linejoin="round"
                             d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                     </svg>
                 </div>
                 <div>
                     <div class="card-title">Total Active Campaign</div>
                     <div class="card-value"> 1.09k</div>
                 </div>
             </div>

             <div class="card shadow" style="background: #043465;">
                 <div class="card-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                         <path stroke-linecap="round" stroke-linejoin="round"
                             d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                     </svg>
                 </div>
                 <div>
                     <div class="card-title">Total Paused Campaign</div>
                     <div class="card-value"> 0.55k</div>
                 </div>
             </div>

             <div class="card shadow" style="background: #f02819;">
                 <div class="card-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                         <path stroke-linecap="round" stroke-linejoin="round"
                             d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                     </svg>
                 </div>
                 <div>
                     <div class="card-title">Campaign Send Rate</div>
                     <div class="card-value"> 80.81m</div>
                 </div>
             </div>
         </div> -->

         <div class="bg-white dark:bg-gray-800 rounded-lg shadow" style="margin: 10px;">

             <div class="relative">
                 <div class="overflow-hidden overflow-x-auto relative" style="border-radius: 10px;">
                     <!-- <table class="w-full table-tight" cellpadding="0" cellspacing="0" data-testid="resource-table"> -->
                        <table
                            class="w-full table-default card-scroll"
                            cellpadding="0"
                            cellspacing="0"
                            data-testid="resource-table"
                        >
                         <thead class="bg-gray-50 dark:bg-gray-800">
                             <tr style="background: #1fc0cd;">

                                 <!-- <th class="td-fit uppercase text-xxs text-gray-500 tracking-wide pl-5 pr-2 py-2"><span
                                          class="sr-only">Selected Resources</span></th>
                                   -->
                                 <th class="text-left px-2 uppercase custom-th tracking-wide py-2">
                                     <span>Agent Name</span>
                                 </th>
                                 <th class="text-left px-2 uppercase custom-th tracking-wide py-2">
                                     <span>Status</span>
                                 </th>
                                 <th class="text-left px-2  uppercase custom-th tracking-wide py-2">
                                     <span>Time In Status</span>
                                 </th>
                                 <th class="text-left px-2  uppercase custom-th tracking-wide py-2">
                                     <span>No. of Calls Received</span>
                                 </th>
                                 <th class="text-left px-2  uppercase custom-th tracking-wide py-2">
                                     <span>Total Time Logged In</span>
                                 </th>
                                 <th class="text-center px-2  uppercase custom-th tracking-wide py-2">
                                     <span>Report/Message</span>
                                 </th>
                                 <!-- <th class="text-center px-2  uppercase custom-th tracking-wide py-2">
                                     <span>Action</span>
                                 </th> -->
                             </tr>
                         </thead>
                         <tbody  v-if="agents.length>0">
                            <tr
                                v-for="item in agents"
                                :key="item.name"
                                dusk="53-row"
                                class="group"
                                addition-actions="[object Object]"
                            >
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]" style="display: flex;">
                                         <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                             <path stroke-linecap="round" stroke-linejoin="round"
                                                 d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                         </svg>
                                         <span class="text-90" style="margin-left: 10px;">{{ item.first_name }} {{ item.last_name }}</span>
                                     </div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-center" resource="[object Object]">
                                        <span v-if="item.status == 'in-call'"
                                            class="inline-flex items-center  h-6 px-2 rounded-full uppercase text-xs font-bold badge-success">{{ item.status }}</span>
                                        <span v-if="item.status == 'on-hold'"
                                            class="inline-flex items-center  h-6 px-2 rounded-full uppercase text-xs font-bold badge-warning">{{ item.status }}</span>
                                        <span v-if="item.status == 'idle'"
                                            class="inline-flex items-center  h-6 px-2 rounded-full uppercase text-xs font-bold badge-info">{{ item.status }}</span>
                                        <span v-if="item.status == 'disconnected'"
                                            class="inline-flex items-center  h-6 px-2 rounded-full uppercase text-xs font-bold badge-danger">{{ item.status }}</span>
                                     </div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]"><span
                                             class="text-90 ">{{ item.logged_in_time }}</span></div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]"><span class="text-90 ">10</span>
                                     </div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]"><span
                                             class="text-90 ">00:05:00</span></div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]"><span class="text-90 ">{{ item.message }}</span></div>
                                 </td>
                             </tr>
                             <!-- <tr dusk="192-row" class="group" addition-actions="[object Object]">
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]" style="display: flex;">
                                         <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                             <path stroke-linecap="round" stroke-linejoin="round"
                                                 d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                         </svg>
                                         <span class="text-90" style="margin-left: 10px;">Muhammad Bilal</span>
                                     </div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-center" resource="[object Object]">
                                         <span
                                             class="inline-flex items-center px-2 rounded-full badge-info">Paused</span>
                                     </div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]"><span
                                             class="text-90 ">00:02:00</span></div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]"><span class="text-90 ">10</span>
                                     </div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]"><span
                                             class="text-90 ">00:05:00</span></div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]"><span class="text-90 ">Lorem
                                             Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                             Ipsum has been the industry's standard dummy text ever since the
                                             1500s.</span></div>
                                 </td>
                             </tr>
                             <tr dusk="192-row" class="group" addition-actions="[object Object]">
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]" style="display: flex;">
                                         <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                             <path stroke-linecap="round" stroke-linejoin="round"
                                                 d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                         </svg>
                                         <span class="text-90" style="margin-left: 10px;">Muhammad Bilal</span>
                                     </div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-center" resource="[object Object]">
                                         <span class="inline-flex items-center px-2 rounded-full badge-success">In
                                             Call</span>
                                     </div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]"><span
                                             class="text-90 ">00:02:00</span></div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]"><span class="text-90 ">10</span>
                                     </div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]"><span
                                             class="text-90 ">00:05:00</span></div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]"><span class="text-90 ">Lorem
                                             Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                             Ipsum has been the industry's standard dummy text ever since the
                                             1500s.</span></div>
                                 </td>
                             </tr>
                             <tr dusk="192-row" class="group" addition-actions="[object Object]">
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]" style="display: flex;">
                                         <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                             <path stroke-linecap="round" stroke-linejoin="round"
                                                 d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                         </svg>
                                         <span class="text-90" style="margin-left: 10px;">Muhammad Bilal</span>
                                     </div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-center" resource="[object Object]">
                                         <span class="inline-flex items-center px-2 rounded-full badge-finished">On
                                             Hold</span>
                                     </div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]"><span
                                             class="text-90 ">00:02:00</span></div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]"><span class="text-90 ">10</span>
                                     </div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]"><span
                                             class="text-90 ">00:05:00</span></div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]"><span class="text-90 ">Lorem
                                             Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                             Ipsum has been the industry's standard dummy text ever since the
                                             1500s.</span></div>
                                 </td>
                             </tr>
                             <tr dusk="192-row" class="group" addition-actions="[object Object]">
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]" style="display: flex;">
                                         <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                             <path stroke-linecap="round" stroke-linejoin="round"
                                                 d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                         </svg>
                                         <span class="text-90" style="margin-left: 10px;">Muhammad Bilal</span>
                                     </div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-center" resource="[object Object]">
                                         <span
                                             class="inline-flex items-center px-2 rounded-full badge-danger">Dead</span>
                                     </div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]"><span
                                             class="text-90 ">00:02:00</span></div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]"><span class="text-90 ">10</span>
                                     </div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]"><span
                                             class="text-90 ">00:05:00</span></div>
                                 </td>
                                 <td
                                     class="custom-td px-2 border-t border-gray-100 dark:border-gray-700  cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
                                     <div class="text-left" resource="[object Object]"><span class="text-90 ">Lorem
                                             Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                             Ipsum has been the industry's standard dummy text ever since the
                                             1500s.</span></div>
                                 </td>
                             </tr> -->

                         </tbody>
                     </table>
                     <ResourcePagination :allMatchingResourceCount="
                            paginationData.allMatchingResourceCount
                        " :currentPage="paginationData.currentPage" :currentResourceCount="
                            paginationData.currentResourceCount
                        " :hasNextPage="paginationData.hasNextPage" :hasPreviousPage="paginationData.hasPreviousPage"
                         :loadMore="loadMore" paginationComponent="pagination-simple" :perPage="3"
                         :resourceCountLabel="paginationData.resourceCountLabel" :shouldShowPagination="true"
                         :totalPages="paginationData.totalPages" :selectPage="selectPage" />
                 </div><!-- Pagination -->

             </div>
         </div>

         <Heading class="mb-6" style="margin-left: 10px;">Report Company</Heading>
         <div class="card-wrapper">

             <div class="card shadow" style="background: white;">
                 <div class="">
                     <h3 style="margin-bottom: 10px; color: #b6b6b6; font-size: 14px; font-weight: 1000">Revenue</h3>
                     <div class="card-title-end">Total Revenue</div>
                     <div class="card-value-end" style="color: #0b8ad7;">$ 567,908</div>
                     <div class="card-title-end">Total Revenue Total Revenue Total Revenue</div>
                 </div>
                 <div class="text-center">
                     <svg class="stat-circle" width="100" viewBox="0 0 20 20">
                         <circle class="bg" cx="10" cy="10" r="8" />
                         <circle class="progress" cx="10" cy="10" r="8" data-percentage="70" style="stroke: #0b8ad7;" />
                         <text class="text" x="50%" y="50%">$ 3.467</text>
                         <text class="text" x="50%" y="65%" style="font-size:2px; fill: #d1d2d3">Weekly</text>
                     </svg>
                 </div>
             </div>

             <div class="card shadow" style="background: white;">
                 <div class="">
                     <h3 style="margin-bottom: 10px; color: #b6b6b6; font-size: 14px; font-weight: 1000">Expense</h3>
                     <div class="card-title-end">Total Expense</div>
                     <div class="card-value-end" style="color: #06c855;">$ 567,908</div>
                     <div class="card-title-end">Total Revenue Total Revenue Total Revenue</div>
                 </div>
                 <div class="text-center">
                     <svg class="stat-circle" width="100" viewBox="0 0 20 20">
                         <circle class="bg" cx="10" cy="10" r="8" />
                         <circle class="progress" cx="10" cy="10" r="8" data-percentage="70" style="stroke: #06c855;" />
                         <text class="text" x="50%" y="50%">$ 3.467</text>
                         <text class="text" x="50%" y="65%" style="font-size:2px; fill: #d1d2d3">Weekly</text>
                     </svg>
                 </div>
             </div>

             <div class="card shadow" style="background: white;">
                 <div class="">
                     <h3 style="margin-bottom: 10px; color: #b6b6b6; font-size: 14px; font-weight: 1000">Active</h3>
                     <div class="card-title-end">Total Active</div>
                     <div class="card-value-end" style="color: #cec520;">$ 567,908</div>
                     <div class="card-title-end">Total Revenue Total Revenue Total Revenue</div>
                 </div>
                 <div class="text-center">
                     <svg class="stat-circle" width="100" viewBox="0 0 20 20">
                         <circle class="bg" cx="10" cy="10" r="8" />
                         <circle class="progress" cx="10" cy="10" r="8" data-percentage="70" style="stroke: #cec520;" />
                         <text class="text" x="50%" y="50%">$ 3.467</text>
                         <text class="text" x="50%" y="65%" style="font-size:2px; fill: #d1d2d3">Weekly</text>
                     </svg>
                 </div>
             </div>


         </div>
     </div>
 </template>






 <script>
     window.io = require('socket.io-client');
     import Echo from "laravel-echo"
     window.e = Echo;
     export default {
         data() {
             return {
                 status: 0,
                 loading: true,
                 hover: true,
                 paginationData: {},
                 agents: {},
             };
         },
         mounted() {
            let vm = this;
             window.socket = window.io('http://127.0.0.1:6001');

             window.socket.on("connect", () => {
                 console.log(socket.id); // x8WIv7-mJelg7on_ALbx
             });

             socket.on('connect', function () {
                 console.log('socket connected')
             })
             socket.emit('subscribe', {
                 channel: 'rvm_database_call-status'
             })

             window.socket.on("disconnect", () => {
                 console.log(socket.id); // undefined
             });

             socket.on('App\\Events\\InCall', function (channel, data) {
                 console.log(data)
                 vm.agents.find(agent => agent.id == data.agent.id).status = data.message
             })
             socket.on('App\\Events\\OnHold', function (channel, data) {
                 console.log(data)
                 vm.agents.find(agent => agent.id == data.agent.id).status = data.message
             })
             socket.on('App\\Events\\Idle', function (channel, data) {
                 console.log(data)
                 vm.agents.find(agent => agent.id == data.agent.id).status = data.message
             })
             socket.on('App\\Events\\Disconnected', function (channel, data) {
                 console.log(data)
                 vm.agents.find(agent => agent.id == data.agent.id).status = data.message
             })

             this.getData();
         },
         methods: {
             async getData() {

                 let baseUrl = "/nova-api/custom/get-company-agents";
                 await Nova.request()
                     .get(baseUrl)
                     .then((response) => {
                         this.agents = response.data.agents.data;
                         console.log(this.agents);

                         this.paginationData = {
                             allMatchingResourceCount: response.data.agents.length,
                             currentPage: response.data.agents.current_page,
                             currentResourceCount: response.data.agents.total,
                             hasNextPage: response.data.agents.next_page_url !== null,
                             hasPreviousPage: response.data.agents.prev_page_url !== null,
                             resourceCountLabel: response.data.agents.from +
                                 "-" +
                                 response.data.agents.to +
                                 " of " +
                                 response.data.agents.total,
                             totalPages: response.data.agents.last_page,
                         };
                     });
             },

             async selectPage(val) {
                console.log(val);
                let params = {
                    page: val,
                };
                console.log(params);
                let baseUrl = "/nova-api/custom/get-company-agents";
                 await Nova.request()
                    .get(baseUrl, {
                        params
                    })
                    .then((response) => {
                         this.agents = response.data.agents.data;
                         console.log(this.agents);

                        this.paginationData = {
                             allMatchingResourceCount: response.data.agents.length,
                             currentPage: response.data.agents.current_page,
                             currentResourceCount: response.data.agents.total,
                             hasNextPage: response.data.agents.next_page_url !== null,
                             hasPreviousPage: response.data.agents.prev_page_url !== null,
                             resourceCountLabel: response.data.agents.from +
                                 "-" +
                                 response.data.agents.to +
                                 " of " +
                                 response.data.agents.total,
                             totalPages: response.data.agents.last_page,
                         };
                        Nova.$emit("resources-loaded", {});
                        this.$forceUpdate();

                        console.log("9.table_data------>", response.data.query);
                    });
            },
         },
     }

 </script>
 <style>
     .stat-circle .bg {
         fill: none;
         stroke: #f1f1f1;
         stroke-width: 2;
     }

     .progress {
         fill: none;
         /* stroke: #0b8ad7; */
         stroke-width: 2;
         stroke-dasharray: 50 50;
         stroke-dashoffset: -90;
         stroke-linecap: round;
     }

     .text {
         font-size: 3px;
         text-anchor: middle;
         fill: #555;
     }

     .custom-td {
         color: #9c9b9c;
         font-size: 12px;
     }





     .card-wrapper {
         justify-content: left;
         display: flex;
         flex-wrap: wrap;
     }

     td {
         border: solid 2px;
     }

     .card {
         color: white;
         display: flex;
         /* flex-direction: column; */
         justify-content: space-around;
         align-items: center;
         width: 270px;
         min-height: 130px;
         margin: 10px;
         padding: 10px;
         /* box-shadow: 0 20px 40px 0 rgba(204, 204, 204, 0.1); */
         border: 1px solid rgba(0, 0, 0, 0.1);
         border-radius: 10px;
         position: relative;
     }

     .card-value {
         font-size: 30px;
         font-family: "Roboto", sans-serif;
         font-weight: 1000;
         text-align: right;
         padding: 5px 0px 5px 0px;
     }

     .card-value-end {
         font-size: 20px;
         font-family: "Roboto", sans-serif;
         font-weight: 1000;
         text-align: left;
         padding: 5px 0px 5px 0px;
     }

     .card-title {

         font-weight: 500;
         font-size: 12px;
         margin-bottom: 5px;
         text-align: right;
     }

     .card-title-end {

         font-weight: 500;
         font-size: 12px;
         margin-bottom: 5px;
         text-align: left;
         color: #b6b6b6;
     }

     .card-icon {
         width: 50px;
         height: 50px;
         border-radius: 100%;
         display: flex;
         justify-content: center;
         align-items: center;
     }

     .card-status {
         font-weight: 500;
         font-size: 14px;
     }

     .custom-th {
         color: white;
         font-size: 9px;
     }

     @media (max-width: 600px) {
         body {
             height: auto;
         }
     }

     @media (max-width: 250px) {
         .card {
             width: 90%;
         }
     }

 </style>
