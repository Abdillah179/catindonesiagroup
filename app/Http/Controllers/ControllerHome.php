<?php

namespace App\Http\Controllers;

use App\Helpers\HtmlPurifierHelper;
use App\Models\tb_data_loading_machine_plant1;
use App\Models\tb_data_loading_machine_plant2;
use App\Models\tb_data_loading_machine_plant3;
use App\Models\tb_data_mesin;
use App\Models\tb_data_mesin_plant_2;
use App\Models\tb_data_mesin_plant_3;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Colors\Rgb\Channels\Red;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ControllerHome extends Controller
{
    public function Home()
    {
        return view('Halaman_Homee', [
            'judul' => 'Home'
        ]);
    }

    // public function TentangKami()
    // {
    //     return view('Halaman_Tentang_Kami', [
    //         'judul' => 'Tentang Kami'
    //     ]);
    // }

    // public function LihatDataLoadingMachinePlant1Home()
    // {

    //     return view('Home.Halaman_Lihat_Data_Loading_Machine_Plant_1', [
    //         'judul' => 'Halaman Lihat Data Loading Machine Plant 1'
    //     ]);
    // }

    // public function LihatDataLoadingMachinePerMachineHomePlant1()
    // {
    //     return view('Home.Halaman_Lihat_Data_Loading_Machine_Per_Machine_Home_Plant_1', [
    //         'judul' => 'Lihat Data Loading Machine Plant 1 Per Machine',
    //         'datamesin' => tb_data_mesin::all()
    //     ]);
    // }

    // public function DetailDataLoadingMachinePlant1PerMachineHome(tb_data_mesin $mesin, Request $request)
    // {
    //     $dataloadingmachineplant1 = tb_data_loading_machine_plant1::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

    //     if ($request->has('search')) {

    //         $search = $request->input('search');

    //         $dataloadingmachineplant1->where(function ($query) use ($search) {
    //             $query->where('plant', 'like', '%' . $search . '%')
    //                 ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
    //                 ->orwhere('project', 'like', '%' .  $search . '%')
    //                 ->orwhere('customer', 'like', '%' .  $search . '%')
    //                 ->orwhere('no_spk', 'like', '%' .  $search . '%')
    //                 ->orWhere('qty', 'like', '%' .  $search . '%')
    //                 ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('actual_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('start', 'like', '%' .  $search . '%')
    //                 ->orWhere('target_finish', 'like', '%' .  $search . '%')
    //                 ->orWhere('priority', 'like', '%' .  $search . '%')
    //                 ->orWhere('on_proses', 'like', '%' .  $search . '%')
    //                 ->orWhere('operator', 'like', '%' .  $search . '%')
    //                 ->orWhere('keterangan', 'like', '%' .  $search . '%')
    //                 ->orWhere('status_done', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
    //                 ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
    //         });
    //     }

    //     $dataloadingmachineplant1count = $dataloadingmachineplant1->count();

    //     $dataloadingmesinplnt1 = $dataloadingmachineplant1->paginate(10)->WithQueryString();

    //     return view('Home.Halaman_Detail_Data_Loading_Machine_Plant_1_Per_Machine_Home', [
    //         'judul' => 'Detail Data Loading Machine',
    //         'dataloadingmachine' => $dataloadingmesinplnt1,
    //         'mesin' => $mesin,
    //         'dataloadingmesincount' => $dataloadingmachineplant1count
    //     ]);
    // }

    // public function ExportPDFDataLoadingMachinePerMachinePlant1Home(tb_data_mesin $mesin, Request $request)
    // {

    //     $dataloadingmesinplant1 = tb_data_loading_machine_plant1::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

    //     if ($request->has('search')) {

    //         $search = $request->input('search');

    //         $dataloadingmesinplant1->where(function ($query) use ($search) {
    //             $query->where('plant', 'like', '%' . $search . '%')
    //                 ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
    //                 ->orwhere('project', 'like', '%' .  $search . '%')
    //                 ->orwhere('customer', 'like', '%' .  $search . '%')
    //                 ->orwhere('no_spk', 'like', '%' .  $search . '%')
    //                 ->orWhere('qty', 'like', '%' .  $search . '%')
    //                 ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('actual_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('start', 'like', '%' .  $search . '%')
    //                 ->orWhere('target_finish', 'like', '%' .  $search . '%')
    //                 ->orWhere('priority', 'like', '%' .  $search . '%')
    //                 ->orWhere('on_proses', 'like', '%' .  $search . '%')
    //                 ->orWhere('operator', 'like', '%' .  $search . '%')
    //                 ->orWhere('keterangan', 'like', '%' .  $search . '%')
    //                 ->orWhere('status_done', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
    //                 ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
    //         });
    //     }

    //     $dataloadingmesinplant1count = $dataloadingmesinplant1->count();

    //     $dataloadingmachineplant1 = $dataloadingmesinplant1->get();

    //     $pdf = PDF::loadView('Home.Export_PDF_Data_Loading_Machine_Plant_1_Home', ['data' => $dataloadingmachineplant1, 'count' => $dataloadingmesinplant1count, 'mesin' => $mesin])
    //         ->setPaper('a4', 'landscape');

    //     return $pdf->download('loading_mesin_plant_1.pdf');
    // }

    // public function LihatDataKeseluruhanLoadingMachinePlant1Home(Request $request)
    // {

    //     $dataloadingmesinplant1 = tb_data_loading_machine_plant1::whereNull('deleted_at');

    //     if ($request->has('search')) {

    //         $search = $request->input('search');

    //         $dataloadingmesinplant1->where(function ($query) use ($search) {
    //             $query->where('plant', 'like', '%' . $search . '%')
    //                 ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
    //                 ->orwhere('project', 'like', '%' .  $search . '%')
    //                 ->orwhere('customer', 'like', '%' .  $search . '%')
    //                 ->orwhere('no_spk', 'like', '%' .  $search . '%')
    //                 ->orWhere('qty', 'like', '%' .  $search . '%')
    //                 ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('actual_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('start', 'like', '%' .  $search . '%')
    //                 ->orWhere('target_finish', 'like', '%' .  $search . '%')
    //                 ->orWhere('priority', 'like', '%' .  $search . '%')
    //                 ->orWhere('on_proses', 'like', '%' .  $search . '%')
    //                 ->orWhere('operator', 'like', '%' .  $search . '%')
    //                 ->orWhere('keterangan', 'like', '%' .  $search . '%')
    //                 ->orWhere('status_done', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
    //                 ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
    //         });
    //     }

    //     $dataloadingmachinecount = $dataloadingmesinplant1->count();

    //     $dataloadingmachine = $dataloadingmesinplant1->paginate(10)->WithQueryString();

    //     return view('Home.Halaman_Lihat_Data_Keseluruhan_Loading_Machine_Plant_1_Home', [
    //         'judul' => 'Halaman Lihat Data Keseluruhan Loading Machine Plant 1',
    //         'dataloadingmachineplant1' => $dataloadingmachine,
    //         'dataloadingmachineplant1count' => $dataloadingmachinecount
    //     ]);
    // }

    // public function ExportPDFDataKeseluruhanLoadingMachinePerMachinePlant1Home(Request $request)
    // {

    //     $dataloadingmachineplant1 = tb_data_loading_machine_plant1::whereNull('deleted_at');

    //     if ($request->has('search')) {

    //         $search = $request->input('search');

    //         $dataloadingmachineplant1->where(function ($query) use ($search) {
    //             $query->where('plant', 'like', '%' . $search . '%')
    //                 ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
    //                 ->orwhere('project', 'like', '%' .  $search . '%')
    //                 ->orwhere('customer', 'like', '%' .  $search . '%')
    //                 ->orwhere('no_spk', 'like', '%' .  $search . '%')
    //                 ->orWhere('qty', 'like', '%' .  $search . '%')
    //                 ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('actual_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('start', 'like', '%' .  $search . '%')
    //                 ->orWhere('target_finish', 'like', '%' .  $search . '%')
    //                 ->orWhere('priority', 'like', '%' .  $search . '%')
    //                 ->orWhere('on_proses', 'like', '%' .  $search . '%')
    //                 ->orWhere('operator', 'like', '%' .  $search . '%')
    //                 ->orWhere('keterangan', 'like', '%' .  $search . '%')
    //                 ->orWhere('status_done', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
    //                 ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
    //         });
    //     }


    //     $dataloadingmesinplant1count = $dataloadingmachineplant1->count();

    //     $dataloadingmesinplant1 = $dataloadingmachineplant1->get();

    //     $pdf = PDF::loadView('Home.Export_PDF_Data_Keseluruhan_Loading_Machine_Plant_1_Home', ['data' => $dataloadingmesinplant1, 'count' => $dataloadingmesinplant1count,])
    //         ->setPaper('a4', 'landscape');

    //     return $pdf->download('loading_mesin_plant_1.pdf');
    // }

    // public function LihatDataLoadingMachinePlant2Home()
    // {

    //     return view('Home.Halaman_Lihat_Data_Loading_Machine_Plant_2_Home', [
    //         'judul' => 'Halaman Lihat Data Loading Machine Plant 2'
    //     ]);
    // }

    // public function LihatDataLoadingMachinePerMachinePlant2Home()
    // {

    //     return view('Home.Halaman_Lihat_Data_Loading_Machine_Per_Machine_Plant_2_Home', [
    //         'judul' => 'Halaman Lihat Data Loading Machine Plant 2',
    //         'datamesin' => tb_data_mesin_plant_2::all()
    //     ]);
    // }

    // public function DetailDataLoadingMesinPlant2PerMesinHome(tb_data_mesin_plant_2 $mesin, Request $request)
    // {
    //     $dataloadingmachineplant2 = tb_data_loading_machine_plant2::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

    //     if ($request->has('search')) {

    //         $search = $request->input('search');

    //         $dataloadingmachineplant2->where(function ($query) use ($search) {

    //             $query->where('plant', 'like', '%' . $search . '%')
    //                 ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
    //                 ->orwhere('project', 'like', '%' .  $search . '%')
    //                 ->orwhere('customer', 'like', '%' .  $search . '%')
    //                 ->orwhere('no_spk', 'like', '%' .  $search . '%')
    //                 ->orWhere('qty', 'like', '%' .  $search . '%')
    //                 ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('actual_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('start', 'like', '%' .  $search . '%')
    //                 ->orWhere('target_finish', 'like', '%' .  $search . '%')
    //                 ->orWhere('priority', 'like', '%' .  $search . '%')
    //                 ->orWhere('on_proses', 'like', '%' .  $search . '%')
    //                 ->orWhere('operator', 'like', '%' .  $search . '%')
    //                 ->orWhere('keterangan', 'like', '%' .  $search . '%')
    //                 ->orWhere('status_done', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
    //                 ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
    //         });
    //     }

    //     $dataloadingmesinplant2count = $dataloadingmachineplant2->count();

    //     $dataloadingmesinplant2 = $dataloadingmachineplant2->paginate(10)->WithQueryString();

    //     return view('Home.Halaman_Detail_Data_Loading_Mesin_Plant_2_Per_Mesin_Home', [
    //         'judul' => 'Halaman Detail Data Loading Machine Plant 2',
    //         'dataloadingmachineplant2' => $dataloadingmesinplant2,
    //         'dataloadingmachineplant2count' => $dataloadingmesinplant2count,
    //         'mesin' => $mesin
    //     ]);
    // }

    // public function ExportPDFDataLoadingMachinePerMachinePlant2Home(tb_data_mesin_plant_2 $mesin, Request $request)
    // {

    //     $dataloadingmesinplant2 = tb_data_loading_machine_plant2::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

    //     if ($request->has('search')) {

    //         $search = $request->input('search');

    //         $dataloadingmesinplant2->where(function ($query) use ($search) {

    //             $query->where('plant', 'like', '%' . $search . '%')
    //                 ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
    //                 ->orwhere('project', 'like', '%' .  $search . '%')
    //                 ->orwhere('customer', 'like', '%' .  $search . '%')
    //                 ->orwhere('no_spk', 'like', '%' .  $search . '%')
    //                 ->orWhere('qty', 'like', '%' .  $search . '%')
    //                 ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('actual_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('start', 'like', '%' .  $search . '%')
    //                 ->orWhere('target_finish', 'like', '%' .  $search . '%')
    //                 ->orWhere('priority', 'like', '%' .  $search . '%')
    //                 ->orWhere('on_proses', 'like', '%' .  $search . '%')
    //                 ->orWhere('operator', 'like', '%' .  $search . '%')
    //                 ->orWhere('keterangan', 'like', '%' .  $search . '%')
    //                 ->orWhere('status_done', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
    //                 ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
    //         });
    //     }

    //     $dataloadingmachineplant2count = $dataloadingmesinplant2->count();

    //     $dataloadingmachineplant2 = $dataloadingmesinplant2->get();

    //     $pdf = PDF::loadView('Home.Export_PDF_Data_Loading_Machine_Per_Mesin_Plant_2_Home', ['data' => $dataloadingmachineplant2, 'count' => $dataloadingmachineplant2count, 'mesin' => $mesin])
    //         ->setPaper('a4', 'landscape');

    //     return $pdf->download('loading_mesin_plant_2.pdf');
    // }


    // public function LihatDataKeseluruhanLoadingMachinePlant2Home(Request $request)
    // {
    //     $datakeseluruhanloadingmachineplant2 = tb_data_loading_machine_plant2::whereNull('deleted_at');

    //     if ($request->has('search')) {

    //         $search = $request->input('search');

    //         $datakeseluruhanloadingmachineplant2->where(function ($query) use ($search) {

    //             $query->where('plant', 'like', '%' . $search . '%')
    //                 ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
    //                 ->orwhere('project', 'like', '%' .  $search . '%')
    //                 ->orwhere('customer', 'like', '%' .  $search . '%')
    //                 ->orwhere('no_spk', 'like', '%' .  $search . '%')
    //                 ->orWhere('qty', 'like', '%' .  $search . '%')
    //                 ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('actual_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('start', 'like', '%' .  $search . '%')
    //                 ->orWhere('target_finish', 'like', '%' .  $search . '%')
    //                 ->orWhere('priority', 'like', '%' .  $search . '%')
    //                 ->orWhere('on_proses', 'like', '%' .  $search . '%')
    //                 ->orWhere('operator', 'like', '%' .  $search . '%')
    //                 ->orWhere('keterangan', 'like', '%' .  $search . '%')
    //                 ->orWhere('status_done', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
    //                 ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
    //         });
    //     }

    //     $dataallloadingmachineplant2count = $datakeseluruhanloadingmachineplant2->count();

    //     $dataallloadingmachineplant2 = $datakeseluruhanloadingmachineplant2->paginate(10)->WithQueryString();

    //     return view('Home.Halaman_Lihat_Data_Keseluruhan_Loading_Machine_Plant_2_Home', [
    //         'judul' => 'Halaman Lihat Data Keseluruhan Loading Machine Plant 2',
    //         'datakeseluruhanloadingmachineplant2' => $dataallloadingmachineplant2,
    //         'datakeseluruhanloadingmachineplant2count' => $dataallloadingmachineplant2count,
    //     ]);
    // }

    // public function ExportPDFDataKeseluruhanLoadingMachinePerMachinePlant2Home(Request $request)
    // {

    //     $datakeseluruhanloadingmachineplant2 = tb_data_loading_machine_plant2::whereNull('deleted_at');

    //     if ($request->has('search')) {

    //         $search = $request->input('search');

    //         $datakeseluruhanloadingmachineplant2->where(function ($query) use ($search) {

    //             $query->where('plant', 'like', '%' . $search . '%')
    //                 ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
    //                 ->orwhere('project', 'like', '%' .  $search . '%')
    //                 ->orwhere('customer', 'like', '%' .  $search . '%')
    //                 ->orwhere('no_spk', 'like', '%' .  $search . '%')
    //                 ->orWhere('qty', 'like', '%' .  $search . '%')
    //                 ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('actual_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('start', 'like', '%' .  $search . '%')
    //                 ->orWhere('target_finish', 'like', '%' .  $search . '%')
    //                 ->orWhere('priority', 'like', '%' .  $search . '%')
    //                 ->orWhere('on_proses', 'like', '%' .  $search . '%')
    //                 ->orWhere('operator', 'like', '%' .  $search . '%')
    //                 ->orWhere('keterangan', 'like', '%' .  $search . '%')
    //                 ->orWhere('status_done', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
    //                 ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
    //         });
    //     }

    //     $dataallloadingmachineplant2count = $datakeseluruhanloadingmachineplant2->count();

    //     $dataallloadingmachineplant2 = $datakeseluruhanloadingmachineplant2->get();

    //     $pdf = PDF::loadView('Home.Export_PDF_Data_Keseluruhan_Loading_Machine_Plant_2_Home', ['data' => $dataallloadingmachineplant2, 'count' => $dataallloadingmachineplant2count])
    //         ->setPaper('a4', 'landscape');

    //     return $pdf->download('loading_mesin_plant_2.pdf');
    // }

    // public function LihatDataLoadingMachinePlant3Home()
    // {

    //     return view('Home.Halaman_Lihat_Data_Loading_Machine_Plant_3_Home', [
    //         'judul' => 'Halaman Lihat Data Loading Machine Plant 3'
    //     ]);
    // }

    // public function LihatDataLoadingMachinePerMachinePlant3()
    // {

    //     return view('Home.Halaman_Lihat_Data_Loading_Machine_Per_Machine_Plant_3', [
    //         'judul' => 'Halaman Lihat Data Loading Machine Plant 3',
    //         'datamesin' => tb_data_mesin_plant_3::all()
    //     ]);
    // }

    // public function DetailDataLoadingMachinePlant3PerMachineHome(tb_data_mesin_plant_3 $mesin, Request $request)
    // {

    //     $dataloadingmachineplant3 = tb_data_loading_machine_plant3::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

    //     if ($request->has('search')) {

    //         $search = $request->input('search');

    //         $dataloadingmachineplant3->where(function ($query) use ($search) {
    //             $query->where('plant', 'like', '%' . $search . '%')
    //                 ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
    //                 ->orwhere('project', 'like', '%' .  $search . '%')
    //                 ->orwhere('customer', 'like', '%' .  $search . '%')
    //                 ->orwhere('no_spk', 'like', '%' .  $search . '%')
    //                 ->orWhere('qty', 'like', '%' .  $search . '%')
    //                 ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('actual_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('start', 'like', '%' .  $search . '%')
    //                 ->orWhere('target_finish', 'like', '%' .  $search . '%')
    //                 ->orWhere('priority', 'like', '%' .  $search . '%')
    //                 ->orWhere('on_proses', 'like', '%' .  $search . '%')
    //                 ->orWhere('operator', 'like', '%' .  $search . '%')
    //                 ->orWhere('keterangan', 'like', '%' .  $search . '%')
    //                 ->orWhere('status_done', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
    //                 ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
    //         });
    //     }

    //     $dataloadingmesinplant3count = $dataloadingmachineplant3->count();

    //     $dataloadingmesinplant3 = $dataloadingmachineplant3->paginate(10)->WithQueryString();

    //     return view('Home.Halaman_Detail_Data_Loading_Machine_Plant_3_Per_Machine_Home', [
    //         'judul' => 'Halaman Detail Data Loading Machine Plant 3',
    //         'dataloadingmachineplant3' => $dataloadingmesinplant3,
    //         'dataloadingmachineplant3count' => $dataloadingmesinplant3count,
    //         'mesin' => $mesin
    //     ]);
    // }

    // public function ExportPDFDataLoadingMachinePerMachinePlant3Home(tb_data_mesin_plant_3 $mesin, Request $request)
    // {

    //     $dataloadingmachineplant3 = tb_data_loading_machine_plant3::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

    //     if ($request->has('search')) {

    //         $search = $request->input('search');

    //         $dataloadingmachineplant3->where(function ($query) use ($search) {

    //             $query->where('plant', 'like', '%' . $search . '%')
    //                 ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
    //                 ->orwhere('project', 'like', '%' .  $search . '%')
    //                 ->orwhere('customer', 'like', '%' .  $search . '%')
    //                 ->orwhere('no_spk', 'like', '%' .  $search . '%')
    //                 ->orWhere('qty', 'like', '%' .  $search . '%')
    //                 ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('actual_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('start', 'like', '%' .  $search . '%')
    //                 ->orWhere('target_finish', 'like', '%' .  $search . '%')
    //                 ->orWhere('priority', 'like', '%' .  $search . '%')
    //                 ->orWhere('on_proses', 'like', '%' .  $search . '%')
    //                 ->orWhere('operator', 'like', '%' .  $search . '%')
    //                 ->orWhere('keterangan', 'like', '%' .  $search . '%')
    //                 ->orWhere('status_done', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
    //                 ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
    //         });
    //     }

    //     $dataloadingmesinplant3count = $dataloadingmachineplant3->count();

    //     $dataloadingmesinplant3 = $dataloadingmachineplant3->get();

    //     $pdf = PDF::loadView('Home.Export_PDF_Data_Loading_Machine_Plant_3_Home', ['data' => $dataloadingmesinplant3, 'count' => $dataloadingmesinplant3count, 'mesin' => $mesin])
    //         ->setPaper('a4', 'landscape');

    //     return $pdf->download('loading_mesin_plant_3.pdf');
    // }

    // public function LihatDataKeseluruhanLoadingMachinePlant3Home(Request $request)
    // {

    //     $datakeseluruhanloadingmachineplant3 = tb_data_loading_machine_plant3::whereNull('deleted_at');

    //     if ($request->has('search')) {

    //         $search = $request->input('search');

    //         $datakeseluruhanloadingmachineplant3->where(function ($query) use ($search) {
    //             $query->where('plant', 'like', '%' . $search . '%')
    //                 ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
    //                 ->orwhere('project', 'like', '%' .  $search . '%')
    //                 ->orwhere('customer', 'like', '%' .  $search . '%')
    //                 ->orwhere('no_spk', 'like', '%' .  $search . '%')
    //                 ->orWhere('qty', 'like', '%' .  $search . '%')
    //                 ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('actual_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('start', 'like', '%' .  $search . '%')
    //                 ->orWhere('target_finish', 'like', '%' .  $search . '%')
    //                 ->orWhere('priority', 'like', '%' .  $search . '%')
    //                 ->orWhere('on_proses', 'like', '%' .  $search . '%')
    //                 ->orWhere('operator', 'like', '%' .  $search . '%')
    //                 ->orWhere('keterangan', 'like', '%' .  $search . '%')
    //                 ->orWhere('status_done', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
    //                 ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
    //         });
    //     }

    //     $dataloadingmesinplant3count = $datakeseluruhanloadingmachineplant3->count();

    //     $dataloadingmesinplant3 = $datakeseluruhanloadingmachineplant3->paginate(10)->WithQueryString();

    //     return view('Home.Halaman_Lihat_Data_Keseluruhan_Loading_Machine_Plant_3_Home', [
    //         'judul' => 'Halaman Lihat Data Keseluruhan Loading Machine Plant 3',
    //         'dataloadingmachineplant3' => $dataloadingmesinplant3,
    //         'dataloadingmachineplant3count' => $dataloadingmesinplant3count
    //     ]);
    // }

    // public function ExportPDFDataKeseluruhanLoadingMachinePerMachinePlant3Home(Request $request)
    // {

    //     $datakeseluruhanloadingmachineplant3 = tb_data_loading_machine_plant3::whereNull('deleted_at');

    //     if ($request->has('search')) {

    //         $search = $request->input('search');

    //         $datakeseluruhanloadingmachineplant3->where(function ($query) use ($search) {
    //             $query->where('plant', 'like', '%' . $search . '%')
    //                 ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
    //                 ->orwhere('project', 'like', '%' .  $search . '%')
    //                 ->orwhere('customer', 'like', '%' .  $search . '%')
    //                 ->orwhere('no_spk', 'like', '%' .  $search . '%')
    //                 ->orWhere('qty', 'like', '%' .  $search . '%')
    //                 ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('actual_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('start', 'like', '%' .  $search . '%')
    //                 ->orWhere('target_finish', 'like', '%' .  $search . '%')
    //                 ->orWhere('priority', 'like', '%' .  $search . '%')
    //                 ->orWhere('on_proses', 'like', '%' .  $search . '%')
    //                 ->orWhere('operator', 'like', '%' .  $search . '%')
    //                 ->orWhere('keterangan', 'like', '%' .  $search . '%')
    //                 ->orWhere('status_done', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
    //                 ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
    //         });
    //     }

    //     $dataallloadingmesinplant3count = $datakeseluruhanloadingmachineplant3->count();

    //     $dataallloadingmesinplant3 = $datakeseluruhanloadingmachineplant3->get();

    //     $pdf = PDF::loadView('Home.Export_PDF_Data_Keseluruhan_Loading_Machine_Plant_3_Home', ['data' => $dataallloadingmesinplant3, 'count' => $dataallloadingmesinplant3count])
    //         ->setPaper('a4', 'landscape');

    //     return $pdf->download('loading_mesin_plant_3.pdf');
    // }
    
    // public function ExportExcelDataLoadingMachinePerMachinePlant1Home(tb_data_mesin $mesin, Request $request)
    // {
    //     $dataloadingmesinplant1 = tb_data_loading_machine_plant1::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

    //     if ($request->has('search')) {

    //         $search = $request->input('search');

    //         $dataloadingmesinplant1->where(function ($query) use ($search) {
    //             $query->where('plant', 'like', '%' . $search . '%')
    //                 ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
    //                 ->orwhere('project', 'like', '%' .  $search . '%')
    //                 ->orwhere('customer', 'like', '%' .  $search . '%')
    //                 ->orwhere('no_spk', 'like', '%' .  $search . '%')
    //                 ->orWhere('qty', 'like', '%' .  $search . '%')
    //                 ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('actual_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('start', 'like', '%' .  $search . '%')
    //                 ->orWhere('target_finish', 'like', '%' .  $search . '%')
    //                 ->orWhere('priority', 'like', '%' .  $search . '%')
    //                 ->orWhere('on_proses', 'like', '%' .  $search . '%')
    //                 ->orWhere('operator', 'like', '%' .  $search . '%')
    //                 ->orWhere('keterangan', 'like', '%' .  $search . '%')
    //                 ->orWhere('status_done', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
    //                 ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
    //         });
    //     }

    //     $dataloadingmesin = $dataloadingmesinplant1->get();

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     $selectedColumns = [
    //         'plant' => 'Plant',
    //         'nama_mesin' => 'Nama Mesin/Proses',
    //         'status_done' => 'Status Done',
    //         'project' => 'Project',
    //         'customer' => 'Customer',
    //         'no_spk' => 'No SPK',
    //         'qty' => 'QTY',
    //         'estimasi_jam' => 'Estimasi Jam',
    //         'actual_jam' => 'Actual Jam',
    //         'start' => 'Start',
    //         'target_finish' => 'Target Finish',
    //         'priority' => 'Priority',
    //         'on_proses' => 'On Proses',
    //         'operator' => 'Operator',
    //         'keterangan' => 'Keterangan'
    //     ];

    //     $columnIndex = 'A';
    //     foreach ($selectedColumns as $columnKey => $columnHeader) {
    //         $sheet->setCellValue($columnIndex . '1', $columnHeader);
    //         $columnIndex++;
    //     }

    //     $row = 2;
    //     foreach ($dataloadingmesin as $item) {
    //         $columnIndex = 'A';
    //         foreach ($selectedColumns as $columnKey => $columnHeader) {
    //             if (isset($item[$columnKey])) {
    //                 $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
    //             } else {
    //                 $sheet->setCellValue($columnIndex . $row, '');
    //             }
    //             $columnIndex++;
    //         }
    //         $row++;
    //     }

    //     $writer = new Xlsx($spreadsheet);
    //     $filePath = storage_path('app/public/exported_data.xlsx');
    //     $writer->save($filePath);

    //     return response()->download($filePath)->deleteFileAfterSend();
    // }
    
    // public function ExportExcelDataKeseluruhanLoadingMachinePlant1Home(Request $request)
    // {

    //     $datakeseluruhanloadingmachineplant1home = tb_data_loading_machine_plant1::whereNull('deleted_at');

    //     if ($request->has('search')) {

    //         $search = $request->input('search');

    //         $datakeseluruhanloadingmachineplant1home->where(function ($query) use ($search) {
    //             $query->where('plant', 'like', '%' . $search . '%')
    //                 ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
    //                 ->orwhere('project', 'like', '%' .  $search . '%')
    //                 ->orwhere('customer', 'like', '%' .  $search . '%')
    //                 ->orwhere('no_spk', 'like', '%' .  $search . '%')
    //                 ->orWhere('qty', 'like', '%' .  $search . '%')
    //                 ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('actual_jam', 'like', '%' .  $search . '%')
    //                 ->orWhere('start', 'like', '%' .  $search . '%')
    //                 ->orWhere('target_finish', 'like', '%' .  $search . '%')
    //                 ->orWhere('priority', 'like', '%' .  $search . '%')
    //                 ->orWhere('on_proses', 'like', '%' .  $search . '%')
    //                 ->orWhere('operator', 'like', '%' .  $search . '%')
    //                 ->orWhere('keterangan', 'like', '%' .  $search . '%')
    //                 ->orWhere('status_done', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
    //                 ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
    //                 ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
    //         });
    //     }

    //     $dataloadingmachineplant1 = $datakeseluruhanloadingmachineplant1home->get();


    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     $selectedColumns = [
    //         'plant' => 'Plant',
    //         'nama_mesin' => 'Nama Mesin/Proses',
    //         'status_done' => 'Status Done',
    //         'project' => 'Project',
    //         'customer' => 'Customer',
    //         'no_spk' => 'No SPK',
    //         'qty' => 'QTY',
    //         'estimasi_jam' => 'Estimasi Jam',
    //         'actual_jam' => 'Actual Jam',
    //         'start' => 'Start',
    //         'target_finish' => 'Target Finish',
    //         'priority' => 'Priority',
    //         'on_proses' => 'On Proses',
    //         'operator' => 'Operator',
    //         'keterangan' => 'Keterangan'
    //     ];

    //     $columnIndex = 'A';
    //     foreach ($selectedColumns as $columnKey => $columnHeader) {
    //         $sheet->setCellValue($columnIndex . '1', $columnHeader);
    //         $columnIndex++;
    //     }

    //     $row = 2;
    //     foreach ($dataloadingmachineplant1 as $item) {
    //         $columnIndex = 'A';
    //         foreach ($selectedColumns as $columnKey => $columnHeader) {
    //             if (isset($item[$columnKey])) {
    //                 $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
    //             } else {
    //                 $sheet->setCellValue($columnIndex . $row, '');
    //             }
    //             $columnIndex++;
    //         }
    //         $row++;
    //     }

    //     $writer = new Xlsx($spreadsheet);
    //     $filePath = storage_path('app/public/exported_data.xlsx');
    //     $writer->save($filePath);

    //     return response()->download($filePath)->deleteFileAfterSend();
    // }
    
    // public function ExportExcelDataLoadingMachinePerMachinePlant2Home(tb_data_mesin_plant_2 $mesin, Request $request)
    // {

    //     $dataloadingmesinplant2 = tb_data_loading_machine_plant2::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

    //     if ($request->has('search')) {

    //         $search = $request->input('search');

    //         $dataloadingmesinplant2->where(function ($query) use ($search) {
    //             $query->where('plant', 'like', '%' . $search . '%')
    //                 ->orwhere('nama_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('project', 'like', '%' . $search . '%')
    //                 ->orwhere('customer', 'like', '%' . $search . '%')
    //                 ->orwhere('no_spk', 'like', '%' . $search . '%')
    //                 ->orwhere('qty', 'like', '%' . $search . '%')
    //                 ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
    //                 ->orwhere('actual_jam', 'like', '%' . $search . '%')
    //                 ->orwhere('start', 'like', '%' . $search . '%')
    //                 ->orwhere('target_finish', 'like', '%' . $search . '%')
    //                 ->orwhere('priority', 'like', '%' . $search . '%')
    //                 ->orwhere('on_proses', 'like', '%' . $search . '%')
    //                 ->orwhere('operator', 'like', '%' . $search . '%')
    //                 ->orwhere('keterangan', 'like', '%' . $search . '%')
    //                 ->orwhere('status_done', 'like', '%' . $search . '%')
    //                 ->orwhere('tanggal_input', 'like', '%' . $search . '%')
    //                 ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
    //                 ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
    //         });
    //     }

    //     $dataloadingmachineplant2 = $dataloadingmesinplant2->get();

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     $selectedColumns = [
    //         'plant' => 'Plant',
    //         'nama_mesin' => 'Nama Mesin/Proses',
    //         'status_done' => 'Status Done',
    //         'project' => 'Project',
    //         'customer' => 'Customer',
    //         'no_spk' => 'No SPK',
    //         'qty' => 'QTY',
    //         'estimasi_jam' => 'Estimasi Jam',
    //         'actual_jam' => 'Actual Jam',
    //         'start' => 'Start',
    //         'target_finish' => 'Target Finish',
    //         'priority' => 'Priority',
    //         'on_proses' => 'On Proses',
    //         'operator' => 'Operator',
    //         'keterangan' => 'Keterangan'
    //     ];

    //     $columnIndex = 'A';
    //     foreach ($selectedColumns as $columnKey => $columnHeader) {
    //         $sheet->setCellValue($columnIndex . '1', $columnHeader);
    //         $columnIndex++;
    //     }

    //     $row = 2;
    //     foreach ($dataloadingmachineplant2 as $item) {
    //         $columnIndex = 'A';
    //         foreach ($selectedColumns as $columnKey => $columnHeader) {
    //             if (isset($item[$columnKey])) {
    //                 $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
    //             } else {
    //                 $sheet->setCellValue($columnIndex . $row, '');
    //             }
    //             $columnIndex++;
    //         }
    //         $row++;
    //     }

    //     $writer = new Xlsx($spreadsheet);
    //     $filePath = storage_path('app/public/exported_data.xlsx');
    //     $writer->save($filePath);

    //     return response()->download($filePath)->deleteFileAfterSend();
    // }
    
    // public function ExportExcelDataKeseluruhanLoadingMachinePlant2Home(Request $request)
    // {

    //     $datakeseluruhanloadingmachineplant2home = tb_data_loading_machine_plant2::whereNull('deleted_at');

    //     if ($request->has('search')) {

    //         $search = $request->input('search');

    //         $datakeseluruhanloadingmachineplant2home->where(function ($query) use ($search) {
    //             $query->where('plant', 'like', '%' . $search . '%')
    //                 ->orwhere('nama_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('project', 'like', '%' . $search . '%')
    //                 ->orwhere('customer', 'like', '%' . $search . '%')
    //                 ->orwhere('no_spk', 'like', '%' . $search . '%')
    //                 ->orwhere('qty', 'like', '%' . $search . '%')
    //                 ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
    //                 ->orwhere('actual_jam', 'like', '%' . $search . '%')
    //                 ->orwhere('start', 'like', '%' . $search . '%')
    //                 ->orwhere('target_finish', 'like', '%' . $search . '%')
    //                 ->orwhere('priority', 'like', '%' . $search . '%')
    //                 ->orwhere('on_proses', 'like', '%' . $search . '%')
    //                 ->orwhere('operator', 'like', '%' . $search . '%')
    //                 ->orwhere('keterangan', 'like', '%' . $search . '%')
    //                 ->orwhere('status_done', 'like', '%' . $search . '%')
    //                 ->orwhere('tanggal_input', 'like', '%' . $search . '%')
    //                 ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
    //                 ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
    //         });
    //     }

    //     $datakeseluruhanloadingmachineplant2 = $datakeseluruhanloadingmachineplant2home->get();

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     $selectedColumns = [
    //         'plant' => 'Plant',
    //         'nama_mesin' => 'Nama Mesin/Proses',
    //         'status_done' => 'Status Done',
    //         'project' => 'Project',
    //         'customer' => 'Customer',
    //         'no_spk' => 'No SPK',
    //         'qty' => 'QTY',
    //         'estimasi_jam' => 'Estimasi Jam',
    //         'actual_jam' => 'Actual Jam',
    //         'start' => 'Start',
    //         'target_finish' => 'Target Finish',
    //         'priority' => 'Priority',
    //         'on_proses' => 'On Proses',
    //         'operator' => 'Operator',
    //         'keterangan' => 'Keterangan'
    //     ];

    //     $columnIndex = 'A';
    //     foreach ($selectedColumns as $columnKey => $columnHeader) {
    //         $sheet->setCellValue($columnIndex . '1', $columnHeader);
    //         $columnIndex++;
    //     }

    //     $row = 2;
    //     foreach ($datakeseluruhanloadingmachineplant2 as $item) {
    //         $columnIndex = 'A';
    //         foreach ($selectedColumns as $columnKey => $columnHeader) {
    //             if (isset($item[$columnKey])) {
    //                 $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
    //             } else {
    //                 $sheet->setCellValue($columnIndex . $row, '');
    //             }
    //             $columnIndex++;
    //         }
    //         $row++;
    //     }

    //     $writer = new Xlsx($spreadsheet);
    //     $filePath = storage_path('app/public/exported_data.xlsx');
    //     $writer->save($filePath);

    //     return response()->download($filePath)->deleteFileAfterSend();
    // }
    
    // public function ExportExcelDataLoadingMachinePermachinePlant3Home(tb_data_mesin_plant_3 $mesin, Request $request)
    // {

    //     $dataloadingmachineplant3 = tb_data_loading_machine_plant3::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

    //     if ($request->has('search')) {

    //         $search = $request->input('search');

    //         $dataloadingmachineplant3->where(function ($query) use ($search) {
    //             $query->where('plant', 'like', '%' . $search . '%')
    //                 ->orwhere('nama_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('project', 'like', '%' . $search . '%')
    //                 ->orwhere('customer', 'like', '%' . $search . '%')
    //                 ->orwhere('no_spk', 'like', '%' . $search . '%')
    //                 ->orwhere('qty', 'like', '%' . $search . '%')
    //                 ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
    //                 ->orwhere('actual_jam', 'like', '%' . $search . '%')
    //                 ->orwhere('start', 'like', '%' . $search . '%')
    //                 ->orwhere('target_finish', 'like', '%' . $search . '%')
    //                 ->orwhere('priority', 'like', '%' . $search . '%')
    //                 ->orwhere('on_proses', 'like', '%' . $search . '%')
    //                 ->orwhere('operator', 'like', '%' . $search . '%')
    //                 ->orwhere('keterangan', 'like', '%' . $search . '%')
    //                 ->orwhere('status_done', 'like', '%' . $search . '%')
    //                 ->orwhere('tanggal_input', 'like', '%' . $search . '%')
    //                 ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
    //                 ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
    //         });
    //     }

    //     $dataloadingmachineplant3permesin = $dataloadingmachineplant3->get();

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     $selectedColumns = [
    //         'plant' => 'Plant',
    //         'nama_mesin' => 'Nama Mesin/Proses',
    //         'status_done' => 'Status Done',
    //         'project' => 'Project',
    //         'customer' => 'Customer',
    //         'no_spk' => 'No SPK',
    //         'qty' => 'QTY',
    //         'estimasi_jam' => 'Estimasi Jam',
    //         'actual_jam' => 'Actual Jam',
    //         'start' => 'Start',
    //         'target_finish' => 'Target Finish',
    //         'priority' => 'Priority',
    //         'on_proses' => 'On Proses',
    //         'operator' => 'Operator',
    //         'keterangan' => 'Keterangan'
    //     ];

    //     $columnIndex = 'A';
    //     foreach ($selectedColumns as $columnKey => $columnHeader) {
    //         $sheet->setCellValue($columnIndex . '1', $columnHeader);
    //         $columnIndex++;
    //     }

    //     $row = 2;
    //     foreach ($dataloadingmachineplant3permesin as $item) {
    //         $columnIndex = 'A';
    //         foreach ($selectedColumns as $columnKey => $columnHeader) {
    //             if (isset($item[$columnKey])) {
    //                 $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
    //             } else {
    //                 $sheet->setCellValue($columnIndex . $row, '');
    //             }
    //             $columnIndex++;
    //         }
    //         $row++;
    //     }

    //     $writer = new Xlsx($spreadsheet);
    //     $filePath = storage_path('app/public/exported_data.xlsx');
    //     $writer->save($filePath);

    //     return response()->download($filePath)->deleteFileAfterSend();
    // }
    
    // public function ExportExcelDataKeseluruhanLoadingMachinePermachinePlant3Home(Request $request)
    // {

    //     $datakeseluruhanloadingmachineplant3home = tb_data_loading_machine_plant3::whereNull('deleted_at');

    //     if ($request->has('search')) {

    //         $search = $request->input('search');

    //         $datakeseluruhanloadingmachineplant3home->where(function ($query) use ($search) {
    //             $query->where('plant', 'like', '%' . $search . '%')
    //                 ->orwhere('nama_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('project', 'like', '%' . $search . '%')
    //                 ->orwhere('customer', 'like', '%' . $search . '%')
    //                 ->orwhere('no_spk', 'like', '%' . $search . '%')
    //                 ->orwhere('qty', 'like', '%' . $search . '%')
    //                 ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
    //                 ->orwhere('actual_jam', 'like', '%' . $search . '%')
    //                 ->orwhere('start', 'like', '%' . $search . '%')
    //                 ->orwhere('target_finish', 'like', '%' . $search . '%')
    //                 ->orwhere('priority', 'like', '%' . $search . '%')
    //                 ->orwhere('on_proses', 'like', '%' . $search . '%')
    //                 ->orwhere('operator', 'like', '%' . $search . '%')
    //                 ->orwhere('keterangan', 'like', '%' . $search . '%')
    //                 ->orwhere('status_done', 'like', '%' . $search . '%')
    //                 ->orwhere('tanggal_input', 'like', '%' . $search . '%')
    //                 ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
    //                 ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
    //                 ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
    //         });
    //     }

    //     $datakeseluruhanloadingmesinplant3 = $datakeseluruhanloadingmachineplant3home->get();

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     $selectedColumns = [
    //         'plant' => 'Plant',
    //         'nama_mesin' => 'Nama Mesin/Proses',
    //         'status_done' => 'Status Done',
    //         'project' => 'Project',
    //         'customer' => 'Customer',
    //         'no_spk' => 'No SPK',
    //         'qty' => 'QTY',
    //         'estimasi_jam' => 'Estimasi Jam',
    //         'actual_jam' => 'Actual Jam',
    //         'start' => 'Start',
    //         'target_finish' => 'Target Finish',
    //         'priority' => 'Priority',
    //         'on_proses' => 'On Proses',
    //         'operator' => 'Operator',
    //         'keterangan' => 'Keterangan'
    //     ];

    //     $columnIndex = 'A';
    //     foreach ($selectedColumns as $columnKey => $columnHeader) {
    //         $sheet->setCellValue($columnIndex . '1', $columnHeader);
    //         $columnIndex++;
    //     }

    //     $row = 2;
    //     foreach ($datakeseluruhanloadingmesinplant3 as $item) {
    //         $columnIndex = 'A';
    //         foreach ($selectedColumns as $columnKey => $columnHeader) {
    //             if (isset($item[$columnKey])) {
    //                 $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
    //             } else {
    //                 $sheet->setCellValue($columnIndex . $row, '');
    //             }
    //             $columnIndex++;
    //         }
    //         $row++;
    //     }

    //     $writer = new Xlsx($spreadsheet);
    //     $filePath = storage_path('app/public/exported_data.xlsx');
    //     $writer->save($filePath);

    //     return response()->download($filePath)->deleteFileAfterSend();
    // }

}
