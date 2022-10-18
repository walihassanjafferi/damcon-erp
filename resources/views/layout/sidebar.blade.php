 <!-- BEGIN: Main Menu-->
 <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ url('/') }}"><span class="brand-logo">
                <img src="{{ asset('project_images/mini_logo.png') }}" style="width:230px;" />
            </span>
            <h2 class="brand-text">Damcon ERP</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item"><a class="d-flex align-items-center" href="{{ url("/") }}"><i class="fa fa-home" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span>
                {{-- <span class="badge badge-light-warning badge-pill ml-auto mr-1">2</span> --}}
            </a>

            </li>
            <li class="navigation-header"><span data-i18n="Apps &amp; Pages">ERP Modules</span><i data-feather="more-horizontal"></i>
            </li>


            {{-- supplier management --}}

            {{-- @canany(['supplier_purchase_order','rental_purchase_order','supplier_payments_management_modules'])
            <li class="nav-item"><a class="d-flex align-items-center" href="#"><i data-feather='users'></i><span class="menu-title text-truncate" data-i18n="Stakeholders">Supplier Management</span></a>
                <ul class="menu-content">

                    <li class="nav-item">
                        <a class="d-flex align-items-center" href="#">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="All customer related reports">Supplier types</span>
                        </a>
                    </li>

                    @can('supplier_purchase_order')
                    <li class="@yield('supplierpos_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('supplierspos.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Suppliers PO Management">Suppliers PO Management</span>
                        </a>
                    </li>
                    @endcan


                    @can('rental_purchase_order')
                    <li class="@yield('rentalpos_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('rentalpos.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Rental PO Management">Rental PO Management</span>
                        </a>
                    </li>
                    @endcan


                    @can('services_purchase_order')
                    <li class="@yield('servicespos_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('servicespos.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Maintenance Items & Services PO Management">Maintenance Items & Services PO Management</span>
                        </a>
                    </li>
                    @endcan


                    @can('supplier_payments_management_modules')
                    <li class="@yield('supplier_payment_management_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('supplier_payment_management.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Supplier Payments">Supplier Payments</span>
                        </a>
                    </li>
                    @endcan



                </ul>
            </li> 
            @endcanany --}}

            {{-- supplier management end--}}


            {{-- Finance Management --}}
            
            {{-- @canany(['manage-banks','manage-interbank-transfer','manage-import-purchases','batches_management_modules','batches_payments_management_modules'
            ,'manage-investors','loan_payments_management_modules','salaries-management','advance-hr-payments','tax_bodies_modules','sales_tax_return_management','supplier_tax_payments_management','employees_tax_management',
            'damcon_assets_modules','assets_purchase_order','damcon_assets_depreciation_modules'])
            <li class="nav-item"><a class="d-flex align-items-center" href="#"><i data-feather='dollar-sign'></i><span class="menu-title text-truncate" data-i18n="Stakeholders">Finance Management</span></a>
                <ul class="menu-content">

                    @can(['manage-banks'])
                        <li class="@yield('bank_sidebar') nav-item">
                            <a class="d-flex align-items-center" href="{{ route('bankaccounts.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Bank Accounts">Bank Accounts</span>
                            </a>
                        </li>
                    @endcan

                    @can(['manage-interbank-transfer'])
                        <li class="@yield('interbank_sidebar') nav-item">
                            <a class="d-flex align-items-center" href="{{ route('interbanktransfer.index') }}">
                                <i data-feather='circle'></i>
                                <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Inter-Bank Transfer">Inter-Bank Transfer</span>
                            </a>
                        </li>
                    @endcan

                    @can('manage-import-purchases')
                        <li class="@yield('import_sidebar') nav-item">
                            <a class="d-flex align-items-center" href="{{ route('importpurchases.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-title text-truncate" data-i18n="user" data-toggle="tooltip" data-placement="top" data-original-title="Import Purchases">Import Purchases</span>
                            </a>
                        </li>
                    @endcan

                    @can('batches_management_modules')
                        <li class="@yield('batches_management_sidebar') nav-item">
                            <a class="d-flex align-items-center" href="{{ route('batches_management.index')}}">
                                <i data-feather='circle'></i>
                                <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Batches Management">Batches Management</span>
                            </a>
                        </li>
                    @endcan

                    @can('batches_payments_management_modules')
                        <li class="@yield('batches_payment_management_sidebar')  nav-item">
                            <a class="d-flex align-items-center" href="{{ route('batches_payment_management.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Batch Payments">Batch Payments</span>
                            </a>
                        </li>
                    @endcan


                    @canany(['manage-investors'])
                        <li  class="@yield('investor_sidebar')">
                            <a class="d-flex align-items-center" href="{{ route('investors.index') }}">
                                <i data-feather='circle'></i>
                                <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Investors">Investors</span>
                            </a>
                        </li>
                    @endcanany

                    @can('loan_payments_management_modules')
                        <li class="@yield('loan_payment_management_sidebar')  nav-item">
                            <a class="d-flex align-items-center" href="{{ route('loan_payment_management.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Loan Payments">Investor Payments</span>
                            </a>
                        </li>
                    @endcan


                    @can('salaries-management')
                        <li class="nav-item @yield('hr_salary_sidebar')">
                            <a class="d-flex align-items-center" href="{{ route('salary_management.index')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Salaries">Salaries</span>
                            </a>
                    @endcan

                    @can('advance-hr-payments')
                        <li class="nav-item @yield('hr_advance_payment_sidebar')">
                            <a class="d-flex align-items-center" href="{{ route('advancehrpayment.index')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Advance HR Payments">Advance HR Payments</span>
                            </a>
                    @endcan


                    @can('tax_bodies_modules')
                    <li class="@yield('tax_bodies_modules_sidebar') nav-item">
                        <a class="d-flex align-items-center" href="{{ route('tax_bodies.index')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="role"  data-toggle="tooltip" data-placement="top" data-original-title="Tax Bodies Management">Tax Bodies Management</span>
                        </a>
                    </li>
                    @endcan
                    @can('sales_tax_return_management')
                    <li class="@yield('sales_tax_return_management_sidebar') nav-item">
                        <a class="d-flex align-items-center" href="{{ route('sales_tax_return_management.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Sales Tax Returns Management">Sales Tax Returns Management</span>
                        </a>
                    </li>
                    @endcan
                    @can('supplier_tax_payments_management')
                    <li class="@yield('supplier_tax_modules_sidebar') nav-item">
                        <a class="d-flex align-items-center" href="{{ route('suppliertaxpayment.index') }}">
                            <i data-feather="circle"></i> 
                            <span class="menu-title text-truncate" data-i18n="users" data-toggle="tooltip" data-placement="top" data-original-title="Supplier Tax Payments Management">Supplier Tax Payments Management</span>
                        </a>
                    </li>
                    @endcan

                    @can('employees_tax_management')
                    <li class="@yield('employees_tax_modules_sidebar') nav-item">
                        <a class="d-flex align-items-center" href="{{ route('employees_tax_management.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="users" data-toggle="tooltip" data-placement="top" data-original-title="Employee Tax Management" >Employees Tax Management</span>
                        </a>
                    </li>
                    @endcan


                    @can('damcon_assets_modules')
                        <li class="@yield('damconassets_sidebar') nav-item">
                            <a class="d-flex align-items-center" href="{{ route('damconassets.index')}}">
                                <i data-feather='circle'></i>
                                <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Assets Management">Damcon Assets Management</span>
                            </a>
                        </li>
                    @endcan


                    @can('assets_purchase_order')
                        <li class="@yield('assetspos_sidebar')  nav-item">
                            <a class="d-flex align-items-center" href="{{ route('assetspos.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Assets PO Management">Assets PO Management</span>
                            </a>
                        </li>
                    @endcan


                    @can('damcon_assets_depreciation_modules')
                        <li class="@yield('damconassetsdepreciation_sidebar')  nav-item">
                            <a class="d-flex align-items-center" href="{{ route('damconassetsdepreciation.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Damcon Asset Depreciation">Damcon Asset Depreciation</span>
                            </a>
                        </li>
                    @endcan


                    
                    @can('damcon_assets_sales_modules')
                        <li class="@yield('damconassetsales_sidebar')  nav-item">
                            <a class="d-flex align-items-center" href="{{ route('damconassetsales.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Damcon Asset Sales">Damcon Asset Sales</span>
                            </a>
                        </li>
                    @endcan


                    
                </ul>
            </li>
            @endcanany --}}


            {{-- Finance Management end--}}


            {{-- Project Management --}}
            {{-- @canany(['manage-project-item-inventory','manage-maintenance-item-inventory','manage-fuel'])
                <li class="nav-item"><a class="d-flex align-items-center" href="#"><i data-feather='folder'></i><span class="menu-title text-truncate" data-i18n="Stakeholders">Project Management</span></a>
                    <ul class="menu-content">

                        @can(['manage-project-item-inventory'])
                        <ul class="menu-content">
                            <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Second Level" data-toggle="tooltip" data-placement="top" data-original-title="Project Items Inventory">Project Items Inventory</span></a>
                                <ul class="menu-content">
                                    <li class="@yield('porject_item_sidebar') nav-item">
                                        <a class="d-flex align-items-center" href="{{ route('projectitems.index') }}">
                                            <i data-feather="circle"></i>
                                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Items Inventory">Item Inventory</span>
                                        </a>
                                    </li>
                                    <li class="@yield('project_issuance_sidebar') nav-item">
                                        <a class="d-flex align-items-center" href="{{ route('projectitemsissuance.index') }}">
                                            <i data-feather="circle"></i>
                                            <span class="menu-title text-truncate" data-i18n="projectitemsissuance" data-toggle="tooltip" data-placement="top" data-original-title="Project Item Issuance">Project Item Issuance</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        @endcan

                        @can(['manage-maintenance-item-inventory'])
                        <ul class="menu-content">
                            <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Second Level" data-toggle="tooltip" data-placement="top" data-original-title="Maintenance Items Inventory">Maintenance Items Inventory</span></a>
                                <ul class="menu-content">
                                    <li class="@yield('maintenanace_item_sidebar') nav-item"><a class="d-flex align-items-center" href="{{ route('maintenanaceiteminventory.index') }}"><i data-feather="circle"></i><span class="menu-title text-truncate" data-i18n="Permission"  data-toggle="tooltip" data-placement="top" data-original-title="Maintenance Item Inventory">Maintenance Item Inventory</span></a>
                                    </li>

                                    <li class="@yield('maintenanace_consumption_sidebar') nav-item"><a class="d-flex align-items-center" href="{{ route('maintenanaceitemconsumption.index') }}"><i data-feather="circle"></i><span class="menu-title text-truncate" data-i18n="Permission"  data-toggle="tooltip" data-placement="top" data-original-title="Maintenance Item Consumption">Maintenance Item Consumption</span></a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        @endcan


                        @can('manage-fuel')
                        <li class="@yield('fuel_sidebar') nav-item">
                            <a class="d-flex align-items-center" href="{{ route('fuelitem.index') }}">
                                <i data-feather="circle"></i><span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Fuel Items">Fuel Items</span>
                            </a>
                        </li>
                        @endcan

                    </ul>
                </li>
            @endcanany --}}
           


            {{-- Project Management end--}}


            {{-- HR Management --}}
{{-- 
            @canany(['manage_hr_management','salaries-management','interprojecttransfer-management','increment-management',
            'damcon_assets_hoto_modules'])
            <li class="nav-item"><a class="d-flex align-items-center" href="#"><i data-feather='users'></i><span class="menu-title text-truncate" data-i18n="Invoice">HR Management</span></a>
                <ul class="menu-content">

                    @can('manage_hr_management')
                        <li class="nav-item @yield('hr_categories_sidebar')">
                            <a class="d-flex align-items-center" href="{{ route('hrcategories.index')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Hr Categories">Hr Categories</span>
                            </a>
                    @endcan

                    @can('manage_hr_management')
                        <li class="nav-item @yield('hr_employee_sidebar')">
                            <a class="d-flex align-items-center" href="{{ route('employees')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Employees">Employees</span>
                            </a>
                        </li>
                    @endcan

                    @can('salaries-management')
                        <li class="nav-item @yield('hr_salary_sidebar')">
                            <a class="d-flex align-items-center" href="{{ route('salary_management.index')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Salaries">Salaries</span>
                            </a>
                    @endcan

                    @can('interprojecttransfer-management')
                        <li class="nav-item @yield('hr_interproject_sidebar')">
                            <a class="d-flex align-items-center" href="{{ route('interproject-management.index')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="InterProject Management">InterProject Management</span>
                            </a>
                    @endcan

                    @can('increment-management')
                        <li class="nav-item @yield('hr_increment_sidebar')">
                            <a class="d-flex align-items-center" href="{{ route('increment-management.index')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Increment Management">Increment Management</span>
                            </a>
                    @endcan
                    
                    @can('employee-exits-management')
                        <li class="nav-item @yield('hr_employee-exits-sidebar')">
                            <a class="d-flex align-items-center" href="{{ route('employeeExitManagement.index')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Employees Exits Management">Employees Exits Management</span>
                            </a>
                    @endcan

                    @can('leaves-management')
                        <li class="nav-item @yield('hr_leaves_sidebar')">
                            <a class="d-flex align-items-center" href="{{ route('leave-management.index')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Leaves Management">Leaves Management</span>
                            </a>
                    @endcan

                    @can('damcon_assets_hoto_modules')
                        <li class="@yield('damconhoto_sidebar')  nav-item">
                            <a class="d-flex align-items-center" href="{{ route('damconhoto.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Damcon HOTO">Damcon HOTO</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            @endcanany --}}


            {{-- HR management end --}}

            {{-- ___________________________________________________________OLD SIDEBAR___________________________________________________ --}}
            {{-- <p class="text-center"><b>New bar</b></p> --}}
            @can('manage-configurations')
            <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('configurations.index') }}"><i class="fa fa-cogs" aria-hidden="true"></i>
                <span class="menu-title text-truncate" data-i18n="user">Configurations</span></a>
            </li>
            @endcan



            @can('manage-projects')
            <li class="@yield('project_siderbar') nav-item"><a class="d-flex align-items-center" href="{{ route('projectmanagement.index') }}"><i class="fa fa-cube" aria-hidden="true"></i>
                <span class="menu-title text-truncate" data-i18n="user" data-toggle="tooltip" data-placement="top" data-original-title="Projects Management">Projects Management</span></a>
            </li>
            @endcan

            {{-- @canany(['manage-customers','manage-investors','manage-suppliers'])
            <li class="nav-item"><a class="d-flex align-items-center" href="#"><i class="fa fa-users" aria-hidden="true"></i></i><span class="menu-title text-truncate" data-i18n="Stakeholders">Stakeholders</span></a>
                <ul class="menu-content">
                    @canany(['manage-customers'])
                    <li class="@yield('customer_sidebar') nav-item"><a class="d-flex align-items-center" href="{{ route('customers.index') }}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                        <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Customers">Customers</span></a>
                    </li>
                    @endcanany
                    @canany(['manage-investors'])
                    <li  class="@yield('investor_sidebar')"><a class="d-flex align-items-center" href="{{ route('investors.index') }}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                        <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Investors">Investors</span></a>
                    </li>
                    @endcanany

                    @can('manage-suppliers')
                    <li class="@yield('supplier_sidebar') nav-item"><a class="d-flex align-items-center" href="{{ route('suppliers.index') }}">
                        <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                        <span class="menu-title text-truncate" data-i18n="user" data-toggle="tooltip" data-placement="top" data-original-title="Suppliers">Suppliers</span></a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany --}}

            
            {{-- customer management --}}
            
            @canany(['security_payments_management_modules','manage-customers','manage-projects','customer_purchase_order','invoice_income_management','uninvoiced-receiveables','security-bid-bond-returns'])
            <li class="nav-item"><a class="d-flex align-items-center" href="#"><i class="fa fa-user-circle" aria-hidden="true"></i>
                <span class="menu-title text-truncate" data-i18n="Stakeholders">Customer Management</span></a>
                <ul class="menu-content">
                    @can('manage-customers')
                    <li class="@yield('customer_sidebar') nav-item">
                        <a class="d-flex align-items-center" href="{{ route('customers.index') }}">
                            <i data-feather='circle'></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Customers">Customers</span>
                        </a>
                    </li>
                    @endcanany

                    @can('manage-projects')
                    <li class="@yield('project_siderbar') nav-item">
                        <a class="d-flex align-items-center" href="{{ route('projectmanagement.index') }}">
                            <i data-feather='circle'></i>
                            <span class="menu-title text-truncate" data-i18n="user" data-toggle="tooltip" data-placement="top" data-original-title="Projects Management">Projects Management</span>
                        </a>
                    </li>
                    @endcan


                    @can('customer_purchase_order')
                        <li class="@yield('customerpos_sidebar') nav-item">
                            <a class="d-flex align-items-center" href="{{ route('customerpos.index')}}">
                                <i data-feather='circle'></i>
                                <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Customer PO Management">Customer PO Management</span>
                            </a>
                        </li>
                    @endcan

                    @can('invoice_income_management')
                        <li class="nav-item @yield('customer_invoice_sidebar')">
                            <a class="d-flex align-items-center" href="{{ route('customerinvoice.index')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Customer Invoice Management">Customer Invoice Management</span>
                            </a>
                        </li>
                    @endcan


                    @can('uninvoiced-receiveables')
                    <li class="nav-item @yield('uninvoiced-receiveables-sidebar')">
                        <a class="d-flex align-items-center" href="{{ route('uninvoicedreceivables.index')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="UnInvoiced Receiveables">UnInvoiced Receiveables</span>
                        </a>
                    @endcan

                    @can('project_income_management')
                    <li class="nav-item @yield('project_income_sidebar')">
                        <a class="d-flex align-items-center" href="{{ route('projectincome.index')}}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Project Income Management">Project Income Management</span></a>
                    @endcan

                    @can('misc-income-management')
                    <li class="nav-item @yield('misc_income_sidebar')"><a class="d-flex align-items-center" href="{{ route('miscincome.index')}}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Misc. Income Management">Misc. Income Management</span></a>
                    @endcan

                    @can('security-bid-bond-returns')
                        <li class="nav-item @yield('security_bid_sidebar')"><a class="d-flex align-items-center" href="{{ route('securitybondreturns.index')}}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Security / Bid Bond Returns">Security / Bid Bond Returns</span></a>
                    @endcan


                   @can('security_payments_management_modules')
                    <li class="@yield('security_payment_management_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('security_payment_management.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Security/Bid Bond Payments">Security/Bid Bond Payments</span>
                        </a>
                    </li>
                    @endcan
                   

                    {{-- <li class="nav-item">
                        <a class="d-flex align-items-center" href="#">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="View Customer Assets Inventory Report">View Customer Assets Inventory Report</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="d-flex align-items-center" href="#">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="View customer Assets inventory items Report">View customer Assets inventory items Report</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="d-flex align-items-center" href="#">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="View customer Consumables inventory items Report">View customer Consumables inventory items Report</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="d-flex align-items-center" href="#">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="All customer related reports">All customer related reports</span>
                        </a>
                    </li> --}}

                  
                </ul>
            </li>
            @endcanany

            {{-- customer management end--}}


            
            {{-- supplier management --}}

            @canany(['manage-suppliers','supplier_purchase_order','manage-rental-items','rental_purchase_order','assets_purchase_order','supplier_payments_management_modules','project_payments'])
            <li class="nav-item"><a class="d-flex align-items-center" href="#">
                <i class="fa fa-shield" aria-hidden="true"></i>               
                <span class="menu-title text-truncate" data-i18n="Stakeholders">Supplier Management</span></a>
                <ul class="menu-content">

                    {{-- <li class="nav-item">
                        <a class="d-flex align-items-center" href="#">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="All customer related reports">Supplier types</span>
                        </a>
                    </li> --}}

                    @can('manage-suppliers')
                    <li class="@yield('supplier_sidebar') nav-item"><a class="d-flex align-items-center" href="{{ route('suppliers.index') }}">
                        <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                        <span class="menu-title text-truncate" data-i18n="user" data-toggle="tooltip" data-placement="top" data-original-title="Suppliers">Suppliers</span></a>
                    </li>
                    @endcan

                    @can('supplier_purchase_order')
                    <li class="@yield('supplierpos_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('supplierspos.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Suppliers PO Management">Suppliers PO Management</span>
                        </a>
                    </li>
                    @endcan

                    @canany(['manage-rental-items'])
                    <li class="@yield('rental_sidebar') nav-item" >
                        <a class="d-flex align-items-center" href="{{ route('rentalitem.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>                           
                            <span class="menu-title text-truncate" data-i18n="Invoice" data-toggle="tooltip" data-placement="top" data-original-title="Rental Items Management">Rental Items Management</span></a>
                    </li>
                    @endcanany


                    @can('rental_purchase_order')
                    <li class="@yield('rentalpos_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('rentalpos.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Rental PO Management">Rental PO Management</span>
                        </a>
                    </li>
                    @endcan


                    @can('assets_purchase_order')
                    <li class="@yield('assetspos_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('assetspos.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Assets PO Management">Assets PO Management</span>
                        </a>
                    </li>
                    @endcan


                    @can('services_purchase_order')
                    <li class="@yield('servicespos_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('servicespos.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Maintenance Items & Services PO Management">Maintenance Items & Services PO Management</span>
                        </a>
                    </li>
                    @endcan


                    @can('supplier_payments_management_modules')
                    <li class="@yield('supplier_payment_management_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('supplier_payment_management.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Supplier Payments">Supplier Payments</span>
                        </a>
                    </li>
                    @endcan

                    @can('project_payments')
                    <li class="@yield('project_payment_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('project_payment.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Project Payments">Project Payments</span>
                        </a>
                    </li>
                    @endcan



                </ul>
            </li> 
            @endcanany

            {{-- supplier management end--}}


            {{-- Invester management --}}

            @canany(['manage-investors','principle_investment_management','loan_payments_management_modules','director_withdraws'])
            <li class="nav-item"><a class="d-flex align-items-center" href="#"><i class="fa fa-gift" aria-hidden="true"></i>
                <span class="menu-title text-truncate" data-i18n="Invoice">Investor Managment</span></a>
                <ul class="menu-content">
                    @canany(['manage-investors'])
                    <li  class="@yield('investor_sidebar')"><a class="d-flex align-items-center" href="{{ route('investors.index') }}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                        <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Investors">Investors</span></a>
                    </li>
                    @endcanany


                    @can('loan_payments_management_modules')
                    <li class="@yield('loan_payment_management_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('loan_payment_management.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Investor Principal Payments">Investor Principal Payments</span>
                        </a>
                    </li>
                    @endcan


                    @can('principle_investment_management')
                    <li class="nav-item @yield('principal_investment_sidebar')"><a class="d-flex align-items-center" href="{{ route('principalinvestment.index')}}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Profit on Investment">Profit on Investment</span></a>
                    @endcan


                    @can('director_withdraws')
                    <li class="@yield('director_sidebar') nav-item"><a class="d-flex align-items-center" href="{{ route('directorwithdraw.index')}}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Director Withdraws">Director Withdraws</span></a>
                    @endcan
                   

                  
                </ul>
            </li>
            @endcanany

            {{-- Investor management --}}


            @canany(['manage-banks','manage-interbank-transfer','manage-import-purchases'])
            <li class="nav-item"><a class="d-flex align-items-center" href="#"><i class="fa fa-university" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Invoice">Banks Managment</span></a>
                <ul class="menu-content">
                    @can(['manage-banks'])
                    <li class="@yield('bank_sidebar') nav-item">
                        <a class="d-flex align-items-center" href="{{ route('bankaccounts.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>                            
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Bank Accounts">Bank Accounts</span>
                        </a>
                    </li>
                    @endcan
                    @can(['manage-interbank-transfer'])
                    <li class="@yield('interbank_sidebar') nav-item">
                        <a class="d-flex align-items-center" href="{{ route('interbanktransfer.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>                            
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Inter-Bank Transfer">Inter-Bank Transfer</span>
                        </a>
                    </li>
                    @endcan

                    @can('manage-import-purchases')
                    <li class="@yield('import_sidebar') nav-item">
                        <a class="d-flex align-items-center" href="{{ route('importpurchases.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="user" data-toggle="tooltip" data-placement="top" data-original-title="Import Purchases">Import Purchases</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @canany(['manage-categories','manage-project-item-inventory','manage-categories'])
            <li class="nav-item"><a class="d-flex align-items-center" href="#"><i class="fa fa-database" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Invoice">Inventory Managment</span></a>
                <ul class="menu-content">
                    {{-- @can(['manage-categories'])
                        <li class="@yield('category_sidebar') nav-item"><a class="d-flex align-items-center" href="{{ route('categories.index') }}"><i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Categories">Categories</span></a>
                        </li>
                    @endcan --}}

                    @can(['manage-categories'])
                 

                        <ul class="menu-content">
                            <li>
                                {{-- <a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Second Level" data-toggle="tooltip" data-placement="top" data-original-title="Project Items Inventory">Project Items Inventory</span></a> --}}

                                <a class="d-flex align-items-center" href="#"><i class="fa fa-list" aria-hidden="true"></i><span class="menu-item text-truncate" data-i18n="Second Level" data-toggle="tooltip" data-placement="top" data-original-title="Project Items Categories">Item Categories</span></a>
                                <ul class="menu-content">
                                    <li class="@yield('inventorycategory_sidebar_parent') nav-item">
                                        <a class="d-flex align-items-center" href="{{ route('itemscategories.index') }}/?category_level=parent-category&module_name=project_item">
                                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Inventory Catgories">Catgories</span></a>
                                    </li>
                                    <li class="@yield('inventorycategory_sidebar_child') nav-item"><a class="d-flex align-items-center" href="{{ route('itemscategories.index') }}/?category_level=sub-category&module_name=project_item"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="projectitemsissuance" data-toggle="tooltip" data-placement="top" data-original-title="Inventory Sub Sub Catgories">Sub Catgories</span></a>
                                    </li>
                                    
                                </ul>
                            </li>
                        </ul>

                    @endcan


                
                    @can(['manage-project-item-inventory'])
                    <ul class="menu-content">
                        <li>
                            <a class="d-flex align-items-center" href="#"><i class="fa fa-inbox" aria-hidden="true"></i><span class="menu-item text-truncate" data-i18n="Second Level" data-toggle="tooltip" data-placement="top" data-original-title="Project Items Inventory">Project Items Inventory</span></a>
                            <ul class="menu-content">
                                <li class="@yield('porject_item_sidebar') nav-item"><a class="d-flex align-items-center" href="{{ route('projectitems.index') }}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Items Inventory">Item Inventory</span></a>
                                </li>
                                <li class="@yield('project_issuance_sidebar') nav-item"><a class="d-flex align-items-center" href="{{ route('projectitemsissuance.index') }}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="projectitemsissuance" data-toggle="tooltip" data-placement="top" data-original-title="Project Item Issuance">Project Item Issuance</span></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    @endcan

                    @can(['manage-maintenance-item-inventory'])

                    <ul class="menu-content">

                        <li><a class="d-flex align-items-center" href="#"><i class="fa fa-plug" aria-hidden="true"></i><span class="menu-item text-truncate" data-i18n="Second Level" data-toggle="tooltip" data-placement="top" data-original-title="Maintenance Items Inventory">Maintenance Items Inventory</span></a>
                            <ul class="menu-content">
                                <li class="@yield('maintenanace_item_sidebar') nav-item"><a class="d-flex align-items-center" href="{{ route('maintenanaceiteminventory.index') }}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Permission"  data-toggle="tooltip" data-placement="top" data-original-title="Maintenance Item Inventory">Maintenance Item Inventory</span></a>
                                </li>

                                <li class="@yield('maintenanace_consumption_sidebar') nav-item"><a class="d-flex align-items-center" href="{{ route('maintenanaceitemconsumption.index') }}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Permission"  data-toggle="tooltip" data-placement="top" data-original-title="Maintenance Item Consumption">Maintenance Item Consumption</span></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    @endcan


                    @can(['manage-categories'])
                        <ul class="menu-content">
                            <li>
                                {{-- <a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Second Level" data-toggle="tooltip" data-placement="top" data-original-title="Project Items Inventory">Project Items Inventory</span></a> --}}
            
                                <a class="d-flex align-items-center" href="#"><i class="fa fa-list" aria-hidden="true"></i><span class="menu-item text-truncate" data-i18n="Second Level" data-toggle="tooltip" data-placement="top" data-original-title="Maintenance Items Categories">Maintenance Categories</span></a>
                                <ul class="menu-content">
                                    <li class="@yield('maintenanacecategory_sidebar_parent') nav-item"><a class="d-flex align-items-center" href="{{ route('itemscategories.index') }}/?category_level=parent-category&module_name=maintenance_item"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate"  data-toggle="tooltip" data-placement="top" data-original-title="Maintenanace Item Catgories">Catgories</span></a>
                                    </li>
                                    <li class="@yield('maintenanacecategory_sidebar_child') nav-item"><a class="d-flex align-items-center" href="{{ route('itemscategories.index') }}/?category_level=sub-category&module_name=maintenance_item"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate"  data-toggle="tooltip" data-placement="top" data-original-title="Maintenanace Sub Catgories">Sub Catgories</span></a>
                                    </li>
                                    
                                </ul>
                            </li>
                        </ul>
                    @endcan
                </ul>
            </li>
            @endcanany



             @can(['manage-categories'])
             <li class="nav-item"><a class="d-flex align-items-center" href="#"><i class="fa fa-server" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Invoice">Categories</span></a>
                <ul class="menu-content">      
                    <li class="@yield('category_sidebar') nav-item"><a class="d-flex align-items-center" href="{{ route('categories.index') }}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Categories">Categories</span></a>
                    </li>
                </ul>
             </li>
            @endcan




            @canany(['manage-fuel','manage-fuel-item-consumption'])

                    <li class="nav-item"><a class="d-flex align-items-center" href="#"><i class="fa fa-car" aria-hidden="true"></i></i><span class="menu-title text-truncate" data-i18n="Invoice">Fuel Managment</span></a>
                        <ul class="menu-content">
                            @can('manage-fuel')
                                <li class="@yield('fuel_sidebar') nav-item"><a class="d-flex align-items-center" href="{{ route('fuelitem.index') }}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Fuel Items">Fuel Items</span></a>
                                </li>
                            @endcan
                            @can('manage-fuel-item-consumption')
                                <li class="@yield('fuel_consumption_sidebar') nav-item"><a class="d-flex align-items-center" href="{{ route('fuelconsumption.index') }}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Fuel Consumption">Fuel Consumption</span></a>
                                </li>
                            @endcan
                        </ul>
                    </li>



            @endcanany


            {{-- @canany(['manage-rental-items'])
            <li class="@yield('rental_sidebar') nav-item" >
                <a class="d-flex align-items-center" href="{{ route('rentalitem.index') }}">
                    <i class="fa fa-truck" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Invoice" data-toggle="tooltip" data-placement="top" data-original-title="Rental Items Management">Rental Items Management</span></a>
            </li>
            @endcanany --}}





            {{-- @canany(['customer_purchase_order','supplier_purchase_order','rental_purchase_order','assets_purchase_order','services_purchase_order'])
            <li class="nav-item"><a class="d-flex align-items-center" href="#"><i class="fa fa-cart-plus" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Invoice"  data-toggle="tooltip" data-placement="top" data-original-title="Purchase Orders Management">Purchase Orders Management</span></a>
                <ul class="menu-content">
                    @can('customer_purchase_order')
                    <li class="@yield('customerpos_sidebar') nav-item">
                        <a class="d-flex align-items-center" href="{{ route('customerpos.index')}}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Customer PO Management">Customer PO Management</span>
                        </a>
                    @endcan
                    @can('supplier_purchase_order')
                    <li class="@yield('supplierpos_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('supplierspos.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Suppliers PO Management">Suppliers PO Management</span>
                        </a>
                    </li>
                    @endcan

                    @can('rental_purchase_order')
                        <li class="@yield('rentalpos_sidebar')  nav-item">
                            <a class="d-flex align-items-center" href="{{ route('rentalpos.index') }}">
                                <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                                <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Rental PO Management">Rental PO Management</span>
                            </a>
                        </li>
                    @endcan

                    @can('assets_purchase_order')
                    <li class="@yield('assetspos_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('assetspos.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Assets PO Management">Assets PO Management</span>
                        </a>
                    </li>
                    @endcan

                    @can('services_purchase_order')
                    <li class="@yield('servicespos_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('servicespos.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Maintenance Items & Services PO Management">Maintenance Items & Services PO Management</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany --}}


            @canany(['damcon_assets_modules','customer_assets_modules','damcon_assets_sales_modules','damcon_assets_depreciation_modules','damcon_assets_hoto_modules'])
            <li class="nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i class="fa fa-briefcase" aria-hidden="true"></i>
                    <span class="menu-title text-truncate" data-i18n="Invoice" data-toggle="tooltip" data-placement="top" data-original-title="Assets Management">Assets Management</span>
                </a>
                <ul class="menu-content">
                    @can('damcon_assets_modules')
                    <li class="@yield('damconassets_sidebar') nav-item">
                        <a class="d-flex align-items-center" href="{{ route('damconassets.index')}}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Assets Management">Damcon Assets Management</span>
                        </a>
                    @endcan
                    @can('customer_assets_modules')
                    <li class="@yield('customerassets_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('customerassets.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Customer Assets Management">Customer Assets Management</span>
                        </a>
                    </li>
                    @endcan

                    @can('damcon_assets_depreciation_modules')
                        <li class="@yield('damconassetsdepreciation_sidebar')  nav-item">
                            <a class="d-flex align-items-center" href="{{ route('damconassetsdepreciation.index') }}">
                                <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                                <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Damcon Asset Depreciation">Damcon Asset Depreciation</span>
                            </a>
                        </li>
                    @endcan

                    

                    @can('damcon_assets_sales_modules')
                    <li class="@yield('damconassetsales_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('damconassetsales.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Damcon Asset Sales">Damcon Asset Sales</span>
                        </a>
                    </li>
                    @endcan

                   @can('damcon_assets_hoto_modules')
                    <li class="@yield('damconhoto_sidebar')  nav-item">
                            <a class="d-flex align-items-center" href="{{ route('damconhoto.index') }}">
                                <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                                <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Damcon HOTO">Damcon HOTO</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            @endcanany


            @canany(['batches_management_modules','batches_payments_management_modules','bank_payments_management_modules','supplier_payments_management_modules','security_payments_management_modules','loan_payments_management_modules','project_payments'])
            <li class="nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i class="fa fa-credit-card" aria-hidden="true"></i>
                    <span class="menu-title text-truncate" data-i18n="Invoice">Payments Management</span>
                </a>
                <ul class="menu-content">
                    @can('batches_management_modules')
                    <li class="@yield('batches_management_sidebar') nav-item">
                        <a class="d-flex align-items-center" href="{{ route('batches_management.index')}}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Batches Management">Batches Management</span>
                        </a>
                    @endcan

                    @can('batches_payments_management_modules')
                    <li class="@yield('batches_payment_management_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('batches_payment_management.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Batch Payments">Batch Payments</span>
                        </a>
                    </li>
                    @endcan

                    @can('bank_payments_management_modules')
                        <li class="@yield('bank_payment_management_sidebar')  nav-item">
                            <a class="d-flex align-items-center" href="{{ route('bank_payment_management.index') }}">
                                <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                                <span class="menu-title text-truncate" data-i18n="Permission"data-toggle="tooltip" data-placement="top" data-original-title="Bank Payments">Bank Payments</span>
                            </a>
                        </li>
                    @endcan

                    {{-- @can('supplier_payments_management_modules')
                    <li class="@yield('supplier_payment_management_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('supplier_payment_management.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Supplier Payments">Supplier Payments</span>
                        </a>
                    </li>
                    @endcan --}}

                    {{-- @can('security_payments_management_modules')
                    <li class="@yield('security_payment_management_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('security_payment_management.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Security/Bid Bond Payments">Security/Bid Bond Payments</span>
                        </a>
                    </li>
                    @endcan --}}

                    {{-- @can('loan_payments_management_modules')
                    <li class="@yield('loan_payment_management_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('loan_payment_management.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Loan Payments">Investor Payments</span>
                        </a>
                    </li>
                    @endcan --}}


                    {{-- project payments --}}
                    {{-- @can('project_payments')
                    <li class="@yield('project_payment_sidebar')  nav-item">
                        <a class="d-flex align-items-center" href="{{ route('project_payment.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Project Payments">Project Payments</span>
                        </a>
                    </li>
                    @endcan --}}
                </ul>
            </li>
            @endcanany


            {{-- @canany(['invoice_income_management','uninvoiced-receiveables','project_income_management','misc-income-management','principle_investment_management','security-bid-bond-returns'])
            <li class="nav-item"><a class="d-flex align-items-center" href="#"><i class="fa fa-line-chart" aria-hidden="true"></i></i><span class="menu-title text-truncate" data-i18n="Invoice">Invoicing & Income Management</span></a>
                <ul class="menu-content">
                    
                    @can('invoice_income_management')
                    <li class="nav-item @yield('customer_invoice_sidebar')"><a class="d-flex align-items-center" href="{{ route('customerinvoice.index')}}">
                        <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                        <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Customer Invoice Management">Customer Invoice Management</span></a>
                    @endcan

                    @can('uninvoiced-receiveables')
                    <li class="nav-item @yield('uninvoiced-receiveables-sidebar')">
                        <a class="d-flex align-items-center" href="{{ route('uninvoicedreceivables.index')}}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="UnInvoiced Receiveables">UnInvoiced Receiveables</span></a>
                    @endcan

                    @can('project_income_management')
                    <li class="nav-item @yield('project_income_sidebar')">
                        <a class="d-flex align-items-center" href="{{ route('projectincome.index')}}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Project Income Management">Project Income Management</span></a>
                    @endcan

                    @can('misc-income-management')
                    <li class="nav-item @yield('misc_income_sidebar')"><a class="d-flex align-items-center" href="{{ route('miscincome.index')}}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Misc. Income Management">Misc. Income Management</span></a>
                    @endcan

                    @can('principle_investment_management')
                    <li class="nav-item @yield('principal_investment_sidebar')"><a class="d-flex align-items-center" href="{{ route('principalinvestment.index')}}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Principal Investments Management">Principal Investments Management</span></a>
                    @endcan

                    @can('security-bid-bond-returns')
                        <li class="nav-item @yield('security_bid_sidebar')"><a class="d-flex align-items-center" href="{{ route('securitybondreturns.index')}}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Security / Bid Bond Returns">Security / Bid Bond Returns</span></a>
                    @endcan
                    
                </ul>
            </li>      
            @endcanany --}}

           
           
           
           
            @canany(['manage_hr_management'])
            <li class="nav-item"><a class="d-flex align-items-center" href="#"><i class="fa fa-building-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Invoice">HR Management</span></a>
                <ul class="menu-content">
                    @can('manage_hr_management')
                    <li class="nav-item @yield('hr_categories_sidebar')"><a class="d-flex align-items-center" href="{{ route('hrcategories.index')}}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Hr Categories">Hr Categories</span></a>
                    @endcan
                    @can('manage_hr_management')
                    <li class="nav-item @yield('hr_employee_sidebar')"><a class="d-flex align-items-center" href="{{ route('employees')}}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Employees">Employees</span></a></li>
                    @endcan

                    @can('salaries-management')
                    <li class="nav-item @yield('hr_salary_sidebar')"><a class="d-flex align-items-center" href="{{ route('salary_management.index')}}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Salaries">Salaries</span></a>
                    @endcan


                    @can('interprojecttransfer-management')
                    <li class="nav-item @yield('hr_interproject_sidebar')"><a class="d-flex align-items-center" href="{{ route('interproject-management.index')}}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="InterProject Management">InterProject Management</span></a>
                    @endcan


                    @can('increment-management')
                    <li class="nav-item @yield('hr_increment_sidebar')"><a class="d-flex align-items-center" href="{{ route('increment-management.index')}}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Increment Management">Increment Management</span></a>
                    @endcan

                    @can('leaves-management')
                    <li class="nav-item @yield('hr_leaves_sidebar')"><a class="d-flex align-items-center" href="{{ route('leave-management.index')}}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Leaves Management">Leaves Management</span></a>
                    @endcan

                    @can('advance-hr-payments')
                    <li class="nav-item @yield('hr_advance_payment_sidebar')"><a class="d-flex align-items-center" href="{{ route('advancehrpayment.index')}}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Advance HR Payments">Advance HR Payments</span></a>

                    @endcan
                    
                    @can('employee-exits-management')
                    <li class="nav-item @yield('hr_employee-exits-sidebar')"><a class="d-flex align-items-center" href="{{ route('employeeExitManagement.index')}}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Employees Exits Management">Employees Exits Management</span></a>
                    @endcan


                    @can('qualityhealthsafety')
                    <li class="nav-item @yield('hr_qualityhealthsafety-sidebar')"><a class="d-flex align-items-center" href="{{ route('qualityhealthSafety.index')}}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Quality Health Safety Event">Quality Health Safety Event</span></a>
                    @endcan

                    
                    @can('employee_traffic_challans')
                    <li class="nav-item @yield('hr_emptrafficchalan-sidebar')"><a class="d-flex align-items-center" href="{{ route('employeechallan.index')}}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Employee Traffic Chalan">Employee Traffic Chalan</span></a>
                    @endcan

                </ul>
            </li>
            @endcanany



            @canany(['tax_bodies_modules','manage-permissions','supplier_tax_payments_management','employees_tax_management'])
            <li class="nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i class="fa fa-braille" aria-hidden="true"></i>
                    <span class="menu-title text-truncate" data-i18n="Invoice">Taxation Management</span>
                </a>

                <ul class="menu-content">
                    @can('tax_bodies_modules')
                    <li class="@yield('tax_bodies_modules_sidebar') nav-item">
                        <a class="d-flex align-items-center" href="{{ route('tax_bodies.index')}}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="role"  data-toggle="tooltip" data-placement="top" data-original-title="Tax Bodies Management">Tax Bodies Management</span>
                        </a>
                    </li>
                    @endcan
                    @can('sales_tax_return_management')
                    <li class="@yield('sales_tax_return_management_sidebar') nav-item">
                        <a class="d-flex align-items-center" href="{{ route('sales_tax_return_management.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="Permission" data-toggle="tooltip" data-placement="top" data-original-title="Sales Tax Returns Management">Sales Tax Returns Management</span>
                        </a>
                    </li>
                    @endcan
                    @can('supplier_tax_payments_management')
                    <li class="@yield('supplier_tax_modules_sidebar') nav-item">
                        <a class="d-flex align-items-center" href="{{ route('suppliertaxpayment.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="users" data-toggle="tooltip" data-placement="top" data-original-title="Supplier Tax Payments Management">Supplier Tax Payments Management</span>
                        </a>
                    </li>
                    @endcan
                    @can('employees_tax_management')
                    <li class="@yield('employees_tax_modules_sidebar') nav-item">
                        <a class="d-flex align-items-center" href="{{ route('employees_tax_management.index') }}">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <span class="menu-title text-truncate" data-i18n="users" data-toggle="tooltip" data-placement="top" data-original-title="Employee Tax Management" >Employees Tax Management</span>
                        </a>
                    </li>
                    @endcan
                    {{-- @can('manage-users')
                    <li class="nav-item">
                        <a class="d-flex align-items-center" href="{{ route('users.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="users">Employees Tax Payments Management</span>
                        </a>
                    </li>
                    @endcan --}}
                </ul>
            </li>
            @endcanany


            @canany(['director_withdraws','damcon-regions'])
            <li class="nav-item"><a class="d-flex align-items-center" href="#"><i class="fa fa-area-chart" aria-hidden="true"></i>
                <span class="menu-title text-truncate" data-i18n="Invoice">Damcon Management</span></a>
                <ul class="menu-content">
                    {{-- @can('director_withdraws')
                    <li class="@yield('director_sidebar') nav-item"><a class="d-flex align-items-center" href="{{ route('directorwithdraw.index')}}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Director Withdraws">Director Withdraws</span></a>
                    @endcan --}}

                    @can('damcon-regions')
                        <li class="@yield('regions_sidebar') nav-item"><a class="d-flex align-items-center" href="{{ route('regions.create')}}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="role" data-toggle="tooltip" data-placement="top" data-original-title="Regions">Regions</span></a>
                    @endcan
                </ul>
            </li>
            @endcanany




            @canany(['manage-roles','manage-permissions','manage-users'])
            <li class="nav-item"><a class="d-flex align-items-center" href="#"><i class="fa fa-user-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Invoice">Users Management</span></a>
                <ul class="menu-content">
                    @can('manage-roles')
                    <li class="@yield('role_sidebar') nav-item"><a class="d-flex align-items-center" href="{{ route('roles.index')}}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="role">Roles</span></a>
                    @endcan
                    @can('manage-permissions')
                    <li class="@yield('permission_sidebar') nav-item"><a class="d-flex align-items-center" href="{{ route('permissions.index') }}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Permission">Permission</span></a>
                    </li>
                    @endcan
                    @can('manage-users')
                    <li class="@yield('users_sidebar') nav-item"><a class="d-flex align-items-center" href="{{ route('users.index') }}"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="users">users</span></a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany


           



            {{-- <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Invoice">Invoice</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="app-invoice-list.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">List</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="app-invoice-preview.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">Preview</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="app-invoice-edit.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Edit">Edit</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="app-invoice-add.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Add">Add</span></a>
                    </li>
                </ul>
            </li> --}}










        </ul>
    </div>
</div>
<!-- END: Main Menu-->









