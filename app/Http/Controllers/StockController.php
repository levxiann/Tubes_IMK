<?php

namespace App\Http\Controllers;

use App\Models\Instock;
use App\Models\Stock;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PDF;
use Dompdf\Options;
use Dompdf\Dompdf;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active');
    }

    public function index(Request $request)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','product');

        $stocks = Stock::where([
            ['id', '!=', Null], ['name', '!=', Null],
            [function ($query) use ($request){
                if(($term = $request->term)){
                    $query->orWhere('id', $term)->get();
                    $query->orWhere('name', 'LIKE', '%'.$term.'%')->get();
                }
            }]
        ])
        ->orderBy("id", "desc")
        ->paginate(10);

        $stocks->appends(['term' => $request->term]);

        return view('kasir.stock', compact('stocks'));
    }

    public function create()
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','product');

        return view('kasir.newproduct');
    }

    public function store(Request $request)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','product');

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'wholesale_price' => 'required|integer|min:0',
            'wholesale_quantity' => 'required|integer|min:0',
            'stock' => 'required|integer|min:1',
            'image' => 'image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if($request->wholesale_price == 0)
        {
            $request->wholesale_price = NULL;
        }

        if($request->wholesale_quantity == 0)
        {
            $request->wholesale_quantity = NULL;
        }

        if($request->has('image'))
        {
            $newname = Str::random(20);
            $newname .=".";
            $newname .= $request->file('image')->extension();

            $request->file('image')->move(public_path('images/'), $newname);
        }
        else
        {
            $newname = "nophoto.png";
        }

        Stock::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'wholesale_price' => $request->wholesale_price,
            'wholesale_quantity' => $request->wholesale_quantity,
            'stock' => $request->stock,
            'image' => $newname
        ]);

        $stock = Stock::latest()->first();

        Instock::create([
            'stock_id' => $stock->id,
            'stock' => $request->stock
        ]);
         
        return redirect('/stock')->with('success','Produk baru berhasil ditambah!');
    }

    public function add($id)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','product');

        $stocks = Stock::findOrFail($id);

        return view('kasir.addstock', compact('stocks'));
    }

    public function tambah(Request $request, $id)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','product');

        $request->validate([
            'stock' => 'required|integer|min:1'
        ]);

        $stock = Stock::findOrFail($id);
        $stock->stock = $stock->stock + $request->stock;
        $stock->save();

        Instock::create([
            'stock_id' => $id,
            'stock' => $request->stock
        ]);

        return redirect('stock')->with('success','Stok berhasil ditambah!');
    }

    public function minus($id)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','product');

        $stocks = Stock::findOrFail($id);

        return view('kasir.stockrusak', compact('stocks'));
    }

    public function kurang(Request $request, $id)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','product');

        $stock = Stock::findOrFail($id);

        $request->validate([
            'stock' => 'required|integer|min:1|max:'.$stock->stock
        ]);

        $stock->stock = $stock->stock - $request->stock;
        $stock->save();

        return redirect('stock')->with('success','Stok berhasil dikurang!');
    }

    public function edit($id)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','product');

        $stocks = Stock::findOrFail($id);

        return view('kasir.editproduct', compact('stocks'));
    }

    public function update(Request $request, $id)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','product');

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'wholesale_price' => 'required|integer|min:0',
            'wholesale_quantity' => 'required|integer|min:0',
            'image' => 'image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if($request->wholesale_price == 0)
        {
            $request->wholesale_price = NULL;
        }

        if($request->wholesale_quantity == 0)
        {
            $request->wholesale_quantity = NULL;
        }

        Stock::where('id', $id)
        ->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'wholesale_price' => $request->wholesale_price,
            'wholesale_quantity' => $request->wholesale_quantity,
        ]);

        if($request->has('image'))
        {
            $newname = Str::random(20);
            $newname .=".";
            $newname .= $request->file('image')->extension();

            $request->file('image')->move(public_path('images/'), $newname);

            Stock::where('id', $id)
            ->update([
                'image' => $newname
            ]);
        }

        return redirect('stock')->with('success','Data produk berhasil diubah!');
    }

    public function destroy($id)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','product');

        $stock = Stock::findOrFail($id);

        if($stock->receipt->count() > 0)
        {
            return redirect('stock');
        }

        Stock::destroy($id);

        return redirect('stock')->with('success','Data berhasil dihapus!');
    }

    public function close($id)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','product');

        $stock = Stock::findOrFail($id);

        if($stock->status == 0)
        {
            return redirect('/stock');
        }

        Stock::where('id', $id)
        ->update([
            'status' => 0
        ]);

        return redirect('/stock')->with('success', 'Produk dimatikan');
    }

    public function open($id)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','product');

        $stock = Stock::findOrFail($id);

        if($stock->status == 1)
        {
            return redirect('/stock');
        }

        Stock::where('id', $id)
        ->update([
            'status' => 1
        ]);

        return redirect('/stock')->with('success', 'Produk diaktifkan');
    }

    public function print()
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','product');

        $stocks = Stock::all();

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $contxt = stream_context_create([ 
            'ssl' => [ 
                'verify_peer' => FALSE, 
                'verify_peer_name' => FALSE,
                'allow_self_signed'=> TRUE
            ] 
        ]);
        $dompdf->setHttpContext($contxt);

        set_time_limit(600);
        
        $pdf = PDF::loadView('kasir.cetakProduk', compact('stocks'));
     
        return $pdf->stream('produk.'.date('d-M-Y').'.pdf');
    }    

    public function instock()
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','instock');

        $instocks = Instock::orderBy('created_at', 'DESC')->paginate(10);

        return view('kasir.instock', compact('instocks'));
    }

    public function instockDelete($id)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','instock');

        Instock::destroy($id);

        return redirect('/instock')->with('status', 'Data Produk Masuk berhasil dihapus');
    }

    public function printInstock()
    {
        $instocks = Instock::all();

        set_time_limit(600);

        $pdf = PDF::loadView('kasir.cetakInstock', compact('instocks'));
     
        return $pdf->stream('produk_masuk.'.date('d-M-Y').'.pdf');
    }

    public function outstock()
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','outstock');

        $outstocks = Payment::where('status', 1)->orderBy('updated_at', 'DESC')->paginate(10);

        return view('kasir.outstock', compact('outstocks'));
    }

    public function detailoutstock($id)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','outstock');

        $outstocks = Payment::findOrFail($id);

        return view('kasir.detailoutstock', compact('outstocks'));
    }

    public function outstockDelete($id)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','outstock');

        Payment::destroy($id);

        return redirect('/outstock')->with('status', 'Data Penjualan berhasil dihapus');
    }
}
