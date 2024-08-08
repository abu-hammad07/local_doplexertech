<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ProxyController extends Controller
{
    //change the url to useful url for proxy
    public function convertVideoUrl(){
        $video_url = $_GET['video_url'];
        $video_url = urldecode($video_url);
        $response = HTTP::get($video_url);

        if ($response->successful()) {
            $seperate_respons = explode("\n",$response->body()); 
            $seperate_respons[3] = "/proxy/?video_url=".$video_url;

            $seperate_respons = implode("\n",$seperate_respons);

            return response($seperate_respons,200)->header('Content-Type', $response->header('Content-Type'));
        } else {
            return response('Failed to fetch content from ' . $video_url, $response->status());
        }
    }

    public function getVideoData(){
        $video_url = $_GET['video_url'];
        $video_url = urldecode($video_url);

        $response = HTTP::get($video_url);

        if ($response->successful()) {
            $seperate_respons = explode("\n",$response->body());
            $video_url = explode("/",$video_url);
            $video_url[count($video_url) - 1] = $seperate_respons[3];
            $video_url = implode("/",$video_url);


            $seperate_respons[3] = "/proxy/get_media_url?video_url=".$video_url;

            $seperate_respons = implode("\n",$seperate_respons);

            return response($seperate_respons,200)
                ->header('Content-Type', "application/vnd.apple.mpegurl")
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Origin, Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers');
        } else {
            return response('Failed to fetch content from ' . $video_url, $response->status());
        }
    }

    public function getMediaurl(){
        $video_url = $_GET['video_url'];
        $video_url = urldecode($video_url);

        $response = HTTP::get($video_url);

        if ($response->successful()) {
            $seperate_url = explode("\n",$response->body());

            $video_url = Str::beforeLast($video_url, '/');

            for ($i=0; $i < count($seperate_url); $i++) { 
                if(Str::startsWith($seperate_url[$i],"#EXTINF")){
                    $i ++;
                    $seperate_url[$i] = "/proxy/get_media_data?media_url=".$video_url.$seperate_url[$i];
                }else if(Str::contains($seperate_url[$i],"URI=")){
                    $seperate_url[$i] = Str::replaceFirst("URI=\"", "URI=\"/proxy/get_media_data?media_url=" . $video_url . "/", $seperate_url[$i]);
                }
            }

            $seperate_url = implode("\n",$seperate_url);

            return response($seperate_url,200)
                ->header('Content-Type', "application/vnd.apple.mpegurl")
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Origin, Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers');
        } else {
            return response('Failed to fetch conten ' . $response->status());
        }
    }

    public function getMediaData(){
        $media_url = $_GET['media_url'];
        $media_url = urldecode($media_url);

        $response = HTTP::get($media_url);

        if ($response->successful()) {
            
            return response($response->body(),200)
                ->header('Content-Type', "application/vnd.apple.mpegurl")
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Origin, Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers');
        } else {
            return response('Failed to fetch content ' . $response->status());
        }
    }
}
