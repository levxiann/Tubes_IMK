@extends('kasir.layouts.main')

@section('content')
    {{-- Sidebar --}}
    @include('kasir.layouts.sidebar')
    {{-- End Sidebar --}}
    
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="width: 100%">
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
                  <a href="{{url('/stock/newproduct')}}" class="btn btn-primary">Tambah Produk</a>
                </p>
                <!--Searching-->
                <form action="{{url('/stock')}}" method="GET" role="search">
                  <div class="input-group">
                      <span class="input-group-btn mr-5 mt-1">
                          <button class="btn btn-info" type="submit" title="Search projects">
                              <span class="fas fa-search"></span>
                          </button>
                      </span>
                      <input type="text" class="form-control mr-2" name="term" placeholder="Cari..." id="term">
                      <a href="{{url('/stock')}}" class=" mt-1">
                          <span class="input-group-btn">
                              <button class="btn btn-danger" type="button" title="Refresh page">
                                  <span class="fas fa-sync-alt"></span>
                              </button>
                          </span>
                      </a>
                  </div>
              </form>
              </div>
              <div class="card-body">
                <table class="table w-100 table-bordered table-hover" id="stok">
                  <thead style="text-align: center">
                    <tr>
                      <th>ID</th>
                      <th>Gambar</th>
                      <th>Nama</th>
                      <th>Deskripsi</th>
                      <th>Harga</th>
                      <th>Harga Grosir</th>
                      <th>Satuan Grosir</th>
                      <th>Stok</th>
                      <th colspan="4">Action</th>
                    </tr>
                  </thead>
                  <tbody style="vertical-align: middle">
                    @foreach($stocks as $stock)
                    <tr>
                        <td>{{$stock->id}}</td>
                        <td><img src="{{asset('storage/images/'.$stock->image)}}" height="100" width="100"></td>
                        <td>{{$stock->name}}</td>
                        <td>{{$stock->description}}</td>
                        <td>Rp{{$stock->price}}</td>
                        <td>Rp{{$stock->wholesale_price}}</td>
                        <td>{{$stock->wholesale_quantity}}</td>
                        <td>{{$stock->stock}}</td>
                        <td><a href="{{url('stock/addstock/'.$stock->id) }}" class="btn btn-sm btn-flat btn-primary">Tambah Stok</a></td>
                        <td><a href="{{url('stock/stockrusak/'.$stock->id) }}" class="btn btn-sm btn-flat btn-warning">Stok Rusak</a></td>
                        <td><a href="{{url('stock/editproduct/'.$stock->id) }}" class="btn btn-sm btn-flat btn-success">Edit</a></td>
                        <td>
                        <form method="POST" action="{{url('stock/'.$stock->id) }}" style="display: inline-block;">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus Data?')">Hapus</button>
                      </form>
                    </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div><!-- /.container-fluid -->
          
          <!--Pagination-->
          <div class="d-flex justify-content-center">
            {!! $stocks->links() !!}
          </div>
          
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
    
@endsection