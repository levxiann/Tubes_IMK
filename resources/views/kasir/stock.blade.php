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
                <h1 class="m-0 text-dark">Data Produk</h1>
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
                  <a href="{{url('/stock/newproduct')}}" class="btn btn-primary"><span class="far fa-plus"></span> Tambah Produk</a>
                  <a href="{{url('/stock/print')}}" target="__blank" class="btn btn-secondary"><span class="far fa-print"></span> Cetak Produk</a>
                </p>
                <!--Searching-->
                <form action="{{url('/stock')}}" method="GET" role="search">
                  <div class="input-group">
                      <span class="input-group-btn mr-5 mt-1 me-3">
                          <button class="btn btn-info" type="submit" title="Search projects">
                              <span class="fas fa-search"></span>
                          </button>
                      </span>
                      <input type="text" class="form-control mr-2" name="term" placeholder="Cari..." id="term">
                      <a href="{{url('/stock')}}" class=" mt-1 ms-2">
                          <span class="input-group-btn">
                              <button class="btn btn-danger" type="button" title="Refresh page">
                                  <span class="fas fa-sync-alt"></span>
                              </button>
                          </span>
                      </a>
                  </div>
              </form>
              </div>
              <div class="card-body" id="stock">
                <table class="table w-100 table-bordered table-hover text-center table-striped" id="stok">
                  <thead style="text-align: center">
                    <tr class="align-middle">
                      <th>ID</th>
                      <th>Gambar</th>
                      <th>Nama</th>
                      <th>Deskripsi</th>
                      <th>Harga</th>
                      <th>Harga Grosir</th>
                      <th>Satuan Grosir</th>
                      <th>Stok</th>
                      <th colspan="5">Action</th>
                    </tr>
                  </thead>
                  <tbody style="vertical-align: middle">
                    @foreach($stocks as $stock)
                    <tr>
                        <td>{{$stock->id}}</td>
                        <td><img src="{{asset('/images/'.$stock->image)}}" height="100" width="100"></td>
                        <td>{{$stock->name}}</td>
                        <td>{{$stock->description}}</td>
                        <td>
                          @if ($stock->discount != NULL)
                            <del>Rp {{number_format($stock->price, 2, ',', '.')}}</del> <b class="text-danger">{{$stock->discount->percentage}}%</b> => Rp {{number_format(((100 - $stock->discount->percentage) * $stock->price)/100, 2, ',', '.')}}
                          @else
                            Rp {{number_format($stock->price, 2, ',', '.')}}
                          @endif
                        </td>
                        <td>
                          @if ($stock->wholesale_price != NULL)
                            Rp {{$stock->wholesale_price}}
                          @endif
                        </td>
                        <td>
                          @if ($stock->wholesale_quantity != NULL)
                            {{$stock->wholesale_quantity}}
                          @endif
                        </td>
                        <td>{{$stock->stock}}</td>
                        <td><a href="{{url('stock/addstock/'.$stock->id) }}" class="btn btn-sm btn-flat btn-primary"><span class="far fa-plus"></span> Tambah Stok</a></td>
                        <td><a href="{{url('stock/stockrusak/'.$stock->id) }}" class="btn btn-sm btn-flat btn-warning"><span class="far fa-minus"></span> Stok Rusak</a></td>
                        <td><a href="{{url('stock/editproduct/'.$stock->id) }}" class="btn btn-sm btn-flat btn-success"><span class="far fa-edit"></span> Edit</a></td>
                        <td>
                        @if ($stock->receipt->count() < 1)
                        <form method="POST" action="{{url('stock/'.$stock->id) }}" style="display: inline-block;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus Data?')"><span class="far fa-trash-alt"></span> Hapus</button>
                        </form>
                        @endif
                        </td>
                        <td>
                          @if ($stock->status == 1)
                          <form method="POST" action="{{url('stock/close/'.$stock->id) }}" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger"><span class="far fa-lock"></span> Matikan</button>
                          </form>
                          @else
                          <form method="POST" action="{{url('stock/open/'.$stock->id) }}" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success"><span class="far fa-lock-open"></span> Aktifkan</button>
                          </form>
                          @endif
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
            {!! $stocks->links() !!}
          </div>
          
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
    
@endsection