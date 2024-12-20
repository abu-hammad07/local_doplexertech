<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\Slider; 
use App\Movies;
use App\Series;
use App\Sports;
use App\LiveTV;

use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Intervention\Image\Facades\Image; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class SliderController extends MainAdminController
{
	public function __construct()
    {
		 $this->middleware('auth');
		  
		parent::__construct();
        check_verify_purchase(); 	
		  
    }
    public function slider_list()    { 
        
        if(Auth::User()->usertype!="Admin" AND Auth::User()->usertype!="Sub_Admin")
            {

                \Session::flash('flash_message', trans('words.access_denied'));

                return redirect('dashboard');
                
             }

        $page_title=trans('words.slider'); 

        //$season_list = Season::orderBy('id','DESC')->paginate(10);
        $slider_list = Slider::orderBy('slider_order','ASC')->paginate(8);        
         
        return view('admin.pages.slider.list',compact('page_title','slider_list'));
    }
    
    public function addSlider()    { 
        
        if(Auth::User()->usertype!="Admin" AND Auth::User()->usertype!="Sub_Admin")
            {

                \Session::flash('flash_message', trans('words.access_denied'));

                return redirect('dashboard');
                
             }

        $page_title=trans('words.add_slider');

        $movies_list = Movies::orderBy('id','DESC')->get();
        $series_list = Series::orderBy('id','DESC')->get();
        $sports_list = Sports::orderBy('id','DESC')->get();
        $live_tv_list = LiveTV::orderBy('id','DESC')->get();
 
        return view('admin.pages.slider.addedit',compact('page_title','movies_list','series_list','sports_list','live_tv_list'));
    }
    
    public function addnew(Request $request)
    { 
        $data =  \Request::except(array('_token')) ;
        
        if(!empty($inputs['id'])){
                $rule=array(
                'slider_title' => 'required'
                  );
        }else
        {
            $rule=array(
                'slider_title' => 'required',
                 );
        }
        
         $validator = \Validator::make($data,$rule);
 
        if ($validator->fails())
        {
                return redirect()->back()->withErrors($validator->messages());
        } 
        $inputs = $request->all();
        
        if(!empty($inputs['id'])){
           
            $slider_obj = Slider::findOrFail($inputs['id']);

        }else{

            $slider_obj = new Slider;

        }

        $app_url = env('APP_URL');

         
         $slider_obj->slider_title = addslashes($inputs['slider_title']);
         $slider_obj->slider_description = addslashes($inputs['slider_description']);

         if($inputs['image_input_state']){
            $file = $request->file('slider_image_file');
            
            $randomString = Str::random(10);

            $filename = $file->getClientOriginalName();
            $newFileName = $randomString . '.' . $filename;

            // Store the file in the specified disk and directory
            $path = $file->storeAs('img', $newFileName, 'upload_file');
            $slider_obj->slider_image = $app_url. '/upload/' .$path;

         }else{
            $slider_obj->slider_image = $inputs['slider_image_url'];
         }

         if($inputs['video_input_state']){
            $file = $request->file('slider_video_file');
            
            $randomString = Str::random(10);

            $filename = $file->getClientOriginalName();
            $newFileName = $randomString . '.' . $filename;

            // Store the file in the specified disk and directory
            $path = $file->storeAs('video', $newFileName, 'upload_file');
            
            
            $slider_obj->slider_video = $app_url. '/upload/' . $path;

         }else{
            $slider_obj->slider_video = $inputs['slider_video_url'];
         }
         //$slider_obj->slider_url = $inputs['slider_url']; 

         $slider_obj->slider_type=$inputs['slider_type'];

         $slider_type=$inputs['slider_type'];
          
        if($slider_type=="Movies")
        {
            $slider_obj->slider_post_id=$inputs['movie_id'];
        }
        else if($slider_type=="Shows")
        {   
            
            $slider_obj->slider_post_id=$inputs['series_id'];
        }
        else if($slider_type=="Sports")
        {
            $slider_obj->slider_post_id=$inputs['sport_id'];
        }
        else if($slider_type=="LiveTV")
        {
            $slider_obj->slider_post_id=$inputs['live_tv_id'];
        }
        else
        {
            $slider_obj->slider_post_id=NULL;
        }

        if(isset($inputs['slider_display_on']))
        {
            $slider_obj->slider_display_on = implode(',',$inputs['slider_display_on']);    
        }
 
         $slider_obj->file_url_state = 1;
         $slider_obj->status = $inputs['status']; 

         if($slider_obj->slider_order != $inputs['slider_order']){
            $this->adjust_slider_order($inputs['slider_order']);
         }
         $slider_obj->slider_order = $inputs['slider_order']; 
         
         $slider_obj->save();
          
        
        if(!empty($inputs['id'])){

            \Session::flash('flash_message', trans('words.successfully_updated'));

            return \Redirect::back();
        }else{

            \Session::flash('flash_message', trans('words.added'));

            return \Redirect::back();

        }            
        
         
    }     

    // adjust the slider order depend on change
    public function adjust_slider_order($id){
        if(Slider::where('slider_order',$id)->exists()) {
            $this->adjust_slider_order($id + 1);
            Slider::where('slider_order',$id)->update(['slider_order' => $id + 1]);
        }else{
            return;
        }
    }
   
    
    public function editSlider($slider_id)    
    {     
          if(Auth::User()->usertype!="Admin" AND Auth::User()->usertype!="Sub_Admin")
            {

                \Session::flash('flash_message', trans('words.access_denied'));

                return redirect('dashboard');
                
             }  

          $page_title=trans('words.edit_slider');

          $slider_info = Slider::findOrFail($slider_id);

          $movies_list = Movies::orderBy('id','DESC')->get();
          $series_list = Series::orderBy('id','DESC')->get();
          $sports_list = Sports::orderBy('id','DESC')->get();
          $live_tv_list = LiveTV::orderBy('id','DESC')->get();
 
          return view('admin.pages.slider.addedit',compact('page_title','slider_info','movies_list','series_list','sports_list','live_tv_list'));
        
    }	 
     
    	
}
