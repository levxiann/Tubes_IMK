<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit Data Produk</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Edit Data Produk</h2>
  <form action="{{url('stock/editproduct/'.$stocks->id)}}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="id">ID</label>
        <input type="number" min="1" class="form-control" id="id" value="{{$stocks->id}}" name="id" disabled>
    </div>
    <div class="form-group">
        <label for="image">Gambar</label>
        <input type="file" class="form-control" id="image" value="{{asset('storage/images/'.$stocks->image)}}" name="image">
    </div>
    <div class="form-group">
        <label for="name">Nama Produk</label>
        <input type="text" class="form-control" id="name" placeholder="Masukkan nama produk" value="{{$stocks->name}}" name="name">
    </div>
    <div class="form-group">
        <label for="description">Deskripsi</label>
        <input type="long-text" class="form-control" id="description" placeholder="Masukkan deskripsi produk" value="{{$stocks->description}}" name="description">
    </div>
    <div class="form-group">
        <label for="price">Harga Produk</label>
        <input type="number" min="0" class="form-control" id="price" placeholder="Masukkan harga produk" value="{{$stocks->price}}" name="price">
    </div>
    <div class="form-group">
        <label for="wholesale_price">Harga Grosir</label>
        <input type="number" min="0" class="form-control" id="wholesale_price" placeholder="Masukkan harga grosir" value="{{$stocks->wholesale_price}}" name="wholesale_price">
    </div>
    <div class="form-group">
        <label for="wholesale_quantity">Satuan Grosir</label>
        <input type="number" min="0" class="form-control" id="wholesale_quantity" placeholder="Masukkan satuan grosir" value="{{$stocks->wholesale_quantity}}" name="wholesale_quantity">
    </div>    
    <div class="form-group">
        <a class="btn btn-light" href="{{url('/stock')}}">Cancel</a>
        <button class="btn btn-primary confirm-button">Save</button>
    </div>
  </form>
</div>

</body>
</html>
