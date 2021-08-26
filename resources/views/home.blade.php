@extends('layouts.app')

@section('content')
    <h2 style="text-align: center"> <strong>Select the Election</strong> </h2>
    <div id="blog-measonry" class="cbp">
        @if (!$voteCategories->count())
            <div class="cbp-item">
                <div class="news_item shadow text-center text-md-left">
                    <a class="image" href="blog-detail.html">
                        <img src="{{asset('assets/frontend/images/blog-measonry1.jpg')}}" alt="" class="img-responsive">
                    </a>
                    <div class="news_desc">
                        <h3 class="text-capitalize font-normal darkcolor"><a href="blog-detail.html">28 Ways to Boost Your Content Confidence</a></h3>
                    </div>
                </div>
            </div>
        @else

            @foreach ($voteCategories as $voteCategory)
                <div class="cbp-item">
                    <div class="news_item shadow text-center text-md-left">
                        <a class="image" href="{{route('vote_submit',$voteCategory->slug)}}">
                            <img src="{{ asset('storage/uploads/vote-categories/'.$voteCategory->image) }}" alt="" class="img-responsive">
                        </a>
                        <div class="news_desc">
                            <h3 class="text-capitalize font-normal darkcolor" style="text-align: center"><a href="{{route('vote_submit',$voteCategory->slug)}}">{{ $voteCategory->title}}</a></h3>
                            <strong>{!! $voteCategory->description !!}</strong>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
