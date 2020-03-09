<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <!--        <link href="{{ asset('css/app.css') }}" rel="stylesheet">-->

    <style>
        body {
            width: 100vw;
            height: 100vh;
            margin: 0;
            background: black;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        canvas {
            position: absolute;
            top: 0;
            left: 0;
            z-index: -99;
        }

        .box {
            padding: 20px;
            background-color: #fff;
            border: 5px solid gray;
            margin: 2px;
        }
    </style>

</head>

<body>

    <!--        <div class="jumbotron text-center">
                    <h1>Login Now</h1>
                    <p class="error_screen"></p>
                </div>-->

    <div class="container">
        <div id="fiddleHook"></div>
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <form action="/action_page.php" class="login_form">
                    <div class="box">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control email" id="email" placeholder="Enter email" name="email" maxlength="30" autocomplete="off" data-validation="required" data-validation-error-msg="Email cannot be empty">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Password:</label>
                            <input type="password" class="form-control password" id="pwd" placeholder="Enter password" name="pswd" autocomplete="off" data-validation="required" data-validation-error-msg="Password cannot be empty">
                        </div>
                        <input type="hidden" name="_csrfToken" value="{{ csrf_token() }}" />
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

            <div class="col-sm-4"></div>
        </div>
    </div>
    <script>
        let base_url = "<?php echo url('/'); ?>";
    </script>
    <script src="{{asset('js/joby_validations.js')}}"></script>
    <script src="{{asset('js/login.js')}}"></script>
    <script src="/third_party/threejs/three.min.js"></script>
    <script src="/third_party/threejs/postprocessing.min.js"></script>
    <!--        <script src="{{asset('js/nebula.js')}}"></script>-->
    <script src="{{asset('js/realistic_rain.js')}}"></script>
</body>

</html>