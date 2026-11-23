
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - SI-IDP Indramayu</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        body {
            background-color: #f1f5f9;
            font-family: Arial, sans-serif;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        .brand-panel {
            background: linear-gradient(135deg, #123b60, #1764a4);
            color: white;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-panel {
            padding: 50px;
        }

        .form-control {
            padding: 12px;
            border-radius: 8px;
        }

        .btn-login {
            background-color: #1764a4;
            color: white;
            padding: 12px;
            border-radius: 8px;
        }

        .btn-login:hover {
            background-color: #123b60;
            color: white;
        }

        @media (max-width: 767px) {
            .brand-panel,
            .form-panel {
                padding: 30px;
            }
        }
    </style>
</head>

<body>

<div class="login-wrapper">
    <div class="container py-4">

        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">

                <div class="card login-card shadow-lg">
                    <div class="row g-0">

                        <!-- Panel identitas aplikasi -->
                        <div class="col-md-6 brand-panel">

                            <p class="text-uppercase mb-2">
                                Pemerintah Kabupaten Indramayu
                            </p>

                            <h1 class="display-4 fw-bold">
                                SI-IDP
                            </h1>

                            <h5>
                                Sistem Informasi Individual
                                Development Plan
                            </h5>

                            <hr class="my-4">

                            <p>
                                Pengembangan kompetensi ASN
                                yang terencana, terarah,
                                dan berkelanjutan.
                            </p>

                            <small class="mt-4">
                                Badan Kepegawaian dan
                                Pengembangan Sumber Daya Manusia
                            </small>

                        </div>

                        <!-- Panel formulir login -->
                        <div class="col-md-6 form-panel bg-white">

                            <h3 class="fw-bold mb-2">
                                Selamat Datang
                            </h3>

                            <p class="text-muted mb-4">
                                Silakan masuk ke akun SI-IDP Anda.
                            </p>

                            <form action="{{ route('login.process') }}"
                                  method="POST">

                                @csrf

                                <!-- Email -->
                                <div class="mb-3">

                                    <label for="email"
                                           class="form-label">
                                        Alamat Email
                                    </label>

                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}"
                                        placeholder="Masukkan email"
                                        autocomplete="username"
                                        required
                                        autofocus>

                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <!-- Password -->
                                <div class="mb-4">

                                    <label for="password"
                                           class="form-label">
                                        Password
                                    </label>

                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Masukkan password"
                                        autocomplete="current-password"
                                        required>

                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <!-- Tombol login -->
                                <button type="submit"
                                        class="btn btn-login w-100">
                                    Masuk ke Sistem
                                </button>

                            </form>

                            <hr class="my-4">

                            <p class="text-center text-muted small mb-0">
                                &copy; {{ date('Y') }}
                                SI-IDP Kabupaten Indramayu
                            </p>

                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

</body>
</html>
