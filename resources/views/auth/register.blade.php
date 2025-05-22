<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register | CariWisataID</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body, html {
            height: 100%;
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-container {
            min-height: 100vh;
        }
        .left-side {
            background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80') no-repeat center center;
            background-size: cover;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            border-radius: 0 0.5rem 0.5rem 0;
            box-shadow: inset 0 0 0 1000px rgba(0, 0, 0, 0.45);
        }
        .left-side h2 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            text-shadow: 0 2px 6px rgba(0,0,0,0.7);
        }
        .left-side p {
            font-size: 1.1rem;
            line-height: 1.5;
            max-width: 400px;
            text-shadow: 0 1px 4px rgba(0,0,0,0.6);
        }
        .right-side {
            background: white;
            padding: 40px 30px;
            border-radius: 0.5rem 0 0 0.5rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        @media (max-width: 767.98px) {
            .left-side {
                border-radius: 0.5rem 0.5rem 0 0;
                min-height: 230px;
                text-align: center;
                box-shadow: inset 0 0 0 1000px rgba(0,0,0,0.55);
            }
            .right-side {
                border-radius: 0 0 0.5rem 0.5rem;
                padding: 30px 20px;
            }
        }
        .form-title {
            text-align: center;
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            color: #343a40;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container register-container d-flex align-items-center justify-content-center">
        <div class="row w-100 shadow-lg rounded" style="max-width: 900px;">
            <div class="col-md-6 d-none d-md-flex left-side flex-column">
                
            </div>
            <div class="col-md-6 right-side">
                <h2 class="form-title">Daftar Akun</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nama Lengkap" />
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                            name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Alamat Email" />
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                            name="password" required autocomplete="new-password" placeholder="Password" />
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input id="password-confirm" type="password" class="form-control" 
                            name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi Password" />
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                </form>

                <p class="text-center mt-3">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

