@extends('site_app')

@section('head_title', trans('words.movies_text').' | '.getcong('site_name') )

@section('head_url', Request::url())

@section('content')

@if(count($slider)!=0)
  @include("pages.movies.slider")  
@endif

<link rel="stylesheet" href="{{ URL::asset('site_assets/css/nice-select.css') }}">

<!-- Start View All Movies -->
<div class="view-all-video-area view-movie-list-item vfx-item-ptb">
  <div class="container-fluid">
  
     <div class="row">
      @foreach($movies_list as $movies_data) 
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 col-6">
          <div class="single-video">
            @if(Auth::check())              
                <a href="{{ URL::to('movies/details/'.$movies_data->video_slug.'/'.$movies_data->id) }}" title="{{$movies_data->video_title}}"> 
            @else
               @if($movies_data->video_access=='Paid')
                <a href="{{ URL::to('movies/details/'.$movies_data->video_slug.'/'.$movies_data->id) }}" title="{{$movies_data->video_title}}" data-toggle="modal" data-target="#loginAlertModal" title="{{$movies_data->video_title}}">
               @else
                <a href="{{ URL::to('movies/details/'.$movies_data->video_slug.'/'.$movies_data->id) }}" title="{{$movies_data->video_title}}">
               @endif  
            @endif
               <div class="video-img"> 
                @if($movies_data->video_access =="Paid")       
                <div class="vid-lab-premium">
                  <img src="{{ URL::asset('site_assets/images/ic-premium.png') }}" alt="premium" title="premium">
                </div> 
                @endif

                <span class="video-item-content">{{Str::limit(stripslashes($movies_data->video_title),20)}}</span> 
                <img src="{{URL::to('/'.$movies_data->video_image_thumb)}}" alt="{{stripslashes($movies_data->video_title)}}" title="{{stripslashes($movies_data->video_title)}}">         
               </div>       
            </a>
          </div>
        </div>
      @endforeach    
    </div>
    <div class="col-xs-12"> 
      @include('_particles.pagination', ['paginator' => $movies_list])
    </div>
   </div>
</div>
<!-- End View All Movies -->


@endsection