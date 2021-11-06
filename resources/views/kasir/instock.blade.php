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
                <h1 class="m-0 text-dark">Data Produk Masuk</h1>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
    
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <!-- Alert -->
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Sukses!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="card mx-auto pull-right">
                    <div class="card-header">
                        <p>
                        <a href="{{url('/instock/print')}}" target="__blank" class="btn btn-secondary"><span class="far fa-print"></span> Cetak Produk Masuk</a>
                        </p>
                    </div>
                    <div class="card-body" id="stock">
                        <table class="table table-striped text-center">
                            <thead>
                              <tr>
                                <th scope="col">Kode Barang</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Tanggal Masuk</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($instocks as $instock)
                                    <tr>
                                        <th scope="row">{{$instock->stock_id}}</th>
                                        <td>{{$instock->stok->name}}</td>
                                        <td>{{$instock->stock}}</td>
                                        <td>{{date('d M Y', strtotime($instock->created_at))}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
          
          <!--Pagination-->
          <div class="d-flex mt-3 justify-content-end me-2">
            {!! $instocks->links() !!}
          </div>
          
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
    
@endsection