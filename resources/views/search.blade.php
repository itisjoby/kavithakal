@extends('layout.main')

@section('content')

<!-- Begin page content -->
<main role="main" class="container mt-10">
    <main role="main" class="container">
        <div class="row">
            <div class="col-md-8 blog-main">
                <h3 class="pb-3 mb-4 font-italic border-bottom">
                    <?php echo count($results) . " results found !..." ?>
                </h3>

                <?php
                if (!empty($results)) {
                    foreach ($results as $key => $post) {
                        $post = (array) $post;
                ?>
                        <div class="blog-post">
                            <h2 class="blog-post-title"> <?php echo $post['title']; ?> </h2>
                            <p class="blog-post-meta"><?php echo date('F D, Y', strtotime($post['created_at'])); ?> by <a href="#"><?php echo $post['author']; ?></a></p>
                            <p>
                                <?php echo $post['content']; ?>
                            </p>
                            <a href="/read/<?php echo $post['id']; ?>">Read ...</a>
                        </div><!-- /.blog-post -->
                <?php
                    }
                }
                ?>



                <nav class="blog-pagination">
                    <a class="btn btn-outline-primary" href="#">Older</a>
                    <a class="btn btn-outline-secondary disabled" href="#">Newer</a>
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
    <script src="{{asset('/js/public_dashboard.js')}}"></script>
    <script src="{{asset('/assets/holder.min.js')}}"></script>
    </div>
</main>

@endsection