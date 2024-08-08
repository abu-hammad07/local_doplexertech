@extends('site_app')

@section('head_title', trans('words.live_tv').' | '.getcong('site_name') )

@section('head_url', Request::url())

@section('content')

@if(count($slider)!=0)
  @include("pages.shows.slider")  
@endif


<link rel="stylesheet" href="{{ URL::asset('site_assets/css/nice-select.css') }}">

<!-- Start View All Sports -->
<div class="view-all-video-area vfx-item-ptb">
  <div class="container-fluid">
   
    <div class="row">
     
         
         @foreach($live_tv_list as $live_tv_data)    
         <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 col-6">
          <div class="single-video">
            <a href="{{ URL::to('livetv/details/'.$live_tv_data->channel_slug.'/'.$live_tv_data->id) }}" title="{{$live_tv_data->channel_name}}">
               <div class="video-img">          
                
                @if($live_tv_data->channel_access=="Paid")       
                <div class="vid-lab-premium">
                  <img src="{{ URL::asset('site_assets/images/ic-premium.png') }}" alt="ic-premium" title="ic-premium">
                </div> 
                @endif             

                <img src="{{URL::to('/'.$live_tv_data->channel_thumb)}}" title="{{$live_tv_data->channel_name}}" alt="{{$live_tv_data->channel_name}}">         
               </div>
               <div class="season-title-item">
                <h3 class="mb-0">{{Str::limit(stripslashes($live_tv_data->channel_name),20)}}</h3>
               </div> 
            </a>
          </div>
             </div>
         @endforeach            
      </div>    
	  <div class="col-xs-12"> 
		  @include('_particles.pagination', ['paginator' => $live_tv_list])
	  </div>
   </div>
</div>
<!-- End View All Sports -->

 
@endsection