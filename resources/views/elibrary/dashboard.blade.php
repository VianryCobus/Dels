@extends('layouts_sbadmin2.app')

@section('title','E-Library')
@section('head')
    
@endsection
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h2 mb-0 text-monospace font-weight-bolder">DAW E-Library</h1>
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
    
    <div class="row mt-2 mb-2">
        @forelse ($elibraries as $e)
            <!-- E-Library -->
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 mb-4">
                <div class="card border-left-primary shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-gray-800 mb-2 card-title">Daw E-Library</div>
                                <div class="card-subtitle font-weight-bold text-primary text-uppercase mb-4">
                                    {{ Str::limit($e->title,35,'...') }}
                                </div>
                                <div class="text-xs font-weight-bolder text-danger text-uppercase d-flex justify-content-center">
                                    {{-- {{ date('d F Y',strtotime($o->created_at)) }} --}}
                                    {{ $e->created_at ->diffForHumans()}}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button class="btn btn-success btn-icon-split download-elibrary" data-route="{{ route('dashelibraries.downloadElibrary',$e->id) }}">
                            <span class="icon text-white-50">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="text">Download</span>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 mb-4">
                <div class="alert alert-danger">
                    There is no E-Library
                </div>
            </div>
        @endforelse
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            // download elibrary file
            $('.download-elibrary').on('click',function(e){
                e.preventDefault();
                const route = $(this).data('route');
                window.open(route);
            });
        });
    </script>
@endsection