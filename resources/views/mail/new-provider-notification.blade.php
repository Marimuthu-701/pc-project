@include('mail.includes.header')
<tr>
   <td style="position: relative; float: left; width: 100%; margin:0px 0px 0px 0px; padding: 20px 0px 0px 0px; text-align: left; background: #ffffff;color: #333333;">
      <h1 style=" width: 100%; margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px; font-family: 'Lato', sans-serif; font-size: 18px; text-align: left;color:#005295;">Hello, Admin!</h1>
      <h2 style="width: 100%; margin: 0px; padding: 10px 0px 0px 0px; font-family: Lato, sans-serif; font-size: 16px; text-align: left; color: #333333;">New provider has been registered.</h2>
      <p style="font-size: 14px;font-weight: normal;color: #333333">Please find the details below.</p>
   </td>
</tr>
<tr>
   <td style="position: relative; float: left; width: 100%; margin:0px 0px 0px 0px; padding: 0px 0px 25px 0px; text-align: left; background: #ffffff;">
      <div style="text-align: left;">
         <p class="label" style="margin-top: 10px;">Name: <span style="padding: 0px 10px;font-weight: normal;">{{ isset($data['name']) ?  $data['name'] : null}}</span></p>
         <p class="label">Type: <span>{{ isset($data['type']) ? $data['type'] : null }}</span></p>
         @if(isset($data['fees_amount']) && $data['fees_amount'])
            <p class="label">Fees: <span>{{ isset($data['fees_amount']) ? $data['fees_amount'] : null }}</span></p>
         @endif
         @if(isset($data['fees_type']) && $data['fees_type'])
            <p class="label">Fees Type: <span>{{ isset($data['fees_type']) ? $data['fees_type'] : null }}</span></p>
         @endif
         @if(isset($data['id_proof']) && $data['id_proof'])
            <p class="label">ID Proof: <span>{{ isset($data['id_proof']) ? $data['id_proof'] : null }}</span></p>
         @endif
         @if(isset($data['area_of_spl']) && $data['area_of_spl'])
            <p class="label">Area of Specialization: <span>{{ isset($data['area_of_spl']) ? $data['area_of_spl'] : null }}</span></p>
         @endif
         @if(isset($data['room_rent']) && $data['room_rent'])
            <p class="label">Room Rent: ₹<span>{{ isset($data['room_rent']) ? $data['room_rent'] : null }}</span></p>   
         @endif
         <p class="label">City: <span>{{ isset($data['city']) ? $data['city'] : null }}</span></p>
         <p class="label">State: <span>{{ isset($data['state']) ? $data['state'] : null }}</span> </p>
         <p class="label">Postal Code: <span>{{ isset($data['pin_code']) ? $data['pin_code'] : null }}</span></p>
      </div>      
         @if(isset($data['profile_url']) && $data['profile_url'])
            <div class="profile_photo">
               <p class="label">Profile Photo: </p> <img src="{{$data['profile_url']}}">
            </div>
         @endif
         @if(isset($data['id_proof_photo_url']) && count($data['id_proof_photo_url']) > 0)
            <div class="id_proof"><p class="label">Id Proof : </p>
               @foreach($data['id_proof_photo_url'] as $value)
                  <img src="{{$value['id_proof_url']}}">
               @endforeach
            </div>
         @endif
      <div style="text-align: center;">
         <h4><a href="{{route('admin.partners.services.view', ['id'=> $data['id']])}}" class="btn" style="margin-right: 20px;">View Details</a>
         <a href="{{route('provider.approval', ['token'=>$data['token']])}}" class="btn">Approve</a></h4>
      </div>
   </td>
</tr>
@include('mail.includes.footer')
                        