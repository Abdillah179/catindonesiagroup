<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\tb_data_spk;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\tb_data_mesin;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Helpers\HtmlPurifierHelper;
use App\Models\file_laporan_loadingmesin_plant_1_stm_plant_3;
use App\Models\laporan_loading_mesin_plant_1_stm_plant_3;
use App\Models\tb_data_comodity_part_item;
use App\Models\tb_data_file_laporan_loading_machine_plant_1;
use App\Models\tb_data_file_projek_loading_machine_plant_1;
use App\Models\tb_data_file_projek_loading_machine_plant_2;
use App\Models\tb_data_file_projek_loading_machine_plant_3;
use App\Models\tb_data_image_drawing;
use App\Models\tb_data_image_drawing_ppic_plant1;
use App\Models\tb_data_image_drawing_ppic_plant2;
use App\Models\tb_data_nama_projek_spk;
use App\Models\tb_data_spk_ppic_plant1;
use App\Models\tb_data_spk_ppic_plant2;
use App\Models\tb_data_spk_ppic_plant3;
use Illuminate\Support\Facades\Storage;
use App\Models\tb_data_item_part_nama_projek;
use App\Models\tb_data_laporan_loading_machine_plant_1;
use App\Models\tb_data_loading_machine_plant1;
use App\Models\tb_data_loading_machine_plant2;
use App\Models\tb_data_loading_machine_plant3;
use App\Models\tb_data_mesin_plant_2;
use App\Models\tb_data_mesin_plant_3;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ControllerPPICPlant2 extends Controller
{
    public function DashboardPPICPlant2()
    {
        return view('UserPPICPlant2.Halaman_Dashboard_PPIC_Plant_2', [
            'judul' => 'Halaman Dashboard PPIC Plant 2'
        ]);
    }

    public function TambahLoadingMachinePlant2PLNT2()
    {
        return view('UserPPICPlant2.Halaman_Tambah_Data_Loading_Mesin_Plant_2', [
            'judul' => 'Halaman Tambah Data Loading Machine',
            'datamesin' => tb_data_mesin_plant_2::all(),
        ]);
    }

    public function PostTambahDataLoadingMesinPPICPlant2PLNT2(Request $request)
    {
        $time = Carbon::now('Asia/Jakarta');

        $request->validate([
            'plant' => 'required|string|max:3000',
            'nama_mesin' => 'required|string|max:3000',
            'project' => 'required|string|max:3000',
            'customer' => 'required|string|max:3000',
            'no_spk' => 'required|string|max:3000',
            'qty' => 'required|string',
            'estimasi_jam' => 'nullable|string|max:3000',
            'actual_jam' => 'nullable|string|max:3000',
            'start' => 'nullable|date',
            'target_finish' => 'nullable|date',
            'priority' => 'required|string|max:3000',
            'operator' => 'nullable|string|max:3000',
            'keterangan' => 'nullable|string|max:3000',
            'file' => 'nullable|file|mimes:pdf'
        ]);

        $tambahLoadingmesinplant2 = tb_data_loading_machine_plant2::create([
            'url_unique_data_mesin' => HtmlPurifierHelper::clean($request->input('url_unique_data_mesin')),
            'url_unique' => Str::uuid(),
            'plant' => HtmlPurifierHelper::clean($request->input('plant')),
            'nama_mesin' => HtmlPurifierHelper::clean($request->input('nama_mesin')),
            'project' => HtmlPurifierHelper::clean($request->input('project')),
            'customer' => HtmlPurifierHelper::clean($request->input('customer')),
            'no_spk' => HtmlPurifierHelper::clean($request->input('no_spk')),
            'qty' => HtmlPurifierHelper::clean($request->input('qty')),
            'estimasi_jam' => HtmlPurifierHelper::clean($request->input('estimasi_jam')),
            'actual_jam' => HtmlPurifierHelper::clean($request->input('actual_jam')),
            'start' => HtmlPurifierHelper::clean($request->input('start')),
            'target_finish' => HtmlPurifierHelper::clean($request->input('target_finish')),
            'priority' => HtmlPurifierHelper::clean($request->input('priority')),
            'on_proses' => 'On',
            'operator' => HtmlPurifierHelper::clean($request->input('operator')),
            'status_done' => 'Not Done',
            'tanggal_input' => $time->format('Y-m-d'),
            'keterangan' => HtmlPurifierHelper::clean($request->input('keterangan'))
        ]);

        if ($request->hasFile('file')) {

            $files['fileprojekloadingmachineplant2'] = $request->file('file')->store('fileprojekloadingmachineplant2');

            tb_data_file_projek_loading_machine_plant_2::create([
                'url_unique_loading_machine' => $tambahLoadingmesinplant2['url_unique'],
                'url_unique' => Str::uuid(),
                'file' => $files['fileprojekloadingmachineplant2'],
                'tanggal_file_diupload' => $time->format('Y-m-d H:i:s')
            ]);
        }

        $tambahData = [
            'plant' => HtmlPurifierHelper::clean($request->input('plant')),
            'nama_mesin' => HtmlPurifierHelper::clean($request->input('nama_mesin')),
            'project' => HtmlPurifierHelper::clean($request->input('project')),
            'customer' => HtmlPurifierHelper::clean($request->input('customer')),
            'no_spk' => HtmlPurifierHelper::clean($request->input('no_spk')),
            'qty' => HtmlPurifierHelper::clean($request->input('qty')),
            'estimasi_jam' => HtmlPurifierHelper::clean($request->input('estimasi_jam')),
            'actual_jam' => HtmlPurifierHelper::clean($request->input('actual_jam')),
            'start' => HtmlPurifierHelper::clean($request->input('start')),
            'target_finish' => HtmlPurifierHelper::clean($request->input('target_finish')),
            'priority' => HtmlPurifierHelper::clean($request->input('priority')),
            'on_proses' => $tambahLoadingmesinplant2['on_proses'],
            'operator' => HtmlPurifierHelper::clean($request->input('operator')),
            'status_done' => $tambahLoadingmesinplant2['status_done'],
            'tanggal_input' => $tambahLoadingmesinplant2['tanggal_input'],
            'keterangan' => HtmlPurifierHelper::clean($request->input('keterangan'))
        ];


        return back()->with('PostTambahDataLoadingMesinPPICPlant2PLNT2', 'Tambah Data Loading Machine Berhasil')->with('addData', $tambahData);
    }
    
    public function LihatSemuaDataLoadingMachinePlant2PLNT2()
    {
        return view('UserPPICPlant2.Halaman_Lihat_Semua_Data_Loading_Machine_Plant_2_PLNT_2', [
            'judul' => 'Lihat Semua Data Loading Machine Plant 2',
            'datamesin' => tb_data_mesin_plant_2::all()
        ]);
    }

    public function LihatSemuaDataDetailLoadingMachinePlant2PLNT2(tb_data_mesin_plant_2 $mesin, Request $request)
    {

        $request->validate([
            'search' => 'nullable|string|max:700',
            'opsi_filter' => 'nullable|in:Done,Not Done,All',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $loadingmesinfilterbyurluniquemesin = tb_data_loading_machine_plant2::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $loadingmesinfilterbyurluniquemesin->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' . $search . '%')
                    ->orwhere('project', 'like', '%' . $search . '%')
                    ->orwhere('customer', 'like', '%' . $search . '%')
                    ->orwhere('no_spk', 'like', '%' . $search . '%')
                    ->orwhere('qty', 'like', '%' . $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
                    ->orwhere('actual_jam', 'like', '%' . $search . '%')
                    ->orwhere('start', 'like', '%' . $search . '%')
                    ->orwhere('target_finish', 'like', '%' . $search . '%')
                    ->orwhere('priority', 'like', '%' . $search . '%')
                    ->orwhere('on_proses', 'like', '%' . $search . '%')
                    ->orwhere('operator', 'like', '%' . $search . '%')
                    ->orwhere('keterangan', 'like', '%' . $search . '%')
                    ->orwhere('status_done', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_input', 'like', '%' . $search . '%')
                    ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $loadingmesinfilterbyurluniquemesin->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $loadingmesinfilterbyurluniquemesin->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            } elseif ($opsi === 'All' || $opsi == null) {
            }
        }


        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $loadingmesinfilterbyurluniquemesin->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmesincount = $loadingmesinfilterbyurluniquemesin->count();

        $dataloadingmesin = $loadingmesinfilterbyurluniquemesin->paginate(10)->WithQueryString();

        return view('UserPPICPlant2.Halaman_Lihat_Semua_Data_Detail_Loading_Machine_Plant_2', [
            'judul' => 'Halaman Lihat Semua Data Detail Loading Machine Plant 2',
            'dataloadingmachine' => $dataloadingmesin,
            'datamesin' => tb_data_mesin_plant_2::all(),
            'mesin' => $mesin,
            'dataloadingmesincount' => $dataloadingmesincount
        ]);
    }

    public function PostDeleteLoadingMachinePlant2PLN2(tb_data_loading_machine_plant2 $data)
    {

        if ($data) {

            $data->delete();

            return back()->with('PostDeleteLoadingMachinePlant2PLN2', 'Hapus Data Berhasil');
        } else {

            return back()->with('PostDeleteLoadingMachinePlant2PLN2Gagal', 'Hapus Data Gagal');
        }
    }

    public function UpdateStatusDoneDataLoadingMachinePlant2PLN2(tb_data_loading_machine_plant2 $data)
    {

        $time = Carbon::now('Asia/Jakarta');

        $array1 = [
            'status_done' => 'Not Done',
            'on_proses' => 'On',
            'user_pengupdated_status_done_loading_mesin' => auth()->user()->nama_user,
            'departemen_user_pengupdated_status_done_loading_mesin' => auth()->user()->departemen,
            'plant_user_pengupdated_status_done_loading_mesin' => auth()->user()->plant,
            'tanggal_updated_status_done_loading_mesin' => $time->format('Y-m-d'),
            'jam_updated_status_done_loading_mesin' => $time->format('H:i:s')
        ];

        $array2 = [
            'status_done' => 'Done',
            'on_proses' => 'Ok',
            'user_pengupdated_status_done_loading_mesin' => auth()->user()->nama_user,
            'departemen_user_pengupdated_status_done_loading_mesin' => auth()->user()->departemen,
            'plant_user_pengupdated_status_done_loading_mesin' => auth()->user()->plant,
            'tanggal_updated_status_done_loading_mesin' => $time->format('Y-m-d'),
            'jam_updated_status_done_loading_mesin' => $time->format('H:i:s')
        ];

        if ($data->status_done == 'Not Done' && $data->on_proses == 'On') {


            $data->update($array2);
        } elseif ($data->status_done == 'Done' && $data->on_proses == 'Ok') {

            $data->update($array1);
        }

        return back()->with('UpdateStatusDoneDataLoadingMachinePlant2PLN2', 'Update Status Done Loading Machine Berhasil');
    }


    public function PostUbahDataDetailLoadingMesinSPKPlant2PLN2(tb_data_loading_machine_plant2 $data, Request $request)
    {

        $time = Carbon::now('Asia/Jakarta');

        $request->validate([
            'plant' => 'required|string|max:3000',
            'nama_mesin' => 'required|string|max:3000',
            'project' => 'required|string|max:3000',
            'customer' => 'required|string|max:3000',
            'no_spk' => 'required|string|max:3000',
            'estimasi_jam' => 'nullable|string|max:3000',
            'actual_jam' => 'nullable|string|max:3000',
            'qty' => 'required|string',
            'start' => 'nullable|date',
            'target_finish' => 'nullable|date',
            'priority' => 'nullable|string|max:3000',
            'operator' => 'nullable|string|max:3000',
            'keterangan' => 'nullable|string|max:3000'
        ]);

        $data->update([
            'url_unique_data_mesin' => HtmlPurifierHelper::clean($request->input('url_unique_data_mesin')),
            'plant' => HtmlPurifierHelper::clean($request->input('plant')),
            'nama_mesin' => HtmlPurifierHelper::clean($request->input('nama_mesin')),
            'project' => HtmlPurifierHelper::clean($request->input('project')),
            'customer' => HtmlPurifierHelper::clean($request->input('customer')),
            'no_spk' => HtmlPurifierHelper::clean($request->input('no_spk')),
            'estimasi_jam' => HtmlPurifierHelper::clean($request->input('estimasi_jam')),
            'actual_jam' => HtmlPurifierHelper::clean($request->input('actual_jam')),
            'qty' => HtmlPurifierHelper::clean($request->input('qty')),
            'start' => HtmlPurifierHelper::clean($request->input('start')),
            'target_finish' => HtmlPurifierHelper::clean($request->input('target_finish')),
            'priority' => HtmlPurifierHelper::clean($request->input('priority')),
            'operator' => HtmlPurifierHelper::clean($request->input('operator')),
            'keterangan' => HtmlPurifierHelper::clean($request->input('keterangan')),
            'user_pengupdated_data_loading_mesin' => auth()->user()->nama_user,
            'departemen_user_pengupdated_data_loading_mesin' => auth()->user()->departemen,
            'plant_user_pengupdated_data_loading_mesin' => auth()->user()->plant,
            'tanggal_updated_data_loading_mesin' => HtmlPurifierHelper::clean($time->format('Y-m-d')),
            'jam_updated_data_loading_mesin' => HtmlPurifierHelper::clean($time->format('H:i:s'))
        ]);

        return back()->with('PostUbahDataDetailLoadingMesinSPKPlant2PLN2', 'Edit/Ubah Data Loading Machine Berhasil');
    }

    public function ExportPDFDetailLoadingMachinePlant2(tb_data_mesin_plant_2 $mesin, Request $request)
    {
        $datasemualoadingmachine = tb_data_loading_machine_plant2::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $datasemualoadingmachine->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' . $search . '%')
                    ->orwhere('project', 'like', '%' . $search . '%')
                    ->orwhere('customer', 'like', '%' . $search . '%')
                    ->orwhere('no_spk', 'like', '%' . $search . '%')
                    ->orwhere('qty', 'like', '%' . $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
                    ->orwhere('actual_jam', 'like', '%' . $search . '%')
                    ->orwhere('start', 'like', '%' . $search . '%')
                    ->orwhere('target_finish', 'like', '%' . $search . '%')
                    ->orwhere('priority', 'like', '%' . $search . '%')
                    ->orwhere('on_proses', 'like', '%' . $search . '%')
                    ->orwhere('operator', 'like', '%' . $search . '%')
                    ->orwhere('keterangan', 'like', '%' . $search . '%')
                    ->orwhere('status_done', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_input', 'like', '%' . $search . '%')
                    ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
                    ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $datasemualoadingmachine->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $datasemualoadingmachine->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $datasemualoadingmachine->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $datasemualoadingmachinecount = $datasemualoadingmachine->count();

        $dataloadingmachine = $datasemualoadingmachine->get();

        $pdf = PDF::loadView('UserPPICPlant2.Export_PDF_Data_Detail_Loading_Mesin_SPK_Plant_2_PLNT2', ['data' => $dataloadingmachine, 'mesin' => $mesin, 'count' =>  $datasemualoadingmachinecount])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_2.pdf');
    }


    public function UbahPasswordUserPlant2PLN2()
    {
        return view('UserPPICPlant2.Halaman_Ubah_Password_Plant_2', [
            'judul' => 'Halaman Ubah Password User Plant2'
        ]);
    }


    public function PostUbahPasswordUserPlant2PLN2(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/|confirmed'
        ]);

        $user = auth()->user();

        $user->update([
            'password' => HtmlPurifierHelper::clean(Hash::make($request->input('password')))
        ]);

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function ProfileUserPlant2PLN2()
    {
        return view('UserPPICPlant2.Halaman_Profile_User_Plant_2_PLN_2', [
            'judul' => 'Halaman Profile User Plant 2'
        ]);
    }

    public function PostGetFotoProfileUserPlant2(Request $request)
    {

        DB::beginTransaction();

        try {
            $user = auth()->user();

            if ($user->image) {

                Storage::delete($user->image);
            }

            $uploadSettings = ["directory" => "fotouser", "disk" => "public", "maxFileSize" => 52428800, "allowedExtensions" => ['jpeg', 'jpg', 'png']];

            $ambilfoto = $request->image;

            $file_uploader_factory = new \OldRavian\FileUploader\Factories\FileUploaderFactory();
            $file_uploader = $file_uploader_factory->build("base64");
            $data = $file_uploader->upload($ambilfoto, $uploadSettings);
            $dataimage = $data['filename'];

            $user->update([
                'image' => 'fotouser/' . $dataimage
            ]);

            DB::commit();

            echo 1;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Gagal mengupload gambar: ' . $th->getMessage());
            echo 0;
        }
    }

    public function PostUbahFotoProfileUserPlant2PLNT2(Request $request)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = auth()->user();

        if ($request->file('image')) {

            if ($user->image) {

                Storage::delete($user->image);

                $image['fotouser'] = $request->file('image')->store('fotouser');
            }

            $user->update([
                'image' => $image['fotouser']
            ]);
        }

        return back();
    }


    public function PilihOpsiLihatDataLoadingMesinPlant2PLN2()
    {
        return view('UserPPICPlant2.Halaman_Pilih_Opsi_Lihat_Data_Loading_Mesin_Plant_2_PLN_2', [
            'judul' => 'Halaman Pilih Opsi Lihat Data Loading Mesin Plant 2',
        ]);
    }

    public function GetPilihOpsiLihatDataLoadingMesinPlant2PLNT2(Request $request)
    {

        $opsi = $request->input('pilih_opsi_lihat_data_loading_machine_plant_2');

        if ($opsi == 'Lihat Data Loading Machine Per Mesin') {

            return redirect('/lihatsemuadataloadingmachineplant2pln2');
        } elseif ($opsi == 'Lihat Data Keseluruhan Loading Machine') {

            return redirect('/lihatdatakeseluruhanloadingmesinplant2');
        }
    }

    public function LihatDataKeseluruhanLoadingMesinPlant2(Request $request)
    {

        $request->validate([
            'search' => 'nullable|string|max:700',
            'opsi_filter' => 'nullable|in:Done,Not Done,All',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $datakeseluruhanloadingmachineplant2 = tb_data_loading_machine_plant2::whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $datakeseluruhanloadingmachineplant2->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' . $search . '%')
                    ->orwhere('project', 'like', '%' . $search . '%')
                    ->orwhere('customer', 'like', '%' . $search . '%')
                    ->orwhere('no_spk', 'like', '%' . $search . '%')
                    ->orwhere('qty', 'like', '%' . $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
                    ->orwhere('actual_jam', 'like', '%' . $search . '%')
                    ->orwhere('start', 'like', '%' . $search . '%')
                    ->orwhere('target_finish', 'like', '%' . $search . '%')
                    ->orwhere('priority', 'like', '%' . $search . '%')
                    ->orwhere('on_proses', 'like', '%' . $search . '%')
                    ->orwhere('operator', 'like', '%' . $search . '%')
                    ->orwhere('keterangan', 'like', '%' . $search . '%')
                    ->orwhere('status_done', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_input', 'like', '%' . $search . '%')
                    ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
                    ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $datakeseluruhanloadingmachineplant2->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $datakeseluruhanloadingmachineplant2->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            } elseif ($opsi == 'All' || $opsi == null) {
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $datakeseluruhanloadingmachineplant2->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmachineplant2count = $datakeseluruhanloadingmachineplant2->count();

        $dataloadingmachineplant2 = $datakeseluruhanloadingmachineplant2->paginate(10)->WithQueryString();

        return view('UserPPICPlant2.Halaman_Lihat_Data_Keseluruhan_Loading_Machine_Plant_2_PLN_2', [
            'judul' => 'Halaman Lihat Data Keseluruhan Loading Mesin Plant 2',
            'dataloadingmachineplant2' => $dataloadingmachineplant2,
            'dataloadingmesinplant2count' => $dataloadingmachineplant2count,
            'datamesin' => tb_data_mesin_plant_2::all()
        ]);
    }

    public function PostDeleteDataKeseluruhanLoadingMachinePlant2(tb_data_loading_machine_plant2 $data)
    {

        if ($data) {

            $data->delete();
        }

        return back()->with('PostDeleteDataKeseluruhanLoadingMachinePlant2', 'Hapus Data Loading Machine Berhasil');
    }

    public function PostEditDataKeseluruhanLoadingMachinePPICPlant2PLN2(tb_data_loading_machine_plant2 $data, Request $request)
    {
        $time = Carbon::now('Asia/Jakarta');

        $request->validate([
            'plant' => 'required|string|max:3000',
            'nama_mesin' => 'required|string|max:3000',
            'project' => 'required|string|max:3000',
            'customer' => 'required|string|max:3000',
            'no_spk' => 'required|string|max:3000',
            'estimasi_jam' => 'nullable|string|max:3000',
            'actual_jam' => 'nullable|string|max:3000',
            'qty' => 'required|string',
            'start' => 'nullable|date',
            'target_finish' => 'nullable|date',
            'priority' => 'nullable|string|max:3000',
            'operator' => 'nullable|string|max:3000',
            'keterangan' => 'nullable|string|max:3000'
        ]);

        $data->update([
            'url_unique_data_mesin' => HtmlPurifierHelper::clean($request->input('url_unique_data_mesin')),
            'plant' => HtmlPurifierHelper::clean($request->input('plant')),
            'nama_mesin' => HtmlPurifierHelper::clean($request->input('nama_mesin')),
            'project' => HtmlPurifierHelper::clean($request->input('project')),
            'customer' => HtmlPurifierHelper::clean($request->input('customer')),
            'no_spk' => HtmlPurifierHelper::clean($request->input('no_spk')),
            'estimasi_jam' => HtmlPurifierHelper::clean($request->input('estimasi_jam')),
            'actual_jam' => HtmlPurifierHelper::clean($request->input('actual_jam')),
            'qty' => HtmlPurifierHelper::clean($request->input('qty')),
            'start' => HtmlPurifierHelper::clean($request->input('start')),
            'target_finish' => HtmlPurifierHelper::clean($request->input('target_finish')),
            'priority' => HtmlPurifierHelper::clean($request->input('priority')),
            'operator' => HtmlPurifierHelper::clean($request->input('operator')),
            'keterangan' => HtmlPurifierHelper::clean($request->input('keterangan')),
            'user_pengupdated_data_loading_mesin' => auth()->user()->nama_user,
            'departemen_user_pengupdated_data_loading_mesin' => auth()->user()->departemen,
            'plant_user_pengupdated_data_loading_mesin' => auth()->user()->plant,
            'tanggal_updated_data_loading_mesin' => HtmlPurifierHelper::clean($time->format('Y-m-d')),
            'jam_updated_data_loading_mesin' => HtmlPurifierHelper::clean($time->format('H:i:s'))
        ]);

        return back()->with('PostEditDataKeseluruhanLoadingMachinePPICPlant2PLN2', 'Edit Data Loading Machine Berhasil');
    }

    public function PostUpdateStatusDoneDataKeseluruhanLoadingMachinePlant2PLNT2(tb_data_loading_machine_plant2 $data)
    {
        $time = Carbon::now('Asia/Jakarta');

        $array1 = [
            'status_done' => 'Not Done',
            'on_proses' => 'On',
            'user_pengupdated_status_done_loading_mesin' => auth()->user()->nama_user,
            'departemen_user_pengupdated_status_done_loading_mesin' => auth()->user()->departemen,
            'plant_user_pengupdated_status_done_loading_mesin' => auth()->user()->plant,
            'tanggal_updated_status_done_loading_mesin' => $time->format('Y-m-d'),
            'jam_updated_status_done_loading_mesin' => $time->format('H:i:s')
        ];

        $array2 = [
            'status_done' => 'Done',
            'on_proses' => 'Ok',
            'user_pengupdated_status_done_loading_mesin' => auth()->user()->nama_user,
            'departemen_user_pengupdated_status_done_loading_mesin' => auth()->user()->departemen,
            'plant_user_pengupdated_status_done_loading_mesin' => auth()->user()->plant,
            'tanggal_updated_status_done_loading_mesin' => $time->format('Y-m-d'),
            'jam_updated_status_done_loading_mesin' => $time->format('H:i:s')
        ];

        if ($data->status_done == 'Not Done' && $data->on_proses == 'On') {

            $data->update($array2);
        } elseif ($data->status_done == 'Done' && $data->on_proses == 'Ok') {

            $data->update($array1);
        }

        return back()->with('PostUpdateStatusDoneDataKeseluruhanLoadingMachinePlant2PLNT2', 'Update Status Done Berhasil');
    }

    public function ExportPDFDataKeseluruhanLoadingMachinePlant2(Request $request)
    {

        $datakeseluruhanloadingmachineplant2 = tb_data_loading_machine_plant2::whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $datakeseluruhanloadingmachineplant2->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' . $search . '%')
                    ->orwhere('project', 'like', '%' . $search . '%')
                    ->orwhere('customer', 'like', '%' . $search . '%')
                    ->orwhere('no_spk', 'like', '%' . $search . '%')
                    ->orwhere('qty', 'like', '%' . $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
                    ->orwhere('actual_jam', 'like', '%' . $search . '%')
                    ->orwhere('start', 'like', '%' . $search . '%')
                    ->orwhere('target_finish', 'like', '%' . $search . '%')
                    ->orwhere('priority', 'like', '%' . $search . '%')
                    ->orwhere('on_proses', 'like', '%' . $search . '%')
                    ->orwhere('operator', 'like', '%' . $search . '%')
                    ->orwhere('keterangan', 'like', '%' . $search . '%')
                    ->orwhere('status_done', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_input', 'like', '%' . $search . '%')
                    ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
                    ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $datakeseluruhanloadingmachineplant2->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $datakeseluruhanloadingmachineplant2->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $datakeseluruhanloadingmachineplant2->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmachineplant2count = $datakeseluruhanloadingmachineplant2->count();

        $dataloadingmachineplant2 = $datakeseluruhanloadingmachineplant2->get();

        $pdf = PDF::loadView('UserPPICPlant2.Export_PDF_Data_Keseluruhan_Loading_Mesin_Plant_2', ['data' => $dataloadingmachineplant2, 'jumlahdata' => $dataloadingmachineplant2count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_2.pdf');
    }
    
    
    public function RestoreDataLoadingMachinePlant2(Request $request)
    {

        $datarestoreloadingmachineplant2 = tb_data_loading_machine_plant2::onlyTrashed();

        if ($request->has('search')) {

            $search = $request->input('search');

            $datarestoreloadingmachineplant2->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' . $search . '%')
                    ->orwhere('project', 'like', '%' . $search . '%')
                    ->orwhere('customer', 'like', '%' . $search . '%')
                    ->orwhere('no_spk', 'like', '%' . $search . '%')
                    ->orwhere('qty', 'like', '%' . $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
                    ->orwhere('actual_jam', 'like', '%' . $search . '%')
                    ->orwhere('start', 'like', '%' . $search . '%')
                    ->orwhere('target_finish', 'like', '%' . $search . '%')
                    ->orwhere('priority', 'like', '%' . $search . '%')
                    ->orwhere('on_proses', 'like', '%' . $search . '%')
                    ->orwhere('operator', 'like', '%' . $search . '%')
                    ->orwhere('keterangan', 'like', '%' . $search . '%')
                    ->orwhere('status_done', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_input', 'like', '%' . $search . '%')
                    ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
                    ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
            });
        }

        $datarestoreloadingmesinplant2count = $datarestoreloadingmachineplant2->count();

        $datarestoreloadingmesinplant2 = $datarestoreloadingmachineplant2->paginate(10)->WithQueryString();

        return view('UserPPICPlant2.Halaman_Restore_Data_Loading_Machine_Plant_2_PLN_2', [
            'judul' => 'Halaman Restore Data Loading Machine Plant 2',
            'datarestoreplant2' => $datarestoreloadingmesinplant2,
            'datarestorecount' => $datarestoreloadingmesinplant2count
        ]);
    }


    public function RestoreDataLoadingMachinePlant2PLNT2($urlUnique)
    {

        $datarestore = tb_data_loading_machine_plant2::onlyTrashed()->where('url_unique', $urlUnique)->first();

        if ($datarestore) {

            $datarestore->restore();

            return back()->with('RestoreDataLoadingMachinePlant2PLNT2Berhasil', 'Restore Data Loading Machine Berhasil');
        } else {

            return back()->with('RestoreDataLoadingMachinePlant2PLNT2Gagal', 'Restore Data Loading Machine Gagal');
        }
    }
    
    
    public function ExportExcelDetailLoadingMachinePlant2(tb_data_mesin_plant_2 $mesin, Request $request)
    {

        $dataloadingmachineplant2 = tb_data_loading_machine_plant2::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmachineplant2->where(function ($query) use ($search) {
                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' . $search . '%')
                    ->orwhere('project', 'like', '%' . $search . '%')
                    ->orwhere('customer', 'like', '%' . $search . '%')
                    ->orwhere('no_spk', 'like', '%' . $search . '%')
                    ->orwhere('qty', 'like', '%' . $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
                    ->orwhere('actual_jam', 'like', '%' . $search . '%')
                    ->orwhere('start', 'like', '%' . $search . '%')
                    ->orwhere('target_finish', 'like', '%' . $search . '%')
                    ->orwhere('priority', 'like', '%' . $search . '%')
                    ->orwhere('on_proses', 'like', '%' . $search . '%')
                    ->orwhere('operator', 'like', '%' . $search . '%')
                    ->orwhere('keterangan', 'like', '%' . $search . '%')
                    ->orwhere('status_done', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_input', 'like', '%' . $search . '%')
                    ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
                    ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $dataloadingmachineplant2->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $dataloadingmachineplant2->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmachineplant2->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmesinplant2 = $dataloadingmachineplant2->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $selectedColumns = [
            'plant' => 'Plant',
            'nama_mesin' => 'Nama Mesin/Proses',
            'status_done' => 'Status Done',
            'project' => 'Project',
            'customer' => 'Customer',
            'no_spk' => 'No SPK',
            'qty' => 'QTY',
            'estimasi_jam' => 'Estimasi Jam',
            'actual_jam' => 'Actual Jam',
            'start' => 'Start',
            'target_finish' => 'Target Finish',
            'priority' => 'Priority',
            'on_proses' => 'On Proses',
            'operator' => 'Operator',
            'keterangan' => 'Keterangan'
        ];

        $columnIndex = 'A';
        foreach ($selectedColumns as $columnKey => $columnHeader) {
            $sheet->setCellValue($columnIndex . '1', $columnHeader);
            $columnIndex++;
        }

        $row = 2;
        foreach ($dataloadingmesinplant2 as $item) {
            $columnIndex = 'A';
            foreach ($selectedColumns as $columnKey => $columnHeader) {
                if (isset($item[$columnKey])) {
                    $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
                } else {
                    $sheet->setCellValue($columnIndex . $row, '');
                }
                $columnIndex++;
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/exported_data.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }
    
    public function ExportExcelDataKeseluruhanLoadingMachinePlant2(Request $request)
    {

        $datakeseluruhanloadingmachineplant2 = tb_data_loading_machine_plant2::whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $datakeseluruhanloadingmachineplant2->where(function ($query) use ($search) {
                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' . $search . '%')
                    ->orwhere('project', 'like', '%' . $search . '%')
                    ->orwhere('customer', 'like', '%' . $search . '%')
                    ->orwhere('no_spk', 'like', '%' . $search . '%')
                    ->orwhere('qty', 'like', '%' . $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
                    ->orwhere('actual_jam', 'like', '%' . $search . '%')
                    ->orwhere('start', 'like', '%' . $search . '%')
                    ->orwhere('target_finish', 'like', '%' . $search . '%')
                    ->orwhere('priority', 'like', '%' . $search . '%')
                    ->orwhere('on_proses', 'like', '%' . $search . '%')
                    ->orwhere('operator', 'like', '%' . $search . '%')
                    ->orwhere('keterangan', 'like', '%' . $search . '%')
                    ->orwhere('status_done', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_input', 'like', '%' . $search . '%')
                    ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
                    ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $datakeseluruhanloadingmachineplant2->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $datakeseluruhanloadingmachineplant2->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $datakeseluruhanloadingmachineplant2->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataallloadingmachineplant2 = $datakeseluruhanloadingmachineplant2->get();


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $selectedColumns = [
            'plant' => 'Plant',
            'nama_mesin' => 'Nama Mesin/Proses',
            'status_done' => 'Status Done',
            'project' => 'Project',
            'customer' => 'Customer',
            'no_spk' => 'No SPK',
            'qty' => 'QTY',
            'estimasi_jam' => 'Estimasi Jam',
            'actual_jam' => 'Actual Jam',
            'start' => 'Start',
            'target_finish' => 'Target Finish',
            'priority' => 'Priority',
            'on_proses' => 'On Proses',
            'operator' => 'Operator',
            'keterangan' => 'Keterangan'
        ];

        $columnIndex = 'A';
        foreach ($selectedColumns as $columnKey => $columnHeader) {
            $sheet->setCellValue($columnIndex . '1', $columnHeader);
            $columnIndex++;
        }

        $row = 2;
        foreach ($dataallloadingmachineplant2 as $item) {
            $columnIndex = 'A';
            foreach ($selectedColumns as $columnKey => $columnHeader) {
                if (isset($item[$columnKey])) {
                    $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
                } else {
                    $sheet->setCellValue($columnIndex . $row, '');
                }
                $columnIndex++;
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/exported_data.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }
    
    // PLANT 1
    
    public function PilihOpsiLihatDataLoadingMachinePlant1PLNT2()
    {
        return view('UserPPICPlant2.Halaman_Pilih_Opsi_Lihat_Data_Loading_Machine_Plant_1_PLNT2', [
            'judul' => 'Halaman Pilih Opsi Lihat Data Loading Machine Plant 1'
        ]);
    }

    public function GetPilihOpsiLihatDataLoadingMesinPlant1PLANT2(Request $request)
    {

        $opsi = HtmlPurifierHelper::clean($request->input('pilih_opsi_lihat_data_loading_machine_plant_1_PLANT2'));

        if ($opsi === 'Lihat Data Loading Machine Per Mesin') {

            return redirect('/lihatdataloadingmachineplant1permachine/plant2');
        } elseif ($opsi === 'Lihat Data Keseluruhan Loading Machine') {

            return redirect('/lihatdatakeseluruhanloadingmachineplant1/plant2');
        }
    }

    public function LihatDataLoadingMachinePlant1PerMachinePLANT2()
    {
        return view('UserPPICPlant2.Halaman_Lihat_Data_Loading_Machine_Plant_1_PLNT2', [
            'judul' => 'Lihat Data Loading Machine Plant 1',
            'datamesin' => tb_data_mesin::all()
        ]);
    }

    public function LihatSemuaDataDetailLoadingMesinPermesinPlant1PLANT2(tb_data_mesin $mesin, Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:700',
            'opsi_filter' => 'nullable|in:Done,Not Done,All',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $dataloadingmachineplant1permesin = tb_data_loading_machine_plant1::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at')
            ->with('fileProjek');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmachineplant1permesin->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' . $search . '%')
                    ->orwhere('project', 'like', '%' . $search . '%')
                    ->orwhere('customer', 'like', '%' . $search . '%')
                    ->orwhere('no_spk', 'like', '%' . $search . '%')
                    ->orwhere('qty', 'like', '%' . $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
                    ->orwhere('actual_jam', 'like', '%' . $search . '%')
                    ->orwhere('start', 'like', '%' . $search . '%')
                    ->orwhere('target_finish', 'like', '%' . $search . '%')
                    ->orwhere('priority', 'like', '%' . $search . '%')
                    ->orwhere('on_proses', 'like', '%' . $search . '%')
                    ->orwhere('operator', 'like', '%' . $search . '%')
                    ->orwhere('keterangan', 'like', '%' . $search . '%')
                    ->orwhere('status_done', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_input', 'like', '%' . $search . '%')
                    ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
                    ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $dataloadingmachineplant1permesin->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $dataloadingmachineplant1permesin->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            } elseif ($opsi === 'All' || $opsi === null) {
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmachineplant1permesin->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmachineplant1permesincount = $dataloadingmachineplant1permesin->count();

        $dataloadingmesinplant1 = $dataloadingmachineplant1permesin->paginate(10)->WithQueryString();

        return view('UserPPICPlant2.Halaman_Lihat_Semua_Data_Detail_Loading_Mesin_Per_mesin_Plant1_PLANT2', [
            'judul' => 'Halaman Lihat Data Loading Machine Plant 1 Per Machine',
            'dataloadingmachineplant1' => $dataloadingmesinplant1,
            'dataloadingmachineplant1count' => $dataloadingmachineplant1permesincount,
            'mesin' => $mesin
        ]);
    }

    public function ExportPDFDetailLoadingMachinePlant1PerMachinePLANT2(tb_data_mesin $mesin, Request $request)
    {

        $dataloadingmachineplant1permesin = tb_data_loading_machine_plant1::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmachineplant1permesin->where(function ($query) use ($search) {
                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' . $search . '%')
                    ->orwhere('project', 'like', '%' . $search . '%')
                    ->orwhere('customer', 'like', '%' . $search . '%')
                    ->orwhere('no_spk', 'like', '%' . $search . '%')
                    ->orwhere('qty', 'like', '%' . $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
                    ->orwhere('actual_jam', 'like', '%' . $search . '%')
                    ->orwhere('start', 'like', '%' . $search . '%')
                    ->orwhere('target_finish', 'like', '%' . $search . '%')
                    ->orwhere('priority', 'like', '%' . $search . '%')
                    ->orwhere('on_proses', 'like', '%' . $search . '%')
                    ->orwhere('operator', 'like', '%' . $search . '%')
                    ->orwhere('keterangan', 'like', '%' . $search . '%')
                    ->orwhere('status_done', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_input', 'like', '%' . $search . '%')
                    ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
                    ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $dataloadingmachineplant1permesin->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $dataloadingmachineplant1permesin->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmachineplant1permesin->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmachineplant1permesincount = $dataloadingmachineplant1permesin->count();

        $dataloadingmachineplant1 = $dataloadingmachineplant1permesin->get();

        $pdf = PDF::loadView('UserPPICPlant2.Export_PDF_Data_Loading_Mesin_Plant_1_Per_Machine_PLANT2', ['data' => $dataloadingmachineplant1, 'count' => $dataloadingmachineplant1permesincount, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_1.pdf');
    }

    public function ExportExcelDetailLoadingMachinePlant1PerMachinePLANT2(tb_data_mesin $mesin, Request $request)
    {

        $dataloadingmachineplant1permesin = tb_data_loading_machine_plant1::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmachineplant1permesin->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' . $search . '%')
                    ->orwhere('project', 'like', '%' . $search . '%')
                    ->orwhere('customer', 'like', '%' . $search . '%')
                    ->orwhere('no_spk', 'like', '%' . $search . '%')
                    ->orwhere('qty', 'like', '%' . $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
                    ->orwhere('actual_jam', 'like', '%' . $search . '%')
                    ->orwhere('start', 'like', '%' . $search . '%')
                    ->orwhere('target_finish', 'like', '%' . $search . '%')
                    ->orwhere('priority', 'like', '%' . $search . '%')
                    ->orwhere('on_proses', 'like', '%' . $search . '%')
                    ->orwhere('operator', 'like', '%' . $search . '%')
                    ->orwhere('keterangan', 'like', '%' . $search . '%')
                    ->orwhere('status_done', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_input', 'like', '%' . $search . '%')
                    ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
                    ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $dataloadingmachineplant1permesin->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $dataloadingmachineplant1permesin->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmachineplant1permesin->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmachineplant1 = $dataloadingmachineplant1permesin->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $selectedColumns = [
            'plant' => 'Plant',
            'nama_mesin' => 'Nama Mesin/Proses',
            'status_done' => 'Status Done',
            'project' => 'Project',
            'customer' => 'Customer',
            'no_spk' => 'No SPK',
            'qty' => 'QTY',
            'estimasi_jam' => 'Estimasi Jam',
            'actual_jam' => 'Actual Jam',
            'start' => 'Start',
            'target_finish' => 'Target Finish',
            'priority' => 'Priority',
            'on_proses' => 'On Proses',
            'operator' => 'Operator',
            'keterangan' => 'Keterangan'
        ];

        $columnIndex = 'A';
        foreach ($selectedColumns as $columnKey => $columnHeader) {
            $sheet->setCellValue($columnIndex . '1', $columnHeader);
            $columnIndex++;
        }

        $row = 2;
        foreach ($dataloadingmachineplant1 as $item) {
            $columnIndex = 'A';
            foreach ($selectedColumns as $columnKey => $columnHeader) {
                if (isset($item[$columnKey])) {
                    $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
                } else {
                    $sheet->setCellValue($columnIndex . $row, '');
                }
                $columnIndex++;
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/loading_mesin_plant_1.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }
    
    // 
    
    public function LihatDataKeseluruhanLoadingMachinePlant1PLANT2(Request $request)
    {

        $request->validate([
            'search' => 'nullable|string|max:700',
            'opsi_filter' => 'nullable|in:Done,Not Done,All',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $datakeseluruhanloadingmachineplant1 = tb_data_loading_machine_plant1::whereNull('deleted_at')
            ->with('fileProjek');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $datakeseluruhanloadingmachineplant1->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' . $search . '%')
                    ->orwhere('project', 'like', '%' . $search . '%')
                    ->orwhere('customer', 'like', '%' . $search . '%')
                    ->orwhere('no_spk', 'like', '%' . $search . '%')
                    ->orwhere('qty', 'like', '%' . $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
                    ->orwhere('actual_jam', 'like', '%' . $search . '%')
                    ->orwhere('start', 'like', '%' . $search . '%')
                    ->orwhere('target_finish', 'like', '%' . $search . '%')
                    ->orwhere('priority', 'like', '%' . $search . '%')
                    ->orwhere('on_proses', 'like', '%' . $search . '%')
                    ->orwhere('operator', 'like', '%' . $search . '%')
                    ->orwhere('keterangan', 'like', '%' . $search . '%')
                    ->orwhere('status_done', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_input', 'like', '%' . $search . '%')
                    ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
                    ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $datakeseluruhanloadingmachineplant1->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $datakeseluruhanloadingmachineplant1->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            } elseif ($opsi === 'All' || $opsi === null) {
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $datakeseluruhanloadingmachineplant1->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $datakeseluruhanloadingmachineplant1count = $datakeseluruhanloadingmachineplant1->count();

        $dataallloadingmachineplant1 = $datakeseluruhanloadingmachineplant1->paginate(10)->WithQueryString();

        return view('UserPPICPlant2.Halaman_Lihat_Data_Keseluruhan_Loading_Machine_Plant_1_PLANT2', [
            'judul' => 'Halaman Lihat Data Keseluruhan Loading Machine Plant 1',
            'dataloadingmachineplant1' => $dataallloadingmachineplant1,
            'dataloadingmachineplant1count' => $datakeseluruhanloadingmachineplant1count
        ]);
    }


    public function ExportPDFDataKeseluruhanLoadingMachinePlant1PLANT2(Request $request)
    {

        $datakeseluruhanloadingmachineplant1 = tb_data_loading_machine_plant1::whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $datakeseluruhanloadingmachineplant1->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' . $search . '%')
                    ->orwhere('project', 'like', '%' . $search . '%')
                    ->orwhere('customer', 'like', '%' . $search . '%')
                    ->orwhere('no_spk', 'like', '%' . $search . '%')
                    ->orwhere('qty', 'like', '%' . $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
                    ->orwhere('actual_jam', 'like', '%' . $search . '%')
                    ->orwhere('start', 'like', '%' . $search . '%')
                    ->orwhere('target_finish', 'like', '%' . $search . '%')
                    ->orwhere('priority', 'like', '%' . $search . '%')
                    ->orwhere('on_proses', 'like', '%' . $search . '%')
                    ->orwhere('operator', 'like', '%' . $search . '%')
                    ->orwhere('keterangan', 'like', '%' . $search . '%')
                    ->orwhere('status_done', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_input', 'like', '%' . $search . '%')
                    ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
                    ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $datakeseluruhanloadingmachineplant1->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $datakeseluruhanloadingmachineplant1->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $datakeseluruhanloadingmachineplant1->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $datakeseluruhanloadingmachineplant1count = $datakeseluruhanloadingmachineplant1->count();

        $dataallloadingmachineplant1 = $datakeseluruhanloadingmachineplant1->get();

        $pdf = PDF::loadView('UserPPICPlant2.Export_PDF_Data_Keseluruhan_Loading_Mesin_Plant_1_PLANT2', ['data' => $dataallloadingmachineplant1, 'count' => $datakeseluruhanloadingmachineplant1count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_1.pdf');
    }

    public function ExportExcelDataKeseluruhanLoadingMachinePlant1PLANT2(Request $request)
    {

        $datakeseluruhanloadingmachineplant1 = tb_data_loading_machine_plant1::whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $datakeseluruhanloadingmachineplant1->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' . $search . '%')
                    ->orwhere('project', 'like', '%' . $search . '%')
                    ->orwhere('customer', 'like', '%' . $search . '%')
                    ->orwhere('no_spk', 'like', '%' . $search . '%')
                    ->orwhere('qty', 'like', '%' . $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
                    ->orwhere('actual_jam', 'like', '%' . $search . '%')
                    ->orwhere('start', 'like', '%' . $search . '%')
                    ->orwhere('target_finish', 'like', '%' . $search . '%')
                    ->orwhere('priority', 'like', '%' . $search . '%')
                    ->orwhere('on_proses', 'like', '%' . $search . '%')
                    ->orwhere('operator', 'like', '%' . $search . '%')
                    ->orwhere('keterangan', 'like', '%' . $search . '%')
                    ->orwhere('status_done', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_input', 'like', '%' . $search . '%')
                    ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
                    ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $datakeseluruhanloadingmachineplant1->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $datakeseluruhanloadingmachineplant1->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $datakeseluruhanloadingmachineplant1->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataallloadingmachineplant1 = $datakeseluruhanloadingmachineplant1->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $selectedColumns = [
            'plant' => 'Plant',
            'nama_mesin' => 'Nama Mesin/Proses',
            'status_done' => 'Status Done',
            'project' => 'Project',
            'customer' => 'Customer',
            'no_spk' => 'No SPK',
            'qty' => 'QTY',
            'estimasi_jam' => 'Estimasi Jam',
            'actual_jam' => 'Actual Jam',
            'start' => 'Start',
            'target_finish' => 'Target Finish',
            'priority' => 'Priority',
            'on_proses' => 'On Proses',
            'operator' => 'Operator',
            'keterangan' => 'Keterangan'
        ];

        $columnIndex = 'A';
        foreach ($selectedColumns as $columnKey => $columnHeader) {
            $sheet->setCellValue($columnIndex . '1', $columnHeader);
            $columnIndex++;
        }

        $row = 2;
        foreach ($dataallloadingmachineplant1 as $item) {
            $columnIndex = 'A';
            foreach ($selectedColumns as $columnKey => $columnHeader) {
                if (isset($item[$columnKey])) {
                    $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
                } else {
                    $sheet->setCellValue($columnIndex . $row, '');
                }
                $columnIndex++;
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/loading_mesin_plant_1.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }
    
    // PLANT 3
    
    // 
    
    public function PilihOpsiLihatDataLoadingMachinePlant3PLANT2()
    {

        return view('UserPPICPlant2.Halaman_Pilih_Opsi_Lihat_Data_Loading_Machine_Plant_3_PLANT2', [
            'judul' => 'Halaman Pilih Opsi Lihat Data Loading Machine Plant 3'
        ]);
    }

    public function GetPilihOpsiLihatDataLoadingMachinePlant3PLANT2(Request $request)
    {

        $opsi = HtmlPurifierHelper::clean($request->input('pilih_opsi_lihat_data_loading_machine_plant_3_PLANT2'));

        if ($opsi === 'Lihat Data Loading Machine Per Mesin') {

            return redirect('/lihatdataloadingmesinplant3permesin/plant2');
        } elseif ($opsi === 'Lihat Data Keseluruhan Loading Machine') {

            return redirect('/lihatdatakeseluruhanloadingmesinplant3/plant2');
        }
    }


    public function LihatDataLoadingMesinPlant3PerMesinPLANT2()
    {

        return view('UserPPICPlant2.Halaman_Lihat_Data_Loading_Machine_Plant_3_Per_Machine_PLANT2', [
            'judul' => 'Halaman Data Loading Machine Plant 3',
            'datamesin' => tb_data_mesin_plant_3::all()
        ]);
    }


    public function LihatSemuaDataDetailLoadingMachinePerMachinePlant3PLANT2(tb_data_mesin_plant_3 $mesin, Request $request)
    {

        $request->validate([
            'search' => 'nullable|string|max:700',
            'opsi_filter' => 'nullable|in:Done,Not Done,All',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $dataloadingmachineplant3permesin = tb_data_loading_machine_plant3::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at')
            ->with('fileProjekLoadingMachinePlant3');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmachineplant3permesin->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' . $search . '%')
                    ->orwhere('project', 'like', '%' . $search . '%')
                    ->orwhere('customer', 'like', '%' . $search . '%')
                    ->orwhere('no_spk', 'like', '%' . $search . '%')
                    ->orwhere('qty', 'like', '%' . $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
                    ->orwhere('actual_jam', 'like', '%' . $search . '%')
                    ->orwhere('start', 'like', '%' . $search . '%')
                    ->orwhere('target_finish', 'like', '%' . $search . '%')
                    ->orwhere('priority', 'like', '%' . $search . '%')
                    ->orwhere('on_proses', 'like', '%' . $search . '%')
                    ->orwhere('operator', 'like', '%' . $search . '%')
                    ->orwhere('keterangan', 'like', '%' . $search . '%')
                    ->orwhere('status_done', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_input', 'like', '%' . $search . '%')
                    ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
                    ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $dataloadingmachineplant3permesin->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $dataloadingmachineplant3permesin->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            } elseif ($opsi === 'All' || $opsi === null) {
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmachineplant3permesin->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmachineplant3permesincount = $dataloadingmachineplant3permesin->count();

        $dataloadingmachineplant3 = $dataloadingmachineplant3permesin->paginate(10)->WithQueryString();

        return view('UserPPICPlant2.Halaman_Lihat_Semua_Data_Detail_Loading_Machine_Per_Machine_Plant_3_PLANT2', [
            'judul' => 'Halaman Data Loading Machine Plant 3 Per Machine',
            'dataloadingmachineplant3' => $dataloadingmachineplant3,
            'mesin' => $mesin,
            'dataloadingmachineplant3count' => $dataloadingmachineplant3permesincount
        ]);
    }


    public function ExportPDFDetailLoadingMachinePlant3PerMachinePLANT2(tb_data_mesin_plant_3 $mesin, Request $request)
    {

        $dataloadingmachineplant3permesin = tb_data_loading_machine_plant3::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmachineplant3permesin->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' . $search . '%')
                    ->orwhere('project', 'like', '%' . $search . '%')
                    ->orwhere('customer', 'like', '%' . $search . '%')
                    ->orwhere('no_spk', 'like', '%' . $search . '%')
                    ->orwhere('qty', 'like', '%' . $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
                    ->orwhere('actual_jam', 'like', '%' . $search . '%')
                    ->orwhere('start', 'like', '%' . $search . '%')
                    ->orwhere('target_finish', 'like', '%' . $search . '%')
                    ->orwhere('priority', 'like', '%' . $search . '%')
                    ->orwhere('on_proses', 'like', '%' . $search . '%')
                    ->orwhere('operator', 'like', '%' . $search . '%')
                    ->orwhere('keterangan', 'like', '%' . $search . '%')
                    ->orwhere('status_done', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_input', 'like', '%' . $search . '%')
                    ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
                    ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $dataloadingmachineplant3permesin->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $dataloadingmachineplant3permesin->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmachineplant3permesin->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }


        $dataloadingmachineplant3permesincount = $dataloadingmachineplant3permesin->count();

        $dataloadingmachineplant3 = $dataloadingmachineplant3permesin->get();

        $pdf = PDF::loadView('UserPPICPlant2.Export_PDF_Data_Loading_Mesin_Plant_3_Per_Mesin_PLANT2', ['data' => $dataloadingmachineplant3, 'count' => $dataloadingmachineplant3permesincount, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_3.pdf');
    }


    public function ExportExcelDetailLoadingMachinePlant3PerMachinePLANT2(tb_data_mesin_plant_3 $mesin, Request $request)
    {

        $dataloadingmachineplant3permesin = tb_data_loading_machine_plant3::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmachineplant3permesin->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' . $search . '%')
                    ->orwhere('project', 'like', '%' . $search . '%')
                    ->orwhere('customer', 'like', '%' . $search . '%')
                    ->orwhere('no_spk', 'like', '%' . $search . '%')
                    ->orwhere('qty', 'like', '%' . $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
                    ->orwhere('actual_jam', 'like', '%' . $search . '%')
                    ->orwhere('start', 'like', '%' . $search . '%')
                    ->orwhere('target_finish', 'like', '%' . $search . '%')
                    ->orwhere('priority', 'like', '%' . $search . '%')
                    ->orwhere('on_proses', 'like', '%' . $search . '%')
                    ->orwhere('operator', 'like', '%' . $search . '%')
                    ->orwhere('keterangan', 'like', '%' . $search . '%')
                    ->orwhere('status_done', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_input', 'like', '%' . $search . '%')
                    ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
                    ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $dataloadingmachineplant3permesin->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $dataloadingmachineplant3permesin->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmachineplant3permesin->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmachineplant3 = $dataloadingmachineplant3permesin->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $selectedColumns = [
            'plant' => 'Plant',
            'nama_mesin' => 'Nama Mesin/Proses',
            'status_done' => 'Status Done',
            'project' => 'Project',
            'customer' => 'Customer',
            'no_spk' => 'No SPK',
            'qty' => 'QTY',
            'estimasi_jam' => 'Estimasi Jam',
            'actual_jam' => 'Actual Jam',
            'start' => 'Start',
            'target_finish' => 'Target Finish',
            'priority' => 'Priority',
            'on_proses' => 'On Proses',
            'operator' => 'Operator',
            'keterangan' => 'Keterangan'
        ];

        $columnIndex = 'A';
        foreach ($selectedColumns as $columnKey => $columnHeader) {
            $sheet->setCellValue($columnIndex . '1', $columnHeader);
            $columnIndex++;
        }

        $row = 2;
        foreach ($dataloadingmachineplant3 as $item) {
            $columnIndex = 'A';
            foreach ($selectedColumns as $columnKey => $columnHeader) {
                if (isset($item[$columnKey])) {
                    $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
                } else {
                    $sheet->setCellValue($columnIndex . $row, '');
                }
                $columnIndex++;
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/loading_mesin_plant_3.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }
    
    public function LihatDataKeseluruhanLoadingMesinPlant3PLANT2(Request $request)
    {

        $request->validate([
            'search' => 'nullable|string|max:700',
            'opsi_filter' => 'nullable|in:Done,Not Done,All',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $datakeseluruhanloadingmachineplant3 = tb_data_loading_machine_plant3::whereNull('deleted_at')
            ->with('fileProjekLoadingMachinePlant3');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $datakeseluruhanloadingmachineplant3->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' . $search . '%')
                    ->orwhere('project', 'like', '%' . $search . '%')
                    ->orwhere('customer', 'like', '%' . $search . '%')
                    ->orwhere('no_spk', 'like', '%' . $search . '%')
                    ->orwhere('qty', 'like', '%' . $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
                    ->orwhere('actual_jam', 'like', '%' . $search . '%')
                    ->orwhere('start', 'like', '%' . $search . '%')
                    ->orwhere('target_finish', 'like', '%' . $search . '%')
                    ->orwhere('priority', 'like', '%' . $search . '%')
                    ->orwhere('on_proses', 'like', '%' . $search . '%')
                    ->orwhere('operator', 'like', '%' . $search . '%')
                    ->orwhere('keterangan', 'like', '%' . $search . '%')
                    ->orwhere('status_done', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_input', 'like', '%' . $search . '%')
                    ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
                    ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $datakeseluruhanloadingmachineplant3->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $datakeseluruhanloadingmachineplant3->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            } elseif ($opsi === 'All' || $opsi === null) {
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $datakeseluruhanloadingmachineplant3->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $datakeseluruhanloadingmachineplant3count = $datakeseluruhanloadingmachineplant3->count();

        $dataallloadingmachineplant3 = $datakeseluruhanloadingmachineplant3->paginate(10)->WithQueryString();

        return view('UserPPICPlant2.Halaman_Lihat_Data_Keseluruhan_Loading_Machine_Plant_3_PLANT2', [
            'judul' => 'Halaman Data Keseluruhan Loading Machine Plant 3',
            'dataloadingmesinplant3' => $dataallloadingmachineplant3,
            'dataloadingmesinplant3count' => $datakeseluruhanloadingmachineplant3count
        ]);
    }



    public function ExportPDFDataKeseluruhanLoadingMachinePlant3PLANT2(Request $request)
    {

        $datakeseluruhanloadingmachineplant3 = tb_data_loading_machine_plant3::whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $datakeseluruhanloadingmachineplant3->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' . $search . '%')
                    ->orwhere('project', 'like', '%' . $search . '%')
                    ->orwhere('customer', 'like', '%' . $search . '%')
                    ->orwhere('no_spk', 'like', '%' . $search . '%')
                    ->orwhere('qty', 'like', '%' . $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
                    ->orwhere('actual_jam', 'like', '%' . $search . '%')
                    ->orwhere('start', 'like', '%' . $search . '%')
                    ->orwhere('target_finish', 'like', '%' . $search . '%')
                    ->orwhere('priority', 'like', '%' . $search . '%')
                    ->orwhere('on_proses', 'like', '%' . $search . '%')
                    ->orwhere('operator', 'like', '%' . $search . '%')
                    ->orwhere('keterangan', 'like', '%' . $search . '%')
                    ->orwhere('status_done', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_input', 'like', '%' . $search . '%')
                    ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
                    ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $datakeseluruhanloadingmachineplant3->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $datakeseluruhanloadingmachineplant3->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $datakeseluruhanloadingmachineplant3->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $datakeseluruhanloadingmachineplant3count = $datakeseluruhanloadingmachineplant3->count();

        $dataallloadingmachineplant3 = $datakeseluruhanloadingmachineplant3->get();

        $pdf = PDF::loadView('UserPPICPlant2.Export_PDF_Data_Keseluruhan_Loading_Mesin_Plant_3_PLANT2', ['data' => $dataallloadingmachineplant3, 'count' => $datakeseluruhanloadingmachineplant3count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_3.pdf');
    }

    public function ExportExcelDataKeseluruhanLoadingMachinePlant3PLANT2(Request $request)
    {

        $datakeseluruhanloadingmachineplant3 = tb_data_loading_machine_plant3::whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $datakeseluruhanloadingmachineplant3->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' . $search . '%')
                    ->orwhere('project', 'like', '%' . $search . '%')
                    ->orwhere('customer', 'like', '%' . $search . '%')
                    ->orwhere('no_spk', 'like', '%' . $search . '%')
                    ->orwhere('qty', 'like', '%' . $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' . $search . '%')
                    ->orwhere('actual_jam', 'like', '%' . $search . '%')
                    ->orwhere('start', 'like', '%' . $search . '%')
                    ->orwhere('target_finish', 'like', '%' . $search . '%')
                    ->orwhere('priority', 'like', '%' . $search . '%')
                    ->orwhere('on_proses', 'like', '%' . $search . '%')
                    ->orwhere('operator', 'like', '%' . $search . '%')
                    ->orwhere('keterangan', 'like', '%' . $search . '%')
                    ->orwhere('status_done', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_input', 'like', '%' . $search . '%')
                    ->orwhere('user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_data_loading_mesin', 'like', '%' . ($search) . '%')
                    ->orwhere('user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_updated_status_done_loading_mesin', 'like', '%' . $search . '%')
                    ->orwhere('jam_updated_status_done_loading_mesin', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $datakeseluruhanloadingmachineplant3->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $datakeseluruhanloadingmachineplant3->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $datakeseluruhanloadingmachineplant3->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataallloadingmachineplant3 = $datakeseluruhanloadingmachineplant3->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $selectedColumns = [
            'plant' => 'Plant',
            'nama_mesin' => 'Nama Mesin/Proses',
            'status_done' => 'Status Done',
            'project' => 'Project',
            'customer' => 'Customer',
            'no_spk' => 'No SPK',
            'qty' => 'QTY',
            'estimasi_jam' => 'Estimasi Jam',
            'actual_jam' => 'Actual Jam',
            'start' => 'Start',
            'target_finish' => 'Target Finish',
            'priority' => 'Priority',
            'on_proses' => 'On Proses',
            'operator' => 'Operator',
            'keterangan' => 'Keterangan'
        ];

        $columnIndex = 'A';
        foreach ($selectedColumns as $columnKey => $columnHeader) {
            $sheet->setCellValue($columnIndex . '1', $columnHeader);
            $columnIndex++;
        }

        $row = 2;
        foreach ($dataallloadingmachineplant3 as $item) {
            $columnIndex = 'A';
            foreach ($selectedColumns as $columnKey => $columnHeader) {
                if (isset($item[$columnKey])) {
                    $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
                } else {
                    $sheet->setCellValue($columnIndex . $row, '');
                }
                $columnIndex++;
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/loading_mesin_plant_3.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }
    
    
    // FILE PROJEK 

    public function PostTambahDataFileProjekLoadingMachineKeseluruhanPlant2PLNT2(tb_data_loading_machine_plant2 $data, Request $request)
    {

        $time = Carbon::now('Asia/Jakarta');

        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        if ($request->hasFile('file')) {

            $files['fileprojekloadingmachineplant2'] = $request->file('file')->store('fileprojekloadingmachineplant2');
        }

        tb_data_file_projek_loading_machine_plant_2::create([
            'url_unique_loading_machine' => $data->url_unique,
            'url_unique' => Str::uuid(),
            'file' => $files['fileprojekloadingmachineplant2'],
            'tanggal_file_diupload' => $time->format('Y-m-d H:i:s')
        ]);

        return back()->with('PostTambahDataFileProjekLoadingMachineKeseluruhanPlant2PLNT2', 'Tambah Data File Berhasil');
    }

    public function LihatDataKeseluruhanFileProjekLoadingMachinePlant2PLNT2(tb_data_loading_machine_plant2 $data, Request $request)
    {

        $datafileprojek = tb_data_file_projek_loading_machine_plant_2::where('url_unique_loading_machine', $data->url_unique);

        if ($request->has('search')) {

            $search = $request->input('search');

            $datafileprojek->where(function ($query) use ($search) {

                $query->where('tanggal_file_diupload', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_file_diubah', 'like', '%' . $search . '%');
            });
        }

        $datafileprojekcount = $datafileprojek->count();

        $datafile = $datafileprojek->paginate(10)->WithQueryString();

        return view('UserPPICPlant2.Halaman_Lihat_Data_Keseluruhan_File_Projek_Loading_Machine_Plant_2_PLNT2', [
            'judul' => 'Halaman Lihat File Projek',
            'datafileprojek' => $datafile,
            'datafileprojekjumlah' => $datafileprojekcount,
            'data' => $data
        ]);
    }

    public function PostTambahDataFileProjekLoadingMesinKeseluruhanPlant2PLANT2(tb_data_loading_machine_plant2 $data, Request $request)
    {

        $time = Carbon::now('Asia/Jakarta');

        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        if ($request->hasFile('file')) {

            $files['fileprojekloadingmachineplant2'] = $request->file('file')->store('fileprojekloadingmachineplant2');
        }

        tb_data_file_projek_loading_machine_plant_2::create([
            'url_unique_loading_machine' => $data->url_unique,
            'url_unique' => Str::uuid(),
            'file' => $files['fileprojekloadingmachineplant2'],
            'tanggal_file_diupload' => $time->format('Y-m-d H:i:s')
        ]);

        return back()->with('PostTambahDataFileProjekLoadingMesinKeseluruhanPlant2PLANT2', 'Tambah Data File Berhasil');
    }

    public function PostDeleteFileProjekLoadingMachineKeseluruhanPlant2(tb_data_file_projek_loading_machine_plant_2 $file)
    {

        if ($file->file) {

            Storage::delete($file->file);
        }

        $file->delete();

        return back()->with('PostDeleteFileProjekLoadingMachineKeseluruhanPlant2', 'Hapus Data Berhasil');
    }

    public function PostUbahDataFileProjekLoadingMachineKeseluruhanPlant2PLNT2(tb_data_file_projek_loading_machine_plant_2 $file, Request $request)
    {

        $time = Carbon::now('Asia/Jakarta');

        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        if ($request->hasFile('file')) {

            if ($file->file) {

                Storage::delete($file->file);
            }

            $files['fileprojekloadingmachineplant2'] = $request->file('file')->store('fileprojekloadingmachineplant2');
        }

        $file->update([
            'file' => $files['fileprojekloadingmachineplant2'],
            'tanggal_file_diubah' => $time->format('Y-m-d H:i:s')
        ]);

        return back()->with('PostUbahDataFileProjekLoadingMachineKeseluruhanPlant2PLNT2', 'Ubah Data File Berhasil');
    }

    public function PostTambahDataFileProjekLoadingMachinePerMachinePlant2PLANT2(tb_data_loading_machine_plant2 $data, Request $request)
    {

        $time = Carbon::now('Asia/Jakarta');

        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        if ($request->hasFile('file')) {

            $files['fileprojekloadingmachineplant2'] = $request->file('file')->store('fileprojekloadingmachineplant2');
        }

        tb_data_file_projek_loading_machine_plant_2::create([
            'url_unique_loading_machine' => $data->url_unique,
            'url_unique' => Str::uuid(),
            'file' => $files['fileprojekloadingmachineplant2'],
            'tanggal_file_diupload' => $time->format('Y-m-d H:i:s'),
        ]);

        return back()->with('PostTambahDataFileProjekLoadingMachinePerMachinePlant2PLANT2', 'Tambah Data File Berhasil');
    }

    public function LihatDataFileProjekLoadingMachinePerMachinePlant2PLNT2(tb_data_loading_machine_plant2 $data, Request $request)
    {
        $datafileprojek = tb_data_file_projek_loading_machine_plant_2::where('url_unique_loading_machine', $data->url_unique);

        if ($request->has('search')) {

            $search = $request->input('search');

            $datafileprojek->where(function ($query) use ($search) {

                $query->where('tanggal_file_diupload', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_file_diubah', 'like', '%' . $search . '%');
            });
        }

        $datafileprojekcount = $datafileprojek->count();

        $datafile = $datafileprojek->paginate(10)->WithQueryString();

        return view('UserPPICPlant2.Halaman_Lihat_Data_File_Projek_Loading_Machine_Per_Machine_Plant_2_PLNT2', [
            'judul' => 'Halaman Lihat File Projek',
            'datafileprojek' => $datafile,
            'datafileprojekcount' => $datafileprojekcount,
            'data' => $data
        ]);
    }

    public function PostTambahDataFileProjekLoadingMesinPerMesinPlant2PLANT2(tb_data_loading_machine_plant2 $data, Request $request)
    {

        $time = Carbon::now('Asia/Jakarta');

        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        if ($request->hasFile('file')) {

            $files['fileprojekloadingmachineplant2'] = $request->file('file')->store('fileprojekloadingmachineplant2');
        }

        tb_data_file_projek_loading_machine_plant_2::create([
            'url_unique_loading_machine' => $data->url_unique,
            'url_unique' => Str::uuid(),
            'file' => $files['fileprojekloadingmachineplant2'],
            'tanggal_file_diupload' => $time->format('Y-m-d H:i:s')
        ]);

        return back()->with('PostTambahDataFileProjekLoadingMesinPerMesinPlant2PLANT2', 'Tambah Data File Berhasil');
    }

    public function PostDeleteDataFileProjekLoadingMachinePerMachinePlant2PLNT2(tb_data_file_projek_loading_machine_plant_2 $file)
    {

        if ($file->file) {

            Storage::delete($file->file);
        }

        $file->delete();

        return back()->with('PostDeleteDataFileProjekLoadingMachinePerMachinePlant2PLNT2', 'Hapus Data File Berhasil');
    }

    public function PostUbahDataFileProjekLoadingMachinePerMachinePlant2PLNT2(tb_data_file_projek_loading_machine_plant_2 $file, Request $request)
    {

        $time = Carbon::now('Asia/Jakarta');

        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        if ($request->hasFile('file')) {

            if ($file->file) {

                Storage::delete($file->file);
            }

            $files['fileprojekloadingmachineplant2'] = $request->file('file')->store('fileprojekloadingmachineplant2');
        }

        $file->update([
            'file' => $files['fileprojekloadingmachineplant2'],
            'tanggal_file_diubah' => $time->format('Y-m-d H:i:s')
        ]);

        return back()->with('PostUbahDataFileProjekLoadingMachinePerMachinePlant2PLNT2', 'Ubah Data File Berhasil');
    }
    
    
    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE LIHAT DATA KESELURUHAN LOADING MACHINE PLANT 2 PLNT2

    public function ExportPDFStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant2PLNT2(Request $request)
    {

        $datakeseluruhanloadingmachineplant2 = tb_data_loading_machine_plant2::whereNull('deleted_at');

        if ($request->has('start_date') && $request->has('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $datakeseluruhanloadingmachineplant2->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $datakeseluruhanloadingmachineplant2count = $datakeseluruhanloadingmachineplant2->count();

        $dataallloadingmachineplant2 = $datakeseluruhanloadingmachineplant2->get();

        $pdf = PDF::loadView('UserPPICPlant2.Export_PDF_Start_Date_End_Date_Lihat_Data_Keseluruhan_Loading_Machine_Plant2_PLNT2', ['data' => $dataallloadingmachineplant2, 'count' => $datakeseluruhanloadingmachineplant2count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_2.pdf');
    }

    public function ExportExcelStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant2PLNT2(Request $request)
    {

        $datakeseluruhanloadingmachineplant2 = tb_data_loading_machine_plant2::whereNull('deleted_at');

        if ($request->has('start_date') && $request->has('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $datakeseluruhanloadingmachineplant2->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataallloadingmachineplant2 = $datakeseluruhanloadingmachineplant2->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $selectedColumns = [
            'plant' => 'Plant',
            'nama_mesin' => 'Nama Mesin/Proses',
            'status_done' => 'Status Done',
            'project' => 'Project',
            'customer' => 'Customer',
            'no_spk' => 'No SPK',
            'qty' => 'QTY',
            'estimasi_jam' => 'Estimasi Jam',
            'actual_jam' => 'Actual Jam',
            'start' => 'Start',
            'target_finish' => 'Target Finish',
            'priority' => 'Priority',
            'on_proses' => 'On Proses',
            'operator' => 'Operator',
            'keterangan' => 'Keterangan'
        ];

        $columnIndex = 'A';
        foreach ($selectedColumns as $columnKey => $columnHeader) {
            $sheet->setCellValue($columnIndex . '1', $columnHeader);
            $columnIndex++;
        }

        $row = 2;
        foreach ($dataallloadingmachineplant2 as $item) {
            $columnIndex = 'A';
            foreach ($selectedColumns as $columnKey => $columnHeader) {
                if (isset($item[$columnKey])) {
                    $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
                } else {
                    $sheet->setCellValue($columnIndex . $row, '');
                }
                $columnIndex++;
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/loading_mesin_plant_2.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }

    public function ExportPDFFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant2PLNT2(Request $request)
    {

        $datakeseluruhanloadingmachineplant2 = tb_data_loading_machine_plant2::whereNull('deleted_at');

        $filter = $request->query('opsi_filter');

        if ($filter === 'Not Done') {

            $datakeseluruhanloadingmachineplant2->where(function ($query) {

                $query->where('status_done', 'Not Done');
            });
        } elseif ($filter === 'Done') {

            $datakeseluruhanloadingmachineplant2->where(function ($query) {

                $query->where('status_done', 'Done');
            });
        } elseif ($filter === 'All' || $filter === null) {
        }

        $datakeseluruhanloadingmachineplant2count = $datakeseluruhanloadingmachineplant2->count();

        $dataallloadingmachineplant2 = $datakeseluruhanloadingmachineplant2->get();

        $pdf = PDF::loadView('UserPPICPlant2.Export_PDF_Filter_Done_Not_Done_Lihat_Data_Keseluruhan_Loading_Machine_Plant2_PLNT2', ['data' => $dataallloadingmachineplant2, 'count' => $datakeseluruhanloadingmachineplant2count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_2.pdf');
    }

    public function ExportExcelFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant2PLNT2(Request $request)
    {

        $datakeseluruhanloadingmachineplant2 = tb_data_loading_machine_plant2::whereNull('deleted_at');

        $filter = $request->query('opsi_filter');

        if ($filter === 'Not Done') {

            $datakeseluruhanloadingmachineplant2->where(function ($query) {

                $query->where('status_done', 'Not Done');
            });
        } elseif ($filter === 'Done') {

            $datakeseluruhanloadingmachineplant2->where(function ($query) {

                $query->where('status_done', 'Done');
            });
        } elseif ($filter === 'All' || $filter === null) {
        }

        $dataallloadingmachineplant2 = $datakeseluruhanloadingmachineplant2->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $selectedColumns = [
            'plant' => 'Plant',
            'nama_mesin' => 'Nama Mesin/Proses',
            'status_done' => 'Status Done',
            'project' => 'Project',
            'customer' => 'Customer',
            'no_spk' => 'No SPK',
            'qty' => 'QTY',
            'estimasi_jam' => 'Estimasi Jam',
            'actual_jam' => 'Actual Jam',
            'start' => 'Start',
            'target_finish' => 'Target Finish',
            'priority' => 'Priority',
            'on_proses' => 'On Proses',
            'operator' => 'Operator',
            'keterangan' => 'Keterangan'
        ];

        $columnIndex = 'A';
        foreach ($selectedColumns as $columnKey => $columnHeader) {
            $sheet->setCellValue($columnIndex . '1', $columnHeader);
            $columnIndex++;
        }

        $row = 2;
        foreach ($dataallloadingmachineplant2 as $item) {
            $columnIndex = 'A';
            foreach ($selectedColumns as $columnKey => $columnHeader) {
                if (isset($item[$columnKey])) {
                    $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
                } else {
                    $sheet->setCellValue($columnIndex . $row, '');
                }
                $columnIndex++;
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/loading_mesin_plant_2.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }
    
    
    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE LIHAT SEMUA DATA DETAIL LOADING MACHINE PLANT2 PLN 2

    public function ExportPDFStartDatEndDateLihatSemuaDataDetailLoadingMachinePlant2PLNT2(tb_data_mesin_plant_2 $mesin, Request $request)
    {

        $dataloadingmachineplant2 = tb_data_loading_machine_plant2::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->has('start_date') && $request->has('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmachineplant2->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmachineplant2count = $dataloadingmachineplant2->count();

        $dataloadingmachine = $dataloadingmachineplant2->get();

        $pdf = PDF::loadView('UserPPICPlant2.Export_PDF_Start_Date_End_Date_Lihat_Semua_Data_Detail_Loading_Machine_Plant2_PLNT2', ['data' => $dataloadingmachine, 'count' => $dataloadingmachineplant2count, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_2.pdf');
    }

    public function ExportExcelStartDateEndDateLihatSemuaDataDetailLoadingMachinePlant2PLNT2(tb_data_mesin_plant_2 $mesin, Request $request)
    {

        $dataloadingmachineplant2 = tb_data_loading_machine_plant2::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->has('start_date') && $request->has('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmachineplant2->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmachine = $dataloadingmachineplant2->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $selectedColumns = [
            'plant' => 'Plant',
            'nama_mesin' => 'Nama Mesin/Proses',
            'status_done' => 'Status Done',
            'project' => 'Project',
            'customer' => 'Customer',
            'no_spk' => 'No SPK',
            'qty' => 'QTY',
            'estimasi_jam' => 'Estimasi Jam',
            'actual_jam' => 'Actual Jam',
            'start' => 'Start',
            'target_finish' => 'Target Finish',
            'priority' => 'Priority',
            'on_proses' => 'On Proses',
            'operator' => 'Operator',
            'keterangan' => 'Keterangan'
        ];

        $columnIndex = 'A';
        foreach ($selectedColumns as $columnKey => $columnHeader) {
            $sheet->setCellValue($columnIndex . '1', $columnHeader);
            $columnIndex++;
        }

        $row = 2;
        foreach ($dataloadingmachine as $item) {
            $columnIndex = 'A';
            foreach ($selectedColumns as $columnKey => $columnHeader) {
                if (isset($item[$columnKey])) {
                    $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
                } else {
                    $sheet->setCellValue($columnIndex . $row, '');
                }
                $columnIndex++;
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/loading_mesin_plant_2.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }

    public function ExportPDFFilterDoneNotDoneLihatSemuaDataDetailLoadingMachinePlant2PLN2(tb_data_mesin_plant_2 $mesin, Request $request)
    {

        $dataloadingmachineplant2 = tb_data_loading_machine_plant2::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        $filter = $request->query('opsi_filter');

        if ($filter === 'Not Done') {

            $dataloadingmachineplant2->where(function ($query) {

                $query->where('status_done', 'Not Done');
            });
        } elseif ($filter === 'Done') {

            $dataloadingmachineplant2->where(function ($query) {

                $query->where('status_done', 'Done');
            });
        } elseif ($filter === 'All' || $filter === null) {
        }

        $dataloadingmachineplant2count = $dataloadingmachineplant2->count();

        $dataloadingmachine = $dataloadingmachineplant2->get();

        $pdf = PDF::loadView('UserPPICPlant2.Export_PDF_Filter_Done_Not_Done_Lihat_Semua_Data_Detail_Loading_Machine_Plant2_PLN2', ['data' => $dataloadingmachine, 'count' => $dataloadingmachineplant2count, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_2.pdf');
    }

    public function ExportExcelFilterDoneNotDoneLihatSemuaDataDetailLoadingMachinePlant2PLN2(tb_data_mesin_plant_2 $mesin, Request $request)
    {

        $dataloadingmachineplant2 = tb_data_loading_machine_plant2::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        $filter = $request->query('opsi_filter');

        if ($filter === 'Not Done') {

            $dataloadingmachineplant2->where(function ($query) {

                $query->where('status_done', 'Not Done');
            });
        } elseif ($filter === 'Done') {

            $dataloadingmachineplant2->where(function ($query) {

                $query->where('status_done', 'Done');
            });
        } elseif ($filter === 'All' || $filter === null) {
        }

        $dataloadingmachine = $dataloadingmachineplant2->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $selectedColumns = [
            'plant' => 'Plant',
            'nama_mesin' => 'Nama Mesin/Proses',
            'status_done' => 'Status Done',
            'project' => 'Project',
            'customer' => 'Customer',
            'no_spk' => 'No SPK',
            'qty' => 'QTY',
            'estimasi_jam' => 'Estimasi Jam',
            'actual_jam' => 'Actual Jam',
            'start' => 'Start',
            'target_finish' => 'Target Finish',
            'priority' => 'Priority',
            'on_proses' => 'On Proses',
            'operator' => 'Operator',
            'keterangan' => 'Keterangan'
        ];

        $columnIndex = 'A';
        foreach ($selectedColumns as $columnKey => $columnHeader) {
            $sheet->setCellValue($columnIndex . '1', $columnHeader);
            $columnIndex++;
        }

        $row = 2;
        foreach ($dataloadingmachine as $item) {
            $columnIndex = 'A';
            foreach ($selectedColumns as $columnKey => $columnHeader) {
                if (isset($item[$columnKey])) {
                    $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
                } else {
                    $sheet->setCellValue($columnIndex . $row, '');
                }
                $columnIndex++;
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/loading_mesin_plant_2.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }
    
    
    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE LIHAT DATA KESELURUHAN LOADING MACHINE PLANT1 PLANT2 

    public function ExportPDFStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant1PLANT2(Request $request)
    {

        $datakeseluruhanloadingmachineplant1 = tb_data_loading_machine_plant1::whereNull('deleted_at');

        if ($request->has('start_date') && $request->has('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $datakeseluruhanloadingmachineplant1->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $datakeseluruhanloadingmachineplant1count = $datakeseluruhanloadingmachineplant1->count();

        $dataallloadingmachineplant1 = $datakeseluruhanloadingmachineplant1->get();

        $pdf = PDF::loadView('UserPPICPlant2.Export_PDF_Start_Date_End_Date_Lihat_Data_Keseluruhan_Loading_Machine_Plant1_PLANT2', ['data' => $dataallloadingmachineplant1, 'count' => $datakeseluruhanloadingmachineplant1count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_1.pdf');
    }

    public function ExportExcelStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant1PLANT2(Request $request)
    {
        $datakeseluruhanloadingmachineplant1 = tb_data_loading_machine_plant1::whereNull('deleted_at');

        if ($request->has('start_date') && $request->has('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $datakeseluruhanloadingmachineplant1->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataallloadingmachineplant1 = $datakeseluruhanloadingmachineplant1->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $selectedColumns = [
            'plant' => 'Plant',
            'nama_mesin' => 'Nama Mesin/Proses',
            'status_done' => 'Status Done',
            'project' => 'Project',
            'customer' => 'Customer',
            'no_spk' => 'No SPK',
            'qty' => 'QTY',
            'estimasi_jam' => 'Estimasi Jam',
            'actual_jam' => 'Actual Jam',
            'start' => 'Start',
            'target_finish' => 'Target Finish',
            'priority' => 'Priority',
            'on_proses' => 'On Proses',
            'operator' => 'Operator',
            'keterangan' => 'Keterangan'
        ];

        $columnIndex = 'A';
        foreach ($selectedColumns as $columnKey => $columnHeader) {
            $sheet->setCellValue($columnIndex . '1', $columnHeader);
            $columnIndex++;
        }

        $row = 2;
        foreach ($dataallloadingmachineplant1 as $item) {
            $columnIndex = 'A';
            foreach ($selectedColumns as $columnKey => $columnHeader) {
                if (isset($item[$columnKey])) {
                    $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
                } else {
                    $sheet->setCellValue($columnIndex . $row, '');
                }
                $columnIndex++;
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/loading_mesin_plant_1.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }

    public function ExportPDFFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant1PLANT2(Request $request)
    {

        $datakeseluruhanloadingmachineplant1 = tb_data_loading_machine_plant1::whereNull('deleted_at');

        $filter = $request->query('opsi_filter');

        if ($filter === 'Not Done') {

            $datakeseluruhanloadingmachineplant1->where(function ($query) {

                $query->where('status_done', 'Not Done');
            });
        } elseif ($filter === 'Done') {

            $datakeseluruhanloadingmachineplant1->where(function ($query) {

                $query->where('status_done', 'Done');
            });
        } elseif ($filter === 'All' || $filter === null) {
        }

        $datakeseluruhanloadingmachineplant1count = $datakeseluruhanloadingmachineplant1->count();

        $dataallloadingmachineplant1 = $datakeseluruhanloadingmachineplant1->get();

        $pdf = PDF::loadView('UserPPICPlant2.Export_PDF_Filter_Done_Not_Done_Lihat_Data_Keseluruhan_Loading_Machine_Plant1_PLANT2', ['data' => $dataallloadingmachineplant1, 'count' => $datakeseluruhanloadingmachineplant1count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_1.pdf');
    }

    public function ExportExcelFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant1PLANT2(Request $request)
    {

        $datakeseluruhanloadingmachineplant1 = tb_data_loading_machine_plant1::whereNull('deleted_at');

        $filter = $request->query('opsi_filter');

        if ($filter === 'Not Done') {

            $datakeseluruhanloadingmachineplant1->where(function ($query) {

                $query->where('status_done', 'Not Done');
            });
        } elseif ($filter === 'Done') {

            $datakeseluruhanloadingmachineplant1->where(function ($query) {

                $query->where('status_done', 'Done');
            });
        } elseif ($filter === 'All' || $filter === null) {
        }

        $dataallloadingmachineplant1 = $datakeseluruhanloadingmachineplant1->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $selectedColumns = [
            'plant' => 'Plant',
            'nama_mesin' => 'Nama Mesin/Proses',
            'status_done' => 'Status Done',
            'project' => 'Project',
            'customer' => 'Customer',
            'no_spk' => 'No SPK',
            'qty' => 'QTY',
            'estimasi_jam' => 'Estimasi Jam',
            'actual_jam' => 'Actual Jam',
            'start' => 'Start',
            'target_finish' => 'Target Finish',
            'priority' => 'Priority',
            'on_proses' => 'On Proses',
            'operator' => 'Operator',
            'keterangan' => 'Keterangan'
        ];

        $columnIndex = 'A';
        foreach ($selectedColumns as $columnKey => $columnHeader) {
            $sheet->setCellValue($columnIndex . '1', $columnHeader);
            $columnIndex++;
        }

        $row = 2;
        foreach ($dataallloadingmachineplant1 as $item) {
            $columnIndex = 'A';
            foreach ($selectedColumns as $columnKey => $columnHeader) {
                if (isset($item[$columnKey])) {
                    $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
                } else {
                    $sheet->setCellValue($columnIndex . $row, '');
                }
                $columnIndex++;
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/loading_mesin_plant_1.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }
    
    
    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE lihatsemuadatadetailloadingmesinpermesinplant1 plant 2


    public function ExportPDFStartDateEndDateLihatSemuaDataDetailLoadingMesinPerMesinPlant1PLANT2(tb_data_mesin $mesin, Request $request)
    {

        $dataloadingmachineplant1 = tb_data_loading_machine_plant1::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->has('start_date') && $request->has('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmachineplant1->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmachineplant1count = $dataloadingmachineplant1->count();

        $dataloadingmachine = $dataloadingmachineplant1->get();

        $pdf = PDF::loadView('UserPPICPlant2.Export_PDF_Start_Date_End_Date_Lihat_Semua_Data_Detail_Loading_Mesin_Per_Mesin_Plant1_PLANT2', ['data' => $dataloadingmachine, 'count' => $dataloadingmachineplant1count, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_1.pdf');
    }

    public function ExportExcelStartDateEndDateLihatSemuaDataDetailLoadingMesinPerMesinPlant1PLANT2(tb_data_mesin $mesin, Request $request)
    {

        $dataloadingmachineplant1 = tb_data_loading_machine_plant1::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->has('start_date') && $request->has('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmachineplant1->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmachine = $dataloadingmachineplant1->get();


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $selectedColumns = [
            'plant' => 'Plant',
            'nama_mesin' => 'Nama Mesin/Proses',
            'status_done' => 'Status Done',
            'project' => 'Project',
            'customer' => 'Customer',
            'no_spk' => 'No SPK',
            'qty' => 'QTY',
            'estimasi_jam' => 'Estimasi Jam',
            'actual_jam' => 'Actual Jam',
            'start' => 'Start',
            'target_finish' => 'Target Finish',
            'priority' => 'Priority',
            'on_proses' => 'On Proses',
            'operator' => 'Operator',
            'keterangan' => 'Keterangan'
        ];

        $columnIndex = 'A';
        foreach ($selectedColumns as $columnKey => $columnHeader) {
            $sheet->setCellValue($columnIndex . '1', $columnHeader);
            $columnIndex++;
        }

        $row = 2;
        foreach ($dataloadingmachine as $item) {
            $columnIndex = 'A';
            foreach ($selectedColumns as $columnKey => $columnHeader) {
                if (isset($item[$columnKey])) {
                    $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
                } else {
                    $sheet->setCellValue($columnIndex . $row, '');
                }
                $columnIndex++;
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/loading_mesin_plant_1.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }

    public function ExportPDFFilterDoneNotDoneLihatSemuaDataDetailLoadingMesinPerMesinPlant1PLANT2(tb_data_mesin $mesin, Request $request)
    {

        $dataloadingmachineplant1 = tb_data_loading_machine_plant1::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        $filter = $request->query('opsi_filter');

        if ($filter === 'Not Done') {

            $dataloadingmachineplant1->where(function ($query) {

                $query->where('status_done', 'Not Done');
            });
        } elseif ($filter === 'Done') {

            $dataloadingmachineplant1->where(function ($query) {

                $query->where('status_done', 'Done');
            });
        } elseif ($filter === 'All' || $filter === null) {
        }

        $dataloadingmachineplant1count = $dataloadingmachineplant1->count();

        $dataloadingmachine = $dataloadingmachineplant1->get();

        $pdf = PDF::loadView('UserPPICPlant2.Export_PDF_Filter_Done_Not_Done_Lihat_Semua_Data_Detail_Loading_Mesin_Per_Mesin_Plant1_PLANT2', ['data' => $dataloadingmachine, 'count' => $dataloadingmachineplant1count, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_1.pdf');
    }


    public function ExportExcelFilterDoneNotDoneLihatSemuaDataDetailLoadingMesinPerMesinPlant1PLANT2(tb_data_mesin $mesin, Request $request)
    {

        $dataloadingmachineplant1 = tb_data_loading_machine_plant1::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        $filter = $request->query('opsi_filter');

        if ($filter === 'Not Done') {

            $dataloadingmachineplant1->where(function ($query) {

                $query->where('status_done', 'Not Done');
            });
        } elseif ($filter === 'Done') {

            $dataloadingmachineplant1->where(function ($query) {

                $query->where('status_done', 'Done');
            });
        } elseif ($filter === 'All' || $filter === null) {
        }

        $dataloadingmachine = $dataloadingmachineplant1->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $selectedColumns = [
            'plant' => 'Plant',
            'nama_mesin' => 'Nama Mesin/Proses',
            'status_done' => 'Status Done',
            'project' => 'Project',
            'customer' => 'Customer',
            'no_spk' => 'No SPK',
            'qty' => 'QTY',
            'estimasi_jam' => 'Estimasi Jam',
            'actual_jam' => 'Actual Jam',
            'start' => 'Start',
            'target_finish' => 'Target Finish',
            'priority' => 'Priority',
            'on_proses' => 'On Proses',
            'operator' => 'Operator',
            'keterangan' => 'Keterangan'
        ];

        $columnIndex = 'A';
        foreach ($selectedColumns as $columnKey => $columnHeader) {
            $sheet->setCellValue($columnIndex . '1', $columnHeader);
            $columnIndex++;
        }

        $row = 2;
        foreach ($dataloadingmachine as $item) {
            $columnIndex = 'A';
            foreach ($selectedColumns as $columnKey => $columnHeader) {
                if (isset($item[$columnKey])) {
                    $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
                } else {
                    $sheet->setCellValue($columnIndex . $row, '');
                }
                $columnIndex++;
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/loading_mesin_plant_1.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }
    
    
    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE lihatdatakeseluruhanloadingmesinplant3 plant2

    public function ExportPDFStartDateEndDatelLihatDataKeseluruhanLoadingMachinePlant3PLANT2(Request $request)
    {

        $datakeseluruhanloadingmachineplant3 = tb_data_loading_machine_plant3::whereNull('deleted_at');

        if ($request->has('start_date') && $request->has('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $datakeseluruhanloadingmachineplant3->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $datakeseluruhanloadingmachineplant3count = $datakeseluruhanloadingmachineplant3->count();

        $dataallloadingmachineplant3 = $datakeseluruhanloadingmachineplant3->get();

        $pdf = PDF::loadView('UserPPICPlant2.Export_PDF_Start_Date_End_Datel_Lihat_Data_Keseluruhan_Loading_Machine_Plant3_PLANT2', ['data' => $dataallloadingmachineplant3, 'count' => $datakeseluruhanloadingmachineplant3count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_3.pdf');
    }


    public function ExportExcelStartDateEndDatelLihatDataKeseluruhanLoadingMachinePlant3PLANT2(Request $request)
    {

        $datakeseluruhanloadingmachineplant3 = tb_data_loading_machine_plant3::whereNull('deleted_at');

        if ($request->has('start_date') && $request->has('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $datakeseluruhanloadingmachineplant3->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataallloadingmachineplant3 = $datakeseluruhanloadingmachineplant3->get();


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $selectedColumns = [
            'plant' => 'Plant',
            'nama_mesin' => 'Nama Mesin/Proses',
            'status_done' => 'Status Done',
            'project' => 'Project',
            'customer' => 'Customer',
            'no_spk' => 'No SPK',
            'qty' => 'QTY',
            'estimasi_jam' => 'Estimasi Jam',
            'actual_jam' => 'Actual Jam',
            'start' => 'Start',
            'target_finish' => 'Target Finish',
            'priority' => 'Priority',
            'on_proses' => 'On Proses',
            'operator' => 'Operator',
            'keterangan' => 'Keterangan'
        ];

        $columnIndex = 'A';
        foreach ($selectedColumns as $columnKey => $columnHeader) {
            $sheet->setCellValue($columnIndex . '1', $columnHeader);
            $columnIndex++;
        }

        $row = 2;
        foreach ($dataallloadingmachineplant3 as $item) {
            $columnIndex = 'A';
            foreach ($selectedColumns as $columnKey => $columnHeader) {
                if (isset($item[$columnKey])) {
                    $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
                } else {
                    $sheet->setCellValue($columnIndex . $row, '');
                }
                $columnIndex++;
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/loading_mesin_plant_3.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }


    public function ExportPDFFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant3PLANT2(Request $request)
    {

        $datakeseluruhanloadingmachineplant3 = tb_data_loading_machine_plant3::whereNull('deleted_at');

        $filter = $request->query('opsi_filter');

        if ($filter === 'Not Done') {

            $datakeseluruhanloadingmachineplant3->where(function ($query) {

                $query->where('status_done', 'Not Done');
            });
        } elseif ($filter === 'Done') {

            $datakeseluruhanloadingmachineplant3->where(function ($query) {

                $query->where('status_done', 'Done');
            });
        } elseif ($filter === 'All' || $filter === null) {
        }

        $datakeseluruhanloadingmachineplant3count = $datakeseluruhanloadingmachineplant3->count();

        $dataallloadingmachineplant3 = $datakeseluruhanloadingmachineplant3->get();

        $pdf = PDF::loadView('UserPPICPlant2.Export_PDF_Filter_Done_Not_Done_Lihat_Data_Keseluruhan_Loading_Machine_Plant3_PLANT2', ['data' => $dataallloadingmachineplant3, 'count' => $datakeseluruhanloadingmachineplant3count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_3.pdf');
    }


    public function ExportExcelFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant3PLANT2(Request $request)
    {

        $datakeseluruhanloadingmachineplant3 = tb_data_loading_machine_plant3::whereNull('deleted_at');

        $filter = $request->query('opsi_filter');

        if ($filter === 'Not Done') {

            $datakeseluruhanloadingmachineplant3->where(function ($query) {

                $query->where('status_done', 'Not Done');
            });
        } elseif ($filter === 'Done') {

            $datakeseluruhanloadingmachineplant3->where(function ($query) {

                $query->where('status_done', 'Done');
            });
        } elseif ($filter === 'All' || $filter === null) {
        }

        $dataallloadingmachineplant3 = $datakeseluruhanloadingmachineplant3->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $selectedColumns = [
            'plant' => 'Plant',
            'nama_mesin' => 'Nama Mesin/Proses',
            'status_done' => 'Status Done',
            'project' => 'Project',
            'customer' => 'Customer',
            'no_spk' => 'No SPK',
            'qty' => 'QTY',
            'estimasi_jam' => 'Estimasi Jam',
            'actual_jam' => 'Actual Jam',
            'start' => 'Start',
            'target_finish' => 'Target Finish',
            'priority' => 'Priority',
            'on_proses' => 'On Proses',
            'operator' => 'Operator',
            'keterangan' => 'Keterangan'
        ];

        $columnIndex = 'A';
        foreach ($selectedColumns as $columnKey => $columnHeader) {
            $sheet->setCellValue($columnIndex . '1', $columnHeader);
            $columnIndex++;
        }

        $row = 2;
        foreach ($dataallloadingmachineplant3 as $item) {
            $columnIndex = 'A';
            foreach ($selectedColumns as $columnKey => $columnHeader) {
                if (isset($item[$columnKey])) {
                    $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
                } else {
                    $sheet->setCellValue($columnIndex . $row, '');
                }
                $columnIndex++;
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/loading_mesin_plant_3.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }
    
    
    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE lihatsemuadatadetailloadingmachinepermachineplant3 plant2

    public function ExportPDFStartDateEndDateLihatSemuaDataDetailLoadingMachinePerMachinePlant3PLANT2(tb_data_mesin_plant_3 $mesin, Request $request)
    {

        $dataloadingmachineplant3 = tb_data_loading_machine_plant3::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->has('start_date') && $request->has('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmachineplant3->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmachineplant3count = $dataloadingmachineplant3->count();

        $dataloadingmachine = $dataloadingmachineplant3->get();

        $pdf = PDF::loadView('UserPPICPlant2.Export_PDF_Start_Date_End_Date_Lihat_Semua_Data_Detail_Loading_Machine_Per_Machine_Plant3_PLANT2', ['data' => $dataloadingmachine, 'count' => $dataloadingmachineplant3count, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_3.pdf');
    }


    public function ExportExcelStartDateEndDateLihatSemuaDataDetailLoadingMachinePerMachinePlant3PLANT2(tb_data_mesin_plant_3 $mesin, Request $request)
    {

        $dataloadingmachineplant3 = tb_data_loading_machine_plant3::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->has('start_date') && $request->has('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmachineplant3->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmachine = $dataloadingmachineplant3->get();


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $selectedColumns = [
            'plant' => 'Plant',
            'nama_mesin' => 'Nama Mesin/Proses',
            'status_done' => 'Status Done',
            'project' => 'Project',
            'customer' => 'Customer',
            'no_spk' => 'No SPK',
            'qty' => 'QTY',
            'estimasi_jam' => 'Estimasi Jam',
            'actual_jam' => 'Actual Jam',
            'start' => 'Start',
            'target_finish' => 'Target Finish',
            'priority' => 'Priority',
            'on_proses' => 'On Proses',
            'operator' => 'Operator',
            'keterangan' => 'Keterangan'
        ];

        $columnIndex = 'A';
        foreach ($selectedColumns as $columnKey => $columnHeader) {
            $sheet->setCellValue($columnIndex . '1', $columnHeader);
            $columnIndex++;
        }

        $row = 2;
        foreach ($dataloadingmachine as $item) {
            $columnIndex = 'A';
            foreach ($selectedColumns as $columnKey => $columnHeader) {
                if (isset($item[$columnKey])) {
                    $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
                } else {
                    $sheet->setCellValue($columnIndex . $row, '');
                }
                $columnIndex++;
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/loading_mesin_plant_3.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }


    public function ExportPDFFilterDoneNotDoneLihatSemuaDataDetailLoadingMachinePerMachinePlant3PLANT2(tb_data_mesin_plant_3 $mesin, Request $request)
    {

        $dataloadingmachineplant3 = tb_data_loading_machine_plant3::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        $filter = $request->query('opsi_filter');

        if ($filter === 'Not Done') {

            $dataloadingmachineplant3->where(function ($query) {

                $query->where('status_done', 'Not Done');
            });
        } elseif ($filter === 'Done') {

            $dataloadingmachineplant3->where(function ($query) {

                $query->where('status_done', 'Done');
            });
        } elseif ($filter === 'All' || $filter === null) {
        }

        $dataloadingmachineplant3count = $dataloadingmachineplant3->count();

        $dataloadingmachine = $dataloadingmachineplant3->get();

        $pdf = PDF::loadView('UserPPICPlant2.Export_PDF_Filter_Done_Not_Done_Lihat_Semua_Data_Detail_Loading_Machine_Per_Machine_Plant3_PLANT2', ['data' => $dataloadingmachine, 'count' => $dataloadingmachineplant3count, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_3.pdf');
    }


    public function ExportExcelFilterDoneNotDoneLihatSemuaDataDetailLoadingMachinePerMachinePlant3PLANT2(tb_data_mesin_plant_3 $mesin, Request $request)
    {

        $dataloadingmachineplant3 = tb_data_loading_machine_plant3::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        $filter = $request->query('opsi_filter');

        if ($filter === 'Not Done') {

            $dataloadingmachineplant3->where(function ($query) {

                $query->where('status_done', 'Not Done');
            });
        } elseif ($filter === 'Done') {

            $dataloadingmachineplant3->where(function ($query) {

                $query->where('status_done', 'Done');
            });
        } elseif ($filter === 'All' || $filter === null) {
        }

        $dataloadingmachine = $dataloadingmachineplant3->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $selectedColumns = [
            'plant' => 'Plant',
            'nama_mesin' => 'Nama Mesin/Proses',
            'status_done' => 'Status Done',
            'project' => 'Project',
            'customer' => 'Customer',
            'no_spk' => 'No SPK',
            'qty' => 'QTY',
            'estimasi_jam' => 'Estimasi Jam',
            'actual_jam' => 'Actual Jam',
            'start' => 'Start',
            'target_finish' => 'Target Finish',
            'priority' => 'Priority',
            'on_proses' => 'On Proses',
            'operator' => 'Operator',
            'keterangan' => 'Keterangan'
        ];

        $columnIndex = 'A';
        foreach ($selectedColumns as $columnKey => $columnHeader) {
            $sheet->setCellValue($columnIndex . '1', $columnHeader);
            $columnIndex++;
        }

        $row = 2;
        foreach ($dataloadingmachine as $item) {
            $columnIndex = 'A';
            foreach ($selectedColumns as $columnKey => $columnHeader) {
                if (isset($item[$columnKey])) {
                    $sheet->setCellValue($columnIndex . $row, $item[$columnKey]);
                } else {
                    $sheet->setCellValue($columnIndex . $row, '');
                }
                $columnIndex++;
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/loading_mesin_plant_3.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }
}
