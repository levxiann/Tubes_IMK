@extends('kasir.layouts.main')

@section('content')
    <div class="container ms-3 mt-3">
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            <strong>{{session('status')}}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @error('pay')
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            <strong>{{$message}}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror
        <h2 class="text-header">Struk</h2>
        <h5 class="text-header">Toko Serba Ada</h5>
        <div>
            Invoice : {{$payment->id}}<br>
            Tanggal : {{date("d M Y")}}<br>
        </div>
        <table class="table table-stripped text-center">
            <thead>
              <tr>
                <th scope="col">Kode Produk</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Qty</th>
                <th scope="col" class="text-end">Harga Total</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                    $proceed = 1;
                @endphp
                @foreach ($receipts as $receipt)
                    <tr>
                        <th scope="row">{{$receipt->stock_id}}</th>
                        <td>{{$receipt->stock->name}}</td>
                        <td>{{$receipt->quantity}}</td>
                        <td class="text-end">
                            @php
                                $price = 0;

                                if($receipt->stock->discount != NULL)
                                {
                                    if($receipt->stock->wholesale_price != NULL && $receipt->stock->wholesale_quantity != NULL)
                                    {
                                        if($receipt->quantity >= $receipt->stock->wholesale_quantity)
                                        {
                                            $price =  ((100-$receipt->stock->discount->percentage) * ($receipt->stock->wholesale_price * $receipt->quantity))/100;
                                        }
                                        else 
                                        {
                                            $price =  ((100-$receipt->stock->discount->percentage) * ($receipt->stock->price * $receipt->quantity))/100;
                                        }
                                    }
                                    else 
                                    {
                                        $price =  ((100-$receipt->stock->discount->percentage) * ($receipt->stock->price * $receipt->quantity))/100;
                                    }
                                }
                                else 
                                {
                                    if($receipt->stock->wholesale_price != NULL && $receipt->stock->wholesale_quantity != NULL)
                                    {
                                        if($receipt->quantity >= $receipt->stock->wholesale_quantity)
                                        {
                                            $price =  $receipt->stock->wholesale_price * $receipt->quantity;
                                        }
                                        else 
                                        {
                                            $price = $receipt->stock->price * $receipt->quantity;
                                        }
                                    }
                                    else 
                                    {
                                        $price = $receipt->stock->price * $receipt->quantity;
                                    }
                                }

                                $total += $price;
                            @endphp
                            Rp {{number_format($price, 2, ',', '.')}}
                        </td>
                        <td class="text-start">
                            <form action="{{url('/order/delete/'.$receipt->id)}}" method="POST" class="ms-2 text-photo" onsubmit="return confirm('Anda Yakin?')" style="display: inline-block">
                                @csrf
                                @method('delete')
                                    <button type="submit" class="btn btn-danger"><span class="far fa-trash" style="background: transparent"></span> Hapus</button>
                            </form>
                            <button type="button" class="btn btn-warning ms-3 editOrder" data-bs-toggle="modal" data-bs-target="#editOrderModal" data-id="{{$receipt->id}}" style="display: inline-block">
                                <span class="far fa-edit" style="background: transparent"></span> Edit Qty
                            </button>
                            @if ($receipt->quantity > $receipt->stock->stock)
                            <button type="button" class="btn btn-danger ms-3 editOrder" style="display: inline-block" disabled>
                                <span class="far fa-exclamation" style="background: transparent"></span> Melebihi Stok
                                @php
                                    $proceed = 0;
                                @endphp
                            </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-end">Total : </td>
                    <td class="text-end">Rp {{number_format($total, 2, ',', '.')}}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-success ms-3" data-bs-toggle="modal" data-bs-target="#bayarModal" style="display: inline-block" @if($proceed == 0) disabled @endif>
            <span class="far fa-print" style="background: transparent"></span> Bayar dan Cetak Struk
        </button>
        <form action="{{url('/order/cancel/'.$payment->id)}}" method="POST" class="text-photo" onsubmit="return confirm('Anda Yakin?')" style="display: inline-block">
            @csrf
            @method('delete')
                <button type="submit" class="btn btn-danger"><span class="far fa-ban" style="background: transparent"></span> Batal</button>
        </form>
        <a href="{{url('/order')}}" class="btn btn-warning"><span class="far fa-arrow-left" style="background: transparent"></span> Kembali</a>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editOrderModalLabel">Edit Orderan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{url('/order/update')}}" method="POST" class="ms-3 text-photo">
                @csrf
                @method('patch')
                <input type="hidden" name="id" id="idReceiptSubmit" value="">
                <div class="form-group mb-3">     
                    <label class="label" for="quantity">Banyak Orderan</label>
                    <input id="quantity" name="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" placeholder="Masukkan Jumlah Orderan" value="" autocomplete="number" autofocus>
                    @error('quantity')
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
<div class="modal fade" id="bayarModal" tabindex="-1" aria-labelledby="bayarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bayarModalLabel">Bayar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{url('/pay')}}" target="_blank" method="POST" class="ms-3 text-photo" onsubmit="return confirm('Anda Yakin?')">
                @csrf
                <input type="hidden" name="id" id="idPaymentSubmit" value="{{$payment->id}}">
                <div class="form-group mb-3">     
                    <label class="label" for="total">Total Harga</label>
                    <input id="total" type="number" class="form-control" value="{{$total}}" autofocus disabled>
                </div>
                <div class="form-group mb-3">     
                    <label class="label" for="bayar">Bayaran Pembeli</label>
                    <input id="pay" name="pay" type="number" class="form-control @error('quantity') is-invalid @enderror" placeholder="Masukkan Bayaran" value="" autocomplete="number" autofocus>
                    @error('pay')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success"><span class="far fa-credit-card" style="background: transparent"></span> Bayar</button>
                </form>
        </div>
      </div>
    </div>
</div>

<script src="{{asset('/js/jquery.js')}}"></script>
<script>
$('.editOrder').on('click',function(e){
    let id=$(this).data('id');
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    jQuery.ajax({
        url: "{{ url('/order/getReceiptOrder') }}",
        method: 'post',
        data: {'id': id},
        dataType:'json',
        success: function(result){
            $('#quantity').val(result.quantity);
            $('#idReceiptSubmit').val(result.id);
        }
    });
});
</script>
@endsection