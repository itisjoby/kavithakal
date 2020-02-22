<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dashboard</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <!--        <link href="{{ asset('css/app.css') }}" rel="stylesheet">-->
        <script>

            let base_url = "<?php echo url('/'); ?>";
        </script>

        <script src="{{asset('third_party/ckeditor/ckeditor.js')}}"></script>
        <link rel="stylesheet" type="text/css"  href="{{asset('third_party/tag-input/src/jquery.tagsinput.css')}}">
        <script src="{{asset('third_party/tag-input/src/jquery.tagsinput.js')}}"></script>
        <style>
            body {
                background: url('assets/bg.jpg') no-repeat center center fixed;
                -moz-background-size: cover;
                -webkit-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }
        </style>
    </head>
    <body>

        <div class="jumbotron text-center bg-dark">
            <h1 style='color:white'>Admin Dashboard</h1>
            <div class="row">
                <div class="col-6"><canvas id="chart1"></canvas></div>
                <div class="col-6"><canvas id="chart2"></canvas></div>
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
                            <div class="card">
                                <div class="card-body" data-toggle="collapse" data-target="#collapse<?php echo $key; ?>" aria-expanded="false" aria-controls="collapse<?php echo $key; ?>">
                                    <div class="card-title font-weight-bolder text-monospace" >
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

            <script src="{{asset('js/joby_validations.js')}}"></script>
            <script src="{{asset('third_party/chartjs/moment.min.js')}}"></script>
            <script src="{{asset('third_party/chartjs/Chart.min.js')}}"></script>
            <script src="{{asset('third_party/chartjs/utils.js')}}"></script>
            <script src="{{asset('js/dashboard.js')}}"></script>
        </div>
    </div>

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
                            <textarea class="form-control" cols="10" rows="5" maxlength="500000" name="mini_content" id="mini_content"  placeholder="first paragraph of the content"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input type="hidden" name="_csrfToken" value="{{ csrf_token() }}"/>
                            <textarea class="form-control" cols="10" rows="15" maxlength="500000" name="content" id="content"  placeholder="actual content"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">

                            <input type="text" class="form-control tags" maxlength="500000" name="tags" id="tags"  placeholder="tags" >
                        </div>
                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" >Save</button>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
            function generateData() {
                var unit = 'second';

                function unitLessThanDay() {
                    return unit === 'second' || unit === 'minute' || unit === 'hour';
                }

                function beforeNineThirty(date) {
                    return date.hour() < 9 || (date.hour() === 9 && date.minute() < 30);
                }

                // Returns true if outside 9:30am-4pm on a weekday
                function outsideMarketHours(date) {
                    if (date.isoWeekday() > 5) {
                        return true;
                    }
                    if (unitLessThanDay() && (beforeNineThirty(date) || date.hour() > 16)) {
                        return true;
                    }
                    return false;
                }

                function randomNumber(min, max) {
                    return Math.random() * (max - min) + min;
                }

                function randomBar(date, lastClose) {
                    var open = randomNumber(lastClose * 0.95, lastClose * 1.05).toFixed(2);
                    var close = randomNumber(open * 0.95, open * 1.05).toFixed(2);
                    return {
                        t: date.valueOf(),
                        y: close
                    };
                }

                var date = moment('Jan 01 1990', 'MMM DD YYYY');
                var now = moment();
                var data = [];
                var lessThanDay = unitLessThanDay();
                for (; data.length < 600 && date.isBefore(now); date = date.clone().add(1, unit).startOf(unit)) {
                    if (outsideMarketHours(date)) {
                        if (!lessThanDay || !beforeNineThirty(date)) {
                            date = date.clone().add(date.isoWeekday() >= 5 ? 8 - date.isoWeekday() : 1, 'day');
                        }
                        if (lessThanDay) {
                            date = date.hour(9).minute(30).second(0);
                        }
                    }
                    data.push(randomBar(date, data.length > 0 ? data[data.length - 1].y : 30));
                }

                return data;
            }

            var ctx = document.getElementById('chart1').getContext('2d');
            ctx.canvas.width = 1000;
            ctx.canvas.height = 300;

            var color = Chart.helpers.color;
            var cfg = {
                data: {
                    datasets: [{
                            label: 'CHRT - Chart.js Corporation',
                            backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                            borderColor: window.chartColors.red,
                            data: generateData(),
                            type: 'line',
                            pointRadius: 0,
                            fill: false,
                            lineTension: 0,
                            borderWidth: 2
                        }]
                },
                options: {
                    animation: {
                        duration: 0
                    },
                    scales: {
                        xAxes: [{
                                type: 'time',
                                distribution: 'series',
                                offset: true,
                                ticks: {
                                    major: {
                                        enabled: true,
                                        fontStyle: 'bold'
                                    },
                                    source: 'data',
                                    autoSkip: true,
                                    autoSkipPadding: 75,
                                    maxRotation: 0,
                                    sampleSize: 100
                                },
                                afterBuildTicks: function (scale, ticks) {
                                    var majorUnit = scale._majorUnit;
                                    var firstTick = ticks[0];
                                    var i, ilen, val, tick, currMajor, lastMajor;

                                    val = moment(ticks[0].value);
                                    if ((majorUnit === 'minute' && val.second() === 0)
                                            || (majorUnit === 'hour' && val.minute() === 0)
                                            || (majorUnit === 'day' && val.hour() === 9)
                                            || (majorUnit === 'month' && val.date() <= 3 && val.isoWeekday() === 1)
                                            || (majorUnit === 'year' && val.month() === 0)) {
                                        firstTick.major = true;
                                    } else {
                                        firstTick.major = false;
                                    }
                                    lastMajor = val.get(majorUnit);

                                    for (i = 1, ilen = ticks.length; i < ilen; i++) {
                                        tick = ticks[i];
                                        val = moment(tick.value);
                                        currMajor = val.get(majorUnit);
                                        tick.major = currMajor !== lastMajor;
                                        lastMajor = currMajor;
                                    }
                                    return ticks;
                                }
                            }],
                        yAxes: [{
                                gridLines: {
                                    drawBorder: false
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Closing price ($)'
                                }
                            }]
                    },
                    tooltips: {
                        intersect: false,
                        mode: 'index',
                        callbacks: {
                            label: function (tooltipItem, myData) {
                                var label = myData.datasets[tooltipItem.datasetIndex].label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += parseFloat(tooltipItem.value).toFixed(2);
                                return label;
                            }
                        }
                    }
                }
            };

            var chart = new Chart(ctx, cfg);

            var ctx = document.getElementById('chart2').getContext('2d');
            ctx.canvas.width = 1000;
            ctx.canvas.height = 300;
            var chart = new Chart(ctx, cfg);



</script>
