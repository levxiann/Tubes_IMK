<?php

namespace App\Http\Controllers;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $stocks = Stock::where([
            ['id', '!=', Null], ['name', '!=', Null],
            [function ($query) use ($request){
                if(($term = $request->term)){
                    $query->orWhere('id', 'LIKE', '%'.$term.'%')->get();
                    $query->orWhere('name', 'LIKE', '%'.$term.'%')->get();
                }
            }]
        ])
        ->orderBy("id", "asc")
        ->paginate(10);

        return view('kasir.stock', compact('stocks'));
    }

    public function create()
    {
        return view('kasir.newproduct');
    }

    public function store(Request $request){
        $stocks['image'] = $request->image;
        $stocks['name'] = $request->name;
        $stocks['description'] = $request->description;
        $stocks['price'] = $request->price;
        $stocks['wholesale_price'] = $request->wholesale_price;
        $stocks['wholesale_quantity'] = $request->wholesale_quantity;
        $stocks['stocks'] = $request->stock;
        
        $input = $request->all();

        $stocks = Stock::create($input);
         
        return redirect('stock')->with('success','Produk baru berhasil ditambah!');
    }

    public function add($id){
        $stocks = Stock::find($id);

        return view('kasir.addstock', compact('stocks'));
    }

    public function tambah(Request $request, $id){
        $stocks['stock'] = $request->stock;

        $stocks = Stock::find($id);
        $stocks->stock = $stocks->stock + $request->stock;
        $stocks->save();

        return redirect('stock')->with('success','Stok berhasil ditambah!');
    }

    public function minus($id){
        $stocks = Stock::find($id);

        return view('kasir.stockrusak', compact('stocks'));
    }

    public function kurang(Request $request, $id){
        $stocks['stock'] = $request->stock;
 
        $stocks = Stock::find($id);
        $stocks->stock = $stocks->stock - $request->stock;
        $stocks->save();

        return redirect('stock')->with('success','Stok berhasil dikurang!');
    }

    public function edit($id)
    {
        $stocks = Stock::find($id);
        return view('kasir.editproduct', compact('stocks'));
    }

    public function update(Request $request, $id)
    {
        $stocks = Stock::find($id);
        $stocks['image'] = $request->image;
        $stocks['name'] = $request->name;
        $stocks['description'] = $request->description;
        $stocks['price'] = $request->price;
        $stocks['wholesale_price'] = $request->wholesale_price;
        $stocks['wholesale_quantity'] = $request->wholesale_quantity;

        $stocks->update(); 
        return redirect('stock')->with('success','Data produk berhasil diubah!');
    }

    public function destroy($id){
        $stocks = Stock::find($id);

        $stocks->delete();

        return redirect('stock')->with('success','Data berhasil dihapus!');
    }

    
}
