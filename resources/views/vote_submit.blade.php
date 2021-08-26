@extends('layouts.app')
@section('title', $voteCategory->title)

@section('content')
    <section style="margin-top:-100px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center heading_space animated wow fadeIn" data-wow-delay="300ms">
                    <h2 class="heading darkcolor font-light2">Our <span class="font-normal">Candidates</span>
                        <span class="divider-center"></span>
                    </h2>
                    <div class="col-md-8 offset-md-2 bottom40">
                        <p>Make Sure Vote the preferable candidate on your mind.</p>
                    </div>
                </div>
            </div>
            @if(!$voted)
                <div id="grid-mosaic" class="row equal-shadow-team cbp cbp-l-grid-mosaic-flat">
                    @if(!$candidates->count())

                    @else
                     @foreach($candidates as $candidate)
                        <div class="cbp-item col-lg-2 col-md-4 col-sm-6 col-12 pb-4 {{ $candidate->vote_category->slug }}">
                            <div class="team-box wow fadeIn" data-wow-delay="300ms">
                                <div class="image">
                                    <img src="{{ asset('storage/uploads/candidates/'.$candidate->image) }}" alt="">
                                </div>
                                <div class="team-content">
                                    <h4 class="darkcolor">{{ $candidate->name }}</h4>
                                    <ul class="social-icons-simple">
                                        <p>{!! $candidate->description !!}</p>

                                    </ul>
                                </div>
                            </div>
                        </div>
                     @endforeach
                    @endif
                </div>
                <form method="POST" id="submit-form" action="{{route('vote_submitstore')}}" enctype="multipart/form-data">
                @csrf
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-6 col-xl-3 m-b-30">
                            <input type="hidden" name="vote_category_id" value="{{ $voteCategory->id }}">
                            <input type="hidden" name="vote_category_slug" value="{{ $voteCategory->slug }}">
                            <h4 class="sub-title">Select Your Candidate</h4>
                            <select name="candidate_id" class="form-control form-control-default">
                                <option value="">Select Your Candidate</option>
                                @foreach($candidates as $candidate)
                                    <option value="{{ $candidate->id }}">{{ $candidate->name }}</option>
                                @endforeach
                            </select>
                            @error('candidate_id')
                                <div class="text-danger">{{ $message  }}</div>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-xl-4 m-b-30">
                            <a href="#" class="btn btn-primary float-md-right" onclick="event.preventDefault();document.getElementById('submit-form').submit();"><i class="fas fa-save "></i> Submit</a>
                        </div>
                    </div>
                </div>
            </form>
            @else
                <div class="alert alert-warning text-center">
                    You have already voted on this category. <a href="{{ route('home') }}">Back to home</a>
                </div>
            @endif
        </div>
    </section>
@endsection
