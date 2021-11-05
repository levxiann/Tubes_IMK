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
        <h2 class="text-header">Struk</h2>
        <h5 class="text-header">Toko Serba Ada</h5>
        <div>
            Invoice : {{$printPayment->id}}<br>
            Tanggal : {{date('d M Y', strtotime($printPayment->updated_at))}}<br>
        </div>
        <table class="table table-stripped text-center">
            <thead>
              <tr>
                <th scope="col">Kode Produk</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Qty</th>
                <th scope="col" class="text-end">Harga Total</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($printReceipt as $receipt)
                    <tr>
                        <th scope="row">{{$receipt->stock_id}}</th>
                        <td>{{$receipt->stock->name}}</td>
                        <td>{{$receipt->quantity}}</td>
                        <td class="text-end">Rp {{$receipt->price}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-end">Total : </td>
                    <td class="text-end">Rp {{$printPayment->total}}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end">Bayar : </td>
                    <td class="text-end">Rp {{$pay}}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end">Kembalian : </td>
                    <td class="text-end">Rp {{$pay - $printPayment->total}}</td>
                </tr>
            </tbody>
        </table>
    </div>   
</body>
</html> 