@extends('site_app')

@section('head_title', trans('words.shows_text').' | '.getcong('site_name') )

@section('head_url', Request::url())

@section('content')

@if(count($slider)!=0)
  @include("pages.shows.slider")  
@endif

<link rel="stylesheet" href="{{ URL::asset('site_assets/css/nice-select.css') }}">

<!-- Start View All Shows -->
<div class="view-all-video-area view-shows-list-item vfx-item-ptb">
  <div class="container-fluid">
   
    <div class="row">              
         @foreach($series_list as $series_data)    
         <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6 col-6">
          <div class="single-video">
            <a href="{{ URL::to('shows/details/'.$series_data->series_slug.'/'.$series_data->id) }}" title="{{$series_data->series_name}}">
               <div class="video-img">          
                
                @if($series_data->series_access=="Paid")       
                <div class="vid-lab-premium">
                  <img src="{{ URL::asset('site_assets/images/ic-premium.png') }}" alt="premium" title="premium">
                </div> 
                @endif             

                <img src="{{URL::to('/'.$series_data->series_poster)}}" alt="{{$series_data->series_name}}" title="{{$series_data->series_name}}">         
               </div>
               <div class="season-title-item">
                <h3>{{Str::limit(stripslashes($series_data->series_name),30)}}</h3>
               </div> 
            </a>
          </div>
             </div>
         @endforeach                       
      </div>    
    <div class="col-xs-12"> 
      @include('_particles.pagination', ['paginator' => $series_list])    
    </div>
   </div>
</div>
<!-- End View All Shows -->

 
@endsection