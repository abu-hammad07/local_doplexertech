@extends("admin.admin_app")

@section("content")

<style type="text/css">
  .iframe-container {
  overflow: hidden;
  padding-top: 56.25% !important;
  position: relative;
}
 
.iframe-container iframe {
   border: 0;
   height: 100%;
   left: 0;
   position: absolute;
   top: 0;
   width: 100%;
}
</style>
 
  <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="card-box">
                 
              <div class="row">
                     <div class="col-sm-6">
                          <a href="{{ URL::to('admin/slider') }}"><h4 class="header-title m-t-0 m-b-30 text-primary pull-left" style="font-size: 20px;"><i class="fa fa-arrow-left"></i> {{trans('words.back')}}</h4></a>
                     </div>
                     
                   </div>
                

                 {!! Form::open(array('url' => array('admin/slider/add_edit_slider'),'class'=>'form-horizontal','name'=>'slider_form','id'=>'slider_form','role'=>'form','enctype' => 'multipart/form-data')) !!}  
                  
                  <input type="hidden" name="id" value="{{ isset($slider_info->id) ? $slider_info->id : null }}">
  
                   
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.slider_title')}}*</label>
                    <div class="col-sm-8">
                      <input type="text" name="slider_title" value="{{ isset($slider_info->slider_title) ? stripslashes($slider_info->slider_title) : null }}" class="form-control">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Slider Description</label>
                    <div class="col-sm-8">
                      <textarea type="text" required name="slider_description"  class="form-control">
                        {{ isset($slider_info->slider_description) ? strip_tags(stripslashes($slider_info->slider_description)) : '' }}
                      </textarea>
                    </div>
                  </div>

                    
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.slider_image')}}</label>                    
                    <div class="col-sm-8">
                      <div class="input-group">
                        <div class="input"></div>
                        <input type="text" name="slider_image_url" id="slider_image_url" value="{{ isset($slider_info->slider_image) ? ($slider_info->slider_url_state === 1 ? $slider_info->slider_image : URL::to($slider_info->slider_image)) : null }}" class="form-control">
                        <input type="file" name="slider_image_file" id="slider_image_file"  class="form-control d-none">
                        <div class="input-group-append">
                            <select class="form-control" name="image_input_state" id="image_input_state">    
                              <option value="0" selected>URL</option>
                              <option value="1">File</option>
                            </select>
                        </div>
                      </div>
                      <small id="emailHelp" class="form-text text-muted">({{trans('words.recommended_resolution')}} : 1100x450)</small>
                      <div id="image_holder" style="margin-top:5px;max-height:100px;"></div>                     
                    </div>
                  </div>

                  <!-- <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Slider Video</label>                    
                    <div class="col-sm-8">
                      <div class="input-group">
                        <input type="text" name="slider_video" id="slider_video" value="{{ isset($slider_info->slider_image) ? $slider_info->slider_image : null }}" class="form-control" readonly>
                        <div class="input-group-append">                           
                            <button type="button" class="btn btn-dark waves-effect waves-light popup_selector" data-input="slider_image" data-preview="holder_thumb" data-inputid="slider_image">Select</button>                        
                        </div>
                      </div>
                      <small id="emailHelp" class="form-text text-muted">({{trans('words.recommended_resolution')}} : 1100x450)</small>
                      <div id="image_holder" style="margin-top:5px;max-height:100px;"></div>                     
                    </div>
                  </div> -->

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Slider Video</label>                    
                    <div class="col-sm-8">
                      <div class="input-group">
                        <input type="text" name="slider_video_url" required id="slider_video_url" value="{{ isset($slider_info->slider_video) ? $slider_info->slider_video : null }}" class="form-control" >
                        <input type="file" name="slider_video_file"  id="slider_video_file" class="form-control d-none" >
                        <div class="input-group-append">
                            <select class="form-control" name="video_input_state" id="video_input_state">    
                              <option value="0" selected>URL</option>
                              <option value="1">File</option>
                            </select>
                        </div>
                      </div>
                      <div id="image_holder" style="margin-top:5px;max-height:100px;"></div>                     
                    </div>
                  </div>

                  <!-- @if(isset($slider_info->slider_image)) 
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">&nbsp;</label>
                    <div class="col-sm-8">                                                                         
                      <img src="{{$slider_info->slider_url_state === 1 ? $slider_info->slider_image : URL::to($slider_info->slider_image)}}" alt="Image" class="img-thumbnail" width="400">                                               
                    </div>
                  </div>
                  @endif -->

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.post_type')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control" name="slider_type" id="slider_type">    
                                <option value=""> {{trans('words.select_type')}} </option>                            
                                @if(getcong('menu_movies'))
                                <option value="Movies" @if(isset($slider_info->id) && $slider_info->slider_type=="Movies") selected @endif>{{trans('words.movies_text')}}</option>
                                @endif

                                @if(getcong('menu_shows'))
                                <option value="Shows" @if(isset($slider_info->id) && $slider_info->slider_type=="Shows") selected @endif>{{trans('words.tv_shows_text')}}</option>
                                @endif

                                @if(getcong('menu_sports'))
                                <option value="Sports" @if(isset($slider_info->id) && $slider_info->slider_type=="Sports") selected @endif>{{trans('words.sports_text')}}</option>
                                @endif

                                @if(getcong('menu_livetv'))
                                <option value="LiveTV" @if(isset($slider_info->id) && $slider_info->slider_type=="LiveTV") selected @endif>{{trans('words.live_tv')}}</option>
                                @endif                            
                            </select>
                      </div>
                  </div>
                  <div class="form-group row" id="movie_list_id" @if(isset($slider_info->id) && $slider_info->slider_type!="Movies") style="display: none;" @endif @if(!isset($slider_info->id)) style="display: none;" @endif>
                    <label class="col-sm-3 col-form-label">{{trans('words.movies_text')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control select2" name="movie_id" id="movie_id">    
                                <option value=""> {{trans('words.select_movie')}} </option>                            
                                @foreach($movies_list as $movies_data)
                                <option value="{{$movies_data->id}}" @if(isset($slider_info->id) && $slider_info->slider_type=="Movies" && $slider_info->slider_post_id==$movies_data->id) selected @endif>{{$movies_data->video_title}}</option>
                                @endforeach                            
                            </select>
                      </div>
                  </div>
                  <div class="form-group row" id="show_list_id" @if(isset($slider_info->id) && $slider_info->slider_type!="Shows") style="display: none;" @endif @if(!isset($slider_info->id)) style="display: none;" @endif>
                    <label class="col-sm-3 col-form-label">{{trans('words.tv_shows_text')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control select2" name="series_id" id="series_id">    
                                <option value=""> {{trans('words.select_show')}} </option>                            
                                @foreach($series_list as $series_data)
                                <option value="{{$series_data->id}}" @if(isset($slider_info->id) && $slider_info->slider_type=="Shows" && $slider_info->slider_post_id==$series_data->id) selected @endif>{{$series_data->series_name}}</option>
                                @endforeach                            
                            </select>
                      </div>
                  </div>
                  <div class="form-group row" id="sports_list_id" @if(isset($slider_info->id) && $slider_info->slider_type!="Sports") style="display: none;" @endif @if(!isset($slider_info->id)) style="display: none;" @endif>
                    <label class="col-sm-3 col-form-label">{{trans('words.sports_text')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control select2" name="sport_id" id="sport_id">    
                                <option value=""> {{trans('words.select_sport')}} </option>                            
                                @foreach($sports_list as $sports_data)
                                <option value="{{$sports_data->id}}" @if(isset($slider_info->id) && $slider_info->slider_type=="Sports" && $slider_info->slider_post_id==$sports_data->id) selected @endif>{{$sports_data->video_title}}</option>
                                @endforeach                            
                            </select>
                      </div>
                  </div>
                  <div class="form-group row" id="live_tv_list_id" @if(isset($slider_info->id) && $slider_info->slider_type!="LiveTV") style="display: none;" @endif @if(!isset($slider_info->id)) style="display: none;" @endif>
                    <label class="col-sm-3 col-form-label">{{trans('words.live_tv')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control select2" name="live_tv_id" id="live_tv_id">    
                                <option value=""> {{trans('words.select_tv')}} </option>                            
                                @foreach($live_tv_list as $live_tv_data)
                                <option value="{{$live_tv_data->id}}" @if(isset($slider_info->id) && $slider_info->slider_type=="LiveTV" && $slider_info->slider_post_id==$live_tv_data->id) selected @endif>{{$live_tv_data->channel_name}}</option>
                                @endforeach                            
                            </select>
                      </div>
                  </div>
                  
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.display_on')}}</label>
                      <div class="col-sm-8">
                            <?php 
                            if(isset($slider_info->slider_display_on))
                            {
                              $slider_display = array_map('trim', explode(",", $slider_info->slider_display_on));
                            }
                            else
                            {
                              $slider_display = array();
                            }

                          ?>
                          <label style="font-weight: 400;padding-top: 8px;"><input type="checkbox" name="slider_display_on[]" value="Home" id="type_of_b1" @if(in_array('Home', $slider_display)) checked="checked" @endif> {{trans('words.home')}}</label>&nbsp;
                          
                          @if(getcong('menu_movies'))
                          <label style="font-weight: 400;padding-top: 8px;"><input type="checkbox" name="slider_display_on[]" value="Movies" id="type_of_b2" @if(in_array('Movies', $slider_display)) checked="checked" @endif> {{trans('words.movies_text')}}</label>&nbsp;
                          @endif
                          
                          @if(getcong('menu_shows'))
                          <label style="font-weight: 400;padding-top: 8px;"><input type="checkbox" name="slider_display_on[]" value="Shows" id="type_of_b3" @if(in_array('Shows', $slider_display)) checked="checked" @endif> {{trans('words.shows_text')}}</label>&nbsp;
                          @endif
                          
                          @if(getcong('menu_sports'))
                          <label style="font-weight: 400;padding-top: 8px;"><input type="checkbox" name="slider_display_on[]" value="Sports" id="type_of_b4" @if(in_array('Sports', $slider_display)) checked="checked" @endif> {{trans('words.sports_text')}}</label>&nbsp;
                          @endif
                          
                          @if(getcong('menu_livetv'))
                          <label style="font-weight: 400;padding-top: 8px;"><input type="checkbox" name="slider_display_on[]" value="LiveTV" id="type_of_b5" @if(in_array('LiveTV', $slider_display)) checked="checked" @endif> {{trans('words.live_tv')}}</label>
                          @endif
                      </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.status')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control" name="status">                               
                                <option value="1" @if(isset($slider_info->status) AND $slider_info->status==1) selected @endif>{{trans('words.active')}}</option>
                                <option value="0" @if(isset($slider_info->status) AND $slider_info->status==0) selected @endif>{{trans('words.inactive')}}</option>                            
                            </select>
                      </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Slider Order</label>
                    <div class="col-sm-8">
                      <input type="number" name="slider_order" id="slider_order" min="1" value="{{ isset($slider_info->slider_order) ? intval($slider_info->slider_order) : 1 }}" class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="offset-sm-3 col-sm-9 pl-1">
                      <button type="submit" class="btn btn-primary waves-effect waves-light"> {{isset($slider_info->id) ? trans('words.save') : "Add"}} </button>                      
                    </div>
                  </div>
                {!! Form::close() !!} 
              </div>
            </div>            
          </div>              
        </div>
      </div>
      @include("admin.copyright") 
    </div> 
 
 
<script type="text/javascript">
     
     
// function to update the file selected by elfinder
function processSelectedFile(filePath, requestingField) {

    //alert(requestingField);

    var elfinderUrl = "{{ URL::to('/') }}/";

    if(requestingField=="slider_image")
    {
      var target_preview = $('#image_holder');
      target_preview.html('');
      target_preview.append(
              $('<img>').css('height', '5rem').attr('src', elfinderUrl + filePath.replace(/\\/g,"/"))
            );
      target_preview.trigger('change');
    }
 
    //$('#' + requestingField).val(filePath.split('\\').pop()).trigger('change'); //For only filename
    $('#' + requestingField).val(filePath.replace(/\\/g,"/")).trigger('change');
 
}
 
 </script> 

<script type="text/javascript">
    
    @if(Session::has('flash_message'))     
 
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

  @if (count($errors) > 0)
                  
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: '<p>@foreach ($errors->all() as $error) {{$error}}<br/> @endforeach</p>',
            showConfirmButton: true,
            confirmButtonColor: '#10c469',
            background:"#1a2234",
            color:"#fff"
           }) 
  @endif

  </script>    

@endsection
@section('user_js')
  <script src="/site_assets/js/customize_js/admin_slider.js"></script>
@endsection
