<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','dashboard_id','remember_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['diuser'];

    public function diuser(){
        return $this->belongsTo(DiUser::class,'dashboard_id');
    }

    public function scopeUsersDels(){
        $usersdels = DB::table('users')
                    ->join('dashboard.di_users','users.dashboard_id','=','dashboard.di_users.id')
                    ->leftJoin('hris.hris_mstemployees','hris.hris_mstemployees.hrisme_nik','=','dashboard.di_users.id_absensi')
                    ->join('hris.hris_master_department','dashboard.di_users.id_dept','=','hris.hris_master_department.hrismd_id')
                    ->select(
                        'users.id',
                        'dashboard.di_users.fname',
                        'dashboard.di_users.auth',
                        'hris.hris_mstemployees.hrisme_kj',
                        'hris.hris_master_department.hrismd_namadept',
                        'dashboard.di_users.id_dept'
                    )
                    ->where('dashboard.di_users.kategori','DAW')
                    ->whereNotIn('dashboard.di_users.id_dept',[
                        '20',
                        '21',
                        '22',
                        '23'
                    ])
                    ->orderBy('dashboard.di_users.fname','asc')
                    ->paginate(10);
        return $usersdels;
    }

    public function scopeUsersDashboard(){
        $usersdashboard = DB::select("select 
                                        diu.id,
                                        id_absensi nik,
                                        fname nama,
                                        decode(hrisme_nik,'','HARIAN',hrisme_statuskerja) status_karyawan,
                                        hrisme_kj KJ,
                                        hrisme_gol gol,
                                        decode(email, '', hrisme_email, email) email,
                                        hrismd_namadept dept
                                    from 
                                        di_users diu
                                        left join hris_mstemployees on hrisme_nik=id_absensi,
                                        hris_master_department hrismd
                                    where
                                    id_dept=hrismd.hrismd_id
                                    and kategori='DAW'
                                    and id_dept not in (20,21,22,23)
                                    ORDER BY fname ASC");
        return $usersdashboard;
    }
}
