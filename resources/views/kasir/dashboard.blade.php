@extends('kasir.layouts.main')

@section('content')
    {{-- Sidebar --}}
    @include('kasir.layouts.sidebar')
    {{-- End Sidebar --}}

    <div class="container ms-3 mt-3">
        <div class="card">
            <div class="card-header">
              Welcome
            </div>
            <div class="card-body">
              <h5 class="card-title">Halo, <b>{{Auth::user()->name}}</b></h5>
              <p class="card-text">Ini Halaman Dashboard</p>
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </div>
</main>
@endsection