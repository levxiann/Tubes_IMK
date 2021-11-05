<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Discount;
use App\Models\Stock;

class DiscountController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Discount::paginate(8);
        return view('kasir.discountpage', compact('products'));
    }

    public function create(Request $request)
    {
        $validate = $request->validate([
            'stock_id' => ['required'],
            'percentage' => ['required', 'numeric', 'min:1', 'max:100']
        ]);

        $product = new Discount;
        $product->stock_id = $request->stock_id;
        $product->percentage = $request->percentage;
        $product->save();
        return redirect('/discount')->with('status' , 'Discount produk berhasil ditambahkan!');
    }

    public function update(Request $request)
    {
        $discount = Discount::findOrFail($request->id);

        $request->validate([
            'id' => 'required',
            'percentage' => 'required|integer|min:1|max:100',
        ]);

        Discount::where('id', $discount->id)
        ->update([
            'percentage' => $request->percentage
        ]);

        return redirect('/discount')->with('status', 'Persen diskon telah diedit');
    }

    public function getDetail(Request $request)
    {
        $discount = Discount::find($request->id);
        
        echo json_encode($discount);
    }

    public function destroy($id)
    {
        //menghapus data product berdasarkan id yang dipilih
		$products = DB::table('discounts')->where('id' , $id)->delete() ;
		
		//pengalihan halaman ke halaman show_data setelah melakukan penghapusan data
		return redirect('/discount')->with('status' , 'Produk yang dipilih berhasil dihapus!');
    }
}
