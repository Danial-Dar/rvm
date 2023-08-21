<aside class="sidebar">
   <div class="sidebar__menu-group">
      <ul class="sidebar_nav">
         <li class="menu-title">
            <span>Main menu </span>
         </li>
         <li>
         @if(auth()->user()->role == "admin")
         <a href="{{ route('admin.dashboard') }}" class="{{ Route::is('admin.dashboard')  ? 'active' : '' }}">
            <span data-feather="compass" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Dashboard"></span>
            <span class="menu-text">Dashboard</span>
            </a>
         </li>
         <li>
            <a href="{{ route('admin.reports.counters_index') }}" class="{{ Route::is('admin.reports.counters_index')  ? 'active' : '' }}">
               <span data-feather="pie-chart" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Reports"></span>
               <span class="menu-text">Reports</span>
            </a>
            {{-- <ul>
               <li>
                  <a class="{{ Route::is('admin.reports.counters_index') ? 'active' : ''}}"
                  href="{{ route('admin.reports.counters_index') }}" ><span data-feather="cloud-rain" class="nav-icon" ></span>Counters</a>
               </li>
               <li>
                  <a class="{{ Route::is('admin.reports.callback_pie') ? 'active' : ''}}"
                  href="{{ route('admin.reports.callback_pie') }}" ><span data-feather="pie-chart" class="nav-icon" ></span>Call Back Pie Charts</a>
               </li>
               <li>
                  <a class="{{ Route::is('admin.reports.callback') ? 'active' : ''}}"
                  href="{{ route('admin.reports.callback') }}" ><span data-feather="cloud-rain" class="nav-icon" ></span>Call Back Heat Map</a>
               </li>
               <li>
                  <a class="{{ Route::is('admin.reports.call_sent_destination') ? 'active' : ''}}"
                  href="{{ route('admin.reports.call_sent_destination') }}" ><span data-feather="cloud-rain" class="nav-icon" ></span>Call Sent Destination Heat Map</a>
               </li>
               <li>
                  <a class="{{ Route::is('admin.reports.call_back_duration') ? 'active' : ''}}"
                  href="{{ route('admin.reports.call_back_duration') }}" ><span data-feather="cloud-rain" class="nav-icon" ></span>Call Back Duration Heat Map</a>
               </li>
            </ul> --}}
         </li>
         <li>
            <a href="{{ route('admin.billing') }}" class="{{ Route::is('admin.billing')  ? 'active' : '' }}">
               <span data-feather="paperclip" class="nav-icon"></span>
               <span class="menu-text">Billing Section</span>
            </a>
         </li>
         <li>
         <a href="{{ route('user') }}" class="{{ Route::is('user')  ? 'active' : '' }}">
            <span data-feather="user" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Manage  Users"></span>
            <span class="menu-text">Manage Users</span>
            </a>
         </li>
         <li>
         <a href="{{ route('admin.company') }}" class="{{ Route::is('admin.company')  ? 'active' : '' }}">
            <span data-feather="briefcase" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Manage Company"></span>
            <span class="menu-text">Manage Company</span>
            </a>
         </li>
         <li>
         <a href="{{ route('admin.recording') }}" class="{{ Route::is('admin.recording')  ? 'active' : '' }}">
            <span data-feather="headphones" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Manage Audio"></span>
            <span class="menu-text">Manage Audio</span>
            </a>
         </li>
         <li>
          <a href="{{ route('admin.contact-list') }}" class="{{ Route::is('admin.contact-list')  ? 'active' : '' }}">
            <span data-feather="hash" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Manage List"></span>
            <span class="menu-text">Manage List</span>
            </a>
         </li>

         <li>
            <a href="{{ route('admin.dnc-list') }}" class="{{ Route::is('admin.dnc-list')  ? 'active' : '' }}">
               <span data-feather="x" class="nav-icon" data-toggle="tooltip" data-placement="right" title="DNC"></span>
               <span class="menu-text">DNC</span>
            </a>
         </li>
         <li>
            <a href="{{ route('admin.api-setting') }}" class="{{ Route::is('admin.api-setting')  ? 'active' : '' }}">
               <span data-feather="aperture" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Api Setting"></span>
               <span class="menu-text">Api Setting</span>
            </a>
         </li>
         <li>
            <a href="{{ route('admin.logs') }}" class="{{ Route::is('admin.logs')  ? 'active' : '' }}">
               <span data-feather="hexagon" class="nav-icon" data-toggle="tooltip" data-placement="right" title="View Logs"></span>
               <span class="menu-text">Logs</span>
            </a>
         </li>
         <li>
            <a href="{{ route('admin.numbers') }}" class="{{ Route::is('admin.numbers')  ? 'active' : '' }}">
               <span data-feather="smartphone" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Numbers"></span>
               <span class="menu-text">Numbers</span>
            </a>
         </li>
         {{-- <li>
            <a href="{{ route('admin.sw_numbers') }}" class="{{ Route::is('admin.sw_numbers')  ? 'active' : '' }}">
               <span data-feather="smartphone" class="nav-icon" data-toggle="tooltip" data-placement="right" title="SW Numbers"></span>
               <span class="menu-text">SW Numbers</span>
            </a>
         </li> --}}
         {{-- <li>
            <a href="{{ route('admin.invoices') }}" class="{{ Route::is('admin.invoices')  ? 'active' : '' }}">
               <span data-feather="aperture" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Invoices"></span>
               <span class="menu-text">Invoice</span>
            </a>
         </li> --}}
         <li>
            <a href="{{ route('admin.incoming_call_log') }}" class="{{ Route::is('admin.incoming_call_log')  ? 'active' : '' }}">
               <span data-feather="target" class="nav-icon"></span>
               <span class="menu-text">Incoming Call Log</span>
            </a>
         </li>
         <li class="has-child {{ Route::is('callerid.checked_contacts')
            || Route::is('admin.sms_contact-list.contact-list') || Route::is('admin.sms_banned_word')
             || Route::is('admin.sms_campaigns') ? 'open' : ''}}">
            <a href="{{ route('admin.sms_campaigns') }}" class="{{ Route::is('admin.sms_campaigns')  ? 'active' : '' }}">
               <span data-feather="send" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Sms Campaign"></span>
               <span class="menu-text">SMS</span>
            </a>
            <ul>
               <li>
                  <a class="{{ Route::is('admin.sms_campaigns') ? 'active' : ''}}"
                  href="{{ route('admin.sms_campaigns') }}" ><span data-feather="cloud-rain" class="nav-icon" ></span>Campaigns</a>
               </li>
               <li>
                  <a class="{{ Route::is('admin.sms_contact-list.contact-list') ? 'active' : ''}}"
                  href="{{ route('admin.sms_contact-list.contact-list') }}" ><span data-feather="hash" class="nav-icon" ></span>Manage List</a>
               </li>
               <li>
                  <a class="{{ Route::is('admin.sms_banned_word') ? 'active' : ''}}"
                  href="{{ route('admin.sms_banned_word') }}" ><span data-feather="slash" class="nav-icon" ></span>Sms Banned Words</a>
               </li>
               <li>
                <a class="{{ Route::is('admin.opt_out_word') ? 'active' : ''}}"
                href="{{ route('admin.opt_out_word') }}" ><span data-feather="send" class="nav-icon" ></span>Sms OptOut Word</a>
                </li>
                {{-- <li>
                    <a class="{{ Route::is('admin.domain') ? 'active' : ''}}"
                    href="{{ route('admin.domain') }}" ><span data-feather="link" class="nav-icon" ></span>Domains</a>
                    </li>
               <li> --}}
                  <a class="{{ Route::is('admin.sms.billing') ? 'active' : ''}}"
                  href="{{ route('admin.sms.billing') }}" ><span data-feather="book" class="nav-icon" ></span>Sms Billing Section</a>
               </li>
            </ul>
         </li>



         @endif
         {{--  || auth()->user()->role == "company" --}}
         @if(auth()->user()->role == "user")
         <li>
            <a href="{{ route('user.dashboard') }}" class="{{ Route::is('user.dashboard')  ? 'active' : '' }}">
               <span data-feather="compass" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Dashboard"></span>
               <span class="menu-text">Dashboard</span>
            </a>
         </li>
         {{-- <li class="has-child {{ Route::is('user.dashboard') ? 'open' : ''}}">
            <a href="{{ route('user.dashboard') }}" class="{{ Route::is('user.dashboard')  ? 'active' : '' }}">
               <span data-feather="file" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Reports"></span>
               <span class="menu-text">Reports</span>
            </a>
            <ul>
               <li>
                  <a class="{{ Route::is('user.dashboard') ? 'active' : ''}}"
                  href="{{ route('user.dashboard') }}" ><span data-feather="cloud-rain" class="nav-icon" ></span>Counters</a>
               </li>
               <li>
                  <a class="{{ Route::is('user.reports.callback_pie') ? 'active' : ''}}"
                  href="{{ route('user.reports.callback_pie') }}" ><span data-feather="pie-chart" class="nav-icon" ></span>Call Back Pie Charts</a>
               </li>
               <li>
                  <a class="{{ Route::is('user.reports.callback') ? 'active' : ''}}"
                  href="{{ route('user.reports.callback') }}" ><span data-feather="cloud-rain" class="nav-icon" ></span>Call Back Heat Map</a>
               </li>
               <li>
                  <a class="{{ Route::is('user.reports.call_sent_destination') ? 'active' : ''}}"
                  href="{{ route('user.reports.call_sent_destination') }}" ><span data-feather="cloud-rain" class="nav-icon" ></span>Call Sent Destination Heat Map</a>
               </li>
               <li>
                  <a class="{{ Route::is('user.reports.call_back_duration') ? 'active' : ''}}"
                  href="{{ route('user.reports.call_back_duration') }}" ><span data-feather="cloud-rain" class="nav-icon" ></span>Call Back Duration Heat Map</a>
               </li>
            </ul>
         </li> --}}
         <li>
         <a href="{{ route('user.recording') }}" class="{{ Route::is('user.recording')  ? 'active' : '' }}">
            <span data-feather="headphones" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Manage Audio"></span>
            <span class="menu-text">Manage Audio</span>
            </a>
         </li>

         <li>
         <a href="{{ route('user.contact-list') }}" class="{{ Route::is('user.contact-list')  ? 'active' : '' }}">
            <span data-feather="hash" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Manage List"></span>
            <span class="menu-text">Manage List</span>
            </a>
         </li>

         <li>
         <a href="{{ route('user.campaign') }}" class="{{ Route::is('user.campaign')  ? 'active' : '' }}">
            <span data-feather="phone" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Campaign"></span>
            <span class="menu-text">Campaign</span>
            </a>
         </li>

         <li>
            <a href="{{ route('user.dnc-list') }}" class="{{ Route::is('user.dnc-list')  ? 'active' : '' }}">
               <span data-feather="x" class="nav-icon" data-toggle="tooltip" data-placement="right" title="DNC List"></span>
               <span class="menu-text">DNC List</span>
            </a>
         </li>

          <li>
            <a href="{{ route('user.dnc-time') }}" class="{{ Route::is('user.dnc-time')  ? 'active' : '' }}">
               <span data-feather="clock" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Campaign Hours"></span>
               <span class="menu-text">Campaign Hours</span>
            </a>
         </li>

          {{-- <li>
            <a href="{{ route('user.user_setting') }}" class="{{ Route::is('user.user_setting')  ? 'active' : '' }}">
               <span data-feather="aperture" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Settings"></span>
               <span class="menu-text">Settings</span>
            </a>
         </li> --}}


         {{-- <li>
            <a href="{{ route('user.invoices') }}" class="{{ Route::is('user.invoices')  ? 'active' : '' }}">
               <span data-feather="aperture" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Invoices"></span>
               <span class="menu-text">Invoice</span>
            </a>
         </li> --}}
         <li>
            <a href="{{ route('user.billing') }}" class="{{ Route::is('user.billing')  ? 'active' : '' }}">
               <span data-feather="paperclip" class="nav-icon"></span>
               <span class="menu-text">Billing Section</span>
            </a>
         </li>
         <li>
            <a href="{{ route('user.incoming_call_log') }}" class="{{ Route::is('user.incoming_call_log')  ? 'active' : '' }}">
               <span data-feather="target" class="nav-icon"></span>
               <span class="menu-text">Incoming Call Log</span>
            </a>
         </li>
         <li>
            <a href="{{ route('user.my_numbers') }}" class="{{ Route::is('user.my_numbers')  ? 'active' : '' }}">
            <span data-feather="smartphone" class="nav-icon" data-toggle="tooltip" data-placement="right" title="My Numbers"></span>
            <span class="menu-text">My Numbers</span>
            </a>
         </li>
         <li class="has-child {{ Route::is('user.sms_campaigns') || Route::is('user.sms_contact-list.contact-list') || Route::is('user.sms_reports') ? 'open' : ''}}">
            <a href="{{ route('user.sms_campaigns') }}" class="{{ Route::is('user.sms_campaigns')  ? 'active' : '' }}">
               <span data-feather="send" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Reports"></span>
               <span class="menu-text">SMS</span>
            </a>
            <ul>
               <li>
                  <a class="{{ Route::is('user.sms_campaigns') ? 'active' : ''}}"
                  href="{{ route('user.sms_campaigns') }}" ><span data-feather="cloud-rain" class="nav-icon" ></span>Campaigns</a>
               </li>
               <li>
                  <a class="{{ Route::is('user.sms_contact-list.contact-list') ? 'active' : ''}}"
                  href="{{ route('user.sms_contact-list.contact-list') }}" ><span data-feather="list" class="nav-icon" ></span>Manage List</a>
               </li>
               <li>
                  <a class="{{ Route::is('user.sms_reports') ? 'active' : ''}}"
                  href="{{ route('user.sms_reports') }}" ><span data-feather="flag" class="nav-icon" ></span>Sms Reports</a>
               </li>
               <li>
                <a class="{{ Route::is('user.opt_out_word') ? 'active' : ''}}"
                href="{{ route('user.opt_out_word') }}" ><span data-feather="book" class="nav-icon" ></span>Sms OptOut Word</a>
                </li>
               {{-- <li>
                <a class="{{ Route::is('user.domain') ? 'active' : ''}}"
                href="{{ route('user.domain') }}" ><span data-feather="pie-chart" class="nav-icon" ></span>Domains</a>
                </li> --}}
           <li>
                </li>
            </ul>
         </li>



         @endif
         @if(auth()->user()->role == "company")
            <li>
                  <a href="{{ route('company.dashboard') }}" class="{{ Route::is('company.dashboard')  ? 'active' : '' }}">
                     <span data-feather="compass" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Dashboard"></span>
                     <span class="menu-text">Dashboard</span>
                  </a>
            </li>
            {{-- <li class="has-child {{ Route::is('company.dashboard') ? 'open' : ''}}">
               <a href="{{ route('company.dashboard') }}" class="{{ Route::is('company.dashboard')  ? 'active' : '' }}">
                  <span data-feather="file" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Reports"></span>
                  <span class="menu-text">Reports</span>
               </a>
               <ul>
                  <li>
                     <a class="{{ Route::is('company.dashboard') ? 'active' : ''}}"
                     href="{{ route('company.dashboard') }}" ><span data-feather="cloud-rain" class="nav-icon" ></span>Counters</a>
                  </li>
                  <li>
                     <a class="{{ Route::is('company.reports.callback_pie') ? 'active' : ''}}"
                     href="{{ route('company.reports.callback_pie') }}" ><span data-feather="pie-chart" class="nav-icon" ></span>Call Back Pie Charts</a>
                  </li>
                  <li>
                     <a class="{{ Route::is('company.reports.callback') ? 'active' : ''}}"
                     href="{{ route('company.reports.callback') }}" ><span data-feather="cloud-rain" class="nav-icon" ></span>Call Back Heat Map</a>
                  </li>
                  <li>
                     <a class="{{ Route::is('company.reports.call_sent_destination') ? 'active' : ''}}"
                     href="{{ route('company.reports.call_sent_destination') }}" ><span data-feather="cloud-rain" class="nav-icon" ></span>Call Sent Destination Heat Map</a>
                  </li>
                  <li>
                     <a class="{{ Route::is('company.reports.call_back_duration') ? 'active' : ''}}"
                     href="{{ route('company.reports.call_back_duration') }}" ><span data-feather="cloud-rain" class="nav-icon" ></span>Call Back Duration Heat Map</a>
                  </li>
               </ul>
            </li> --}}
            <li>
            <li>
            <a href="{{ route('company.recording') }}" class="{{ Route::is('company.recording')  ? 'active' : '' }}">
               <span data-feather="headphones" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Manage Audio"></span>
               <span class="menu-text">Manage Audio</span>
               </a>
            </li>

            <li>
            <a href="{{ route('company.contact-list') }}" class="{{ Route::is('company.contact-list')  ? 'active' : '' }}">
               <span data-feather="hash" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Manage List"></span>
               <span class="menu-text">Manage List</span>
               </a>
            </li>

            <li>
            <a href="{{ route('company.campaign') }}" class="{{ Route::is('company.campaign')  ? 'active' : '' }}">
               <span data-feather="phone" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Campaign"></span>
               <span class="menu-text">Campaign</span>
               </a>
            </li>

            <li>
               <a href="{{ route('company.dnc-list') }}" class="{{ Route::is('company.dnc-list')  ? 'active' : '' }}">
                  <span data-feather="x" class="nav-icon" data-toggle="tooltip" data-placement="right" title="DNC List"></span>
                  <span class="menu-text">DNC List</span>
               </a>
            </li>

            <li>
               <a href="{{ route('company.dnc-time') }}" class="{{ Route::is('company.dnc-time')  ? 'active' : '' }}">
                  <span data-feather="clock" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Campaign Hours"></span>
                  <span class="menu-text">Campaign Hours</span>
               </a>
            </li>

            <li>
               <a href="{{ route('company.user_setting') }}" class="{{ Route::is('company.user_setting')  ? 'active' : '' }}">
                  <span data-feather="aperture" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Settings"></span>
                  <span class="menu-text">Settings</span>
               </a>
            </li>
            <li>
               <a href="{{ route('company.company_user') }}" class="{{ Route::is('company.company_user')  ? 'active' : '' }}">
               <span data-feather="user" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Manage Users"></span>
               <span class="menu-text">Manage Users</span>
               </a>
            </li>

            <li>
               <a href="{{ route('company_admin.billing') }}" class="{{ Route::is('company_admin.billing')  ? 'active' : '' }}">
               <span data-feather="paperclip" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Billings"></span>
               <span class="menu-text">Billing Section</span>
               </a>
            </li>
            {{-- <li>
               <a href="{{ route('company.invoices') }}" class="{{ Route::is('company.invoices')  ? 'active' : '' }}">
                  <span data-feather="aperture" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Invoices"></span>
                  <span class="menu-text">Invoice</span>
               </a>
            </li> --}}
            <li>
               <a href="{{ route('company.my_numbers') }}" class="{{ Route::is('company.my_numbers')  ? 'active' : '' }}">
               <span data-feather="smartphone" class="nav-icon" data-toggle="tooltip" data-placement="right" title="My Numbers"></span>
               <span class="menu-text">My Numbers</span>
               </a>
            </li>
            <li>
               <a href="{{ route('company.incoming_call_log') }}" class="{{ Route::is('company.incoming_call_log')  ? 'active' : '' }}">
                  <span data-feather="target" class="nav-icon"></span>
                  <span class="menu-text">Incoming Call Log</span>
               </a>
            </li>
            <li class="has-child {{ Route::is('company.sms_campaigns') || Route::is('company.sms_contact-list.contact-list') || Route::is('admin.sms_banned_word') ? 'open' : ''}}">
            <a href="{{ route('admin.sms_campaigns') }}" class="{{ Route::is('admin.sms_campaigns')  ? 'active' : '' }}">
               <span data-feather="send" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Sms Campaign"></span>
               <span class="menu-text">SMS</span>
            </a>
            <ul>
               <li>
                  <a class="{{ Route::is('company.sms_campaigns') ? 'active' : ''}}"
                  href="{{ route('company.sms_campaigns') }}" ><span data-feather="cloud-rain" class="nav-icon" ></span>Campaigns</a>
               </li>
               <li>
                  <a class="{{ Route::is('company.sms_contact-list.contact-list') ? 'active' : ''}}"
                  href="{{ route('company.sms_contact-list.contact-list') }}" ><span data-feather="hash" class="nav-icon" ></span>Manage List</a>
               </li>
               <li>
                  <a class="{{ Route::is('company.sms_reports') ? 'active' : ''}}"
                  href="{{ route('company.sms_reports') }}" ><span data-feather="pie-chart" class="nav-icon" ></span>Sms Reports</a>
               </li>
               {{--
               <li>
                  <a class="{{ Route::is('admin.sms.billing') ? 'active' : ''}}"
                  href="{{ route('company.sms.billing') }}" ><span data-feather="pie-chart" class="nav-icon" ></span>Sms Billing Section</a>
               </li>  --}}
            </ul>
         </li>
         @endif

        <li class="has-child {{ Route::is('callerid.report') || Route::is('callerid.list') || Route::is('callerid.billing') ? 'open' : '' }}">
            <a href="{{ route('callerid.list') }}" class="{{ Route::is('callerid.list') ? 'active' : ''}}">
               <span data-feather="phone-forwarded" class="nav-icon" data-toggle="tooltip" data-placement="right" title="Reports"></span>
               <span class="menu-text">Caller Id</span>
            </a>
            <ul>
                <li>
                    <a class="{{ Route::is('callerid.report') ? 'active' : '' }}"
                    href="{{ route('callerid.report') }}" ><span data-feather="pie-chart" class="nav-icon" ></span>Reports</a>
                 </li>
                <li>
                   <a class="{{ Route::is('callerid.list') ? 'active' : '' }}"
                   href="{{ route('callerid.list') }}" ><span data-feather="flag" class="nav-icon" ></span>Manage All</a>
                </li>
                {{-- <li>
                    <a class="{{ Route::is('callerid.billing') ? 'active' : '' }}"
                    href="{{ route('callerid.billing') }}" ><span data-feather="target" class="nav-icon" ></span>Billing</a>
                 </li> --}}
             </ul>
        </li>



         {{-- @if(auth()->user()->role == "user")


         @endif --}}





      </ul>
   </div>
</aside>
