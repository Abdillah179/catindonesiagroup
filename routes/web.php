<?php

use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group;
use App\Http\Controllers\ControllerHome;
use App\Http\Controllers\ControllerAdmin;
use App\Http\Controllers\ControllerLogin;
use App\Http\Controllers\ControllerMarketing;
use App\Http\Controllers\ControllerPPICPlant1;
use App\Http\Controllers\ControllerPPICPlant2;
use App\Http\Controllers\ControllerPPICPlant3;
use App\Http\Controllers\ControllerEngineering;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use \App\Models\User;

Route::middleware(['guests'])->group(function () {
    Route::get('/', [ControllerHome::class, 'Home'])->name('login');
    Route::get('/forgotpasswordadmin', [ControllerLogin::class, 'ForgotPasswordAdmin'])->middleware('throttle:10,2')->name('password.request');
    Route::post('/postforgotpasswordadmin', [ControllerLogin::class, 'PostForgotPasswordAdmin'])->middleware('throttle:5,2');
    Route::get('/reset-password/{token}', function (string $token) {
        return view('auth.reset-password', [
            'token' => $token,
            'judul' => 'Halaman Reset Password'
        ]);
    })->name('password.reset');

    Route::post('/reset-password', [ControllerLogin::class, 'ResettingPassword'])->middleware('throttle:5,2')->name('password.update');
    Route::get('/forgotpasswordppicplant1', [ControllerLogin::class, 'ForgotPasswordPPICPlant1']);
    Route::post('/postforgotpasswordppicplant1', [ControllerLogin::class, 'PostForgotPasswordPPICPlant1'])->middleware('throttle:5,2');
    Route::get('/forgotpasswordppicplant2', [ControllerLogin::class, 'ForgotPasswordPPICPlant2']);
    Route::post('/postforgotpasswordppicplant2', [ControllerLogin::class, 'PostForgotPasswordPPICPlant2'])->middleware('throttle:5,2');
    Route::get('/forgotpasswordppicplant3', [ControllerLogin::class, 'ForgotPasswordPPICPlant3']);
    Route::post('/postforgotpasswordppicplant3', [ControllerLogin::class, 'PostForgotPasswordPPICPlant3'])->middleware('throttle:5,2');
    Route::get('/loginadmin', [ControllerLogin::class, 'LoginAdmin']);
    Route::get('/loginppicplant1', [ControllerLogin::class, 'LoginPPICPlant1']);
    Route::get('/loginppicplant3', [ControllerLogin::class, 'LoginPPICPlant3']);
    Route::post('/postloginuserppicplant1', [ControllerLogin::class, 'PostLoginUserPPICPlant1'])->middleware('throttle:5,1');
    Route::post('/postloginuseradmin', [ControllerLogin::class, 'PostLoginUserAdmin'])->middleware('throttle:5,1');
    Route::post('/postloginuserppicplant3', [ControllerLogin::class, 'PostLoginUserPPICPlant3'])->middleware('throttle:5,2');
    Route::get('/loginppicplant2', [ControllerLogin::class, 'LoginPPICPlant2']);
    Route::post('/postloginuserppicplant2', [ControllerLogin::class, 'PostLoginUserPPICPlant2'])->middleware('throttle:5,2');
    Route::get('/loginmarketing', [ControllerLogin::class, 'LoginMarketing']);
    Route::post('/postloginusermarketing', [ControllerLogin::class, 'PostLoginMarketing'])->middleware('throttle:5,2');
    // Route::get('/lihatdataloadingmachineplant1/home', [ControllerHome::class, 'LihatDataLoadingMachinePlant1Home']);
    // Route::get('/lihatdataloadingmachinepermachine/plnt1/home', [ControllerHome::class, 'LihatDataLoadingMachinePerMachineHomePlant1']);
    // Route::get('/detaildataloadingmachineplant1permachine/home/{mesin:url_unique_mesin}', [ControllerHome::class, 'DetailDataLoadingMachinePlant1PerMachineHome']);
    // Route::get('/exportpdfdataloadingmachinepermachineplant1home/{mesin:url_unique_mesin}', [ControllerHome::class, 'ExportPDFDataLoadingMachinePerMachinePlant1Home']);
    // Route::get('/lihatdatakeseluruhanloadingmachineplant1/plnt1/home', [ControllerHome::class, 'LihatDataKeseluruhanLoadingMachinePlant1Home']);
    // Route::get('/exportpdfdatakeseluruhanloadingmachinepermachineplant1home', [ControllerHome::class, 'ExportPDFDataKeseluruhanLoadingMachinePerMachinePlant1Home']);
    // Route::get('/lihatdataloadingmachineplant2/home', [ControllerHome::class, 'LihatDataLoadingMachinePlant2Home']);
    // Route::get('/lihatdataloadingmachinepermachinepln2/home', [ControllerHome::class, 'LihatDataLoadingMachinePerMachinePlant2Home']);
    // Route::get('/detaildataloadingmesinplant2permachine/home/{mesin:url_unique_mesin}', [ControllerHome::class, 'DetailDataLoadingMesinPlant2PerMesinHome']);
    // Route::get('/exportpdfdataloadingmachinepermachineplant2home/{mesin:url_unique_mesin}', [ControllerHome::class, 'ExportPDFDataLoadingMachinePerMachinePlant2Home']);
    // Route::get('/lihatdatakeseluruhanloadingmachinepln2/home', [ControllerHome::class, 'LihatDataKeseluruhanLoadingMachinePlant2Home']);
    // Route::get('/exportpdfdatakeseluruhanloadingmachinepermachineplant2home', [ControllerHome::class, 'ExportPDFDataKeseluruhanLoadingMachinePerMachinePlant2Home']);
    // Route::get('/lihatdataloadingmachineplant3/home', [ControllerHome::class, 'LihatDataLoadingMachinePlant3Home']);
    // Route::get('/lihatdataloadingmachinepermachinepln3/home', [ControllerHome::class, 'LihatDataLoadingMachinePerMachinePlant3']);
    // Route::get('/detaildataloadingmachineplant3permachine/home/{mesin:url_unique_mesin}', [ControllerHome::class, 'DetailDataLoadingMachinePlant3PerMachineHome']);
    // Route::get('/exportpdfdataloadingmachinepermachineplant3home/{mesin:url_unique_mesin}', [ControllerHome::class, 'ExportPDFDataLoadingMachinePerMachinePlant3Home']);
    // Route::get('/lihatdatakeseluruhanloadingmachinepln3/home', [ControllerHome::class, 'LihatDataKeseluruhanLoadingMachinePlant3Home']);
    // Route::get('/exportpdfdatakeseluruhanloadingmachinepermachineplant3home', [ControllerHome::class, 'ExportPDFDataKeseluruhanLoadingMachinePerMachinePlant3Home']);
    // Route::get('/exportexceldataloadingmachinepermachineplant1home/{mesin:url_unique_mesin}', [ControllerHome::class, 'ExportExcelDataLoadingMachinePerMachinePlant1Home']);
    // Route::get('/exportexceldatakeseluruhanloadingmachineplant1home', [ControllerHome::class, 'ExportExcelDataKeseluruhanLoadingMachinePlant1Home']);
    // Route::get('/exportexceldataloadingmachinepermachineplant2home/{mesin:url_unique_mesin}', [ControllerHome::class, 'ExportExcelDataLoadingMachinePerMachinePlant2Home']);
    // Route::get('/exportexceldatakeseluruhanloadingmachinepermachineplant2home', [ControllerHome::class, 'ExportExcelDataKeseluruhanLoadingMachinePlant2Home']);
    // Route::get('/exportexceldataloadingmachinepermachineplant3home/{mesin:url_unique_mesin}', [ControllerHome::class, 'ExportExcelDataLoadingMachinePermachinePlant3Home']);
    // Route::get('/exportexceldatakeseluruhanloadingmachinepermachineplant3home', [ControllerHome::class, 'ExportExcelDataKeseluruhanLoadingMachinePermachinePlant3Home']);
});


Route::middleware(['auth', 'adminplant3', 'encryp', 'verified'])->group(function () {
    Route::get('/DashboardAdmin', [ControllerAdmin::class, 'DashboardAdmin'])->name('home');
    Route::get('/datauseradmin', [ControllerAdmin::class, 'DataUserAdmin']);
    Route::get('/datamesin', [ControllerAdmin::class, 'DataMesin']);
    Route::delete('/postdeletedatamesin/{data:url_unique_mesin}', [ControllerAdmin::class, 'PostDeleteDataMesin'])->middleware('throttle:15,2');
    Route::post('/posteditnamamesin/{data:url_unique_mesin}', [ControllerAdmin::class, 'PostEditNamaMesin'])->middleware('throttle:15,2');
    Route::post('/posttambahdatamesin', [ControllerAdmin::class, 'PostTambahDataMesin'])->middleware('throttle:15,2');
    Route::get('/datauserppicplant1', [ControllerAdmin::class, 'DataUserPPICPlant1']);
    Route::post('/posttambahdatauserppicplant1/adm', [ControllerAdmin::class, 'PostTambahDataUserPPICPlant1ADM'])->middleware('throttle:5,2');
    Route::put('/posteditkodemesin/{data:url_unique_mesin}', [ControllerAdmin::class, 'PostEditKodeMesin'])->middleware('throttle:15,2');
    Route::get('/ubahpasswordadmin', [ControllerAdmin::class, 'UbahPasswordAdmin']);
    Route::patch('/postubahpasswordadmin/adm', [ControllerAdmin::class, 'PostUbahPasswordAdminADM'])->middleware('throttle:10,2');
    Route::get('/datamesinplant2', [ControllerAdmin::class, 'DataMesinPlant2']);
    Route::post('/posttambahdatamesinplant2/pln2', [ControllerAdmin::class, 'PostTambahDataMesinPlant2PLN2'])->middleware('throttle:20,2');
    Route::delete('/postdeletedatamesinplant2/{mesin:url_unique_mesin}', [ControllerAdmin::class, 'PostDeleteDataMesinPlant2'])->middleware('throttle:20,2');
    Route::patch('/posteditnamamesinplant2/{mesin:url_unique_mesin}', [ControllerAdmin::class, 'PostEditNamaMesinPlant2'])->middleware('throttle:20,2');
    Route::patch('/posteditkodemesinplant2/{mesin:url_unique_mesin}', [ControllerAdmin::class, 'PostEditKodeMesinPlant2'])->middleware('throttle:20,2');
    Route::get('/datamesinplant3', [ControllerAdmin::class, 'DataMesinPlant3']);
    Route::post('/posttambahdatamesinplant3/plnt3', [ControllerAdmin::class, 'PostTambahDataMesinPlant3'])->middleware('throttle:15,2');
    Route::delete('/postdeletedatamesinplant3/{mesin:url_unique_mesin}', [ControllerAdmin::class, 'PostDeleteDataMesinPlant3'])->middleware('throttle:30,2');
    Route::patch('/posteditnamamesinplant3/plt3/{mesin:url_unique_mesin}', [ControllerAdmin::class, 'PostEditNamaMesinPlant3PLT3'])->middleware('throttle:30,2');
    Route::patch('/posteditkodemesinplant3/plnt3/{mesin:url_unique_mesin}', [ControllerAdmin::class, 'PostEditKodeMesinPlant3PLNT3'])->middleware('throttle:30,2');
    Route::get('/datauserppicplant2', [ControllerAdmin::class, 'DataUserPPICPlant2']);
    Route::post('/posttambahdatauserppicplant2/adm', [ControllerAdmin::class, 'PostTambahDataUserPPICPlant2ADM'])->middleware('throttle:30,2');
    Route::get('/logoutuser', [ControllerLogin::class, 'Logout']);
    Route::get('/profileuseradmin', [ControllerAdmin::class, 'ProfileUserAdmin']);
    Route::patch('/postubahfotoprofileuser/adm', [ControllerAdmin::class, 'PostUbahFotoProfileUserAdmin'])->middleware('throttle:10,2');
    Route::post('/postgetfotoprofileuseradmin', [ControllerAdmin::class, 'PostGetFotoProfileUserAdmin'])->middleware('throttle:10,2');
    Route::delete('/postdeleteuserppicplant1/adm/{data:url_unique}', [ControllerAdmin::class, 'PostDeleteUserPPICPlant1ADM'])->middleware('throttle:10,2');
    Route::delete('/postdeletedatauserppicplant2/adm/{data:url_unique}', [ControllerAdmin::class, 'PostDeleteDataUserPPICPlant2ADM'])->middleware('throttle:10,2');
    Route::get('/datauserppicplant3', [ControllerAdmin::class, 'DataUserPPICPlant3']);
    Route::delete('/postdeletedatauserppicplant3/adm/{data:url_unique}', [ControllerAdmin::class, 'PostDeleteDataUserPPICPlant3ADM'])->middleware('throttle:10,2');
    Route::post('/posttambahdatauserppicplant3/adm', [ControllerAdmin::class, 'PostTambahDataUserPPICPlant3ADM'])->middleware('throttle:20,2');
    Route::post('/posttambahdatauseradmin/adm', [ControllerAdmin::class, 'PostTambahDataUserAdminADM'])->middleware('throttle:20,2');
    Route::delete('/postdeleteuseradmin/adm/{data:url_unique}', [ControllerAdmin::class, 'PostDeleteDataUserAdminADM'])->middleware('throttle:20,2');
});

// Authentication Route

// Route::get('/verify-email/{token}', [ControllerAdmin::class, 'VerifyEmail'])->middleware('auth')->name('verify.email');

Route::middleware(['auth', 'ppicplant3', 'encryp', 'verified'])->group(function () {
    Route::get('/DashboardPPICPlant3', [ControllerPPICPlant3::class, 'DashboardPPICPlant3']);
    Route::get('/dataloadingmachineppicplant3', [ControllerPPICPlant3::class, 'DataLoadingMachinePPICPlant3']);
    Route::get('/detaildataloadingmachineppicplant3/{mesin:url_unique_mesin}', [ControllerPPICPlant3::class, 'DetailDataLoadingMachinePPICPlant3']);
    Route::delete('/postdeletedataloadingmesinplant3/pln3/{data:url_unique}', [ControllerPPICPlant3::class, 'PostDeleteDataLoadingMesinPlant3PLN3'])->middleware('throttle:30,2', 'gateppicplant3');
    Route::patch('/posteditdetaildataloadingmesinspkppicplant3/{data:url_unique}', [ControllerPPICPlant3::class, 'PostEditDetailDataLoadingMesinSPKPPICPlant3'])->middleware('throttle:30,2', 'gateppicplant3');
    Route::get('/tambahdataloadingmachineplant3/pln3', [ControllerPPICPlant3::class, 'TambahDataLoadingMachinePlant3PLN3'])->middleware('gateppicplant3');
    Route::post('/posttambahloadingmesinsistemplant3/plnt3', [ControllerPPICPlant3::class, 'PostTambahLoadingMesinSistemPlant3PLNT3'])->middleware('throttle:30,2', 'gateppicplant3');
    Route::patch('/updatestatusdonedatadetailloadingmachineplant3/plnt3/{data:url_unique}', [ControllerPPICPlant3::class, 'UpdateStatusDoneDataDetailLoadingMachinePlant3'])->middleware('throttle:30,2', 'gateppicplant3');
    Route::get('/exportpdfdatadetailloadingmachineplant3/{data:url_unique_mesin}', [ControllerPPICPlant3::class, 'ExportPDFDataDetailLoadingMachinePlant3']);
    Route::get('/ubahpassworduserplant3/pl3', [ControllerPPICPlant3::class, 'UbahPasswordUserPlant3PL3'])->middleware('gateppicplant3');
    Route::patch('/postubahpassworduserplant3/pln3', [ControllerPPICPlant3::class, 'PostUbahPasswordUserPlant3PLN3'])->middleware('throttle:14,2', 'gateppicplant3');
    Route::get('/profileuserpl3', [ControllerPPICPlant3::class, 'ProfileUserPlant3'])->middleware('gateppicplant3');
    Route::post('/postgetfotoprofileuserplant3', [ControllerPPICPlant3::class, 'PostGetFotoProfileUserPlant3'])->middleware('throttle:20,2', 'gateppicplant3');
    Route::patch('/postubahfotoprofileuserplant3/pln3', [ControllerPPICPlant3::class, 'PostUbahFotoProfileUserPlant3PLN3'])->middleware('throttle:20,2', 'gateppicplant3');
    Route::get('/pilihopsilihatdataloadingmachineplant3/pln3', [ControllerPPICPlant3::class, 'PilihOpsiLihatDataLoadingMachinePlant3PLN3']);
    Route::get('/getpilihopsilihatdataloadingmachineplant3', [ControllerPPICPlant3::class, 'GetPilihOpsiLihatDataLoadingMachinePlant3']);
    Route::get('/lihatdatakeseluruhanloadingmachineplant3', [ControllerPPICPlant3::class, 'LihatDataKeseluruhanLoadingMachinePlant3']);
    Route::delete('/postdeletedatakeseluruhanloadingmachineplant3/pln3/{data:url_unique}', [ControllerPPICPlant3::class, 'PostDeleteDataKeseluruhanLoadingMachinePlant3'])->middleware('throttle:30,2', 'gateppicplant3');
    Route::patch('/updatestatusdonedatakeseluruhanloadingmachineplant3/pln3/{data:url_unique}', [ControllerPPICPlant3::class, 'UpdateStatusDoneDataKeseluruhanLoadingMachinePlant3'])->middleware('throttle:30,2', 'gateppicplant3');
    Route::patch('/posteditdatakeseluruhanloadingmachineppicplant3/{data:url_unique}', [ControllerPPICPlant3::class, 'PostEditDataKeseluruhanLoadingMachinePPICPlant3'])->middleware('throttle:30,2', 'gateppicplant3');
    Route::get('/exportpdfdatakeseluruhanloadingmachineplant3', [ControllerPPICPlant3::class, 'ExportPDFDataKeseluruhanLoadingMachinePlant3']);
    Route::get('/restoredataloadingmachineplant3/plnt3', [ControllerPPICPlant3::class, 'RestoreDataLoadingMachinePlant3PLNT3'])->middleware('gateppicplant3');
    Route::patch('/postrestoreddataloadingmachineplant3/plnt3/{url_unique}', [ControllerPPICPlant3::class, 'PostRestoredDataLoadingMachinePlant3'])->middleware('throttle:30,2', 'gateppicplant3');
    Route::get('/logoutuserppicplant3', [ControllerLogin::class, 'LogoutPPICPlant3']);
    Route::get('/exportexceldatadetailloadingmachineplant3/{mesin:url_unique_mesin}', [ControllerPPICPlant3::class, 'ExportExcelDataDetailLoadingMachinePlant3']);
    Route::get('/exportexceldatakeseluruhanloadingmachineplant3', [ControllerPPICPlant3::class, 'ExportExcelDataKeseluruhanLoadingMachinePlant3']);


    // PLANT 1

    // 

    Route::get('/pilihopsilihatdataloadingmachineplant1/plant3', [ControllerPPICPlant3::class, 'PilihOpsiLihatDataLoadingMachinePlant1PLANT3']);
    Route::get('/getpilihopsilihatdataloadingmesinplant1/plant3', [ControllerPPICPlant3::class, 'GetPilihOpsiLihatDataLoadingMesinPlant1PLANT3']);
    Route::get('/lihatdataloadingmachineplant1permachine/plant3', [ControllerPPICPlant3::class, 'LihatDataLoadingMachinePlant1PerMachinePLANT3']);
    Route::get('/lihatdetaildataloadingmachinepermachineplant1/plant3/{mesin:url_unique_mesin}', [ControllerPPICPlant3::class, 'LihatDetailDataLoadingMachinePerMachinePlant1PLANT3']);
    Route::get('/exportpdfdatadetailloadingmachineplant1/plant3/{mesin:url_unique_mesin}', [ControllerPPICPlant3::class, 'ExportPDFDataDetailLoadingMachinePlant1PLANT3']);
    Route::get('/exportexceldatadetailloadingmachineplant1/plant3/{mesin:url_unique_mesin}', [ControllerPPICPlant3::class, 'ExportExcelDataDetailLoadingMachinePlant1PLANT3']);

    // 

    Route::get('/lihatdatakeseluruhanloadingmachineplant1/plant3', [ControllerPPICPlant3::class, 'LihatDataKeseluruhanLoadingMachinePlant1PLANT3']);
    Route::get('/exportpdfdatakeseluruhanloadingmachineplant1/plant3', [ControllerPPICPlant3::class, 'ExportPDFDataKeseluruhanLoadingMachinePlant1PLANT3']);
    Route::get('/exportexceldatakeseluruhanloadingmachineplant1/plant3', [ControllerPPICPlant3::class, 'ExportExcelDataKeseluruhanLoadingMachinePlant1PLANT3']);



    // PLANT 2

    // 

    Route::get('/pilihopsilihatdataloadingmachineplant2/plant3', [ControllerPPICPlant3::class, 'PilihOpsiLihatDataLoadingMachinePlant2PLANT3']);
    Route::get('/getpilihopsilihatdataloadingmachineplant2/plant3', [ControllerPPICPlant3::class, 'GetPilihOpsiLihatDataLoadingMachinePlant2PLANT3']);
    Route::get('/lihatdataloadingmesinpermesinplant2/plant3', [ControllerPPICPlant3::class, 'LihatDataLoadingMesinPerMesinPlant2PLANT3']);
    Route::get('/lihatdetaildataloadingmesinpermesinplant2/plant3/{mesin:url_unique_mesin}', [ControllerPPICPlant3::class, 'LihatDetailDataLoadingMesinPerMesinPlant2PLANT3']);
    Route::get('/exportpdfdatadetailloadingmesinplant2permesin/plant3/{mesin:url_unique_mesin}', [ControllerPPICPlant3::class, 'ExportPDFDataDetailLoadingMesinPlant2PerMesinPLANT3']);
    Route::get('/exportexceldatadetailloadingmesinplant2permesin/plant3/{mesin:url_unique_mesin}', [ControllerPPICPlant3::class, 'ExportExcelDataDetailLoadingMesinPlant2PerMesinPLANT3']);

    // 

    Route::get('/lihatdatakeseluruhanloadingmachineplant2/plant3', [ControllerPPICPlant3::class, 'LihatDataKeseluruhanLoadingMachinePlant2PLANT3']);
    Route::get('/exportpdfdatakeseluruhanloadingmachineplant2/plant3', [ControllerPPICPlant3::class, 'ExportPDFDataKeseluruhanLoadingMachinePlant2PLANT3']);
    Route::get('/exportexceldatakeseluruhanloadingmachineplant2/plant3', [ControllerPPICPlant3::class, 'ExportExcelDataKeseluruhanLoadingMachinePlant2PLANT3']);


    // LIHAT FILE PROJEK

    Route::post('/posttambahdatafileprojekloadingmachinekeseluruhanplant3/plant3/{data:url_unique}', [ControllerPPICPlant3::class, 'PostTambahDataFileProjekLoadingMachineKeseluruhanPlant3PLANT3'])->middleware('throttle:30,2');
    Route::get('/lihatdatafileprojekloadingmachinekeseluruhanplant3/plnt3/{data:url_unique}', [ControllerPPICPlant3::class, 'LihatDataFileProjekLoadingMachineKeseluruhanPlant3PLANT3']);
    Route::post('/posttambahdatafileprojekloadingmesinkeseluruhanplant3/plnt3/{data:url_unique}', [ControllerPPICPlant3::class, 'PostTambahDataFileProjekLoadingMesinKeseluruhanPlant3PLN3'])->middleware('throttle:30,2');
    Route::delete('/postdeletedatafileprojekloadingmachinekeseluruhanplant3/plant3/{file:url_unique}', [ControllerPPICPlant3::class, 'PostDeleteDataFileProjekLoadingMachineKeseluruhanPlant3PLANT3'])->middleware('throttle:30,2');
    Route::patch('/postubahdatafileprojekloadingmachinekeseluruhanplant3/plant3/{file:url_unique}', [ControllerPPICPlant3::class, 'PostUbahDataFileProjekLoadingMachineKeseluruhanPlant3PLN3'])->middleware('throttle:30,2');
    Route::post('/posttambahdatafileprojekloadingmachinepermachineplant3/pln3/{data:url_unique}', [ControllerPPICPlant3::class, 'PostTambahDataFileProjekLoadingMachinePerMachinePlant3PLN3'])->middleware('throttle:30,2');
    Route::get('/lihatdatafileprojekloadingmachinepermachineplant3/pln3/{data:url_unique}', [ControllerPPICPlant3::class, 'LihatDataFileProjekLoadingMachinePerMachinePlant3PLN3']);
    Route::post('/posttambahdatafileprojekloadingmesinpermesinplant3/plant3/{data:url_unique}', [ControllerPPICPlant3::class, 'PostTambahDataFileProjekLoadingMesinPerMesinPlant3PLNT3'])->middleware('throttle:30,2');
    Route::delete('/postdeletedatafileprojekloadingmachinepermachineplant3/plnt3/{file:url_unique}', [ControllerPPICPlant3::class, 'PostDeleteDataFileProjekLoadingMachinePerMachinePlant3PLNT3'])->middleware('throttle:30,2');
    Route::patch('/postubahdatafileprojekloadingmachinepermachineplant3/pl3/{file:url_unique}', [ControllerPPICPlant3::class, 'PostUbahDataFileProjekLoadingMachinePerMachinePlant3PLNT3'])->middleware('throttle:30,2');


    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE lihatdatakeseluruhanloadingmachineplant3 plant3

    Route::get('/exportpdfstartdateenddatelihatdatakeseluruhanloadingmachineplant3/plant3', [ControllerPPICPlant3::class, 'ExportPDFStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant3PLANT3']);
    Route::get('/exportexcelstartdateenddatelihatdatakeseluruhanloadingmachineplant3/plant3', [ControllerPPICPlant3::class, 'ExportExcelStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant3PLANT3']);
    Route::get('/exportpdffilterdonenotdonelihatdatakeseluruhanloadingmachineplant3/plant3', [ControllerPPICPlant3::class, 'ExportPDFFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant3PLANT3']);
    Route::get('/exportexcelfilterdonenotdonelihatdatakeseluruhanloadingmachineplant3/plant3', [ControllerPPICPlant3::class, 'ExportExcelFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant3PLANT3']);


    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE detaildataloadingmachineppicplant3 plant3

    Route::get('/exportpdfstartdateenddatedetaildataloadingmachineppicplant3/plant3/{mesin:url_unique_mesin}', [ControllerPPICPlant3::class, 'ExportPDFStartDateEndDateDetailDataLoadingMachinePPICPlant3PLANT3']);
    Route::get('/exportexcelstartdateenddatedetaildataloadingmachineppicplant3/plant3/{mesin:url_unique_mesin}', [ControllerPPICPlant3::class, 'ExportExcelStartDateEndDateDetailDataLoadingMachinePPICPlant3PLANT3']);
    Route::get('/exportpdffilterdonenotdonedetaildataloadingmachineppicplant3/plant3/{mesin:url_unique_mesin}', [ControllerPPICPlant3::class, 'ExportPDFFilterDoneNotDoneDetailDataLoadingMachinePPICPlant3PLANT3']);
    Route::get('/exportexcelfilterdonenotdonedetaildataloadingmachineppicplant3/plant3/{mesin:url_unique_mesin}', [ControllerPPICPlant3::class, 'ExportExcelFilterDoneNotDoneDetailDataLoadingMachinePPICPlant3PLANT3']);


    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE lihatdatakeseluruhanloadingmachineplant1 plant3

    Route::get('/exportpdfstartdateenddatelihatdatakeseluruhanloadingmachineplant1/plant3', [ControllerPPICPlant3::class, 'ExportPDFStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant1PLANT3']);
    Route::get('/exportexcelstartdateenddatelihatdatakeseluruhanloadingmachineplant1/plant3', [ControllerPPICPlant3::class, 'ExportExcelStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant1PLANT3']);
    Route::get('/exportpdffilterdonenotdonelihatdatakeseluruhanloadingmachineplant1/plant3', [ControllerPPICPlant3::class, 'ExportPDFFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant1PLANT3']);
    Route::get('/exportexcelfilterdonenotdonelihatdatakeseluruhanloadingmachineplant1/plant3', [ControllerPPICPlant3::class, 'ExportExcelFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant1PLANT3']);


    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE lihatdetaildataloadingmachinepermachineplant1 plant3

    Route::get('/exportpdfstartdateenddatelihatdetaildataloadingmachinepermachineplant1/plant3/{mesin:url_unique_mesin}', [ControllerPPICPlant3::class, 'ExportPDFStartDateEndDateLihatDetailDataLoadingMachinePerMachinePlant1PLANT3']);
    Route::get('/exportexcelstartdateenddatelihatdetaildataloadingmachinepermachineplant1/plant3/{mesin:url_unique_mesin}', [ControllerPPICPlant3::class, 'ExportExcelStartDateEndDateLihatDetailDataLoadingMachinePerMachinePlant1PLANT3']);
    Route::get('/exportpdffilterdonenotdonelihatdetaildataloadingmachinepermachineplant1/plant3/{mesin:url_unique_mesin}', [ControllerPPICPlant3::class, 'ExportPDFFilterDoneNotDoneLihatDetailDataLoadingMachinePerMachinePlant1PLANT3']);
    Route::get('/exportexcelfilterdonenotdonelihatdetaildataloadingmachinepermachineplant1/plant3/{mesin:url_unique_mesin}', [ControllerPPICPlant3::class, 'ExportExcelFilterDoneNotDoneLihatDetailDataLoadingMachinePerMachinePlant1PLANT3']);


    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE lihatdatakeseluruhanloadingmachineplant2 plant3

    Route::get('/exportpdfstartdateenddatelihatdatakeseluruhanloadingmachineplant2/plant3', [ControllerPPICPlant3::class, 'ExportPDFStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant2PLANT3']);
    Route::get('/exportexcelstartdateenddatelihatdatakeseluruhanloadingmachineplant2/plant3', [ControllerPPICPlant3::class, 'ExportExcelStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant2PLANT3']);
    Route::get('/exportpdffilterdonenotdonelihatdatakeseluruhanloadingmachineplant2/plant3', [ControllerPPICPlant3::class, 'ExportPDFFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant2PLANT3']);
    Route::get('/exportexcelfilterdonenotdonelihatdatakeseluruhanloadingmachineplant2/plant3', [ControllerPPICPlant3::class, 'ExportExcelFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant2PLANT3']);


    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE lihatdetaildataloadingmesinpermesinplant2 plant3

    Route::get('/exportpdfstartdateenddatelihatdetaildataloadingmesinpermesinplant2/plant3/{mesin:url_unique_mesin}', [ControllerPPICPlant3::class, 'ExportPDFStartDateEndDateLihatDetailDataLoadingMesinPerMesinPlant2PLANT3']);
    Route::get('/exportexcelstartdateenddatelihatdetaildataloadingmesinpermesinplant2/plant3/{mesin:url_unique_mesin}', [ControllerPPICPlant3::class, 'ExportExcelStartDateEndDateLihatDetailDataLoadingMesinPerMesinPlant2PLANT3']);
    Route::get('/exportpdffilterdonenotdonelihatdetaildataloadingmesinpermesinplant2/plant3/{mesin:url_unique_mesin}', [ControllerPPICPlant3::class, 'ExportPDFFilterDoneNotDoneLihatDetailDataLoadingMesinPerMesinPlant2PLANT3']);
    Route::get('/exportexcelfilterdonenotdonelihatdetaildataloadingmesinpermesinplant2/plant3/{mesin:url_unique_mesin}', [ControllerPPICPlant3::class, 'ExportExcelFilterDoneNotDoneLihatDetailDataLoadingMesinPerMesinPlant2PLANT3']);
});

Route::middleware(['auth', 'ppicplant1', 'encryp', 'verified'])->group(function () {
    Route::get('/DashboardPPICPlant1', [ControllerPPICPlant1::class, 'DashboardPPICPlant1']);
    Route::post('/posttambahdataloadingmesinspkppicplant1/plnt1', [ControllerPPICPlant1::class, 'PostTambahDataLoadingMachineSPKPPICPlant1PLNT1'])->middleware('throttle:40,1', 'gateppicplant1');
    Route::get('/lihatsemuadataloadingmachineplant1plnt1', [ControllerPPICPlant1::class, 'LihatSemuaDataLoadingMachinePlant1PLNT1']);
    Route::get('/lihatdetaildataloadingmachineplant1/plnt1/{mesin:url_unique_mesin}', [ControllerPPICPlant1::class, 'LihatDetailLoadingMachinePlant1PLNT1']);
    Route::delete('/postdeletedatadetailloadingmachineplant1/plnt1/{data:url_unique}', [ControllerPPICPlant1::class, 'PostDeteleDataDetailLoadingMachinePlant1PLNT1'])->middleware('throttle:27,2', 'gateppicplant1');
    Route::patch('/posteditdatadetailloadingmesinppicplant1/plnt1/{data:url_unique}', [ControllerPPICPlant1::class, 'PostEditDataDetailLoadingMesinPPICPlant1PLNT1'])->middleware('throttle:27,2', 'gateppicplant1');
    Route::patch('/postupdatestatusdonedetaildataloadingmesinplant1/plnt1/{data:url_unique}', [ControllerPPICPlant1::class, 'PostUpdateStatusDoneDetailDataLoadingMesinPlant1PLNT1'])->middleware('throttle:27,2', 'gateppicplant1');
    Route::get('/exportpdfdatadetailloadingmachineplant1/{mesin:url_unique_mesin}', [ControllerPPICPlant1::class, 'ExportPDFDataDetailLoadingMachinePlant1']);
    Route::get('/tambahloadingmachinesistemplant1/plnt1', [ControllerPPICPlant1::class, 'TambahLoadingMachineSistemPlant1PLNT1'])->middleware('gateppicplant1');
    Route::get('/ubahpassworduserpl1', [ControllerPPICPlant1::class, 'UbahPasswordPlant1'])->middleware('gateppicplant1');
    Route::patch('/postubahpassworduserplant1/plnt1', [ControllerPPICPlant1::class, 'PostUbahPasswordUserPlant1'])->middleware('throttle:20,2', 'gateppicplant1');
    Route::get('/profileuserpl1', [ControllerPPICPlant1::class, 'ProfileUserPlant1'])->middleware('gateppicplant1');
    Route::post('/postgetfotoprofileuser', [ControllerPPICPlant1::class, 'PostGetFotoProfileUser'])->middleware('throttle:27,2', 'gateppicplant1');
    Route::patch('/postubahfotoprofileuser/plnt1', [ControllerPPICPlant1::class, 'PostUbahFotoProfileUserPLNT1'])->middleware('throttle:27,2')->middleware('gateppicplant1');
    Route::get('/lihatdataloadingmesinplant1', [ControllerPPICPlant1::class, 'LihatDataLoadingMesinPlant1']);
    Route::get('/lihatdatakeseluruhanloadingmachineplant1/pln1', [ControllerPPICPlant1::class, 'LihatDataKeseluruhanLoadingMachinePlant1PLN1']);
    Route::get('/export-pdf-data-keseluruhan-loading-machine-plant-1/pln1', [ControllerPPICPlant1::class, 'ExportPDFDataKeseluruhanLoadingMachinePlant1PLN1']);
    Route::delete('/postdeletedatakeseluruhanloadingmesinplant1/plnt1/{data:url_unique}', [ControllerPPICPlant1::class, 'PostDeleteDataKeseluruhanLoadingMesinPlant1PLNT1'])->middleware('throttle:30,2', 'gateppicplant1');
    Route::get('/restoredataloadingmachineplant1/pln1', [ControllerPPICPlant1::class, 'RestoreDataLoadingMachinePlant1PLN1'])->middleware('gateppicplant1');
    Route::patch('/postrestoredataloadingmachineplant1/pln1/{data:url_unique}', [ControllerPPICPlant1::class, 'PostRestoreDataLoadingMachinePlant1PLN1'])->middleware('throttle:30,2', 'gateppicplant1');
    Route::patch('/posteditdatakeseluruhanloadingmachineppicplant1/pln1/{data:url_unique}', [ControllerPPICPlant1::class, 'PostEditDataKeseluruhanLoadingMachinePPICPlant1PLN1'])->middleware('throttle:30,2', 'gateppicplant1');
    Route::patch('/postupdatestatusdonedatakeseluruhanloadingmesinplant1/plnt1/{data:url_unique}', [ControllerPPICPlant1::class, 'PostUpdateStatusDoneDataKeseluruhanLoadingMesinPlant1PLNT1'])->middleware('throttle:30,2', 'gateppicplant1');
    Route::get('/pilihopsilihatdataloadingmachineplant1', [ControllerPPICPlant1::class, 'PilihOpsiLihatLoadingMachinePlant1']);
    Route::get('/getpilihopsilihatdataloadingmachineplant1/pln1', [ControllerPPICPlant1::class, 'GetPlilihOpsiLihatDataLoadingMachinePlant1PLN1']);
    Route::get('/logoutuserppicplant1', [ControllerLogin::class, 'LogoutUserPPICPlant1']);
    Route::get('/exportexceldatadetailloadingmachineplant1/{mesin:url_unique_mesin}', [ControllerPPICPlant1::class, 'ExportExcelDataDetailLoadingMachinePlant1']);
    Route::get('/export-excel-data-keseluruhan-loading-machine-plant-1/pln1', [ControllerPPICPlant1::class, 'ExportExcelDataKeseluruhanLoadingMachinePlant1PLN1']);
    Route::get('/pilihopsilihatdataloadingmachineplant2/pln1', [ControllerPPICPlant1::class, 'PilihOpsiLihatDataLoadingMachinePlant2PLN1']);
    Route::get('/getpilihopsilihatdataloadingmachineplant2/plnt1', [ControllerPPICPlant1::class, 'GetPilihOpsiLihatDataLoadingMachinePlant2PLNT1']);
    Route::get('/lihatdataloadingmachinepermachineplant2/plant1', [ControllerPPICPlant1::class, 'LihatDataLoadingMachinePerMachinePlant2PLNT1']);
    Route::get('/lihatdetaildataloadingmesinplant2/plant1/{mesin:url_unique_mesin}', [ControllerPPICPlant1::class, 'LihatDetailDataLoadingMesinPlant2PLANT1']);
    Route::get('/exportpdfdatadetailloadingmachineplant2permesin/plnt1/{mesin:url_unique_mesin}', [ControllerPPICPlant1::class, 'ExportPDFDataDetailLoadingMachinePlant2PerMesinPLNT1']);
    Route::get('/exportexceldatadetailloadingmachineplant2permesin/plnt1/{mesin:url_unique_mesin}', [ControllerPPICPlant1::class, 'ExportExcelDataDetailLoadingMachinePlant2PerMesinPLNT1']);
    Route::get('/lihatdatakeseluruhanloadingmachineplant2/plant1', [ControllerPPICPlant1::class, 'LihatDataKeseluruhanLoadingMachinePlant2PLANT1']);
    Route::get('/export-pdf-data-keseluruhan-loading-machine-plant-2/plant1', [ControllerPPICPlant1::class, 'ExportPDFDataKeseluruhanLoadingMachinePlant2PLANT1']);
    Route::get('/export-excel-data-keseluruhan-loading-machine-plant-2/plant1', [ControllerPPICPlant1::class, 'ExportExcelDataKeseluruhanLoaadingMachinePlant2PLANT1']);

    // PLANT 3

    Route::get('/pilihopsilihatdataloadingmachineplant3/plant1', [ControllerPPICPlant1::class, 'PilihOpsiLihatDataLoadingMachinePlant3PLANT1']);
    Route::get('/getpilihopsilihatdataloadingmachineplant3/plant1', [ControllerPPICPlant1::class, 'GetPilihOpsiLihatDataLoadingMachinePlant3PLANT1']);
    Route::get('/lihatdataloadingmesinpermesinplant3/plant1', [ControllerPPICPlant1::class, 'LihatDataLoadingMesinPerMesinPlant3PLANT1']);
    Route::get('/lihatdetaildataloadingmachineplant3/plant1/{mesin:url_unique_mesin}', [ControllerPPICPlant1::class, 'LihatDetailDataLoadingMachinePlant3PLANT1']);
    Route::get('/exportpdfdatadetailloadingmesinplant3permesin/plant1/{mesin:url_unique_mesin}', [ControllerPPICPlant1::class, 'ExportPDFDataDetailLoadingMesinPlant3PerMesinPLANT1']);
    Route::get('/exportexceldatadetailloadingmesinplant3permesin/plant1/{mesin:url_unique_mesin}', [ControllerPPICPlant1::class, 'ExportExcelDataDetailLoadingMesinPlant3PerMesinPLANT1']);

    Route::get('/lihatdatakeseluruhanloadingmesinplant3/plant1', [ControllerPPICPlant1::class, 'LihatDataKeseluruhanLoadingMachinePlant3PLANT1']);
    Route::get('/export-pdf-data-keseluruhan-loading-mesin-plant-3/plant1', [ControllerPPICPlant1::class, 'ExportPDFDataKeseluruhanLoadingMachinePlant3PLANT1']);
    Route::get('/export-excel-data-keseluruhan-loading-machine-plant-3/plant1', [ControllerPPICPlant1::class, 'ExportExcelDataKeseluruhanLoadingMachinePlant3PLANT1']);



    // FILE PROJEK

    Route::get('/lihatfileprojekloadingmachineplant1/plant1/{data:url_unique}', [ControllerPPICPlant1::class, 'LihatFileProjekLoadingMachinePlant1PLANT1']);
    Route::post('/posttambahdatafileprojekloadingmachineplant1/PLNT1/{data:url_unique}', [ControllerPPICPlant1::class, 'PostTambahDataFileProjekLoadingMachinePlant1PLNT1'])->middleware('throttle:30,2');
    Route::delete('/postdeletefileprojekloadingmachineplant1/PLNT1/{file:url_unique}', [ControllerPPICPlant1::class, 'PostDeleteFileProjekLoadingMachinePlant1PLNT1'])->middleware('throttle:30,2');
    Route::patch('/postubahdatafileprojekloadingmachineplant1/plant1/{file:url_unique}', [ControllerPPICPlant1::class, 'PostUbahDataFileProjekLoadingMachinePlant1PLANT1'])->middleware('throttle:30,2');
    Route::post('/posttambahdatafileprojekloadingmachinepermachineplant1/{data:url_unique}', [ControllerPPICPlant1::class, 'PostTambahDataFileProjekLoadingMachinePerMachinePlant1'])->middleware('throttle:30,2');
    Route::get('/lihatdatafileprojekloadingmachinepermachineplant1/plnt1/{data:url_unique}', [ControllerPPICPlant1::class, 'LihatDataFileProjekLoadingMachinePlant1PLNT1']);
    Route::post('/posttambahdatafileprojekloadingmachinepermachineplant1/PLNT1/{data:url_unique}', [ControllerPPICPlant1::class, 'PostTambahDataFileProjekLoadingMachinePerMachinePlant1PLNT1'])->middleware('throttle:30,2');
    Route::delete('/postdeletefileprojekloadingmachinepermachineplant1/PLNT1/{file:url_unique}', [ControllerPPICPlant1::class, 'PostDeleteFileProjekLoadingMachinePerMachinePlant1PLNT1'])->middleware('throttle:30,2');
    Route::patch('/postubahdatafileprojekloadingmachinepermachineplant1/PLNT1/{file:url_unique}', [ControllerPPICPlant1::class, 'PostUbahDataFileProjekLoadingMachinePerMachinePlant1PLNT1'])->middleware('throttle:30,2');
    Route::post('/posttambahdatafileprojekloadingmachineallplant1/plnt1/{data:url_unique}', [ControllerPPICPlant1::class, 'PostTambahDataFileProjekLoadingMachineAllPlant1PLANT1'])->middleware('throttle:30,2');

    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE

    Route::get('/exportpdfstartdateenddatedatadetailloadingmachineplant1/{mesin:url_unique_mesin}', [ControllerPPICPlant1::class, 'ExportPDFStartDateEndDateDataDetailLoadingMachinePlant1PLNT1']);
    Route::get('/exportexcelstartdateenddatedatadetailloadingmachineplant1/{mesin:url_unique_mesin}', [ControllerPPICPlant1::class, 'ExportExcelStartDateEndDateDataDetailLoadingMachinePlant1PLNT1']);
    Route::get('/exportpdffilterdonenotdonedatadetailloadingmachineplant1/{mesin:url_unique_mesin}', [ControllerPPICPlant1::class, 'ExportPDFFilterDoneNotDoneDataDetailLoadingMachinePlant1PLNT1']);
    Route::get('/exportexcelfilterdonenotdonedatadetailloadingmachineplant1/{mesin:url_unique_mesin}', [ControllerPPICPlant1::class, 'ExportExcelFilterDoneNotDoneDataDetailLoadingMachinePlant1PLNT1']);

    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE KESELURUHAN

    Route::get('/exportpdfstartdateenddatelihatdataallloadingmachineplant1/plnt1', [ControllerPPICPlant1::class, 'ExportPDFStartDateEndDateLihatDataAllLoadingMachinePlant1PLNT1']);
    Route::get('/exportexcelstartdateenddatelihatdataallloadingmachineplant1/plnt1', [ControllerPPICPlant1::class, 'ExportExcelStartDateEndDateLihatDataAllLoadingMachinePlant1PLNT1']);
    Route::get('/exportpdffilterdonenotdonelihatdataallloadingmachineplant1/plnt1', [ControllerPPICPlant1::class, 'ExportPDFFilterDoneNotDoneLihatDataAllLoadingMachinePlant1PLNT1']);
    Route::get('/exportexcelfilterdonenotdonelihatdataallloadingmachineplant1/pln1', [ControllerPPICPlant1::class, 'ExportExcelFilterDoneNotDoneLihatDataAllLoadingMachinePlant1PLN1']);


    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE DATA DETAIL LOADING MACHINE PLANT2 PER MACHINE PLNT1

    Route::get('/exportpdfstartdateenddatelihatdetaildataloadingmachineplant2permachine/PLNT1/{mesin:url_unique_mesin}', [ControllerPPICPlant1::class, 'ExportPDFStartDateEndDateLihatDetailDataLoadingMachinePlant2PerMachinePLNT1']);
    Route::get('/exportexcelstartdateenddatelihatdetaildataloadingmachineplant2permachine/PLNT1/{mesin:url_unique_mesin}', [ControllerPPICPlant1::class, 'ExportExcelStartDateEndDateLihatDetailDataLoadingMachinePlant2PerMachinePLNT1']);
    Route::get('/exportpdffilterdonenotdonelihatdetaildataloadingmachineplant2permachine/PLNT1/{mesin:url_unique_mesin}', [ControllerPPICPlant1::class, 'ExportPDFFilterDoneNotDoneLihatDetailDataLoadingMachinePlant2pPerMachinePLNT1']);
    Route::get('/exportexcelfilterdonenotdonelihatdetaildataloadingmachineplant2permachine/PLNT1/{mesin:url_unique_mesin}', [ControllerPPICPlant1::class, 'ExportExcelFilterDoneNotDoneLihatDetailDataLoadingMachinePlant2PerMachinePLNT1']);


    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE LIHAT DATA KESELURUHAN LOADING MACHINE PLANT2 PLANT1

    Route::get('/exportpdfstartdateenddatelihatdatakeseluruhanloadingmachineplant2PLANT1', [ControllerPPICPlant1::class, 'ExportPDFStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant2PLANT1']);
    Route::get('/exportexcelstartdateenddatelihatdatakeseluruhanloadingmachineplant2PLANT1', [ControllerPPICPlant1::class, 'ExportExcelStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant2PLANT1']);
    Route::get('/exportpdffilterdonenotdonelihatdatakeseluruhanloadingmachineplant2/PLNT1', [ControllerPPICPlant1::class, 'ExportPDFFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant2PLNT1']);
    Route::get('/exportexcelfilterdonenotdonelihatdatakeseluruhanloadingmachineplant2/PLNT1', [ControllerPPICPlant1::class, 'ExportExcelFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant2PLNT1']);


    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE LIHAT DATA KESELURUHAN LOADING MACHINE PLANT3 PLANT1

    Route::get('/exportpdfstartdateenddatelihatdatakeseluruhanloadingmachineplant3PLANT1', [ControllerPPICPlant1::class, 'ExportPDFStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant3PLANT1']);
    Route::get('/exportexcelstartdateenddatelihatdatakeseluruhanloadingmachineplant3PLANT1', [ControllerPPICPlant1::class, 'ExportExcelStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant3PLANT1']);
    Route::get('/exportpdffilterdonenotdonelihatdatakeseluruhanloadingmachineplant3/PLANT1', [ControllerPPICPlant1::class, 'ExportPDFFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant3PLANT1']);
    Route::get('/exportexcelfilterdonenotdonelihatdatakeseluruhanloadingmachineplant3/PLANT1', [ControllerPPICPlant1::class, 'ExportExcelFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant3PLANT1']);


    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE LIHAT DETAIL DATA LOADING MACHINE PLANT 3 PLANT1

    Route::get('/exportpdfstartdateenddatelihatdetaildataloadingmachineplant3/plant1/{mesin:url_unique_mesin}', [ControllerPPICPlant1::class, 'ExportPDFStartDateEndDateLihatDetailDataLoadingMachinePlant3PLANT1']);
    Route::get('/exportexcelstartdateenddatelihatdetaildataloadingmachineplant3/plant1/{mesin:url_unique_mesin}', [ControllerPPICPlant1::class, 'ExportExcelStartDateEndDateLihatDetailDataLoadingMachinePlant3PLANT1']);
    Route::get('/exportpdffilterdonenotdonelihatdetaildataloadingmachineplant3/plant1/{mesin:url_unique_mesin}', [ControllerPPICPlant1::class, 'ExportPDFFilterDoneNotDoneLihatDetailDataLoadingMachinePlant3PLANT1']);
    Route::get('/exportexcelfilterdonenotdonelihatdetaildataloadingmachineplant3/plant1/{mesin:url_unique_mesin}', [ControllerPPICPlant1::class, 'ExportExcelFilterDoneNotDoneLihatDetailDataLoadingMachinePlant3PLANT1']);
});


Route::middleware(['auth', 'ppicplant2', 'encryp', 'verified'])->group(function () {
    Route::get('/DashboardPPICPlant2', [ControllerPPICPlant2::class, 'DashboardPPICPlant2']);
    Route::get('/tambahloadingmachineplant2/pln2', [ControllerPPICPlant2::class, 'TambahLoadingMachinePlant2PLNT2'])->middleware('gateppicplant2');
    Route::post('/posttambahdataloadingmesinppicplant2/plnt2', [ControllerPPICPlant2::class, 'PostTambahDataLoadingMesinPPICPlant2PLNT2'])->middleware('throttle:30,2', 'gateppicplant2');
    Route::get('/lihatsemuadataloadingmachineplant2pln2', [ControllerPPICPlant2::class, 'LihatSemuaDataLoadingMachinePlant2PLNT2']);
    Route::get('/lihatsemuadatadetailloadingmachineplant2/pln2/{mesin:url_unique_mesin}', [ControllerPPICPlant2::class, 'LihatSemuaDataDetailLoadingMachinePlant2PLNT2']);
    Route::delete('/postdeleteloadingmachineplant2/pln2/{data:url_unique}', [ControllerPPICPlant2::class, 'PostDeleteLoadingMachinePlant2PLN2'])->middleware('throttle:27,2', 'gateppicplant2');
    Route::patch('/updatestatusdonedataloadingmachineplant2/pln2/{data:url_unique}', [ControllerPPICPlant2::class, 'UpdateStatusDoneDataLoadingMachinePlant2PLN2'])->middleware('throttle:30,2', 'gateppicplant2');
    Route::patch('/postubahdatadetailloadingmesinspkplant2/pln2/{data:url_unique}', [ControllerPPICPlant2::class, 'PostUbahDataDetailLoadingMesinSPKPlant2PLN2'])->middleware('throttle:30,2', 'gateppicplant2');
    Route::get('/export-pdf-detail-loading-machine-plant-2/{mesin:url_unique_mesin}', [ControllerPPICPlant2::class, 'ExportPDFDetailLoadingMachinePlant2']);
    Route::get('/ubahpassworduserplant2/pln2', [ControllerPPICPlant2::class, 'UbahPasswordUserPlant2PLN2'])->middleware('gateppicplant2');
    Route::patch('/postubahpassworduserplant2/pln2', [ControllerPPICPlant2::class, 'PostUbahPasswordUserPlant2PLN2'])->middleware('throttle:10,2', 'gateppicplant2');
    Route::get('/profileuserplant2/pln2', [ControllerPPICPlant2::class, 'ProfileUserPlant2PLN2'])->middleware('gateppicplant2');
    Route::post('/postgetfotoprofileuserplant2', [ControllerPPICPlant2::class, 'PostGetFotoProfileUserPlant2'])->middleware('throttle:10,2', 'gateppicplant2');
    Route::patch('/postubahfotoprofileuserplant2/plnt2', [ControllerPPICPlant2::class, 'PostUbahFotoProfileUserPlant2PLNT2'])->middleware('throttle:10,2', 'gateppicplant2');
    Route::get('/pilihopsilihatdataloadingmesinplant2/pln2', [ControllerPPICPlant2::class, 'PilihOpsiLihatDataLoadingMesinPlant2PLN2']);
    Route::get('/getpilihopsilihatdataloadingmesinplant2/plnt2', [ControllerPPICPlant2::class, 'GetPilihOpsiLihatDataLoadingMesinPlant2PLNT2']);
    Route::get('/lihatdatakeseluruhanloadingmesinplant2', [ControllerPPICPlant2::class, 'LihatDataKeseluruhanLoadingMesinPlant2']);
    Route::delete('/postdeletedatakeseluruhanloadingmachineplant2/{data:url_unique}', [ControllerPPICPlant2::class, 'PostDeleteDataKeseluruhanLoadingMachinePlant2'])->middleware('throttle:30,2', 'gateppicplant2');
    Route::patch('/posteditdatakeseluruhanloadingmachineppicplant2/pln2/{data:url_unique}', [ControllerPPICPlant2::class, 'PostEditDataKeseluruhanLoadingMachinePPICPlant2PLN2'])->middleware('throttle:30,2', 'gateppicplant2');
    Route::patch('/postupdatestatusdonedatakeseluruhanloadingmachineplant2/plnt2/{data:url_unique}', [ControllerPPICPlant2::class, 'PostUpdateStatusDoneDataKeseluruhanLoadingMachinePlant2PLNT2'])->middleware('throttle:30,2', 'gateppicplant2');
    Route::get('/export-pdf-data-keseluruhan-loading-machine-plant-2', [ControllerPPICPlant2::class, 'ExportPDFDataKeseluruhanLoadingMachinePlant2']);
    Route::get('/restoredataloadingmachineplant2', [ControllerPPICPlant2::class, 'RestoreDataLoadingMachinePlant2'])->middleware('gateppicplant2');
    Route::patch('/restoredataloadingmachineplant2/plnt2/{url_unique}', [ControllerPPICPlant2::class, 'RestoreDataLoadingMachinePlant2PLNT2'])->middleware('throttle:30,2', 'gateppicplant2');
    Route::get('/logoutuserppicplant2', [ControllerLogin::class, 'LogoutPPICPlant2']);
    Route::get('/export-excel-detail-loading-machine-plant-2/{mesin:url_unique_mesin}', [ControllerPPICPlant2::class, 'ExportExcelDetailLoadingMachinePlant2']);
    Route::get('/export-excel-data-keseluruhan-loading-machine-plant-2', [ControllerPPICPlant2::class, 'ExportExcelDataKeseluruhanLoadingMachinePlant2']);


    // PLANT 1

    Route::get('/pilihopsilihatdataloadingmachineplant1/plnt2', [ControllerPPICPlant2::class, 'PilihOpsiLihatDataLoadingMachinePlant1PLNT2']);
    Route::get('/getpilihopsilihatdataloadingmesinplant1/plant2', [ControllerPPICPlant2::class, 'GetPilihOpsiLihatDataLoadingMesinPlant1PLANT2']);
    Route::get('/lihatdataloadingmachineplant1permachine/plant2', [ControllerPPICPlant2::class, 'LihatDataLoadingMachinePlant1PerMachinePLANT2']);
    Route::get('/lihatsemuadatadetailloadingmesinpermesinplant1/plant2/{mesin:url_unique_mesin}', [ControllerPPICPlant2::class, 'LihatSemuaDataDetailLoadingMesinPermesinPlant1PLANT2']);
    Route::get('/export-pdf-detail-loading-machine-plant-1-per-machine/plant2/{mesin:url_unique_mesin}', [ControllerPPICPlant2::class, 'ExportPDFDetailLoadingMachinePlant1PerMachinePLANT2']);
    Route::get('/export-excel-detail-loading-machine-plant-1-per-machine/plant2/{mesin:url_unique_mesin}', [ControllerPPICPlant2::class, 'ExportExcelDetailLoadingMachinePlant1PerMachinePLANT2']);

    // 

    Route::get('/lihatdatakeseluruhanloadingmachineplant1/plant2', [ControllerPPICPlant2::class, 'LihatDataKeseluruhanLoadingMachinePlant1PLANT2']);
    Route::get('/export-pdf-data-keseluruhan-loading-machine-plant-1/plant2', [ControllerPPICPlant2::class, 'ExportPDFDataKeseluruhanLoadingMachinePlant1PLANT2']);
    Route::get('/export-excel-data-keseluruhan-loading-machine-plant-1/plant2', [ControllerPPICPlant2::class, 'ExportExcelDataKeseluruhanLoadingMachinePlant1PLANT2']);


    // PLANT 3

    // 

    Route::get('/pilihopsilihatdataloadingmachineplant3/plant2', [ControllerPPICPlant2::class, 'PilihOpsiLihatDataLoadingMachinePlant3PLANT2']);
    Route::get('/getpilihopsilihatdataloadingmesinplant3/plant2', [ControllerPPICPlant2::class, 'GetPilihOpsiLihatDataLoadingMachinePlant3PLANT2']);
    Route::get('/lihatdataloadingmesinplant3permesin/plant2', [ControllerPPICPlant2::class, 'LihatDataLoadingMesinPlant3PerMesinPLANT2']);
    Route::get('/lihatsemuadatadetailloadingmachinepermachineplant3/plant2/{mesin:url_unique_mesin}', [ControllerPPICPlant2::class, 'LihatSemuaDataDetailLoadingMachinePerMachinePlant3PLANT2']);
    Route::get('/export-pdf-detail-loading-machine-plant-3-per-machine/plant2/{mesin:url_unique_mesin}', [ControllerPPICPlant2::class, 'ExportPDFDetailLoadingMachinePlant3PerMachinePLANT2']);
    Route::get('/export-excel-detail-loading-machine-plant-3-per-machine/plant2/{mesin:url_unique_mesin}', [ControllerPPICPlant2::class, 'ExportExcelDetailLoadingMachinePlant3PerMachinePLANT2']);

    // 

    Route::get('/lihatdatakeseluruhanloadingmesinplant3/plant2', [ControllerPPICPlant2::class, 'LihatDataKeseluruhanLoadingMesinPlant3PLANT2']);
    Route::get('/export-pdf-data-keseluruhan-loading-machine-plant-3/plant2', [ControllerPPICPlant2::class, 'ExportPDFDataKeseluruhanLoadingMachinePlant3PLANT2']);
    Route::get('/export-excel-data-keseluruhan-loading-machine-plant-3/plant2', [ControllerPPICPlant2::class, 'ExportExcelDataKeseluruhanLoadingMachinePlant3PLANT2']);


    // FILE PROJEK

    Route::post('/posttambahdatafileprojekloadingmachinekeseluruhanplant2/plnt2/{data:url_unique}', [ControllerPPICPlant2::class, 'PostTambahDataFileProjekLoadingMachineKeseluruhanPlant2PLNT2'])->middleware('throttle:30,2');
    Route::get('/lihatdatakeseluruhanfileprojekloadingmachineplant2/plnt2/{data:url_unique}', [ControllerPPICPlant2::class, 'LihatDataKeseluruhanFileProjekLoadingMachinePlant2PLNT2']);
    Route::post('/posttambahdatafileprojekloadingmesinkeseluruhanplant2/{data:url_unique}', [ControllerPPICPlant2::class, 'PostTambahDataFileProjekLoadingMesinKeseluruhanPlant2PLANT2'])->middleware('throttle:30,2');
    Route::delete('/postdeletefileprojekloadingmachinekeseluruhanplant2/{file:url_unique}', [ControllerPPICPlant2::class, 'PostDeleteFileProjekLoadingMachineKeseluruhanPlant2'])->middleware('throttle:30,2');
    Route::patch('/postubahdatafileprojekloadingmachinekeseluruhanplant2/{file:url_unique}', [ControllerPPICPlant2::class, 'PostUbahDataFileProjekLoadingMachineKeseluruhanPlant2PLNT2'])->middleware('throttle:30,2');
    Route::post('/posttambahdatafileprojekloadingmachinepermachineplant2/plnt2/{data:url_unique}', [ControllerPPICPlant2::class, 'PostTambahDataFileProjekLoadingMachinePerMachinePlant2PLANT2'])->middleware('throttle:30,2');
    Route::get('/lihatdatafileprojekloadingmachinepermachineplant2/plnt2/{data:url_unique}', [ControllerPPICPlant2::class, 'LihatDataFileProjekLoadingMachinePerMachinePlant2PLNT2']);
    Route::post('/posttambahdatafileprojekloadingmesinpermesinplant2/plant2/{data:url_unique}', [ControllerPPICPlant2::class, 'PostTambahDataFileProjekLoadingMesinPerMesinPlant2PLANT2'])->middleware('throttle:30,2');
    Route::delete('/postdeletedatafileprojekloadingmachinepermachineplant2/plnt2/{file:url_unique}', [ControllerPPICPlant2::class, 'PostDeleteDataFileProjekLoadingMachinePerMachinePlant2PLNT2'])->middleware('throttle:30,2');
    Route::patch('/postubahdatafileprojekloadingmachinepermachineplant2/plnt2/{file:url_unique}', [ControllerPPICPlant2::class, 'PostUbahDataFileProjekLoadingMachinePerMachinePlant2PLNT2'])->middleware('throttle:30,2');



    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE LIHAT DATA KESELURUHAN LOADING MACHINE PLANT 2 PLNT2

    Route::get('/exportpdfstartdateenddatelihatdatakeseluruhanloadingmachineplant2/plnt2', [ControllerPPICPlant2::class, 'ExportPDFStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant2PLNT2']);
    Route::get('/exportexcelstartdateenddatelihatdatakeseluruhanloadingmachineplant2/plnt2', [ControllerPPICPlant2::class, 'ExportExcelStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant2PLNT2']);
    Route::get('/exportpdffilterdonenotdonelihatdatakeseluruhanloadingmachineplant2/plnt2', [ControllerPPICPlant2::class, 'ExportPDFFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant2PLNT2']);
    Route::get('/exportexcelfilterdonenotdonelihatdatakeseluruhanloadingmachineplant2/plnt2', [ControllerPPICPlant2::class, 'ExportExcelFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant2PLNT2']);


    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE LIHAT SEMUA DATA DETAIL LOADING MACHINE PLANT2 PLN 2

    Route::get('/exportpdfstartdateenddatelihatsemuadatadetailloadingmachineplant2/plnt2/{mesin:url_unique_mesin}', [ControllerPPICPlant2::class, 'ExportPDFStartDatEndDateLihatSemuaDataDetailLoadingMachinePlant2PLNT2']);
    Route::get('/exportexcelstartdateenddatelihatsemuadatadetailloadingmachineplant2/plnt2/{mesin:url_unique_mesin}', [ControllerPPICPlant2::class, 'ExportExcelStartDateEndDateLihatSemuaDataDetailLoadingMachinePlant2PLNT2']);
    Route::get('/exportpdffilterdonenotdonelihatsemuadatadetailloadingmachineplant2PLN2/plnt2/{mesin:url_unique_mesin}', [ControllerPPICPlant2::class, 'ExportPDFFilterDoneNotDoneLihatSemuaDataDetailLoadingMachinePlant2PLN2']);
    Route::get('/exportexcelfilterdonenotdonelihatsemuadatadetailloadingmachineplant2PLN2/plnt2/{mesin:url_unique_mesin}', [ControllerPPICPlant2::class, 'ExportExcelFilterDoneNotDoneLihatSemuaDataDetailLoadingMachinePlant2PLN2']);



    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE LIHAT DATA KESELURUHAN LOADING MACHINE PLANT1 PLANT2 

    Route::get('/exportpdfstartdateenddatelihatdatakeseluruhanloadingmachineplant1/plnt2', [ControllerPPICPlant2::class, 'ExportPDFStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant1PLANT2']);
    Route::get('/exportexcelstartdateenddatelihatdatakeseluruhanloadingmachineplant1/plnt2', [ControllerPPICPlant2::class, 'ExportExcelStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant1PLANT2']);
    Route::get('/exportpdffilterdonenotdonelihatdatakeseluruhanloadingmachineplant1/PLANT2', [ControllerPPICPlant2::class, 'ExportPDFFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant1PLANT2']);
    Route::get('/exportexcelfilterdonenotdonelihatdatakeseluruhanloadingmachineplant1/PLANT2', [ControllerPPICPlant2::class, 'ExportExcelFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant1PLANT2']);


    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE lihatsemuadatadetailloadingmesinpermesinplant1 plant 2

    Route::get('/exportpdfstartdateenddatelihatsemuadatadetailloadingmesinpermesinplant1/plant2/{mesin:url_unique_mesin}', [ControllerPPICPlant2::class, 'ExportPDFStartDateEndDateLihatSemuaDataDetailLoadingMesinPerMesinPlant1PLANT2']);
    Route::get('/exportexcelstartdateenddatelihatsemuadatadetailloadingmesinpermesinplant1/plant2/{mesin:url_unique_mesin}', [ControllerPPICPlant2::class, 'ExportExcelStartDateEndDateLihatSemuaDataDetailLoadingMesinPerMesinPlant1PLANT2']);
    Route::get('/exportpdffilterdonenotdonelihatsemuadatadetailloadingmesinpermesinplant1/plant2/{mesin:url_unique_mesin}', [ControllerPPICPlant2::class, 'ExportPDFFilterDoneNotDoneLihatSemuaDataDetailLoadingMesinPerMesinPlant1PLANT2']);
    Route::get('/exportexcelfilterdonenotdonelihatsemuadatadetailloadingmesinpermesinplant1/plant2/{mesin:url_unique_mesin}', [ControllerPPICPlant2::class, 'ExportExcelFilterDoneNotDoneLihatSemuaDataDetailLoadingMesinPerMesinPlant1PLANT2']);


    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE lihatdatakeseluruhanloadingmesinplant3 plant2


    Route::get('/exportpdfstartdateenddatelihatdatakeseluruhanloadingmachineplant3/plant2', [ControllerPPICPlant2::class, 'ExportPDFStartDateEndDatelLihatDataKeseluruhanLoadingMachinePlant3PLANT2']);
    Route::get('/exportexcelstartdateenddatelihatdatakeseluruhanloadingmachineplant3/plant2', [ControllerPPICPlant2::class, 'ExportExcelStartDateEndDatelLihatDataKeseluruhanLoadingMachinePlant3PLANT2']);
    Route::get('/exportpdffilterdonenotdonelihatdatakeseluruhanloadingmachineplant3/plant2', [ControllerPPICPlant2::class, 'ExportPDFFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant3PLANT2']);
    Route::get('/exportexcelfilterdonenotdonelihatdatakeseluruhanloadingmachineplant3/plant2', [ControllerPPICPlant2::class, 'ExportExcelFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant3PLANT2']);


    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE lihatsemuadatadetailloadingmachinepermachineplant3 plant2

    Route::get('/exportpdfstartdateenddatelihatsemuadatadetailloadingmachinepermachineplant3/plant2/{mesin:url_unique_mesin}', [ControllerPPICPlant2::class, 'ExportPDFStartDateEndDateLihatSemuaDataDetailLoadingMachinePerMachinePlant3PLANT2']);
    Route::get('/exportexcelstartdateenddatelihatsemuadatadetailloadingmachinepermachineplant3/plant2/{mesin:url_unique_mesin}', [ControllerPPICPlant2::class, 'ExportExcelStartDateEndDateLihatSemuaDataDetailLoadingMachinePerMachinePlant3PLANT2']);
    Route::get('/exportpdffilterdonenotdonelihatsemuadatadetailloadingmachinepermachineplant3/plant2/{mesin:url_unique_mesin}', [ControllerPPICPlant2::class, 'ExportPDFFilterDoneNotDoneLihatSemuaDataDetailLoadingMachinePerMachinePlant3PLANT2']);
    Route::get('/exportexcelfilterdonenotdonelihatsemuadatadetailloadingmachinepermachineplant3/plant2/{mesin:url_unique_mesin}', [ControllerPPICPlant2::class, 'ExportExcelFilterDoneNotDoneLihatSemuaDataDetailLoadingMachinePerMachinePlant3PLANT2']);
});
