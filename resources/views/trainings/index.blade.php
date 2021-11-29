@extends('layouts_sbadmin2.app')

@section('title','Training List')
@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Filter Training</h6>
                </div>
                <div class="card_body">
                    <form name="frmFilterTraining" action="{{ route('trainings.search') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="row my-3">
                            <div class="col-md-3 d-flex justify-content-end align-items-center font-weight-bolder text-monospace">
                                Training Name
                            </div>
                            <div class="col-md-1 d-flex justify-content-center align-items-center">
                                <strong>:</strong>
                            </div>
                            <div class="col-md-6 d-flex justify-content-center align-items-center">
                                <input type="text" name="filtername" id="filtername" class="form-control" placeholder="Training Name"
                                    @if(!empty($request['filtername']))
                                        value="{{ $request['filtername'] }}"
                                    @endif;
                                >
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-md-3 d-flex justify-content-end align-items-center font-weight-bolder text-monospace">
                                Trainer Name
                            </div>
                            <div class="col-md-1 d-flex justify-content-center align-items-center">
                                <strong>:</strong>
                            </div>
                            <div class="col-md-6 d-flex justify-content-center align-items-center">
                                <input type="text" name="filtertrainer" id="filtertrainer" class="form-control" placeholder="Trainer Name"
                                    @if(!empty($request['filtertrainer']))
                                        value="{{ $request['filtertrainer'] }}"
                                    @endif;
                                >
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-md-3 d-flex justify-content-end align-items-center font-weight-bolder text-monospace">
                                Category
                            </div>
                            <div class="col-md-1 d-flex justify-content-center align-items-center">
                                <strong>:</strong>
                            </div>
                            <div class="col-md-6 d-flex justify-content-center align-items-center">
                                <select name="filtercategory" id="filtercategory" class="form-control">
                                    <option value="">Choose One!</option>
                                    @foreach ($categories as $c)
                                        <option value="{{ $c->id }}"
                                            @if (!empty($request['filtercategory']))
                                                @if($c->id == $request['filtercategory']))
                                                    selected
                                                @endif;
                                            @endif
                                        >{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-md-3 d-flex justify-content-end align-items-center">
                            </div>
                            <div class="col-md-1 d-flex justify-content-center align-items-center">
                            </div>
                            <div class="col-md-7 d-flex justify-content-start align-items-center">
                                <button type="submit" class="btn btn-info">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Training List</h6>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-md-4">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary add-training" data-toggle="modal" data-target="#tcModal" data-route="{{ route('trainings.store') }}">
                        + Training
                    </button>
                </div>
            </div>
            <div class="table-responsive my-3">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Trainer</th>
                            <th>Category</th>
                            <th>Schedule</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @forelse ($trainings as $t)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $t->name }}</td>
                                <td>{{ $t->trainer_name }}</td>
                                <td>{{ $t->category->name }}</td>
                                <td>{{ date('d F Y',strtotime($t->start_date)) }} - {{  date('d F Y',strtotime($t->end_date)) }}</td>
                                <td>
                                    <span class="badge 
                                    {{ ($t->status == 0) ? 'badge-danger':'badge-success' }}">
                                        {{ ($t->status == 1) ? 'Open' : 'Close' }}
                                    </span>
                                </td>
                                <td>
                                    <center>
                                        <i style="cursor:pointer;" class="fas fa-edit edit-training" data-url="{{ route('trainings.show',$t->slug) }}" data-route="{{ route('trainings.update',$t->slug) }}" data-toggle="modal" data-target="#tcModal"></i>
                                        <i style="cursor:pointer;" class="fas fa-trash delete-training" data-route="{{ route('trainings.destroy',$t->slug) }}" data-toggle="modal" data-target="#tcModalDelete"></i>
                                    </center>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="alert alert-danger">
                                        There is no Data
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $trainings->links() }}
            </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="tcModal" tabindex="-1" aria-labelledby="tcModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('trainings.store') }}" name="frmTraining" autocomplete="off" method="post">
                        @csrf
                        @method('post')
                        <div class="modal-header">
                            <h5 class="modal-title" id="tcModalLabel">Register Training</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Category</label>
                                <select name="category" id="category" class="form-control select2" style="width:100%;" multiple>
                                    @foreach ($categories as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Please Insert Training Name">
                            </div>
                            <div class="form-group">
                                <label for="name">Status</label>
                                <select name="status" id="status" class="form-control">
                                    @foreach ($arrstts as $key => $as)
                                        <option value="{{ $key }}">{{ $as }}</option>
                                    @endforeach
                                </select>
                            </div>
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure?');">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Delete -->
        <div class="modal fade" id="tcModalDelete" tabindex="-1" aria-labelledby="tcModalDeleteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="" name="frmDeleteTraining" autocomplete="off" method="post">
                        @csrf
                        @method('delete')
                        <div class="modal-header">
                            <h5 class="modal-title" id="tcModalDeleteLabel">Delete Training</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h5>Are You sure to delete this content?</h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('myjs/period_datepicker.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function(){
            periodDatepicker();
            $('.select2').select2({
                maximumSelectionLength: 1
            });
            $(".add-training").on('click',function(e){
                e.preventDefault();
                const route = $(this).data('route');
                $("form[name='frmTraining'] #tcModalLabel").html('Register Training');
                $("form[name='frmTraining'] #name").val('');
                $("form[name='frmTraining'] #start_date").val('');
                $("form[name='frmTraining'] #end_date").val('');
                $("form[name='frmTraining'] #trainer_name").val('');
                $("form[name='frmTraining'] #status").val('0');
                $("form[name='frmTraining'] #category").val('');
                $("form[name='frmTraining'] input[name='_method']").val('post');
                $("form[name='frmTraining']").attr('action',route);
            });
            $(".edit-training").on('click',function(e){
                e.preventDefault();
                const url = $(this).data('url');
                const route = $(this).data('route');
                $.ajax({
                    url: url,
                    method:'get',
                    dataType: 'json',
                    beforeSend: function(){
                        $("form[name='frmTraining'] #tcModalLabel").html(`<div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="spinner-grow text-danger" style="width: 3rem; height: 3rem;" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>`);
                    },
                    success: function(result){
                        // console.log(result);
                        $("form[name='frmTraining'] #tcModalLabel").html('Update Training');
                        // $("form[name='frmTraining'] #category").val(result.category.id);
                        $("form[name='frmTraining'] #category").val(result.category.id).trigger('change');
                        $("form[name='frmTraining'] #name").val(result.name);
                        $("form[name='frmTraining'] #start_date").val(result.start_date);
                        $("form[name='frmTraining'] #end_date").val(result.end_date);
                        $("form[name='frmTraining'] #trainer_name").val(result.trainer_name);
                        $("form[name='frmTraining'] #status").val(result.status);
                        $("form[name='frmTraining'] input[name='_method']").val('patch');
                        $("form[name='frmTraining']").attr('action',route);

                        if($( "#start_date" ).val() != ""){
                            $( "#end_date" ).datepicker( "option", "minDate", $.datepicker.parseDate( "yy/mm/dd",  $( "#start_date" ).val() ) );
                        }
                        if($( "#end_date" ).val() != ""){
                            
                            $( "#start_date" ).datepicker( "option", "maxDate", $.datepicker.parseDate( "yy/mm/dd",  $( "#end_date" ).val() ) );
                        }
                    }
                });
            });
            $(".delete-training").on('click',function(e){
                e.preventDefault();
                const route = $(this).data('route');
                $("form[name='frmDeleteTraining']").attr('action',route);
            });
            // $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"}); 
            // $(".datex").datepicker({
            //     dateFormat  : "dd/mm/yy",
            //     changeMonth : true,
            //     changeYear  : true,
            //     // yearRange	  : "-70:-15"
            // });
        });
    </script>
@endsection