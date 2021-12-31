<?php

namespace App\Http\Controllers;

use App\Http\Requests\DashboardtrainingRequest;
use App\{User,Training};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashtrainingController extends Controller
{
    public function index()
    {
        $employees = User::UsersDashboard();
        $employees = collect($employees);
        $arrleftborder = collect([
            '1' => 'border-left-primary',
            '2' => 'border-left-success',
            '3' => 'border-left-info',
            '4' => 'border-left-warning',
        ]);
        if(session('isadmin')) :
            $open = Training::whereDate('start_date','>',date('Y/m/d'))->where('status','1')->get();
            $ongoing = Training::whereDate('start_date','<=',date('Y/m/d'))
                        ->whereDate('end_date','>=',date('Y/m/d'))
                        ->where('status','1')->get();
        else :
            $arrTraining = [];
            $trainings = DB::table('diuser_training')
                        ->select('training_id')
                        ->where('diuser_id',session('id'))
                        ->get();
            foreach ($trainings as $value) {
                $arrTraining[] = $value->training_id;   
            }
            $open = Training::whereDate('start_date','>',date('Y/m/d'))
                    ->where('status','1')
                    ->whereIn('id', $arrTraining)
                    ->get();
            $ongoing = Training::whereDate('start_date','<=',date('Y/m/d'))
                    ->whereDate('end_date','>=',date('Y/m/d'))
                    ->whereIn('id', $arrTraining)
                    ->where('status','1')->get();
        endif;
        return view('dashtrainings.index',[
            'arrleftborder' => $arrleftborder,
            'open' => $open,
            'ongoing' => $ongoing,
            'employees' => $employees
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {   
        if(session('isadmin')):
            $request->validate([
                'start_date' => 'required',
                'end_date' => 'required',
                'trainer_name' => 'required',
                'employee' => 'required',
                'lesson' => 'max:20480',
                'task' => 'max:20480'
            ]);

            // TASK IN TRAINING ==============================================================
            if($request->file('task')) :
                $tasks = [];
                foreach ($request->file('task') as $value) {
                    // var date for make name of file is unique
                    $dates = date('YmdHis');
                    // $urlfile = $value->store("dashtraining/task");
                    $urlfile = $value->storeAs("dashtraining/task","{$dates}_{$value->getClientOriginalName()}");
                    $tasks[] = [
                        'training_id' => $request->training_id,
                        'task' => $value->getClientOriginalName(),
                        'slug' => $urlfile,
                    ];
                }
                $instask = DB::table('task_training')->insert($tasks);
            else :
                $instask = true;
            endif;

            if($instask) :
                // LESSON IN TRAINING ==============================================================
                if($request->file('lesson')) :
                    $lessons = [];
                    foreach ($request->file('lesson') as $value) {
                        // var date for make name of file is unique
                        $dates = date('YmdHis');
                        // $urlfile = $value->store("dashtraining/lesson");
                        $urlfile = $value->storeAs("dashtraining/lesson","{$dates}_{$value->getClientOriginalName()}");
                        $lessons[] = [
                            'training_id' => $request->training_id,
                            'lesson' => $value->getClientOriginalName(),
                            'slug' => $urlfile,
                        ];
                    }
                    $insless = DB::table('lesson_training')->insert($lessons);
                else :
                    $insless = true;
                endif;
                if($insless) :
                    // EMPLOYEE IN TRAINING ==============================================================
                    // collect employee data
                    $employee = $request->employee;
                    $diuser = [];
                    foreach ($employee as $e) :
                        $diuser[] = [
                            'diuser_id' => $e,
                            'training_id' => $request->training_id,
                            'pretest' => (isset($request->pretest[$e]))?$request->pretest[$e]:'',
                            'posttest' => (isset($request->posttest[$e]))?$request->posttest[$e]:'',
                            'final_value' => (isset($request->final_value[$e]))?$request->final_value[$e]:'',
                        ];
                    endforeach;
                    // action delete employee in training
                    $deldis = DB::table('diuser_training')
                                ->where('training_id', $request->training_id)
                                ->delete();
                    // action insert employee in training
                    // if($deldis) :
                        $insdis = DB::table('diuser_training')->insert($diuser);

                        if($insdis){
                            // TRAINING ==============================================================
                            // action update data training
                            $attr['start_date'] = $request->start_date;
                            $attr['end_date'] = $request->end_date;
                            $attr['trainer_name'] = $request->trainer_name;
                            $attr['pretest_link'] = $request->pretest_link;
                            $attr['posttest_link'] = $request->posttest_link;
                            $attr['task_desc'] = $request->task_desc;
                            $upd = Training::where('id',$request->training_id)
                                    ->update($attr);
                    
                            if($upd) : 
                                session()->flash('success', 'The Dashboard training was Updated');
                            else :
                                session()->flash('error', 'The Updated action for Dashboard training was failed');
                            endif;
                        } else{
                            session()->flash('error', 'Failed insert employee data');
                        }
                    // else :
                    //     session()->flash('error', 'Failed update data employee on training');
                    // endif;
                else :
                    session()->flash('error', 'Failed insert lesson file');
                endif;
            else :
                session()->flash('error', 'Failed insert task file');
            endif;
        else :
            // RETURN FILE TASK IN TRAINING ==============================================================
            if($request->file('return_task')):
                $return_tasks = [];
                foreach ($request->file('return_task') as $key => $value) {
                    // Action Delete if data exist
                    $taskreturn = DB::table('task_training_return')
                    ->where([
                        ['task_id','=',$key],
                        ['diuser_id','=',session('id')]
                    ])
                    ->count();
                    if($taskreturn > 0) :
                        $taskreturn = DB::table('task_training_return')
                                    ->where([
                                        ['task_id','=',$key],
                                        ['diuser_id','=',session('id')]
                                    ])
                                    ->first();
                        Storage::delete($taskreturn->slug);
                    endif;
                    $actdel = DB::table('task_training_return')
                                    ->where([
                                        ['task_id','=',$key],
                                        ['diuser_id','=',session('id')]
                                    ])
                                    ->delete();
                    // Action Insert
                    $urlfile = $value->store("dashtraining/return_task");
                    $return_tasks[] = [
                        'task_id' => $key,
                        'return_task' => $value->getClientOriginalName(),
                        'slug' => $urlfile,
                        'diuser_id' => session('id'),
                        'created_at' => date('Y/m/d')
                    ];
                }
                $insret = DB::table('task_training_return')->insert($return_tasks);
                if($insret) :
                    session()->flash('success', 'The Dashboard training was Updated');
                else :
                    session()->flash('error', 'Failed insert return task file');
                endif;
            endif;
        endif;
        
        
        // return back();
        return redirect('dashtraining');
    }

    public function show(Training $training)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    // FILE LESSON
    public function deleteLesson($id){
        $lesson = DB::table('lesson_training')
        ->where('id',$id)
        ->first();
        $actdelfile = Storage::delete($lesson->slug);
        if($actdelfile) :
            $actdel = DB::table('lesson_training')
                            ->where('id', $id)
                            ->delete();
            if($actdel) :
                return true;
            else :
                return false;
            endif;
        else:
            return false;
        endif;
    }

    public function showLesson($id){
        $training['lessons'] = DB::table('lesson_training')
                            ->where('training_id',$id)
                            ->get();
        return $training;
    }
    
    public function downloadLesson($id){
        $lesson = DB::table('lesson_training')
        ->where('id',$id)
        ->first();
        return Storage::download($lesson->slug);
    }

    // FILE TASK
    public function deleteTask($id){
        $task = DB::table('task_training')
        ->where('id',$id)
        ->first();
        $actdelfile = Storage::delete($task->slug);
        if($actdelfile) :
            $actdel = DB::table('task_training')
                            ->where('id', $id)
                            ->delete();
            if($actdel) :
                return true;
            else :
                return false;
            endif;
        else:
            return false;
        endif;
    }

    public function showTask($id){
        $training['tasks'] = DB::table('task_training')
                            ->where('training_id',$id)
                            ->get();
        return $training;
    }
    
    public function downloadTask($id){
        $task = DB::table('task_training')
        ->where('id',$id)
        ->first();
        return Storage::download($task->slug);
    }

    public function downloadReturnTask($id){
        $taskreturn = DB::table('task_training_return')
        ->where('id',$id)
        ->first();
        return Storage::download($taskreturn->slug);
    }

    public function dataReturnTask($id){
        $training['returntask'] = DB::table('task_training_return')
                                ->join('dashboard.di_users','task_training_return.diuser_id','=','dashboard.di_users.id')
                                ->select(
                                    'dashboard.di_users.fname',
                                    'task_training_return.id',
                                    'task_training_return.return_task'
                                )
                                ->where('task_training_return.task_id',$id)
                                ->get();
        return $training;
    }

    // EMPLOYEE
    public function deleteEmployee($diuser_id,$training_id){
        $actdel = DB::table('diuser_training')
                        ->where([
                            ['diuser_id', $diuser_id],
                            ['training_id', $training_id],
                        ])
                        ->delete();
        if($actdel) :
            return true;
        else :
            return false;
        endif;
    }

    public function showEmployee($id){
        $training['employees'] = DB::table('diuser_training')
                                ->join('dashboard.di_users','diuser_training.diuser_id','=','dashboard.di_users.id')
                                ->select(
                                    'dashboard.di_users.fname',
                                    'diuser_training.diuser_id',
                                    'diuser_training.pretest',
                                    'diuser_training.posttest',
                                    'diuser_training.final_value',
                                    'diuser_training.training_id'
                                )
                                ->where('training_id', $id)
                                ->orderBy('fname','asc')
                                ->get();
        $training['di_users'] = DB::table('diuser_training')
                                ->select('diuser_id')
                                ->where('training_id', $id)
                                ->get();
        return $training;
    }
}
