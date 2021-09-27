<div class="container">
  <div class="row">
    <div class="col-md-3">
        <div class="left-menu-container">
        <ul class="nav nav-pills  nav-stacked myaccount-left-menu">
          <li><a href="#my-account" data-toggle="pill" class="active">{{ trans('messages.my_account')}}</a></li>
          @if($userType == App\Models\User::TYPE_PARTNER)
            <li>
              @if($serviceInfo)
                <a href="#my-service" data-toggle="pill"> {{ trans('messages.my_service') }} </a>
              @else
                <a href="{{ route('service.provider') }}"> {{ trans('messages.my_service') }} </a>
              @endif
            </li>
          @endif
          @if($userType != App\Models\User::TYPE_PARTNER)
            <li data-key="wish_list"><a href="#wish-list" data-toggle="pill"> {{ trans('messages.wish_list') }}</a></li>
          @endif
          <li><a href="#" data-toggle="pill" onclick="event.preventDefault();
                                                     document.getElementById('logout-myaccount-form').submit();"> {{ trans('messages.logout') }}</a></li>
        </ul>
      </div>
    </div>
    <div class=" col-md-9 my-account-right-panel">
        @if(($userType == App\Models\User::TYPE_PARTNER) && ($approvalStatus == App\Models\User::STATUS_PENDING))
            @include('partials.waiting-approval-message')
        @elseif(Session::has('message'))
            @include('partials.waiting-approval-message', ['type'=>App\Models\User::TYPE_USER])
        @elseif(Session::has('profile_updated') || $updateApproveMessage)
            <div class="custom_success alert alert-success"> {{ trans('messages.provider_updated_approval_message') }} </div>
        @endif
        <div class="tab-content myaccount-container">
            <div class="tab-pane active" id="my-account">
              @include('partials.myaccount-detail')
            </div>
          @if($userType == App\Models\User::TYPE_PARTNER)
            <div class="tab-pane" id="my-service">
              @include('partials.my-service-provider')
            </div>
          @endif
          @if($userType != App\Models\User::TYPE_PARTNER)
          <div class="tab-pane" id="wish-list">
              @include('partials.my-wish-list')
          </div>
          @endif
          <div class="tab-pane" id="logout">
              <form id="logout-myaccount-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
          </div>
        </div>
    </div>
  </div>
</div>
@push('script')
  <script>
    $(document).ready(function(){
        $('.myaccount-left-menu li').on('click', function() {
            var wish_list = $(this).data('key');
              if (wish_list != undefined && wish_list == "wish_list"){
                $('#myaccount-section .myaccount-container').css('box-shadow','unset');
              } else {
                $('#myaccount-section .myaccount-container').css('box-shadow','0px 5px 10px 0px rgba(0,0,0,0.09)');
              }
        });
    });
  </script>
@endpush