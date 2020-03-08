function fetchData() {
  $.ajax({
    url: base_url + "/Admin/everyDayPosts/",
    type: "POST",
    dataType: "json",
    async: true,
    beforeSend: function(xhr) {
      xhr.setRequestHeader("X-CSRF-Token", $('[name="_csrfToken"]').val());
      // setting a timeout
      $(".page-loader").show();
    },
    success: function(resp) {
      // return

      var data = [];
      for (key in resp.data) {
        let date = resp.data[key]["created_at"];
        let counter = resp.data[key]["count"];
        date = moment(date, "YYYY-MM-DD");
        data.push({
          t: date.valueOf(),
          y: counter
        });
      }

      var color = Chart.helpers.color;
      var cfg = {
        data: {
          datasets: [
            {
              label: "no of post per day",
              backgroundColor: color(window.chartColors.red)
                .alpha(0.5)
                .rgbString(),
              borderColor: window.chartColors.red,
              data: data,
              type: "line",
              pointRadius: 0,
              fill: false,
              lineTension: 0,
              borderWidth: 2
            }
          ]
        },
        options: {
          animation: {
            duration: 0
          },
          scales: {
            xAxes: [
              {
                type: "time",
                distribution: "series",
                offset: true,
                ticks: {
                  major: {
                    enabled: true,
                    fontStyle: "bold"
                  },
                  source: "data",
                  autoSkip: true,
                  autoSkipPadding: 75,
                  maxRotation: 0,
                  sampleSize: 100
                },
                afterBuildTicks: function(scale, ticks) {
                  var majorUnit = scale._majorUnit;
                  var firstTick = ticks[0];
                  var i, ilen, val, tick, currMajor, lastMajor;

                  val = moment(ticks[0].value);
                  if (
                    (majorUnit === "minute" && val.second() === 0) ||
                    (majorUnit === "hour" && val.minute() === 0) ||
                    (majorUnit === "day" && val.hour() === 9) ||
                    (majorUnit === "month" &&
                      val.date() <= 3 &&
                      val.isoWeekday() === 1) ||
                    (majorUnit === "year" && val.month() === 0)
                  ) {
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
              }
            ],
            yAxes: [
              {
                gridLines: {
                  drawBorder: false
                },
                scaleLabel: {
                  display: true,
                  labelString: "Post per day"
                }
              }
            ]
          },
          tooltips: {
            intersect: false,
            mode: "index",
            callbacks: {
              label: function(tooltipItem, myData) {
                var label =
                  myData.datasets[tooltipItem.datasetIndex].label || "";
                if (label) {
                  label += ": ";
                }
                label += parseFloat(tooltipItem.value).toFixed(2);
                return label;
              }
            }
          }
        }
      };

      var chart1 = new Chart(ctx1, cfg);

      //var chart = new Chart(ctx, cfg);
    }
  });
}
var ctx1 = document.getElementById("chart1").getContext("2d");
ctx1.canvas.width = 1000;
ctx1.canvas.height = 300;
//var ctx = document.getElementById("chart2").getContext("2d");
//ctx.canvas.width = 1000;
//ctx.canvas.height = 300;
fetchData();
