<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\tb_data_spk;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\tb_data_mesin;
use App\Models\tb_data_mesin_plant_2;
use App\Models\tb_data_mesin_plant_3;
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
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Colors\Rgb\Channels\Red;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ControllerPPICPlant1 extends Controller
{
    public function DashboardPPICPlant1()
    {
        return view('UserPPICPlant1.Halaman_Dashboard_PPIC_Plant1', [
            'judul' => 'Halaman Dashboard PPIC Plant 1',
        ]);
    }

    public function PostTambahDataLoadingMachineSPKPPICPlant1PLNT1(Request $request)
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

        $tambahLoadingmesinplant1 = tb_data_loading_machine_plant1::create([
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

            $files['fileprojekloadingmachineplant1'] = $request->file('file')->store('fileprojekloadingmachineplant1');

            tb_data_file_projek_loading_machine_plant_1::create([
                'url_unique_loading_machine' => $tambahLoadingmesinplant1['url_unique'],
                'url_unique' => Str::uuid(),
                'file' => $files['fileprojekloadingmachineplant1'],
                'tanggal_file_diupload' => $time->format('Y-m-d H:i:s'),
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
            'on_proses' => $tambahLoadingmesinplant1['on_proses'],
            'operator' => HtmlPurifierHelper::clean($request->input('operator')),
            'status_done' => $tambahLoadingmesinplant1['on_proses'],
            'tanggal_input' => $tambahLoadingmesinplant1['tanggal_input'],
            'keterangan' => HtmlPurifierHelper::clean($request->input('keterangan'))
        ];

        return back()->with('PostTambahDataLoadingMachineSPKPPICPlant1PLNT1', 'Tambah Data Loading Machine Berhasil')->with('addData', $tambahData);
    }
    
    public function LihatSemuaDataLoadingMachinePlant1PLNT1()
    {
        return view('UserPPICPlant1.Halaman_Lihat_Data_Loading_Machine_Plant_1', [
            'judul' => 'Halaman Lihat Semua Data Loading Machine',
            'datamesin' => tb_data_mesin::all()
        ]);
    }

    public function LihatDetailLoadingMachinePlant1PLNT1(tb_data_mesin $mesin, Request $request)
    {

        $request->validate([
            'search' => 'nullable|string|max:700',
            'opsi_filter' => 'nullable|in:Done,Not Done,All',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
        ]);

        $dataloadingmachineplant1 = tb_data_loading_machine_plant1::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmachineplant1->where(function ($query) use ($search) {
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

                $dataloadingmachineplant1->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            }

            if ($opsi === 'Done') {

                $dataloadingmachineplant1->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmachineplant1->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmesinplant1plnt1count = $dataloadingmachineplant1->count();

        $dataloadingmesinplant1plnt1 = $dataloadingmachineplant1->paginate(10)->WithQueryString();

        return view('UserPPICPlant1.Halaman_Lihat_Detail_Loading_Machine_SPK_Plant_1', [
            'judul' => 'Halaman Lihat Detail Loading Machine Plant 1',
            'dataloadingmesin' => $dataloadingmesinplant1plnt1,
            'mesin' => $mesin,
            'datamesin' => tb_data_mesin::all(),
            'countData' => $dataloadingmesinplant1plnt1count
        ]);
    }

    public function PostDeteleDataDetailLoadingMachinePlant1PLNT1(tb_data_loading_machine_plant1 $data)
    {
        if ($data) {

            $data->delete();
        }

        return back()->with('PostDeteleDataDetailLoadingMachinePlant1PLNT1', 'Hapus Data Loading Mesin Berhasil');
    }


    public function PostEditDataDetailLoadingMesinPPICPlant1PLNT1(tb_data_loading_machine_plant1 $data, Request $request)
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

        return back()->with('PostEditDataDetailLoadingMesinPPICPlant1PLNT1', 'Edit Data Loading Machine Berhasil');
    }


    public function PostUpdateStatusDoneDetailDataLoadingMesinPlant1PLNT1(tb_data_loading_machine_plant1 $data)
    {
        $time = Carbon::now('Asia/Jakarta');

        $array = [
            'status_done' => 'Done',
            'on_proses' => 'Ok',
            'user_pengupdated_status_done_loading_mesin' => auth()->user()->nama_user,
            'departemen_user_pengupdated_status_done_loading_mesin' => auth()->user()->departemen,
            'plant_user_pengupdated_status_done_loading_mesin' => auth()->user()->plant,
            'tanggal_updated_status_done_loading_mesin' => HtmlPurifierHelper::clean($time->format('Y-m-d')),
            'jam_updated_status_done_loading_mesin' => HtmlPurifierHelper::clean($time->format('H:i:s'))
        ];


        $array2 = [
            'status_done' => 'Not Done',
            'on_proses' => 'On',
            'user_pengupdated_status_done_loading_mesin' => auth()->user()->nama_user,
            'departemen_user_pengupdated_status_done_loading_mesin' => auth()->user()->departemen,
            'plant_user_pengupdated_status_done_loading_mesin' => auth()->user()->plant,
            'tanggal_updated_status_done_loading_mesin' => HtmlPurifierHelper::clean($time->format('Y-m-d')),
            'jam_updated_status_done_loading_mesin' => HtmlPurifierHelper::clean($time->format('H:i:s'))
        ];


        if ($data->status_done == 'Not Done' && $data->on_proses == 'On') {

            $data->update($array);
        } else {

            $data->update($array2);
        }

        return back()->with('PostUpdateStatusDoneDetailDataLoadingMesinPlant1PLNT1', 'Update Status Done Berhasil');
    }


    public function ExportPDFDataDetailLoadingMachinePlant1(tb_data_mesin $mesin, Request $request)
    {

        $dataloadingmesin = tb_data_loading_machine_plant1::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

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

        $dataloadingmachine = $dataloadingmesin->get();

        $pdf = PDF::loadView('UserPPICPlant1.Export_PDF_Data_Detail_Loading_Mesin_Plant_1', ['data' => $dataloadingmachine, 'mesin' => $mesin, 'count' => $dataloadingmesincount])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_1.pdf');
    }

    public function TambahLoadingMachineSistemPlant1PLNT1()
    {
        return view('UserPPICPlant1.Halaman_Tambah_Loading_Machine_SPK_Plant_1_PLNT_1', [
            'judul' => 'Halaman Tambah Loading Machine Sistem Plant 1',
            'datamesin' => tb_data_mesin::all()
        ]);
    }


    public function UbahPasswordPlant1()
    {
        return view('UserPPICPlant1.Halaman_Ubah_Password_Plant_1', [
            'judul' => 'Halaman Ubah Password Admin'
        ]);
    }


    public function PostUbahPasswordUserPlant1(Request $request)
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

    public function ProfileUserPlant1()
    {
        return view('UserPPICPlant1.Halaman_Profile_User_Plant_1', [
            'judul' => 'Halaman Profile User Plant 1',
        ]);
    }

    public function PostGetFotoProfileUser(Request $request)
    {
        DB::beginTransaction();

        try {

            $userplant1 = auth()->user();

            if ($userplant1->image) {

                Storage::delete($userplant1->image);
            }

            $uploadSettings = ["directory" => "fotouser", "disk" => "public", "maxFileSize" => 52428800, "allowedExtensions" => ['jpeg', 'jpg', 'png']];

            $ambilfoto = $request->image;

            $file_uploader_factory = new \OldRavian\FileUploader\Factories\FileUploaderFactory();
            $file_uploader = $file_uploader_factory->build("base64");
            $data = $file_uploader->upload($ambilfoto, $uploadSettings);
            $dataimage = $data['filename'];

            $userplant1->update([
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

    public function PostUbahFotoProfileUserPLNT1(Request $request)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,png|max:2048'
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

        return back();
    }


    public function LihatDataLoadingMesinPlant1(Request $request)
    {

        $opsi = $request->input('lihat_data_loading_machine_pl_1');

        if ($opsi == 'Lihat Data Loading Machine Per Mesin') {

            return redirect('/lihatsemuadataloadingmachineplant1plnt1');
        } elseif ($opsi == 'Lihat Data Keseluruhan Loading Machine') {

            return redirect('/lihatdatakeseluruhanloadingmachineplant1/pln1');
        }
    }

    public function LihatDataKeseluruhanLoadingMachinePlant1PLN1(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:700',
            'opsi_filter' => 'nullable|string|in:Done,Not Done,All',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
        ]);

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

        $datasemualoadingmachineplant1count = $datakeseluruhanloadingmachineplant1->count();

        $datasemualoadingmachineplant1 = $datakeseluruhanloadingmachineplant1->paginate(10)->WithQueryString();

        return view('UserPPICPlant1.Halaman_Lihat_Data_Keseluruhan_Loading_Machine_Plant_1_PLN_1', [
            'judul' => 'Halaman Lihat Data Keseluruhan Loading Machine Plant 1',
            'dataloadingmachineplant1' =>  $datasemualoadingmachineplant1,
            'dataloadingmachineplant1count' => $datasemualoadingmachineplant1count,
            'datamesin' => tb_data_mesin::all()
        ]);
    }

    public function ExportPDFDataKeseluruhanLoadingMachinePlant1PLN1(Request $request)
    {
        $datakeseluruhanloadingmachineplant1 = DB::table('tb_data_loading_machine_plant1s')->whereNull('deleted_at');

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

        // Filter berdasarkan opsi 'Done', 'Not Done', atau 'All'
        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {
                $datakeseluruhanloadingmachineplant1->where('status_done', 'Not Done');
            } elseif ($opsi === 'Done') {
                $datakeseluruhanloadingmachineplant1->where('status_done', 'Done');
            }
        }

        // Filter berdasarkan rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $datakeseluruhanloadingmachineplant1->whereBetween('tanggal_input', [$startDate, $endDate]);
        }

        $datasemualoadingmachineplant1count = $datakeseluruhanloadingmachineplant1->count();

        $datasemualoadingmachineplant1 = $datakeseluruhanloadingmachineplant1->get();

        $pdf = PDF::loadView('UserPPICPlant1.Export_PDF_Data_Keseluruhan_Loading_Mesin_Plant_1', ['data' => $datasemualoadingmachineplant1, 'count' => $datasemualoadingmachineplant1count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_1.pdf');
    }


    public function PostDeleteDataKeseluruhanLoadingMesinPlant1PLNT1(tb_data_loading_machine_plant1 $data)
    {
        if ($data) {

            $data->delete();
        }

        return back()->with('PostDeleteDataKeseluruhanLoadingMesinPlant1PLNT1', 'Hapus Data Loading Machine Berhasil');
    }


    public function RestoreDataLoadingMachinePlant1PLN1(Request $request)
    {
        $datarestore = tb_data_loading_machine_plant1::onlyTrashed();

        if ($request->has('search')) {

            $search = $request->input('search');

            $datarestore->where(function ($query) use ($search) {
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

        $datarestoreloadingmachineplant1count = $datarestore->count();

        $datarestoreloadingmachineplant1 = $datarestore->paginate(10)->WithQueryString();

        return view('UserPPICPlant1.Halaman_Restore_Data_Loading_Machine_Plant_1_PLN_1', [
            'judul' => 'Halaman Restore Data Loading Machine Plant 1',
            'datarestore' => $datarestoreloadingmachineplant1,
            'datacount' => $datarestoreloadingmachineplant1count,
            'datamesin' => tb_data_mesin::all()
        ]);
    }

    public function PostRestoreDataLoadingMachinePlant1PLN1($data)
    {
        $dataloadingmachine = tb_data_loading_machine_plant1::onlyTrashed()->where('url_unique', $data)->first();

        $dataloadingmachine->restore();

        return back()->with('PostRestoreDataLoadingMachinePlant1PLN1', 'Restore Data Loading Machine Berhasil');
    }

    public function PostEditDataKeseluruhanLoadingMachinePPICPlant1PLN1(tb_data_loading_machine_plant1 $data, Request $request)
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

        return back()->with('PostEditDataKeseluruhanLoadingMachinePPICPlant1PLN1', 'Edit Data Loading Machine Berhasil');
    }

    public function PostUpdateStatusDoneDataKeseluruhanLoadingMesinPlant1PLNT1(tb_data_loading_machine_plant1 $data)
    {
        $time = Carbon::now('Asia/Jakarta');

        $array1 = [
            'status_done' => 'Done',
            'on_proses' => 'Ok',
            'user_pengupdated_status_done_loading_mesin' => auth()->user()->nama_user,
            'departemen_user_pengupdated_status_done_loading_mesin' => auth()->user()->departemen,
            'plant_user_pengupdated_status_done_loading_mesin' => auth()->user()->plant,
            'tanggal_updated_status_done_loading_mesin' => HtmlPurifierHelper::clean($time->format('Y-m-d')),
            'jam_updated_status_done_loading_mesin' => HtmlPurifierHelper::clean($time->format('H:i:s'))
        ];

        $array2 = [
            'status_done' => 'Not Done',
            'on_proses' => 'On',
            'user_pengupdated_status_done_loading_mesin' => auth()->user()->nama_user,
            'departemen_user_pengupdated_status_done_loading_mesin' => auth()->user()->departemen,
            'plant_user_pengupdated_status_done_loading_mesin' => auth()->user()->plant,
            'tanggal_updated_status_done_loading_mesin' => HtmlPurifierHelper::clean($time->format('Y-m-d')),
            'jam_updated_status_done_loading_mesin' => HtmlPurifierHelper::clean($time->format('H:i:s'))
        ];

        if ($data->status_done == 'Done' && $data->on_proses == 'Ok') {

            $data->update($array2);
        } elseif ($data->status_done == 'Not Done' && $data->on_proses == 'On') {

            $data->update($array1);
        }

        return back()->with('PostUpdateStatusDoneDataKeseluruhanLoadingMesinPlant1PLNT1', 'Update Status Done Loading Machine Berhasil');
    }

    public function PilihOpsiLihatLoadingMachinePlant1()
    {
        return view('UserPPICPlant1.Halaman_Lihat_Opsi_Lihat_Data_Loading_Machine_Plant_1', [
            'judul' => 'Pilih Opsi Lihat Data Loading Machine Plant 1'
        ]);
    }

    public function GetPlilihOpsiLihatDataLoadingMachinePlant1PLN1(Request $request)
    {

        $opsi = $request->input('pilih_opsi_lihat_data_loading_machine_plant_1');

        if ($opsi == 'Lihat Data Loading Machine Per Mesin') {

            return redirect('/lihatsemuadataloadingmachineplant1plnt1');
        } elseif ($opsi == 'Lihat Data Keseluruhan Loading Machine') {

            return redirect('/lihatdatakeseluruhanloadingmachineplant1/pln1');
        }
    }
    
    public function ExportExcelDataDetailLoadingMachinePlant1(tb_data_mesin $mesin, Request $request)
    {

        $dataloadingmachineplant1 = tb_data_loading_machine_plant1::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmachineplant1->where(function ($query) use ($search) {
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

                $dataloadingmachineplant1->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $dataloadingmachineplant1->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmachineplant1->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmesinplant1 = $dataloadingmachineplant1->get();

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
        foreach ($dataloadingmesinplant1 as $item) {
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
    
    public function ExportExcelDataKeseluruhanLoadingMachinePlant1PLN1(Request $request)
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

        // Filter berdasarkan opsi 'Done', 'Not Done', atau 'All'
        if ($request->filled('opsi_filter')) {

            $opsi = $request->input('opsi_filter');

            if ($opsi === 'Not Done') {
                $datakeseluruhanloadingmachineplant1->where('status_done', 'Not Done');
            } elseif ($opsi === 'Done') {
                $datakeseluruhanloadingmachineplant1->where('status_done', 'Done');
            }
        }

        // Filter berdasarkan rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $datakeseluruhanloadingmachineplant1->whereBetween('tanggal_input', [$startDate, $endDate]);
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
        $filePath = storage_path('app/public/exported_data.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }
    
    public function PilihOpsiLihatDataLoadingMachinePlant2PLN1() 
    {
        return view('UserPPICPlant1.Halaman_Pilih_Opsi_Lihat_Data_Loading_Machine_Plant_2_PLNT1', [
            'judul' => 'Halaman Pilih Opsi Lihat Data Loading Machine Plant 2'
        ]);
    }
    
    public function GetPilihOpsiLihatDataLoadingMachinePlant2PLNT1(Request $request) 
    {
        $opsi = HtmlPurifierHelper::clean($request->input('pilih_opsi_lihat_data_loading_machine_plant_2_plnt_1'));
        
        if($opsi === 'Lihat Data Loading Machine Per Mesin') {
            
            return redirect('/lihatdataloadingmachinepermachineplant2/plant1');
        } elseif($opsi === 'Lihat Data Keseluruhan Loading Machine') {
            
            return redirect('/lihatdatakeseluruhanloadingmachineplant2/plant1');
        }
    }
    
    public function LihatDataLoadingMachinePerMachinePlant2PLNT1() 
    {
        return view('UserPPICPlant1.Halaman_Lihat_Data_Loading_Machine_Per_Machine_Plant_2_PLANT_1', [
            'judul' => 'Halaman Lihat Data Loading Machine Plant 2',
            'datamesin' => tb_data_mesin_plant_2::all(),
        ]);
    }
    
    public function LihatDetailDataLoadingMesinPlant2PLANT1(tb_data_mesin_plant_2 $mesin, Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:700',
            'opsi_filter' => 'nullable|in:Done,Not Done,All',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
        ]);

        $dataloadingmesinplant2permesin = tb_data_loading_machine_plant2::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at')
            ->with('fileProjekLoadingMachinePlant2');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmesinplant2permesin->where(function ($query) use ($search) {

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

                $dataloadingmesinplant2permesin->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $dataloadingmesinplant2permesin->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startdate = $request->input('start_date');
            $enddate = $request->input('end_date');

            $dataloadingmesinplant2permesin->where(function ($query) use ($startdate, $enddate) {

                $query->whereBetween('tanggal_input', [$startdate, $enddate]);
            });
        }

        $dataloadingmesinplant2permesincount = $dataloadingmesinplant2permesin->count();

        $dataloadingmachine = $dataloadingmesinplant2permesin->paginate(10)->WithQueryString();

        return view('UserPPICPlant1.Halaman_Lihat_Detail_Data_Loading_Mesin_Plant_2_Per_Machine_PLNT_1', [
            'judul' => 'Lihat Detail Data Loading Machine Plant 2',
            'dataloadingmachine' => $dataloadingmachine,
            'mesin' => $mesin,
            'countData' => $dataloadingmesinplant2permesincount,
        ]);
    }
    
    public function ExportPDFDataDetailLoadingMachinePlant2PerMesinPLNT1(tb_data_mesin_plant_2 $mesin, Request $request)
    {

        $dataloadingmachineplant2 = tb_data_loading_machine_plant2::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmachineplant2->where(function ($query) use ($search) {

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

        $dataloadingmachineplant2count = $dataloadingmachineplant2->count();

        $dataloadingmachineplant2permesin = $dataloadingmachineplant2->get();

        $pdf = PDF::loadView('UserPPICPlant1.Export_PDF_Data_Detail_Loading_Mesin_Plant_2_Per_Mesin', ['data' => $dataloadingmachineplant2permesin, 'mesin' => $mesin, 'count' => $dataloadingmachineplant2count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_2.pdf');
    }

    public function ExportExcelDataDetailLoadingMachinePlant2PerMesinPLNT1(tb_data_mesin_plant_2 $mesin, Request $request)
    {
        $dataloadingmesinplant2 = tb_data_loading_machine_plant2::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmesinplant2->where(function ($query) use ($search) {

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

                $dataloadingmesinplant2->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $dataloadingmesinplant2->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmesinplant2->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmesinplant2permesin = $dataloadingmesinplant2->get();


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
        foreach ($dataloadingmesinplant2permesin as $item) {
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
    
    public function LihatDataKeseluruhanLoadingMachinePlant2PLANT1(Request $request)
    {

        $request->validate([
            'search' => 'nullable|string|max:700',
            'opsi_filter' => 'nullable|in:Done,Not Done,All',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
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

        return view('UserPPICPlant1.Halaman_Lihat_Data_Keseluruhan_Loading_Machine_Plant_2_PLANT1', [
            'judul' => 'Halaman Lihat Data Keseluruhan Loading Machine Plant 2',
            'dataloadingmachineplant2' => $dataallloadingmachineplant2,
            'dataloadingmachineplant2count' => $datakeseluruhanloadingmachineplant2count
        ]);
    }

    public function ExportPDFDataKeseluruhanLoadingMachinePlant2PLANT1(Request $request)
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

        $pdf = PDF::loadView('UserPPICPlant1.Export_PDF_Data_Keseluruhan_Loading_Mesin_Plant_2_PLANT1', ['data' => $dataallloadingmachineplant2, 'count' => $datakeseluruhanloadingmachineplant2count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_2.pdf');
    }

    public function ExportExcelDataKeseluruhanLoaadingMachinePlant2PLANT1(Request $request)
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
    
    public function PilihOpsiLihatDataLoadingMachinePlant3PLANT1()
    {

        return view('UserPPICPlant1.Halaman_Pilih_Opsi_Lihat_Data_Loading_Machine_Plant_3_PLANT1', [
            'judul' => 'Halaman Pilih Opsi Lihat Data Loading Machine Plant 3'
        ]);
    }

    public function GetPilihOpsiLihatDataLoadingMachinePlant3PLANT1(Request $request)
    {

        $opsi = HtmlPurifierHelper::clean($request->input('pilih_opsi_lihat_data_loading_machine_plant_3_plant_1'));

        if ($opsi === 'Lihat Data Loading Machine Per Mesin') {

            return redirect('/lihatdataloadingmesinpermesinplant3/plant1');
        } elseif ($opsi === 'Lihat Data Keseluruhan Loading Machine') {

            return redirect('/lihatdatakeseluruhanloadingmesinplant3/plant1');
        }
    }

    public function LihatDataLoadingMesinPerMesinPlant3PLANT1()
    {

        return view('UserPPICPlant1.Halaman_Lihat_Data_Loading_Mesin_Per_Mesin_Plant_3_PLANT1', [
            'judul' => 'Lihat Data Loading Machine Plant 3',
            'datamesin' => tb_data_mesin_plant_3::all()
        ]);
    }

    public function LihatDetailDataLoadingMachinePlant3PLANT1(tb_data_mesin_plant_3 $mesin, Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:700',
            'opsi_filter' => 'nullable|in:Done,Not Done,All',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
        ]);

        $dataloadingmesinplant3permesin = tb_data_loading_machine_plant3::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at')
            ->with('fileProjekLoadingMachinePlant3');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmesinplant3permesin->where(function ($query) use ($search) {

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

                $dataloadingmesinplant3permesin->where(function ($query) {

                    $query->where('status_done', 'Not Done');
                });
            } elseif ($opsi === 'Done') {

                $dataloadingmesinplant3permesin->where(function ($query) {

                    $query->where('status_done', 'Done');
                });
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmesinplant3permesin->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmesinplant3permesincount = $dataloadingmesinplant3permesin->count();

        $dataallloadingmachineplant3 = $dataloadingmesinplant3permesin->paginate(10)->WithQueryString();

        return view('UserPPICPlant1.Halaman_Lihat_Detail_Data_Loading_Machine_Plant_3_Per_Machine_PLANT1', [
            'judul' => 'Halaman Lihat Data Loading Machine Plant 3 Per Machine',
            'dataloadingmachineplant3' => $dataallloadingmachineplant3,
            'mesin' => $mesin,
            'dataloadingmachineplant3count' => $dataloadingmesinplant3permesincount
        ]);
    }

    public function ExportPDFDataDetailLoadingMesinPlant3PerMesinPLANT1(tb_data_mesin_plant_3 $mesin, Request $request)
    {

        $dataloadingmachineplant3permesin = tb_data_loading_machine_plant3::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmachineplant3permesin->where(function ($query) use ($search) {

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

        $dataallloadingmachineplant3 = $dataloadingmachineplant3permesin->get();

        $pdf = PDF::loadView('UserPPICPlant1.Export_PDF_Data_Loading_Mesin_Plant_3_Per_Mesin_PLANT1', ['data' => $dataallloadingmachineplant3, 'count' => $dataloadingmachineplant3permesincount, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_3.pdf');
    }

    public function ExportExcelDataDetailLoadingMesinPlant3PerMesinPLANT1(tb_data_mesin_plant_3 $mesin, Request $request)
    {

        $dataloadingmachineplant3permesin = tb_data_loading_machine_plant3::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->filled('search')) {

            $search = $request->input('search');

            $dataloadingmachineplant3permesin->where(function ($query) use ($search) {

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

        $dataallloadingmachineplant3 = $dataloadingmachineplant3permesin->get();

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
    
    public function LihatDataKeseluruhanLoadingMachinePlant3PLANT1(Request $request)
    {

        $request->validate([
            'search' => 'nullable|string|max:700',
            'opsi_filter' => 'nullable|in:Done,Not Done,All',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
        ]);

        $datakeseluruhanloadingmachineplant3 = tb_data_loading_machine_plant3::whereNull('deleted_at')
            ->with('fileProjekLoadingMachinePlant3');

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
            }

            if ($opsi === 'Done') {

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

        $dataallloadingmachineplant3 = $datakeseluruhanloadingmachineplant3->paginate(10)->WithQueryString();

        return view('UserPPICPlant1.Halaman_Lihat_Data_Keseluruhan_Loading_Machine_Plant_3_PLANT1', [
            'judul' => 'Halaman Lihat Data Keseluruhan Loading Machine Plant 3',
            'datakeseluruhanloadingmachine' => $dataallloadingmachineplant3,
            'datakeseluruhanloadingmachinecount' => $datakeseluruhanloadingmachineplant3count
        ]);
    }

    public function ExportPDFDataKeseluruhanLoadingMachinePlant3PLANT1(Request $request)
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

        $datakeseluruhanloadingmachineplant3count = $datakeseluruhanloadingmachineplant3->count();

        $dataloadingmachineplant3all = $datakeseluruhanloadingmachineplant3->get();

        $pdf = PDF::loadView('UserPPICPlant1.Export_PDF_Data_Keseluruhan_Loading_Mesin_Plant_3_PLANT1', ['data' => $dataloadingmachineplant3all, 'count' => $datakeseluruhanloadingmachineplant3count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_3.pdf');
    }

    public function ExportExcelDataKeseluruhanLoadingMachinePlant3PLANT1(Request $request)
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
        $filePath = storage_path('app/public/loading_mesin_plant_3.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }
    
    
    // LIHAT FILE PROJEK

    public function LihatFileProjekLoadingMachinePlant1PLANT1(tb_data_loading_machine_plant1 $data, Request $request)
    {
        $datafileprojek = tb_data_file_projek_loading_machine_plant_1::where('url_unique_loading_machine', $data->url_unique);

        if ($request->has('search')) {

            $search = $request->input('search');

            $datafileprojek->where(function ($query) use ($search) {

                $query->where('tanggal_file_diupload', 'like', '%' . $search . '%')
                    ->orWhere('tanggal_file_diubah', 'like', '%' . $search . '%');
            });
        }

        $datafileprojekcount = $datafileprojek->count();

        $datafile = $datafileprojek->paginate(10)->WithQueryString();

        return view('UserPPICPlant1.Halaman_Lihat_File_Projek_Loading_Machine_Plant_1_PLANT1', [
            'judul' => 'Halaman Lihat Data File Projek Loading Machine Plant 1',
            'datafileprojek' => $datafile,
            'data' => $data,
            'datafileprojekcount' => $datafileprojekcount
        ]);
    }

    public function PostTambahDataFileProjekLoadingMachinePlant1PLNT1(tb_data_loading_machine_plant1 $data, Request $request)
    {

        $time = Carbon::now('Asia/Jakarta');

        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        if ($request->hasFile('file')) {

            $files['fileprojekloadingmachineplant1'] = $request->file('file')->store('fileprojekloadingmachineplant1');
        }

        tb_data_file_projek_loading_machine_plant_1::create([
            'url_unique_loading_machine' => $data->url_unique,
            'url_unique' => Str::uuid(),
            'file' => $files['fileprojekloadingmachineplant1'],
            'tanggal_file_diupload' => $time->format('Y-m-d H:i:s'),
        ]);

        return back()->with('PostTambahDataFileProjekLoadingMachinePlant1PLNT1', 'Tambah Data File Projek Berhasil');
    }

    public function PostDeleteFileProjekLoadingMachinePlant1PLNT1(tb_data_file_projek_loading_machine_plant_1 $file)
    {

        if ($file->file) {

            Storage::delete($file->file);
        }

        $file->delete();

        return back()->with('PostDeleteFileProjekLoadingMachinePlant1PLNT1', 'Hapus Data Berhasil');
    }

    public function PostUbahDataFileProjekLoadingMachinePlant1PLANT1(tb_data_file_projek_loading_machine_plant_1 $file, Request $request)
    {

        $time = Carbon::now('Asia/Jakarta');

        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        if ($request->hasFile('file')) {

            if ($file->file) {

                Storage::delete($file->file);
            }

            $files['fileprojekloadingmachineplant1'] = $request->file('file')->store('fileprojekloadingmachineplant1');
        }

        $file->update([
            'file' => $files['fileprojekloadingmachineplant1'],
            'tanggal_file_diubah' => $time->format('Y-m-d H:i:s'),
        ]);

        return back()->with('PostUbahDataFileProjekLoadingMachinePlant1PLANT1', 'Ubah Data Berhasil');
    }

    public function PostTambahDataFileProjekLoadingMachinePerMachinePlant1(tb_data_loading_machine_plant1 $data, Request $request)
    {

        $time = Carbon::now('Asia/Jakarta');

        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        if ($request->hasFile('file')) {

            $files['fileprojekloadingmachineplant1'] = $request->file('file')->store('fileprojekloadingmachineplant1');
        }

        tb_data_file_projek_loading_machine_plant_1::create([
            'url_unique_loading_machine' => $data->url_unique,
            'url_unique' => Str::uuid(),
            'file' => $files['fileprojekloadingmachineplant1'],
            'tanggal_file_diupload' => $time->format('Y-m-d H:i:s'),
        ]);

        return back()->with('PostTambahDataFileProjekLoadingMachinePerMachinePlant1', 'Tambah File Berhasil');
    }

    public function LihatDataFileProjekLoadingMachinePlant1PLNT1(tb_data_loading_machine_plant1 $data, Request $request)
    {
        $datafileprojekloadingmachineplant1 = tb_data_file_projek_loading_machine_plant_1::where('url_unique_loading_machine', $data->url_unique);

        if ($request->has('search')) {

            $search = $request->input('search');

            $datafileprojekloadingmachineplant1->where(function ($query) use ($search) {

                $query->where('tanggal_file_diupload', 'like', '%' . $search . '%')
                    ->orWhere('tanggal_file_diubah', 'like', '%' . $search . '%');
            });
        }

        $datafileprojekloadingmachineplant1count = $datafileprojekloadingmachineplant1->count();

        $datafileprojek = $datafileprojekloadingmachineplant1->paginate(10)->WithQueryString();

        return view('UserPPICPlant1.Halaman_Lihat_Data_File_Projek_Loading_Machine_Plant_1_Per_Machine', [
            'judul' => 'Halaman Lihat Data File Projek Loading Machine Plant 1',
            'datafileprojek' => $datafileprojek,
            'datafileprojekcount' => $datafileprojekloadingmachineplant1count,
            'data' => $data
        ]);
    }

    public function PostTambahDataFileProjekLoadingMachinePerMachinePlant1PLNT1(tb_data_loading_machine_plant1 $data, Request $request)
    {

        $time = Carbon::now('Asia/Jakarta');

        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        if ($request->hasFile('file')) {

            $files['fileprojekloadingmachineplant1'] = $request->file('file')->store('fileprojekloadingmachineplant1');
        }

        tb_data_file_projek_loading_machine_plant_1::create([
            'url_unique_loading_machine' => $data->url_unique,
            'url_unique' => Str::uuid(),
            'file' => $files['fileprojekloadingmachineplant1'],
            'tanggal_file_diupload' => $time->format('Y-m-d H:i:s')
        ]);


        return back()->with('PostTambahDataFileProjekLoadingMachinePerMachinePlant1PLNT1', 'Tambah Data File Berhasil');
    }

    public function PostDeleteFileProjekLoadingMachinePerMachinePlant1PLNT1(tb_data_file_projek_loading_machine_plant_1 $file)
    {

        if ($file->file) {

            Storage::delete($file->file);
        }

        $file->delete();

        return back()->with('PostDeleteFileProjekLoadingMachinePerMachinePlant1PLNT1', 'Hapus Data Berhasil');
    }

    public function PostUbahDataFileProjekLoadingMachinePerMachinePlant1PLNT1(tb_data_file_projek_loading_machine_plant_1 $file, Request $request)
    {

        $time = Carbon::now('Asia/Jakarta');

        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);


        if ($request->hasFile('file')) {

            if ($file->file) {

                Storage::delete($file->file);
            }

            $files['fileprojekloadingmachineplant1'] = $request->file('file')->store('fileprojekloadingmachineplant1');
        }

        $file->update([
            'file' => $files['fileprojekloadingmachineplant1'],
            'tanggal_file_diubah' => $time->format('Y-m-d H:i:s')
        ]);

        return back()->with('PostUbahDataFileProjekLoadingMachinePerMachinePlant1PLNT1', 'Ubah Data File Berhasil');
    }

    public function PostTambahDataFileProjekLoadingMachineAllPlant1PLANT1(tb_data_loading_machine_plant1 $data, Request $request)
    {

        $time = Carbon::now('Asia/Jakarta');

        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        if ($request->hasFile('file')) {

            $files['fileprojekloadingmachineplant1'] = $request->file('file')->store('fileprojekloadingmachineplant1');
        }

        tb_data_file_projek_loading_machine_plant_1::create([
            'url_unique_loading_machine' => $data->url_unique,
            'url_unique' => Str::uuid(),
            'file' => $files['fileprojekloadingmachineplant1'],
            'tanggal_file_diupload' => $time->format('Y-m-d H:i:s')
        ]);

        return back()->with('PostTambahDataFileProjekLoadingMachineAllPlant1PLANT1', 'Tambah Data File Berhasil');
    }
    
    
    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE 

    public function ExportPDFStartDateEndDateDataDetailLoadingMachinePlant1PLNT1(tb_data_mesin $mesin, Request $request)
    {

        $dataloadingmachineplant1 = tb_data_loading_machine_plant1::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->has('start_date') && $request->has('end_date')) {

            $startdate = $request->input('start_date');
            $enddate = $request->input('end_date');

            $dataloadingmachineplant1->where(function ($query) use ($startdate, $enddate) {

                $query->whereBetween('tanggal_input', [$startdate, $enddate]);
            });
        }

        $dataloadingmachineplant1count = $dataloadingmachineplant1->count();

        $dataloadingmachine = $dataloadingmachineplant1->get();

        $pdf = PDF::loadView('UserPPICPlant1.Export_PDF_Data_Start_Date_End_Date_Detail_Loading_Machine_PLANT1_PLNT1', ['data' => $dataloadingmachine, 'count' => $dataloadingmachineplant1count, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_1.pdf');
    }

    public function ExportExcelStartDateEndDateDataDetailLoadingMachinePlant1PLNT1(tb_data_mesin $mesin, Request $request)
    {

        $dataloadingmachineplant1 = tb_data_loading_machine_plant1::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->has('start_date') && $request->has('end_date')) {

            $startdate = $request->input('start_date');
            $enddate = $request->input('end_date');

            $dataloadingmachineplant1->where(function ($query) use ($startdate, $enddate) {

                $query->whereBetween('tanggal_input', [$startdate, $enddate]);
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


    public function ExportPDFFilterDoneNotDoneDataDetailLoadingMachinePlant1PLNT1(tb_data_mesin $mesin, Request $request)
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
        } elseif ($filter === 'All') {
        }

        $dataloadingmesinplant1count = $dataloadingmachineplant1->count();

        $dataloadingmesin = $dataloadingmachineplant1->get();

        $pdf = PDF::loadView('UserPPICPlant1.Export_PDF_Filter_Done_Not_Done_Data_Detail_Loading_Machine_PLANT1', ['data' => $dataloadingmesin, 'count' => $dataloadingmesinplant1count, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_1.pdf');
    }
    
    public function ExportExcelFilterDoneNotDoneDataDetailLoadingMachinePlant1PLNT1(tb_data_mesin $mesin, Request $request)
    {

        $dataloadingmachineplant1 = tb_data_loading_machine_plant1::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        $opsi = $request->query('opsi_filter');

        if ($opsi === 'Not Done') {

            $dataloadingmachineplant1->where(function ($query) {

                $query->where('status_done', 'Not Done');
            });
        } elseif ($opsi === 'Done') {

            $dataloadingmachineplant1->where(function ($query) {

                $query->where('status_done', 'Done');
            });
        } elseif ($opsi === 'All' || $filter === null) {
        }

        $dataloadingmesin = $dataloadingmachineplant1->get();

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
        foreach ($dataloadingmesin as $item) {
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
    
    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE KESELURUHAN

    public function ExportPDFStartDateEndDateLihatDataAllLoadingMachinePlant1PLNT1(Request $request)
    {

        $datakeseluruhanloadingmachineplant1 = tb_data_loading_machine_plant1::whereNull('deleted_at');

        if ($request->has('start_date') && $request->has('end_date')) {

            $startdate = $request->input('start_date');
            $enddate = $request->input('end_date');

            $datakeseluruhanloadingmachineplant1->where(function ($query) use ($startdate, $enddate) {

                $query->whereBetween('tanggal_input', [$startdate, $enddate]);
            });
        }

        $datakeseluruhanloadingmachineplant1count = $datakeseluruhanloadingmachineplant1->count();

        $dataallloadingmachineplant1 = $datakeseluruhanloadingmachineplant1->get();

        $pdf = PDF::loadView('UserPPICPlant1.Export_PDF_Start_Date_End_Date_Lihat_Data_All_Loading_Machine_Plant_1_PLNT1', ['data' => $dataallloadingmachineplant1, 'count' => $datakeseluruhanloadingmachineplant1count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_1.pdf');
    }

    public function ExportExcelStartDateEndDateLihatDataAllLoadingMachinePlant1PLNT1(Request $request)
    {

        $datakeseluruhanloadingmachineplant1 = tb_data_loading_machine_plant1::whereNull('deleted_at');

        if ($request->has('start_date') && $request->has('end_date')) {

            $startdate = $request->input('start_date');
            $enddate = $request->input('end_date');

            $datakeseluruhanloadingmachineplant1->where(function ($query) use ($startdate, $enddate) {

                $query->whereBetween('tanggal_input', [$startdate, $enddate]);
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

    public function ExportPDFFilterDoneNotDoneLihatDataAllLoadingMachinePlant1PLNT1(Request $request)
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

        $pdf = PDF::loadView('UserPPICPlant1.Export_PDF_Filter_Done_Not_Done_Lihat_Data_All_Loading_Machine_Plant1_PLNT1', ['data' => $dataallloadingmachineplant1, 'count' => $datakeseluruhanloadingmachineplant1count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_1.pdf');
    }

    public function ExportExcelFilterDoneNotDoneLihatDataAllLoadingMachinePlant1PLN1(Request $request)
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
    
    
    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE DATA DETAIL LOADING MACHINE PLANT2 PER MACHINE PLNT1

    public function ExportPDFStartDateEndDateLihatDetailDataLoadingMachinePlant2PerMachinePLNT1(tb_data_mesin_plant_2 $mesin, Request $request)
    {

        $dataloadingmachineplant2 = tb_data_loading_machine_plant2::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->has('start_date') && $request->has('end_date')) {

            $startdate = $request->input('start_date');
            $enddate = $request->input('end_date');

            $dataloadingmachineplant2->where(function ($query) use ($startdate, $enddate) {

                $query->whereBetween('tanggal_input', [$startdate, $enddate]);
            });
        }

        $dataloadingmachineplant2count = $dataloadingmachineplant2->count();

        $dataloadingmesinplant2 = $dataloadingmachineplant2->get();

        $pdf = PDF::loadView('UserPPICPlant1.Export_PDF_Start_Date_End_Date_Lihat_Detail_Data_Loading_Machine_Plant2_Per_Machine_PLNT1', ['data' => $dataloadingmesinplant2, 'count' => $dataloadingmachineplant2count, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_2.pdf');
    }

    public function ExportExcelStartDateEndDateLihatDetailDataLoadingMachinePlant2PerMachinePLNT1(tb_data_mesin_plant_2 $mesin, Request $request)
    {

        $dataloadingmachineplant2 = tb_data_loading_machine_plant2::where('url_unique_data_mesin', $mesin->url_unique_mesin)->whereNull('deleted_at');

        if ($request->has('start_date') && $request->has('end_date')) {

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
        $filePath = storage_path('app/public/loading_mesin_plant_2.xlsx');
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }

    public function ExportPDFFilterDoneNotDoneLihatDetailDataLoadingMachinePlant2pPerMachinePLNT1(tb_data_mesin_plant_2 $mesin, Request $request)
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

        $dataloadingmesin = $dataloadingmachineplant2->get();

        $pdf = PDF::loadView('UserPPICPlant1.Export_PDF_Filter_Done_Not_Done_Lihat_Detail_Data_Loading_Machine_Plant2_Per_Machine_PLNT1', ['data' => $dataloadingmesin, 'count' => $dataloadingmachineplant2count, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_2.pdf');
    }

    public function ExportExcelFilterDoneNotDoneLihatDetailDataLoadingMachinePlant2PerMachinePLNT1(tb_data_mesin_plant_2 $mesin, Request $request)
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

        $dataloadingmesin = $dataloadingmachineplant2->get();

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
        foreach ($dataloadingmesin as $item) {
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
    
    
    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE LIHAT DATA KESELURUHAN LOADING MACHINE PLANT2 PLANT1

    public function ExportPDFStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant2PLANT1(Request $request)
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

        $pdf = PDF::loadView('UserPPICPlant1.Export_PDF_Start_Date_End_Date_Lihat_Data_Keseluruhan_Loading_Machine_Plant2_PLANT1', ['data' => $dataallloadingmachineplant2, 'count' => $datakeseluruhanloadingmachineplant2count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_2.pdf');
    }

    public function ExportExcelStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant2PLANT1(Request $request)
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

    public function ExportPDFFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant2PLNT1(Request $request)
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

        $pdf = PDF::loadView('UserPPICPlant1.Export_PDF_Filter_Done_Not_Done_Lihat_Data_Keseluruhan_Loading_Machine_Plant2_PLANT1', ['data' => $dataallloadingmachineplant2, 'count' => $datakeseluruhanloadingmachineplant2count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_2.pdf');
    }

    public function ExportExcelFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant2PLNT1(Request $request)
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
    
    
    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE LIHAT DATA KESELURUHAN LOADING MACHINE PLANT3 PLANT1

    public function ExportPDFStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant3PLANT1(Request $request)
    {

        $dataloadingmachineplant3 = tb_data_loading_machine_plant3::whereNull('deleted_at');

        if ($request->has('start_date') && $request->has('end_date')) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $dataloadingmachineplant3->where(function ($query) use ($startDate, $endDate) {

                $query->whereBetween('tanggal_input', [$startDate, $endDate]);
            });
        }

        $dataloadingmachineplant3count = $dataloadingmachineplant3->count();

        $dataloadingmachine = $dataloadingmachineplant3->get();

        $pdf = PDF::loadView('UserPPICPlant1.Export_PDF_Start_Date_End_Date_Lihat_Data_Keseluruhan_Loading_Machine_Plant3_PLANT1', ['data' => $dataloadingmachine, 'count' => $dataloadingmachineplant3count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_3.pdf');
    }

    public function ExportExcelStartDateEndDateLihatDataKeseluruhanLoadingMachinePlant3PLANT1(Request $request)
    {

        $dataloadingmachineplant3 = tb_data_loading_machine_plant3::whereNull('deleted_at');

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

    public function ExportPDFFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant3PLANT1(Request $request)
    {

        $dataloadingmachineplant3 = tb_data_loading_machine_plant3::whereNull('deleted_at');

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

        $pdf = PDF::loadView('UserPPICPlant1.Export_PDF_Filter_Done_Not_Done_Lihat_Data_Keseluruhan_Loading_Machine_Plant3_PLANT1', ['data' => $dataloadingmachine, 'count' => $dataloadingmachineplant3count])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_3.pdf');
    }

    public function ExportExcelFilterDoneNotDoneLihatDataKeseluruhanLoadingMachinePlant3PLANT1(Request $request)
    {

        $dataloadingmachineplant3 = tb_data_loading_machine_plant3::whereNull('deleted_at');

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
    
    
    // EXPORT PDF DAN EXCEL START END DATE END DAN FILTER DONE NOT DONE LIHAT DETAIL DATA LOADING MACHINE PLANT 3 PLANT1

    public function ExportPDFStartDateEndDateLihatDetailDataLoadingMachinePlant3PLANT1(tb_data_mesin_plant_3 $mesin, Request $request)
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

        $pdf = PDF::loadView('UserPPICPlant1.Export_PDF_Start_Date_End_Date_Lihat_Detail_Data_Loading_Machine_Plant3_PLANT1', ['data' => $dataloadingmachine, 'count' => $dataloadingmachineplant3count, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_3.pdf');
    }


    public function ExportExcelStartDateEndDateLihatDetailDataLoadingMachinePlant3PLANT1(tb_data_mesin_plant_3 $mesin, Request $request)
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

    public function ExportPDFFilterDoneNotDoneLihatDetailDataLoadingMachinePlant3PLANT1(tb_data_mesin_plant_3 $mesin, Request $request)
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

        $pdf = PDF::loadView('UserPPICPlant1.Export_PDF_Filter_Done_Not_Done_Lihat_Detail_Data_Loading_Machine_Plant3_PLANT1', ['data' => $dataloadingmachine, 'count' => $dataloadingmachineplant3count, 'mesin' => $mesin])
            ->setPaper('a4', 'landscape');

        return $pdf->download('loading_mesin_plant_3.pdf');
    }

    public function ExportExcelFilterDoneNotDoneLihatDetailDataLoadingMachinePlant3PLANT1(tb_data_mesin_plant_3 $mesin, Request $request)
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
