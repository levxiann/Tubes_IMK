@extends('kasir.layouts.main')

@section('content')

<div class="container mt-3">
  <h2>Stok Rusak</h2><hr>
  <form action="{{url('stock/stockrusak/'.$stocks->id)}}" method="POST">
    @csrf
    <div class="form-group mb-3">
        <label for="id">ID</label>
        <input type="number" min="1" class="form-control" id="id" value="{{$stocks->id}}" name="id" disabled>
    </div>
    <div class="form-group mb-3">
        <label for="name">Nama Produk</label>
        <input type="text" class="form-control" id="name" value="{{$stocks->name}}" name="name" disabled>
    </div>
    <div class="form-group mb-3">
        <label for="description">Deskripsi</label>
        <input type="long-text" class="form-control" id="description" value="{{$stocks->description}}" name="description" disabled>
    </div>
    <div class="form-group mb-3">
        <label for="stockAda">Stok</label>
        <input type="number" class="form-control" id="stockAda" value="{{$stocks->stock}}" name="stock" disabled>
    </div> 
    <div class="form-group mb-3">
        <label for="stockRusak">Jumlah Stok Rusak</label>
        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stockRusak" placeholder="Masukkan jumlah stok rusak" name="stock" value="{{old('stock')}}">
        @error('stock')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>    
    <div class="form-group mb-3">
        <label for="stockRusak">Keterangan</label>
        <textarea type="text" class="form-control @error('desc') is-invalid @enderror" id="desc" placeholder="Masukkan keterangan" name="desc" rows="5">{{old('desc')}}</textarea>
        @error('desc')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>  
    <div class="form-group mb-3">
        <a class="btn btn-light" href="{{url('/stock')}}">Cancel</a>
        <button type="submit" class="btn btn-primary confirm-button"><span class="far fa-save"></span> Save</button>
    </div>
  </form>
</div>

@endsection
