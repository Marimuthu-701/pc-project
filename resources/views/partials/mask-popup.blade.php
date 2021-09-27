@php
	$data = isset($data) ? $data : null;
	$search = isset($search) ? $search : null;
	$web_link = isset($web_link) ? $web_link : null;
	$fees_type = isset($fees_type) ? $fees_type : null;
	$fees = isset($fees) ? $fees : null;
	$fees_nurse = isset($fees_nurse) ? $fees_nurse : '';
	$landline   = isset($landline) ? $landline : null;

	if(isset($mobile) && $mobile) {
		$tool_tip_title = trans('messages.mask_mobile');
	} else if(isset($email) && $email){
		$tool_tip_title = trans('messages.mask_email');
	} else if(isset($contact_person) && $contact_person){
		$tool_tip_title =  trans('messages.mask_contact_person');
	} else if(isset($fees) && $fees){
		$tool_tip_title =  trans('messages.mask_fees_amount');
	} else if(isset($fees_amount) && $fees_amount){
		$tool_tip_title = trans('messages.mask_fees_amount');
	} else if($web_link){
		$tool_tip_title = trans('messages.mask_website_link');
	} else if($landline) {
		$tool_tip_title = trans('messages.landline_mask');
	}else {
		$tool_tip_title = trans('messages.other_mask');
	}
@endphp

@guest
	<span class="content-masked hide">{{ __('**********') }}</span>
	<a href="javascript:void(0);" class="mask-popvoer" data-toggle="tooltip" data-placement="top" title="{{$tool_tip_title}}" data-redirect-url="{{Request::url()}}">Login to view</a>
@else
	@if($search && $data)
		{{ isset($data) ? $data : '-' }}
	@elseif($fees_type == 'nurse')
		{{ isset($data) ? 'Rs. '.currency($data).' '.$fees : '-' }}
	@elseif($data && $web_link)
		<a href="{{ isset($data) ? $data : '-' }}" target="_blank"> {{ isset($data) ? Str::limit($data, 75, '...') : '-' }}</a>
	@else
		{{ isset($data) ? $data : '-' }}
	@endif
@endguest