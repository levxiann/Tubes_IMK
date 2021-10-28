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
    <div class="login-logo">
    <img class="brand-img" src="{{asset('/a1/asset/img/wallet.svg')}}" alt="" srcset="">
        <p class="brand-text mt-3">Toko <b>Serba Ada</b></p>
    </div>
    <div class="login-form">
        <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
            <div class="login-pass">
                <label for="email">
                    <i class="far fa-envelope"></i>
                    <input class="name @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{$email ?? old('email')}}" placeholder="Masukkan Email" autocomplete="name">  
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </label>
                <label for="password" class="mt-3">
                    <i class="far fa-lock"></i>
                    <input class="password @error('password') is-invalid @enderror" id="password" type="password" name="password" placeholder="Masukkan Password" autocomplete="new-password">  
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </label>
                <label for="password-confirm" class="mt-3">
                    <i class="far fa-lock"></i>
                    <input class="password @error('password') is-invalid @enderror" id="password-confirm" type="password" name="password_confirmation" placeholder="Konfirmasi Password" autocomplete="new-password">  
                </label>      
            </div>
            <div class="submit-button"> 
                <button type="submit" class="btn btn-login">Ganti Password</button>
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