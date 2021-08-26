@extends('admin.layouts.app')
@section('title', "Vote Result")

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Vote Result</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Result</li>
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
                                    <div class="card-header-right col-md-12 ml-2">
                                        <h4 class="sub-title">Select Vote Purpose</h4>
                                        <select name="vote_category_id" class="form-control form-control-default">
                                            <option value="">Select Vote Purpose</option>
                                            @foreach($vote_categories as $voteCategory)
                                                <option value="{{ $voteCategory->id }}">{{ $voteCategory->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="page-body">
                                    <div class="card-block">
                                        <div class="table-responsive dt-responsive">
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Candidate Name</th>
                                                    <th>Image</th>
                                                    <th>Total Vote</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach($candidates as $candidate)
                                                    <tr>
                                                        <td>{{$candidate->name}}</td>
                                                        <td style="width:20%;">
                                                            <a href="{{ asset('storage/uploads/candidates/'.$candidate->image) }}" data-toggle="lightbox">
                                                                <img src="{{ asset('storage/uploads/candidates/'.$candidate->image) }}" class="img-fluid" style="width: 50%!important;">
                                                            </a>
                                                        </td>
                                                        <td>
                                                            
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
