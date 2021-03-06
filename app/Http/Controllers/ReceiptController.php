<?php

namespace App\Http\Controllers;

use App\Models\Broken;
use App\Models\Payment;
use App\Models\Receipt;
use Illuminate\Http\Request;
use PDF;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active');
    }

    public function index()
    {
        session()->put('menu','receipt');

        $payment = Payment::where('status', 0)->where('user_id', Auth::user()->id)->first();
        $count = 0;
        if($payment != NULL)
        {
            $count = Payment::find($payment->id)->receipts()->count();
        }

        return view('kasir.order', compact('count'));
    }

    public function search(Request $request)
    {
        session()->put('menu','receipt');

        session()->put('keyword', $request->keyword);

        $payment = Payment::where('status', 0)->where('user_id', Auth::user()->id)->first();
        $count = 0;
        if($payment != NULL)
        {
            $count = Payment::find($payment->id)->receipts()->count();
        }

        $keyword = $request->keyword;

        $stocks = Stock::where('status', 1)
                    ->where(function($q){
                        $keyword = session('keyword');
                        $q->where('name', 'like', "%". $keyword ."%")->orWhere('id', $keyword);
                    })->paginate(8);

        $stocks->appends(['keyword' => $request->keyword]);

        return view('kasir.order', compact('stocks', 'count'));
    }

    public function getOrder(Request $request)
    {
        $stock = Stock::find($request->id);
        
        echo json_encode($stock);
    }

    public function store(Request $request)
    {
        $stock = Stock::findOrFail($request->id);

        if($stock->status == 0)
        {
            return redirect('/order');
        }

        $request->validate([
            'id' => 'required',
            'quantity' => 'required|integer|min:1|max:'.$stock->stock,
        ]);

        $receipt = Payment::where('status', 0)->where('user_id', Auth::user()->id)->first();

        if($receipt == NULL)
        {
            Payment::create([
                'user_id' => Auth::user()->id,
                'status' => 0,
            ]);

            $payment = Payment::all()->last();

            Receipt::create([
                'payment_id' => $payment->id,
                'stock_id' => $request->id,
                'quantity' => $request->quantity,
            ]);
        }
        else
        {
            $orderedBefore = Receipt::where('payment_id', $receipt->id)->where('stock_id', $request->id)->first();

            if($orderedBefore == NULL)
            {
                Receipt::create([
                    'payment_id' => $receipt->id,
                    'stock_id' => $request->id,
                    'quantity' => $request->quantity,
                ]);
            }
            else
            {
                Receipt::where('id', $orderedBefore->id)
                ->update([
                    'quantity' => $orderedBefore->quantity + $request->quantity,
                ]);
            }
        }

        return redirect('/order')->with('status', 'Orderan telah dimasukkan ke keranjang');
    }

    public function receipt()
    {
        $payment = Payment::where('status', 0)->where('user_id', Auth::user()->id)->first();

        if($payment == NULL)
        {
            return redirect('/order');
        }

        $count = $payment->receipts->count();

        foreach($payment->receipts as $receipt)
        {
            if($receipt->stock->status == 0)
            {
                if($count == 1)
                {
                    Payment::destroy($payment->id);

                    return redirect('/order');
                }
                else
                {
                    Receipt::destroy($receipt->id);                
                }
            }
        }

        $receipts = Receipt::where('payment_id', $payment->id)->get();

        return view('kasir.receipt', compact('receipts', 'payment'));
    }

    public function update(Request $request)
    {
        $receipt = Receipt::findOrFail($request->id);
        $stock = Stock::findOrFail($receipt->stock->id);

        if($stock->status == 0)
        {
            Receipt::destroy($request->id);
            return redirect('/receipt');
        }

        $request->validate([
            'id' => 'required',
            'quantity' => 'required|integer|min:1|max:'.$stock->stock,
        ]);

        if($receipt->payment->status == 0)
        {
            Receipt::where('id', $receipt->id)
            ->update([
                'quantity' => $request->quantity
            ]);
        }

        return redirect('/receipt')->with('status', 'Orderan telah diedit');
    }

    public function getReceiptOrder(Request $request)
    {
        $receipt = Receipt::find($request->id);
        
        echo json_encode($receipt);
    }

    public function destroy($id)
    {
        $check = Receipt::find($id);

        if($check->payment->status == 1)
        {
            return redirect('/order');
        }

        $payment = $check->payment->receipts->count();

        if($payment == 1)
        {
            
            Payment::destroy($check->payment_id);
        }
        else
        {
            Receipt::destroy($id);
        }

        return redirect('/receipt')->with('status', 'Orderan telah dihapus');
    }

    public function pay(Request $request)
    {
        $payment = Payment::where('status', 0)->where('user_id', Auth::user()->id)->where('id', $request->id)->first();

        if($payment != NULL)
        {
            $receipts = Receipt::where('payment_id', $payment->id)->get();

            $price = 0;
            $total = 0;

            foreach($receipts as $receipt)
            {
                if($receipt->quantity > $receipt->stock->stock)
                {
                    return redirect('/receipt')->with('status', 'Orderan melebihi kapasitas');
                }
                elseif($receipt->stock->status == 0)
                {
                    return redirect('/receipt');
                }
                if($receipt->stock->discount != NULL)
                {
                    if($receipt->stock->wholesale_price != NULL && $receipt->stock->wholesale_quantity != NULL)
                    {
                        if($receipt->quantity >= $receipt->stock->wholesale_quantity)
                        {
                            $price =  ((100-$receipt->stock->discount->percentage) * ($receipt->stock->wholesale_price * $receipt->quantity))/100;
                        }
                        else 
                        {
                            $price =  ((100-$receipt->stock->discount->percentage) * ($receipt->stock->price * $receipt->quantity))/100;
                        }
                    }
                    else 
                    {
                        $price =  ((100-$receipt->stock->discount->percentage) * ($receipt->stock->price * $receipt->quantity))/100;
                    }
                }
                else 
                {
                    if($receipt->stock->wholesale_price != NULL && $receipt->stock->wholesale_quantity != NULL)
                    {
                        if($receipt->quantity >= $receipt->stock->wholesale_quantity)
                        {
                            $price =  $receipt->stock->wholesale_price * $receipt->quantity;
                        }
                        else 
                        {
                            $price = $receipt->stock->price * $receipt->quantity;
                        }
                    }
                    else 
                    {
                        $price = $receipt->stock->price * $receipt->quantity;
                    }
                }

                $total += $price;

                Receipt::where('id', $receipt->id)
                ->update([
                    'price' => $price
                ]);
            }

            $request->validate([
                'id' => 'required',
                'pay' => 'required|integer|min:'.$total
            ]);

            foreach($receipts as $receipt)
            {
                $stock = Stock::find($receipt->stock_id);

                $stock->stock = $stock->stock - $receipt->quantity;

                $stock->save();
            }

            Payment::where('id', $payment->id)
            ->update([
                'total' => $total,
                'status' => 1
            ]);

            $printReceipt = Receipt::where('payment_id', $payment->id)->get();

            $printPayment = Payment::find($payment->id);

            $pay = $request->pay;

            set_time_limit(600);

            $pdf = PDF::loadView('kasir.struk', compact('printPayment', 'printReceipt', 'pay'));
     
            return $pdf->stream('struk.'.$printPayment->id.'.pdf');
        }
        else
        {
            return redirect('/order');
        }
    }

    public function cancel($id)
    {
        $count = Payment::where('status', 0)->where('user_id', Auth::user()->id)->where('id', $id)->first();

        if($count == NULL)
        {
            return redirect('/order');
        }

        Payment::destroy($id);

        return redirect('/order')->with('status', 'Pembelian telah dibatalkan');
    }

    public function invoice(Request $request)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('order');
        }

        $request->validate([
            'start' => 'required|before:finish',
            'finish' => 'required|before:tomorrow',
        ]);

        $payments = Payment::where('status', 1)->where('created_at', '>=' , date('Y-m-d H:i:s', strtotime($request->start)))->where('created_at', '<=' , date('Y-m-d H:i:s', strtotime('+1 day', strtotime($request->finish))))->get();

        set_time_limit(600);

        $pdf = PDF::loadView('kasir.invoice', compact('payments'));
     
        return $pdf->stream('invoice.pdf');
    }
}

