@if(env('HELP_VIDEO_ID'))
    <div class="help-icon">
         <a href="javascript:void(0);" class="help-video-popup">
            <i class="fas fa-info-circle"></i>
        </a>
    </div>
@endif
<div class="modal fade" id="help-video-popup" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="help-video" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered" role="document">
      <div class="modal-content">
          <div class="modal-body">
              <button type="button" class="close equipment-close-btn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <iframe  id="help-video-iframe" width="560" height="315" src="https://www.youtube.com/embed/{{env('HELP_VIDEO_ID', 'LXb3EKWsInQ')}}" frameborder="0" allowfullscreen></iframe>
          </div>
      </div>
    </div>
</div>

<footer id="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="footer-inner">
                    <div class="social">
                        <ul>
                            <li><a href="https://www.facebook.com/TheParentsCare" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="https://www.youtube.com/channel/UCwJuX07jnDnkOiCIPW7s6aA" target="_blank"><i class="fab fa-youtube"></i></a></li>
                            <li><a href="https://www.linkedin.com/company/the-parents-care" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                        </ul>
                    </div>
                    <ul>
                        <li><a href="{{ route('about.us') }}" target="_blank">About Us<span>|</span></a></li>
                        <li><a href="{{ route('terms.conditions') }}" target="_blank">T&C<span>|</span></a></li>
                        <li><a href="{{ route('privacy.policy') }}" target="_blank">Privacy Policy<span>|</span></a></li>
                        <!-- <li><a href="#" target="_blank">Careers<span>|</span></a></li> -->
                        <li><a href="{{ route('contact') }}" target="_blank">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><p>© 2020 by The Parents Care. All rights reserved.</p></div>
            </div>
        </div>
    </div>
    @include('partials.login-popup')
</footer>