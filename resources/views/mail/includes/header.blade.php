<html>
   <head>
      <title>{!! config('app.name', 'The Parents Care') !!}</title>
      <style type="text/css">
         @import url('https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900');
         @import url('https://fonts.googleapis.com/css?family=Varela+Round');
         body{margin: 0; font-family: 'Lato',sans-serif;}
         @media screen and (max-device-width: 480px),
         screen and (max-width: 480px){
            .width-100{width: 100% !important;}
         }
         p {            
            color: #333333;
            text-align: left;
         }
         p.label { font-weight: 600;  }
         p.label span { padding: 0px 5px;font-weight: normal; }
         .btn { font-size: 13px; font-family: 'Lato', sans-serif; font-weight: 600; background:#005295; border-radius: 50px;  padding: 10px 20px; color:#ffffff !important; text-decoration: none; text-transform: uppercase; }
      </style>
   </head>
   <body>
      <table align="center" border="0" cellpadding="0" cellspacing="0" class="content" style="height:auto;width: 100%; margin:0 auto;padding:0%;background-color: #f1f1f1">
         <tbody>
            <tr>
               <td>
                  <table align="center" border="0" cellpadding="0" cellspacing="0" class="content" style="height:auto; max-width:650px; width: 100%; margin: 25px auto 5px; background-color: #ffffff; padding: 0 25px;">
                     <tbody>
                        <tr>
                           <td style="width:100%; text-align: center; background: #ffffff; border-bottom: 1px solid #666666;">
                              <a href="{{ url('/') }}" style="display: block;width:100%; float:left; text-align: center; padding:40px 0 25px;">
                              <img style="max-width: 300px;" alt="{{ config('app.name') }}" src="{{ asset('images/parents_care_email_logo.png') }}" /> 
                              </a>
                           </td>
                        </tr>