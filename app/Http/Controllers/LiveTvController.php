<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\LiveTV;
use App\TvCategory;
use App\RecentlyWatched;
use App\Slider;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

use Session;

class LiveTvController extends Controller
{
	  
    public function live_tv_list()
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

        $slider= Slider::where('status',1)->whereRaw("find_in_set('LiveTV',slider_display_on)")->orderby('slider_order','ASC')->get();
        
        $pagination_limit=36;

        if(isset($_GET['cat_id']))
        {   
            $channel_cat_id = $_GET['cat_id'];

            $live_tv_list = LiveTV::where('status',1)->where('channel_cat_id',$channel_cat_id)->orderBy('id','DESC')->paginate($pagination_limit);
            $live_tv_list->appends(\Request::only('cat_id'))->links();
        } 
        else if(isset($_GET['filter']))
        {
            $keyword = $_GET['filter'];  

            if($keyword=='old')
            {
                $live_tv_list = LiveTV::where('status',1)->orderBy('id','ASC')->paginate($pagination_limit);
                $live_tv_list->appends(\Request::only('filter'))->links();
            }
            else if($keyword=='alpha')
            {
                $live_tv_list = LiveTV::where('status',1)->orderBy('channel_name','ASC')->paginate($pagination_limit);
                $live_tv_list->appends(\Request::only('filter'))->links();
            }
            else if($keyword=='rand')
            {
                $live_tv_list = LiveTV::where('status',1)->inRandomOrder()->paginate($pagination_limit);
                $live_tv_list->appends(\Request::only('filter'))->links();
            }
            else
            {
                $live_tv_list = LiveTV::where('status',1)->orderBy('id','DESC')->paginate($pagination_limit);
                $live_tv_list->appends(\Request::only('filter'))->links();
            }
            
        }
        else
        {	   
            $live_tv_list = LiveTV::where('status',1)->orderBy('id','DESC')->paginate($pagination_limit);

        }        
       return view('pages.livetv.list',compact('slider','live_tv_list'));
         
    }

    public function live_tv_by_category($slug)
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

       $tv_cat_info = TvCategory::where('category_slug',$slug)->first();       
       
       $cat_id=$tv_cat_info->id;    

       $pagination_limit=16;   

       if(isset($_GET['filter']))
        {
            $keyword = $_GET['filter'];  

            if($keyword=='old')
            {
                $live_tv_list = LiveTV::where('status',1)->where('channel_cat_id',$cat_id)->orderBy('id','ASC')->paginate($pagination_limit);
                $live_tv_list->appends(\Request::only('filter'))->links();
            }
            else if($keyword=='alpha')
            {
                $live_tv_list = LiveTV::where('status',1)->where('channel_cat_id',$cat_id)->orderBy('channel_name','ASC')->paginate($pagination_limit);
                $live_tv_list->appends(\Request::only('filter'))->links();
            }
            else if($keyword=='rand')
            {
                $live_tv_list = LiveTV::where('status',1)->where('channel_cat_id',$cat_id)->inRandomOrder()->paginate($pagination_limit);
                $live_tv_list->appends(\Request::only('filter'))->links();
            }
            else
            {
                $live_tv_list = LiveTV::where('status',1)->where('channel_cat_id',$cat_id)->orderBy('id','DESC')->paginate($pagination_limit);
                $live_tv_list->appends(\Request::only('filter'))->links();
            }
            
        }
        else
        {

             $live_tv_list = LiveTV::where('status',1)->where('channel_cat_id',$cat_id)->orderBy('id','DESC')->paginate($pagination_limit);  
        }      
       return view('pages.livetv_by_category',compact('live_tv_list','tv_cat_info'));
         
    }

    public function live_tv_details($slug,$id)
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

        $tv_info = LiveTV::where('id',$id)->first();

        $related_livetv_list = LiveTV::where('status',1)->where('id','!=',$id)->where('channel_cat_id',$tv_info->channel_cat_id)->orderBy('id','DESC')->take(10)->get();

        return view('pages.livetv.details',compact('tv_info','related_livetv_list')); 
    }

    public function live_tv_single($slug,$id)
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
    	   
        $tv_info = LiveTV::where('id',$id)->first();

        //Check user plan
        // if($tv_info->channel_access=="Paid")
        // {
        //     if(Auth::check())
        //     {
        //         if(Auth::User()->usertype =="User")
        //         {   
        //             $user_id=Auth::User()->id;

        //             $user_info = User::findOrFail($user_id);
        //             $user_plan_id=$user_info->plan_id;
        //             $user_plan_exp_date=$user_info->exp_date;

        //             if($user_plan_id==0 OR strtotime(date('m/d/Y'))>$user_plan_exp_date)
        //             {        
        //                 return redirect('membership_plan');
        //             }
        //         }
        //     }
        //     else
        //     {
        //         \Session::flash('error_flash_message', 'Access denied!');

        //         return redirect('login');
        //     }
        // }

         
        $related_livetv_list = LiveTV::where('status',1)->where('id','!=',$id)->where('channel_cat_id',$tv_info->channel_cat_id)->orderBy('id','DESC')->take(10)->get();
 
        //Recently Watched
        if(Auth::check())
        {
             $current_user_id=Auth::User()->id;
             $video_id=$tv_info->id;

             $recently_video_count = RecentlyWatched::where('video_type','LiveTV')->where('user_id',$current_user_id)->where('video_id',$video_id)->count();

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
                    $video_recent_obj->video_type = 'LiveTV';
                    $video_recent_obj->user_id = $current_user_id;
                    $video_recent_obj->video_id = $video_id;
                    $video_recent_obj->save();
                }
                else
                {
                    $video_recent_obj = new RecentlyWatched;
                    $video_recent_obj->video_type = 'LiveTV';
                    $video_recent_obj->user_id = $current_user_id;
                    $video_recent_obj->video_id = $video_id;
                    $video_recent_obj->save();
                }
            } 

        }

        //View Update
        $v_id=$tv_info->id;
        $video_obj = LiveTV::findOrFail($v_id);        
        $video_obj->increment('views');     
        $video_obj->save();

        $tv_info->proxy_state = false;
        if(Str::startsWith($tv_info->channel_url, 'http://') && Str::endsWith($tv_info->channel_url, 'm3u8')){
            $tv_info->channel_url = route('proxyVideo').'?video_url='.$tv_info->channel_url;
            $tv_info->proxy_state = true;
        }

        return view('pages.livetv.watch',compact('tv_info','related_livetv_list')); 
    }

    
    
}
