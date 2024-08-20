<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthManager extends Controller
{
    function login(){
        if(Auth::check()){
            return redirect(route('home'));
        }
        return view('login');
    }

    function registration(){
        if(Auth::check()){
            return redirect(route('home'));
        }
        return view('registration');
    }

    function LoginPost(request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $crediantials = $request->only('email', 'password');
        if(Auth::attempt($crediantials)){
            return redirect()->intended(route(name:'home' ));
        }
        
        return redirect(route('login'))->with("error", "login details are not valid");
    }

    function registrationPost(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        if(!$user){
            return redirect(route('registration'))->with("error", "Registration failed, try again.");
        }

        return redirect(route('login'))->with("success", "Registration successful, login to accsess the app.");
    }

    function logout(){
        session()->flush();
        Auth::logout();
        return redirect(route('login'));
    }

    function data(Request $request){
    $query = $request->input('search');
    
    $pegawai = Pegawai::when($query, function($queryBuilder) use ($query) {
        return $queryBuilder->where('nama', 'like', "%{$query}%")
                            ->orWhere('alamat', 'like', "%{$query}%")
                            ->orWhere('nohp', 'like', "%{$query}%")
                            ->orWhere('birthday', 'like', "%{$query}%");
                            

    })->get();
    
    return view('pegawai.data', compact('pegawai'));
    }


  function sort(request $request){
    isset($sort) ? $sort : 'asc' ;
  }

    
    function temp(Request $request){
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nohp' => 'required|numeric|min:0',
            'birthday' => 'required|string|max:255',
       
        ]);

        pegawai::create($request->all());

        return redirect()->route('pegawai.data')->with('success', 'Tambah pegawai sukses.');
    }
    function edit(Request $request, pegawai $pegawai){
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nohp' => 'required|numeric|min:0',
            'birthday' => 'required|string|max:255',
 
        ]);

        $pegawai->update($request->all());

        return redirect()->route('pegawai.data')->with('success', 'Update pegawai sukses.');
    }

    function delete(pegawai $pegawai){
        $pegawai->delete();
        return redirect()->route('pegawai.data')->with('success', 'Hapus pegawai sukses');
    }


}

