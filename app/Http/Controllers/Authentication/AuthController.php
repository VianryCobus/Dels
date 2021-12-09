<?php

namespace App\Http\Controllers\Authentication;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // public function __construct(){
        
    // }

    public function index(){
        if(session('email')){
            return view('home/index');
        }
        return view('authentication.login');
    }

    public function login(Request $request){
        $data = DB::table('users')
                ->join('dashboard.di_users','users.dashboard_id','=','dashboard.di_users.id')
                ->leftJoin('hris.hris_mstemployees','hris.hris_mstemployees.hrisme_nik','=','dashboard.di_users.id_absensi')
                ->where('dashboard.di_users.uname',$request->username)
                ->first();
        if($data){
            // if(Hash::check($request->password,$data->password)){
            if($request->password == $data->pwd){
                $isadmin = false;
                $isdepthead = false;
                $arrIdDeptAdmin = [1,3];
                if(in_array($data->id_dept,$arrIdDeptAdmin)){
                    $isadmin = true;
                }
                if($data->hrisme_level == 'DEPT. HEAD'){
                    $isdepthead = true;
                }
                session([
                    'name' => $request->username,
                    'email' => (!empty($data->email)) ? $data->email : '-',
                    'isadmin' => $isadmin,
                    'isdepthead' => $isdepthead,
                    'id' => $data->id,
                    'kj' => $data->hrisme_kj,
                    'iddept' => $data->id_dept
                ]);
                return redirect('dashboard');
            }
        }
        session()->flash('error','Username or Password has incorect');
        return redirect('/');
    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/');
    }
}
