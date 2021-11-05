<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Discount;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','discount');

        $products = Stock::paginate(8);

        return view('kasir.discountpage', compact('products'));
    }

    public function search(Request $request)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','discount');

        $products = Stock::where('name', 'like', "%".$request->keyword."%")->paginate(8);

        $products->appends(['keyword' => $request->keyword]);

        return view('kasir.discountpage', compact('products'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'id' => 'required',
            'percentage' => 'required|integer|min:1|max:100'
        ]);

        Stock::findOrFail($request->id);

        Discount::create([
            'stock_id' => $request->id,
            'percentage' => $request->percentage
        ]);

        return redirect('/discount')->with('status' , 'Discount produk berhasil ditambahkan!');
    }

    public function update(Request $request)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','discount');

        $request->validate([
            'id' => 'required',
            'percentage' => 'required|integer|min:1|max:100',
        ]);

        $discount = Discount::findOrFail($request->id);

        Discount::where('id', $discount->id)
        ->update([
            'percentage' => $request->percentage
        ]);

        return redirect('/discount')->with('status', 'Persen diskon berhasil diedit');
    }

    public function getDetail(Request $request)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','discount');

        $discount = Discount::findOrFail($request->id);
        
        echo json_encode($discount);
    }

    public function getProductDetail(Request $request)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','discount');

        $product = Stock::findOrFail($request->id);
        
        echo json_encode($product);
    }

    public function destroy($id)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','discount');

        //menghapus data product berdasarkan id yang dipilih
		Discount::destroy($id);
		
		//pengalihan halaman ke halaman show_data setelah melakukan penghapusan data
		return redirect('/discount')->with('status' , 'Diskon Produk berhasil dihapus!');
    }
}
