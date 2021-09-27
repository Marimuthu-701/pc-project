@include('mail.includes.header')
<tr>
   <td style="position: relative; float: left; width: 100%; margin:0px 0px 0px 0px; padding: 20px 0px 0px 0px; text-align: left; background: #ffffff;color: #333333;">
      <h1 style=" width: 100%; margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px; font-family: 'Lato', sans-serif; font-size: 18px; text-align: left;color:#005295;">
         @if(isset($data['name']) && $data['name'])
            Hello, {{ isset($data['name']) ? $data['name'] : null }}!
         @else
            Hello!
         @endif
         </h1>
   </td>
</tr>
<tr>
   <td style="position: relative; float: left; width: 100%; margin:0px 0px 0px 0px; padding: 0px 0px 25px 0px; text-align: left; background: #ffffff;">
      <div style="text-align: left;">
         <p style="margin-top: 10px;margin-bottom: 20px;">
            You are receiving this email because we received a account delete request for your account.
         </p>
         <p>
            Your account delete vefification code is: <span style="font-weight: bold;font-size: 15px;">{{ $data['code'] }}</span>
         </p>
      </div>
   </td>
</tr>
@include('mail.includes.footer')