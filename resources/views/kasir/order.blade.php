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
        @error('quantity')
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                <strong>{{$message}}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @enderror
        <div class="row mt-3">
            <h2 class="card-header mb-4">Struk</h2>
            
            <div class="float-end">
                @if (Auth::user()->name == "Admin")
                <a href="{{url('/invoice')}}" target="_blank" class="float-start btn btn-primary" style="display: inline-block"><span class="far fa-print" style="background: transparent"></span> Cetak Invoice</a>
                @endif
                <a href="{{url('/receipt')}}" class="float-end @if($count == 0) disabled @endif btn btn-success" style="display: inline-block"><span class="far fa-shopping-cart" style="background: transparent"></span> Selesai ({{$count}})</a>            
            </div>
            <form class="d-flex mt-3" action="{{url('/order/search')}}" method="GET">
                <input id="keyword" class="form-control me-2 mb-2 mr-2" type="search" placeholder="Cari Kode Barang atau Nama Barang" name="keyword" aria-label="Search" style="background-color : lightblue" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>">
                <button class="btn btn-outline-success btn-sm" type="submit">Search</button>
            </form>
        </div>
        @if (isset($stocks))
            <div id="stock" class="row mt-3">
                @foreach ($stocks as $stock)
                    <div class="col-4 me-2">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                            <div class="col-md-4 justify">
                                <img src="{{asset('/images/'. $stock->image)}}" class="img-fluid rounded-start" alt="{{$stock->name}}">
                                <button type="button" class="btn btn-success ms-3 mb-2 addOrder" data-bs-toggle="modal" data-bs-target="#tambahOrderModal" data-id="{{$stock->id}}">
                                    <span class="far fa-plus" style="background: transparent"></span> Tambah
                                </button>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                <p class="card-title">{{$stock->id}} {{$stock->name}}</p>
                                <p class="card-text">{{$stock->stock}} tersedia</p>
                                <p class="card-text"><small class="text-muted">
                                @if ($stock->discount != NULL)
                                    <del>Rp {{$stock->price}}</del> <b class="text-danger">{{$stock->discount->percentage}}%</b> => Rp {{((100 - $stock->discount->percentage) * $stock->price)/100}}
                                @else
                                    Rp {{$stock->price}}
                                @endif    
                                </small></p>
                                <p class="card-text"><small class="text-muted">
                                    @if ($stock->wholesale_price != NULL)
                                        Rp {{$stock->wholesale_price}} untuk {{$stock->wholesale_quantity}} item
                                    @else
                                        <br>
                                    @endif    
                                    </small></p>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row mt-2 ml-2">
                {{$stocks->onEachSide(2)->links()}}
            </div>
        @endif

    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="tambahOrderModal" tabindex="-1" aria-labelledby="tambahOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tambahOrderModalLabel">Tambah Orderan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{url('/order/store')}}" method="POST" class="ms-3 text-photo">
                @csrf
                <input type="hidden" name="id" id="idOrderSubmit" value="">
                <div class="form-group mb-3">     
                    <input id="idOrder" type="text" class="form-control" value="" autofocus disabled>
                </div>
                <div class="form-group mb-3">     
                    <label class="label" for="quantity">Banyak Orderan</label>
                    <input id="quantity" name="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" placeholder="Masukkan Jumlah Orderan" value="{{ old('quantity') }}" autocomplete="number" autofocus>
                    @error('quantity')
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
$('.addOrder').on('click',function(e){
    let id=$(this).data('id');
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    jQuery.ajax({
        url: "{{ url('/order/getOrder') }}",
        method: 'post',
        data: {'id': id},
        dataType:'json',
        success: function(result){
            $('#idOrder').val(result.id+' '+result.name);
            $('#idOrderSubmit').val(result.id);
        }
    });
});
</script>
@endsection