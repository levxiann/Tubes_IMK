@extends('kasir.layouts.main')

@section('content')
    {{-- Sidebar --}}
    @include('kasir.layouts.sidebar')
    {{-- End Sidebar --}}

    <div class="container">
      <div class="row"><br><b style="font-size: x-large;">DISCOUNT<b><br></div>
    <div class="row justify-content-start">
        @foreach($products as $product)
        <div class="card col-lg-3 col-6 col-md-3">
            <div class="card border-0" style="width: 15rem; border-radius: 5px;">
                <img src="#" class="card-img-top" style="width: 14rem; height: 10rem; object-fit: cover; border-radius: 5px;" alt="...">
                <div class="card-body">
                    <div class="card-title discount-title" style="color:black; font-weight:500; font-size: large;">{{$product->stock->name}}</div>
                    <div class="discount-circle">{{$product->percentage}}%</div><br>
                    <div style= "inline-block; float:right;">
                    <button type="button" class="btn btn-primary btn-sm btn-block button_disc" data-bs-toggle="modal" data-bs-target="#exampleModalCenter" data-id="{{$product->id}}">Edit Discount</button>   
                    <form action="{{url('/discount/delete/'.$product->id)}}" method="POST" class="ms-2 text-photo" onsubmit="return confirm('Anda Yakin?')" style="display: inline-block">
                        @csrf
                        @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm" style="inline"><span class="far fa-trash" style="background: transparent"></span> Hapus</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
        <!--Pagination-->
        <div style="font-size: small;">@include('pagination', ['paginator' => $products, 'interval' => 4])</div>
    </div>

</main>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                
                <h5 class="modal-title" id="editDiscountModalLongTitle" value="">
                    @error('editDiscountModalLongTitle')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('/discount/update')}}" method="POST" class="ms-3 text-photo">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="id" id="idDiscountSubmit" value="">
                    
                    <div class="form-group mb-3">     
                        <label class="label" for="percentage">Jumlah Discount</label>
                        <input id="percentage" name="percentage" type="number" class="form-control @error('percentage') is-invalid @enderror" placeholder="Masukkan besar persen diskon" value="" autocomplete="number" autofocus>%
                        @error('percentage')
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
            $('#idDiscountSubmit').val(id);
            $('#editDiscountModalLongTitle').val(result.stock.name);
        }
    });
});
</script>
@endsection