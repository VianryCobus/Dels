<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $reports = DB::table('users')
        //             ->join('dashboard.di_users','users.dashboard_id','=','dashboard.di_users.id')
        //             ->leftJoin('hris.hris_mstemployees','hris.hris_mstemployees.hrisme_nik','=','dashboard.di_users.id_absensi')
        //             ->join('hris.hris_master_department','dashboard.di_users.id_dept','=','hris.hris_master_department.hrismd_id')
        //             ->join('diuser_training','dashboard.di_users.id','=','diuser_training.diuser_id')
        //             ->join('trainings','diuser_training.training_id','=','trainings.id')
        //             ->join('categories','trainings.category_id','=','categories.id')
        //             ->select(
        //                 'users.id',
        //                 'dashboard.di_users.fname',
        //                 'hris.hris_mstemployees.hrisme_kj',
        //                 'hris.hris_master_department.hrismd_namadept',
        //                 'trainings.name as training_name',
        //                 'trainings.start_date',
        //                 'trainings.end_date',
        //                 'categories.name as category_name',
        //                 'diuser_training.final_value'
        //             )
        //             ->where('dashboard.di_users.kategori','DAW')
        //             ->whereNotIn('dashboard.di_users.id_dept',[
        //                 '20',
        //                 '21',
        //                 '22',
        //                 '23'
        //             ])
        //             ->orderBy('dashboard.di_users.fname','asc')
        //             ->paginate(10);
        $reports = [];
        $request = [];
        // Option value departments
        if(session('isdepthead')) :
            $departments = DB::table('hris.hris_master_department')
                        ->where('hrismd_id',session('iddept'))
                        ->get();
        else :
            if(session('isadmin')) :
                $departments = DB::table('hris.hris_master_department')
                            ->whereNotIn('hrismd_id',[
                                '20',
                                '21',
                                '22',
                                '23'
                            ])->orderBy('hrismd_namadept','asc')
                            ->get();
            else :
                $departments = DB::table('hris.hris_master_department')
                        ->where('hrismd_id',session('iddept'))
                        ->get();
            endif;
        endif;
        // Option value KJ
        if(session('isadmin')) :
            $kj = DB::table('hris.hris_mstemployees')
            ->select('hrisme_kj')
            ->distinct()
            ->orderBy('hrisme_kj','asc')
            ->get();
        else :
            $kj = DB::table('hris.hris_mstemployees')
            ->select('hrisme_kj')
            ->distinct()
            ->where('hrisme_kj',session('kj'))
            ->get();
        endif;
        
        $categories = Category::where('status',1)->orderBy('name','asc')->get();
        $paginate = false;
        return view('reports.index',compact('reports','categories','departments','kj','paginate','request'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required'
        ]);
        $queryextra = "";
        if($request->departments){
            $queryextra .= " and id_dept = ".$request->departments;
        }
        if($request->kj){
            $queryextra .= " and hrisme_kj = ".$request->kj;
        }
        if($request->categories){
            $queryextra .= " and categories.id = ".$request->categories;
        }
        if($request->start_date && $request->end_date){
            $queryextra .= " and trunc(trainings.start_date) BETWEEN TO_DATE('".$request->start_date."','YYYY/MM/DD') AND TO_DATE('".$request->end_date."','YYYY/MM/DD') ";
        }
        $reports = DB::select("select 
                                    fname,
                                    hrisme_kj,
                                    hrismd_namadept,
                                    users.id,
                                    trainings.name as training_name,
                                    trainings.start_date,
                                    trainings.end_date,
                                    categories.name as category_name,
                                    diuser_training.final_value
                                from 
                                    users join di_users on users.dashboard_id = di_users.id
                                    left join hris_mstemployees on hrisme_nik=id_absensi
                                    join hris_master_department hrismd on id_dept=hrismd.hrismd_id
                                    join diuser_training on di_users.id = diuser_training.diuser_id
                                    join trainings on diuser_training.training_id = trainings.id
                                    join categories on trainings.category_id = categories.id
                                where
                                kategori='DAW'
                                and id_dept not in (20,21,22,23)
                                ".$queryextra."
                                ORDER BY fname ASC");
        // Option value departments
        if(session('isdepthead')) :
            $departments = DB::table('hris.hris_master_department')
                        ->where('hrismd_id',session('iddept'))
                        ->get();
        else :
            if(session('isadmin')) :
                $departments = DB::table('hris.hris_master_department')
                            ->whereNotIn('hrismd_id',[
                                '20',
                                '21',
                                '22',
                                '23'
                            ])->orderBy('hrismd_namadept','asc')
                            ->get();
            else :
                $departments = DB::table('hris.hris_master_department')
                        ->where('hrismd_id',session('iddept'))
                        ->get();
            endif;
        endif;
        // Option value KJ
        if(session('isadmin')) :
            $kj = DB::table('hris.hris_mstemployees')
            ->select('hrisme_kj')
            ->distinct()
            ->orderBy('hrisme_kj','asc')
            ->get();
        else :
            $kj = DB::table('hris.hris_mstemployees')
            ->select('hrisme_kj')
            ->distinct()
            ->where('hrisme_kj',session('kj'))
            ->get();
        endif;
        $categories = Category::where('status',1)->orderBy('name','asc')->get();
        $paginate = false;
        return view('reports.index',compact('reports','categories','departments','kj','paginate','request'));
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
        //
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
        //
    }
}
