<!DOCTYPE html>
<html lang="sr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="robots" content="noindex, nofollow" />
  <meta name="googlebot" content="noindex, nofollow" />
  <meta name="theme-color" content="#333333">

  <meta name="description" content="" />
  <meta property="og:description" content="" />
  <meta name="twitter:description" content="" />

  <meta property="og:image" content="{{ asset('assets/images/share.png') }}"/>
  <meta name="twitter:image" content="{{ asset('assets/images/share.png') }}" />

  <meta property="og:type" content="website" />
  <meta property="og:url" content="{{ url()->full() }}" />
  <meta property="og:site_name" content="Finance Soft4Tech" />

  <meta name="twitter:card" content="summary_large_image"/>
  <meta name="twitter:site" content="Finance Soft4Tech" />
  <meta name="twitter:creator" content="@soft4tech.com" />
  <meta name="twitter:url" content="{{ url()->full() }}" />

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <meta property="og:title" content="Finance Soft4Tech" />
  <meta name="twitter:title" content="Finance Soft4Tech" />
  <title>Soft4Tech</title>
  <link rel="icon" href="{{asset('assets/images/cropped-favicon-32x32.png')}}" sizes="32x32" />
  <link rel="icon" href="{{asset('assets/images/cropped-favicon-192x192.png')}}" sizes="192x192" />
  <link rel="apple-touch-icon" href="{{asset('assets/images/cropped-favicon-180x180.png')}}" />
  <meta name="msapplication-TileImage" content="{{asset('assets/images/cropped-favicon-270x270.png')}}" />  <!-- stylesheets -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="//fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600&family=Source+Serif+Pro:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@fullcalendar/core@4.4.0/main.min.css">
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@fullcalendar/daygrid@4.4.0/main.min.css">
  <link href="//cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
  <link href="{{ asset('assets/stylesheets/fontawesome.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/stylesheets/main.css?v=1.5.3') }}" rel="stylesheet">
  <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />
  <script>
    var url = "{{url('')}}",
        errorMessage = "Došlo je do greške! Molimo pokušajte ponovo.";
  </script>
  {{-- <meta charset="UTF-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
</head>

<body>
  <div id="loader" class="loader-container">
    <div class="loader"></div>
</div>
