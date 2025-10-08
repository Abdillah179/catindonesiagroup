<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\tb_data_spk;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\tb_data_mesin;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Helpers\HtmlPurifierHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\tb_data_image_drawing;
use Intervention\Image\Facades\Image;
use Illuminate\Auth\Events\Registered;
use App\Models\tb_data_nama_projek_spk;
use App\Models\tb_data_spk_ppic_plant3;
use Illuminate\Support\Facades\Storage;
use App\Models\tb_data_comodity_part_item;
use App\Models\tb_data_image_drawing_admin;
use App\Models\tb_data_item_part_nama_projek;
use App\Models\tb_data_mesin_plant_2;
use App\Models\tb_data_mesin_plant_3;
use App\Models\tb_data_spk_ppic_plant1;
use App\Models\tb_data_spk_ppic_plant2;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Validation\Rule;
use Mpdf\Mpdf;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Verified;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class ControllerAdmin extends Controller
{
    public function DashboardAdmin()
    {
        return view('UserAdmin.Halaman_Dashboard_Admin', [
            'judul' => 'Halaman Dashboard Admin',

        ]);
    }

    public function DataMesin()
    {
        return view('UserAdmin.Halaman_Data_Mesin', [
            'judul' => 'Halaman Data Mesin',
            'data' => tb_data_mesin::all()
        ]);
    }


    public function PostDeleteDataMesin(tb_data_mesin $data)
    {
        $data->forceDelete();


        return back();
    }


    public function PostEditNamaMesin(tb_data_mesin $data, Request $request)
    {
        $request->validate([
            'nama_mesin' => 'required|string|max:400|unique:tb_data_mesins,nama_mesin',
        ]);

        $data->update([
            'nama_mesin' => HtmlPurifierHelper::clean($request->input('nama_mesin')),
        ]);

        return back();
    }


    public function PostTambahDataMesin(Request $request)
    {
        $request->validate([
            'nama_mesin' => 'required|string|max:400|unique:tb_data_mesins,nama_mesin',
            'kode_mesin' => 'required|string|max:300'
        ]);

        tb_data_mesin::create([
            'url_unique_mesin' => Str::uuid(),
            'nama_mesin' => HtmlPurifierHelper::clean($request->input('nama_mesin')),
            'kode_mesin' => HtmlPurifierHelper::clean($request->input('kode_mesin'))
        ]);


        return back();
    }

    public function DataUserPPICPlant1(Request $request)
    {
        $datauserppicplant1 = User::where('role', 2)->where('departemen', 'PPIC')->where('plant', 'Plant 1');

        if ($request->has('search')) {

            $search = $request->input('search');

            $datauserppicplant1->where(function ($query) use ($search) {
                $query->where('nama_user', 'like', '%' . $search . '%')
                    ->orwhere('nik_karyawan', 'like', '%' . $search . '%')
                    ->orwhere('no_telepon', 'like', '%' . $search . '%')
                    ->orwhere('departemen', 'like', '%' . $search . '%')
                    ->orwhere('plant', 'like', '%' . $search . '%');
            });
        }

        $datauserppicplant1count = $datauserppicplant1->count();

        $datauserplant1 = $datauserppicplant1->paginate(10)->WithQueryString();

        return view('UserAdmin.Halaman_Data_User_PPIC_Plant_1', [
            'judul' => 'Halaman Data User PPIC Plant 1',
            'datauserppicplant1' => $datauserplant1,
            'datauserppicplant1count' => $datauserppicplant1count
        ]);
    }


    public function PostTambahDataUserPPICPlant1ADM(Request $request)
    {
        $time = Carbon::now('Asia/Jakarta');
        
        $request->validate([
            'nama_user' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/', // Hanya huruf dan spasi
            ],
            'nik_karyawan' => [
                'required',
                'numeric',
                'unique:users,nik_karyawan' // NIK karyawan harus berisi 16 digit
            ],
            'no_telepon' => [
                'required',
                'numeric',
                // 'digits_between:10,15', // Nomor telepon harus antara 10-15 digit
            ],
            'departemen' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/', // Hanya huruf dan spasi
            ],
            'plant' => [
                'required',
                'string',
                'max:255', // Hanya huruf dan spasi
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email', // Pastikan email unik di tabel users
            ],
            'password' => [
                'required',
                'string',
                'min:8', // Minimal 8 karakter
                'regex:/[a-z]/', // Harus memiliki setidaknya satu huruf kecil
                'regex:/[A-Z]/', // Harus memiliki setidaknya satu huruf besar
                'regex:/[0-9]/', // Harus memiliki setidaknya satu angka
                'confirmed', // Pastikan ada password_confirmation yang cocok
            ],
            'image' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],
        ]);

        if ($request->file('image')) {

            $foto = $request->file('image')->store('fotouser');
            
            $image = 'fotouser/' . $foto;
        } else {
            $image = 'default.jpg';
        }

        User::create([
            'url_unique' => Str::uuid(),
            'nama_user' => HtmlPurifierHelper::clean($request->input('nama_user')),
            'nik_karyawan' => HtmlPurifierHelper::clean($request->input('nik_karyawan')),
            'no_telepon' => HtmlPurifierHelper::clean($request->input('no_telepon')),
            'departemen' => HtmlPurifierHelper::clean($request->input('departemen')),
            'plant' => HtmlPurifierHelper::clean($request->input('plant')),
            'email' => HtmlPurifierHelper::clean($request->input('email')),
            'password' => HtmlPurifierHelper::clean(Hash::make($request->input('password'))),
            'role' => 2,
            'image' => $image,
            'email_verified_at' => $time->format('Y-m-d H:i:s')
        ]);

        return back()->with('tambahuserppicplant1', 'Tambah Data User Berhasil');
    }


    public function EmailVerify()
    {
        return view('auth.verify-email', [
            'judul' => 'Verifikasi Email'
        ]);
    }


    public function VerificationVerifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();

        $user = Auth::user();

        if ($user->role == 2) {
            return redirect('/DashboardPPICPlant1');
        } elseif ($user->role == 3) {
            return redirect('/DashboardPPICPlant2');
        } elseif ($user->role == 4) {
            return redirect('/DashboardPPICPlant3');
        }
    }

    public function PostEditKodeMesin(tb_data_mesin $data, Request $request)
    {
        $request->validate([
            'kode_mesin' => 'required|string|max:300'
        ]);

        $data->update([
            'kode_mesin' => HtmlPurifierHelper::clean($request->input('kode_mesin'))
        ]);

        return back();
    }

    public function UbahPasswordAdmin()
    {
        return view('UserAdmin.Halaman_Ubah_Password_Admin', [
            'judul' => 'Ubah Password'
        ]);
    }

    public function PostUbahPasswordAdminADM(Request $request)
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

    public function DataMesinPlant2()
    {
        return view('UserAdmin.Halaman_Data_Mesin_Plant_2', [
            'judul' => 'Halaman Data Mesin Plant 2',
            'datamesin' => tb_data_mesin_plant_2::all()
        ]);
    }

    public function PostTambahDataMesinPlant2PLN2(Request $request)
    {
        $request->validate([
            'nama_mesin' => 'required|string|max:400|unique:tb_data_mesin_plant_2s,nama_mesin',
            'kode_mesin' => 'required|string|max:300'
        ]);

        tb_data_mesin_plant_2::create([
            'url_unique_mesin' => Str::uuid(),
            'nama_mesin' => HtmlPurifierHelper::clean($request->input('nama_mesin')),
            'kode_mesin' => HtmlPurifierHelper::clean($request->input('kode_mesin'))
        ]);

        return back()->with('PostTambahDataMesinPlant2PLN2', 'Tambah Data Mesin Berhasil');
    }

    public function PostDeleteDataMesinPlant2(tb_data_mesin_plant_2 $mesin)
    {
        if ($mesin) {

            $mesin->forceDelete();
        }

        return back()->with('PostDeleteDataMesinPlant2', 'Hapus Data Mesin Berhasil');
    }

    public function PostEditNamaMesinPlant2(tb_data_mesin_plant_2 $mesin, Request $request)
    {
        $request->validate([
            'nama_mesin' => 'required|string|max:400|unique:tb_data_mesin_plant_2s,nama_mesin'
        ]);

        $mesin->update([
            'nama_mesin' => HtmlPurifierHelper::clean($request->input('nama_mesin'))
        ]);

        return back()->with('PostEditNamaMesinPlant2', 'Ubah Nama Mesin Berhasil');
    }

    public function PostEditKodeMesinPlant2(tb_data_mesin_plant_2 $mesin, Request $request)
    {
        $request->validate([
            'kode_mesin' => 'required|string|max:300'
        ]);

        $mesin->update([
            'kode_mesin' => HtmlPurifierHelper::clean($request->input('kode_mesin'))
        ]);

        return back()->with('PostEditKodeMesinPlant2', 'Edit Kode Mesin Berhasil');
    }

    public function DataMesinPlant3()
    {
        return view('UserAdmin.Halaman_Data_Mesin_Plant_3', [
            'judul' => 'Halaman Data Mesin Plant 3',
            'datamesin' => tb_data_mesin_plant_3::all()
        ]);
    }

    public function PostTambahDataMesinPlant3(Request $request)
    {
        $request->validate([
            'nama_mesin' => 'required|string|max:400|unique:tb_data_mesin_plant_3s,nama_mesin',
            'kode_mesin' => 'required|string|max:300'
        ]);

        tb_data_mesin_plant_3::create([
            'url_unique_mesin' => Str::uuid(),
            'nama_mesin' => HtmlPurifierHelper::clean($request->input('nama_mesin')),
            'kode_mesin' => HtmlPurifierHelper::clean($request->input('kode_mesin'))
        ]);

        return back()->with('PostTambahDataMesinPlant3', 'Tambah Data Mesin Berhasil');
    }

    public function PostDeleteDataMesinPlant3(tb_data_mesin_plant_3 $mesin)
    {

        if ($mesin) {

            $mesin->forceDelete();
        }

        return back()->with('PostDeleteDataMesinPlant3', 'Hapus Data Mesin Berhasil');
    }

    public function PostEditNamaMesinPlant3PLT3(tb_data_mesin_plant_3 $mesin, Request $request)
    {
        $request->validate([
            'nama_mesin' => 'required|string|max:400|unique:tb_data_mesin_plant_3s,nama_mesin'
        ]);

        $mesin->update([
            'nama_mesin' => HtmlPurifierHelper::clean($request->input('nama_mesin'))
        ]);

        return back()->with('PostEditNamaMesinPlant3PLT3', 'Ubah Nama Mesin Berhasil');
    }

    public function PostEditKodeMesinPlant3PLNT3(tb_data_mesin_plant_3 $mesin, Request $request)
    {
        $request->validate([
            'kode_mesin' => 'nullable|string|max:300'
        ]);

        $mesin->update([
            'kode_mesin' => HtmlPurifierHelper::clean($request->input('kode_mesin'))
        ]);

        return back()->with('PostEditKodeMesinPlant3PLNT3', 'Ubah Kode Mesin Berhasil');
    }

    public function DataUserPPICPlant2(Request $request)
    {

        $datauserppicplant2 = User::where('role', 3)->where('departemen', 'PPIC')->where('plant', 'Plant 2');

        if ($request->has('search')) {

            $search = $request->input('search');

            $datauserppicplant2->where(function ($query) use ($search) {
                $query->where('nama_user', 'like', '%' . $search . '%')
                    ->orwhere('nik_karyawan', 'like', '%' . $search . '%')
                    ->orwhere('no_telepon', 'like', '%' . $search . '%')
                    ->orwhere('departemen', 'like', '%' . $search . '%')
                    ->orwhere('plant', 'like', '%' . $search . '%');
            });
        }

        $datauserppicplant2count = $datauserppicplant2->count();

        $datauserppcplant2 = $datauserppicplant2->paginate(10)->WithQueryString();

        return view('UserAdmin.Halaman_Data_User_PPIC_Plant_2', [
            'judul' => 'Halaman Data User PPIC Plant 2',
            'datauserppicplant2' => $datauserppcplant2,
            'datauserppicplant2count' => $datauserppicplant2count
        ]);
    }

    public function PostTambahDataUserPPICPlant2ADM(Request $request)
    {
        $time = Carbon::now('Asia/Jakarta');
        
        $request->validate([
            'nama_user' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/', // Hanya huruf dan spasi
            ],
            'nik_karyawan' => [
                'required',
                'numeric',
                'unique:users,nik_karyawan' // NIK karyawan harus berisi 16 digit
            ],
            'no_telepon' => [
                'required',
                'numeric',
                // 'digits_between:10,15', // Nomor telepon harus antara 10-15 digit
            ],
            'departemen' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/', // Hanya huruf dan spasi
            ],
            'plant' => [
                'required',
                'string',
                'max:255', // Hanya huruf dan spasi
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email', // Pastikan email unik di tabel users
            ],
            'image' => [
                'nullable',
                'file',
                'mimes:png,jpg,jpeg',
                'max:2048'
            ],
            'password' => [
                'required',
                'string',
                'min:8', // Minimal 8 karakter
                'regex:/[a-z]/', // Harus memiliki setidaknya satu huruf kecil
                'regex:/[A-Z]/', // Harus memiliki setidaknya satu huruf besar
                'regex:/[0-9]/', // Harus memiliki setidaknya satu angka
                'confirmed', // Pastikan ada password_confirmation yang cocok
            ],
        ]);

        if ($request->file('image')) {

            $foto = $request->file('image')->store('fotouser');
            
            $image = 'fotouser/' . $foto;
        } else {
            $image = 'default.jpg';
        }

        User::create([
            'url_unique' => Str::uuid(),
            'nama_user' => HtmlPurifierHelper::clean($request->input('nama_user')),
            'nik_karyawan' => HtmlPurifierHelper::clean($request->input('nik_karyawan')),
            'no_telepon' => HtmlPurifierHelper::clean($request->input('no_telepon')),
            'departemen' => HtmlPurifierHelper::clean($request->input('departemen')),
            'plant' => HtmlPurifierHelper::clean($request->input('plant')),
            'image' => $image,
            'email' => HtmlPurifierHelper::clean($request->input('email')),
            'password' => HtmlPurifierHelper::clean(Hash::make($request->input('password'))),
            'role' => 3,
            'email_verified_at' => $time->format('Y-m-d H:i:s')
        ]);

        return back()->with('PostTambahDataUserPPICPlant2ADM', 'Tambah Data User Berhasil');
    }

    // public function VerifyEmail(Request $request, $token)
    // {
    //     try {
    //         $decoded = JWT::decode($token, new Key(config('app.jwt_secret'), 'HS256'));

    //         $user = User::findOrFail($decoded->user_id);

    //         if ($user->hasVerifiedEmail()) {
    //             return redirect('/')->with('success', 'Email sudah diverifikasi sebelumnya.');
    //         }

    //         if ($user->markEmailAsVerified()) {
    //             event(new Verified($user));
    //         }

    //         auth()->login($user);
    //         $request->session()->regenerate();

    //         Log::info('User email verified', ['user_id' => $user->id]);

    //         if ($user->role === 1) {

    //             return redirect()->intended('/DashboardAdmin')->with('VerifyEmailAdmin', 'Selamat Datang');
    //         } elseif ($user->role === 2) {

    //             return redirect()->intended('/DashboardPPICPlant1')->with('VerifyEmailPPICPlant1', 'Verifikasi Email Berhasil, Selamat Datang.');
    //         } elseif ($user->role === 3) {

    //             return redirect()->intended('/DashboardPPICPlant2')->with('VerifyEmailPPICPlant2', 'Selamat Datang');
    //         } elseif ($user->role === 4) {

    //             return redirect()->intended('/DashboardPPICPlant3')->with('VerifyEmailPPICPlant3', 'Selamat Datang');
    //         }
    //     } catch (\Exception $e) {
    //         Log::warning('Invalid email verification attempt', ['error' => $e->getMessage()]);
    //         return redirect('/')->with('error', 'Link verifikasi tidak valid atau sudah kadaluarsa.');
    //     }
    // }

    public function ProfileUserAdmin()
    {
        return view('UserAdmin.Halaman_Profile_User_Admin', [
            'judul' => 'Halaman Profile User Admin'
        ]);
    }

    public function PostUbahFotoProfileUserAdmin(Request $request)
    {

        $request->validate([
            'image' => 'required|file|mimes:jpg,png,jpeg|max:2048'
        ]);

        $useradmin = auth()->user();

        if ($request->file('image')) {

            if ($useradmin->image) {

                Storage::delete($useradmin->image);
            }

            $image['fotouser'] = $request->file('image')->store('fotouser');
        }

        $useradmin->update([
            'image' => $image['fotouser']
        ]);

        return back();
    }

    public function PostGetFotoProfileUserAdmin(Request $request)
    {

        DB::beginTransaction();

        try {

            $useradmin = auth()->user();

            if ($useradmin->image) {

                Storage::delete($useradmin->image);
            }

            $uploadSettings = ["directory" => "fotouser", "disk" => "public", "maxFileSize" => 52428800, "allowedExtensions" => ['jpeg', 'jpg', 'png']];

            $ambilfoto = $request->image;

            $file_uploader_factory = new \OldRavian\FileUploader\Factories\FileUploaderFactory();
            $file_uploader = $file_uploader_factory->build("base64");
            $data = $file_uploader->upload($ambilfoto, $uploadSettings);
            $dataimage = $data['filename'];

            $useradmin->update([
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

    public function PostDeleteUserPPICPlant1ADM(User $data)
    {

        if ($data->image) {

            Storage::delete($data->image);
        }

        $data->delete();

        return back()->with('PostDeleteUserPPICPlant1ADM', 'Hapus Data User Berhasil');
    }

    public function PostDeleteDataUserPPICPlant2ADM(User $data)
    {

        if ($data->image) {

            Storage::delete($data->image);
        }

        $data->delete();

        return back()->with('PostDeleteDataUserPPICPlant2ADM', 'Hapus Data User Berhasil');
    }

    public function DataUserPPICPlant3(Request $request)
    {
        $datauserppicplant3 = User::where('role', 4)->where('departemen', 'PPIC')->where('plant', 'Plant 3');

        if ($request->has('search')) {

            $search = $request->input('search');

            $datauserppicplant3->where(function ($query) use ($search) {
                $query->where('nama_user', 'like', '%' . $search . '%')
                    ->orwhere('nik_karyawan', 'like', '%' . $search . '%')
                    ->orwhere('no_telepon', 'like', '%' . $search . '%')
                    ->orwhere('departemen', 'like', '%' . $search . '%')
                    ->orwhere('plant', 'like', '%' . $search . '%');
            });
        }

        $datauserppicplant3count = $datauserppicplant3->count();

        $datauserppcplant3 = $datauserppicplant3->paginate(10)->WithQueryString();

        return view('UserAdmin.Halaman_Data_User_PPIC_Plant_3', [
            'judul' => 'Halaman Data User PPIC Plant3',
            'datauserppicplant3' => $datauserppcplant3,
            'datauserppicplant3count' => $datauserppicplant3count
        ]);
    }

    public function PostDeleteDataUserPPICPlant3ADM(User $data)
    {

        if ($data->image) {

            Storage::delete($data->image);
        }

        $data->delete();

        return back()->with('PostDeleteDataUserPPICPlant3ADM', 'Hapus Data User Berhasil');
    }

    public function PostTambahDataUserPPICPlant3ADM(Request $request)
    {
        $time = Carbon::now('Asia/Jakarta');
        
        $request->validate([
            'nama_user' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/', // Hanya huruf dan spasi
            ],
            'nik_karyawan' => [
                'required',
                'numeric',
                'unique:users,nik_karyawan' // NIK karyawan harus berisi 16 digit
            ],
            'no_telepon' => [
                'required',
                'numeric',
                // 'digits_between:10,15', // Nomor telepon harus antara 10-15 digit
            ],
            'departemen' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/', // Hanya huruf dan spasi
            ],
            'plant' => [
                'required',
                'string',
                'max:255', // Hanya huruf dan spasi
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email', // Pastikan email unik di tabel users
            ],
            'image' => [
                'nullable',
                'file',
                'mimes:png,jpg,jpeg',
                'max:2048'
            ],
            'password' => [
                'required',
                'string',
                'min:8', // Minimal 8 karakter
                'regex:/[a-z]/', // Harus memiliki setidaknya satu huruf kecil
                'regex:/[A-Z]/', // Harus memiliki setidaknya satu huruf besar
                'regex:/[0-9]/', // Harus memiliki setidaknya satu angka
                'confirmed', // Pastikan ada password_confirmation yang cocok
            ],
        ]);

        if ($request->file('image')) {

            $foto = $request->file('image')->store('fotouser');
            
            $image = 'fotouser/' . $foto;
        } else {
            $image = 'default.jpg';
        }

        User::create([
            'url_unique' => Str::uuid(),
            'nama_user' => HtmlPurifierHelper::clean($request->input('nama_user')),
            'nik_karyawan' => HtmlPurifierHelper::clean($request->input('nik_karyawan')),
            'no_telepon' => HtmlPurifierHelper::clean($request->input('no_telepon')),
            'departemen' => HtmlPurifierHelper::clean($request->input('departemen')),
            'plant' => HtmlPurifierHelper::clean($request->input('plant')),
            'image' => $image,
            'email' => HtmlPurifierHelper::clean($request->input('email')),
            'password' => HtmlPurifierHelper::clean(Hash::make($request->input('password'))),
            'role' => 4,
            'email_verified_at' => $time->format('Y-m-d H:i:s')
        ]);

        return back()->with('PostTambahDataUserPPICPlant3ADM', 'Tambah Data User Berhasil');
    }

    public function DataUserAdmin(Request $request)
    {
        $datauseradmin = User::where('role', 1)->where('departemen', 'Admin')->where('plant', 'Plant 3');

        if ($request->has('search')) {

            $search = $request->input('search');

            $datauseradmin->where(function ($query) use ($search) {
                $query->where('nama_user', 'like', '%' . $search . '%')
                    ->orwhere('nik_karyawan', 'like', '%' . $search . '%')
                    ->orwhere('no_telepon', 'like', '%' . $search . '%')
                    ->orwhere('departemen', 'like', '%' . $search . '%')
                    ->orwhere('plant', 'like', '%' . $search . '%');
            });
        }

        $datauseradmcount = $datauseradmin->count();

        $datausradmin = $datauseradmin->paginate(10)->WithQueryString();

        return view('UserAdmin.Halaman_Data_User_Admin', [
            'judul' => 'Halaman Data User Admin',
            'datauseradmin' => $datausradmin,
            'datauseradmincount' => $datauseradmcount
        ]);
    }

    public function PostTambahDataUserAdminADM(Request $request)
    {
        
        $time = Carbon::now('Asia/Jakarta');
        
        $request->validate([
            'nama_user' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/', // Hanya huruf dan spasi
            ],
            'nik_karyawan' => [
                'required',
                'numeric',
                'unique:users,nik_karyawan' // NIK karyawan harus berisi 16 digit
            ],
            'no_telepon' => [
                'required',
                'numeric',
                // 'digits_between:10,15', // Nomor telepon harus antara 10-15 digit
            ],
            'departemen' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/', // Hanya huruf dan spasi
            ],
            'plant' => [
                'required',
                'string',
                'max:255', // Hanya huruf dan spasi
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email', // Pastikan email unik di tabel users
            ],
            'image' => [
                'nullable',
                'file',
                'mimes:png,jpg,jpeg',
                'max:2048'
            ],
            'password' => [
                'required',
                'string',
                'min:8', // Minimal 8 karakter
                'regex:/[a-z]/', // Harus memiliki setidaknya satu huruf kecil
                'regex:/[A-Z]/', // Harus memiliki setidaknya satu huruf besar
                'regex:/[0-9]/', // Harus memiliki setidaknya satu angka
                'confirmed', // Pastikan ada password_confirmation yang cocok
            ],
        ]);

        if ($request->file('image')) {

            $foto = $request->file('image')->store('fotouser');
            
            $image = 'fotouser/' . $foto;
        } else {
            $image = 'default.jpg';
        }

        User::create([
            'url_unique' => Str::uuid(),
            'nama_user' => HtmlPurifierHelper::clean($request->input('nama_user')),
            'nik_karyawan' => HtmlPurifierHelper::clean($request->input('nik_karyawan')),
            'no_telepon' => HtmlPurifierHelper::clean($request->input('no_telepon')),
            'departemen' => HtmlPurifierHelper::clean($request->input('departemen')),
            'plant' => HtmlPurifierHelper::clean($request->input('plant')),
            'image' => $image,
            'email' => HtmlPurifierHelper::clean($request->input('email')),
            'password' => HtmlPurifierHelper::clean(Hash::make($request->input('password'))),
            'role' => 1,
            'email_verified_at' => $time->format('Y-m-d H:i:s')
        ]);

        return back()->with('PostTambahDataUserAdminADM', 'Tambah Data User Berhasil');
    }

    public function PostDeleteDataUserAdminADM(User $data)
    {

        if ($data->image) {

            Storage::delete($data->image);
        }

        $data->delete();

        return back()->with('PostDeleteDataUserAdminADM', 'Hapus Data User Berhasil');
    }
}
