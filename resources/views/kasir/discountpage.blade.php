@extends('kasir.layouts.main')

@section('content')
    {{-- Sidebar --}}
    @include('kasir.layouts.sidebar')
    {{-- End Sidebar --}}

    <div class="container mt-3">
        @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            <strong>{{session('status')}}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @error('percentage')
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                <strong>{{$message}}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @enderror
    <div class="row"><br><b style="font-size: x-large;">DISCOUNT<b><br></div><hr>
    <div class="row mb-3">
        <form class="d-flex mt-3" action="{{url('/discount/search')}}" method="GET">
            <a href="{{url('/discount')}}" class="me-2">
                <span class="input-group-btn">
                    <button class="btn btn-danger" type="button" title="Refresh page">
                        <span class="fas fa-sync-alt"></span>
                    </button>
                </span>
            </a>
            <input id="keyword" class="form-control me-2 mb-2 mr-2" type="search" placeholder="Cari Nama Barang" name="keyword" aria-label="Search" style="background-color : lightblue" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>">
            <button class="btn btn-outline-success btn-sm" type="submit">Search</button>
        </form>
    </div>
    <div class="row justify-content-start">
        @foreach($products as $product)
        <div class="card col-lg-3 col-6 col-md-3">
            <div class="card border-0" style="width: 15rem; border-radius: 5px;">
                <img src="{{asset('/images/'.$product->image)}}" class="card-img-top" style="width: 14rem; height: 10rem; object-fit: cover; border-radius: 5px;" alt="...">
                <div class="card-body">
                    <div class="card-title discount-title" style="color:black; font-weight:500; font-size: large;">{{$product->name}}</div>
                    @if ($product->discount != NULL)
                    <div class="discount-circle">{{$product->discount->percentage}}%</div><br>
                    <div style= "inline-block; float:right;">
                        <button type="button" class="btn btn-warning btn-sm btn-block button_disc" data-bs-toggle="modal" data-bs-target="#editDiscountModal" data-id="{{$product->discount->id}}">
                            <span class="far fa-edit"></span>  Edit Discount
                        </button>
                        <form action="{{url('/discount/delete/'.$product->discount->id)}}" method="POST" class="ms-2 text-photo" onsubmit="return confirm('Anda Yakin?')" style="display: inline-block">
                            @csrf
                            @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm" style="inline"><span class="far fa-trash" style="background: transparent"></span> Hapus</button>
                        </form>
                    </div>
                    @else
                    <br>
                    <div style= "inline-block;">
                        <button type="button" class="btn btn-success btn-sm btn-block button_disc_add" data-bs-toggle="modal" data-bs-target="#tambahDiscountModal" data-id="{{$product->id}}">
                            <span class="far fa-plus"></span>  Tambah Discount
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
        <!--Pagination-->
        <div class="d-flex mt-3 justify-content-end me-2">
            {!! $products->links() !!}
        </div>
    </div>

</main>

<!-- Modal -->
<div class="modal fade" id="editDiscountModal" tabindex="-1" aria-labelledby="editDiscountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editDiscountModalLabel">Edit Discount</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{url('/discount/update')}}" method="POST" class="ms-3 text-photo">
                @csrf
                @method('patch')
                <input type="hidden" name="id" id="idDiscountSubmit" value="">
                <div class="form-group mb-3">     
                    <label class="label" for="percentage">Jumlah Discount</label>
                    <input id="percentage" name="percentage" type="number" class="form-control @error('percentage') is-invalid @enderror" placeholder="Masukkan Persen Diskon" value="" autocomplete="number" autofocus>
                    @error('percentage')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <label class="label" for="percentage">%</label>
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
<div class="modal fade" id="tambahDiscountModal" tabindex="-1" aria-labelledby="tambahDiscountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tambahDiscountModalLabel">Tambah Discount</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{url('/discount/store')}}" method="POST" class="ms-3 text-photo">
                @csrf
                <input type="hidden" name="id" id="idProductSubmit" value="">
                <div class="form-group mb-3">     
                    <label class="label" for="keterangan">Produk</label>
                    <input id="keterangan" type="text" class="form-control" value="" autofocus disabled>
                </div>
                <div class="form-group mb-3">     
                    <label class="label" for="percentage">Jumlah Discount</label>
                    <input id="percentageAdd" name="percentage" type="number" class="form-control @error('percentage') is-invalid @enderror" placeholder="Masukkan Persen Diskon" value="{{ old('percentage') }}" autocomplete="number" autofocus>
                    @error('percentage')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <label class="label" for="percentage">%</label>
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
$('.button_disc').on('click',function(e){
    let id=$(this).data('id');
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    jQuery.ajax({
        url: "{{ url('/discount/getDiscountDetail') }}",
        method: 'post',
        data: {'id': id},
        dataType:'json',
        success: function(result){
            $('#percentage').val(result.percentage);
            $('#idDiscountSubmit').val(result.id);
        }
    });
});

$('.button_disc_add').on('click',function(e){
    let id=$(this).data('id');
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    jQuery.ajax({
        url: "{{ url('/discount/getProductDetail') }}",
        method: 'post',
        data: {'id': id},
        dataType:'json',
        success: function(result){
            $('#percentageAdd').val(result.percentage);
            $('#idProductSubmit').val(result.id);
            $('#keterangan').val(result.id + ' ' + result.name);
        }
    });
});
</script>
@endsection