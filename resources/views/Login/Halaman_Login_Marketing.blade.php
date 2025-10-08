<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('storage/image/logo_cat_terbaru.png') }}" type="image/x-icon">
    <title>{{ $judul }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {
        background-color: #ff4500; /* Warna latar belakang sesuai dengan gambar */
        color: #fff;
        text-align: center;
        font-family: Arial, sans-serif;
      }

      .login-container {
        background-color: #d27b67; /* Warna latar belakang panel login */
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        margin: 0 auto;
      }

      .login-container h1 {
        font-size: 1.5rem;
        margin-bottom: 20px;
        font-weight: bold;
      }

      .form-control {
        background-color: #fff;
        border: none;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
      }

      .btn-login {
        background-color: #007bff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        color: #fff;
        font-weight: bold;
        margin-top: 10px;
        width: 100%;
      }

      .btn-login:hover {
        background-color: #0056b3;
      }

      .form-check {
        text-align: left;
        margin-left: 20px;
      }

      .form-check-input {
        margin-right: 10px;
      }

      .form-check-label {
        font-weight: bold;
      }

      footer {
        font-size: 0.75rem;
        color: #fff;
        margin-top: 20px;
      }

      .logo {
        width: 300px;
        height: auto;
        margin-bottom: 10px;
      }
    </style>
  </head>
  <body>

    <div class="container">
      <h1 class="mt-5">PORTAL MANAGEMENT SYSTEM</h1>

      <div class="login-container mt-4 p-4">
        @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
        @endif

        @if(session('PostLoginMarketingGagal'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>{{ session('PostLoginMarketingGagal') }}</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('PostLoginMarketingGagall'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>{{ session('PostLoginMarketingGagall') }}</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <img src="{{ asset('storage/logo/logo_pt.png') }}" alt="Logo Perusahaan" class="logo"> <!-- Ganti dengan URL gambar logo -->
        <h1>MANAGEMENT SYSTEM</h1>
        <form action="/postloginusermarketing" method="post">
          @csrf
          @method('POST')

          <input type="text" class="form-control" placeholder="Masukkan NIK Karyawan" required name="nik_karyawan">
          <input type="password" class="form-control" placeholder="Masukkan Password Anda" required name="password">

          <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"></div>

          <button type="submit" class="btn btn-login">LOGIN</button>
        </form>
      </div>

      <footer>
        Copyright © PT. Cemerlang Abadi Tekindo {{ date('Y') }}
      </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </body>
</html>
