<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="icon" href="{{ asset('storage/image/logo_cat_terbaru.png') }}" type="image/x-icon">
    <title>{{ $judul }}</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400&display=swap');

/** Variables - colors **/
:root {
    /* Light */
    --color-light-50: #f8fafc;

    /* Dark */
    --color-dark-50: #797984;
    --color-dark-100: #312d37;
    --color-dark-900: #000;

    /* Purple */
    --color-purple-50: #7c3aed;
    --color-purple-100: #a855f7;
    --color-purple-200: #bf46ef;

    /* Gradient */
    --color-gradient: linear-gradient(90deg, var(--color-purple-50), var(--color-purple-100), var(--color-purple-200));
}

/* General */
* {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

#container {
    height: 100vh;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background: var(--color-gradient);
}

#login_form {
    display: flex;
    flex-direction: column;
    height: fit-content;
    background-color: var(--color-light-50);
    padding: 30px 40px;
    border-radius: 8px;
    gap: 30px;
    box-shadow: 5px 5px 8px rgba(0, 0, 0, 0.336);
    animation: dark-to-light-background 0.3s ease-in-out;
}

/* Form Header */
#form_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

#form_header h1 {
    font-size: 40px;
    position: relative;
}

#form_header h1::before {
    position: absolute;
    content: '';
    width: 40%;
    height: 3px;
    background-color: var(--color-purple-50);
    bottom: 10px;
    border-radius: 5px;
}

#mode_icon {
    cursor: pointer;
    font-size: 20px;
}

/* Social Media */
#social_media {
    display: flex;
    justify-content: space-around;
}

#social_media img {
    width: 35px;
}

#social_media img:hover {
    transform: scale(1.2);
}

/* Inputs */
#inputs {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 20px;
}

.input-box>label {
    font-size: 14px;
    color: var(--color-dark-50);
}

.input-field {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 3px;
    border-bottom: 1px solid var(--color-purple-50);
    cursor: text;
}

.input-field i {
    font-size: 18px;
    cursor: text;
    color: var(--color-dark-900);
} 

.input-field input {
    border: none;
    width: 260px;
    background-color: transparent;
    font-size: 18px;
    padding: 0px 5px;
}

.input-field input:focus {
    outline: none;
}

/* Forgot password */
#forgot_password a {
    text-decoration: none;
    color: var(--color-dark-50);
    font-size: 12px;
}

#forgot_password a:hover {
    color: var(--color-purple-50);
}

/* Login Button */
#login_button {
    border: none;
    background: var(--color-gradient);
    padding: 7px;
    border-radius: 3px;
    color: var(--color-light-50);
    font-weight: bold;
    font-size: 18px;
    cursor: pointer;
}

#login_button:hover {
    transform: scale(1.05);
}

/* Dark Mode */
.dark#login_form {
    color: var(--color-light-50);
    background-color: var(--color-dark-100);
    animation: light-to-dark-background 0.3s ease-in-out;
}

.dark#login_form .input-field input,
.dark#login_form .input-field i {
    color: var(--color-light-50);
}

@keyframes dark-to-light-background {
    0% {
        background-color:var(--color-dark-100);
    }
    100.0% {
        background-color:var(--color-light-50);
    }
}

@keyframes light-to-dark-background {
    0% {
        background-color:var(--color-light-50);
    }
    100.0% {
        background-color:var(--color-dark-100); 
    }
}

        /* Fullscreen overlay */
#preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #ffffff; /* Sesuaikan warna latar preloader */
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 1;
    transition: opacity 0.3s ease; /* Tambahkan transisi untuk efek mulus */
}

/* Animasi gambar preloader */
.preloader-animation img {
    width: 120px; /* Sesuaikan ukuran gambar */
    height: auto;
    animation: pulse 1.5s infinite ease-in-out; /* Animasi berdenyut */
}

/* Keyframe untuk animasi berdenyut */
@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.7; }
    100% { transform: scale(1); opacity: 1; }
}
    </style>
</head>
<body>   
    <main id="container">
        <form id="login_form" action="/postloginuserppicplant3" method="post">
          @csrf
          @method('POST')
            <!-- FORM HEADER -->
            <div id="form_header">
                <h1>Login</h1>
                <i id="mode_icon" class="fa-solid fa-moon"></i>
            </div>

            @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
        @endif

        @if(session('PostLoginUserPPICPlant3Gagal'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session('PostLoginUserPPICPlant3Gagal') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('PostLoginUserPPICPlant3Gagall'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session('PostLoginUserPPICPlant3Gagal') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('PostLoginUserPPICPlant3Gagalll'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session('PostLoginUserPPICPlant3Gagalll') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('PostLoginUserPPICPlant3'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session('PostLoginUserPPICPlant3') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
            <!-- INPUTS -->
            <div id="inputs">
                <!-- Preloader Section -->
                <div id="preloader">
                    <div class="preloader-animation">
                        <img src="{{ asset('storage/image/logo_cat_terbaru.png') }}" alt="Preloader Image">
                    </div>
                </div>

                <!-- NAME -->
                <div class="input-box">
                    <label for="nik">
                        NIK Karyawan
                        <div class="input-field">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" id="nik" placeholder="Masukkan NIK Karyawan" name="nik_karyawan">
                        </div>
                    </label>
                </div>
                
                <!-- PASSWORD -->
                <div class="input-box">
                    <label for="password">
                        Password
                        <div class="input-field">
                            <i class="fa-solid fa-key"></i>
                            <input type="password" id="password" placeholder="Masukkan Password Anda" name="password">
                        </div>
                    </label>

                    <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"></div>
                    
                    <!-- FORGOT PASSWORD -->
                    <div id="forgot_password">
                        <a href="/forgotpasswordppicplant3">
                            Forgot your password?
                        </a>
                    </div>
                </div>
            </div>

            <!-- LOGIN BUTTON -->
            <button type="submit" id="login_button">
                Login
            </button>
        </form>
    </main>

    <!-- JAVASCRIPT -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        const mode = document.getElementById('mode_icon');

mode.addEventListener('click', () => {
    const form = document.getElementById('login_form');

    if(mode.classList.contains('fa-moon')) {
        mode.classList.remove('fa-moon');
        mode.classList.add('fa-sun');

        form.classList.add('dark');
        return ;
    }
    
    mode.classList.remove('fa-sun');
    mode.classList.add('fa-moon');

    form.classList.remove('dark');
});
    </script>
    
    <script>
       document.addEventListener("DOMContentLoaded", function () {
    const preloader = document.getElementById("preloader");

    // Fungsi untuk menampilkan preloader
    function showPreloader() {
        preloader.style.display = "flex"; // Menampilkan preloader
        preloader.style.opacity = "1";
    }

    // Fungsi untuk menyembunyikan preloader setelah halaman dimuat
    function hidePreloader() {
        setTimeout(() => {
            preloader.style.opacity = "0";
            setTimeout(() => {
                preloader.style.display = "none";
            }, 600); // Durasi efek menghilang lebih lama (600 ms sesuai dengan transisi di CSS)
        }, 1000); // Durasi delay sebelum mulai menghilang (1 detik)
    }

    // Menyembunyikan preloader setelah halaman selesai dimuat
    hidePreloader();

    // Menampilkan preloader saat link diklik
    document.querySelectorAll("a").forEach(link => {
        link.addEventListener("click", function (event) {
            // Cek apakah link menuju halaman yang sama
            if (!link.hasAttribute("target") && link.getAttribute("href") && link.getAttribute("href").charAt(0) !== "#") {
                showPreloader();
            }
        });
    });

    // Jika halaman menggunakan form submit, tampilkan preloader saat form disubmit
    document.querySelectorAll("form").forEach(form => {
        form.addEventListener("submit", function () {
            showPreloader();
        });
    });
});
    </script>
</body>
</html>