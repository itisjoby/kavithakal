<!DOCTYPE html>
<html lang="en">

<head>
    <title>malayalam സാഹിത്യം</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{URL('/assets/logo.jpg')}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
        let base_url = "<?php echo url('/'); ?>";
    </script>
    <link href="{{asset('assets/main.css')}}" rel="stylesheet">
    <link href="{{asset('assets/blog.css')}}" rel="stylesheet">
</head>

<body>
    <header>
        @include('header')
    </header>
    <!-- end head -->
    <!-- wrapper -->
    <div id="wrapper">
        @yield('content')
    </div>
    <!-- end wrapper -->
    <footer class="footer">
        <!-- footer -->
        @include('footer')
        <!-- end footer -->
    </footer>
</body>

</html>