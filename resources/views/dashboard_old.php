<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <!--        <link href="{{ asset('css/app.css') }}" rel="stylesheet">-->
    <script>
        let base_url = "<?php echo url('/'); ?>";
    </script>

    <script src="{{asset('third_party/ckeditor/ckeditor.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('third_party/tag-input/src/jquery.tagsinput.css')}}">
    <script src="{{asset('third_party/tag-input/src/jquery.tagsinput.js')}}"></script>
    <style>
        body {
            background: url('assets/bg.jpg') no-repeat center center fixed;
            -moz-background-size: cover;
            -webkit-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        .cards_wraper {
            margin-bottom: 20px;
        }
    </style>
    <link href="{{asset('assets/admin_menu.css')}}" rel="stylesheet">
    <link href="{{asset('assets/menu2.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
    <!--        <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>-->
    <script src="https://cdn-webgl.eegeo.com/eegeojs/api/v0.1.780/eegeo.js"></script>
</head>

<body>

    <div class="jumbotron text-center bg-dark">
        <h1 style='color:white'>Admin Dashboard</h1>
        <div class="row">
            <div class="col-sm-6"><canvas id="chart1"></canvas></div>
            <div class="col-sm-6"><canvas id="chart2"></canvas></div>
            <div class="col-sm-6"><canvas id="chart3"></canvas></div>
            <div class="col-sm-6"><canvas id="chart4"></canvas></div>
        </div>
    </div>

    <div class="container">

        <div class="row">
            <div class="col-sm-8"></div>
            <div class="col-sm-4">
                <button type="button" id="addbutton" class="btn btn-primary float-right add_new_story">Add new</button>
            </div>
            <?php
            if (!empty($posts)) {
                foreach ($posts as $key => $post) {
                    $post = (array) $post;
            ?>
                    <div class="col-sm-12">
                        <div class="card cards_wraper">
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
        </div>

        <div class="col-sm-12">
            <div class="menu_list">
                <div class="all">
                    <div class="lefter">
                        <div class="text">Hosting</div>
                    </div>
                    <div class="left">
                        <div class="text">Web Design</div>
                    </div>
                    <div class="center">
                        <div class="explainer"><span>Hover me</span></div>
                        <div class="text">Frontend Development</div>
                    </div>
                    <div class="right">
                        <div class="text">Backend Development</div>
                    </div>
                    <div class="righter">
                        <div class="text">SEO</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div id="mainMenu" class="mainMenuOverlay floating2">
                <div class="navire floating3"></div>
                <div class="itemMenuBox bills"><a href="https://codepen.io/mahmoud-nb/pen/ZOYdKm" target="_blank" class="itemMenu "><i class="fa fa-file-text-o" aria-hidden="true"></i></a></div>
                <div class="itemMenuBox tarsheed"><a href="javascript:void(0)" class="itemMenu "><i class="fa fa-diamond" aria-hidden="true"></i></a>menu</div>
                <div class="itemMenuBox employees"><a href="javascript:void(0)" class="itemMenu "><i class="fa fa-users" aria-hidden="true"></i></a></div>
                <div class="itemMenuBox location"><a href="javascript:void(0)" class="itemMenu "><i class="fa fa-location-arrow" aria-hidden="true"></i></a></div>
                <div class="itemMenuBox eservices"><a href="javascript:void(0)" class="itemMenu "><i class="fa fa-key" aria-hidden="true"></i></a></div>
                <div class="itemMenuBox contact"><a href="javascript:void(0)" class="itemMenu "><i class="fa fa-phone" aria-hidden="true"></i></a></div>

                <a href="javascript:void(0)" class="toggleMenu floating"><i class="fa fa-bars" aria-hidden="true"></i></a>
            </div>



            <!-- Signature -->
            <div class="signatureBox fixed">Written and coded by <a href="https://codepen.io/mahmoud-nb/" target="_blank"><span class="signature"></span></a></div>
        </div>







    </div>

    <div class="jumbotron text-center bg-dark">
        <h1 style='color:white'>Admin Map</h1>
        <div class="row">
            <div id="map" style="width: 100%; height: 400px;"></div>
        </div>
    </div>

    <script src="{{asset('js/joby_validations.js')}}"></script>
    <script src="{{asset('third_party/chartjs/moment.min.js')}}"></script>
    <script src="{{asset('third_party/chartjs/Chart.min.js')}}"></script>
    <script src="{{asset('third_party/chartjs/utils.js')}}"></script>
    <script src="{{asset('js/dashboard.js')}}"></script>
    <script src="{{asset('js/chart1.js')}}"></script>
    <script src="{{asset('js/chart2.js')}}"></script>
    <script src="{{asset('js/chart3.js')}}"></script>
    <script src="{{asset('js/lmap.js')}}"></script>
    <script>
        $(".toggleMenu").on('click', function() {
            $("#mainMenu").toggleClass('open');
        });
    </script>
</body>

</html>

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