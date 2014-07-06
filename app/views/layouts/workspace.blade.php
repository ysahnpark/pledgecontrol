<!doctype html>
<html >
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>PC | {{ $content_header }}</title>
      <meta name="description" content="">
      <meta name="viewport" content="width=device-width">
      <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
      
      {{ HTML::script('js/jquery-2.1.0.min.js') }}
      {{ HTML::script('js/jquery-ui-1.10.4.min.js') }}
      
      {{ HTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.6/angular.min.js') }}

      {{ HTML::style('bootstrap/css/bootstrap.css') }}
      {{ HTML::style('css/main.css') }}
      {{ HTML::script('bootstrap/js/bootstrap.js') }}
      {{ HTML::script('js/lodash.min.js') }}

      <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
      <link href='http://fonts.googleapis.com/css?family=Questrial|Dosis|ABeeZee|Poiret+One|Quicksand|Source+Code+Pro|Nunito|Varela+Round|Actor|Milonga|Anonymous+Pro' rel='stylesheet' type='text/css'>

      <!-- endbuild 
      <script src="bower_components/modernizr/modernizr.js"></script>
      -->
  </head>
  <body>
        <!--[if lt IE 10]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

      <div class="navbar navbar-default navbar-fixed-top">
        <div class="navbar-header">
        </div>
        <div style="margin-left: 220px ;"><a href="http://stdaveluychurch.org/"><img src="/org_logo.png" height="45" /></a></div>
      </div>

    <div class="container-fluid">
      <div class="row">
        <!-- SIDE BAR { -->
        <div class="col-sm-3 col-md-2 sidebar fixed-left">
          <h3>Pledge Control</h3>
          @include('_partials.menu_side')
        </div>
        <!-- } SIDE BAR -->

        <!-- MAIN CONTENT { -->
        

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

          @if (!empty($breadcrumb))
          <ol class="breadcrumb">
            @foreach ($breadcrumb as $bc_entry)
              @if (count($bc_entry) > 1)
                <li><a href="{{ $bc_entry[1] }}">{{ $bc_entry[0] }}</a></li>
              @else
                <li>{{ $bc_entry[0] }}</li>
              @endif
            @endforeach
          </ol>
          @endif
          @if (!empty($content_header))
          <h2 class="page-header"> {{ $content_header }}</h2>
          @endif

          <!-- CONTENT-BEGIN -->
          @yield('content')
          <!-- CONTENT-END -->
          
        </div>
        <!-- } MAIN CONTENT -->
      </div>

      <footer>
        <p></p>
      </footer>

    </div> <!-- /container -->

  

  </body>
</html>
