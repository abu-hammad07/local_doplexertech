@extends('site_app')

@section('head_title', trans('words.sports_text').' | '.getcong('site_name') )

@section('head_url', Request::url())

@section('content')
  
@if(count($slider)!=0)
  @include("pages.sports.slider")  
@endif

<!-- Banner -->


<link rel="stylesheet" href="{{ URL::asset('site_assets/css/nice-select.css') }}">

<!-- Start View All Sports -->
<div class="view-all-video-area vfx-item-ptb">
  <div class="container-fluid">
    <div class="row">
     
         
         @foreach($sports_video_list as $sports_video)    
         <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 col-6">
          <div class="single-video">
            <a href="{{ URL::to('sports/details/'.$sports_video->video_slug.'/'.$sports_video->id) }}" title="{{$sports_video->video_title}}">
               <div class="video-img">          
                
                @if($sports_video->video_access=="Paid")       
                <div class="vid-lab-premium">
                  <img src="{{ URL::asset('site_assets/images/ic-premium.png') }}" alt="ic-premium" title="ic-premium">
                </div> 
                @endif             

                <img src="{{URL::to('/'.$sports_video->video_image)}}" title="{{$sports_video->video_title}}" alt="{{$sports_video->video_title}}">         
               </div>
               <div class="season-title-item">
                <h3 class="mb-0">{{Str::limit(stripslashes($sports_video->video_title),20)}}</h3>
               </div> 
            </a>
          </div>
             </div>
         @endforeach            
       
    
      </div>    

    <div class="col-xs-12"> 

      @include('_particles.pagination', ['paginator' => $sports_video_list])

     
   </div>
   </div>
</div>
<!-- End View All Sports -->

<!-- Banner -->
 
@endsection