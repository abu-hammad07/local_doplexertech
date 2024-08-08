<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Slider;
use App\Series;
use App\Movies;
use App\HomeSections;
use App\Sports;
use App\Pages;
use App\RecentlyWatched;
use App\LiveTV;
use App\Transactions; 
use App\UsersDeviceHistory;
use App\Http\Controllers\Auth\SubscribeController;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image; 

use Session;

use ProtoneMedia\LaravelFFMpeg;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use ProtoneMedia\LaravelFFMpeg\Support\ServiceProvider;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use FFMpeg\Filters\AdvancedMedia\ComplexFilters;
use FFMpeg\Filters\Video\WatermarkFilter;

require(base_path() . '/public/device-detector/vendor/autoload.php');
use DeviceDetector\ClientHints;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\AbstractDeviceParser;

AbstractDeviceParser::setVersionTruncation(AbstractDeviceParser::VERSION_TRUNCATION_NONE);

class IndexController extends Controller
{   
 
	  
    public function index()
    {   

        
        // if(!$this->alreadyInstalled())
        // {
        //     return redirect('public/install');
        // }

    	$slider= Slider::where('status',1)->whereRaw("find_in_set('Home',slider_display_on)")->orderby('slider_order','ASC')->get();
        
        if(Auth::check())
        {   
            $current_user_id=Auth::User()->id;
            
            if(getcong('menu_movies')==0 AND getcong('menu_shows')==0)
            {
                $recently_watched = RecentlyWatched::where('user_id',$current_user_id)->where('video_type','!=','Movies')->where('video_type','!=','Episodes')->orderby('id','DESC')->get();
            }
            else if(getcong('menu_sports')==0 AND getcong('menu_livetv')==0)
            {
                $recently_watched = RecentlyWatched::where('user_id',$current_user_id)->where('video_type','!=','Sports')->where('video_type','!=','LiveTV')->orderby('id','DESC')->get();
            }
            else if(getcong('menu_livetv')==0)
            {
                $recently_watched = RecentlyWatched::where('user_id',$current_user_id)->where('video_type','!=','LiveTV')->orderby('id','DESC')->get();
            }   
            else if(getcong('menu_sports')==0)
            {
                $recently_watched = RecentlyWatched::where('user_id',$current_user_id)->where('video_type','!=','Sports')->orderby('id','DESC')->get();
            }
            else if(getcong('menu_movies')==0)
            {
                $recently_watched = RecentlyWatched::where('user_id',$current_user_id)->where('video_type','!=','Movies')->orderby('id','DESC')->get();
            }   
            else if(getcong('menu_shows')==0)
            {
                $recently_watched = RecentlyWatched::where('user_id',$current_user_id)->where('video_type','!=','Episodes')->orderby('id','DESC')->get();
            }
            else
            {
                $recently_watched = RecentlyWatched::where('user_id',$current_user_id)->orderby('id','DESC')->get();
            }   
            
        }
        else
        {
            $recently_watched = array();
        }

        $upcoming_movies = Movies::where('upcoming',1)->orderby('id','DESC')->get();
        $upcoming_series = Series::where('upcoming',1)->orderby('id','DESC')->get();

        //dd($upcoming_movies);exit;
        
        $home_sections = HomeSections::where('status',1)->orderby('id')->get();    
 
        return view('pages.index',compact('slider','recently_watched','upcoming_movies','upcoming_series','home_sections'));
         
    } 

    public function home_collections($slug, $id)
    {
        $home_section = HomeSections::where('id',$id)->where('status',1)->first();

        //echo $home_section->post_type;exit;

        if($home_section->post_type=="Movie")
        {
            return view('pages.home.movies',compact('home_section'));
        }
        else if($home_section->post_type=="Shows")
        {             
            return view('pages.home.shows',compact('home_section'));
        }
        else if($home_section->post_type=="LiveTV")
        {             
            return view('pages.home.livetv',compact('home_section'));
        }
        else if($home_section->post_type=="Sports")
        {             
            return view('pages.home.sports',compact('home_section'));
        }
        else
        {
            return view('pages.home_section',compact('home_section'));
        }
        
    }


    public function alreadyInstalled()
    {   
         
        return file_exists(base_path('/public/.lic'));
    }

    public function search_elastic()
    {
        $keyword = $_GET['s'];  
        
        if(getcong('menu_movies'))
        {
            $s_movies_list = Movies::where('status',1)->where("video_title", "LIKE","%$keyword%")->orderBy('video_title')->get();

        }
        else
        {
            $s_movies_list =array();
        }

        if(getcong('menu_shows'))
        {
            $s_series_list = Series::where('status',1)->where("series_name", "LIKE","%$keyword%")->orderBy('series_name')->get();
        }
        else
        {
            $s_series_list=array();
        }
        
        if(getcong('menu_sports'))
        {
            $s_sports_list = Sports::where('status',1)->where("video_title", "LIKE","%$keyword%")->orderBy('video_title')->get();
        }
        else
        {
            $s_sports_list=array();
        }

        if(getcong('menu_livetv'))
        {
            $live_tv_list = LiveTV::where('status',1)->where("channel_name", "LIKE","%$keyword%")->orderBy('channel_name')->get();
        }
        else
        {
            $live_tv_list=array();
        }
        

        return view('_particles.search_elastic',compact('s_movies_list','s_series_list','s_sports_list','live_tv_list'));
        
    }

    public function search()
    {
        $keyword = $_GET['s'];  
        
        $movies_list = Movies::where('status',1)->where('upcoming',0)->where("video_title", "LIKE","%$keyword%")->orderBy('video_title')->get();

        $series_list = Series::where('status',1)->where('upcoming',0)->where("series_name", "LIKE","%$keyword%")->orderBy('series_name')->get();

        $sports_video_list = Sports::where('status',1)->where("video_title", "LIKE","%$keyword%")->orderBy('video_title')->get();

        $live_tv_list = LiveTV::where('status',1)->where("channel_name", "LIKE","%$keyword%")->orderBy('channel_name')->get();
    
        return view('pages.search',compact('movies_list','series_list','sports_video_list','live_tv_list'));
    }

    public function sitemap()
    {    
        return response()->view('pages.sitemap')->header('Content-Type', 'text/xml');
    }

    public function sitemap_misc()
    {   
        $pages_list = Pages::where('status',1)->orderBy('id')->get();

        return response()->view('pages.sitemap_misc',compact('pages_list'))->header('Content-Type', 'text/xml');
    }
 

    public function sitemap_movies()
    {   
        $movies_list = Movies::where('status',1)->orderBy('id','DESC')->get();

        return response()->view('pages.sitemap_movies',compact('movies_list'))->header('Content-Type', 'text/xml');
    }

    public function sitemap_show()
    {   
        $series_list = Series::where('status',1)->orderBy('id','DESC')->get();

        return response()->view('pages.sitemap_show',compact('series_list'))->header('Content-Type', 'text/xml');
    }

    public function sitemap_sports()
    {   
        $sports_video_list = Sports::where('status',1)->orderBy('id','DESC')->get();

        return response()->view('pages.sitemap_sports',compact('sports_video_list'))->header('Content-Type', 'text/xml');
    }

    public function sitemap_livetv()
    {   
        $live_list = LiveTV::where('status',1)->orderBy('id','DESC')->get();

        return response()->view('pages.sitemap_livetv',compact('live_list'))->header('Content-Type', 'text/xml');
    }

    public function login()
    {
        if (Auth::check()) {
                        
            return redirect('/'); 
        }

        return view('pages.user.login');
    }

    public function postLogin(Request $request)
    {
        
   
        $data =  \Request::except(array('_token'));     
        $inputs = $request->all();

        
        // if(getcong('recaptcha_on_login'))
        // {
        //     $rule=array(
        //         'phone' => 'required|phone',
        //         'password' => 'required',
        //         'g-recaptcha-response' => 'required'                
        //          );
        // }
        // else
        // {
        //     $rule=array(
        //         'email' => 'required|email',
        //         'password' => 'required'              
        //          );
        // }

        $rule=array(
        'phone' => 'required',
        'password' => 'required'              
        );
         
         $validator = \Validator::make($data,$rule);
 
        if ($validator->fails())
        {
                Session::flash('login_flash_error', 'required');
                return redirect()->back()->withInput()->withErrors($validator->messages());
         }

            $credentials = $request->only('phone', 'password');

            $remember_me = $request->has('remember') ? true : false;  
            
            if (Auth::attempt($credentials, $remember_me)) {

                if(Auth::user()->status=='0' AND Auth::user()->deleted_at!=NULL){
                    \Auth::logout();
                      
                    Session::flash('login_flash_error', 'required'); 
                    return redirect('/login')->withInput()->withErrors(trans('words.account_delete_msg'));
                }

                if(Auth::user()->status=='0'){
                    \Auth::logout();
                    Session::flash('login_flash_error', 'required'); 
                    return redirect('/login')->withInput()->withErrors(trans('words.account_banned'));
                 }
 
                return $this->handleUserWasAuthenticated($request);
            }
 
            Session::flash('login_flash_error', 'required'); 
            return redirect('/login')->withInput()->withErrors('The phone or the password is invalid. Please try again.');
 
        
    }
    
     /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $throttles
     * @return \Illuminate\Http\Response
     */
    protected function handleUserWasAuthenticated(Request $request)
    {

        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request, Auth::user());
        }

        /*$previous_session = Auth::User()->session_id;
        if ($previous_session) {
            Session::getHandler()->destroy($previous_session);
        }

        Auth::user()->session_id = Session::getId();
        Auth::user()->save();
        */

        if(Auth::user()->usertype=='Admin' OR Auth::user()->usertype=='Sub_Admin')
        {
            return redirect('admin/dashboard'); 
        }
        else
        {

            $user_id=Auth::user()->id;
            /***Save Device***/
            $userAgent = $_SERVER['HTTP_USER_AGENT']; // change this to the useragent you want to parse

            $dd = new DeviceDetector($userAgent);

            $dd->parse();

            if ($dd->isBot()) {
              // handle bots,spiders,crawlers,...
              $botInfo = $dd->getBot();
            } else {
              $clientInfo = $dd->getClient(); // holds information about browser, feed reader, media player, ...
              $osInfo = $dd->getOs();
              $device = $dd->getDeviceName();
              $brand = $dd->getBrandName();
              $model = $dd->getModel();

                
            if($brand)
              {
                $user_device_name= $brand.' '.$model.' '.$osInfo['platform'].' '.$device;
              }
              else
              {
                $user_device_name= $osInfo['name'].$osInfo['version'].' '.$osInfo['platform'].' '.$device;
              }

                //Save History
                $user_device_obj = new UsersDeviceHistory;

                $user_device_obj->user_id = $user_id;
                $user_device_obj->user_device_name=$user_device_name;   
                $user_device_obj->user_session_name=Session::getId();   
                $user_device_obj->save();

            }

            /***Save Device End***/
            if(session()->get('back_url')){
                $go_url = session()->get('back_url');
                return redirect($go_url); 
            }
            return redirect('/'); 
        }
        
    }
    

    public function signup(Request $request)
    {   
        if($request->has('video_current_time')){
            session()->put('back_with_credential', true);
            session()->put('back_url', $request->input('page_url'));
            session()->put('saved_video_time', $request->input('video_current_time'));
        }
        return view('pages.user.signup');
    }

    public function postSignup(Request $request)
    { 
        $inputs = $request->all();

        $data =  \Request::except(array('_token'));
        
        $rule=array(
        'name' => 'required',                
        'phone' => 'required|regex:/^[0-9]{10,15}$/|unique:users',
        'password' => 'required|confirmed|min:8',
        'password_confirmation' => 'required'                
        );
         
        
        $validator = \Validator::make($data,$rule);
 
        if ($validator->fails())
        {
                Session::flash('signup_flash_error', 'required');
                return redirect()->back()->withInput()->withErrors($validator->messages());
        }
        
        $res = SubscribeController::subscribe_send($request['phone'],$request['password']);

        session()->put('name', $inputs['name']);
        session()->put('phone', $inputs['phone']);
        session()->put('password', $inputs['password']);

        if($res['status'] === 'fail'){
            Session::flash('error_flash_message',$res['content']);
            
        }

        return redirect('/auth/code');
    }

    public function register_validatedUser(Request $request){
        $user = new User;

        //$confirmation_code = str_random(30);

        $user->usertype = 'User';
        $user->name = $request['name']; 
        $user->phone = $request['phone'];         
        $user->password= bcrypt($request['password']);          
        $user->subscribe_state = 1;
        $user->save();

        return $this->postLogin($request);
    }

    public function subscribe(){
        return view('pages.user.code');
    }

    public function postSubscribe(Request $request){
        $pin_code = $request['key1'].$request['key2'].$request['key3'].$request['key4'].$request['key5'].$request['key6'];
        
        $res = SubscribeController::pincode_validation(session()->get('phone'),$pin_code);
        
        if($res['status'] === 'success'){
            $request['name'] = session()->get('name');
            $request['phone'] = session()->get('phone');
            $request['password'] = session()->get('password');

            session()->forget('name');
            session()->forget('phone');
            session()->forget('password');

            return $this->register_validatedUser($request);
        }else{
            Session::flash('error_flash_message',$res['content']);
            return redirect()->back()->withInput();
        }
    }

    public function postResendPincode(Request $request){
        $res = SubscribeController::pincode_resend(session()->get('phone'));
        
        if($res['status'] === 'success'){
            Session::flash('flash_message',$res['content']);
            return redirect()->back()->withInput();
        }else{
            Session::flash('error_flash_message',$res['content']);
            return redirect()->back()->withInput();
        }
    }

    
    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        $user_id=Auth::user()->id;

        //Delete session file
        $user_session_name=Session::getId();        
        \Session::getHandler()->destroy($user_session_name);
 
        $user_device_obj = UsersDeviceHistory::where('user_id',$user_id)->where('user_session_name',$user_session_name);
        $user_device_obj->delete();

        Auth::logout();

        return redirect('/');
    }
    
    public function logout_user_remotely($user_session_name)
    {
        $user_id=Auth::user()->id;
        
        $user_obj = User::findOrFail($user_id);

        //Push Notification on Mobile
       $content = array("en" => "Logout device remotely");

        $fields = array(
                'app_id' => getcong_app('onesignal_app_id'),
                'included_segments' => array('all'),                                            
                'data' => array("foo" => "bar", "logout_remote"=>"1"),
                'filters' => array(array('field' => 'tag', 'key' => 'user_session', 'relation' => '=', 'value' => $user_session_name)),
                'headings'=> array("en" => getcong_app('app_name')),
                'contents' => $content 
            );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8','Authorization: Basic '.getcong_app('onesignal_rest_key')));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $notify_res = curl_exec($ch);  

        curl_close($ch);

        //dd($notify_res);
        //exit;
        

        //Delete session file
        \Session::getHandler()->destroy($user_session_name);
         
        $user_device_obj = UsersDeviceHistory::where('user_id',$user_id)->where('user_session_name',$user_session_name);
        $user_device_obj->delete();      
        
       
        \Session::flash('success', 'Logout device remotely successfully...');

        return redirect('/dashboard');
    } 

    public function check_user_remotely_logout_or_not($user_session_name)
    {
         

        $user_device_obj = UsersDeviceHistory::where('user_session_name',$user_session_name)->first();
        //dd($user_device_obj);
        //exit;

        if($user_device_obj)
        {
           echo "true";
        }
        else
        {
          echo "false";
        }
    }
     
}
