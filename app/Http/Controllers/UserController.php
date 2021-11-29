<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrIdDeptAdmin = [1,3];
        $usersdels = User::usersDels();
        $employees = User::UsersDashboard();
        return view('user.index',compact('usersdels','employees','arrIdDeptAdmin'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee' => 'required'
        ]);

        $cek = DB::table('users')
                ->where('dashboard_id',$request->employee)
                ->exists();
        if($cek) :
            session()->flash('error','User is exist');
        else :
            $data = DB::table('dashboard.di_users')
                ->where('dashboard.di_users.id',$request->employee)
                ->first();
            $attr = [
                'name' => $data->fname,
                'email' => (!empty($data->email)) ? $data->email : '-',
                'password' => bcrypt($data->pwd),
                'remember_token' => Str::random(50),
                'dashboard_id' => $data->id
            ];
            $act = User::create($attr);
            if($act) :
                session()->flash('success','User was created');
            else:
                session()->flash('error','User wasn\'t created');
            endif;
        endif;

        return redirect('users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $actdel = DB::table('users')
                ->where('id', $id)
                ->delete();
        if($actdel) :
            session()->flash('success', 'User Was Deleted');
        else :
            session()->flash('error','User Wasn\'t Deleted');
        endif;

        return redirect('users');
    }
}
