<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
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
use App\Models\tb_data_image_drawing;
use App\Models\tb_data_nama_projek_spk;
use App\Models\tb_data_spk_ppic_plant1;
use App\Models\tb_data_spk_ppic_plant2;
use App\Models\tb_data_spk_ppic_plant3;
use Illuminate\Support\Facades\Storage;
use App\Models\tb_data_comodity_part_item;
use App\Models\tb_data_item_part_nama_projek;
use App\Models\tb_data_loading_machine_plant1;
use App\Models\tb_data_loading_machine_plant2;
use App\Models\tb_data_loading_machine_plant3;
use App\Models\tb_data_image_drawing_ppic_plant1;
use App\Models\tb_data_image_drawing_ppic_plant2;
use App\Models\laporan_loading_mesin_plant_1_stm_plant_3;
use App\Models\tb_data_laporan_loading_machine_plant_1;
use App\Models\tb_data_mesin_plant_3;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Colors\Rgb\Channels\Red;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\tb_data_mesin_plant_2;
use App\Models\tb_data_file_projek_loading_machine_plant_1;
use App\Models\tb_data_file_projek_loading_machine_plant_2;
use App\Models\tb_data_file_projek_loading_machine_plant_3;

class ControllerPPICPlant3 extends Controller
{
    public function DashboardPPICPlant3()
    {
        return view('UserPPICPlant3.Halaman_Dashboard_PPIC_Plant3', [
            'judul' => 'Halaman Dashboard PPIC Plant 3'
        ]);
    }

    public function DataLoadingMachinePPICPlant3()
    {
        return view('UserPPICPlant3.Halaman_Data_Loading_Mesin_PPIC_Plant3', [
            'judul' => 'Halaman Data Loading Mesin',
            'datamesin' => tb_data_mesin_plant_3::all()
        ]);
    }


    public function DetailDataLoadingMachinePPICPlant3(tb_data_mesin_plant_3 $mesin, Request $request)
    {

        $request->validate([
            'search' => 'nullable|string|max:700',
            'opsi_filter' => 'nullable|in:Done,Not Done,All',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $dataloadingmesin = tb_data_loading_machine_plant3::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmesin->where(function ($query) use ($search) {
                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
                    ->orwhere('project', 'like', '%' .  $search . '%')
                    ->orwhere('customer', 'like', '%' .  $search . '%')
                    ->orwhere('no_spk', 'like', '%' .  $search . '%')
                    ->orWhere('qty', 'like', '%' .  $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
                    ->orWhere('actual_jam', 'like', '%' .  $search . '%')
                    ->orWhere('start', 'like', '%' .  $search . '%')
                    ->orWhere('target_finish', 'like', '%' .  $search . '%')
                    ->orWhere('priority', 'like', '%' .  $search . '%')
                    ->orWhere('on_proses', 'like', '%' .  $search . '%')
                    ->orWhere('operator', 'like', '%' .  $search . '%')
                    ->orWhere('keterangan', 'like', '%' .  $search . '%')
                    ->orWhere('status_done', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
                    ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
            });
        }


        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $dataloadingmesin->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $dataloadingmesin->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            } elseif ($opsi === 'All' || $opsi === null) {
            }
        }


        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmesin->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmesincount = $dataloadingmesin->count();

        $dataloadingmachine = $dataloadingmesin->paginate(10)->WithQueryString();

        return view('UserPPICPlant3.Halaman_Detail_Data_Loading_Machine_PPIC_Plant3', [
            'judul' => 'Halaman Detail Data Loading Mesin',
            'mesin' => $mesin,
            'dataloadingmesin' => $dataloadingmachine,
            'datamesin' => tb_data_mesin_plant_3::all(),
            'dataloadingmesincount' => $dataloadingmesincount
        ]);
    }


    public function PostDeleteDataLoadingMesinPlant3PLN3(tb_data_loading_machine_plant3 $data)
    {
        if ($data) {

            $data->delete();
        }

        return back()->with('PostDeleteDataLoadingMesinPlant3PLN3', 'Hapus Data Berhasil');
    }


    public function PostEditDetailDataLoadingMesinSPKPPICPlant3(tb_data_loading_machine_plant3 $data, Request $request)
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
            'qty' => HtmlPurifierHelper::clean($request->input('qty')),
            'estimasi_jam' => HtmlPurifierHelper::clean($request->input('estimasi_jam')),
            'actual_jam' => HtmlPurifierHelper::clean($request->input('actual_jam')),
            'start' => HtmlPurifierHelper::clean($request->input('start')),
            'target_finish' => HtmlPurifierHelper::clean($request->input('target_finish')),
            'priority' => HtmlPurifierHelper::clean($request->input('priority')),
            'operator' => HtmlPurifierHelper::clean($request->input('operator')),
            'keterangan' => HtmlPurifierHelper::clean($request->input('keterangan')),
            'user_pengupdated_data_loading_mesin' => auth()->user()->nama_user,
            'departemen_user_pengupdated_data_loading_mesin' => auth()->user()->departemen,
            'plant_user_pengupdated_data_loading_mesin' => auth()->user()->plant,
            'tanggal_updated_data_loading_mesin' => $time->format('Y-m-d'),
            'jam_updated_data_loading_mesin' => $time->format('H:i:s')
        ]);

        return back()->with('PostEditDetailDataLoadingMesinSPKPPICPlant3', 'Edit Data Loading Machine Berhasil');
    }


    public function UpdateStatusDoneDataDetailLoadingMachinePlant3(tb_data_loading_machine_plant3 $data)
    {
        $time = Carbon::now('Asia/Jakarta');

        $array1 = [
            'status_done' => 'Not Done',
            'on_proses' => 'On',
            'user_pengupdated_status_done_loading_mesin' => auth()->user()->nama_user,
            'departemen_user_pengupdated_status_done_loading_mesin' => auth()->user()->departemen,
            'plant_user_pengupdated_status_done_loading_mesin' => auth()->user()->plant,
            'tanggal_updated_status_done_loading_mesin' => HtmlPurifierHelper::clean($time->format('Y-m-d')),
            'jam_updated_status_done_loading_mesin' => HtmlPurifierHelper::clean($time->format('H:i:s'))
        ];

        $array2 = [
            'status_done' => 'Done',
            'on_proses' => 'Ok',
            'user_pengupdated_status_done_loading_mesin' => auth()->user()->nama_user,
            'departemen_user_pengupdated_status_done_loading_mesin' => auth()->user()->departemen,
            'plant_user_pengupdated_status_done_loading_mesin' => auth()->user()->plant,
            'tanggal_updated_status_done_loading_mesin' => HtmlPurifierHelper::clean($time->format('Y-m-d')),
            'jam_updated_status_done_loading_mesin' => HtmlPurifierHelper::clean($time->format('H:i:s'))
        ];

        if ($data->status_done == 'Not Done' && $data->on_proses == 'On') {

            $data->update($array2);
        } elseif ($data->status_done == 'Done' && $data->on_proses == 'Ok') {

            $data->update($array1);
        }


        return back()->with('UpdateStatusDoneDataDetailLoadingMachinePlant3', 'Update Status Done Berhasil');
    }


    public function TambahDataLoadingMachinePlant3PLN3()
    {
        return view('UserPPICPlant3.Halaman_Tambah_Loading_Machine_SPK', [
            'judul' => 'Halaman Tambah Data Loading Machine Plant 3',
            'datamesin' => tb_data_mesin_plant_3::all()
        ]);
    }

    public function PostTambahLoadingMesinSistemPlant3PLNT3(Request $request)
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
            'keterangan' => 'nullable|string|max:3000',
            'file' => 'nullable|file|mimes:pdf'
        ]);

        $tambahLoadingmesinplant3 = tb_data_loading_machine_plant3::create([
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

            $files['fileprojekloadingmachineplant3'] = $request->file('file')->store('fileprojekloadingmachineplant3');

            tb_data_file_projek_loading_machine_plant_3::create([
                'url_unique_loading_machine' => $tambahLoadingmesinplant3['url_unique'],
                'url_unique' => Str::uuid(),
                'file' => $files['fileprojekloadingmachineplant3'],
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
            'on_proses' => $tambahLoadingmesinplant3['on_proses'],
            'operator' => HtmlPurifierHelper::clean($request->input('operator')),
            'status_done' => $tambahLoadingmesinplant3['status_done'],
            'tanggal_input' => $tambahLoadingmesinplant3['tanggal_input'],
            'keterangan' => HtmlPurifierHelper::clean($request->input('keterangan'))
        ];

        return back()->with('PostTambahLoadingMesinSistemPlant3PLNT3', 'Tambah Data Loading Machine Berhasil')->with('addData', $tambahData);
    }


    public function ExportPDFDataDetailLoadingMachinePlant3(tb_data_mesin_plant_3 $data, Request $request)
    {

        $dataloadingmachineplant3 = tb_data_loading_machine_plant3::where('url_unique_data_mesin', $data->url_unique_mesin)->whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmachineplant3->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
                    ->orwhere('project', 'like', '%' .  $search . '%')
                    ->orwhere('customer', 'like', '%' .  $search . '%')
                    ->orwhere('no_spk', 'like', '%' .  $search . '%')
                    ->orWhere('qty', 'like', '%' .  $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
                    ->orWhere('actual_jam', 'like', '%' .  $search . '%')
                    ->orWhere('start', 'like', '%' .  $search . '%')
                    ->orWhere('target_finish', 'like', '%' .  $search . '%')
                    ->orWhere('priority', 'like', '%' .  $search . '%')
                    ->orWhere('on_proses', 'like', '%' .  $search . '%')
                    ->orWhere('operator', 'like', '%' .  $search . '%')
                    ->orWhere('keterangan', 'like', '%' .  $search . '%')
                    ->orWhere('status_done', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
                    ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $dataloadingmachineplant3->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $dataloadingmachineplant3->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmachineplant3->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmachinecount = $dataloadingmachineplant3->count();

        $dataloadingmachine = $dataloadingmachineplant3->get();

        $pdf = PDF::loadView('UserPPICPlant3.Export_PDF_Data_Detail_Loading_Mesin_Plant_3', ['data' => $dataloadingmachine, 'mesin' => $data, 'count' => $dataloadingmachinecount])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_3.pdf');
    }

    public function UbahPasswordUserPlant3PL3()
    {
        return view('UserPPICPlant3.Halaman_Ubah_Password_User_Plant_3', [
            'judul' => 'Halaman Ubah Password User Plant 3'
        ]);
    }

    public function PostUbahPasswordUserPlant3PLN3(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/|confirmed',
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


    public function ProfileUserPlant3()
    {
        return view('UserPPICPlant3.Halaman_Profile_User', [
            'judul' => 'Halaman Profile User'
        ]);
    }

    public function PostGetFotoProfileUserPlant3(Request $request)
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

    public function PostUbahFotoProfileUserPlant3PLN3(Request $request)
    {

        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();

        if ($request->file('image')) {

            if ($user->image) {

                Storage::delete($user->image);
            }

            $image['fotouser'] = $request->file('image')->store('fotouser');

            $user->update([
                'image' => $image['fotouser']
            ]);
        }

        return back()->with('PostUbahFotoProfileUserPlant3PLN3', 'Ubah Foto Profile Berhasil');
    }

    public function PilihOpsiLihatDataLoadingMachinePlant3PLN3()
    {
        return view('UserPPICPlant3.Halaman_Pilih_Opsi_Lihat_Data_Loading_Machine_Plant_3', [
            'judul' => 'Halaman Pilih Opsi Lihat Data Loading Machine Plant 3',
        ]);
    }

    public function GetPilihOpsiLihatDataLoadingMachinePlant3(Request $request)
    {

        $opsi = $request->input('pilih_opsi_lihat_data_loading_machine_plnt_3');

        if ($opsi === 'Lihat Data Loading Machine Per Mesin') {

            return redirect('/dataloadingmachineppicplant3');
        } elseif ($opsi === 'Lihat Data Keseluruhan Loading Machine') {

            return redirect('/lihatdatakeseluruhanloadingmachineplant3');
        }
    }

    public function LihatDataKeseluruhanLoadingMachinePlant3(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:700',
            'opsi_filter' => 'nullable|in:Done,Not Done,All',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $datakeseluruhanloadingmachineplant3 = tb_data_loading_machine_plant3::whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $datakeseluruhanloadingmachineplant3->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
                    ->orwhere('project', 'like', '%' .  $search . '%')
                    ->orwhere('customer', 'like', '%' .  $search . '%')
                    ->orwhere('no_spk', 'like', '%' .  $search . '%')
                    ->orWhere('qty', 'like', '%' .  $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
                    ->orWhere('actual_jam', 'like', '%' .  $search . '%')
                    ->orWhere('start', 'like', '%' .  $search . '%')
                    ->orWhere('target_finish', 'like', '%' .  $search . '%')
                    ->orWhere('priority', 'like', '%' .  $search . '%')
                    ->orWhere('on_proses', 'like', '%' .  $search . '%')
                    ->orWhere('operator', 'like', '%' .  $search . '%')
                    ->orWhere('keterangan', 'like', '%' .  $search . '%')
                    ->orWhere('status_done', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
                    ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
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

        $lihatdataallloadingmachinecount = $datakeseluruhanloadingmachineplant3->count();

        $lihatdataallloadingmachine = $datakeseluruhanloadingmachineplant3->paginate(10)->WithQueryString();

        return view('UserPPICPlant3.Halaman_Lihat_Data_Keseluruhan_Loading_Machine_Plant_3', [
            'judul' => 'Halaman Lihat Data Keseluruhan Loading Machine Plant 3',
            'dataloadingmachineplant3' => $lihatdataallloadingmachine,
            'dataloadingmachineplant3count' => $lihatdataallloadingmachinecount,
            'datamesin' => tb_data_mesin_plant_3::all()
        ]);
    }

    public function PostDeleteDataKeseluruhanLoadingMachinePlant3(tb_data_loading_machine_plant3 $data)
    {

        if ($data) {

            $data->delete();

            return back()->with('PostDeleteDataKeseluruhanLoadingMachinePlant3Berhasil', 'Hapus Data Loading Machine Berhasil');
        } else {

            return back()->with('PostDeleteDataKeseluruhanLoadingMachinePlant3Gagal', 'Hapus Data Loading Machine Gagal');
        }
    }

    public function UpdateStatusDoneDataKeseluruhanLoadingMachinePlant3(tb_data_loading_machine_plant3 $data)
    {

        $time = Carbon::now('Asia/Jakarta');

        $array1 = [
            'status_done' => 'Not Done',
            'on_proses' => 'On',
            'user_pengupdated_status_done_loading_mesin' => auth()->user()->nama_user,
            'departemen_user_pengupdated_status_done_loading_mesin' => auth()->user()->departemen,
            'plant_user_pengupdated_status_done_loading_mesin' => auth()->user()->plant,
            'tanggal_updated_status_done_loading_mesin' => HtmlPurifierHelper::clean($time->format('Y-m-d')),
            'jam_updated_status_done_loading_mesin' => HtmlPurifierHelper::clean($time->format('H:i:s'))
        ];

        $array2 = [
            'status_done' => 'Done',
            'on_proses' => 'Ok',
            'user_pengupdated_status_done_loading_mesin' => auth()->user()->nama_user,
            'departemen_user_pengupdated_status_done_loading_mesin' => auth()->user()->departemen,
            'plant_user_pengupdated_status_done_loading_mesin' => auth()->user()->plant,
            'tanggal_updated_status_done_loading_mesin' => HtmlPurifierHelper::clean($time->format('Y-m-d')),
            'jam_updated_status_done_loading_mesin' => HtmlPurifierHelper::clean($time->format('H:i:s'))
        ];

        if ($data->status_done === 'Not Done' && $data->on_proses === 'On') {

            $data->update($array2);
        } elseif ($data->status_done === 'Done' && $data->on_proses === 'Ok') {

            $data->update($array1);
        }

        return back()->with('UpdateStatusDoneDataKeseluruhanLoadingMachinePlant3', 'Update Status Done Loading Machine Berhasil');
    }

    public function PostEditDataKeseluruhanLoadingMachinePPICPlant3(tb_data_loading_machine_plant3 $data, Request $request)
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
            'qty' => HtmlPurifierHelper::clean($request->input('qty')),
            'estimasi_jam' => HtmlPurifierHelper::clean($request->input('estimasi_jam')),
            'actual_jam' => HtmlPurifierHelper::clean($request->input('actual_jam')),
            'start' => HtmlPurifierHelper::clean($request->input('start')),
            'target_finish' => HtmlPurifierHelper::clean($request->input('target_finish')),
            'priority' => HtmlPurifierHelper::clean($request->input('priority')),
            'operator' => HtmlPurifierHelper::clean($request->input('operator')),
            'keterangan' => HtmlPurifierHelper::clean($request->input('keterangan')),
            'user_pengupdated_data_loading_mesin' => auth()->user()->nama_user,
            'departemen_user_pengupdated_data_loading_mesin' => auth()->user()->departemen,
            'plant_user_pengupdated_data_loading_mesin' => auth()->user()->plant,
            'tanggal_updated_data_loading_mesin' => $time->format('Y-m-d'),
            'jam_updated_data_loading_mesin' => $time->format('H:i:s')
        ]);

        return back()->with('PostEditDataKeseluruhanLoadingMachinePPICPlant3', 'Edit Data Loading Machine Berhasil');
    }

    public function ExportPDFDataKeseluruhanLoadingMachinePlant3(Request $request)
    {
        $datakeseluruhanloadingmachineplant3 = tb_data_loading_machine_plant3::whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $datakeseluruhanloadingmachineplant3->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
                    ->orwhere('project', 'like', '%' .  $search . '%')
                    ->orwhere('customer', 'like', '%' .  $search . '%')
                    ->orwhere('no_spk', 'like', '%' .  $search . '%')
                    ->orWhere('qty', 'like', '%' .  $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
                    ->orWhere('actual_jam', 'like', '%' .  $search . '%')
                    ->orWhere('start', 'like', '%' .  $search . '%')
                    ->orWhere('target_finish', 'like', '%' .  $search . '%')
                    ->orWhere('priority', 'like', '%' .  $search . '%')
                    ->orWhere('on_proses', 'like', '%' .  $search . '%')
                    ->orWhere('operator', 'like', '%' .  $search . '%')
                    ->orWhere('keterangan', 'like', '%' .  $search . '%')
                    ->orWhere('status_done', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
                    ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
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

        $dataallloadingmachineplant3count = $datakeseluruhanloadingmachineplant3->count();

        $dataallloadingmachineplant3 = $datakeseluruhanloadingmachineplant3->get();

        $pdf = PDF::loadView('UserPPICPlant3.Export_PDF_Data_Detail_Keseluruhan_Loading_Mesin_Plant_3', ['data' => $dataallloadingmachineplant3, 'jumlahdata' =>  $dataallloadingmachineplant3count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_3.pdf');
    }

    public function RestoreDataLoadingMachinePlant3PLNT3(Request $request)
    {

        $datarestoredloadingmachineplant3 = tb_data_loading_machine_plant3::onlyTrashed();

        if ($request->has('search')) {

            $search = $request->input('search');

            $datarestoredloadingmachineplant3->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
                    ->orwhere('project', 'like', '%' .  $search . '%')
                    ->orwhere('customer', 'like', '%' .  $search . '%')
                    ->orwhere('no_spk', 'like', '%' .  $search . '%')
                    ->orWhere('qty', 'like', '%' .  $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
                    ->orWhere('actual_jam', 'like', '%' .  $search . '%')
                    ->orWhere('start', 'like', '%' .  $search . '%')
                    ->orWhere('target_finish', 'like', '%' .  $search . '%')
                    ->orWhere('priority', 'like', '%' .  $search . '%')
                    ->orWhere('on_proses', 'like', '%' .  $search . '%')
                    ->orWhere('operator', 'like', '%' .  $search . '%')
                    ->orWhere('keterangan', 'like', '%' .  $search . '%')
                    ->orWhere('status_done', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
                    ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
            });
        }

        $datarestoreloadingmesinplant3count = $datarestoredloadingmachineplant3->count();

        $datarestoreloadingmesinplant3 = $datarestoredloadingmachineplant3->paginate(10)->WithQueryString();

        return view('UserPPICPlant3.Halaman_Restore_Data_Loading_Machine_Plant_3_PLNT_3', [
            'judul' => 'Halaman Restore Data Loading Machine Plant 3',
            'datarestoredloadingmachine' => $datarestoreloadingmesinplant3,
            'datarestoredloadingmachinecount' => $datarestoreloadingmesinplant3count,
            'datamesin' => tb_data_mesin_plant_3::all()
        ]);
    }

    public function PostRestoredDataLoadingMachinePlant3($urlUnique)
    {

        $datarestored = tb_data_loading_machine_plant3::onlyTrashed()->where('url_unique', $urlUnique)->first();

        if ($datarestored) {

            $datarestored->restore();

            return back()->with('PostRestoredDataLoadingMachinePlant3', 'Data Loading Machine Berhasil Di Pulihkan');
        } else {
            return back()->with('PostRestoredDataLoadingMachinePlant3Gagal', 'Data Loading Machine Gagal Di Pulihkan');
        }
    }
    
    
    public function ExportExcelDataDetailLoadingMachinePlant3(tb_data_mesin_plant_3 $mesin, Request $request)
    {

        $dataloadingmachineplant3 = tb_data_loading_machine_plant3::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmachineplant3->where(function ($query) use ($search) {
                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
                    ->orwhere('project', 'like', '%' .  $search . '%')
                    ->orwhere('customer', 'like', '%' .  $search . '%')
                    ->orwhere('no_spk', 'like', '%' .  $search . '%')
                    ->orWhere('qty', 'like', '%' .  $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
                    ->orWhere('actual_jam', 'like', '%' .  $search . '%')
                    ->orWhere('start', 'like', '%' .  $search . '%')
                    ->orWhere('target_finish', 'like', '%' .  $search . '%')
                    ->orWhere('priority', 'like', '%' .  $search . '%')
                    ->orWhere('on_proses', 'like', '%' .  $search . '%')
                    ->orWhere('operator', 'like', '%' .  $search . '%')
                    ->orWhere('keterangan', 'like', '%' .  $search . '%')
                    ->orWhere('status_done', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
                    ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $dataloadingmachineplant3->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $dataloadingmachineplant3->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmachineplant3->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmesinplant3 = $dataloadingmachineplant3->get();

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
        foreach ($dataloadingmesinplant3 as $item) {
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
    
    
    public function ExportExcelDataKeseluruhanLoadingMachinePlant3(Request $request)
    {

        $datakeseluruhanloadingmachineplant3 = tb_data_loading_machine_plant3::whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $datakeseluruhanloadingmachineplant3->where(function ($query) use ($search) {
                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
                    ->orwhere('project', 'like', '%' .  $search . '%')
                    ->orwhere('customer', 'like', '%' .  $search . '%')
                    ->orwhere('no_spk', 'like', '%' .  $search . '%')
                    ->orWhere('qty', 'like', '%' .  $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
                    ->orWhere('actual_jam', 'like', '%' .  $search . '%')
                    ->orWhere('start', 'like', '%' .  $search . '%')
                    ->orWhere('target_finish', 'like', '%' .  $search . '%')
                    ->orWhere('priority', 'like', '%' .  $search . '%')
                    ->orWhere('on_proses', 'like', '%' .  $search . '%')
                    ->orWhere('operator', 'like', '%' .  $search . '%')
                    ->orWhere('keterangan', 'like', '%' .  $search . '%')
                    ->orWhere('status_done', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
                    ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
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
        $filePath = storage_path('app/public/exported_data.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }
    
    //  PLANT 1

    // 

    public function PilihOpsiLihatDataLoadingMachinePlant1PLANT3()
    {

        return view('UserPPICPlant3.Halaman_Pilih_Opsi_Lihat_Data_Loading_Machine_Plant_1_PLANT3', [
            'judul' => 'Halaman Pilih Opsi Lihat Data Loading Machine Plant 1',
        ]);
    }

    public function GetPilihOpsiLihatDataLoadingMesinPlant1PLANT3(Request $request)
    {

        $opsi = HtmlPurifierHelper::clean($request->input('pilih_opsi_lihat_data_loading_machine_plant_1_PLANT3'));

        if ($opsi === 'Lihat Data Loading Machine Per Mesin') {

            return redirect('/lihatdataloadingmachineplant1permachine/plant3');
        } elseif ($opsi === 'Lihat Data Keseluruhan Loading Machine') {

            return redirect('/lihatdatakeseluruhanloadingmachineplant1/plant3');
        }
    }

    public function LihatDataLoadingMachinePlant1PerMachinePLANT3()
    {

        return view('UserPPICPlant3.Halaman_Lihat_Data_Loading_Machine_Per_Machine_Plant_1_PLANT3', [
            'judul' => 'Halaman Lihat Data Loading Machine Per Machine Plant 1',
            'datamesin' => tb_data_mesin::all()
        ]);
    }

    public function LihatDetailDataLoadingMachinePerMachinePlant1PLANT3(tb_data_mesin $mesin, Request $request)
    {

        $request->validate([
            'search' => 'nullable|string|max:700',
            'opsi_filter' => 'nullable|in:Done,Not Done,All',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $dataloadingmesinplant1permesin = tb_data_loading_machine_plant1::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at')
            ->with('fileProjek');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmesinplant1permesin->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
                    ->orwhere('project', 'like', '%' .  $search . '%')
                    ->orwhere('customer', 'like', '%' .  $search . '%')
                    ->orwhere('no_spk', 'like', '%' .  $search . '%')
                    ->orWhere('qty', 'like', '%' .  $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
                    ->orWhere('actual_jam', 'like', '%' .  $search . '%')
                    ->orWhere('start', 'like', '%' .  $search . '%')
                    ->orWhere('target_finish', 'like', '%' .  $search . '%')
                    ->orWhere('priority', 'like', '%' .  $search . '%')
                    ->orWhere('on_proses', 'like', '%' .  $search . '%')
                    ->orWhere('operator', 'like', '%' .  $search . '%')
                    ->orWhere('keterangan', 'like', '%' .  $search . '%')
                    ->orWhere('status_done', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
                    ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
            });
        }


        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $dataloadingmesinplant1permesin->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $dataloadingmesinplant1permesin->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            } elseif ($opsi === 'All' || $opsi === null) {
            }
        }


        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmesinplant1permesin->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmesinplant1permesincount = $dataloadingmesinplant1permesin->count();

        $dataloadingmesinplant1 = $dataloadingmesinplant1permesin->paginate(10)->WithQueryString();

        return view('UserPPICPlant3.Halaman_Lihat_Detail_Data_Loading_Machine_Per_Machine_Plant_1_PLANT3', [
            'judul' => 'Halaman Lihat Data Loading Machine Plant 1 Per Machine',
            'dataloadingmesinplant1' => $dataloadingmesinplant1,
            'dataloadingmesinplant1count' => $dataloadingmesinplant1permesincount,
            'mesin' => $mesin
        ]);
    }


    public function ExportPDFDataDetailLoadingMachinePlant1PLANT3(tb_data_mesin $mesin, Request $request)
    {

        $dataloadingmachineplant1permesin = tb_data_loading_machine_plant1::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmachineplant1permesin->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
                    ->orwhere('project', 'like', '%' .  $search . '%')
                    ->orwhere('customer', 'like', '%' .  $search . '%')
                    ->orwhere('no_spk', 'like', '%' .  $search . '%')
                    ->orWhere('qty', 'like', '%' .  $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
                    ->orWhere('actual_jam', 'like', '%' .  $search . '%')
                    ->orWhere('start', 'like', '%' .  $search . '%')
                    ->orWhere('target_finish', 'like', '%' .  $search . '%')
                    ->orWhere('priority', 'like', '%' .  $search . '%')
                    ->orWhere('on_proses', 'like', '%' .  $search . '%')
                    ->orWhere('operator', 'like', '%' .  $search . '%')
                    ->orWhere('keterangan', 'like', '%' .  $search . '%')
                    ->orWhere('status_done', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
                    ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
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

        $pdf = PDF::loadView('UserPPICPlant3.Export_PDF_Data_Detail_Loading_Mesin_Plant_1_Per_Mesin_PLANT3', ['data' => $dataloadingmachineplant1, 'count' => $dataloadingmachineplant1permesincount, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_1.pdf');
    }

    
    public function ExportExcelDataDetailLoadingMachinePlant1PLANT3(tb_data_mesin $mesin, Request $request)
    {

        $dataloadingmachineplant1permesin = tb_data_loading_machine_plant1::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');


        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmachineplant1permesin->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
                    ->orwhere('project', 'like', '%' .  $search . '%')
                    ->orwhere('customer', 'like', '%' .  $search . '%')
                    ->orwhere('no_spk', 'like', '%' .  $search . '%')
                    ->orWhere('qty', 'like', '%' .  $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
                    ->orWhere('actual_jam', 'like', '%' .  $search . '%')
                    ->orWhere('start', 'like', '%' .  $search . '%')
                    ->orWhere('target_finish', 'like', '%' .  $search . '%')
                    ->orWhere('priority', 'like', '%' .  $search . '%')
                    ->orWhere('on_proses', 'like', '%' .  $search . '%')
                    ->orWhere('operator', 'like', '%' .  $search . '%')
                    ->orWhere('keterangan', 'like', '%' .  $search . '%')
                    ->orWhere('status_done', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
                    ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
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

    public function LihatDataKeseluruhanLoadingMachinePlant1PLANT3(Request $request)
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
                    ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
                    ->orwhere('project', 'like', '%' .  $search . '%')
                    ->orwhere('customer', 'like', '%' .  $search . '%')
                    ->orwhere('no_spk', 'like', '%' .  $search . '%')
                    ->orWhere('qty', 'like', '%' .  $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
                    ->orWhere('actual_jam', 'like', '%' .  $search . '%')
                    ->orWhere('start', 'like', '%' .  $search . '%')
                    ->orWhere('target_finish', 'like', '%' .  $search . '%')
                    ->orWhere('priority', 'like', '%' .  $search . '%')
                    ->orWhere('on_proses', 'like', '%' .  $search . '%')
                    ->orWhere('operator', 'like', '%' .  $search . '%')
                    ->orWhere('keterangan', 'like', '%' .  $search . '%')
                    ->orWhere('status_done', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
                    ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
            });
        }


        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi ===  'Not Done') {

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

        return view('UserPPICPlant3.Halaman_Lihat_Data_Keseluruhan_Loading_Machine_Plant_1_PLANT3', [
            'judul' => 'Halaman Lihat Data Keseluruhan Loading Machine Plant 1',
            'dataloadingmesinplant1' => $dataallloadingmachineplant1,
            'dataloadingmesinplant1count' => $datakeseluruhanloadingmachineplant1count
        ]);
    }

    public function ExportPDFDataKeseluruhanLoadingMachinePlant1PLANT3(Request $request)
    {

        $datakeseluruhanloadingmachineplant1 = tb_data_loading_machine_plant1::whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $datakeseluruhanloadingmachineplant1->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
                    ->orwhere('project', 'like', '%' .  $search . '%')
                    ->orwhere('customer', 'like', '%' .  $search . '%')
                    ->orwhere('no_spk', 'like', '%' .  $search . '%')
                    ->orWhere('qty', 'like', '%' .  $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
                    ->orWhere('actual_jam', 'like', '%' .  $search . '%')
                    ->orWhere('start', 'like', '%' .  $search . '%')
                    ->orWhere('target_finish', 'like', '%' .  $search . '%')
                    ->orWhere('priority', 'like', '%' .  $search . '%')
                    ->orWhere('on_proses', 'like', '%' .  $search . '%')
                    ->orWhere('operator', 'like', '%' .  $search . '%')
                    ->orWhere('keterangan', 'like', '%' .  $search . '%')
                    ->orWhere('status_done', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
                    ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
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

        $pdf = PDF::loadView('UserPPICPlant3.Export_PDF_Data_Keseluruhan_Loading_Mesin_Plant_1_PLANT3', ['data' => $dataallloadingmachineplant1, 'count' => $datakeseluruhanloadingmachineplant1count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_1.pdf');
    }


    public function ExportExcelDataKeseluruhanLoadingMachinePlant1PLANT3(Request $request)
    {

        $datakeseluruhanloadingmachineplant1 = tb_data_loading_machine_plant1::whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $datakeseluruhanloadingmachineplant1->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
                    ->orwhere('project', 'like', '%' .  $search . '%')
                    ->orwhere('customer', 'like', '%' .  $search . '%')
                    ->orwhere('no_spk', 'like', '%' .  $search . '%')
                    ->orWhere('qty', 'like', '%' .  $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
                    ->orWhere('actual_jam', 'like', '%' .  $search . '%')
                    ->orWhere('start', 'like', '%' .  $search . '%')
                    ->orWhere('target_finish', 'like', '%' .  $search . '%')
                    ->orWhere('priority', 'like', '%' .  $search . '%')
                    ->orWhere('on_proses', 'like', '%' .  $search . '%')
                    ->orWhere('operator', 'like', '%' .  $search . '%')
                    ->orWhere('keterangan', 'like', '%' .  $search . '%')
                    ->orWhere('status_done', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
                    ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
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
    
    
    // PLANT 2

    // 

    public function PilihOpsiLihatDataLoadingMachinePlant2PLANT3()
    {

        return view('UserPPICPlant3.Halaman_Pilih_Opsi_Lihat_Data_Loading_Machine_Plant_2_PLANT3', [
            'judul' => 'Halaman Pilih Opsi Lihat Data Loading Machine Plant 2'
        ]);
    }

    public function GetPilihOpsiLihatDataLoadingMachinePlant2PLANT3(Request $request)
    {

        $opsi = HtmlPurifierHelper::clean($request->input('pilih_opsi_lihat_data_loading_machine_plant_2_PLANT3'));

        if ($opsi === 'Lihat Data Loading Machine Per Mesin') {

            return redirect('/lihatdataloadingmesinpermesinplant2/plant3');
        } elseif ($opsi === 'Lihat Data Keseluruhan Loading Machine') {

            return redirect('/lihatdatakeseluruhanloadingmachineplant2/plant3');
        }
    }

    public function LihatDataLoadingMesinPerMesinPlant2PLANT3()
    {

        return view('UserPPICPlant3.Halaman_Lihat_Data_Loading_Mesin_Per_Mesin_Plant_2_PLANT3', [
            'judul' => 'Halaman Lihat Data Loading Mesin Plant 2',
            'datamesin' => tb_data_mesin_plant_2::all()
        ]);
    }


    public function LihatDetailDataLoadingMesinPerMesinPlant2PLANT3(tb_data_mesin_plant_2 $mesin, Request $request)
    {

        $request->validate([
            'search' => 'nullable|string|max:700',
            'opsi_filter' => 'nullable|in:Done,Not Done,All',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $dataloadingmachineplant2permesin = tb_data_loading_machine_plant2::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at')
            ->with('fileProjekLoadingMachinePlant2');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmachineplant2permesin->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
                    ->orwhere('project', 'like', '%' .  $search . '%')
                    ->orwhere('customer', 'like', '%' .  $search . '%')
                    ->orwhere('no_spk', 'like', '%' .  $search . '%')
                    ->orWhere('qty', 'like', '%' .  $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
                    ->orWhere('actual_jam', 'like', '%' .  $search . '%')
                    ->orWhere('start', 'like', '%' .  $search . '%')
                    ->orWhere('target_finish', 'like', '%' .  $search . '%')
                    ->orWhere('priority', 'like', '%' .  $search . '%')
                    ->orWhere('on_proses', 'like', '%' .  $search . '%')
                    ->orWhere('operator', 'like', '%' .  $search . '%')
                    ->orWhere('keterangan', 'like', '%' .  $search . '%')
                    ->orWhere('status_done', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
                    ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
            });
        }


        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $dataloadingmachineplant2permesin->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $dataloadingmachineplant2permesin->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            } elseif ($opsi === 'All' || $opsi === null) {
            }
        }


        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmachineplant2permesin->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmachineplant2permesincount = $dataloadingmachineplant2permesin->count();

        $dataloadingmachineplant2 = $dataloadingmachineplant2permesin->paginate(10)->WithQueryString();

        return view('UserPPICPlant3.Halaman_Lihat_Detail_Data_Loading_Mesin_Per_Mesin_Plant_2_PLANT3', [
            'judul' => 'Halaman Lihat Data Loading Machine Per Machine Plant 2',
            'dataloadingmesinplant2' => $dataloadingmachineplant2,
            'dataloadingmesinplant2count' => $dataloadingmachineplant2permesincount,
            'mesin' => $mesin
        ]);
    }

    
    public function ExportPDFDataDetailLoadingMesinPlant2PerMesinPLANT3(tb_data_mesin_plant_2 $mesin, Request $request)
    {

        $dataloadingmachineplant2permesin = tb_data_loading_machine_plant2::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmachineplant2permesin->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
                    ->orwhere('project', 'like', '%' .  $search . '%')
                    ->orwhere('customer', 'like', '%' .  $search . '%')
                    ->orwhere('no_spk', 'like', '%' .  $search . '%')
                    ->orWhere('qty', 'like', '%' .  $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
                    ->orWhere('actual_jam', 'like', '%' .  $search . '%')
                    ->orWhere('start', 'like', '%' .  $search . '%')
                    ->orWhere('target_finish', 'like', '%' .  $search . '%')
                    ->orWhere('priority', 'like', '%' .  $search . '%')
                    ->orWhere('on_proses', 'like', '%' .  $search . '%')
                    ->orWhere('operator', 'like', '%' .  $search . '%')
                    ->orWhere('keterangan', 'like', '%' .  $search . '%')
                    ->orWhere('status_done', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
                    ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $dataloadingmachineplant2permesin->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $dataloadingmachineplant2permesin->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmachineplant2permesin->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmachineplant2permesincount = $dataloadingmachineplant2permesin->count();

        $dataloadingmachineplant2 = $dataloadingmachineplant2permesin->get();

        $pdf = PDF::loadView('UserPPICPlant3.Export_PDF_Data_Loading_Mesin_Per_Mesin_Plant_2_PLANT3', ['data' => $dataloadingmachineplant2, 'count' => $dataloadingmachineplant2permesincount, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_2.pdf');
    }
    

    public function ExportExcelDataDetailLoadingMesinPlant2PerMesinPLANT3(tb_data_mesin_plant_2 $mesin, Request $request)
    {

        $dataloadingmachineplant2permesin = tb_data_loading_machine_plant2::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmachineplant2permesin->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
                    ->orwhere('project', 'like', '%' .  $search . '%')
                    ->orwhere('customer', 'like', '%' .  $search . '%')
                    ->orwhere('no_spk', 'like', '%' .  $search . '%')
                    ->orWhere('qty', 'like', '%' .  $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
                    ->orWhere('actual_jam', 'like', '%' .  $search . '%')
                    ->orWhere('start', 'like', '%' .  $search . '%')
                    ->orWhere('target_finish', 'like', '%' .  $search . '%')
                    ->orWhere('priority', 'like', '%' .  $search . '%')
                    ->orWhere('on_proses', 'like', '%' .  $search . '%')
                    ->orWhere('operator', 'like', '%' .  $search . '%')
                    ->orWhere('keterangan', 'like', '%' .  $search . '%')
                    ->orWhere('status_done', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
                    ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
            });
        }

        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {

                $dataloadingmachineplant2permesin->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $dataloadingmachineplant2permesin->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmachineplant2permesin->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmachineplant2 = $dataloadingmachineplant2permesin->get();

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
        foreach ($dataloadingmachineplant2 as $item) {
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

    // 

    public function LihatDataKeseluruhanLoadingMachinePlant2PLANT3(Request $request)
    {

        $request->validate([
            'search' => 'nullable|string|max:700',
            'opsi_filter' => 'nullable|in:Done,Not Done,All',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $datakeseluruhanloadingmachineplant2 = tb_data_loading_machine_plant2::whereNull('deleted_at')
            ->with('fileProjekLoadingMachinePlant2');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $datakeseluruhanloadingmachineplant2->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
                    ->orwhere('project', 'like', '%' .  $search . '%')
                    ->orwhere('customer', 'like', '%' .  $search . '%')
                    ->orwhere('no_spk', 'like', '%' .  $search . '%')
                    ->orWhere('qty', 'like', '%' .  $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
                    ->orWhere('actual_jam', 'like', '%' .  $search . '%')
                    ->orWhere('start', 'like', '%' .  $search . '%')
                    ->orWhere('target_finish', 'like', '%' .  $search . '%')
                    ->orWhere('priority', 'like', '%' .  $search . '%')
                    ->orWhere('on_proses', 'like', '%' .  $search . '%')
                    ->orWhere('operator', 'like', '%' .  $search . '%')
                    ->orWhere('keterangan', 'like', '%' .  $search . '%')
                    ->orWhere('status_done', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
                    ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
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
            } elseif ($opsi === 'All' || $opsi === null) {
            }
        }


        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $datakeseluruhanloadingmachineplant2->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $datakeseluruhanloadingmachineplant2count = $datakeseluruhanloadingmachineplant2->count();

        $dataallloadingmachineplant2 = $datakeseluruhanloadingmachineplant2->paginate(10)->WithQueryString();

        return view('UserPPICPlant3.Halaman_Lihat_Data_Keseluruhan_Loading_Machine_Plant_2_PLANT3', [
            'judul' => 'Halaman Lihat Data Keseluruhan Loading Machine Plant 2',
            'dataloadingmesinplant2' => $dataallloadingmachineplant2,
            'dataloadingmesinplant2count' =>  $datakeseluruhanloadingmachineplant2count,
        ]);
    }

    
    public function ExportPDFDataKeseluruhanLoadingMachinePlant2PLANT3(Request $request)
    {

        $datakeseluruhanloadingmachineplant2 = tb_data_loading_machine_plant2::whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $datakeseluruhanloadingmachineplant2->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
                    ->orwhere('project', 'like', '%' .  $search . '%')
                    ->orwhere('customer', 'like', '%' .  $search . '%')
                    ->orwhere('no_spk', 'like', '%' .  $search . '%')
                    ->orWhere('qty', 'like', '%' .  $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
                    ->orWhere('actual_jam', 'like', '%' .  $search . '%')
                    ->orWhere('start', 'like', '%' .  $search . '%')
                    ->orWhere('target_finish', 'like', '%' .  $search . '%')
                    ->orWhere('priority', 'like', '%' .  $search . '%')
                    ->orWhere('on_proses', 'like', '%' .  $search . '%')
                    ->orWhere('operator', 'like', '%' .  $search . '%')
                    ->orWhere('keterangan', 'like', '%' .  $search . '%')
                    ->orWhere('status_done', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
                    ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
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

        $datakeseluruhanloadingmachineplant2count = $datakeseluruhanloadingmachineplant2->count();

        $dataallloadingmachineplant2 = $datakeseluruhanloadingmachineplant2->get();

        $pdf = PDF::loadView('UserPPICPlant3.Export_PDF_Data_Keseluruhan_Loading_Mesin_Plant_2_PLANT3', ['data' => $dataallloadingmachineplant2, 'count' => $datakeseluruhanloadingmachineplant2count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_2.pdf');
    }


    public function ExportExcelDataKeseluruhanLoadingMachinePlant2PLANT3(Request $request)
    {

        $datakeseluruhanloadingmachineplant2 = tb_data_loading_machine_plant2::whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $datakeseluruhanloadingmachineplant2->where(function ($query) use ($search) {

                $query->where('plant', 'like', '%' . $search . '%')
                    ->orwhere('nama_mesin', 'like', '%' .  $search . '%')
                    ->orwhere('project', 'like', '%' .  $search . '%')
                    ->orwhere('customer', 'like', '%' .  $search . '%')
                    ->orwhere('no_spk', 'like', '%' .  $search . '%')
                    ->orWhere('qty', 'like', '%' .  $search . '%')
                    ->orwhere('estimasi_jam', 'like', '%' .  $search . '%')
                    ->orWhere('actual_jam', 'like', '%' .  $search . '%')
                    ->orWhere('start', 'like', '%' .  $search . '%')
                    ->orWhere('target_finish', 'like', '%' .  $search . '%')
                    ->orWhere('priority', 'like', '%' .  $search . '%')
                    ->orWhere('on_proses', 'like', '%' .  $search . '%')
                    ->orWhere('operator', 'like', '%' .  $search . '%')
                    ->orWhere('keterangan', 'like', '%' .  $search . '%')
                    ->orWhere('status_done', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_input', 'like', '%' .  $search . '%')
                    ->orWhere('user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_data_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_data_loading_mesin', 'like', '%' . $search . '%')
                    ->orWhere('user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('departemen_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('plant_user_pengupdated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('tanggal_updated_status_done_loading_mesin', 'like', '%' .  $search . '%')
                    ->orWhere('jam_updated_status_done_loading_mesin', 'like', '%' .  $search . '%');
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
        $filePath = storage_path('app/public/loading_mesin_plant_2.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }
    
    
    // LIHAT FILE PROJEK

    public function PostTambahDataFileProjekLoadingMachineKeseluruhanPlant3PLANT3(tb_data_loading_machine_plant3 $data, Request $request)
    {

        $time = Carbon::now('Asia/Jakarta');

        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        if ($request->hasFile('file')) {

            $files['fileprojekloadingmachineplant3'] = $request->file('file')->store('fileprojekloadingmachineplant3');
        }

        tb_data_file_projek_loading_machine_plant_3::create([
            'url_unique_loading_machine' => $data->url_unique,
            'url_unique' => Str::uuid(),
            'file' => $files['fileprojekloadingmachineplant3'],
            'tanggal_file_diupload' => $time->format('Y-m-d H:i:s')
        ]);

        return back()->with('PostTambahDataFileProjekLoadingMachineKeseluruhanPlant3PLANT3', 'Tambah File Berhasil');
    }

    public function LihatDataFileProjekLoadingMachineKeseluruhanPlant3PLANT3(tb_data_loading_machine_plant3 $data, Request $request)
    {
        $datafileprojek = tb_data_file_projek_loading_machine_plant_3::where('url_unique_loading_machine', $data->url_unique);

        if ($request->has('search')) {

            $search = $request->input('search');

            $datafileprojek->where(function ($query) use ($search) {

                $query->where('tanggal_file_diupload', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_file_diubah', 'like', '%' . $search . '%');
            });
        }

        $datafileprojekcount = $datafileprojek->count();

        $datafile = $datafileprojek->paginate(10)->WithQueryString();

        return view('UserPPICPlant3.Halaman_Lihat_Data_File_Projek_Loading_Machine_Keseluruhan_Plant_3_PLANT3', [
            'judul' => 'Halaman Lihat Data File Projek',
            'datafileprojek' => $datafile,
            'datafileprojekcount' => $datafileprojekcount,
            'data' => $data
        ]);
    }

    public function PostTambahDataFileProjekLoadingMesinKeseluruhanPlant3PLN3(tb_data_loading_machine_plant3 $data, Request $request)
    {

        $time = Carbon::now('Asia/Jakarta');

        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        if ($request->hasFile('file')) {

            $files['fileprojekloadingmachineplant3'] = $request->file('file')->store('fileprojekloadingmachineplant3');
        }

        tb_data_file_projek_loading_machine_plant_3::create([
            'url_unique_loading_machine' => $data->url_unique,
            'url_unique' => Str::uuid(),
            'file' => $files['fileprojekloadingmachineplant3'],
            'tanggal_file_diupload' => $time->format('Y-m-d H:i:s')
        ]);


        return back()->with('PostTambahDataFileProjekLoadingMesinKeseluruhanPlant3PLN3', 'Tambah Data File Berhasil');
    }

    public function PostDeleteDataFileProjekLoadingMachineKeseluruhanPlant3PLANT3(tb_data_file_projek_loading_machine_plant_3 $file)
    {

        if ($file->file) {

            Storage::delete($file->file);
        }

        $file->delete();

        return back()->with('PostDeleteDataFileProjekLoadingMachineKeseluruhanPlant3PLANT3', 'Hapus Data File Projek Berhasil');
    }


    public function PostUbahDataFileProjekLoadingMachineKeseluruhanPlant3PLN3(tb_data_file_projek_loading_machine_plant_3 $file, Request $request)
    {

        $time = Carbon::now('Asia/Jakarta');

        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        if ($request->hasFile('file')) {

            if ($file->file) {

                Storage::delete($file->file);
            }

            $files['fileprojekloadingmachineplant3'] = $request->file('file')->store('fileprojekloadingmachineplant3');
        }

        $file->update([
            'file' => $files['fileprojekloadingmachineplant3'],
            'tanggal_file_diubah' => $time->format('Y-m-d H:i:s')
        ]);

        return back()->with('PostUbahDataFileProjekLoadingMachineKeseluruhanPlant3PLN3', 'Ubah Data Berhasil');
    }

    public function PostTambahDataFileProjekLoadingMachinePerMachinePlant3PLN3(tb_data_loading_machine_plant3 $data, Request $request)
    {

        $time = Carbon::now('Asia/Jakarta');

        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        if ($request->hasFile('file')) {

            $files['fileprojekloadingmachineplant3'] = $request->file('file')->store('fileprojekloadingmachineplant3');
        }

        tb_data_file_projek_loading_machine_plant_3::create([
            'url_unique_loading_machine' => $data->url_unique,
            'url_unique' => Str::uuid(),
            'file' => $files['fileprojekloadingmachineplant3'],
            'tanggal_file_diupload' => $time->format('Y-m-d H:i:s')
        ]);

        return back()->with('PostTambahDataFileProjekLoadingMachinePerMachinePlant3PLN3', 'Tambah Data File Berhasil');
    }

    public function LihatDataFileProjekLoadingMachinePerMachinePlant3PLN3(tb_data_loading_machine_plant3 $data, Request $request)
    {

        $datafileprojek = tb_data_file_projek_loading_machine_plant_3::where('url_unique_loading_machine', $data->url_unique);

        if ($request->has('search')) {

            $search = $request->input('search');

            $datafileprojek->where(function ($query) use ($search) {

                $query->where('tanggal_file_diupload', 'like', '%' . $search . '%')
                    ->orwhere('tanggal_file_diubah', 'like', '%' . $search . '%');
            });
        }

        $datafileprojekcount = $datafileprojek->count();

        $datafile = $datafileprojek->paginate(10)->WithQueryString();

        return view('UserPPICPlant3.Halaman_Lihat_Data_File_Projek_Loading_Machine_Per_Machine_Plant_3_PLN3', [
            'judul' => 'Halaman Lihat Data File Projek',
            'datafileprojek' => $datafile,
            'datafileprojekcount' => $datafileprojekcount,
            'data' => $data
        ]);
    }

    public function PostTambahDataFileProjekLoadingMesinPerMesinPlant3PLNT3(tb_data_loading_machine_plant3 $data, Request $request)
    {

        $time = Carbon::now('Asia/Jakarta');

        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        if ($request->hasFile('file')) {

            $files['fileprojekloadingmachineplant3'] = $request->file('file')->store('fileprojekloadingmachineplant3');
        }

        tb_data_file_projek_loading_machine_plant_3::create([
            'url_unique_loading_machine' => $data->url_unique,
            'url_unique' => Str::uuid(),
            'file' => $files['fileprojekloadingmachineplant3'],
            'tanggal_file_diupload' => $time->format('Y-m-d H:i:s')
        ]);

        return back()->with('PostTambahDataFileProjekLoadingMesinPerMesinPlant3PLNT3', 'Tambah Data File Berhasil');
    }

    public function PostDeleteDataFileProjekLoadingMachinePerMachinePlant3PLNT3(tb_data_file_projek_loading_machine_plant_3 $file)
    {

        if ($file->file) {

            Storage::delete($file->file);
        }

        $file->delete();

        return back()->with('PostDeleteDataFileProjekLoadingMachinePerMachinePlant3PLNT3', 'Hapus Data Berhasil');
    }

    public function PostUbahDataFileProjekLoadingMachinePerMachinePlant3PLNT3(tb_data_file_projek_loading_machine_plant_3 $file, Request $request)
    {

        $time = Carbon::now('Asia/Jakarta');

        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        if ($request->hasFile('file')) {

            if ($file->file) {

                Storage::delete($file->file);
            }

            $files['fileprojekloadingmachineplant3'] = $request->file('file')->store('fileprojekloadingmachineplant3');
        }

        $file->update([
            'file' => $files['fileprojekloadingmachineplant3'],
            'tanggal_file_diubah' => $time->format('Y-m-d H:i:s')
        ]);

        return back()->with('PostUbahDataFileProjekLoadingMachinePerMachinePlant3PLNT3', 'Ubah File Berhasil');
    }
    
    
    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE lihatdatakeseluruhanloadingmachineplant3 plant3

    public function ExportPDFStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant3PLANT3(Request $request)
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

        $pdf = PDF::loadView('UserPPICPlant3.Export_PDF_Start_Date_End_Date_Lihat_Data_Keseluruhan_Loading_Machine_Plant3_PLANT3', ['data' => $dataallloadingmachineplant3, 'count' => $datakeseluruhanloadingmachineplant3count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_3.pdf');
    }


    public function ExportExcelStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant3PLANT3(Request $request)
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


    public function ExportPDFFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant3PLANT3(Request $request)
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

        $pdf = PDF::loadView('UserPPICPlant3.Export_PDF_Filter_Done_Not_Done_Lihat_Data_Keseluruhan_Loading_Machine_Plant3_PLANT3', ['data' => $dataallloadingmachineplant3, 'count' => $datakeseluruhanloadingmachineplant3count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_3.pdf');
    }


    public function ExportExcelFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant3PLANT3(Request $request)
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
    
    
    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE lihatdatakeseluruhanloadingmachineplant3 plant3


    public function ExportPDFStartDateEndDateDetailDataLoadingMachinePPICPlant3PLANT3(tb_data_mesin_plant_3 $mesin, Request $request)
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

        $pdf = PDF::loadView('UserPPICPlant3.Export_PDF_Start_Date_End_Date_Detail_Data_Loading_Machine_PPIC_Plant3_PLANT3', ['data' => $dataloadingmachine, 'count' => $dataloadingmachineplant3count, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_3.pdf');
    }


    public function ExportExcelStartDateEndDateDetailDataLoadingMachinePPICPlant3PLANT3(tb_data_mesin_plant_3 $mesin, Request $request)
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


    public function ExportPDFFilterDoneNotDoneDetailDataLoadingMachinePPICPlant3PLANT3(tb_data_mesin_plant_3 $mesin, Request $request)
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

        $pdf = PDF::loadView('UserPPICPlant3.Export_PDF_Filter_Done_Not_Done_Detail_Data_Loading_Machine_PPIC_Plant3_PLANT3', ['data' => $dataloadingmachine, 'count' => $dataloadingmachineplant3count, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_3.pdf');
    }


    public function ExportExcelFilterDoneNotDoneDetailDataLoadingMachinePPICPlant3PLANT3(tb_data_mesin_plant_3 $mesin, Request $request)
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
    
    
    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE lihatdatakeseluruhanloadingmachineplant1 plant3

    public function ExportPDFStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant1PLANT3(Request $request)
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

        $dataallloadingmachineplant3 = $datakeseluruhanloadingmachineplant1->get();

        $pdf = PDF::loadView('UserPPICPlant3.Export_PDF_Start_Date_End_Date_Lihat_Data_Keseluruhan_Loading_Machine_Plant1_PLANT3', ['data' => $dataallloadingmachineplant3, 'count' => $datakeseluruhanloadingmachineplant1count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_1.pdf');
    }


    public function ExportExcelStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant1PLANT3(Request $request)
    {

        $datakeseluruhanloadingmachineplant1 = tb_data_loading_machine_plant1::whereNull('deleted_at');

        if ($request->has('start_date') && $request->has('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $datakeseluruhanloadingmachineplant1->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataallloadingmachineplant3 = $datakeseluruhanloadingmachineplant1->get();

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
        $filePath = storage_path('app/public/loading_mesin_plant_1.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }


    public function ExportPDFFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant1PLANT3(Request $request)
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

        $dataallloadingmachineplant3 = $datakeseluruhanloadingmachineplant1->get();

        $pdf = PDF::loadView('UserPPICPlant3.Export_PDF_Filter_Done_Not_Done_Lihat_Data_Keseluruhan_Loading_Machine_Plant1_PLANT3', ['data' => $dataallloadingmachineplant3, 'count' => $datakeseluruhanloadingmachineplant1count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_1.pdf');
    }


    public function ExportExcelFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant1PLANT3(Request $request)
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

        $dataallloadingmachineplant3 = $datakeseluruhanloadingmachineplant1->get();

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
        $filePath = storage_path('app/public/loading_mesin_plant_1.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }
    
    
    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE lihatdetaildataloadingmachinepermachineplant1 plant3

    public function ExportPDFStartDateEndDateLihatDetailDataLoadingMachinePerMachinePlant1PLANT3(tb_data_mesin $mesin, Request $request)
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

        $pdf = PDF::loadView('UserPPICPlant3.Export_PDF_Start_Date_End_Date_Lihat_Detail_Data_Loading_Machine_Per_Machine_Plant1_PLANT3', ['data' => $dataloadingmachine, 'count' => $dataloadingmachineplant1count, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_1.pdf');
    }


    public function ExportExcelStartDateEndDateLihatDetailDataLoadingMachinePerMachinePlant1PLANT3(tb_data_mesin $mesin, Request $request)
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


    public function ExportPDFFilterDoneNotDoneLihatDetailDataLoadingMachinePerMachinePlant1PLANT3(tb_data_mesin $mesin, Request $request)
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

        $pdf = PDF::loadView('UserPPICPlant3.Export_PDF_Filter_Done_Not_Done_Lihat_Detail_Data_Loading_Machine_Per_Machine_Plant1_PLANT3', ['data' => $dataloadingmachine, 'count' => $dataloadingmachineplant1count, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_1.pdf');
    }


    public function ExportExcelFilterDoneNotDoneLihatDetailDataLoadingMachinePerMachinePlant1PLANT3(tb_data_mesin $mesin, Request $request)
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
    
    
    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE lihatdatakeseluruhanloadingmachineplant2 plant3


    public function ExportPDFStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant2PLANT3(Request $request)
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


        $pdf = PDF::loadView('UserPPICPlant3.Export_PDF_Start_Date_End_Date_Lihat_Data_Keseluruhan_Loading_Machine_Plant2_PLANT3', ['data' => $dataallloadingmachineplant2, 'count' => $datakeseluruhanloadingmachineplant2count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_2.pdf');
    }


    public function ExportExcelStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant2PLANT3(Request $request)
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


    public function ExportPDFFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant2PLANT3(Request $request)
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

        $pdf = PDF::loadView('UserPPICPlant3.Export_PDF_Filter_Done_Not_Done_Lihat_Data_Keseluruhan_Loading_Machine_Plant2_PLANT3', ['data' => $dataallloadingmachineplant2, 'count' => $datakeseluruhanloadingmachineplant2count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_2.pdf');
    }


    public function ExportExcelFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant2PLANT3(Request $request)
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
    
    
    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE lihatdetaildataloadingmesinpermesinplant2 plant3

    public function ExportPDFStartDateEndDateLihatDetailDataLoadingMesinPerMesinPlant2PLANT3(tb_data_mesin_plant_2 $mesin, Request $request)
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

        $pdf = PDF::loadView('UserPPICPlant3.Export_PDF_Start_Date_End_Date_Lihat_Detail_Data_Loading_Mesin_Per_Mesin_Plant2_PLANT3', ['data' => $dataloadingmachine, 'count' => $dataloadingmachineplant2count, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_2.pdf');
    }


    public function ExportExcelStartDateEndDateLihatDetailDataLoadingMesinPerMesinPlant2PLANT3(tb_data_mesin_plant_2 $mesin, Request $request)
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


    public function ExportPDFFilterDoneNotDoneLihatDetailDataLoadingMesinPerMesinPlant2PLANT3(tb_data_mesin_plant_2 $mesin, Request $request)
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

        $pdf = PDF::loadView('UserPPICPlant3.Export_PDF_Filter_Done_Not_Done_Lihat_Detail_Data_Loading_Mesin_Per_Mesin_Plant2_PLANT3', ['data' => $dataloadingmachine, 'count' => $dataloadingmachineplant2count, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_2.pdf');
    }


    public function ExportExcelFilterDoneNotDoneLihatDetailDataLoadingMesinPerMesinPlant2PLANT3(tb_data_mesin_plant_2 $mesin, Request $request)
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
}
