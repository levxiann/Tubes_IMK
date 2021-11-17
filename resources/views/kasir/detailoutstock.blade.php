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
                <div class="card-body">
                    <h6>Invoice : {{$outstocks->id}}</h6>
                    <h6>Tanggal : {{date('D, d M Y H:i',strtotime($outstocks->updated_at))}}</h6>
                    <h6>Kasir   : {{$outstocks->user->name}}</h6>
                    <table class="table table-stripped text-center">
                    <thead>
                        <tr class="align-middle">
                            <th scope="col">Kode Produk</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Qty</th>
                            <th scope="col" class="text-end">Harga Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($outstocks->receipts as $receipt)
                            <tr>
                                <th scope="row">{{$receipt->stock_id}}</th>
                                <td>{{$receipt->stock->name}}</td>
                                <td>{{$receipt->quantity}}</td>
                                <td class="text-end">Rp {{$receipt->price}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-end">Total : </td>
                            <td class="text-end">Rp {{$outstocks->total}}</td>
                        </tr>
                    </tbody>
                    </table>
                </div>
                <form action="{{url('/outstock/delete/'.$outstocks->id)}}" method="POST" class="text-photo" onsubmit="return confirm('Anda Yakin?')" style="display: inline-block">
                    @csrf
                    @method('delete')
                        <button type="submit" class="btn btn-danger"><span class="far fa-trash-alt" style="background: transparent"></span> Hapus</button>
                </form>
                <a href="{{url('/outstock')}}" class="btn btn-warning"><span class="far fa-arrow-left" style="background: transparent"></span> Kembali</a>
            </div><!-- /.container-fluid -->
          
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
    
@endsection