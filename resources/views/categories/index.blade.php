@extends('layouts_sbadmin2.app')

@section('title','Training Category')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Training Category</h6>
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
                    <button type="button" class="btn btn-primary add-category" data-toggle="modal" data-target="#tcModal" data-route="{{ route('categories.store') }}">
                        + Training Category
                    </button>
                </div>
            </div>
            <div class="table-responsive my-3">
                <table class="table table-bordered table-responsive" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Category Training</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    {{-- <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Category Training</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot> --}}
                    <tbody>
                        <?php $no = 1; ?>
                        @forelse ($categories as $c)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $c->name }}</td>
                                <td>
                                    <span class="badge 
                                    {{ ($c->status == 0) ? 'badge-danger':'badge-success' }}">
                                        {{ ($c->status == 1) ? 'Active' : 'NonActive' }}</td>
                                    </span>
                                <td>
                                    <center>
                                        <i style="cursor:pointer;" class="fas fa-edit edit-category" data-url="{{ route('categories.show',$c->slug) }}" data-route="{{ route('categories.update',$c->slug) }}" data-toggle="modal" data-target="#tcModal"></i>

                                        <i style="cursor:pointer;" class="fas fa-trash delete-category" data-route="{{ route('categories.destroy',$c->slug) }}" data-toggle="modal" data-target="#tcModalDelete"></i>
                                    </center>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="alert alert-info">
                                        There is no Data
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $categories->links() }}
            </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="tcModal" tabindex="-1" aria-labelledby="tcModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('categories.store') }}" name="frmTrainingCategory" autocomplete="off" method="post">
                        @csrf
                        @method('post')
                        <div class="modal-header">
                            <h5 class="modal-title" id="tcModalLabel">Register Training Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Training Category</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Please Insert Training Category Name">
                            </div>
                            <div class="form-group">
                                <label for="name">Status</label>
                                <select name="status" id="status" class="form-control">
                                    @foreach ($arrstts as $key => $as)
                                        <option value="{{ $key }}">{{ $as }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                    <form action="" name="frmDeleteTrainingCategory" autocomplete="off" method="post">
                        @csrf
                        @method('delete')
                        <div class="methodcobs"></div>
                        <div class="modal-header">
                            <h5 class="modal-title" id="tcModalDeleteLabel">Delete Training Category</h5>
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
    <script>
        $(document).ready(function(){
            $(".add-category").on('click',function(e){
                e.preventDefault();
                const route = $(this).data('route');
                $("form[name='frmTrainingCategory'] #tcModalLabel").html('Register Training Category');
                $("form[name='frmTrainingCategory'] #name").val('');
                $("form[name='frmTrainingCategory'] #status").val('0');
                $("form[name='frmTrainingCategory'] input[name='_method']").val('post');
                $("form[name='frmTrainingCategory']").attr('action',route);
            });
            $(".edit-category").on('click',function(e){
                e.preventDefault();
                const url = $(this).data('url');
                const route = $(this).data('route');
                $.ajax({
                    url: url,
                    method:'get',
                    dataType: 'json',
                    beforeSend: function(){
                        $("form[name='frmTrainingCategory'] #tcModalLabel").html(`<div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="spinner-grow text-danger" style="width: 3rem; height: 3rem;" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>`);
                    },
                    success: function(result){
                        // console.log(result);
                        $("form[name='frmTrainingCategory'] #tcModalLabel").html('Update Training Category');
                        $("form[name='frmTrainingCategory'] #name").val(result.name);
                        $("form[name='frmTrainingCategory'] #status").val(result.status);
                        $("form[name='frmTrainingCategory'] input[name='_method']").val('patch');
                        $("form[name='frmTrainingCategory']").attr('action',route);
                    }
                });
            });
            $(".delete-category").on('click',function(e){
                e.preventDefault();
                const route = $(this).data('route');
                $("form[name='frmDeleteTrainingCategory']").attr('action',route);
            });
        });
    </script>
@endsection