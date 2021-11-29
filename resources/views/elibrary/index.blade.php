@extends('layouts_sbadmin2.app')

@section('title','E-Library List')
@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('mycss/loading.css') }}">
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">E-Library List</h6>
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
                    <button type="button" class="btn btn-primary add-elibrary" data-toggle="modal" data-target="#tcModal" data-route="{{ route('elibraries.store') }}">
                        + E-Library
                    </button>
                </div>
            </div>
            <div class="table-responsive my-3">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @forelse ($elibraries as $e)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $e->title }}</td>
                                <td>
                                    <span class="badge 
                                    {{ ($e->status == 0) ? 'badge-danger':'badge-success' }}">
                                        {{ $arrstts[$e->status] }}
                                    </span>
                                </td>
                                <td>
                                    <button class="edit-elibrary btn btn-primary" data-url="{{ route('elibraries.show',$e->id) }}" data-route="{{ route('elibraries.update',$e->id) }}" data-toggle="modal" data-target="#tcModal">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-info download-elibrary" data-route="{{ route('elibraries.downloadElibrary',$e->id) }}">
                                        <i class="fas fa-download"></i>
                                    </button>

                                    <button class="btn btn-danger delete-elibrary" data-route="{{ route('elibraries.destroy',$e->id) }}" data-toggle="modal" data-target="#tcModalDelete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="alert alert-danger">
                                        There is no Data
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $elibraries->links() }}
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="tcModal" tabindex="-1" aria-labelledby="tcModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="d-flex justify-content-center align-items-center div-loading">
                        <div class="spinner-border text-info" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <form action="{{ route('elibraries.store') }}" name="frmElibrary" autocomplete="off" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="modal-header">
                            <h5 class="modal-title" id="tcModalLabel">Upload E-Library</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Title</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="Please Type Title">
                            </div>
                            <div class="form-group">
                                <label for="name">Status</label>
                                <select name="status" id="status" class="form-control">
                                    @foreach ($arrstts as $key => $a)
                                        <option value="{{ $key }}">{{ $a }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">File Elibrary</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="elibrary">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose File</label>
                                    </div>
                                </div>
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
                    <form action="" name="frmDeleteElibrary" autocomplete="off" method="post">
                        @csrf
                        @method('delete')
                        <div class="modal-header">
                            <h5 class="modal-title" id="tcModalDeleteLabel">Delete E-Library</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h5>Are You sure to delete this file?</h5>
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
    <script src="{{ asset('myjs/loading.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function(){
            periodDatepicker();
            $('.select2').select2({
                maximumSelectionLength: 1
            });
            $(".add-elibrary").on('click',function(e){
                e.preventDefault();
                const route = $(this).data('route');
                $("form[name='frmElibrary'] #tcModalLabel").html('Upload E-Library');
                $("form[name='frmElibrary'] #title").val('');
                $("form[name='frmElibrary'] #status").val('0');
                $("form[name='frmElibrary'] input[name='_method']").val('post');
                $("form[name='frmElibrary']").attr('action',route);
            });
            $(".edit-elibrary").on('click',function(e){
                e.preventDefault();
                const url = $(this).data('url');
                const route = $(this).data('route');
                $.ajax({
                    url: url,
                    method:'get',
                    dataType: 'json',
                    beforeSend: function(){
                        showLoading();
                    },
                    success: function(result){
                        unshowLoading();
                        // console.log(result);
                        $("form[name='frmElibrary'] #tcModalLabel").html('Update E-Library');
                        $("form[name='frmElibrary'] #title").val(result.title);
                        $("form[name='frmElibrary'] #status").val(result.status);
                        $("form[name='frmElibrary'] input[name='_method']").val('patch');
                        $("form[name='frmElibrary']").attr('action',route);
                    }
                });
            });
            $(".delete-elibrary").on('click',function(e){
                e.preventDefault();
                const route = $(this).data('route');
                $("form[name='frmDeleteElibrary']").attr('action',route);
            });
            // download elibrary file
            $('.download-elibrary').on('click',function(e){
                e.preventDefault();
                const route = $(this).data('route');
                window.open(route);
            });
            // script for title file on input file
            $('.custom-file-input').on('change',function(){
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass('selected').html(fileName);
            });
        });
    </script>
@endsection