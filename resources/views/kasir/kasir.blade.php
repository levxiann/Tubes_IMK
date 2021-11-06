@extends('kasir.layouts.main')

@section('content')
    {{-- Sidebar --}}
    @include('kasir.layouts.sidebar')
    {{-- End Sidebar --}}
      
    <div class="container ms-3 mt-3">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                <strong>{{session('status')}}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @error('name')
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                <strong>{{$message}}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @enderror
        @error('email')
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                <strong>{{$message}}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @enderror
        @error('password')
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                <strong>{{$message}}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @enderror
        <div class="row mt-3">
            <h2 class="card-header mb-4">Akun</h2>
            <div class="d-flex">
                <button type="button" class="btn btn-success tambahKasir" data-bs-toggle="modal" data-bs-target="#tambahKasirModal" style="display: inline-block">
                    <span class="far fa-plus" style="background: transparent"></span> Tambah Kasir
                </button>
            </div>
            <form class="d-flex mt-3" action="{{url('/kasir/search')}}" method="GET">
                <input id="keyword" class="form-control me-2 mb-2 mr-2" type="search" placeholder="Cari Kasir" name="keyword" aria-label="Search" style="background-color : lightblue" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>">
                <button class="btn btn-outline-success btn-sm" type="submit">Search</button>
            </form>
        </div>
        <div id="stock" class="row mt-3">
            <ul class="list-group mt-2">
                @foreach ($kasirs as $kasir)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="col-5 justify-content-start">
                        {{$kasir->name}} - {{$kasir->email}}
                        @if ($kasir->level == Auth::user()->level)
                            <i class="text-primary">(saya)</i>
                        @elseif ($kasir->level != Auth::user()->level && $kasir->status == 0)
                            <i class="text-danger">(tidak aktif)</i>
                        @elseif ($kasir->level != Auth::user()->level && $kasir->status == 1)
                            <i class="text-success">(aktif)</i>
                        @endif
                    </div>
                    <div class="col-5">
                        @if ($kasir->level != 1 && $kasir->status == 0)
                            <form action="{{url('/kasir/activate/'.$kasir->id)}}" method="POST" class="ms-2 text-photo float-end" style="display: inline-block">
                                @csrf
                                @method('patch')
                                    <button type="submit" class="btn btn-success"><span class="far fa-lock-open" style="background: transparent"></span> Aktifkan</button>
                            </form>
                        @elseif ($kasir->level != 1 && $kasir->status == 1)
                        <form action="{{url('/kasir/inactivate/'.$kasir->id)}}" method="POST" class="ms-2 text-photo float-end" style="display: inline-block">
                            @csrf
                            @method('patch')
                                <button type="submit" class="btn btn-secondary"><span class="far fa-lock" style="background: transparent"></span> Non Aktifkan</button>
                        </form>
                        @endif
                        <button type="button" class="btn btn-warning ms-3 editKasir float-end" data-bs-toggle="modal" data-bs-target="#editKasirModal" data-id="{{$kasir->id}}" style="display: inline-block">
                            <span class="far fa-edit" style="background: transparent"></span> Edit
                        </button>
                        @if ($kasir->level != 1 && $kasir->payments->count() < 1)
                            <form action="{{url('/kasir/delete/'.$kasir->id)}}" method="POST" class="ms-2 text-photo float-end" onsubmit="return confirm('Anda Yakin?')" style="display: inline-block">
                                @csrf
                                @method('delete')
                                    <button type="submit" class="btn btn-danger"><span class="far fa-trash" style="background: transparent"></span> Hapus</button>
                            </form>
                        @endif
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="editKasirModal" tabindex="-1" aria-labelledby="editKasirModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editKasirModalLabel">Edit Kasir</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{url('/kasir/update')}}" method="POST" class="ms-3 text-photo" onsubmit="return confirm('Anda Yakin?')">
                @csrf
                @method('patch')
                <input type="hidden" name="id" id="idKasirSubmit" value="">
                <div class="form-group mb-3">     
                    <label class="label" for="name">Nama</label>
                    <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan Nama" value="" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">     
                    <label class="label" for="email">Email</label>
                    <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email" value="" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">     
                    <label class="label" for="password">Ganti Password</label>
                    <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Password (Optional)" value="" autofocus>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-warning"><span class="far fa-edit" style="background: transparent"></span> Edit</button>
                </form>
        </div>
      </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="tambahKasirModal" tabindex="-1" aria-labelledby="tambahKasirModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tambahKasirModalLabel">Tambah Kasir</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{url('/kasir/store')}}" method="POST" class="ms-3 text-photo">
                @csrf
                <input type="hidden" name="id" id="idKasirSubmit" value="">
                <div class="form-group mb-3">     
                    <label class="label" for="name">Nama</label>
                    <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan Nama" value="{{old('name')}}" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">     
                    <label class="label" for="email">Email</label>
                    <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email" value="{{old('email')}}" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">     
                    <label class="label" for="password">Password</label>
                    <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Password" value="" autofocus>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success"><span class="far fa-plus" style="background: transparent"></span> Tambah</button>
                </form>
        </div>
      </div>
    </div>
</div>

<script src="{{asset('/js/jquery.js')}}"></script>
<script>
$('.editKasir').on('click',function(e){
    let id=$(this).data('id');
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    jQuery.ajax({
        url: "{{ url('/kasir/getKasir') }}",
        method: 'post',
        data: {'id': id},
        dataType:'json',
        success: function(result){
            $('#idKasirSubmit').val(result.id);
            $('#name').val(result.name);
            $('#email').val(result.email);
        }
    });
});
</script>
@endsection