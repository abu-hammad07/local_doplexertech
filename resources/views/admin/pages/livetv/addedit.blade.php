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
                          <a href="{{ URL::to('admin/live_tv') }}"><h4 class="header-title m-t-0 m-b-30 text-primary pull-left" style="font-size: 20px;"><i class="fa fa-arrow-left"></i> {{trans('words.back')}}</h4></a>
                     </div>
                     @if(isset($tv_info->id))
                     <div class="col-sm-6">
                        <a href="{{ URL::to('livetv/details/'.$tv_info->channel_slug.'/'.$tv_info->id) }}" target="_blank"><h4 class="header-title m-t-0 m-b-30 text-primary pull-right" style="font-size: 20px;">{{trans('words.preview')}} <i class="fa fa-eye"></i></h4> </a>
                     </div>
                     @endif
                   </div>

                  
                 {!! Form::open(array('url' => array('admin/live_tv/add_edit_live_tv'),'class'=>'form-horizontal','name'=>'video_form','id'=>'video_form','role'=>'form','enctype' => 'multipart/form-data')) !!}  
                  
                  <input type="hidden" name="id" value="{{ isset($tv_info->id) ? $tv_info->id : null }}">

                  <div class="row">

                  <div class="col-md-6">
                    <h4 class="m-t-0 m-b-30 header-title" style="font-size: 20px;">{{trans('words.live_tv_info')}}</h4> 

                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.live_tv_name')}}*</label>
                    <div class="col-sm-8">
                      <input type="text" name="channel_name" value="{{ isset($tv_info->channel_name) ? stripslashes($tv_info->channel_name) : old('channel_name') }}" class="form-control">
                    </div>
                  </div>                  
                  <div class="form-group row">
                    <label for="webSite" class="col-sm-12 col-form-label">{{trans('words.description')}}</label>
                    <div class="col-sm-12">
                      <!--<div class="card-box pl-0 description_box">-->
            
                      <textarea id="elm1" name="channel_description">{{ isset($tv_info->channel_description) ? stripslashes($tv_info->channel_description) : old('channel_description') }}</textarea>
                     
                    <!--</div>-->
                    </div>
                  </div>   

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.live_tv_access')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control" name="video_access" id="video_access" tag-role="choose-video-access">                               
                                <option value="Paid" @if(isset($tv_info->channel_access) AND $tv_info->channel_access=='Paid') selected @endif>{{trans('words.paid')}}</option>
                                <option value="Free" @if(isset($tv_info->channel_access) AND $tv_info->channel_access=='Free') selected @endif>{{trans('words.free')}}</option>                            
                            </select>
                      </div>
                  </div>
                  
                  <div class="form-group row {{(isset($tv_info->channel_access) AND $tv_info->channel_access=='Free') ? 'd-none' : '' }}" tag-role="set-freetime">
                    <label class="col-sm-3 col-form-label">Free Time</label>
                    <div class="col-sm-8">
                      <div class="input-group">
                      <input type="text" name="free_time" onkeypress="return inpute_check_number(event);" id="free_time" value="{{ isset($tv_info->free_time) ? $tv_info->free_time : old('free_time') }}" class="form-control" placeholder="seconds">
                      <div class="input-group-append">
                            <span class="input-group-text"><i class="mdi mdi-clock"></i></span>
                        </div>
                    </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.live_tv_category')}}*</label>
                      <div class="col-sm-8">
                            <select class="form-control select2" name="tv_category">
                                <option value="">{{trans('words.select_category')}}</option>
                                @foreach($cat_list as $cat_data)
                                  <option value="{{$cat_data->id}}" @if(isset($tv_info->id) && $cat_data->id==$tv_info->channel_cat_id) selected @endif>{{$cat_data->category_name}}</option>
                                @endforeach
                            </select>
                      </div>
                  </div> 
                   
                     
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.status')}}</label>
                      <div class="col-sm-8">
                            <select class="form-control" name="status">                               
                                <option value="1" @if(isset($tv_info->status) AND $tv_info->status==1) selected @endif>{{trans('words.active')}}</option>
                                <option value="0" @if(isset($tv_info->status) AND $tv_info->status==0) selected @endif>{{trans('words.inactive')}}</option>                            
                            </select>
                      </div>
                  </div>

                </div>
                <div class="col-md-6">
                    <h4 class="m-t-0 m-b-30 header-title" style="font-size: 20px;">{{trans('words.live_tv_thumb_url')}}</h4>
                    <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.live_tv_stream_type')}} </label>
                      <div class="col-sm-8">
                            <select class="form-control" name="channel_url_type" id="channel_url_type">                               
                                <option value="HLS" @if(isset($tv_info->channel_url_type) AND $tv_info->channel_url_type=="HLS") selected @endif>HLS/m3u8 / MPEG-DASH / YouTube / Vimeo</option>
                                 
                                <option value="Embed" @if(isset($tv_info->channel_url_type) AND $tv_info->channel_url_type=="Embed") selected @endif>Embed Code</option>
                                 
                                                             
                            </select>
                      </div>
                  </div>
                  
                  <div class="form-group row" id="live_url_id" @if(isset($tv_info->channel_url_type) AND $tv_info->channel_url_type!="HLS") style="display:none;" @endif>

                    <div class="col-sm-11">
                    <small id="emailHelp" class="form-text text-muted">(Supported : MP4, YouTube, Vimeo, HLS / m3u8 URL. If you are using external files then those files have to be <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS" target="_blank">CORS</a> enabled otherwise they will not work.)</small></label><br>
                    </div> 

                    <label class="col-sm-3 col-form-label">{{trans('words.server_1_url')}}*</label>
                     <div class="col-sm-8 mb-3">
                      <input type="text" name="channel_url" value="{{ isset($tv_info->channel_url) ? $tv_info->channel_url : old('channel_url') }}" class="form-control">
                    </div><br/>
                    
                    <label class="col-sm-3 col-form-label">{{trans('words.server_2_url')}}</label>
                     <div class="col-sm-8 mb-3">
                      <input type="text" name="channel_url2" value="{{ isset($tv_info->channel_url2) ? $tv_info->channel_url2 : old('channel_url2') }}" class="form-control">
                    </div><br/>

                    <label class="col-sm-3 col-form-label">{{trans('words.server_3_url')}}</label>
                     <div class="col-sm-8">
                      <input type="text" name="channel_url3" value="{{ isset($tv_info->channel_url3) ? $tv_info->channel_url3 : old('channel_url3') }}" class="form-control">
                    </div>

                  </div>
                   
                   
                  <div class="form-group row" id="live_embed_id" @if(isset($tv_info->channel_url_type) AND $tv_info->channel_url_type!="Embed") style="display:none;" @endif @if(!isset($tv_info->channel_url_type)) style="display:none;" @endif>
                     
                  <div class="col-sm-11">
                    <small id="emailHelp" class="form-text text-muted">(Supported : Embeded code only)</small></label><br>
                    </div> 

                    <label class="col-sm-3 col-form-label">{{trans('words.tv_embed_code')}}*</label>
                     <div class="col-sm-8">
                      <textarea class="form-control" name="channel_url_embed">{{ isset($tv_info->channel_url) ? $tv_info->channel_url : null }}</textarea>
                    </div>
                  </div>
                  
                 
 
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.live_tv_logo')}}*</label>
                    <div class="col-sm-8">                       
                      <div class="input-group">
                          <input type="text" name="channel_thumb" id="channel_thumb" value="{{ isset($tv_info->channel_thumb) ? $tv_info->channel_thumb : null }}" class="form-control" readonly>
                          <div class="input-group-append">                           
                            <button type="button" class="btn btn-dark waves-effect waves-light popup_selector" data-input="channel_thumb" data-preview="holder_thumb" data-inputid="channel_thumb">Select</button>                        
                          </div>
                      </div>
                      <small id="emailHelp" class="form-text text-muted">({{trans('words.recommended_resolution')}} : 800x450)</small>
                      <div id="image_holder" style="margin-top:5px;max-height:100px;"></div>                     
                    </div>
                  </div>

                  @if(isset($tv_info->channel_thumb)) 
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">&nbsp;</label>
                    <div class="col-sm-8">
                                                                         
                           <img src="{{URL::to('/'.$tv_info->channel_thumb)}}" alt="video image" class="img-thumbnail" width="200">                        
                       
                    </div>
                  </div>
                  @endif
                   

                   <hr/>
                  <h4 class="m-t-0 m-b-30 header-title" style="font-size: 20px;">{{trans('words.seo')}}</h4>
                  
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.seo_title')}}</label>
                    <div class="col-sm-8">
                      <input type="text" name="seo_title" id="seo_title" value="{{ isset($tv_info->seo_title) ? stripslashes($tv_info->seo_title) : old('seo_title') }}" class="form-control">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.seo_desc')}}</label>
                    <div class="col-sm-8">                       
                      <textarea name="seo_description" id="seo_description" class="form-control">{{ isset($tv_info->seo_description) ? stripslashes($tv_info->seo_description) : old('seo_description') }}</textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">{{trans('words.seo_keyword')}}</label>
                    <div class="col-sm-8">                      
                      <textarea name="seo_keyword" id="seo_keyword" class="form-control">{{ isset($tv_info->seo_keyword) ? stripslashes($tv_info->seo_keyword) : old('seo_keyword') }}</textarea>
                      <small id="emailHelp" class="form-text text-muted">{{trans('words.seo_keyword_note')}}</small>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="offset-sm-9 col-sm-9">
                      <button type="submit" class="btn btn-primary waves-effect waves-light"><i class="fa fa-save"></i> {{trans('words.save')}} </button>                      
                    </div>
                  </div>  
                  
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

    if(requestingField=="channel_thumb")
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
  <script src="/site_assets/js/customize_js/admin_movie.js"></script>
@endsection