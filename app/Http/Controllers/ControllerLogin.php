<?php

namespace App\Http\Controllers;

use App\Helpers\HtmlPurifierHelper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use \App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class ControllerLogin extends Controller
{
    public function LoginAdmin()
    {
        return view('Login.Halaman_Login_User', [
            'judul' => 'Halaman Login Admin'
        ]);
    }


    public function PostLoginUserAdmin(Request $request)
    {
        $request->validate([
            'nik_karyawan' => 'required|numeric',
            'password' => 'required|min:9',
            'g-recaptcha-response' => 'required|captcha'
        ]);


        if (Auth::attempt(['nik_karyawan' => $request->input('nik_karyawan'), 'password' => $request->input('password')])) {

            $user = Auth::user();

            if ($user->email_verified_at === null) {
                Auth::logout();
                return back()->with('PostLoginUserAdminn', 'Maaf akun anda belum terverifikasi email, silahkan verifikasi terlebih dahulu');
            }

            if ($user->role !== 1) {
                Auth::logout();
                return back()->with('PostLoginUserAdmin', 'Maaf Anda tidak memiliki akses masuk ke sistem atau portal ini');
            }

            if ($user->departemen !== 'Admin') {
                Auth::logout();
                return back()->with('PostLoginUserAdminGagal', 'Maaf Anda tidak memiliki akses masuk ke sistem atau portal ini');
            }

            if ($user->plant !== 'Plant 3') {
                Auth::logout();
                return back()->with('PostLoginUserAdminGagall', 'Maaf Anda tidak memiliki akses masuk ke sistem atau portal ini');
            }

            $request->session()->regenerate();

            return redirect()->intended('/DashboardAdmin')->with('PostLoginUserAdmin', 'Login Berhasil, Selamat Datang.');
        }

        return back()->withErrors([
            'email' => 'Akun Anda Tidak Terdaftar',
        ])->onlyInput('email');
    }

    public function LoginPPICPlant1()
    {
        return view('Login.Halaman_Login_PPIC_Plant_1', [
            'judul' => 'Halaman Login PPIC Plant 1'
        ]);
    }

    public function PostLoginUserPPICPlant1(Request $request)
    {
        $request->validate([
            'nik_karyawan' => 'required|numeric',
            'password' => 'required|min:9',
            'g-recaptcha-response' => 'required|captcha'
        ]);

        if (Auth::attempt(['nik_karyawan' => $request->input('nik_karyawan'), 'password' => $request->input('password')])) {

            $user = Auth::user();

            if ($user->email_verified_at === null) {
                Auth::logout();
                return back()->with('PostLoginUserPPICPlant', 'Maaf akun anda belum terverifikasi email, silahkan verifikasi terlebih dahulu');
            }

            if ($user->role !== 2) {

                Auth::logout();
                return back()->with('PostLoginUserPPICPlant1', 'Maaf Anda tidak memiliki akses masuk ke sistem atau portal ini');
            }

            if ($user->departemen !== 'PPIC') {

                Auth::logout();
                return back()->with('PostLoginUserPPICPlant11', 'Maaf Anda tidak memiliki akses masuk ke sistem atau portal ini');
            }

            if ($user->plant !== 'Plant 1') {
                Auth::logout();
                return back()->with('PostLoginUserPPICPlant11S', 'Maaf Anda tidak memiliki akses masuk ke sistem atau portal ini');
            }

            $request->session()->regenerate();

            return redirect()->intended('/DashboardPPICPlant1')->with('PostLoginUserPPICPlant111', 'Login Berhasil, Selamat Datang');
        }

        return back()->withErrors([
            'email' => 'Akun Tidak Terdaftar',
        ])->onlyInput('email', 'password');
    }

    public function LoginPPICPlant3()
    {
        return view('Login.Halaman_Login_PPIC_Plant_3', [
            'judul' => 'Halaman Login PPIC Plant 3'
        ]);
    }

    public function PostLoginUserPPICPlant3(Request $request)
    {
        $request->validate([
            'nik_karyawan' => 'required|numeric',
            'password' => 'required|min:9',
            'g-recaptcha-response' => 'required|captcha'
        ]);

        if (Auth::attempt(['nik_karyawan' => $request->input('nik_karyawan'), 'password' => $request->input('password')])) {

            $user = Auth::user();

            if ($user->email_verified_at === null) {
                Auth::logout();
                return back()->with('PostLoginUserPPICPlant3', 'Maaf akun anda belum terverifikasi email, silahkan verifikasi terlebih dahulu');
            }

            if ($user->role !== 4) {

                Auth::logout();
                return back()->with('PostLoginUserPPICPlant3Gagal', 'Maaf anda tidak memiliki akses untuk masuk ke portal ini');
            }

            if ($user->departemen !== 'PPIC') {

                Auth::logout();
                return back()->with('PostLoginUserPPICPlant3Gagall', 'Maaf anda tidak memiliki akses untuk masuk ke portal ini');
            }

            if ($user->plant !== 'Plant 3') {
                Auth::logout();
                return back()->with('PostLoginUserPPICPlant3Gagalll', 'Maaf anda tidak memiliki akses untuk masuk ke portal ini');
            }

            $request->session()->regenerate();

            return redirect()->intended('/DashboardPPICPlant3')->with('PostLoginUserPPICPlant3Berhasil', 'Login Berhasil, Selamat Datang');
        }

        return back()->withErrors([
            'email' => 'Akun Tidak Terdaftar',
        ])->onlyInput('email', 'password');
    }

    public function LoginPPICPlant2()
    {
        return view('Login.Halaman_Login_PPIC_Plant_2', [
            'judul' => 'Halaman Login PPIC Plant 2'
        ]);
    }


    public function PostLoginUserPPICPlant2(Request $request)
    {

        $request->validate([
            'nik_karyawan' => 'required|numeric',
            'password' => 'required|min:9',
            'g-recaptcha-response' => 'required|captcha'
        ]);

        if (Auth::attempt(['nik_karyawan' => $request->input('nik_karyawan'), 'password' => $request->input('password')])) {

            $user = Auth::user();

            if ($user->email_verified_at === null) {
                Auth::logout();
                return back()->with('PostLoginUserPPICPlant2', 'Maaf akun anda belum terverifikasi email, silahkan verifikasi terlebih dahulu');
            }

            if ($user->role !== 3) {

                Auth::logout();
                return back()->with('PostLoginUserPPICPlant2Gagal', 'Maaf anda tidak memiliki akses untuk masuk ke portal ini');
            }

            if ($user->departemen !== 'PPIC') {

                Auth::logout();
                return back()->with('PostLoginUserPPICPlant2Gagall', 'Maaf anda tidak memiliki akses untuk masuk ke portal ini');
            }

            if ($user->plant !== 'Plant 2') {
                Auth::logout();
                return back()->with('PostLoginUserPPICPlant2Gagalll', 'Maaf anda tidak memiliki akses untuk masuk ke portal ini');
            }

            $request->session()->regenerate();

            return redirect()->intended('/DashboardPPICPlant2')->with('PostLoginUserPPICPlant2Berhasil', 'Login Berhasil, Selamat Datang');
        }

        return back()->withErrors([
            'email' => 'Akun Tidak Terdaftar',
        ])->onlyInput('email', 'password');
    }


    public function Logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function LoginMarketing()
    {
        return view('Login.Halaman_Login_Marketing', [
            'judul' => 'Halaman Login Marketing'
        ]);
    }

    public function PostLoginMarketing(Request $request)
    {
        $request->validate([
            'nik_karyawan' => 'required|numeric',
            'password' => 'required|min:9',
            'g-recaptcha-response' => 'required|captcha'
        ]);

        if (Auth::attempt(['nik_karyawan' => $request->input('nik_karyawan'), 'password' => $request->input('password')])) {

            $user = Auth::user();

            if ($user->role !== 5) {

                Auth::logout();
                return back()->with('PostLoginMarketingGagal', 'Maaf anda tidak memiliki akses untuk masuk ke sistem ini');
            }

            if ($user->departemen !== 'Marketing') {

                Auth::logout();
                return back()->with('PostLoginMarketingGagall', 'Maaf anda tidak memiliki akses untuk masuk ke sistem ini');
            }

            $request->session()->regenerate();

            return redirect()->intended('/DashboardMarketing');
        }

        return back()->withErrors([
            'email' => 'Akun Tidak Terdaftar',
        ])->onlyInput('email', 'password');
    }

    public function ForgotPasswordAdmin()
    {
        return view('auth.Halaman_Forgot_Password_Admin', [
            'judul' => 'Halaman Forgot Password Admin'
        ]);
    }

    public function PostForgotPasswordAdmin(Request $request)
    {

        $request->validate([
            'nik_karyawan' => 'required|numeric'
        ]);


        $nik = HtmlPurifierHelper::clean($request->input('nik_karyawan'));

        $useradmin = User::where('role', 1)->where('departemen', 'Admin')->where('nik_karyawan', $nik)->first();

        if (!$useradmin) {

            return back()->with('PostForgotPasswordAdmin', 'Maaf akun anda tidak terdaftar sebagai admin');
        }

        if ($useradmin->email_verified_at === null) {
            return back()->with('PostForgotPasswordAdminn', 'Maaf akun anda belum diverifikasi, silahkan verifikasi terlebih dahulu');
        }

        $status = Password::sendResetLink(
            ['email' => $useradmin->email]
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __('Link Ubah Password Sudah Dikirimkan Ke Email Anda ' . $useradmin->email)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function ResettingPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));

                try {

                    DB::table('password_reset_tokens')->where('email', $user->email)->delete();
                } catch (\Exception $e) {
                    Log::error('Failed to delete password reset token: ' . $e->getMessage());
                }
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }


    public function LogoutUserPPICPlant1(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function LogoutPPICPlant2(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function LogoutPPICPlant3(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function ForgotPasswordPPICPlant1()
    {
        return view('auth.Halaman_Forgot_Password_PPIC_Plant_1', [
            'judul' => 'Halaman Forgot Password PPIC Plant 1'
        ]);
    }

    public function PostForgotPasswordPPICPlant1(Request $request)
    {

        $request->validate([
            'nik_karyawan' => 'required|numeric'
        ]);

        $nik = HtmlPurifierHelper::clean($request->input('nik_karyawan'));


        $userppicplant1 = User::where('nik_karyawan', $nik)->first();

        if (!$userppicplant1) {

            return back()->with('PostForgotPasswordPPICPlant11', 'Maaf akun anda tidak terdaftar');
        }

        if ($userppicplant1->email_verified_at === null) {

            return back()->with('PostForgotPasswordPPICPlant1Gagal', 'Maaf akun anda belum diverifikasi, silahkan verifikasi email terlebih dahulu');
        }

        if ($userppicplant1->departemen !== 'PPIC') {

            return back()->with('PostForgotPasswordPPICPlant1Gagall', 'Maaf Akun Anda Tidak Terdaftar Sebagai PPIC');
        }

        if ($userppicplant1->role !== 2) {

            return back()->with('PostForgotPasswordPPICPlant1Gagalll', 'Maaf Akun Anda Tidak Terdaftar Sebagai PPIC Plant 1');
        }

        $status = Password::sendResetLink(
            ['email' => $userppicplant1->email]
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['statusforgotppcplant1' => __('Link Ubah Password Sudah Dikirimkan Ke Email Anda ' . $userppicplant1->email)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function ForgotPasswordPPICPlant2()
    {
        return view('auth.Halaman_Forgot_Password_PPIC_Plant_2', [
            'judul' => 'Halaman Forgot Password PPIC Plant 2'
        ]);
    }

    public function PostForgotPasswordPPICPlant2(Request $request)
    {

        $request->validate([
            'nik_karyawan' => 'required|numeric'
        ]);

        $nik = HtmlPurifierHelper::clean($request->input('nik_karyawan'));

        $userppicplant2 = User::where('nik_karyawan', $nik)->first();

        if (!$userppicplant2) {

            return back()->with('PostForgotPasswordPPICPlant22', 'Maaf akun anda tidak terdaftar');
        }

        if ($userppicplant2->email_verified_at === null) {

            return back()->with('PostForgotPasswordPPICPlant2Gagal', 'Maaf akun anda belum diverifikasi, silahkan verifikasi email terlebih dahulu');
        }

        if ($userppicplant2->departemen !== 'PPIC') {

            return back()->with('PostForgotPasswordPPICPlant2Gagall', 'Maaf akun anda tidak terdaftar sebagai PPIC');
        }

        if ($userppicplant2->role !== 3) {

            return back()->with('PostForgotPasswordPPICPlant2Gagalll', 'Maaf akun anda tidak terdaftar sebagai PPIC Plant 2');
        }

        $status = Password::sendResetLink(
            ['email' => $userppicplant2->email]
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['statusforgotppcplant2' => __('Link Ubah Password Sudah Dikirimkan Ke Email Anda ' . $userppicplant2->email)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function ForgotPasswordPPICPlant3()
    {

        return view('auth.Halaman_Forgot_Password_PPIC_Plant_3', [
            'judul' => 'Halaman Forgot Password PPIC Plant 3'
        ]);
    }

    public function PostForgotPasswordPPICPlant3(Request $request)
    {

        $request->validate([
            'nik_karyawan' => 'required|numeric'
        ]);

        $nik_karyawan = HtmlPurifierHelper::clean($request->input('nik_karyawan'));

        $userppicplant3 = User::where('nik_karyawan', $nik_karyawan)->first();

        if (!$userppicplant3) {

            return back()->with('PostForgotPasswordPPICPlant33', 'Maaf akun anda tidak terdaftar');
        }

        if ($userppicplant3->email_verified_at === null) {

            return back()->with('PostForgotPasswordPPICPlant3Gagall', 'Maaf akun anda belum terverifikasi, siahkan verifikasi email terlebih dahulu');
        }

        if ($userppicplant3->departemen !== 'PPIC') {

            return back()->with('PostForgotPasswordPPICPlant3Gagalll', 'Maaf akun anda tidak terdaftar sebagai PPIC');
        }

        if ($userppicplant3->role !== 4) {

            return back()->with('PostForgotPasswordPPICPlant3Gagallll', 'Maaf akun anda tidak terdaftar sebagai PPIC Plant 3');
        }

        $status = Password::sendResetLink(
            ['email' => $userppicplant3->email]
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['statusforgotppcplant3' => __('Link Ubah Password Sudah Dikirimkan Ke Email Anda ' . $userppicplant3->email)])
            : back()->withErrors(['email' => __($status)]);
    }
}
