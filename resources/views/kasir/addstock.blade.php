<!DOCTYPE html>
<html lang="en">
<head>
  <title>Tambah Stok</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Tambah Stok Produk</h2>
  <form action="{{url('stock/addstock/'.$stocks->id)}}" method="POST">
    @csrf
    <div class="form-group">
        <label for="id">ID</label>
        <input type="number" min="1" class="form-control" id="id" value="{{$stocks->id}}" name="id" disabled>
    </div>
    <div class="form-group">
        <label for="name">Nama Produk</label>
        <input type="text" class="form-control" id="name" value="{{$stocks->name}}" name="name" disabled>
    </div>
    <div class="form-group">
        <label for="description">Deskripsi</label>
        <input type="long-text" class="form-control" id="description" value="{{$stocks->description}}" name="description" disabled>
    </div>
    <div class="form-group">
        <label for="stock">Stok</label>
        <input type="number" min="0" class="form-control" id="stock" value="{{$stocks->stock}}" name="stock" disabled>
    </div>
    <div class="form-group">
        <label for="stock">Tambah stok</label>
        <input type="number" min="1" class="form-control" id="stock" placeholder="Masukkan tambahan stok" name="stock">
    </div>    
    <div class="form-group">
        <a class="btn btn-light" href="{{url('/stock')}}">Cancel</a>
        <button class="btn btn-primary confirm-button">Save</button>
    </div>
  </form>
</div>

</body>
</html>
