<aside class="sidebar">
   <div class="sidebar__menu-group">
      <ul class="sidebar_nav">
         <li class="menu-title">
            <span>Main menu </span>
         </li>
         <li>
            <a href="{{route('dashboards.index')}}"
               class="{{ Route::is('dashboards.index')  ? 'active' : '' }}">
            <span data-feather="user" class="nav-icon"></span>
            <span class="menu-text">Dashboard</span>
            </a>
         </li>
         @if(array_key_exists('ADMIN', $accessGranted))
         <li>
            <a href="{{ route('admin.index') }}"
               class="{{ Route::is('admin.index')  ? 'active' : '' }}">
            <span data-feather="user" class="nav-icon"></span>
            <span class="menu-text">Admin</span>
            </a>
         </li>
         @endif
         @if(array_key_exists('CUST', $accessGranted))
         <li>
            <a href="{{ route('customer.index') }}"
               class="{{ Route::is('customer.index')  ? 'active' : '' }}">
            <span data-feather="users" class="nav-icon"></span>
            <span class="menu-text">Customer </span>
            </a>
         </li>
         @endif
         @if(array_key_exists('CAT', $accessGranted))
         <li>
            <a href="{{ route('category.index') }}"
               class="{{ Route::is('category.index')  ? 'active' : '' }}">
            <span data-feather="target" class="nav-icon"></span>
            <span class="menu-text">Category </span>
            </a>
         </li>
         @endif
         @if(array_key_exists('ORDER', $accessGranted))
         <li>
            <a href="{{ route('order.index') }}"
               class="{{ Route::is('order.index')  ? 'active' : '' }}">
            <span data-feather="package" class="nav-icon"></span>
            <span class="menu-text">Order </span>
            </a>
         </li>
         @endif
         @if(array_key_exists('EMAIL', $accessGranted))
         <li>
            <a href="{{ route('mail.index') }}"
               class="{{ Route::is('mail.index')  ? 'active' : '' }}">
            <span data-feather="mail" class="nav-icon"></span>
            <span class="menu-text">Email Template </span>
            </a>
         </li>
         @endif
         @if(array_key_exists('PAYGAT', $accessGranted))
         <li>
            <a href="{{ route('payment.gateway') }}"
               class="{{ Route::is('payment.gateway')  ? 'active' : '' }}">

               <span data-feather="dollar-sign" class="nav-icon" ></span>
            <span class="menu-text">Payment Gateway </span>

            </a>
         </li>
         @endif
         @if(array_key_exists('EMACONF', $accessGranted))
         <li class="has-child {{ request()->is('configuration/*') ? 'open' : ''}}">
            <a href="#" class="{{ request()->is('configuration/*') ? 'active' : ''}}">
            <span data-feather="settings" class="nav-icon"></span>
            <span class="menu-text">Email Configuration</span>
            <span class="toggle-icon"></span>
            </a>
            @endif
            <ul>
            @if(array_key_exists('MADE', $accessGranted) && array_key_exists('EMACONF', $accessGranted))
               <li>
                  <a class="{{ Route::is('configuration.migration')  ? 'active' : ''}}"
                     href="{{ route('configuration.migration') }}">Migration ADE</a>
               </li>
               @endif
            @if(array_key_exists('SDP', $accessGranted)&& array_key_exists('EMACONF', $accessGranted))
               <li>
                  <a class="{{ Route::is('configuration.student') ? 'active' : ''}}"
                     href="{{ route('configuration.student') }}">Student Doc Pros</a>
               </li>
               @endif
            @if(array_key_exists('PDP', $accessGranted)&& array_key_exists('EMACONF', $accessGranted))
               <li>
                  <a class="{{ Route::is('configuration.passport') ? 'active' : ''}}"
                     href="{{ route('configuration.passport') }}">Passport Doc Pros</a>
               </li>
               @endif
            @if(array_key_exists('EIN', $accessGranted)&& array_key_exists('EMACONF', $accessGranted))
               <li>
                  <a class="{{ Route::is('configuration.ein') ? 'active' : ''}}"
                     href="{{ route('configuration.ein') }}">EIN</a>
               </li>
               @endif
            @if(array_key_exists('COA', $accessGranted)&& array_key_exists('EMACONF', $accessGranted))
               <li>
                  <a class="{{ Route::is('configuration.ncoa') ? 'active' : ''}}"
                     href="{{ route('configuration.ncoa') }}">COA</a>
               </li>
               @endif
            @if(array_key_exists('SBA', $accessGranted)&& array_key_exists('EMACONF', $accessGranted))
               <li>
                  <a class="{{ Route::is('configuration.sba') ? 'active' : ''}}"
                     href="{{ route('configuration.sba') }}">SBA</a>
               </li>
            @endif
            <li>
                <a class="{{ Route::is('configuration.prime-cloud') ? 'active' : ''}}"
                    href="{{ route('configuration.prime-cloud') }}">Prime Cloud</a>
            </li>
            </ul>
         </li>
         @if(array_key_exists('SBAPAY', $accessGranted))
         <li class="has-child {{ request()->is('sbaPayments/*') ? 'open' : ''}}">
            <a href="#" class="{{ request()->is('sbaPayments/*') ? 'active' : ''}}">
            <span data-feather="dollar-sign" class="nav-icon" ></span>
            <span class="menu-text">ACH Payments</span>
            <span class="toggle-icon"></span>
            </a>
            @endif
            <ul>
            @if(array_key_exists('SBAACH', $accessGranted)&& array_key_exists('SBAPAY', $accessGranted))

            <li>
                        <a class="{{ Route::is('ach.index') ? 'active' : ''}}"
                        href="{{ route('ach.index') }}" >   <span data-feather="dollar-sign" class="nav-icon" ></span>   SBA ACH</a>


            </li>
            @endif
            @if(array_key_exists('BADROUT', $accessGranted)&& array_key_exists('SBAPAY', $accessGranted))
            <li>
                        <a class="{{ Route::is('badrouting.index') ? 'active' : ''}}"
                        href="{{ route('badrouting.index') }}" >  <span data-feather="dollar-sign" class="nav-icon" ></span>  Bad Routing Number</a>
            <li>
            @endif
            @if(array_key_exists('RET', $accessGranted)&& array_key_exists('SBAPAY', $accessGranted))
            <li>
                        <a class="{{ Route::is('badrouting.return') ? 'active' : ''}}"
                        href="{{ route('badrouting.return') }}" >  <span data-feather="dollar-sign" class="nav-icon" ></span>  Returns</a>

            </li>
            @endif
            </ul>
         </li>
         @if(array_key_exists('MANPRO', $accessGranted))
         <li class="has-child {{ request()->is('manual/*') ? 'open' : ''}}">
            <a href="#" class="{{ request()->is('manual/*') ? 'active' : ''}}">
            <span data-feather="repeat" class="nav-icon"></span>
            <span class="menu-text">Manual Processing</span>
            <span class="toggle-icon"></span>
            </a>
            @endif
            <ul>
            @if(array_key_exists('EINAPP', $accessGranted)&&array_key_exists('MANPRO', $accessGranted))
               <li>
                  <a class="{{ Route::is('ein.index')  ? 'active' : ''}}"
                     href="{{ route('ein.index') }}">EIN Application</a>
               </li>
               @endif
               @if(array_key_exists('SBAAPP', $accessGranted)&&array_key_exists('MANPRO', $accessGranted))
               <li>
                           <a class="{{ Route::is('sba.index') ? 'active' : ''}}"
                              href="{{ route('sba.index') }}"> SBA Application</a>

                     </li>
                     @endif

               <li>
               @if(array_key_exists('COAAPP', $accessGranted)&&array_key_exists('MANPRO', $accessGranted))
                  <a class="{{ Route::is('coa.index') ? 'active' : ''}}"
                     href="{{ route('coa.index') }}">Change of Address</a>
               </li>
               @endif

            </ul>
         </li>
         @if(array_key_exists('LOGS', $accessGranted))
         <li class="has-child {{ request()->is('dashboards/*') ? 'open' : ''}}">
            <a href="#" class="{{ request()->is('dashboards/*') ? 'active' : ''}}">
            <span data-feather="terminal" class="nav-icon"></span>
            <span class="menu-text">Logs</span>
            <span class="toggle-icon"></span>
            </a>
         @endif
            <ul>
                @if(array_key_exists('PAYLOG', $accessGranted)&&(array_key_exists('LOGS', $accessGranted)))
               <li>
                  <a class="{{ Route::is('log.payment')  ? 'active' : ''}}"
                     href="{{ route('log.payment') }}"><i class="fas fa-hand-holding-usd"></i> &nbsp; Payment Logs</a>
               </li>
               @endif
               @if(array_key_exists('APILOGS', $accessGranted)&& (array_key_exists('LOGS', $accessGranted)))
               <li>
                  <a class="{{ Route::is('log.api') ? 'active' : ''}}"
                     href="{{ route('log.api') }}"><i class="fas fa-braille"></i> &nbsp; APIs Logs</a>
               </li>
               @endif
               @if(array_key_exists('EMAILLOGS', $accessGranted)&&(array_key_exists('LOGS', $accessGranted)))
               <li>
                  <a class="{{ Route::is('log.email') ? 'active' : ''}}"
                     href="{{ route('log.email') }}"><i class="fas fa-mail-bulk"></i> &nbsp; Email Logs</a>
               </li>
               @endif
               @if(array_key_exists('LOBLOGS', $accessGranted)&& (array_key_exists('LOGS', $accessGranted)))
               <li>
                  <a class="{{ Route::is('log.lob') ? 'active' : ''}}"
                     href="{{ route('log.lob') }}"><img src="https://s3-us-west-2.amazonaws.com/public.lob.com/sites/brand-favicon.ico" width="25px" height="25px"> LOB Logs</a>
               </li>
               @endif
               @if(array_key_exists('REFLOGS', $accessGranted)&& (array_key_exists('LOGS', $accessGranted)))
               <li>
                  <a class="{{ Route::is('log.refund') ? 'active' : ''}}"
                     href="{{ route('log.refund') }}"><img src="{{asset('img/svg/refund.svg')}}" width="25px" height="25px" style="padding:2px;">Refund Logs</a>
               </li>
               @endif
               @if(array_key_exists('REFSTATLOGS', $accessGranted)&& (array_key_exists('LOGS', $accessGranted)))
               <li>
                  <a class="{{ Route::is('refunds.log') ? 'active' : ''}}"
                     href="{{ route('refunds.log') }}"><img src="{{asset('img/svg/mono-invert.svg')}}" width="25px" height="25px" style="padding:2px;">Refund Status Logs</a>
               </li>
               @endif
               @if(array_key_exists('REFSTATLOGS', $accessGranted)&& (array_key_exists('LOGS', $accessGranted)))
               <li>
                  <a class="{{ Route::is('log.recurring_payment') ? 'active' : ''}}"
                     href="{{ route('log.recurring_payment') }}"><img src="{{asset('img/svg/cancellation-of-order-1.svg')}}" width="25px" height="25px" style="padding:2px;">Recurring Payment Logs</a>
               </li>
               @endif
            </ul>
         </li>
            @if(array_key_exists('REF', $accessGranted))
            <li>
               <a href="{{ route('refunds.index') }}"
                  class="{{ Route::is('refunds.index')  ? 'active' : '' }}">
               <span data-feather="shuffle" class="nav-icon"></span>
               <span class="menu-text">Refund </span>
               </a>
            </li>
            @endif
            @if(array_key_exists('PCLOUDSTOR', $accessGranted))
          <li class="has-child {{ request()->is('primecloudstorage/*') ? 'open' : ''}}">
            <a href="#" class="{{ request()->is('primecloudstorage/*') ? 'active' : ''}}">
            <span data-feather="upload-cloud" class="nav-icon" ></span>
            <span class="menu-text">Prime Cloud Storage</span>
            <span class="toggle-icon"></span>
            </a>
            @endif
            <ul>
            @if(array_key_exists('PORDER', $accessGranted)&& (array_key_exists('PCLOUDSTOR', $accessGranted)))
            <li>
                        <a class="{{ Route::is('storage.orders') ? 'active' : ''}}"
                        href="{{ route('storage.orders') }}" >   <span data-feather="cloud-rain" class="nav-icon" ></span>Orders</a>
            </li>
            @endif
            @if(array_key_exists('PNOTES', $accessGranted)&& (array_key_exists('PCLOUDSTOR', $accessGranted)))
            <li>
                        <a class=""
                        href="{{route('storage.viewnotes')}}" >  <span data-feather="file-minus" class="nav-icon" ></span>Notes</a>
            <li>
            @endif
            @if(array_key_exists('PLOGS', $accessGranted))
            <li class="has-child {{ request()->is('primecloudstorage/*') ? 'open' : ''}}">
            <a href="#" >
            <span data-feather="upload-cloud" class="nav-icon" ></span>
            <span class="menu-text">Logs</span>
            <span class="toggle-icon"></span>
            </a>
            @endif
            <ul>
            @if(array_key_exists('PAPILOGS', $accessGranted)&& (array_key_exists('PLOGS', $accessGranted)))
            <li>
                        <a class="{{ Route::is('storage.apilogs') ? 'active' : ''}}"
                        href="{{ route('storage.apilogs') }}" >   <span data-feather="file-plus" class="nav-icon" ></span>Api Logs</a>
            </li>
            @endif
            @if(array_key_exists('PEMAILLOGS', $accessGranted)&& (array_key_exists('PLOGS', $accessGranted)))
            <li>
                        <a class="{{ Route::is('storage.emaillogs') ? 'active' : ''}}"
                        href="{{ route('storage.emaillogs') }}" >   <span data-feather="mail" class="nav-icon" ></span>Email Logs</a>
            </li>
            @endif
            @if(array_key_exists('PPAYLOGS', $accessGranted)&& (array_key_exists('PLOGS', $accessGranted)))
            <li>
                        <a class="{{ Route::is('storage.paymentlogs') ? 'active' : ''}}"
                        href="{{ route('storage.paymentlogs') }}" >   <span data-feather="framer" class="nav-icon" ></span>Payment Logs</a>
            </li>
            @endif
            @if(array_key_exists('PRECLOGS', $accessGranted)&& (array_key_exists('PLOGS', $accessGranted)))
            <li>
                        <a class="{{ Route::is('storage.recurringlogs') ? 'active' : ''}}"
                        href="{{ route('storage.recurringlogs') }}" >   <span data-feather="arrow-right-circle" class="nav-icon" ></span>Recurring Logs</a>
            </li>
            @endif
            @if(array_key_exists('PREFLOGS', $accessGranted)&& (array_key_exists('PLOGS', $accessGranted)))
            <li>
                        <a class="{{ Route::is('storage.refundlogs') ? 'active' : ''}}"
                        href="{{ route('storage.refundlogs') }}" >   <span data-feather="navigation" class="nav-icon" ></span>Refund Logs</a>
            </li>
            @endif
            </ul>
            </li>
            </ul>
         </li>
          <li class="has-child {{ request()->is('cmspages/*') ? 'open' : ''}}">
            <a href="#" class="{{ request()->is('cmspages/*') ? 'active' : ''}}">
            <span data-feather="aperture" class="nav-icon" ></span>
            <span class="menu-text">CMS Pages</span>
            <span class="toggle-icon"></span>
            </a>
            <ul>
            <li>
               <a class="{{ Route::is('cmspages.migrationade') ? 'active' : ''}}" href="{{ route('cmspages.migrationade') }}" >   <span data-feather="layers" class="nav-icon" ></span>Migrationade</a>
            </li>
            <li>
               <a class="{{ Route::is('cmspages.changeofaddress') ? 'active' : ''}}" href="{{ route('cmspages.changeofaddress') }}" >  <span data-feather="layers" class="nav-icon" ></span>Change Of Address</a>
            </li>
            <li>
               <a class="{{ Route::is('cmspages.passport') ? 'active' : ''}}" href="{{ route('cmspages.passport') }}"><span data-feather="layers" class="nav-icon" ></span>Passport Doc pros</a>
            </li>
            <li>
               <a class="{{ Route::is('cmspages.studentloan') ? 'active' : ''}}" href="{{ route('cmspages.studentloan') }}"><span data-feather="layers" class="nav-icon" ></span>Student Loan Doc Pros</a>
            </li>
            <li>
               <a class="{{ Route::is('cmspages.sba') ? 'active' : ''}}" href="{{ route('cmspages.sba') }}"><span data-feather="layers" class="nav-icon" ></span> SBA Disaster Pros</a>
            </li>
            <li>
               <a class="{{ Route::is('cmspages.ein') ? 'active' : ''}}" href="{{ route('cmspages.ein') }}"><span data-feather="layers" class="nav-icon" ></span> EIN </a>
            </li>
            </ul>
         </li>

      </ul>
   </div>
</aside>
