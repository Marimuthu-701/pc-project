@include('mail.includes.header')
<tr>
   <td style="position: relative; float: left; width: 100%; margin:0px 0px 0px 0px; padding: 20px 0px 0px 0px; text-align: left; background: #ffffff;color: #333333;">
      <h1 style=" width: 100%; margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px; font-family: 'Lato', sans-serif; font-size: 18px; text-align: left;color:#005295;">Hello, Admin!</h1>
      <h2 style="width: 100%; margin: 0px; padding: 10px 0px 0px 0px; font-family: Lato, sans-serif; font-size: 16px; text-align: left; color: #333333;">New testimonial has been posted.</h2>
      <p style="font-size: 14px;font-weight: normal;color: #333333">Please find the details below.</p>
   </td>
</tr>
<tr>
   <td style="position: relative; float: left; width: 100%; margin:0px 0px 0px 0px; padding: 0px 0px 25px 0px; text-align: left; background: #ffffff;">
      <div style="text-align: left;">
         <p class="label" style="margin-top: 10px;">Name: <span style="padding: 0px 10px;font-weight: normal;">{{ isset($data['name']) ?  $data['name'] : null}}</span></p>
         @if(isset($data['email']) && $data['email'])
            <p class="label">Email: <span>{{ isset($data['email']) ? $data['email'] : null }}</span> </p>
         @endif
         <p class="label">Address: <span>{{ isset($data['address']) ? $data['address'] : null }}</span></p>
         @if(isset($data['rating']) && $data['rating'])
            <p class="label">Rating: <span>{{ isset($data['rating']) ? $data['rating'] : null }}</span></p>
         @endif
         <p class="label">Description: <span>{{ isset($data['description']) ? $data['description'] : null }}</span></p>
      </div>

      <div style="text-align: center;">
         <h4>
            <a href="{{ route('admin.testimonials.show', ['testimonial'=> $data['id']]) }}" class="btn" style="margin-right: 20px;">View Details</a>
            <a href="{{route('testimonial.approve', ['token'=>$data['token']])}}" class="btn">Approve</a>
         </h4>
      </div>
   </td>
</tr>
@include('mail.includes.footer')