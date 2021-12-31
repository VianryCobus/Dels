@extends('layouts_sbadmin2.app')

@section('title','Dashboard Training')
@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('mycss/loading.css') }}">
@endsection
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h2 mb-0 text-monospace font-weight-bolder">Dashboard training</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mb-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <h5 class="h5 text-primary font-weight-bold">Open training</h5>
            <hr class="border border-primary">
        </div>
    </div>

    
    <div class="row mt-2 mb-2">
        <?php $no = 1; ?>
        @forelse ($open as $o)
            @if ($no > 4)
                <?php $no = 1; ?>
            @endif
            <!-- Open Training -->
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 mb-4">
                <div class="card {{ $arrleftborder[$no] }} shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-gray-800 mb-2 card-title">{{ Str::limit($o->category->name,25,'...') }}</div>
                                <div class="card-subtitle font-weight-bold text-primary text-uppercase mb-4">
                                    {{ Str::limit($o->name,35,'...') }}
                                </div>
                                <div class="text-xs font-weight-bolder text-danger text-uppercase d-flex justify-content-center">
                                    [ {{ date('d F Y',strtotime($o->start_date)) }} - {{  date('d F Y',strtotime($o->end_date)) }} ]
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-door-open fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button class="btn btn-success btn-icon-split detail-training" data-toggle="modal" data-target="#Modal" data-url="{{ route('dashtrainings.show',$o->slug) }}">
                            <span class="icon text-white-50">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="text">Open</span>
                        </button>
                    </div>
                </div>
            </div>
            <?php $no++; ?>
        @empty
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 mb-4">
                <div class="alert alert-danger">
                    There is no Training
                </div>
            </div>
        @endforelse
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h5 class="h5 mb-0 text-success font-weight-bold">Ongoing training</h5>
            <hr class="border border-success">
        </div>
    </div>


    <div class="row mt-2 mb-2">
        <?php $no = 1; ?>
        @forelse ($ongoing as $o)
            @if ($no > 4)
                <?php $no = 1; ?>
            @endif
            <!-- Ongoing Training -->
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 mb-4">
                <div class="card {{ $arrleftborder[$no] }} shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-gray-800 mb-2 card-title">{{ Str::limit($o->category->name,25,'...') }}</div>
                                <div class="card-subtitle font-weight-bold text-primary text-uppercase mb-4">
                                    {{ Str::limit($o->name,35,'...') }}
                                </div>
                                <div class="text-xs font-weight-bolder text-danger text-uppercase d-flex justify-content-center">
                                    [ {{ date('d F Y',strtotime($o->start_date)) }} - {{  date('d F Y',strtotime($o->end_date)) }} ]
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-sync fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button class="btn btn-success btn-icon-split detail-training" data-toggle="modal" data-target="#Modal" data-url="{{ route('dashtrainings.show',$o->slug) }}">
                            <span class="icon text-white-50">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="text">Open</span>
                        </button>
                    </div>
                </div>
            </div>
            <?php $no++; ?>
        @empty
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 mb-4">
                <div class="alert alert-danger">
                    There is no Training
                </div>
            </div>
        @endforelse
    </div>

    <!-- Modal -->
    <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="d-flex justify-content-center align-items-center div-loading">
                    <div class="spinner-border text-info" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <form action="{{ route('dashtrainings.store') }}" name="frmDashTraining" autocomplete="off" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title" id="ModalLabel">Dashboard Training</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="form-group col-lg-1 col-2 d-flex justify-content-center align-items-center">
                                    Category
                                </div>
                                <div class="form-group col-lg-1 col-1 font-weight-bold d-flex justify-content-center align-items-center">
                                    :
                                </div>
                                <div class="form-group col-lg-6 col-9">
                                    <input type="text" name="category" id="category" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-1 col-2 d-flex justify-content-center align-items-center">
                                    Name
                                </div>
                                <div class="form-group col-lg-1 col-1 font-weight-bold d-flex justify-content-center align-items-center">
                                    :
                                </div>
                                <div class="form-group col-lg-6 col-9">
                                    <input type="text" name="name" id="name" class="form-control" readonly>
                                </div>
                            </div>
                            @if (!session('isadmin'))
                                <div class="row">
                                    <div class="form-group col-lg-1 d-flex justify-content-center align-items-center">
                                        Training Date
                                    </div>
                                    <div class="form-group col-lg-1 font-weight-bold d-flex justify-content-center align-items-center">
                                        :
                                    </div>
                                    <div class="col-md-4 d-flex justify-content-center align-items-center">
                                        <input type="text" id="start_date_modif" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-1 d-flex justify-content-center align-items-center"> Sampai </div>
                                    <div class="col-md-4 d-flex justify-content-center align-items-center">
                                        <input type="text" id="end_date_modif" class="form-control" readonly>
                                    </div>
                                </div>
                            @endif

                            <div class="row my-3">
                                <ul class="nav nav-pills border border-info p-1" style="border-radius:10px;">
                                    @if (!session('isadmin'))
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#hints" role="tab" data-toggle="tab">Hints</a>
                                        </li>
                                    @else
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#general" role="tab" data-toggle="tab">General</a>
                                        </li>
                                    @endif
                                    @if (session('isadmin'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="#employee" role="tab" data-toggle="tab">Employee</a>
                                        </li>
                                    @endif
                                    <li class="nav-item">
                                        <a class="nav-link" href="#lesson" role="tab" data-toggle="tab">Lesson</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#test" role="tab" data-toggle="tab">Test</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#assignment" role="tab" data-toggle="tab">Assignment</a>
                                    </li>
                                    @if (session('isadmin'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="#result" role="tab" data-toggle="tab">Result</a>
                                        </li>
                                    @endif
                                    @if (session('isadmin'))
                                        <li class="nav-item return_task">
                                            <a class="nav-link" href="#returntask" role="tab" data-toggle="tab">Return Task</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="tab-content my-4 row">
                                @if (!session('isadmin'))
                                    <div id="hints" role="tabpanel" class="tab-pane active col-lg-12 border border-info p-4" style="border-radius:25px;">
                                        <h3 class="mb-2">Instructions for training</h3>
                                        <div class="text-arial">
                                            <ol>
                                                <li>Complete the series of tests according to the specified period</li>
                                                <li>Please complete the pre-test that you can accessed the link in the test tab</li>
                                                <li>The lesson of training can downloaded at the Lesson tab</li>
                                                <li>learn the lesson of training</li>
                                                <li>You can find the link of post test in the Test tab and please complete it</li>
                                                <li>If you had a trouble or any questions, you can contact HR department </li>
                                            </ol>
                                        </div>
                                    </div>
                                @else
                                    <div id="general" role="tabpanel" class="tab-pane active col-lg-8 border border-info p-4" style="border-radius:25px;">
                                        <input type="hidden" name="training_id" id="training_id">
                                        <div class="form-group">
                                            <label for="name">Schedule</label>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input type="text" name="start_date" id="start_date" class="form-control" placeholder="Start Date">
                                                </div>
                                                <div class="col-md-2 d-flex justify-content-center align-items-center"> - </div>
                                                <div class="col-md-5">
                                                    <input type="text" name="end_date" id="end_date" class="form-control" placeholder="End Date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Trainer Name</label>
                                            <input type="text" name="trainer_name" id="trainer_name" class="form-control" placeholder="Please Insert Trainer Name">
                                        </div>
                                    </div>
                                @endif
                                @if (session('isadmin'))
                                    <div id="employee" role="tabpanel" class="tab-pane fade col-lg-12 border border-info p-3" style="border-radius:15px;">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-2 col-6 mb-2 d-flex justify-content-end align-items-center">
                                                    Employee Name
                                                </div>
                                                <div class="col-lg-1 col-1 mb-2 d-flex justify-content-center align-items-center font-weight-bolder">:</div>
                                                <div class="col-lg-9 col-12 d-flex justify-content-center align-items-center">
                                                    <select name="employee[]" id="employee" class="form-control select2" style="width:100%;" multiple>
                                                        @foreach ($employees as $e)
                                                            @if (!empty($e->kj))
                                                                <option value="{{ $e->id }}">{{ $e->nama.'  --  '.$e->dept.'  --  KJ = '.$e->kj }}</option>
                                                            @else
                                                                <option value="{{ $e->id }}">{{ $e->nama.'  --  '.$e->dept }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div id="lesson" role="tabpanel" class="tab-pane fade col-lg-12 border border-info p-3" style="border-radius:15px;">
                                    @if (session('isadmin'))
                                        <div class="form-group" id="section-lesson">
                                            <div class="row">
                                                <div class="col-lg-2 col-12 d-flex justify-content-center align-items-center text-monospace font-weight-bolder">
                                                    Lesson
                                                </div>
                                                <div class="col-lg-9 col-10 d-flex justify-content-center align-items-center">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="lesson[]">
                                                            <label class="custom-file-label" for="inputGroupFile01">Choose File</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 col-2 d-flex justify-content-center align-items-center">
                                                    <button type="button" class="btn btn-success" id="btn-add-lesson">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="section row" id="section-lesson-table">

                                    </div>
                                </div>
                                <div id="test" role="tabpanel" class="tab-pane fade col-lg-12 border border-info p-3" style="border-radius:15px;">
                                    <div class="form-group row">
                                        <div class="col-lg-2 col-12 d-flex justify-content-center align-items-center">
                                            Pretest Link
                                        </div>
                                        <div class="col-lg-9 col-10 d-flex justify-content-center align-items-center">
                                            <input type="text" name="pretest_link" id="pretest_link" class="form-control" placeholder="Insert Pre Test Link" {{ (!session('isadmin'))?"readonly":false }}>
                                        </div>
                                        <div class="col-lg-1 col-2 d-flex justify-content-center align-items-center">
                                            <button type="button" class="btn btn-info btn-go-to" id="pretest_link">
                                                <i class="fas fa-external-link-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-2 col-12 d-flex justify-content-center align-items-center">
                                            Posttest Link
                                        </div>
                                        <div class="col-lg-9 col-10 d-flex justify-content-center align-items-center">
                                            <input type="text" name="posttest_link" id="posttest_link" class="form-control" placeholder="Insert Post Test Link" {{ (!session('isadmin'))?"readonly":false }}>
                                        </div>
                                        <div class="col-lg-1 col-2 d-flex justify-content-center align-items-center">
                                            <button type="button" class="btn btn-info btn-go-to" id="posttest_link">
                                                <i class="fas fa-external-link-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="assignment" role="tabpanel" class="tab-pane fade col-lg-12 border border-info p-3" style="border-radius:15px;">
                                    @if (session('isadmin'))
                                        <div class="form-group" id="section-task-description">
                                            <div class="row">
                                                <div class="col-lg-12 d-flex justify-content-start align-items-center text-monospace font-weight-bold mb-1">
                                                    Please describe the task that will give to the trainees
                                                </div>
                                                <div class="col-lg-12 d-flex justify-content-center align-items-center mb-1">
                                                    <textarea class="form-control" id="task_desc" name="task_desc" rows="3" placeholder="description box..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="section-task">
                                            <div class="row">
                                                <div class="col-lg-2 col-12 d-flex justify-content-center align-items-center text-monospace font-weight-bolder">
                                                    Task
                                                </div>
                                                <div class="col-lg-9 col-10 d-flex justify-content-center align-items-center">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="task[]">
                                                            <label class="custom-file-label" for="inputGroupFile01">Choose File</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 col-2 d-flex justify-content-center align-items-center">
                                                    <button type="button" class="btn btn-success" id="btn-add-task">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="section row" id="section-task-table">

                                    </div>
                                </div>
                                <div id="result" role="tabpanel" class="tab-pane fade col-lg-12 border border-info p-3" style="border-radius:15px;">
                                    <div class="row" id="section-employees-table">
                                        <div class="col-lg-12">
                                            <table class="table table-bordered table-striped table-responsive">
                                                <thead>
                                                    <tr class="table-info">
                                                        <th>No</th>
                                                        <th>Name</th>
                                                        <th>Pretest</th>
                                                        <th>Posttest</th>
                                                        <th>Result</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody-employees-table">
                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="returntask" role="tabpanel" class="tab-pane fade col-lg-12 border border-info p-3" style="border-radius:15px;">
                                    <div class="row" id="section-rt-headers">
                                    </div>
                                    <div class="row" id="section-rt-lines"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-info">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure?');">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('myjs/period_datepicker.js') }}"></script>
    <script src="{{ asset('myjs/lesson_table.js') }}"></script>
    <script src="{{ asset('myjs/task_table.js') }}"></script>
    <script src="{{ asset('myjs/employee_table.js') }}"></script>
    <script src="{{ asset('myjs/loading.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function(){
            // var id for each lesson has added
            let intLesson = 2;
            // var id for each task has added
            let intTask = 2;
            // var for check admin -> val (1 or null)
            const isadmin = "{{ session('isadmin') }}";
            // function for call datepicker
            periodDatepicker();
            $('.select2').select2({
                placeholder: 'Select employee'
            });
            $(".detail-training").on('click',function(e){
                e.preventDefault();
                const url = $(this).data('url');
                // Arr for employee temp
                let ddi = new Array();
                $.ajax({
                    url: url,
                    method:'get',
                    dataType: 'json',
                    timeout: 10000,
                    beforeSend: function(){
                        showLoading();
                    },
                    success: function(result){
                        unshowLoading();
                        $("form[name='frmDashTraining'] #ModalLabel").html('Dashboard Training');
                        // UI components for table lesson
                        if(result.lessons.length > 0){
                            createTableLesson("#section-lesson-table",".tbody-lessontab#idtbody",result.lessons,"{{ route('dashtrainings.index') }}",isadmin);
                        } else{
                            $("#section-lesson-table").html(`
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="alert alert-danger">
                                        There is no data
                                    </div>
                                </div>
                            `);
                        }
                        // UI components for table task
                        if(result.tasks.length > 0){
                            createTableTask("#section-task-table",".tbody-tasktab#idtbody",result.tasks,result.task_user,"{{ route('dashtrainings.index') }}",isadmin);
                        } else{
                            $("#returntask").hide();
                            $(".nav-item.return_task").hide();
                            $("#section-task-table").html(`
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="alert alert-danger">
                                        There is no data
                                    </div>
                                </div>
                            `);
                        }
                        if(isadmin == 1){
                            // UI Components for employees table
                            if(result.employees.length > 0){
                                createTableEmployee("#section-employees-table #tbody-employees-table",result.employees,"{{ route('dashtrainings.index') }}");
                            } else{
                                $("#section-employees-table #tbody-employees-table").empty()
                            }
                            // UI for employee
                            $.each(result.di_users, function(i,e){
                                ddi.push(e.diuser_id);
                            });
                            // $('.select2').val(ddi).trigger('change');
                            $("form[name='frmDashTraining'] #employee").val(ddi).trigger('change');

                            // UI Comopnents for return tasks
                            createOptionTask(result.tasks,'#section-rt-headers');
                        }
                        // UI form general
                        $("form[name='frmDashTraining'] #training_id").val(result.id);
                        $("form[name='frmDashTraining'] #category").val(result.category.name);
                        $("form[name='frmDashTraining'] #name").val(result.name);
                        $("form[name='frmDashTraining'] #start_date").val(result.start_date);
                        $("form[name='frmDashTraining'] #start_date_modif").val(result.start_date_modif);
                        $("form[name='frmDashTraining'] #end_date").val(result.end_date);
                        $("form[name='frmDashTraining'] #end_date_modif").val(result.end_date_modif);
                        $("form[name='frmDashTraining'] #trainer_name").val(result.trainer_name);
                        $("form[name='frmDashTraining'] #status").val(result.status);
                        $("form[name='frmDashTraining'] #pretest_link").val(result.pretest_link);
                        $("form[name='frmDashTraining'] #posttest_link").val(result.posttest_link);
                        if(result.pretest_link == null){
                            $(".btn-go-to#pretest_link").hide();
                        } else{
                            $(".btn-go-to#pretest_link").show();
                        }
                        if(result.posttest_link == null){
                            $(".btn-go-to#posttest_link").hide();
                        } else{
                            $(".btn-go-to#posttest_link").show();
                        }
                        $("form[name='frmDashTraining'] #task_desc").val(result.task_desc);

                        if(isadmin == 1){
                            // make datepicker vaidation start with end date
                            if($( "#start_date" ).val() != ""){
                                $( "#end_date" ).datepicker( "option", "minDate", $.datepicker.parseDate( "yy/mm/dd",  $( "#start_date" ).val() ) );
                            }
                            if($( "#end_date" ).val() != ""){
                                
                                $( "#start_date" ).datepicker( "option", "maxDate", $.datepicker.parseDate( "yy/mm/dd",  $( "#end_date" ).val() ) );
                            }
                        }
                    },
                    error: function (jqXHR, exception) {
                        if (jqXHR.status === 0) {
                            alert('Not connect.\n Verify Network.');
                        } else if (jqXHR.status == 404) {
                            alert('Requested page not found. [404]');
                        } else if (jqXHR.status == 500) {
                            alert('Internal Server Error [500].');
                        } else if (exception === 'parsererror') {
                            alert('Requested JSON parse failed.');
                        } else if (exception === 'timeout') {
                            alert('Time out error.');
                        } else if (exception === 'abort') {
                            alert('Ajax request aborted.');
                        } else {
                            alert('Uncaught Error.\n' + jqXHR.responseText);
                        }
                        unshowLoading();
                    },
                });
            });
            // add lesson component
            $("#btn-add-lesson").on('click',function(e){
                e.preventDefault();
                $("#section-lesson").append(`
                    <div class="row mt-3 components-lesson" id="`+intLesson+`">
                        <div class="col-lg-2 col-12 d-flex justify-content-center align-items-center text-monospace font-weight-bolder">
                            Lesson
                        </div>
                        <div class="col-lg-9 col-10 d-flex justify-content-center align-items-center">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="lesson[]">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose File</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-2 d-flex justify-content-center align-items-center">
                            <button type="button" class="btn btn-danger btn-delete-lesson" id="`+intLesson+`">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                `);
                intLesson++;
            });
            // remove lesson component
            $("#section-lesson").on('click','.btn-delete-lesson',function(e){
                e.preventDefault();
                const id = this.id;
                $(".components-lesson#"+id).remove();
            });
            // script for title file on input file
            $('#section-lesson').on('change','.custom-file-input',function(){
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass('selected').html(fileName);
            });
            // delete lesson file
            $('#section-lesson-table').on('click','.btn-delete-filelesson',function(e){
                e.preventDefault();
                const url = $(this).data('url');
                let token = "{{ csrf_token() }}";
                const training_id = $("form[name=frmDashTraining] #training_id").val();
                const c = confirm('Are you sure to delete this file?');
                if(c){
                    $.ajax({
                        url: url,
                        method: "delete",
                        datatype: "json",
                        data:{
                            "_token" : token
                        },
                        beforeSend: () => {
                            $("body").css("cursor","wait");
                        },
                        success: function(result){
                            if(result){
                                const urlshow = "{{ route('dashtrainings.index') }}/"+training_id+"/showlesson";
                                $.ajax({
                                    url: urlshow,
                                    method: "get",
                                    datatype: "json",
                                    success: function(result){
                                        $("body").css("cursor","default");
                                        // UI components for table lesson
                                        if(result.lessons.length > 0){
                                            createTableLesson("#section-lesson-table",".tbody-lessontab#idtbody",result.lessons,"{{ route('dashtrainings.index') }}",isadmin);
                                        } else{
                                            $("#section-lesson-table").empty();
                                        }
                                    }
                                });
                            } else{
                                $("body").css("cursor","default");
                                alert('Failed delete file lesson');
                            }
                        }
                    });
                }
            });
            // download lesson file
            $('#section-lesson-table').on('click','.btn-download-filelesson',function(e){
                e.preventDefault();
                const url = $(this).data('url');
                window.open(url);
            });

            // add task component
            $("#btn-add-task").on('click',function(e){
                e.preventDefault();
                $("#section-task").append(`
                    <div class="row mt-3 components-task" id="`+intTask+`">
                        <div class="col-lg-2 col-12 d-flex justify-content-center align-items-center text-monospace font-weight-bolder">
                            Task
                        </div>
                        <div class="col-lg-9 col-10 d-flex justify-content-center align-items-center">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="task[]">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose File</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-2 d-flex justify-content-center align-items-center">
                            <button type="button" class="btn btn-danger btn-delete-task" id="`+intTask+`">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                `);
                intTask++;
            });
            // remove task component
            $("#section-task").on('click','.btn-delete-task',function(e){
                e.preventDefault();
                const id = this.id;
                $(".components-task#"+id).remove();
            });
            // script for title file on input file
            $('#section-task').on('change','.custom-file-input',function(){
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass('selected').html(fileName);
            });
            // delete task file
            $('#section-task-table').on('click','.btn-delete-filetask',function(e){
                e.preventDefault();
                const url = $(this).data('url');
                let token = "{{ csrf_token() }}";
                const training_id = $("form[name=frmDashTraining] #training_id").val();
                const c = confirm('Are you sure to delete this file?');
                if(c){
                    $.ajax({
                        url: url,
                        method: "delete",
                        datatype: "json",
                        data:{
                            "_token" : token
                        },
                        beforeSend: () => {
                            $("body").css("cursor","wait");
                        },
                        success: function(result){
                            if(result){
                                const urlshow = "{{ route('dashtrainings.index') }}/"+training_id+"/showTask";
                                $.ajax({
                                    url: urlshow,
                                    method: "get",
                                    datatype: "json",
                                    success: function(result){
                                        $("body").css("cursor","default");
                                        // UI components for table task
                                        if(result.tasks.length > 0){
                                            createTableTask("#section-task-table",".tbody-tasktab#idtbody",result.tasks,"{{ route('dashtrainings.index') }}",isadmin);
                                        } else{
                                            $("#section-task-table").empty();
                                        }
                                    }
                                });
                            } else{
                                $("body").css("cursor","default");
                                alert('Failed delete file task');
                            }
                        }
                    });
                }
            });
            // download task file
            $('#section-task-table').on('click','.btn-download-filetask',function(e){
                e.preventDefault();
                const url = $(this).data('url');
                window.open(url);
            });
            // download return task file (user)
            $('#section-task-table').on('click','.btn-download-filereturntask',function(e){
                e.preventDefault();
                const url = $(this).data('url');
                window.open(url);
            });

            // delete employees
            $("#tbody-employees-table").on('click','.delete-employee',function(e){
                e.preventDefault();
                const url = $(this).data('url');
                let token = "{{ csrf_token() }}";
                // Arr for employee temp
                let ddi = new Array();
                const training_id = $("form[name=frmDashTraining] #training_id").val();
                const c = confirm('Are you sure to remove this employee?');
                if(c){
                    $.ajax({
                        url: url,
                        method: "delete",
                        datatype: "json",
                        data:{
                            "_token" : token
                        },
                        success: function(result){
                            if(result){
                                const urlshow = "{{ route('dashtrainings.index') }}/"+training_id+"/showemployee";
                                $.ajax({
                                    url: urlshow,
                                    method: "get",
                                    datatype: "json",
                                    success: function(result){
                                        // UI Components for employees table
                                        if(result.employees.length > 0){
                                            createTableEmployee("#section-employees-table #tbody-employees-table",result.employees,"{{ route('dashtrainings.index') }}");
                                        } else{
                                            $("#section-employees-table #tbody-employees-table").empty()
                                        }

                                        // UI for employee
                                        $.each(result.di_users, function(i,e){
                                            ddi.push(e.diuser_id);
                                        });
                                        $("form[name='frmDashTraining'] #employee").val(ddi).trigger('change');
                                    }
                                });
                            } else{
                                alert('Failed delete file task');
                            }
                        }
                    });
                }
            });

            
            // Open link Post and Pre Test
            $(".btn-go-to").on('click',function(e){
                e.preventDefault();
                const id = this.id;
                let link = "";
                if(id == "pretest_link"){
                    link = $("form[name='frmDashTraining'] #pretest_link").val();
                } else if(id == "posttest_link"){
                    link = $("form[name='frmDashTraining'] #posttest_link").val();
                }
                window.open(link);
            });

            // change optiontasks on return task section
            $("#returntask").on('change','#optiontasks',function(e){
                e.preventDefault();
                const idrt = $(this).val();
                const prefix = "{{ route('dashtrainings.index') }}";
                const urlx = `${prefix}/${idrt}/datareturntask`;
                if(idrt != ""){
                    $.ajax({
                        url: urlx,
                        method: 'get',
                        dataType: 'json',
                        beforeSend: () => {
                            $("#section-rt-lines").html(`<div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <div class="spinner-grow text-danger" style="width: 3rem; height: 3rem;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>`);
                        },
                        success: result => createTableReturnTask(result.returntask,"#section-rt-lines",prefix)
                    });
                }
            });

            // download return task file (admin)
            $('#returntask').on('click','.btn-download-filereturntask',function(e){
                e.preventDefault();
                const url = $(this).data('url');
                window.open(url);
            });

            // change cursor while submit form dashboard
            $("form[name='frmDashTraining']").on('submit',function(){
                $("body").css("cursor","wait");
            });
        });
    </script>
@endsection