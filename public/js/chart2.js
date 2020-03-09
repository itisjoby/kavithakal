var DATA_COUNT = 7;

var utils = Samples.utils;

utils.srand(110);

function getLineColor(ctx) {
  return utils.color(ctx.datasetIndex);
}

function alternatePointStyles(ctx) {
  var index = ctx.dataIndex;
  return index % 2 === 0 ? "circle" : "rect";
}

function makeHalfAsOpaque(ctx) {
  return utils.transparentize(getLineColor(ctx));
}

function make20PercentOpaque(ctx) {
  return utils.transparentize(getLineColor(ctx), 0.8);
}

function adjustRadiusBasedOnData(ctx) {
  var v = ctx.dataset.data[ctx.dataIndex];
  return v < 10 ? 5 : v < 25 ? 7 : v < 50 ? 9 : v < 75 ? 11 : 15;
}

function generateData() {
  return utils.numbers({
    count: DATA_COUNT,
    min: 0,
    max: 100
  });
}

var data = {
  labels: [
    ["Eating", "Dinner"],
    ["Drinking", "Water"],
    "Sleeping",
    ["Designing", "Graphics"],
    "Coding",
    "Cycling",
    "Running"
  ],
  datasets: [
    {
      data: generateData()
    }
  ]
};

var options = {
  legend: false,
  tooltips: true,
  elements: {
    line: {
      backgroundColor: make20PercentOpaque,
      borderColor: getLineColor
    },
    point: {
      backgroundColor: getLineColor,
      hoverBackgroundColor: makeHalfAsOpaque,
      radius: adjustRadiusBasedOnData,
      pointStyle: alternatePointStyles,
      hoverRadius: 15
    }
  }
};
//https://www.chartjs.org/samples/latest/scriptable/radar.html
var chart = new Chart("chart3", {
  type: "radar",
  data: data,
  options: options
});

// eslint-disable-next-line no-unused-vars
function addDataset() {
  chart.data.datasets.push({
    data: generateData()
  });
  chart.update();
}

// eslint-disable-next-line no-unused-vars
function randomize() {
  chart.data.datasets.forEach(function(dataset) {
    dataset.data = generateData();
  });
  chart.update();
}

// eslint-disable-next-line no-unused-vars
function removeDataset() {
  chart.data.datasets.shift();
  chart.update();
}