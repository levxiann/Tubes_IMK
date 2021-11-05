@extends('account.layouts.main')

@section('content')
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
@endsection