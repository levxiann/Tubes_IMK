<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        session()->put('menu','order');

        return redirect('/order');
    }

    public function kasir()
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','kasir');

        $kasirs = User::all();

        return view('kasir.kasir', compact('kasirs'));
    }

    public function search(Request $request)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','kasir');

        $kasirs = User::where('name', 'like', "%".$request->keyword."%")->orWhere('email', 'like', "%".$request->keyword."%")->get();

        return view('kasir.kasir', compact('kasirs'));
    }

    public function getKasir(Request $request)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','kasir');

        $kasir = User::find($request->id);
        
        echo json_encode($kasir);
    }

    public function store(Request $request)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','kasir');

        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|max:255|email:rfc,dns|unique:users',
            'password' => 'required|string'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect('/kasir')->with('status', 'Kasir berhasil ditambah');
    }

    public function update(Request $request)
    {
        if(Auth::user()->level != 1)
        {
            return redirect('/order');
        }

        session()->put('menu','kasir');

        $user = User::findOrFail($request->id);

        $request->validate([
            'name' => 'required|string|max:255|unique:users,name,'.$user->id,
            'email' => 'required|string|max:255|email:rfc,dns|unique:users,email,'.$user->id,
        ]);

        User::where('id', $user->id)
        ->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if($request->password != NULL)
        {
            User::where('id', $user->id)
            ->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect('/kasir')->with('status', 'Akun berhasil diedit');
    }

    public function destroy($id)
    {
        User::destroy($id);

        return redirect('/kasir')->with('status', 'Akun berhasil dihapus');
    }
}
