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
        <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
        <script>
let base_url = "<?php echo url('/'); ?>";
        </script>
        <link href="{{asset('assets/main.css')}}" rel="stylesheet">
        <link href="{{asset('assets/blog.css')}}" rel="stylesheet">
    </head>
    <body>
        <header>
            <!-- Fixed navbar -->
            <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                <a class="navbar-brand" href="/"><img src="{{URL('/assets/logo.jpg')}}" class="img-fluid img-rounded" alt="Responsive image" style="max-height: 70px;"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                        </li>

                    </ul>
                    <form class="form-inline mt-2 mt-md-0" action="/search" method="get">
                        <input class="form-control mr-sm-2" type="text" name="query" placeholder="Search" aria-label="Search" value="{{ session()->get('search') }}">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </nav>
        </header>
        <!-- Begin page content -->
        <main role="main" class="container mt-5">


            <main role="main" class="container">
                <div class="row">
                    <div class="col-md-8 blog-main">
                        <div class="p-3 mb-3 bg-light rounded">
                            <?php
                            if (!empty($article)) {
                                ?>

                                <h1 class="blog-post-title"><?php echo $article[0]->title; ?></h1>
                                <p class="blog-post-meta"><?php echo date('F D, Y', strtotime($article[0]->created_at)); ?> by <a href="#"><?php echo $article[0]->author; ?></a></p>
                                <p><?php echo $article[0]->content; ?></p>
                                <?php
                            } else {
                                echo '<div class="text-center">sorry article not found</div>';
                            }
                            ?>
                        </div>
                    </div><!-- /.blog-main -->

                    <aside class="col-md-4 blog-sidebar">
                        <div class="p-3 mb-3 bg-light rounded">
                            <h4 class="font-italic">About</h4>
                            <p class="mb-0">This page mainly focus on individuals who have a taste in poems and literature.We update new contents on a daily basis and keep trying to improve the world around us.If you are good at writing you can contribute your content too, which we will publish if it is well made.</p>
                        </div>

                        <div class="p-3">
                            <h4 class="font-italic">Archives</h4>
                            <ol class="list-unstyled mb-0">
                                <li><a href="#">March 2014</a></li>
                                <li><a href="#">February 2014</a></li>
                                <li><a href="#">January 2014</a></li>
                                <li><a href="#">December 2013</a></li>
                                <li><a href="#">November 2013</a></li>
                                <li><a href="#">October 2013</a></li>
                                <li><a href="#">September 2013</a></li>
                                <li><a href="#">August 2013</a></li>
                                <li><a href="#">July 2013</a></li>
                                <li><a href="#">June 2013</a></li>
                                <li><a href="#">May 2013</a></li>
                                <li><a href="#">April 2013</a></li>
                            </ol>
                        </div>

                        <div class="p-3">
                            <h4 class="font-italic">Elsewhere</h4>
                            <ol class="list-unstyled">
                                <li><a href="#">Instagram</a></li>
                                <li><a href="#">Twitter</a></li>
                                <li><a href="#">Facebook</a></li>
                            </ol>
                        </div>
                    </aside><!-- /.blog-sidebar -->
                </div><!-- /.row -->
            </main>
            <script src="{{asset('/js/public_dashboard.js')}}"></script>
            <script src="{{asset('/assets/holder.min.js')}}"></script>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <span class="text-muted text-center">Copyright ©   <?php echo date('Y'); ?></span>
        </div>
    </footer>



</body>
</html>

