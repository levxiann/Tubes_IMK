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
                        <p>
                            <a href="{{url('/invoice')}}" target="_blank" class="float-start btn btn-secondary" style="display: inline-block"><span class="far fa-print" style="background: transparent"></span> Cetak Penjualan</a>
                        </p>
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
    
@endsection