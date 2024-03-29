@if (env('GOOGLE_ANALYTICS_TRACKING_ID'))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GOOGLE_ANALYTICS_TRACKING_ID') }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', "{{ env('GOOGLE_ANALYTICS_TRACKING_ID') }}");
    </script>
@endif