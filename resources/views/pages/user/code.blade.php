@extends('site_app')

@section('head_title', 'Pincode' )

@section('head_url', Request::url())

@section('content')


<!-- Login Main Wrapper Start -->
<div id="main-wrapper">
  <div class="container-fluid px-0 m-0 h-100 mx-auto">
    <div class="row g-0 min-vh-100 overflow-hidden">
      <!-- Welcome Text -->
      <div class="col-md-12">
        <div class="hero-wrap d-flex align-items-center h-100">
          <div class="hero-mask"></div>
          <div class="hero-bg hero-bg-scroll"
            style="background-image:url('{{ URL::asset('site_assets/images/login-signup-bg-img.jpg') }}');"></div>
          <div class="hero-content mx-auto w-100 h-100 d-flex flex-column justify-content-center">
            <div class="row">
              <div class="col-12 col-lg-5 col-xl-5 mx-auto">
                <div class="logo mt-40 mb-20 mb-md-0 justify-content-center d-flex text-center">

                  @if(getcong('site_logo'))
                  <a href="{{ URL::to('/') }}" title="logo"><img src="{{ URL::asset('/'.getcong('site_logo')) }}"
                      alt="logo" title="logo" class="login-signup-logo"></a>
                  @else
                  <a href="{{ URL::to('/') }}" title="logo"><img src="{{ URL::asset('site_assets/images/logo.png') }}"
                      alt="logo" title="logo" class="login-signup-logo"></a>
                  @endif

                </div>
              </div>
            </div>
            <!-- Login Form -->
            <div class="col-lg-4 col-md-6 col-sm-6 mx-auto d-flex align-items-center login-item-block">
              <div class="container login-part">
                <div class="row">
                  <div class="col-12 col-lg-12 col-xl-12 mx-auto ">
                    <div class="position-absolute"><span><i onclick="window.history.back()" class="fa fa-arrow-left" style="font-size: 25px; color:#FF6506"></i></sa></div>
                    <h2 class="d-flex align-items-center justify-content-center text-center mb-4"
                      style="background-color: none;">Enter Code</h2>
                    <p class="d-flex align-items-center justify-content-center text-center mb-4"
                      style="background-color: none;">We have sent you SMS with 6 digits verification code on</p>
                    {!! Form::open(array('url' => 'auth/code','class'=>'','id'=>'loginform','role'=>'form')) !!}  
                    <div class="form-group d-flex gap-2">
                        <input type="text"  onkeyup="moveToNext(this, event)" maxlength="1" tag-role="input-pincode" name="key1" id="key1"
                            class="form-control text-center" required>
                        <input type="text"  onkeyup="moveToNext(this, event)" maxlength="1" tag-role="input-pincode" name="key2" id="key2"
                            class="form-control text-center" required>
                        <input type="text"  onkeyup="moveToNext(this, event)" maxlength="1" tag-role="input-pincode" name="key3" id="key3"
                            class="form-control text-center" required>
                        <input type="text"  onkeyup="moveToNext(this, event)" maxlength="1" tag-role="input-pincode" name="key4" id="key4"
                            class="form-control text-center" required>
                        <input type="text"  onkeyup="moveToNext(this, event)" maxlength="1" tag-role="input-pincode" name="key5" id="key5"
                            class="form-control text-center" required>
                        <input type="text"  onkeyup="moveToNext(this, event)" maxlength="1" tag-role="input-pincode" name="key6" id="key6"
                            class="form-control text-center" required>
                    </div>
                    <button class="btn-submit btn-block my-4 mb-4" type="submit">Continue</button>
                    {!! Form::close() !!}
                    <p class="text-3 text-center mb-3 d-flex align-items-center justify-content-center text-nowrap">
                      Didn't recieve code?<a href="{{ url('/auth/resend_pincode') }}" class="btn-link" title="signup">Resend Code</a>
                    </p>
                    <div class="socail-login-item mx-auto w-100 text-center">

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Login Form End -->
          </div>
        </div>
      </div>
      <!-- Welcome Text End -->
    </div>
  </div>
</div>
<!-- End Login Main Wrapper -->


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

  @if (Session:: has('error_flash_message'))

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
    icon: 'error',
    title: '{{ Session :: get('error_flash_message') }}'
      })

@endif

  @if (Session :: has('pincode_flash_error'))
    @if (count($errors) > 0)
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        html: '<p>@foreach ($errors->all() as $error) {{$error}}<br/> @endforeach</p>',
        showConfirmButton: true,
        confirmButtonColor: '#10c469',
        background: "#1a2234",
        color: "#fff"
      })
    @endif
  @endif

 
  function moveToNext(currentInput, event) {
    if(isNaN(event.key)) return;

    currentInput.value = event.key;
    var nextInput = currentInput.nextElementSibling;
    if (nextInput != null) {
      nextInput.focus();
    }
  }
</script>


@endsection