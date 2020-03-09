@extends('layout.main')

@section('content')
<script src="{{asset('third_party/ckeditor/ckeditor.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('third_party/tag-input/src/jquery.tagsinput.css')}}">
<script src="{{asset('third_party/tag-input/src/jquery.tagsinput.js')}}"></script>
<!-- <script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/mapdata/custom/world.js"></script> -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="{{asset('third_party/chartjs/moment.min.js')}}"></script>
<script src="{{asset('third_party/chartjs/Chart.min.js')}}"></script>
<script src="{{asset('third_party/chartjs/utils.js')}}"></script>
<link href="{{asset('assets/admin.css')}}" rel="stylesheet">
<link href="{{asset('assets/menu2.css')}}" rel="stylesheet">
<input type="hidden" name="_csrfToken" value="{{ csrf_token() }}" />

<main role="main" class="container mt-10">
    <div class="jumbotron text-center bg-dark">
        <h1 style='color:white'>Welcome admin...</h1>
        <div class="row">
            <div class="col-sm-12"><canvas id="chart1"></canvas></div>

        </div>
    </div>

    <div class="container">
        <div class="row">
            <?php
            if (!empty($posts)) {
                foreach ($posts as $key => $post) {
                    $post = (array) $post;
            ?>
                    <div class="col-sm-12">
                        <div class="card cards_wraper">
                            <button class="btn btn-sm btn-danger delete_btn" postid=" <?php echo $post['id']; ?>">delete</button>
                            <div class="card-body" data-toggle="collapse" data-target="#collapse<?php echo $key; ?>" aria-expanded="false" aria-controls="collapse<?php echo $key; ?>">
                                <div class="card-title font-weight-bolder text-monospace">
                                    <?php
                                    echo htmlentities($post['title']);
                                    ?>

                                </div>
                            </div>
                            <div class="collapse" id="collapse<?php echo $key; ?>">
                                <div class="card">
                                    <div class="card-body">
                                        <p class="text-justify text-muted">
                                            <?php
                                            echo ($post['content']);
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
            <?php
                }
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
        </div>

        <!-- visitor widgets -->
        <div class="card cards_wraper">
            <div class="card-body" data-toggle="collapse" data-target="#visitor_map_div" aria-expanded="false" aria-controls="visitor_map_div">
                <div class="card-title font-weight-bolder text-monospace">Visitor info</div>
            </div>
            <div class="collapse" id="visitor_map_div">
                <div class="row">
                    <div class="col-sm-6">
                        <div id="container_map" style="min-width: 250px; height: 300px;margin:0px;padding:0px; "></div>

                    </div>
                    <div class="col-sm-6">
                        <div id="container" style="min-width: 250px; height: 300px;margin:0px;padding:0px; "></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- floating menu -->
        <div class="col-sm-12">
            <div id="mainMenu" class="mainMenuOverlay floating2">
                <div class="navire floating3"></div>
                <div class="itemMenuBox bills"><a href="javascript:void(0)" class="itemMenu add_new_story"><i class="fa fa-file-text-o" aria-hidden="true"></i></a></div>
                <div class="itemMenuBox tarsheed"><a href="javascript:void(0)" class="itemMenu "><i class="fa fa-diamond" aria-hidden="true"></i></a></div>
                <div class="itemMenuBox employees"><a href="javascript:void(0)" class="itemMenu "><i class="fa fa-users" aria-hidden="true"></i></a></div>
                <div class="itemMenuBox location"><a href="javascript:void(0)" class="itemMenu "><i class="fa fa-location-arrow" aria-hidden="true"></i></a></div>
                <div class="itemMenuBox eservices"><a href="javascript:void(0)" class="itemMenu "><i class="fa fa-key" aria-hidden="true"></i></a></div>
                <div class="itemMenuBox contact"><a href="/signout" class="itemMenu "><i class="fa fa-sign-out" aria-hidden="true"></i></a></div>
                <a href="javascript:void(0)" class="toggleMenu floating"><i class="fa fa-bars" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
    <script src="{{asset('js/joby_validations.js')}}"></script>
    <script src="{{asset('js/dashboard.js')}}"></script>
    <script src="{{asset('js/chart1.js')}}"></script>
    <!-- <script src="{{asset('js/chart2.js')}}"></script> -->

    <script>
        $(".toggleMenu").on('click', function() {
            $("#mainMenu").toggleClass('open');
        });
    </script>
    <script>
        let today_visitors = 98;
    </script>
    <script src="{{asset('js/speedometer.js')}}"></script>
    <!-- <script src="{{asset('js/worldmap.js')}}"></script> -->
    <!-- add content modal -->
    <div class="modal" id="addnewcontent">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add New Content</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form class="content_form">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="error_screen"></div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea class="form-control" cols="10" rows="3" maxlength="500000" name="title" id="title" placeholder="title of the content"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea class="form-control" cols="10" rows="5" maxlength="500000" name="mini_content" id="mini_content" placeholder="first paragraph of the content"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="hidden" name="_csrfToken" value="{{ csrf_token() }}" />
                                <textarea class="form-control" cols="10" rows="15" maxlength="500000" name="content" id="content" placeholder="actual content"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">

                                <input type="text" class="form-control tags" maxlength="500000" name="tags" id="tags" placeholder="tags">
                            </div>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</main>
@endsection