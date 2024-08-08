@extends('site_app')


@if($tv_info->seo_title)
@section('head_title', stripslashes($tv_info->seo_title).' | '.getcong('site_name'))
@else
@section('head_title', stripslashes($tv_info->channel_name).' | '.getcong('site_name') )
@endif

@if($tv_info->seo_description)
@section('head_description', stripslashes($tv_info->seo_description))
@else
@section('head_description', Str::limit(stripslashes($tv_info->channel_description),160))
@endif

@if($tv_info->seo_keyword)
@section('head_keywords', stripslashes($tv_info->seo_keyword))
@endif


@section('head_image', URL::to('/'.$tv_info->channel_thumb) )

@section('head_url', Request::url())

@section('content')

<link rel="stylesheet" type="text/css" href="{{ URL::asset('site_assets/player/content/global.css') }}">
<!-- <script type="text/javascript" src="{{ URL::asset('site_assets/player/java/FWDEVPlayer.js') }}"></script> -->

<style>
    .youtube-video-item {
        position: relative;
        padding-bottom: 40.25%;
        height: 0;
    }

    .youtube-video-item iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        margin: 0 auto;
        display: inline-block;
        right: 0;
    }
</style>

<!-- Start Page Content Area -->



<div class="page-content-area vfx-item-ptb pt-0">

    <div class="container-fluid bg-dark video-player-base">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">


                <div class="video-posts-video d-flex align-items-center justify-content-center">


                    @if($tv_info->channel_url!="")
                    <div class="video-show position-relative">
                        <div class="video-show-content w-100 h-100">
                            <video id="video-show-content-videotag" poster="{{URL::asset($tv_info->channel_thumb)}}" src="{{$tv_info->proxy_state === false ? URL::asset($tv_info->channel_url) : $tv_info->channel_url }}" access_status="{{Auth::check() ? 'free' : $tv_info->channel_access}}"
                                class="customize-video" width="100%" height="100%" style="object-fit:cover" free_time = {{$tv_info->channel_access === 'Paid' ? $tv_info->free_time : 0}} @if(session('back_with_credential')) saved_time="{{session('saved_video_time')}}" <?php session()->forget('back_with_credential'); session()->forget('saved_video_time');?> @endif></video>    
                        </div>
                        <div class="video-show-player-btn d-flex align-items-center justify-content-center">
                            <span>
                                <i class="icon fa fa-play"></i>
                            </span>
                        </div>
                        <div class="video-show-control position-absolute w-100" style="z-index:0;">
                            
                            <div
                                class="video-show-control-btns w-100 d-flex align-items-center justify-content-between">
                                <div class="video-control-btns-left col-2 d-flex ">
                                    <ul class="d-flex align-items-center justify-content-start gap-3">
                                        <li><i class="fa fa-play" tag-role="video-sate"></i></li>
                                        <li><i class="fa fa-undo" tag-role="video-time-forward"></i></li>
                                        <li><i class="fa fa-redo" tag-role="video-time-backward"></i></li>
                                        <li class="video-show-control-timer text-nowrap">
                                            <span class="video-timer-current d-none"
                                                tag-role="video-timer-currenttime">00:00</span>
                                            <span class="d-none">/</span>
                                            <span class="video-timer-duration d-none"
                                                tag-role="video-timer-duration">00:00</span>
                                            <i class="fas fa-video fa-fw" tag-role="video-live-icon"></i>
                                        </li>
                                        <li class="position-relative d-flex flex-row flex-nowrap align-items-center justify-content-around"
                                            tag-role="video-volume-control">
                                            <i class="fa fa-volume-up" tag-role="video-mute-state"></i>
                                            <input style="width: 75px;" value="0" type="range" min="0" max="1"
                                                step="0.01" tag-role="video-volume-slider"></input>
                                        </li>
                                    </ul>
                                </div>
                                <!-- <div class="video-control-btns-middle col-4 d-flex align-items-center justify-content-center">
                  <h3 class="text-nowrap">{{$tv_info->video_title}}</h3>
                </div> -->
                                <div
                                    class="video-control-btns-right col-2 d-flex align-items-center justify-content-around">
                                    <ul class="w-100 d-flex align-items-center justify-content-end gap-3">
                                        <!-- <li><i class="fa fa-step-forward" tag-role="video-next"></i></li>
                    <li><i class="fa fa-comment-alt" tag-role="video-subtitle"></i></li> -->
                                        <li><i class="fa fa-expand" tag-role="video-screen-expand"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="loading-icon" style="display: none;" id="loadingIcon">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </div>

                    @else

                    <div style="text-align: center;padding: 70px 30px;font-size: 24px;	font-weight: 700;	background: #101011;border-radius: 10px;margin-top: 15px;min-height: 280px;
      line-height: 6;">NO Source URL Set</div>

                    @endif

                </div>

            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- Start Video Post -->
                <div class="video-post-wrapper">
                    <div class="row mt-30">

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="video-posts-data mt-0 mb-0">
                                <div class="video-post-info">
                                    <h2>{{stripslashes($tv_info->channel_name)}}</h2>
                                    <div class="video-post-date">
                                        <span class="video-posts-author"><i
                                                class="fa fa-eye"></i>{{number_format_short($tv_info->views)}}
                                            {{trans('words.video_views')}}</span>

                                    </div>
                                    <ul class="actor-video-link">
                                        <li><a href="{{ URL::to('livetv/?cat_id='.$tv_info->channel_cat_id) }}"
                                                title="{{App\TvCategory::getTvCategoryInfo($tv_info->channel_cat_id,'category_name')}}">{{App\TvCategory::getTvCategoryInfo($tv_info->channel_cat_id,'category_name')}}</a>
                                        </li>
                                    </ul>

                                    @if($tv_info->channel_url2!='' OR $tv_info->channel_url3!='')
                                    <div class="video-watch-share-item server-btn-list">
                                        @if($tv_info->channel_url2!='' OR $tv_info->channel_url3!='')
                                        <div class="server-btn-item">
                                            <a href="{{ URL::to('livetv/watch/'.$tv_info->channel_slug.'/'.$tv_info->id) }}"
                                                title="server"><i class="fa fa-tv"></i> {{trans('words.server_1')}}</a>
                                        </div>
                                        @endif

                                        @if($tv_info->channel_url2)

                                        <div class="server-btn-item">
                                            <a href="{{ URL::to('livetv/watch/'.$tv_info->channel_slug.'/'.$tv_info->id) }}?server=2"
                                                title="server"><i class="fa fa-tv"></i> {{trans('words.server_2')}}</a>
                                        </div>

                                        @endif
                                        @if($tv_info->channel_url3)
                                        <div class="server-btn-item">
                                            <a href="{{ URL::to('livetv/watch/'.$tv_info->channel_slug.'/'.$tv_info->id) }}?server=3"
                                                title="server"><i class="fa fa-tv"></i> {{trans('words.server_3')}}</a>
                                        </div>

                                        @endif
                                    </div>
                                    @endif
                                    <div class="video-watch-share-item d-flex gap-2 flex-wrap">
                                        @if(Auth::check())

                                        @if(check_watchlist(Auth::user()->id,$tv_info->id,'LiveTV'))
                                        <span class="btn-watchlist text-nowrap"><a
                                                href="{{URL::to('watchlist/remove')}}?post_id={{$tv_info->id}}&post_type=LiveTV"
                                                title="watchlist"><i
                                                    class="fa fa-check"></i>{{trans('words.remove_from_watchlist')}}</a></span>
                                        @else
                                        <span class="btn-watchlist text-nowrap"><a
                                                href="{{URL::to('watchlist/add')}}?post_id={{$tv_info->id}}&post_type=LiveTV"
                                                title="watchlist"><i
                                                    class="fa fa-plus"></i>{{trans('words.add_to_watchlist')}}</a></span>
                                        @endif
                                        @else
                                        <span class="btn-watchlist text-nowrap"><a
                                                href="{{URL::to('watchlist/add')}}?post_id={{$tv_info->id}}&post_type=LiveTV"
                                                title="watchlist"><i
                                                    class="fa fa-plus"></i>{{trans('words.add_to_watchlist')}}</a></span>
                                        @endif

                                        <span class="btn-share text-nowrap"><a href="#" class="nav-link" data-bs-toggle="modal"
                                                data-bs-target="#social-media"><i
                                                    class="fas fa-share-alt mr-5"></i>{{trans('words.share_text')}}</a></span>
                                        <span class="btn-share text-nowrap"><a href="#" class="nav-link" tag-role="btn-show-description"><i
                                                    class="fas fa-info mr-1"></i>{{trans('words.description')}}</a></span>

                                        <!-- Start Social Media Icon Popup -->
                                        <div id="social-media" class="modal fade centered-modal in" tabindex="-1"
                                            role="dialog" aria-labelledby="myModal" aria-hidden="true">
                                            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                                <div class="modal-content bg-dark-2 text-light">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title text-white">{{trans('words.share_text')}}
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <div class="social-media-modal">
                                                            <ul>
                                                                <li><a title="Sharing"
                                                                        href="https://www.facebook.com/sharer/sharer.php?u={{share_url_get('livetv',$tv_info->channel_slug,$tv_info->id)}}"
                                                                        class="facebook-icon" target="_blank"><i
                                                                            class="ion-social-facebook"></i></a></li>
                                                                <li><a title="Sharing"
                                                                        href="https://twitter.com/intent/tweet?text={{$tv_info->channel_name}}&amp;url={{share_url_get('livetv',$tv_info->channel_slug,$tv_info->id)}}"
                                                                        class="twitter-icon" target="_blank"><i
                                                                            class="ion-social-twitter"></i></a></li>
                                                                <li><a title="Sharing"
                                                                        href="https://www.instagram.com/?url={{share_url_get('livetv',$tv_info->channel_slug,$tv_info->id)}}"
                                                                        class="instagram-icon" target="_blank"><i
                                                                            class="ion-social-instagram"></i></a></li>
                                                                <li><a title="Sharing"
                                                                        href="https://wa.me?text={{share_url_get('livetv',$tv_info->channel_slug,$tv_info->id)}}"
                                                                        class="whatsapp-icon" target="_blank"><i
                                                                            class="ion-social-whatsapp"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Social Media Icon Popup -->


                                    </div>
                                    <div class="video-description-wrapper d-flex d-none mt-5 w-100">
                                        <span class="video-descrption-subwrapper" tag-role="dispaly-description">
                                            {!!$tv_info->video_description!!}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="vfx-tabs-item mt-30 d-none">
                        <input checked="checked" id="tab1" type="radio" name="pct" />
                        <input id="tab2" type="radio" name="pct" />
                        <input id="tab3" type="radio" name="pct" />
                        <nav>
                            <ul>
                                <li class="tab1">
                                    <label for="tab1">{{trans('words.description')}}</label>
                                </li>
                            </ul>
                        </nav>
                        <section class="tabs_item_block">
                            <div class="tab1">
                                <div class="description-detail-item">

                                    <p>{!!stripslashes($tv_info->channel_description)!!}</p>

                                </div>
                            </div>

                        </section>
                    </div>
                </div>
            </div>
            <!-- Start Popular Videos -->

            <!-- Start You May Also Like Video Carousel -->
            <div class="video-carousel-area vfx-item-ptb related-video-item">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 p-0">
                            <div class="vfx-item-section">
                                <h3>{{trans('words.you_may_like')}}</h3>
                            </div>
                            <div class="tv-season-video-carousel owl-carousel">

                                @foreach($related_livetv_list as $related_data)
                                <div class="single-video">
                                    <a href="{{ URL::to('livetv/details/'.$related_data->channel_slug.'/'.$related_data->id) }}"
                                        title="{{stripslashes($related_data->channel_name)}}">
                                        <div class="video-img">

                                            @if($related_data->channel_access =="Paid")
                                            <div class="vid-lab-premium">
                                                <img src="{{ URL::asset('site_assets/images/ic-premium.png') }}"
                                                    alt="ic-premium" title="ic-premium">
                                            </div>
                                            @endif

                                            <span
                                                class="video-item-content">{{stripslashes($related_data->channel_name)}}</span>
                                            <img src="{{URL::to('/'.$related_data->channel_thumb)}}"
                                                alt="{{stripslashes($related_data->channel_name)}}"
                                                title="{{stripslashes($related_data->channel_name)}}">
                                        </div>
                                    </a>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End You May Also Like Video Carousel -->
        </div>
    </div>
</div>

<!-- End Page Content Area -->

<script type="text/javascript">

    @if (Session:: has('flash_message'))

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: false,
        /*didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }*/
    })

    Toast.fire({
        icon: 'success',
        title: '{{ Session::get('flash_message') }}'
      })

    @endif

</script>

@endsection
@section('user_js')
<script>
    setInterval(()=>{
        document.querySelector('[tag-role="video-live-icon"]').classList.toggle('text-danger');
    },1000);
</script>
<script src="/site_assets/js/customize-videoshow.js"></script>
@endsection