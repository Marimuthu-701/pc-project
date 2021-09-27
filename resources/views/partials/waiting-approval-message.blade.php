<div class="alert alert-success awaiting-message" role="alert">
    <h4 class="alert-heading">Well done!</h4>
    @if(isset($type) && $type)
    	<p>Thank you! You have been successfully registered with The Parents Care.</p>
    @else
    	<p>{{trans('messages.approval_message') }}</p>
    @endif
</div>