<footer>
  <div class="footer-area vfx-item-ptb py-3" style="position:relative">
    <div class="footer-wrapper">
      <div class="container-fluid" >
        <div class="row d-flex align-items-center justify-content-around footer-tag">
          <div class="col-3 col-sm-1 d-flex align-items-center justify-content-center">
            <div class="footer-logo" style="height:65px">
              <img src="{{ URL::asset('site_assets/images/logo.png') }}" width="100%" height="100%" style="object-fit: cover;" alt="">
            </div>
          </div>
          <div class="col d-flex align-items-center justify-content-around">
              <ul class="d-flex align-items-center justify-content-around flex-wrap">
                @foreach(\App\Pages::where('status','1')->orderBy('page_order')->get() as $page_data)
                <li class="px-1"><a href="{{ URL::to('page/'.$page_data->page_slug) }}"class="text-center text-nowrap"
                    title="{{$page_data->page_title}}">{{$page_data->page_title}}</a></li>
                @endforeach
              </ul>
          </div>
          <div class="col d-flex align-items-center justify-content-around">
            <div class="footer-bottom">
              <div class="copyright-text text-center">
                <p>{{stripslashes(getcong('site_copyright'))}}</p>
              </div>
            </div>
          </div>
          <div class="col d-flex align-items-center justify-content-around">
            <div class="social-links w-100 d-flex align-items-center justify-content-around">
              <ul>
                <li><a href="{{stripslashes(getcong('footer_fb_link'))}}" title="facebook"><i
                      class="ion-social-facebook"></i></a></li>
                <li><a href="{{stripslashes(getcong('footer_twitter_link'))}}" title="twitter"><i
                      class="ion-social-twitter"></i></a></li>
                <li><a href="{{stripslashes(getcong('footer_instagram_link'))}}" title="instagram"><i
                      class="ion-social-instagram"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- Start Scroll Top Area -->
      <div class="scroll-top">
        <div class="scroll-icon"> <i class="fa fa-angle-up"></i> </div>
      </div>
    </div>
    <ul class="footer-btns row">
      <ul class="d-flex align-items-center justify-content-around w-100">
        <li class="d-flex align-items-center justify-content-center flex-column"><i class="fa fa-home"></i><span>Home</span></li>
        <li class="d-flex align-items-center justify-content-center flex-column"><i class="fa fa-search"></i><span>Search</span></li>
        <li class="d-flex align-items-center justify-content-center flex-column"><i class="fa fa-user"></i><span>Account</span></li>
        <li class="d-flex align-items-center justify-content-center flex-column"><i class="fa fa-list"></i><span>WatchList</span></li>
      </ul>
    </div>
  </div>
    <!-- End Scroll Top Area -->
</footer>