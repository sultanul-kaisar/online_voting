@extends('admin.layouts.app')
@section('title', "Create Candidate")
@push('css')
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush

@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Blank Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Create Candidate</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="content" >
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-md-12 col-xl-12">
                            <div class="card sale-card" style="min-height:550px!important;">
                                <div class="card-header">
                                    <h5 class="card-title">Create Candidate</h5>
                                    @if(auth()->user()->can('master') || auth()->user()->can('global') || auth()->user()->can('candidate create'))
                                        <div class="card-header-right col-md-12 ml-2">
                                            <a type="button" href="{{ route('candidate.index') }}" class="btn btn-primary  float-right ml-2"><i class="fas fa-arrow-left"></i> Back</a>
                                            <a href="#" class="btn btn-primary float-md-right" onclick="event.preventDefault();document.getElementById('submit-form').submit();"><i class="fas fa-save "></i> Save</a>
                                        </div>
                                    @endif
                                </div>

                                <div class="page-body">
                                    <div class="card-block">
                                        <form method="POST" id="submit-form" action="{{ route('candidate.store')}}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-3 ml-5">Vote Category ( <span class="text-danger">*</span> )</label>
                                                <div class="col-lg-8">
                                                    <select name="vote_category_id" id="" class="form-control select-search @error('vote_category_id') is-invalid @enderror">
                                                        <option value="">Select Vote category</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" {{ (old('vote_category_id') ==  $category->id) ? 'selected=selected':'' }}>{{ $category->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('vote_category_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-3 ml-5">Full Name ( <span class="text-danger">*</span> )</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" onkeyup="nameSlug(this.value)" placeholder="Full Name" value="{{ old('name') }}">
                                                    @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-3 ml-5">Slug ( <span class="text-danger">*</span> )</label>
                                                <div class="col-lg-8">
                                                    <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" placeholder="Slug" value="{{ old('slug') }}">
                                                    @error('slug')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-3 ml-5">Image</label>
                                                <div class="col-lg-8">
                                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                                    @error('image')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-3 ml-5">Description</label>
                                                <div class="col-lg-8">
                                                    <textarea id="summernote" name="description" class="form-control" cols="30" rows="10" placeholder="Description">{{ old('description') }}</textarea>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 160
            });
        });
        function slugify(text)
        {
            return text
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                .replace(/[&\/\\#@,+()$~%.'":*?<>{}]/g,'')              // Replace ?
                .replace(/^-+/, '')             // Trim - from start of text
                .replace(/-+$/, '');            // Trim - from end of text
        }

        function nameSlug(name)
        {
            var slug = slugify(name);
            slug = slug.toLowerCase();
            document.getElementById("slug").value = slug;
        }
    </script>

    <script>
        $(document).ready(function() {
            $('.select-search').selectize({
                sortField: 'text'
            });
        });
    </script>


@endpush

