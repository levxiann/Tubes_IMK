@extends('account.layouts.main')

@section('content')
<nav class="navbar fixed-top">
    <div class="container-fluid">
        <div class="mode ms-auto">
            <input type="checkbox" class="checkbox" id="chk" />
            <label class="label" for="chk">
                <i class="fas fa-moon"></i>
                <i class="fas fa-sun"></i>
                <div class="ball"></div>
            </label>
        </div>
    </div>
</nav>

<div class="login text-center">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="login-logo">
    <img class="brand-img" src="{{asset('/a1/asset/img/wallet.svg')}}" alt="" srcset="">
        <p class="brand-text mt-3">Toko <b>Serba Ada</b></p>
    </div>
    <div class="login-form">
        <form method="POST" action="{{ route('login') }}">
        @csrf
            <div class="login-pass">
                <label for="username">
                    <i class="far fa-user"></i>
                    <input class="name @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{old('name')}}" placeholder="Masukkan Nama" autocomplete="name">  
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>nama/password salah</strong>
                        </span>
                    @enderror
                </label>
                <label for="password" class="mt-3">
                    <i class="far fa-lock"></i>
                    <input class="password @error('password') is-invalid @enderror" id="password" type="password" name="password" placeholder="Masukkan Password" autocomplete="current-password">  
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </label>      
            </div>
            <div class="submit-button">
                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        Ganti password?
                    </a>
                @endif     
                <button type="submit" class="btn btn-login">Login</button>
            </div>
        </form>
    </div>
</div>

<nav class="footer fixed-bottom footer-light text-center pt-2 pb-2">
    <span class="footer-text">
        Copyright &copy; 2021 Kelompok IMK
    </span>
</nav>
@endsection