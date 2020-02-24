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
        <link href="<?php echo config('app.url') . 'public/assets/main.css'; ?>" rel="stylesheet">
        <link href="<?php echo config('app.url') . 'public/assets/blog.css'; ?>" rel="stylesheet">

    </head>
    <body>
        <header>
            <!-- Fixed navbar -->
            <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                <a class="navbar-brand" href="<?php echo config('app.url'); ?>"><img src="{{URL('/assets/logo.jpg')}}" class="img-fluid img-rounded" alt="Responsive image" style="max-height: 70px;"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo config('app.url'); ?>">Home <span class="sr-only">(current)</span></a>
                        </li>

                    </ul>
                    <form class="form-inline mt-2 mt-md-0" action="<?php echo config('app.url'); ?>search" method="get">
                        <input class="form-control mr-sm-2" type="text" name="query" placeholder="Search" aria-label="Search" value="{{ session()->get('search') }}">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </nav>
        </header>
        <!-- Begin page content -->
        <main role="main" class="container mt-5">
            <div class="container">


                <!--                <div class="nav-scroller py-1 mb-2">
                                    <nav class="nav d-flex justify-content-between">
                                        <a class="p-2 text-muted" href="#">World</a>
                                        <a class="p-2 text-muted" href="#">U.S.</a>
                                        <a class="p-2 text-muted" href="#">Technology</a>
                                        <a class="p-2 text-muted" href="#">Design</a>
                                        <a class="p-2 text-muted" href="#">Culture</a>
                                        <a class="p-2 text-muted" href="#">Business</a>
                                        <a class="p-2 text-muted" href="#">Politics</a>
                                        <a class="p-2 text-muted" href="#">Opinion</a>
                                        <a class="p-2 text-muted" href="#">Science</a>
                                        <a class="p-2 text-muted" href="#">Health</a>
                                        <a class="p-2 text-muted" href="#">Style</a>
                                        <a class="p-2 text-muted" href="#">Travel</a>
                                    </nav>
                                </div>-->
                <?php
                if (!empty($top_posts)) {
                    ?>
                    <div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
                        <div class="col-md-6 px-0">
                            <h1 class="display-4 font-italic"><?php echo $top_posts[0]->title; ?></h1>
                            <p class="lead my-3"><?php echo $top_posts[0]->mini_content; ?></p>
                            <p class="lead mb-0"><a href="<?php echo config('app.url'); ?>read/<?php echo $top_posts[0]->id; ?>" class="text-white font-weight-bold">Continue reading...</a></p>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <?php
                if (!empty($new_posts)) {
                    if (count($posts) > 5) {
                        ?>
                        <div class="row mb-2">
                            <?php
                            foreach ($new_posts as $new_post) {
                                ?>
                                <div class="col-md-6">
                                    <div class="card flex-md-row mb-4 box-shadow h-md-250">
                                        <div class="card-body d-flex flex-column align-items-start">
                                            <strong class="d-inline-block mb-2 text-primary">World</strong>
                                            <h3 class="mb-0">
                                                <a class="text-dark" href="<?php echo config('app.url'); ?>read/<?php echo $new_post->id; ?>"><?php echo $new_post->title; ?></a>
                                            </h3>
                                            <div class="mb-1 text-muted"><?php echo date('M d,', strtotime($new_post->created_at)); ?></div>
                                            <p class="card-text mb-auto"><?php echo $new_post->mini_content; ?></p>
                                            <a href="<?php echo config('app.url'); ?>read/<?php echo $new_post->id; ?>">Continue reading</a>
                                        </div>
                                        <img class="card-img-right flex-auto d-none d-md-block" data-src="holder.js/200x250?theme=thumb" alt="Card image cap">
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                        </div>
                        <?php
                    }
                }
                ?>
            </div>

            <main role="main" class="container">
                <div class="row">
                    <div class="col-md-8 blog-main">
                        <h3 class="pb-3 mb-4 font-italic border-bottom">
                            Trending Now
                        </h3>

                        <?php
                        if (!empty($posts)) {
                            foreach ($posts as $key => $post) {
                                $post = (array) $post;
                                ?>
                                <div class="blog-post">
                                    <h1 class="blog-post-title"> <?php echo $post['title']; ?> </h1>
                                    <p class="blog-post-meta"><?php echo date('F D, Y', strtotime($post['created_at'])); ?> by <a href="#"><?php echo $post['creator']; ?></a></p>
                                    <p>
                                        <?php echo $post['content']; ?>
                                    </p>
                                    <a href="<?php echo config('app.url'); ?>read/<?php echo $post['id']; ?>">Read ...</a>
                                </div><!-- /.blog-post -->
                                <?php
                            }
                        } else {
                            echo '<div class="alert alert-danger">No more posts available</div>';
                        }
                        ?>



                        <nav class="blog-pagination">
                            <?php
                            $prev_disabled = "disabled";
                            $next_disabled = "disabled";
                            if ($paginator->getCurrentPage() > 1) {
                                $prev_disabled = "";
                            }
                            if ($paginator->getCurrentPage() < $paginator->getNumPages()) {
                                $next_disabled = "";
                            }
                            ?>
                            <a class="btn btn-outline-primary <?php echo $prev_disabled; ?>" href="<?php echo @$paginator->getPrevUrl(); ?>">Older</a>
                            <a class="btn btn-outline-secondary <?php echo $next_disabled; ?>" href="<?php echo @$paginator->getNextUrl(); ?>">Newer</a>
                        </nav>

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



            <script src="<?php echo config('app.url') . '/js/public_dashboard.js'; ?>"></script>
            <script src="<?php echo config('app.url') . '/js/holder.min.js'; ?>"></script>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <span class="text-muted text-center">Copyright ©   <?php echo date('Y'); ?></span>
        </div>
    </footer>



</body>
</html>

