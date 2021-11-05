@extends('account.layouts.main')

@section('content')
<div class="forpass text-center">
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
        <form method="POST" action="{{ route('password.email') }}">
        @csrf
            <div class="login-pass">
                <label for="email">
                    <i class="far fa-envelope"></i>
                    <input class="name @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{old('email')}}" placeholder="Masukkan Email" autocomplete="email">  
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </label>    
            </div>
            <div class="submit-button">
                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('login') }}">
                        Login
                    </a><br>
                @endif     
                <button type="submit" class="btn btn-login">Kirim E-mail</button>
            </div>
        </form>
    </div>
</div>
@endsection