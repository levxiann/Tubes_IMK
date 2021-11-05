@extends('kasir.layouts.main')

@section('content')

<div class="container mt-3">
  <h2>Edit Data Produk</h2><hr>
  <form action="{{url('stock/editproduct/'.$stocks->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group mb-3">
        <label for="id">ID</label>
        <input type="number" class="form-control" id="id" value="{{$stocks->id}}" name="id" disabled>
    </div>
    <div class="form-group mb-3">
        <label for="name">Nama Produk</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Masukkan nama produk" name="name" value="{{$stocks->name}}">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="image">Gambar</label>
        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
        @error('image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="description">Deskripsi</label>
        <input type="long-text" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Masukkan deskripsi produk" name="description" value="{{$stocks->description}}">
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="price">Harga Produk</label>
        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" placeholder="Masukkan harga produk" name="price" value="{{$stocks->price}}">
        @error('price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="wholesale_price">Harga Grosir</label>
        <input type="number" class="form-control @error('wholesale_price') is-invalid @enderror" id="wholesale_price" placeholder="Masukkan harga grosir" name="wholesale_price" value="@php echo ($stocks->wholesale_price == NULL) ? 0 : $stocks->wholesale_price;  @endphp">
        @error('wholesale_price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="wholesale_quantity">Satuan Grosir</label>
        <input type="number" class="form-control @error('wholesale_quantity') is-invalid @enderror" id="wholesale_quantity" placeholder="Masukkan satuan grosir" name="wholesale_quantity" value="@php echo ($stocks->wholesale_quantity == NULL) ? 0 : $stocks->wholesale_quantity;  @endphp">
        @error('wholesale_quantity')
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
