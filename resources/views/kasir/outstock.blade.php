@extends('kasir.layouts.main')

@section('content')
    {{-- Sidebar --}}
    @include('kasir.layouts.sidebar')
    {{-- End Sidebar --}}
    
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper mt-3" style="width: 100%">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col">
                <h1 class="m-0 text-dark">Data Penjualan</h1>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
    
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <!-- Alert -->
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                        <strong>{{session('status')}}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card mx-auto pull-right">
                    <div class="card-header">
                        <button type="button" class="btn btn-secondary ms-3 mb-2 mt-1" data-bs-toggle="modal" data-bs-target="#cetakKeluarModal">
                          <span class="far fa-print" style="background: transparent"></span> Cetak Penjualan
                        </button>
                    </div>
                    <div class="card-body" id="stock">
                        <table class="table table-striped text-center">
                            <thead>
                              <tr>
                                <th scope="col">Kode Penjualaan</th>
                                <th scope="col">Jumlah Produk</th>
                                <th scope="col">Tanggal Penjualan</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($outstocks as $outstock)
                                    <tr>
                                        <th scope="row">{{$outstock->id}}</th>
                                        <td>{{$outstock->receipts->count()}}</td>
                                        <td>{{date('d M Y', strtotime($outstock->updated_at))}}</td>
                                        <td>
                                            <form method="POST" action="{{url('outstock/delete/'.$outstock->id) }}" style="display: inline-block;">
                                              @csrf
                                              @method('DELETE')
                                              <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus Data?')"><span class="far fa-trash-alt"></span> Hapus</button>
                                            </form>
                                            <a href="{{url('/outstock/detail/'.$outstock->id)}}" class="btn btn-sm btn-primary" style="display: inline-block"><span class="far fa-info"></span> Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
          
          <!--Pagination-->
          <div class="d-flex mt-3 justify-content-end me-2">
            {!! $outstocks->links() !!}
          </div>
          
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
    
<!-- Modal -->
<div class="modal fade" id="cetakKeluarModal" tabindex="-1" aria-labelledby="cetakKeluarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cetakKeluarModalLabel">Cetak Data Penjualan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form action="{{url('/invoice')}}" method="POST" class="ms-3 text-photo" target="__blank">
              @csrf
              <div class="form-group mb-3">     
                  <label class="label" for="start">Mulai Tanggal : </label>
                  <input id="start" name="start" type="date" class="form-control @error('start') is-invalid @enderror" placeholder="Masukkan Tanggal Mulai" value="{{ old('start') }}" autocomplete="number" autofocus>
                  @error('start')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
              <div class="form-group mb-3">     
                  <label class="label" for="finish">Sampai Tanggal : </label>
                  <input id="finish" name="finish" type="date" class="form-control @error('finish') is-invalid @enderror" placeholder="Masukkan Tanggal Selesai" value="{{ old('finish') }}" autocomplete="number" autofocus>
                  @error('finish')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-secondary"><span class="far fa-print" style="background: transparent"></span> Cetak</button>
              </form>
      </div>
    </div>
  </div>
</div>
@endsection