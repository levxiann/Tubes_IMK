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
        <h5 class="text-header">Data Produk Rusak</h5>
        <div class="card-body">
            <table class="table table-striped text-center">
                <thead>
                  <tr>
                    <th scope="col">Kode Barang</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Qty Rusak</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Tanggal Keluar</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($brokens as $broken)
                        <tr>
                            <th scope="row">{{$broken->stock_id}}</th>
                            <td>{{$broken->stock->name}}</td>
                            <td>{{$broken->broken_stock}}</td>
                            <td>{{$broken->desc}}</td>
                            <td>{{date('d M Y', strtotime($broken->created_at))}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>   
</body>
</html> 