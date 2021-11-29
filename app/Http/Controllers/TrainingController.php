<?php

namespace App\Http\Controllers;

use App\{Category,Training};
use App\Http\Requests\TrainingRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrstts = [
            '0' => 'Close',
            '1' => 'Open',
        ];
        return view('trainings.index', [
            'trainings' => Training::latest()->paginate(10),
            'categories' => Category::where('status','1')->get(),
            'arrstts' => $arrstts,
            'request' => []
        ]);
    }
    public function search(Request $request)
    {
        $arrstts = [
            '0' => 'Close',
            '1' => 'Open',
        ];
        $queryextra = "";
        if($request->filtername) :
            $queryextra .= "UPPER(name) LIKE '%" . strtoupper($request->filtername) . "%' AND ";
        endif;

        if($request->filtercategory):
            $queryextra .= "category_id = '".$request->filtercategory."' AND ";
        endif;

        if($request->filtertrainer) :
            $queryextra .= "UPPER(trainer_name) LIKE '%" . strtoupper($request->filtertrainer) . "%' AND ";
        endif;

        $queryextra = substr($queryextra,0,strlen($queryextra) - 4);

        if(!empty($queryextra)):
            $trainings = Training::whereRaw($queryextra)->paginate(10);
        else:
            $trainings = Training::latest()->paginate(10);
        endif;
        return view('trainings.index', [
            'trainings' => $trainings,
            'categories' => Category::where('status','1')->get(),
            'arrstts' => $arrstts,
            'request' => $request
        ]);
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
    public function store(TrainingRequest $request)
    {
        $attr = $request->all();
        // dd($attr);
        $attr['slug'] = Str::slug($request->name);
        $attr['category_id'] = $request->category;
        $act = Training::create($attr);
        if($act) :
            session()->flash('success','Training was created');
        else:
            session()->flash('error','Training wasn\'t created');
        endif;

        return redirect('trainings');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function show(Training $training)
    {
        $arrtask_user = [];
        if(!session('isadmin')) :
            $datatask_user = DB::table('task_training')
                            ->leftJoin('task_training_return','task_training_return.task_id','=','task_training.id')
                            ->select(
                                'task_training.id',
                                'task_training_return.id as id_ttr',
                                'task_training_return.return_task'
                            )
                            ->where([
                                ['task_training.training_id','=',$training->id],
                                ['task_training_return.diuser_id','=',session('id')]
                            ])
                            ->get();
            // dd($datatask_user);
            if(count($datatask_user) > 0) :
                foreach ($datatask_user as $value) {
                    $arrtask_user['return'][$value->id] = $value->return_task;
                    $arrtask_user['id_ttr'][$value->id] = $value->id_ttr;
                }
            else :
                $arrtask_user['return'] = [];
                $arrtask_user['id_ttr'] = [];
            endif;
        endif;
        $training['start_date'] = date('Y/m/d',strtotime($training->start_date));
        $training['end_date'] = date('Y/m/d',strtotime($training->end_date));
        // field for employees
        $training['start_date_modif'] = date('d F Y',strtotime($training->start_date));
        $training['end_date_modif'] = date('d F Y',strtotime($training->end_date));
        // =======================
        $training['di_users'] = DB::table('diuser_training')
                                ->select('diuser_id')
                                ->where('training_id', $training->id)
                                ->get();
        $training['lessons'] = DB::table('lesson_training')
                            ->where('training_id',$training->id)
                            ->get();
        $training['tasks'] = DB::table('task_training')
                            ->where('training_id',$training->id)
                            ->get();
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
                            ->where('training_id', $training->id)
                            ->orderBy('fname','asc')
                            ->get();
        $training['task_user'] = $arrtask_user;
        return $training;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function edit(Training $training)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function update(TrainingRequest $request, Training $training)
    {
        $attr = $request->all();
        $attr['category_id'] = $request->category;
        $act = $training->update($attr);
        if($act) : 
            session()->flash('success', 'The Training was Updated');
        else :
            session()->flash('error', 'The Updated action for Training was failed');
        endif;

        // return back();
        return redirect('trainings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function destroy(Training $training)
    {
        $act = $training->delete();
        if($act) :
            session()->flash('success', 'The Training Was Deleted');
        else :
            session()->flash('error','Training Wasn\'t Deleted');
        endif;

        return redirect('trainings');
    }
}
