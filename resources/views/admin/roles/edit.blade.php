@extends('admin.layouts.app')
@section('title', "Edit Role")

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Role</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Edit Role</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">

    <div class="content" >
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-md-12 col-xl-12">
                            <div class="card sale-card" style="min-height:550px!important;">
                                <div class="card-header">
                                    <h5 class="card-title"> Update Role</h5>
                                    <div class="card-header-right col-md-12 ml-2">
                                        <a type="button" href="{{ route('role.index') }}" class="btn btn-primary  float-right ml-2"><i class="fas fa-arrow-left"></i> Back</a>
                                        <a href="#" class="btn btn-primary float-md-right" onclick="event.preventDefault();document.getElementById('submit-form').submit();"><i class="fas fa-save "></i> Save</a>
                                    </div>
                                </div>

                                <div class="page-body">
                                    <div class="card-block">
                                        <form method="POST" id="submit-form" action="{{ route('role.update', $role->id)}}">
                                            @csrf
                                            @method('PUT')
                                            @if($role->name == 'developer' || $role->name == 'super admin' || $role->name == 'uncategorized')
                                                <div class="form-group row">
                                                    <label class="col-form-label col-lg-3 ml-5">Title</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" disabled class="form-control @error('name') is-invalid @enderror" value="{{ $role->name }}">
                                                    </div>
                                                </div>
                                            @else
                                                <div class="form-group row">
                                                    <label class="col-form-label col-lg-3 ml-5">Title ( <span class="text-danger">*</span> )</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Role Name" value="{{ old('name' , $role->name) }}">
                                                        @error('name')
                                                        <div class="text-danger mb-3">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-3 ml-5">
                                                    Related Permissions ( <span class="text-danger">*</span> )
                                                </label>
                                                <div class="col-12">
                                                    <div class="bg-light p-3">
                                                        @error('permissions')
                                                        <div class="text-danger text-center">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                {{-- <div class="col-12">
                                                    <div class="bg-light p-3">
                                                        <div class="form-check ml-auto mr-auto" style="width:200px;">
                                                            <label class="form-check-label">
                                                                <input id="select-all-checkbox" type="checkbox" class="form-check-input-styled-success" data-fouc>
                                                                All Permissions
                                                            </label>
                                                        </div>
                                                        @error('permissions')
                                                            <div class="text-danger text-center">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div> --}}
                                                <div class="col-lg-12">
                                                    @error('permission')
                                                    <div class="text-danger mb-3">{{ $message }}</div>
                                                    @enderror

                                                    <div class="row p-2">
                                                        @if($pages->isEmpty())
                                                            <div class="col-8 offset-2">
                                                                <div class="text-center">
                                                                    <div class="alert alert-danger border-0 alert-dismissible">
                                                                        <span class="font-weight-semibold">Oh snap!</span> No permission found. Please  <a href="{{ route('permission.create') }}" class="alert-link">try creating</a> new permission.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            @foreach($pages as $page)
                                                                <div class="col-lg-4">
                                                                    <div class="card card-body custom-border-top" style="min-height:266px!important;">
                                                                        <div class="text-center">
                                                                            <h4 class="mb-0 font-weight-bold">{{ ucfirst($page->title) }}</h4>
                                                                        </div>
                                                                        <div class="card card-body bg-light mb-0">
                                                                            <div id="group{{$page->id}}">
                                                                                <span id="addClass{{$page->id}}" onclick="checkSelectedAll(this)" class="select-group d-block text-center badge badge-secondary badge-pill" style="cursor: pointer;font-size:12px;">Check All</span>
                                                                                @if($page->title == 'global')
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ $page->title }}" {{ (collect(old('permissions'))->contains($page->title)) ? 'checked':'' }} {{ ($role->hasPermissionTo($page->title)) ? 'checked':'' }}>
                                                                                        <label class="form-check-label" for="flexCheckDefault">
                                                                                            {{ $page->title }}
                                                                                        </label>
                                                                                    </div>

                                                                                    @if((collect(old('permissions'))->contains('global')))
                                                                                        <script>
                                                                                            var element = document.getElementById('addClass{{$page->id}}');
                                                                                            element.classList.add("badge-success");
                                                                                        </script>
                                                                                    @endif

                                                                                    @if(($role->hasPermissionTo('global')))
                                                                                        <script>
                                                                                            var element = document.getElementById('addClass{{$page->id}}');
                                                                                            element.classList.add("badge-success");
                                                                                        </script>
                                                                                    @endif
                                                                                @elseif($page->title == 'setting')
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ $page->title.' view' }}" {{ (collect(old('permissions'))->contains($page->title.' view')) ? 'checked':'' }} {{ ($role->hasPermissionTo($page->title. ' view')) ? 'checked':'' }}>
                                                                                        <label class="form-check-label" for="flexCheckDefault">
                                                                                            {{ $page->title }} view
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ $page->title.' edit' }}" {{ (collect(old('permissions'))->contains($page->title.' edit')) ? 'checked':'' }} {{ ($role->hasPermissionTo($page->title. ' edit')) ? 'checked':'' }}>
                                                                                        <label class="form-check-label" for="flexCheckDefault">
                                                                                            {{ $page->title }} edit
                                                                                        </label>
                                                                                    </div>

                                                                                    @if((collect(old('permissions'))->contains($page->title.' view')) || (collect(old('permissions'))->contains($page->title.' edit')))
                                                                                        <script>
                                                                                            var element = document.getElementById('addClass{{$page->id}}');
                                                                                            element.classList.add("badge-success");
                                                                                        </script>
                                                                                    @endif

                                                                                    @if(($role->hasPermissionTo($page->title. ' view')) || ($role->hasPermissionTo($page->title. ' edit')))
                                                                                        <script>
                                                                                            var element = document.getElementById('addClass{{$page->id}}');
                                                                                            element.classList.add("badge-success");
                                                                                        </script>
                                                                                    @endif
                                                                                @else
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ $page->title.' view' }}" {{ (collect(old('permissions'))->contains($page->title.' view')) ? 'checked':'' }} {{ ($role->hasPermissionTo($page->title. ' view')) ? 'checked':'' }}>
                                                                                        <label class="form-check-label" for="flexCheckDefault">
                                                                                            {{ $page->title }} view
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ $page->title.' create' }}" {{ (collect(old('permissions'))->contains($page->title.' create')) ? 'checked':'' }} {{ ($role->hasPermissionTo($page->title. ' create')) ? 'checked':'' }}>
                                                                                        <label class="form-check-label" for="flexCheckDefault">
                                                                                            {{ $page->title }} create
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ $page->title.' edit' }}" {{ (collect(old('permissions'))->contains($page->title.' edit')) ? 'checked':'' }} {{ ($role->hasPermissionTo($page->title. ' edit')) ? 'checked':'' }}>
                                                                                        <label class="form-check-label" for="flexCheckDefault">
                                                                                            {{ $page->title }} edit
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ $page->title.' delete' }}" {{ (collect(old('permissions'))->contains($page->title.' delete')) ? 'checked':'' }} {{ ($role->hasPermissionTo($page->title. ' delete')) ? 'checked':'' }}>
                                                                                        <label class="form-check-label" for="flexCheckDefault">
                                                                                            {{ $page->title }} delete
                                                                                        </label>
                                                                                    </div>

                                                                                    @if((collect(old('permissions'))->contains($page->title.' view')) || (collect(old('permissions'))->contains($page->title.' create')) || (collect(old('permissions'))->contains($page->title.' edit')) || (collect(old('permissions'))->contains($page->title.' delete')))
                                                                                        <script>
                                                                                            var element = document.getElementById('addClass{{$page->id}}');
                                                                                            element.classList.add("badge-success");
                                                                                        </script>
                                                                                    @endif

                                                                                    @if(($role->hasPermissionTo($page->title. ' view')) || ($role->hasPermissionTo($page->title. ' create')) || ($role->hasPermissionTo($page->title. ' edit')) || ($role->hasPermissionTo($page->title. ' delete')) )
                                                                                        <script>
                                                                                            var element = document.getElementById('addClass{{$page->id}}');
                                                                                            element.classList.add("badge-success");
                                                                                        </script>
                                                                                    @endif
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
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

</section>

@endsection
