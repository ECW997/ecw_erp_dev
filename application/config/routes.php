<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['JobCard/(:num)'] = 'JobCard/index/$1';
$route['Invoice/(:num)'] = 'Invoice/index/$1';
$route['Payment/(:num)'] = 'Payment/index/$1';

// Cashier Routes - Controllers moved to root controllers directory
$route['Cashier/Shift'] = 'CashierShift';
$route['Cashier/Shift/(:any)'] = 'CashierShift/$1';

$route['Cashier/Handover'] = 'CashierHandover';
$route['Cashier/Handover/(:any)'] = 'CashierHandover/$1';

$route['Cashier/Summary'] = 'CashierSummary';
$route['Cashier/Summary/getCashBookSummary/(:num)'] = 'CashierSummary/getCashBookSummary/$1';
$route['Cashier/Summary/getCalculatedSummary/(:num)'] = 'CashierSummary/getCalculatedSummary/$1';
$route['Cashier/Summary/saveCashBookSummary/(:num)'] = 'CashierSummary/saveCashBookSummary/$1';
$route['Cashier/Summary/(:any)'] = 'CashierSummary/$1';

$route['Cashier/Shift/getRealTimeCashProgress/(:num)'] = 'CashierShift/getRealTimeCashProgress/$1';

$route['Cashier/TransactionLedger'] = 'CashierTransactionLedger';
$route['Cashier/TransactionLedger/reverseTransaction/(:num)'] = 'CashierTransactionLedger/reverseTransaction/$1';
$route['Cashier/TransactionLedger/(:any)'] = 'CashierTransactionLedger/$1';

$route['Cashier/CashMovement/approveCashMovement/(:num)'] = 'CashierCashMovement/approveCashMovement/$1';
$route['Cashier/CashMovement/cancelCashMovementApproval/(:num)'] = 'CashierCashMovement/cancelCashMovementApproval/$1';
$route['Cashier/CashMovement/deleteCashMovement/(:num)'] = 'CashierCashMovement/deleteCashMovement/$1';
$route['Cashier/CashMovement/updateCashMovement/(:num)'] = 'CashierCashMovement/updateCashMovement/$1';
$route['Cashier/CashMovement/getCashMovement/(:num)'] = 'CashierCashMovement/getCashMovement/$1';
$route['Cashier/CashMovement/getCashMovementById/(:num)'] = 'CashierCashMovement/getCashMovementById/$1';
$route['Cashier/CashMovement/printPettyCashVoucher/(:num)'] = 'CashierCashMovement/printPettyCashVoucher/$1';
$route['Cashier/CashMovement/getSupplierJobsBySupplier/(:num)'] = 'CashierCashMovement/getSupplierJobsBySupplier/$1';
$route['Cashier/CashMovement/getSupplierJobsWithAdvances/(:num)'] = 'CashierCashMovement/getSupplierJobsWithAdvances/$1';
$route['Cashier/CashMovement/getAdvancePaymentsByJob/(:num)'] = 'CashierCashMovement/getAdvancePaymentsByJob/$1';
$route['Cashier/CashMovement/updateSupplierJob/(:num)'] = 'CashierCashMovement/updateSupplierJob/$1';
$route['Cashier/CashMovement'] = 'CashierCashMovement';
$route['Cashier/CashMovement/(:any)'] = 'CashierCashMovement/$1';

$route['Cashier/Adjustment'] = 'CashierAdjustment';
$route['Cashier/Adjustment/(:any)'] = 'CashierAdjustment/$1';

$route['Cashier/IouSettlement'] = 'CashierIouSettlement';
$route['Cashier/IouSettlement/(:any)'] = 'CashierIouSettlement/$1';

$route['Cashier/Auth'] = 'CashierAuth';
$route['Cashier/Auth/(:any)'] = 'CashierAuth/$1';

$route['Cashier/CashSafeTransaction'] = 'CashSafeTransaction';
$route['Cashier/CashSafeTransaction/(:any)'] = 'CashSafeTransaction/$1';

$route['Cashier/CashBook'] = 'CashierCashBook';
$route['Cashier/CashBook/(:any)'] = 'CashierCashBook/$1';

// Cashier Report Routes
$route['Cashier/Report/dailySummary'] = 'CashierReport/dailySummary';
$route['Cashier/Report/paymentSummary'] = 'CashierReport/paymentSummary';
$route['Cashier/Report/discrepancy'] = 'CashierReport/discrepancy';
$route['Cashier/Report/cashOutSummary'] = 'CashierReport/cashOutSummary';
$route['Cashier/Report/outstandingIous'] = 'CashierReport/outstandingIous';
$route['Cashier/Report/(:any)'] = 'CashierReport/$1';