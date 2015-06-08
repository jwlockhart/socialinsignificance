<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Normal Plot</title>
    <meta name="description" content="">
    <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <script src="./js/math.js" charset="utf-8"></script>
    <style type="text/css">
    body {
        font: 10px sans-serif;
    }
    .axis path,
    .axis line {
        fill: none;
        stroke: #000;
        shape-rendering: crispEdges;
    }
    /*.x.axis path {
        display: none;
    }*/
    .line {
        fill: none;
        stroke: steelblue;
        stroke-width: 1.5px;
    }
    </style>
</head>

<body>


<?php
$slug = htmlspecialchars($_GET["id"]);
$data_file = "./demo_data/" . $slug . ".json";
$tmp = file_get_contents($data_file);
$data = json_decode($tmp, true);

echo "The data on this page is from the following study:<br/><a href=\"" . $data['url'] . "\" target=\"_blank\">" . $data['citation'] . "</a> doi: " . $data['doi'] . '.<br/>';
echo "<b>Abstract:</b><br/>" . $data['abstract'];

echo "<br/><br/>";

?>


</body>

<script type="text/javascript">



var data1 = getGausData(mean = -1, sigma = 1); // popuate data 
var data2 = getGausData(mean = 0, sigma = 2); // popuate data 

// line chart based on http://bl.ocks.org/mbostock/3883245
var margin = {
        top: 20,
        right: 20,
        bottom: 30,
        left: 50
    },
    width = 600 - margin.left - margin.right,
    height = 300 - margin.top - margin.bottom;

var x = d3.scale.linear()
    .range([0, width]);

var y = d3.scale.linear()
    .range([height, 0]);

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left");

var line = d3.svg.line()
    .x(function(d) {
        return x(d.q);
    })
    .y(function(d) {
        return y(d.p);
    });

var svg = d3.select("body").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
    .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

x.domain(d3.extent(data1, function(d) {
    return d.q;
}));
y.domain(d3.extent(data1, function(d) {
    return d.p;
}));

svg.append("g")
    .attr("class", "x axis")
    .attr("transform", "translate(0," + height + ")")
    .call(xAxis);

svg.append("g")
    .attr("class", "y axis")
    .call(yAxis);

svg.append("path")
    .datum(data1)
    .attr("class", "line")
    .attr("d", line);
    
svg.append("path")
    .datum(data2)
    .attr("class", "line")
    .attr("d", line);

</script>

</html>
