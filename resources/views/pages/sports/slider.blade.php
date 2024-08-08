<!-- Start Slider Area -->
<div class="slider-area">
  <div class="container-fluid">
    <div class="row">
      <div class="splide">
    <div class="splide__track">
      <ul class="splide__list">
        @foreach($slider as $index => $slider_data)
        
        @if($slider_data->slider_post_id=="")

        <?php $slider_url='#';?>

        @elseif($slider_data->slider_type=="Movies")

        <?php $slider_url= URL::to('movies/details/'.App\Movies::getMoviesInfo($slider_data->slider_post_id,'video_slug').'/'.$slider_data->slider_post_id);?>
         
        @elseif($slider_data->slider_type=="Shows")
        
        <?php $slider_url= URL::to('shows/details/'.App\Series::getSeriesInfo($slider_data->slider_post_id,'series_slug').'/'.$slider_data->slider_post_id);?>
         
        @elseif($slider_data->slider_type=="Sports")

        <?php $slider_url= URL::to('sports/details/'.App\Sports::getSportsInfo($slider_data->slider_post_id,'video_slug').'/'.$slider_data->slider_post_id);?>
        
        @elseif($slider_data->slider_type=="LiveTV")

        <?php $slider_url= URL::to('livetv/details/'.App\LiveTV::getLiveTvInfo($slider_data->slider_post_id,'channel_slug').'/'.$slider_data->slider_post_id);?>
 
        @else
          <?php $slider_url='#';?>
        @endif

        <li class="splide__slide" video-id="{{$slider_data->id}}" slider-id="{{$index}}">
            <div class="splide-slider-details-area d-flex flex-column justify-content-end" style="padding-bottom: 8%;" >
              <div class="movies-info-header">
                <h1>{{stripslashes($slider_data->slider_title)}}</h1>
                <!-- <div class="movies-info-date">
                  <span class="border-white-quar">A</span>
                  <span class="before-dot"> 2024</span>
                  <span class="before-dot"> Hindi</span>
                  <span class="before-dot"> Drama</span>
                  <span class="before-dot"> Mystery</span>
                </div> -->
              </div>
              <div class="movies-info-description" >
                @if ($slider_data->file_url_state === 0)
                  {!! App\Slider::getMoviesInfo($slider_data->slider_post_id)->video_description !!}
                @else
                  <p>{{$slider_data->slider_description}}</p>
                @endif
              </div>
              <div class="movies-info-button-group">
                <div class="row d-flex align-items-center justify-content-start" >
                  <!-- <a href="{{$slider_url}}" class="col-lg-3 col-md-4" title="{{stripslashes($slider_data->slider_title)}}"><img src="{{ URL::asset('site_assets/images/ic-play.png') }}" class="w-100" style="object-fit: cover; height:33px; border-radius:5px;" alt="ic-play" title="ic-play"></a> -->
                  <!-- <button _ngcontent-lrh-c165="" class="text-nowrap btn-description-show" video-id="{{$slider_data->id}}" id="info"><img _ngcontent-lrh-c165="" id="moreInfo" src="{{ URL::asset('site_assets/images/info.svg')}}" alt="altt" loading="lazy" style="cursor: pointer;"> More Info </button> -->
                  <!-- <button _ngcontent-lrh-c165="" class="text-nowrap btn-description-show" video-id="{{$slider_data->id}}" id="info"><img _ngcontent-lrh-c165="" id="moreInfo" src="{{ URL::asset('site_assets/images/info.svg')}}" alt="altt" loading="lazy" style="cursor: pointer;"> More Info </button> -->
                   <button class="col-md-3 col-xl-2 btn-custom btn-custom-danger movies-info-play mr-5 text-nowrap" style="cursor: pointer;" onclick="location.href='{{$slider_url}}'">
                      <i class="fa fa-play-circle"></i>
                      Play
                   </button>
                   <button class="btn-custom btn-description-show btn-custom-secondary ml-5 text-nowrap" style="cursor: pointer;" video-id="{{$slider_data->id}}" id="info">
                      <i class="fa fa-info-circle"></i>
                      More Info
                   </button>
                </div>
              </div>
            </div>
            <div class="video-show">
              <video style="object-fit: cover;" class="d-none" src="{{ $slider_data->file_url_state === 0 ? App\Slider::getMoviesInfo($slider_data->slider_post_id)->video_url : $slider_data->slider_video}}" width="100%" height="100%">
              </video>
              <img src="{{$slider_data->file_url_state === 0 ? App\Slider::getMoviesInfo($slider_data->slider_post_id)->video_image : $slider_data->slider_image}}" alt=""  style="object-fit: cover;" width="100%" height="100%">
            </div>
            <div class="video-operation d-flex align-items-center justify-content-around d-none">
              <span class="video-opeation-play text-center px-2">
                <i class="fa fa-pause"></i>
              </span>
              <span class="video-opeation-audio text-center px-2">
                <i class="fas fa-volume-up"></i>
              </span>
            </div>
            <div class="play-icon-item"  >
              <i class="icon fa fa-play"></i>
            </div>
            <!-- <img src="{{URL::to('/'.$slider_data->slider_image)}}" title="{{stripslashes($slider_data->slider_title)}}" alt="{{stripslashes($slider_data->slider_title)}}"> -->
        </li>
        @endforeach         
        
      </ul>
      <div class="loading-icon" style="display: none;" id="loadingIcon">
        <i class="fas fa-spinner fa-spin"></i>
      </div>
    </div>
    </div>
    </div>
  </div>
</div>
<!-- End Slider Area --> 

<div class="movies-info-description-mobile" style="display:none">
  <h3>Hello Word</h3> 
  <p class="more">
    An emotional journey of a prison warden, driven by a personal vendetta while keeping up to a promise made years ago, recruits inmates to commit outrageous crimes that shed light on corruption and injustice, in an attempt to get even with his past, and that leads him to an unexpected reunion.
  </p>
 <span>Read More</span>
</div>