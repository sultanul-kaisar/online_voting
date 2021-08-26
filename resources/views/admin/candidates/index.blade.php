@extends('admin.layouts.app')
@section('title', "Candidate")

@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Candidate</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Candidate</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-md-12 col-xl-12">
                            <div class="card sale-card" style="min-height:550px!important;">
                                <div class="card-header">
                                    <h5 class="card-title">All Vote Candidate</h5>
                                    <div class="card-header-right col-md-12 ml-2">
                                        <a type="button" href="{{ route('candidate.create') }}" class="btn btn-primary  float-right ml-2"><i class="fas fa-plus"></i> New Vote Candidate</a>
                                    </div>
                                </div>

                                <div class="page-body">
                                    <div class="card-block">
                                        <div class="table-responsive dt-responsive">
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        @if(auth()->user()->can('master') || auth()->user()->can('global') || auth()->user()->can('candidate view') || auth()->user()->can('candidate edit') || auth()->user()->can('candidate delete'))
                                                            <th>Action</th>
                                                        @endif
                                                        <th>Name</th>
                                                        <th>Slug</th>
                                                        <th>Vote Category</th>
                                                        <th>Image</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($candidates as $candidate)
                                                    <tr>
                                                        <td>
                                                            @if(auth()->user()->can('master') || auth()->user()->can('global') || auth()->user()->can('candidate edit') || auth()->user()->can('candidate delete'))
                                                                 <div class="list-icons">
                                                                    <div class="dropdown">
                                                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                                            <i class="fas fa-bars"></i>
                                                                        </a>
                                                                        <div class="dropdown-menu dropdown-menu-right custom-dropdown-menu-right">
                                                                            @if(auth()->user()->can('master') || auth()->user()->can('global') || auth()->user()->can('candidate edit'))
                                                                                <a href="{{ route('candidate.edit', $candidate->id) }}" class="dropdown-item"><i class="fas fa-pencil-alt"></i> View / Edit</a>
                                                                            @endif
                                                                            @if(auth()->user()->can('master') || auth()->user()->can('global') || auth()->user()->can('candidate delete'))
                                                                                <a href="{{ route('admin.dashboard') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('delete-form{{$candidate->id}}').submit();"><i class="fas fa-trash"></i> Delete</a>
                                                                                <form id="delete-form{{$candidate->id}}" action="{{ route('candidate.destroy', $candidate->id) }}" method="POST" style="display: none;">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                </form>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>{{  $candidate->name }}</td>
                                                        <td>{{  $candidate->slug }}</td>
                                                        <td>{{  $candidate->vote_category->title }}</td>
                                                        <td style="width:20%;">
                                                            <a href="{{ asset('storage/uploads/candidates/'.$candidate->image) }}" data-toggle="lightbox">
                                                                <img src="{{ asset('storage/uploads/candidates/'.$candidate->image) }}" class="img-fluid" style="width: 50%!important;">
                                                            </a>
                                                        </td>
                                                        <td>
                                                            @if($candidate->status == "active")
                                                                <span class="badge badge-success">Enabled</span>
                                                            @endif

                                                            @if($candidate->status == "inactive")
                                                                <span class="badge badge-danger">Disabled</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
    <script>
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    </script>
@endpush
