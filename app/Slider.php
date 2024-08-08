<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'slider';

    protected $fillable = ['slider_title','slider_image'];


	public $timestamps = false; 
	 
    public static function getMoviesInfo($id) 
    { 
    	$movie_info = Movies::where('status','1')->where('id',$id)->first();
		
		if($movie_info)
		{
			return  $movie_info;
		}
		else
		{
			return  '';
		}
		
	}

}
