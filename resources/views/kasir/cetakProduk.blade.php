<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Serba Ada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        table, th, td {
        border: 1px solid rgb(81, 79, 79);
        border-collapse: collapse;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container ms-3 mt-3">
        <h5 class="text-header">Toko Serba Ada</h5>
        <h5 class="text-header">Data Produk</h5>
        <div class="card-body">
            <table class="table table-stripped text-center" style="width: 600px">
              <thead>
                <tr class="align-middle">
                  <th scope="col">ID</th>
                  <th scope="col">Gambar</th>
                  <th scope="col">Nama</th>
                  <th scope="col">Deskripsi</th>
                  <th scope="col">Harga</th>
                  <th scope="col">Harga Grosir</th>
                  <th scope="col">Satuan Grosir</th>
                  <th scope="col">Stok</th>
                </tr>
              </thead>
              <tbody>
                @foreach($stocks as $stock)
                <tr>
                    <td>{{$stock->id}}</td>
                    <td><img src="{{ public_path('images/'.$stock->image) }}" height="100" width="100"></td>
                    <td>{{$stock->name}}</td>
                    <td>{{$stock->description}}</td>
                    <td>
                      @if ($stock->discount != NULL)
                        <del>Rp {{$stock->price}}</del> <b class="text-danger">{{$stock->discount->percentage}}%</b> => Rp {{((100 - $stock->discount->percentage) * $stock->price)/100}}
                      @else
                        Rp {{$stock->price}}
                      @endif
                    </td>
                    <td>
                      @if ($stock->wholesale_price != NULL)
                        Rp {{$stock->wholesale_price}}
                      @endif
                    </td>
                    <td>
                      @if ($stock->wholesale_quantity != NULL)
                        {{$stock->wholesale_quantity}}
                      @endif
                    </td>
                    <td>{{$stock->stock}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
        </div>
    </div>   
</body>
</html> 