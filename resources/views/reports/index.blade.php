@extends('layouts_sbadmin2.app')

@section('title','Report Training')
@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Filter Report</h6>
                </div>
                <div class="card_body">
                    <form name="frmReport" action="{{ route('reports.search') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="row my-3">
                            <div class="col-md-3 d-flex justify-content-end align-items-center font-weight-bolder text-monospace">
                                Tgl Training
                            </div>
                            <div class="col-md-1 d-flex justify-content-center align-items-center">
                                <strong>:</strong>
                            </div>
                            <div class="col-md-3 d-flex justify-content-center align-items-center">
                                <input type="text" name="start_date" id="start_date" class="form-control" placeholder="Start Date"
                                    @if(!empty($request['start_date']))
                                        value="{{ $request['start_date'] }}"
                                    @endif;
                                >
                            </div>
                            <div class="col-md-1 d-flex justify-content-center align-items-center font-weight-bolder">
                                -
                            </div>
                            <div class="col-md-3 d-flex justify-content-center align-items-center">
                                <input type="text" name="end_date" id="end_date" class="form-control" placeholder="End Date"
                                    @if(!empty($request['end_date']))
                                        value="{{ $request['end_date'] }}"
                                    @endif
                                >
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-md-3 d-flex justify-content-end align-items-center font-weight-bolder text-monospace">
                                Department
                            </div>
                            <div class="col-md-1 d-flex justify-content-center align-items-center">
                                <strong>:</strong>
                            </div>
                            <div class="col-md-7 d-flex justify-content-center align-items-center">
                                <select name="departments" id="departments" class="form-control">
                                    <option selected disabled>Choose the Department</option>
                                    @foreach ($departments as $d)
                                        <option value="{{ $d->hrismd_id }}"
                                            @if(!empty($request))
                                                {{ ($d->hrismd_id == $request['departments']) ? "selected" : false }}
                                            @else
                                                @if(session('isdepthead'))
                                                    {{ ($d->hrismd_id == session('iddept')) ? "selected" : false }}
                                                @else
                                                    @if(!session('isadmin'))
                                                        {{ ($d->hrismd_id == session('iddept')) ? "selected" : false }}
                                                    @endif
                                                @endif
                                            @endif;
                                        >{{ $d->hrismd_namadept }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-md-3 d-flex justify-content-end align-items-center font-weight-bolder text-monospace">
                                KJ
                            </div>
                            <div class="col-md-1 d-flex justify-content-center align-items-center">
                                <strong>:</strong>
                            </div>
                            <div class="col-md-7 d-flex justify-content-center align-items-center">
                                <select name="kj" id="kj" class="form-control">
                                    <option selected disabled>Choose one!</option>
                                    @foreach ($kj as $k)
                                        <option value="{{ $k->hrisme_kj }}"
                                            @if(!empty($request))
                                                {{ ($k->hrisme_kj == $request['kj']) ? "selected" : false }}
                                            @endif;
                                            >{{ $k->hrisme_kj }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-md-3 d-flex justify-content-end align-items-center font-weight-bolder text-monospace">
                                Category
                            </div>
                            <div class="col-md-1 d-flex justify-content-center align-items-center">
                                <strong>:</strong>
                            </div>
                            <div class="col-md-7 d-flex justify-content-center align-items-center">
                                <select name="categories" id="categories" class="form-control">
                                    @foreach ($categories as $c)
                                        <option value="{{ $c->id }}" 
                                            @if(!empty($request))
                                                {{ ($c->id == $request['categories']) ? "selected" : false }}
                                            @endif;
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
            <h6 class="m-0 font-weight-bold text-primary">Report Training</h6>
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

            <div class="table-responsive my-3">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Dept</th>
                            <th>KJ</th>
                            <th>Category</th>
                            <th>Training</th>
                            <th>Period</th>
                            <th>Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @forelse ($reports as $r)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $r->fname }}</td>
                                <td>{{ $r->hrismd_namadept }}</td>
                                <td>{{ $r->hrisme_kj }}</td>
                                <td>{{ $r->category_name }}</td>
                                <td>{{ $r->training_name }}</td>
                                <td>
                                    {{ date('d F Y',strtotime($r->start_date)) }} - {{  date('d F Y',strtotime($r->end_date)) }}
                                </td>
                                <td>
                                    <span class="badge 
                                    {{ ($r->final_value == "Y") ? 'badge-success':'badge-danger' }}">
                                        {{ ($r->final_value == "Y") ? 'Graduated' : 'Not Graduated' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="alert alert-danger">
                                        There is no Data
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if ($paginate)
                    {{ $reports->links() }}
                @endif
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
        });
    </script>
@endsection