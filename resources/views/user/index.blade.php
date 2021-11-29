@extends('layouts_sbadmin2.app')

@section('title','User List')
@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User List</h6>
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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tcModal">
                        + User
                    </button>
                </div>
            </div>
            <div class="table-responsive my-3">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Dept</th>
                            <th>Kj</th>
                            <th>Auth</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @forelse ($usersdels as $ud)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $ud->fname }}</td>
                                <td>{{ $ud->hrismd_namadept }}</td>
                                <td>{{ $ud->hrisme_kj }}</td>
                                <td>{{ (in_array($ud->id_dept,$arrIdDeptAdmin)) ? 'Administrator' : 'member' }}</td>
                                <td>
                                    <button class="delete-user btn btn-danger" data-route="{{ route('users.destroy',$ud->id) }}" data-toggle="modal" data-target="#tcModalDelete">remove</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="alert alert-danger">
                                        There is no Data
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $usersdels->links() }}
            </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="tcModal" tabindex="-1" aria-labelledby="tcModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('users.store') }}" name="frmUser" autocomplete="off" method="post">
                        @csrf
                        @method('post')
                        <div class="modal-header">
                            <h5 class="modal-title" id="tcModalLabel">Register User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Employees</label>
                                <select name="employee" id="employee" class="form-control select2" style="width:100%;" multiple="">
                                    @foreach ($employees as $e)
                                        <option value="{{ $e->id }}">{{ $e->nama }}</option>
                                    @endforeach
                                </select>
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
                    <form action="" name="frmDeleteUser" autocomplete="off" method="post">
                        @csrf
                        @method('delete')
                        <div class="modal-header">
                            <h5 class="modal-title" id="tcModalDeleteLabel">Remove User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h5>Are You sure to remove this user?</h5>
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
            $(".delete-user").on('click',function(e){
                e.preventDefault();
                const route = $(this).data('route');
                $("form[name='frmDeleteUser']").attr('action',route);
            });
        });
    </script>
@endsection