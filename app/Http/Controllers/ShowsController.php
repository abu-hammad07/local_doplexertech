<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Series;
use App\Season; 
use App\Episodes; 
use App\HomeSection;
use App\RecentlyWatched;
use App\Slider;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image; 

use Session;

class ShowsController extends Controller
{
	  
    public function shows()
    {   
        if(Auth::check())
        {             
            if(Auth::user()->usertype!="Admin" AND Auth::user()->usertype!="Sub_Admin")  
           {
              if(user_device_limit_reached(Auth::user()->id,Auth::user()->plan_id))
              {                 
                  return redirect('dashboard');
              }
           }
        }

        $slider= Slider::where('status',1)->whereRaw("find_in_set('Shows',slider_display_on)")->orderby('slider_order','ASC')->get();

        $pagination_limit=12;

        $series_list = Series::where('status','1')->where('upcoming',0)->orderBy('id','DESC')->paginate($pagination_limit);
        // $episodes_list = Episodes::where('status','1')->where('single_state',1)->orderBy('id','DESC')->paginate($pagination_limit);

        return view('pages.shows.list',compact('slider','series_list'));
         
    }


    public function show_details($slug,$id)
    {   

        if(Auth::check())
        {             
            if(Auth::user()->usertype!="Admin" AND Auth::user()->usertype!="Sub_Admin")  
           {
              if(user_device_limit_reached(Auth::user()->id,Auth::user()->plan_id))
              {                 
                  return redirect('dashboard');
              }
           }
        }
    	   
       $series_info = Series::where('status',1)->where('id',$id)->first();

       if($series_info=='')
       {
         abort(404, 'Unauthorized action.');
       }

       $season_list = Season::where('status',1)->where('series_id',$id)->get();
       $episode_list = Episodes::where('status',1)->where('episode_series_id',$id)->get();

       $series_latest_episode = Episodes::where('status',1)->where('episode_series_id',$series_info->id)->first();  
 

        return view('pages.shows.details',compact('series_info','season_list','series_latest_episode','episode_list'));
         
    }

    public function single_episode_details($series_id,$episode_id)
    {   

        if(Auth::check())
        {             
            if(Auth::user()->usertype!="Admin" AND Auth::user()->usertype!="Sub_Admin")  
           {
              if(user_device_limit_reached(Auth::user()->id,Auth::user()->plan_id))
              {                 
                  return redirect('dashboard');
              }
           }
        }
    	   
       $series_info = Series::where('status',1)->where('id',$series_id)->first();
       $season_list = Season::where('status',1)->where('series_id',$series_id)->get();


       if($series_info=='')
       {
         abort(404, 'Unauthorized action.');
       }

       $series_info->series_slug = $episode_id;

        return view('pages.shows.details',compact('series_info','season_list'));
         
    }

    public function watch_single_episode($episode_id){
        if(Auth::check())
        {             
            if(Auth::user()->usertype!="Admin" AND Auth::user()->usertype!="Sub_Admin")  
           {
              if(user_device_limit_reached(Auth::user()->id,Auth::user()->plan_id))
              {                 
                  return redirect('dashboard');
              }
           }
        }
           
       $episode_info = Episodes::where('id',$episode_id)->first();  

       if($episode_info=='')
       {
         abort(404, 'Unauthorized action.');
       }

       $episode_up_next_list = Episodes::where('status',1)->where('single_state',0)->where('id','!=',$episode_id)->where('episode_season_id',$episode_info->episode_season_id)->take(4)->get();

       $series_id=$episode_info->episode_series_id;
       $series_info = Series::where('id',$series_id)->first();

       //echo $series_info->series_slug;exit;

 

    //    $season_name= Season::getSeasonInfo($episode_info->episode_season_id,'season_name');

    //    $season_trailer_url= Season::getSeasonInfo($episode_info->episode_season_id,'trailer_url');

    //    $episode_list = Episodes::where('status',1)->where('episode_season_id',$episode_info->episode_season_id)->get();

       $season_list = Season::where('status',1)->where('series_id',$episode_info->episode_series_id)->get();

       //Recently Watched
        if(Auth::check())
        {
             $current_user_id=Auth::User()->id;
             $video_id=$episode_info->id;

             $recently_video_count = RecentlyWatched::where('video_type','Episodes')->where('user_id',$current_user_id)->where('video_id',$video_id)->count();

            if($recently_video_count <=0)
            {
                //Current user recently count
                $current_user_video_count = RecentlyWatched::where('user_id',$current_user_id)->count();

                if($current_user_video_count == 10)
                {   
                    DB::table("recently_watched")
                    ->where("user_id", "=", $current_user_id)
                    ->orderBy("id", "ASC")
                    ->take(1)
                    ->delete();

                    $video_recent_obj = new RecentlyWatched;
                    $video_recent_obj->video_type = 'Episodes';
                    $video_recent_obj->user_id = $current_user_id;
                    $video_recent_obj->video_id = $video_id;
                    $video_recent_obj->save();
                }
                else
                {
                    $video_recent_obj = new RecentlyWatched;
                    $video_recent_obj->video_type = 'Episodes';
                    $video_recent_obj->user_id = $current_user_id;
                    $video_recent_obj->video_id = $video_id;
                    $video_recent_obj->save();
                }
            } 

        }

        //View Update
        $v_id=$episode_info->id;
        $video_obj = Episodes::findOrFail($v_id);        
        $video_obj->increment('views');     
        $video_obj->save();


        return view('pages.shows.episodes_details',compact('episode_info','episode_up_next_list','series_info','season_list'));
    }

    public function season_episodes($series_slug,$season_slug,$id)
    {   
    	   
       $season_info = Season::where('id',$id)->first();
       $episode_list = Episodes::where('status',1)->where('episode_season_id',$id)->get();  

       $series_name= Series::getSeriesInfo($season_info->series_id,'series_name');
       $series_slug= Series::getSeriesInfo($season_info->series_id,'series_slug');


        return view('pages.shows.season_episodes',compact('season_info','episode_list','series_name','series_slug'));
         
    }

    public function episodes_details($series_slug,$season_slug,$id)
    {   
        if(Auth::check())
        {             
            if(Auth::user()->usertype!="Admin" AND Auth::user()->usertype!="Sub_Admin")  
           {
              if(user_device_limit_reached(Auth::user()->id,Auth::user()->plan_id))
              {                 
                  return redirect('dashboard');
              }
           }
        }
           
       $episode_info = Episodes::where('id',$id)->first();  

       if($episode_info=='')
       {
         abort(404, 'Unauthorized action.');
       }

       $episode_up_next_list = Episodes::where('status',1)->where('single_state',0)->where('id','!=',$id)->where('episode_season_id',$episode_info->episode_season_id)->take(4)->get();

       $series_id=$episode_info->episode_series_id;
       $series_info = Series::where('id',$series_id)->first();

       //echo $series_info->series_slug;exit;

 

       $season_name= Season::getSeasonInfo($episode_info->episode_season_id,'season_name');

       $season_trailer_url= Season::getSeasonInfo($episode_info->episode_season_id,'trailer_url');

       $episode_list = Episodes::where('status',1)->where('episode_season_id',$episode_info->episode_season_id)->get();

       $season_list = Season::where('status',1)->where('series_id',$episode_info->episode_series_id)->get();

       //Recently Watched
        if(Auth::check())
        {
             $current_user_id=Auth::User()->id;
             $video_id=$episode_info->id;

             $recently_video_count = RecentlyWatched::where('video_type','Episodes')->where('user_id',$current_user_id)->where('video_id',$video_id)->count();

            if($recently_video_count <=0)
            {
                //Current user recently count
                $current_user_video_count = RecentlyWatched::where('user_id',$current_user_id)->count();

                if($current_user_video_count == 10)
                {   
                    DB::table("recently_watched")
                    ->where("user_id", "=", $current_user_id)
                    ->orderBy("id", "ASC")
                    ->take(1)
                    ->delete();

                    $video_recent_obj = new RecentlyWatched;
                    $video_recent_obj->video_type = 'Episodes';
                    $video_recent_obj->user_id = $current_user_id;
                    $video_recent_obj->video_id = $video_id;
                    $video_recent_obj->save();
                }
                else
                {
                    $video_recent_obj = new RecentlyWatched;
                    $video_recent_obj->video_type = 'Episodes';
                    $video_recent_obj->user_id = $current_user_id;
                    $video_recent_obj->video_id = $video_id;
                    $video_recent_obj->save();
                }
            } 

        }

        //View Update
        $v_id=$episode_info->id;
        $video_obj = Episodes::findOrFail($v_id);        
        $video_obj->increment('views');     
        $video_obj->save();


        return view('pages.shows.episodes_details',compact('episode_info','episode_up_next_list','series_info','season_name','season_trailer_url','episode_list','season_list'));
         
    } 

      
}
