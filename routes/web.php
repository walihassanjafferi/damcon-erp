<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\PermissionController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ConfigurationController;

## stakeholder routes
use App\Http\Controllers\User\stakeholders\CustomerController;
use App\Http\Controllers\User\stakeholders\InvestorController;
use App\Http\Controllers\User\stakeholders\SupplierController;

## projectmanagment routes
use App\Http\Controllers\User\projectmanagement\ProjectManagementController;
## banks managment
use App\Http\Controllers\User\bankmanagement\BankAccountController;
use App\Http\Controllers\User\bankmanagement\InterBankTransferController;
use App\Http\Controllers\User\bankmanagement\ImportPurchasesController;

## inventory management
use App\Http\Controllers\User\inventorymanagement\CategoriesController;
use App\Http\Controllers\User\inventorymanagement\ProjectItemsController;
use App\Http\Controllers\User\inventorymanagement\ProjectItemsIssuanceController;
use App\Http\Controllers\User\inventorymanagement\MaintenanaceItemController;
use App\Http\Controllers\User\inventorymanagement\MaintenanaceConsumptionController;

## fuel management
use App\Http\Controllers\User\fuelmanagement\FuelitemController;
use App\Http\Controllers\User\fuelmanagement\FuelConsumptionController;


## Rental Item Controller
use App\Http\Controllers\User\rentalitemsmanagement\RentalItemsManagementController as RentalItemsManagement;
use App\Http\Controllers\User\customerposmanagement\CustomerPosManagementController as CustomerPosManagement;
use App\Http\Controllers\User\supplierposmanagement\SupplierPosManagementController as SupplierPosManagement;
use App\Http\Controllers\User\assetspurchaseordersmanagement\AssetsPurchaseOrdersManagementController as AssetsPosManagement;
use App\Http\Controllers\User\rentalpurchaseordersmanagement\RentalPurchaseOrdersManagementController as RentalPosManagement;
use App\Http\Controllers\User\servicespurchaseordersmanagement\ServicesPurchaseOrdersManagementController as ServicesPosManagement;


// Assets Management Module
use App\Http\Controllers\User\assetsmanagement\CustomerAssetsManagementController as CustomerAssetsManagement;
use App\Http\Controllers\User\assetsmanagement\DamconAssetDepreciationController as DamconAssetDepreciation;
use App\Http\Controllers\User\assetsmanagement\DamconAssetSalesController as DamconAssetSales;
use App\Http\Controllers\User\assetsmanagement\DamconAssetsManagementController as DamconAssetsManagement;
use App\Http\Controllers\User\assetsmanagement\DamconHotoController as DamconHoto;


//Payments Management Module
use App\Http\Controllers\User\paymentsmanagement\BatchesManagementController as  BatchesManagement;
use App\Http\Controllers\User\paymentsmanagement\BatchPaymentsManagementController as  BatchesPaymentManagement;
use App\Http\Controllers\User\paymentsmanagement\BankPaymentsController as  BankPaymentManagement;
use App\Http\Controllers\User\paymentsmanagement\SupplierPaymentsController as  SupplierPaymentManagement;
use App\Http\Controllers\User\paymentsmanagement\SecurityPaymentsController as  SecurityPaymentManagement;
use App\Http\Controllers\User\paymentsmanagement\LoanPaymentsController as  LoanPaymentManagement;
use App\Http\Controllers\User\paymentsmanagement\ProjectPaymentController as ProjectPayment;


//Taxation Management Module
use App\Http\Controllers\User\taxationmanagement\TaxBodiesController as TaxBodiesManagement;
use App\Http\Controllers\User\taxationmanagement\EmployeesTaxManagementController as EmployeesTaxManagement;
use App\Http\Controllers\User\taxationmanagement\SupplierTaxPaymentsManagementController as SupplierTaxPaymentsManagement;
use App\Http\Controllers\User\taxationmanagement\SalesTaxReturnManagementController as SalesTaxReturnManagement;
//HR MODULE

#HR categories
use App\Http\Controllers\User\hr\hrcategories\HrCategoriesController as HrCategories;
use App\Http\Controllers\User\hr\employeemanagement\EmployeeController;
use App\Http\Controllers\User\hr\salariesmanagement\SalariesManagementController;
use App\Http\Controllers\User\hr\interprojectmanagement\InterProjectManagement;
use App\Http\Controllers\User\hr\incrementmanagement\IncrementManagementController;
use App\Http\Controllers\User\hr\leavesmanagement\LeaveManagementController;
use App\Http\Controllers\User\hr\advancehrpayment\AdvanceHrPaymentController;
use App\Http\Controllers\User\hr\employeeexitmanagement\EmployeeExitController;
use App\Http\Controllers\User\hr\qualityhealthsafety\QualityHealthSafetyController;
use App\Http\Controllers\User\hr\employeeChallan\ChallanController;

// INCOME & INVOICE MODULE
use App\Http\Controllers\User\invoiceandincome\CustomerInvoiceManagementController;
use App\Http\Controllers\User\invoiceandincome\UninvoicedReceiveablesController;
use App\Http\Controllers\User\invoiceandincome\ProjectIncomeManagementController;
use App\Http\Controllers\User\invoiceandincome\MiscIncomeController;
use App\Http\Controllers\User\invoiceandincome\PrincipalInvestmentsController;
use App\Http\Controllers\User\invoiceandincome\SecurityBondReturnController;

##Director withdraw controller
use App\Http\Controllers\User\damconmanagement\DirectorWithdrawController;

##Improved Categories
use App\Http\Controllers\User\improvedcategories\ImprovedCategoriesController;

##regions
use App\Http\Controllers\User\regions\RegionsController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(['register' => false]);

Route::get('/403',[DashboardController::class,'NotAuthorized'])->name('not_authorized');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/check',[PermissionController::class,'permissions']);

// Route::group(['middleware' => 'role'], function() {

//     Route::get('/admin', function() {

//        return 'Welcome Admin';

//     });

//  });

Route::middleware(['auth'])->group(function () {

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[DashboardController::class,'index'])->name('dashboard');

// stakeholders route
Route::any('/change/status',[CustomerController::class,'changeStatus'])->name('customer_status_change');
Route::post('investor/change/status',[InvestorController::class,'changeStatus'])->name('investors_status_change');
Route::post('user/change/status',[UserController::class,'changeStatus'])->name('user_status_change');
Route::post('supplier/change/status',[SupplierController::class,'changeStatus'])->name('supplier_status_change');
Route::post('project/change/status',[ProjectManagementController::class,'changeStatus'])->name('project_status_change');
Route::post('category/change/status',[CategoriesController::class,'changeStatus'])->name('category_status_change');



## user management Resource Controllers
Route::resource('roles',RoleController::class);
Route::resource('permissions',PermissionController::class);
Route::resource('users',UserController::class);
##get user profile
Route::get('/profile/{id}',[UserController::class,'profile'])->name('user.profile');
Route::post('/profile/update/{id}',[UserController::class,'profileUpdate'])->name('user.profileUpdate');
Route::resource('configurations',ConfigurationController::class);

## stakeholder routes
Route::resource('customers',CustomerController::class);
Route::resource('investors',InvestorController::class);
Route::resource('suppliers',SupplierController::class);

## projects management
Route::resource('projectmanagement',ProjectManagementController::class);

## banks managment
Route::resource('bankaccounts',BankAccountController::class);

## interbank transfers
Route::resource('interbanktransfer',InterBankTransferController::class);

## import purchases
Route::resource('importpurchases',ImportPurchasesController::class);

##inventory managment

    #category management
// Route::resource('categories',CategoriesController::class);
Route::post('/getCategories',[CategoriesController::class,'getCategories'])->name('getCategories');
Route::get('/editChildcategory/{id}',[CategoriesController::class,'childCategoryEdit'])->name('edit_Child_category');
Route::patch('/updateChildcategory/{id}',[CategoriesController::class,'childCategoryUpdate'])->name('update_Child_category');
Route::post('/ajaxgeterpcategorybymodule',[CategoriesController::class,'ajaxgeterpcategorybymodule'])->name('ajaxgeterpcategorybymodule');
  

    #category management

    #Project items inventory
    Route::resource('projectitems',ProjectItemsController::class);
    Route::post('/getchildCategories',[ProjectItemsController::class,'getchildCategories'])->name('getchildCategories');
    Route::post('/getajaxcategoriesByID',[ProjectItemsController::class,'getajaxcategoryByID'])->name('getajaxcategoryByID');
    #Project items inventory

    #project items issuance
    Route::resource('projectitemsissuance',ProjectItemsIssuanceController::class);
    Route::post('getprojectitems',[ProjectItemsIssuanceController::class,'getProjects'])->name('getProjects');
    #project items issuance
    Route::post('getissuanceEmp',[ProjectItemsIssuanceController::class,'getEmployees'])->name('getEmployees');

    ##Maintenanace item inventory
    Route::resource('maintenanaceiteminventory',MaintenanaceItemController::class);

    ##Maintenanace item consumtion
    Route::resource('maintenanaceitemconsumption',MaintenanaceConsumptionController::class);

##inventory managment

##fuel management
    ##fuel item
    Route::resource('fuelitem',FuelitemController::class);
    ##fuel consumption
    Route::resource('fuelconsumption',FuelConsumptionController::class);
    Route::get('get/project_fuel_items',[FuelConsumptionController::class,'get_project_fuel_items'])->name('get_project_fuel_items');
    Route::get('get/fuelConsumption',[FuelConsumptionController::class,'getFuelConsumption'])->name('getFuelConsumption');



//ajax routes
Route::post('get/tax_percentage',[ImportPurchasesController::class,'getTax'])->name('get_tax_boby');
Route::post('get/getleftleaves',[LeaveManagementController::class,'getLeftleaves'])->name('getleftleaves');





//Rental Item Routes
Route::resource('rentalitem',RentalItemsManagement::class);

Route::resource('rentalitem',RentalItemsManagement::class);
    Route::get('rentalitem/get/items',[RentalItemsManagement::class,'getRentalManagment'])->name('rentalitem_get_items');
    //Remove Bulk Orders
    Route::post('rentalitem/bulk/remove',[RentalItemsManagement::class,'destroy_bulk'])->name('rentalitem_bulk_remove');




//Purchase Orders Management Module
    //Customer POs Management Route
        Route::resource('customerpos',CustomerPosManagement::class);
            //Change Status
            Route::post('customerpos/change/status',[CustomerPosManagement::class,'changeStatus'])->name('customerpos_status_change');
            //Get Customer Orders
            Route::get('customerpos/get/orders',[CustomerPosManagement::class,'getCustomerOrders'])->name('customerpos_get_orders');
            //Remove Bulk Orders
            Route::post('customerpos/bulk/remove',[CustomerPosManagement::class,'destroy_bulk'])->name('customerpos_bulk_remove');

    //Supplier POs Management Route
        Route::resource('supplierspos',SupplierPosManagement::class);
            //Get Supplier Orders
            Route::get('supplierpos/get/orders',[SupplierPosManagement::class,'getSupplierOrders'])->name('supplierpos_get_orders');
            //Remove Bulk Orders
            Route::post('supplierpos/bulk/remove',[SupplierPosManagement::class,'destroy_bulk'])->name('supplierpos_bulk_remove');
            // Get supplier items
            Route::post('get/supplier/items',[SupplierPosManagement::class,'get_Supplier_items_po'])->name('get_supplier_items_po');

    //Assets POs Management Route
        Route::resource('assetspos',AssetsPosManagement::class);
            //Get Supplier Orders
            Route::get('assetspos/get/orders',[AssetsPosManagement::class,'getAssetsOrders'])->name('assetspos_get_orders');
            Route::post('get_Supplier_assests',[AssetsPosManagement::class,'get_Supplier_assests'])->name('get_Supplier_assests');
            //Remove Bulk Orders
            Route::post('assetspos/bulk/remove',[AssetsPosManagement::class,'destroy_bulk'])->name('assetspos_bulk_remove');

    //Rental POs Management Route
        Route::resource('rentalpos',RentalPosManagement::class);
            //Get Supplier Orders
            Route::get('rentalpos/get/orders',[RentalPosManagement::class,'getRentalOrders'])->name('rentalpos_get_orders');
            //Remove Bulk Orders
            Route::post('rentalpos/bulk/remove',[RentalPosManagement::class,'destroy_bulk'])->name('rentalpos_bulk_remove');
            //Get Monthly Rent
            Route::post('get_monthly_rent',[RentalPosManagement::class,'getMonthlyRent'])->name('get_monthly_rent');
            //Get Supplier Items
            Route::post('get/items',[RentalPosManagement::class,'getItems'])->name('getSupplier');

    //Services POs Management Route
        Route::resource('servicespos',ServicesPosManagement::class);
          //Get Assets Orders
          Route::get('servicespospos/get/orders',[ServicesPosManagement::class,'getServicesOrders'])->name('servicespos_get_orders');
          //Remove Bulk Orders
          Route::post('servicespos/bulk/remove',[ServicesPosManagement::class,'destroy_bulk'])->name('servicespos_bulk_remove');
          Route::post('getmaintenanceitems',[ServicesPosManagement::class,'getMaintenanceItems'])->name('getmaintenanceitems');

// Assets Management Module
    //Customer Assets Management
        Route::resource('customerassets',CustomerAssetsManagement::class);
            //Get Customer Assets
            Route::get('customer/assets/get/',[CustomerAssetsManagement::class,'getCustomerAssets'])->name('customer_get_assets');
            //Remove Bulk Orders
            Route::post('customer_assets/bulk/remove',[CustomerAssetsManagement::class,'destroy_bulk'])->name('customer_assets_bulk_remove');


    //Damcon Asset Depreciation
        Route::resource('damconassetsdepreciation',DamconAssetDepreciation::class);
            //Get Asset Details
            Route::post('getAssets',[DamconAssetDepreciation::class,'getAssetDetails'])->name('getAssetDetails');
            //Get Supplier Orders
            Route::get('assetsDepreciation/get/orders',[DamconAssetDepreciation::class,'getAssetsDepreciation'])->name('assets.depreciation_get');
            //Remove Bulk Orders
            Route::post('depreciation/bulk/remove',[DamconAssetDepreciation::class,'destroy_bulk'])->name('depreciation_assets_bulk_remove');


    //Damcon Asset Sales
        Route::resource('damconassetsales',DamconAssetSales::class);
            //Get Damcon Assets
            Route::post('damcon/assets_sale/get/',[DamconAssetSales::class,'getAssetDetails'])->name('damcom_get_assets_sales');
            //Get Assets Sales
            Route::get('assetsSales/get/list',[DamconAssetSales::class,'getAssetsSales'])->name('assets.sales.get');
            //Remove Bulk Orders
            Route::post('assetssales/bulk/remove',[DamconAssetSales::class,'destroy_bulk'])->name('assets_sales_bulk_remove');



    //Damcon Asset
        Route::resource('damconassets',DamconAssetsManagement::class);
            //Get Damcon Assets
            Route::get('damcon/assets/get/',[DamconAssetsManagement::class,'getDemconAssets'])->name('damcom_get_assets');
            //Remove Bulk Orders
            Route::post('damcon_assets/bulk/remove',[DamconAssetsManagement::class,'destroy_bulk'])->name('damcon_assets_bulk_remove');

    //Damcon HOTO
        Route::resource('damconhoto',DamconHoto::class);
        Route::post('gethotoEmpdetails',[DamconHoto::class,'gethotoEmployeeDetails'])->name('gethotoEmployeeDetails');
        Route::get('/getAjaxhoto',[DamconHoto::class,'getAjaxHoto'])->name('getAjaxhoto');

// Payments Management Module

    //Batches Management
        Route::resource('batches_management',BatchesManagement::class);
            //Remove Bulk Listing
            Route::post('batches/bulk/remove',[BatchesManagement::class,'destroy_bulk'])->name('batches_bulk_remove');

    //Batches Payments Management
        Route::resource('batches_payment_management',BatchesPaymentManagement::class);
            Route::post('batches_payment_banks',[BatchesPaymentManagement::class,'getBank'])->name('get_batch_bank');
            //Remove Bulk Records
            Route::post('batches_payment/bulk/remove',[BatchesPaymentManagement::class,'destroy_bulk'])->name('batches_payment_bulk_remove');


    //Suppliers Payments Management
        Route::resource('supplier_payment_management',SupplierPaymentManagement::class);
          Route::post('get_supplier/po',[SupplierPaymentManagement::class,'getSupplierPO'])->name('get_supplier_po');
          //Remove Bulk Records
          Route::post('supplier_payment/bulk/remove',[SupplierPaymentManagement::class,'destroy_bulk'])->name('supplier_payment_bulk_remove');


    //Security Payments Management
        Route::resource('security_payment_management',SecurityPaymentManagement::class);
          //Remove Bulk Records
          Route::post('security_payment/bulk/remove',[SecurityPaymentManagement::class,'destroy_bulk'])->name('security_payment_bulk_remove');

    //Loan Payments Management
        Route::resource('loan_payment_management',LoanPaymentManagement::class);
          //Remove Bulk Records
          Route::post('loan_payment/bulk/remove',[LoanPaymentManagement::class,'destroy_bulk'])->name('loan_payment_bulk_remove');

    //Bank Payments Management
        Route::resource('bank_payment_management',BankPaymentManagement::class);
           //Remove Bulk Records
           Route::post('bank_payment/bulk/remove',[BankPaymentManagement::class,'destroy_bulk'])->name('bank_payment_bulk_remove');

    //Project payment
        Route::resource('project_payment',ProjectPayment::class);
        Route::post('/ajaxgetpaymentcategories',[ProjectPayment::class,'ajaxgeterpcategorybymodule'])->name('ajaxgetpaymentcategories');


    // Taxation Management Module
    //Tax Bodies Management
        Route::resource('tax_bodies',TaxBodiesManagement::class);
        //Remove Bulk Records
        Route::post('tax_bodies/bulk/remove',[TaxBodiesManagement::class,'destroy_bulk'])->name('tax_bodies_bulk_remove');

    //Employees Tax Management
        Route::resource('employees_tax_management',EmployeesTaxManagement::class);
        //Remove Bulk Records
        Route::post('employees_tax/bulk/remove',[EmployeesTaxManagement::class,'destroy_bulk'])->name('employees_tax_management_bulk_remove');

    //Supplier Tax Payments Management
        // Route::resource('supplier_tax_management',SupplierTaxPaymentsManagement::class);
        // //Remove Bulk Records
        // Route::post('employees_tax/bulk/remove',[SupplierTaxPaymentsManagement::class,'destroy_bulk'])->name('employees_tax_management_bulk_remove');
    //Sales tax return management
        Route::resource('sales_tax_return_management',SalesTaxReturnManagement::class);
        Route::post('/getTaxMonthData',[SalesTaxReturnManagement::class,'getTaxMonthData'])->name('getTaxMonthData');
        Route::get('/getAjaxSalestax',[SalesTaxReturnManagement::class,'getAjaxSalestax'])->name('getAjaxSalestax');
    //Supplier tax payment Management
        Route::resource('suppliertaxpayment',SupplierTaxPaymentsManagement::class);
        Route::post('/getSuppliertaxledgers',[SupplierTaxPaymentsManagement::class,'get_supplier_tax_ledger'])->name('getSuppliertaxledgers');
        Route::get('/ajaxGetSuppliertaxpayments',[SupplierTaxPaymentsManagement::class,'ajaxGetSuppliertaxpayments']);


##HR management
    ##HR Categories
    Route::resource('hrcategories',HrCategories::class);
    Route::post('/change/status',[HrCategories::class,'changeStatus'])->name('hrcategory_status_change');
    
    ## HR employee
    Route::get('/employees',[EmployeeController::class,'getEmployee'])->name('employees');
    ##get employee salaries
    Route::get('/salarytransactions/{id}',[EmployeeController::class,'salaryTransactions'])->name('salaryTransactions');

    Route::get('create/employee',[EmployeeController::class,'createEmployee'])->name('createEmployee');

    Route::post('save/employee',[EmployeeController::class,'saveEmployee'])->name('saveEmployee');
    
    Route::get('/edit/employee/{id}',[EmployeeController::class,'editEmployee'])->name('editEmployee');

    Route::post('/edit/save',[EmployeeController::class,'editSaveEmployee'])->name('editEmpSave');

    Route::get('/view/profile/{id}',[EmployeeController::class,'viewProfile'])->name('viewEmployee');

    ##getajaxemployee
    Route::get('/getajaxEmployee',[EmployeeController::class,'getajaxEmployee'])->name('getAjaxEmployee');
    
    Route::post('/getSubordinatesEmployee',[EmployeeController::class,'getProjectEmp'])->name('getProjectEmp');

    ##salaries management   
    Route::resource('salary_management',SalariesManagementController::class);
    Route::get('/getajaxsalaries',[SalariesManagementController::class,'getAjaxSalaries'])->name('getAjaxSalaries');
    // import salaries
    Route::post('/import_salaies',[SalariesManagementController::class,'import_salaries'])->name('importSalaries');
    ##get import salaries
    Route::get('/getImportSalaries/{id}',[SalariesManagementController::class,'ajaxSalariesImport'])->name('ajaxSalariesImport');
    
    ##Inter Project Transfer Management
    Route::resource('interproject-management',InterProjectManagement::class);
    Route::get('/getAjaxInterProjects',[InterProjectManagement::class,'getAjaxInterProjects'])->name('getAjaxInterProjects');

    ##Increment Management
    Route::resource('increment-management',IncrementManagementController::class);
    Route::get('/getAjaxIncrement',[IncrementManagementController::class,'getAjaxIncrement'])->name('getAjaxIncrement');

    ##Leave Management
    Route::resource('leave-management',LeaveManagementController::class);
    Route::get('/getAjaxleaves',[LeaveManagementController::class,'getAjaxleaves'])->name('getAjaxleaves');

    ##AdvanceHr payment
    Route::resource('advancehrpayment',AdvanceHrPaymentController::class);
    Route::get('/getAjaxAdvanceHrPayment',[AdvanceHrPaymentController::class,'getAjaxAdvanceHrPayment'])->name('getAjaxAdvanceHrPayment');

    ##Employee exit management
    Route::resource('employeeExitManagement',EmployeeExitController::class);
    Route::get('/getEmpAjaxExit',[EmployeeExitController::class,'getEmpAjaxExit'])->name('getEmpAjaxExit');

    ##Qualityhealtsafety
    Route::resource('qualityhealthSafety',QualityHealthSafetyController::class);
    Route::get('/getAjaxQHS',[QualityHealthSafetyController::class,'getAjaxQHS'])->name('getAjaxQHS');
       
    ##CHALLAN
    Route::resource('employeechallan',ChallanController::class);
    Route::get('/getChallans',[ChallanController::class]);
    

##Invoice & Income Management
    ##Customer Invoice Management
    Route::resource('customerinvoice',CustomerInvoiceManagementController::class);
    Route::get('/getAjaxCustomerInvoice',[CustomerInvoiceManagementController::class,'getAjaxCustomerInvoice'])->name('getAjaxCustomerInvoice');

    ##uninvoiced receiveables
    Route::resource('uninvoicedreceivables',UninvoicedReceiveablesController::class);
    ##convert uninvoice to invoice
    Route::post('/convertInvoice',[UninvoicedReceiveablesController::class,'convertToInvoice'])->name('convertToInvoice');
    Route::get('/getAjaxUninvoiced',[UninvoicedReceiveablesController::class,'getAjaxUninvoiced'])->name('getAjaxUninvoiced');

    ##Project income management

    Route::resource('projectincome',ProjectIncomeManagementController::class);
    Route::get('/getAjaxIndexIncome',[ProjectIncomeManagementController::class,'getAjaxIndexIncome'])->name('getAjaxIndexIncome');

    ###get project invoices
    Route::any('/get/project/invoice',[ProjectIncomeManagementController::class,'getProjectsInvoices'])->name('getProjectInvoices');
    
    ##Misc Income management
    Route::resource('miscincome',MiscIncomeController::class);
    Route::get('/getAjaxMiscIncome',[MiscIncomeController::class,'getAjaxMiscIncome'])->name('getAjaxMiscIncome');

    ##Principal Investment management
    Route::resource('principalinvestment',PrincipalInvestmentsController::class);
    Route::get('/getAjaxPrincipleInvestment',[PrincipalInvestmentsController::class,'getAjaxPrincipleInvestment'])->name('getAjaxPrincipleInvestment');

    ##securityBond returns
    Route::resource('securitybondreturns',SecurityBondReturnController::class);
    Route::get('/getAjaxSecurityBondReturns',[SecurityBondReturnController::class,'getAjaxSecurityBondReturns'])->name('getAjaxSecurityBondReturns');

    ##directorwithdraw
    Route::resource('directorwithdraw',DirectorWithdrawController::class);
    Route::get('/getAjaxdirectorwithdraw',[DirectorWithdrawController::class,'getAjaxdirectorwithdraw'])->name('getAjaxdirectorwithdraw');

    ##get investort balance
    Route::post('getAjaxInvesterbalance',[PrincipalInvestmentsController::class,'getInvestorBalance'])->name('getInvestorBalance');


    ##getfuelmilage
    Route::post('getfuelmilage',[FuelConsumptionController::class,'get_Item_previous_milage'])->name('getfuelmilage');

    ##salman routes
    Route::get('projectmanagementinvoices/{id}', [ProjectManagementController::class, 'invoices'])->name('project_invoices');
    Route::get('projectmanagementincomes/{id}', [ProjectManagementController::class, 'incomes'])->name('project_incomes');


    ##Dashboard Routes
    Route::post('/getadmindashboard',[DashboardController::class,'getadminDashboardData'])->name('getadmindashboard');

    ##get last inserted invoice balance
    Route::post('/getLastInsertedInvoice',[CustomerInvoiceManagementController::class,'getLastInsertedInvoice'])->name('getLastInsertedInvoice');

    ##import Employees
    Route::post('/import_employees',[EmployeeController::class,'import_employees'])->name('import_employees');

    ##Categories
    Route::resource('categories',CategoriesController::class);
    Route::post('/updateCatogories',[CategoriesController::class,'updateCategories'])->name('updateCatogories');

    ###improved categories (Items categories)
    Route::post('/ajaxgetcategorybymodule',[ImprovedCategoriesController::class,'ajaxgetcategorybymodule'])->name('ajaxgetcategorybymodule');
    Route::resource('itemscategories',ImprovedCategoriesController::class);


    ##regions controller 
    Route::resource('regions',RegionsController::class);

}); 


Route::get('/clear', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});
