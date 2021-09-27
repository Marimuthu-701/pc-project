@include('mail.includes.header')
<tr>
   <td style="position: relative; float: left; width: 100%; margin:0px 0px 0px 0px; padding: 20px 0px 0px 0px; text-align: left; background: #ffffff;color: #333333;">
      <h1 style=" width: 100%; margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px; font-family: 'Lato', sans-serif; font-size: 18px; text-align: left;color:#005295;">Hello, {{ isset($data['name']) ? $data['name'] : null }}!</h1>
      <h2 style="width: 100%; margin: 0px; padding: 10px 0px 0px 0px; font-family: Lato, sans-serif; font-size: 16px; text-align: left; color: #333333;">Congratulations!</h2>
   </td>
</tr>
<tr>
   <td style="position: relative; float: left; width: 100%; margin:0px 0px 0px 0px; padding: 0px 0px 25px 0px; text-align: left; background: #ffffff;">
      <div style="text-align: left;">
         <p style="margin-top: 10px;margin-bottom: 20px;">
            Your provider service has been approved by the admin and it got listing in the Parents Care site.
         </p>
      </div>
      <div style="text-align: center;margin-top: 25px;">
         <h4><a href="{{route('type.slug', ['type'=>'service', 'slug'=> $data['slug']]) }}" class="btn">View Details</a></h4>
      </div>
   </td>
</tr>
@include('mail.includes.footer')
                        