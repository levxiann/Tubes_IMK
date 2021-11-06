@extends('kasir.layouts.main')

@section('content')

<div class="container mt-3">
  <h2>Tambah Produk Baru</h2><hr>
  <form action="{{url('stock/newproduct')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group mb-3">
        <label for="name">Nama Produk</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Masukkan nama produk" name="name" value="{{old('name')}}">
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
        <input type="long-text" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Masukkan deskripsi produk" name="description" value="{{old('description')}}">
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="price">Harga Produk</label>
        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" placeholder="Masukkan harga produk" name="price" value="{{old('price')}}">
        @error('price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="wholesale_price">Harga Grosir</label>
        <input type="number" class="form-control @error('wholesale_price') is-invalid @enderror" id="wholesale_price" placeholder="Masukkan harga grosir (0 jika tidak ada)" name="wholesale_price" value="{{old('wholesale_price')}}">
        @error('wholesale_price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="wholesale_quantity">Satuan Grosir</label>
        <input type="number" class="form-control @error('wholesale_quantity') is-invalid @enderror" id="wholesale_quantity" placeholder="Masukkan satuan grosir (0 jika tidak ada)" name="wholesale_quantity" value="{{old('wholesale_quantity')}}">
        @error('wholesale_quantity')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>    
    <div class="form-group mb-3">
        <label for="stok">Jumlah Stok</label>
        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stok" placeholder="Masukkan jumlah stok" name="stock" value="{{old('stock')}}">
        @error('stock')
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