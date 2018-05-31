<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
 
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <link rel="stylesheet" href="/assets/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="/assets/dist/css/skins/_all-skins.min.css">
 
  <link rel="stylesheet" href="/assets/plugins/morris/morris.css">
 
  <link rel="stylesheet" href="/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">

  <link rel="stylesheet" href="/assets/plugins/datepicker/datepicker3.css">
  
  <link rel="stylesheet" href="/assets/plugins/daterangepicker/daterangepicker-bs3.css">
 
  <link rel="stylesheet" href="/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="/css/main.css?v={{ date('dmhms')}}">

  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
 
  <link  href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">


  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body class="hold-transition skin-blue-light sidebar-mini">
<div class="wrapper">

  <header class="main-header">
   
    <a href="/admin" class="logo">
      
      <span class="logo-mini">{{ config('app.name', 'Laravel') }}</span>
      
      <span class="logo-lg">{{ config('app.name', 'Laravel') }}</span>
    </a>
   
    <nav class="navbar navbar-static-top" role="navigation">
     
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="/assets/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">{{$usuario}}</span>
            </a>
           
          </li>
          
        </ul>
      </div>
    </nav>

  </header>
 @if($usuario=="asociado")
   @include('partial/menuasociado')
 @elseif($usuario=="cliente")
    @include('partial/menucliente')
 @else
    @include('partial/menuadmin')
@endif
  <div class="content-wrapper">
       
    @yield('content')
    
  </div>
  


  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    
  </footer>

 
  <div class="control-sidebar-bg"></div>
</div>



<script src="/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>

<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

<script src="/assets/bootstrap/js/bootstrap.min.js"></script>


<script src="/assets/bower_components/raphael/raphael.min.js"></script>
<script src="/assets/bower_components/morris.js/morris.min.js"></script>
<script>
        try{
          var area = new Morris.Area({
            element: 'revenue-chart',
            resize: true,
            data: [
              
              {y: '2018 Q3', item1: 5, item2: 10},
              {y: '2018 Q2', item1: 4, item2: 20},
              {y: '2018 Q1', item1: 2, item2: 13}
              
            ],
            xkey: 'y',
            ykeys: ['item1' ],
            labels: ['Solicitudes'],
            lineColors: ['#a0d0e0'],
            hideHover: 'auto'
          });
      
        }catch(err){
          console.log(err);
        }
      </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="/assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="/assets/dist/js/app.js"></script>
<script type="text/javascript" src="/bower_components/moment/min/moment.min.js"></script>
<script type="text/javascript" src="/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="/js/main.js?v={{ date('dmhms')}}"></script>

</body>
</html>
