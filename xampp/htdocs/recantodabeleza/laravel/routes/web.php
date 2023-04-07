<?php

use Illuminate\Support\Facades\Route;
// use Carbon\Carbon;

date_default_timezone_set ("America/Sao_Paulo");

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

//OTHERS
Route::resource('adm/product', 'ProductController')->middleware('verification');
Route::get('adm/product/destroy/{id}', 'ProductController@destroy')->name('ProductDestroy')->middleware('verification');
Route::post('adm/product/filter',  'ProductController@filter')->name('ProductFilter')->middleware('verification');
Route::resource('adm/service', 'ServiceController')->middleware('verification');
Route::get('adm/service/destroy/{id}', 'ServiceController@destroy')->name('ServicoDestroy')->middleware('verification');
Route::post('adm/service/filter', 'ServiceController@filter')->name('ServiceFilter')->middleware('verification');

//ATTENDANCE
Route::get('adm/registerPayment', 'AttendanceController@registerPaymentView')->name('registerPayment')->middleware('verification');
Route::get('getAttendances', 'AttendanceController@getAttendances')->name('getAttendances')->middleware('verification');
Route::get('getUnpaidAttendances', 'AttendanceController@getUnpaidAttendances')->name('getUnpaidAttendances')->middleware('verification');
Route::get('adm/payment/{id}', 'AttendanceController@showPayment')->middleware('verification');
Route::get('adm/attendance/create/{date}', 'AttendanceController@newCreate')->middleware('verification');
Route::post('adm/clientPayment', 'AttendanceController@pay')->name('pay')->middleware('verification');
Route::resource('adm/attendance', 'AttendanceController')->middleware('verification');
Route::post('adm/quitando', function(){
  if(Request::ajax()){
    $request = Request::only('cdCliente');
    // return $request['cdCliente'];

    return redirect()->route('quitarAtendimento', [
      "cdCliente"=> $request['cdCliente']
    ]); 
  }
})->middleware('verification');
Route::get('adm/quitarAtendimento', 'AttendanceController@quitarAtendimento')->name('quitarAtendimento')->middleware('verification');

//CUSTOMER
Route::get('getCustomersCPFs', 'CustomerController@getCPFs')->name('getCustomersCPFs')->middleware('verification');
Route::get('getCustomersEmails', 'CustomerController@getEmails')->name('getCustomersEmails')->middleware('verification');
Route::get('adm/customer/destroy', 'CustomerController@destroy')->name('CustDestroy')->middleware('verification');
Route::resource('adm/customer', 'CustomerController')->middleware('verification');
Route::post('adm/customer/filter', 'CustomerController@filter')->name('CustomerFilter')->middleware('verification');

//EMPLOYEE + TYPE
Route::get('getEmployeesCPFs', 'EmployeeController@getCPFs')->name('getEmployeesCPFs')->middleware('verification');
Route::get('getEmployeesEmails', 'EmployeeController@getEmails')->name('getEmployeesEmails')->middleware('verification');
Route::resource('adm/employee', 'EmployeeController')->middleware('verification');
Route::get('adm/employee/destroy/{id}', 'EmployeeController@destroy')->name('EmpDestroy')->middleware('verification');
Route::post('adm/employee/filter', 'EmployeeController@filter')->name('EmployeeFilter')->middleware('verification');
Route::post('adm/newEmpType', 'EmployeeTypeController@store')->name('newEmpType')->middleware('verification');
Route::resource('adm/employeeType', 'EmployeeTypeController')->middleware('verification');
Route::get('adm/employeeType/destroy/{id}', 'EmployeeTypeController@destroy')->name('EmpTypeDestroy')->middleware('verification');
Route::post('adm/employeeType/filter', 'EmployeeTypeController@filter')->name('EmpTypeFilter')->middleware('verification');

//SUPPLIER
Route::get('getSuppliersEmails', 'SupplierController@getEmails')->name('getSuppliersEmails')->middleware('verification');
Route::get('getSuppliersCNPJs', 'SupplierController@getCNPJs')->name('getSuppliersCNPJs')->middleware('verification');
Route::resource('adm/supplier', 'SupplierController')->middleware('verification');
Route::get('adm/supplier/destroy/{id}', 'SupplierController@destroy')->name('SupDestroy')->middleware('verification');
Route::post('adm/supplier/filter', 'SupplierController@filter')->name('SuppliersFilter')->middleware('verification');

//SCHEDULING
Route::get('adm/scheduling/create/{date}', 'SchedulingController@newCreate')->middleware('verification');
Route::resource('adm/scheduling', 'SchedulingController')->middleware('verification');

//REPORTS
Route::get('/pdfLatePayment', 'LatePaymentPdfController@geraPdf')->middleware('verification');
Route::resource('adm/paymentReport', 'PaymentReportController')->middleware('verification');

Route::get('/pdfAttendance', 'AttendancePdfController@geraPdf')->middleware('verification');
Route::resource('adm/attendanceReport', 'AttendanceReportController')->middleware('verification');

//GENERAL
Route::view('adm/more', 'more')->middleware('verification');
Route::get('adm/index', 'FullCalendar@index')->name("index")->middleware('verification');
Route::get('load-events', 'SchedulingController@loadEvents')->name('routeLoadEvents')->middleware('verification');
Route::get('getESRelationship', 'ServiceController@getEmployeeRelationship')->name('getESRelationship')->middleware('verification');

Route::post('adm/exibindo', function(){
  if(Request::ajax()){
    $valor = Request::only('valor');

    $route = "indexProducts";

    // var_dump($route);
    return redirect()->route($route, [
      "valor"=> $valor['valor']
    ]); 
  }
})->middleware('verification');
Route::get('adm/indexProducts', 'ProductController@indexProducts')->name('indexProducts')->middleware('verification');

Route::get('/cep', function(){
  $cepResponse = cep('01010000');
  $data = $cepResponse->getCepModel();
  return response()->json($data);
})->middleware('verification');

Route::get('/endereco', function(){
  $enderecoResponse = endereco('sp','são paulo','ave');
  $data = $enderecoResponse->getCepModels();
  return response()->json($data);
})->middleware('verification');

Auth::routes();

// USER
Route::get('/adm/newUser/{nome}/{email}/{senha}/{tipo}','UserController@store')->name('newUser')->middleware('verification'); 
Route::get('/adm/getCategory','UserController@getCategory')->name('getCategory')->middleware('verification');

//LOGIN
Route::get('/adm/login','AuthController@showLoginForm')->name('adm.login'); // (tela de login)
Route::get('/adm/logout','AuthController@logout')->name('adm.logout')->middleware('verification');
Route::get('/adm','AuthController@dashboard')->name('adm')->middleware('verification');
Route::post('/adm/login/do','AuthController@login')->name('adm.login.do');

// INDEX EMPLOYEE
Route::get('/','AuthController@indexEmployee')->name('indexEmployee'); // tela inicial
