<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Normal Plot</title>
    <meta name="description" content="">
    <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <script src="./js/math.js" charset="utf-8"></script>
    <script src="./js/helpers.js" charset="utf-8"></script>
    <script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    
    <style type="text/css">
        .axis path {
            fill: none;
            stroke: #777;
            shape-rendering: crispEdges;
        }
        .axis text {
            font-family: Lato;
            font-size: 13px;
        }
    </style>
</head>

<body>


<!--php
$slug = htmlspecialchars($_GET["id"]);
$data_file = "./demo_data/" . $slug . ".json";
$tmp = file_get_contents($data_file);
$data = json_decode($tmp, true);

echo "The data on this page is from the following study:<br/><a href=\"" . $data['url'] . "\" target=\"_blank\">" . $data['citation'] . "</a> doi: " . $data['doi'] . '.<br/>';
echo "<b>Abstract:</b><br/>" . $data['abstract'] . "<br/>";

echo "<br/><br/>";

?> -->

<div id="study_info">Loading study meta data...</br></div>

<br/><b>Debug Data:</b><br>
<div id="debug"></br></div>

<svg id="visualisation" width="1000" height="500"></svg>

</body>

<script type="text/javascript">

var slug = getParameterByName('id');
var file_path = "./demo_data/"
file_path += slug;
file_path += ".json";


//load the json data
$.getJSON(file_path, gen_page);

//generate the page content based on the json data
function gen_page(data){
  pop_meta_data(data);
  make_two_gaussians(data);
};

//function for making basic chart of two gaussians
function make_two_gaussians(data){

  //populate data
  
  var x_vals = get_x_vals(data.group[0].mean, data.group[0].stddiv, data.group[1].mean, data.group[1].stddiv);
  
  
  //var data0 = get_gaus_data(mean = data.group[0].mean, stddiv = data.group[0].stddiv, x_vals);
  //var data1 = get_gaus_data(mean = data.group[1].mean, stddiv = data.group[1].stddiv, x_vals);
      
  //for (var i in data.group) { data.group[i].firstName; }
  
  var d = gen_data(data);
  
  dbg = 'data g name 0 is ' + d.length; //d[0][data.group[0].name].x;
  document.getElementById("debug").innerHTML=dbg;
  
  
  var vis = d3.select("#visualisation"),
      WIDTH = 600,
      HEIGHT = 400,
      MARGINS = {
	  top: 20,
	  right: 20,
	  bottom: 20,
	  left: 50
      },
      xScale = d3.scale.linear().range([MARGINS.left, WIDTH - MARGINS.right]).domain([x_vals[0], x_vals[x_vals.length-1]]),
      yScale = d3.scale.linear().range([HEIGHT - MARGINS.top, MARGINS.bottom]).domain([0,0.3]),
      xAxis = d3.svg.axis()
      .scale(xScale),
      yAxis = d3.svg.axis()
      .scale(yScale)
      .orient("left");
  
  vis.append("svg:g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + (HEIGHT - MARGINS.bottom) + ")")
      .call(xAxis);
  vis.append("svg:g")
      .attr("class", "y axis")
      .attr("transform", "translate(" + (MARGINS.left) + ",0)")
      .call(yAxis);
  var lineGen = d3.svg.line()
      .x(function(d) {
	  return xScale(d.x);
      })
      .y(function(d) {
	  return yScale(d.y);
      })
      .interpolate("basis");
      
  var line_gen = d3.svg.line()
      .x(function(d, name) {
	  return xScale(d['x']);
      })
      .y(function(d, name) {
	  return yScale(d[name]);
      })
      .interpolate("basis");

  for (var i = 0; i < data.group.length; i++){
    vis.append('svg:path')
      .attr('d', line_gen(d, data.group[i]))
      .attr('stroke', 'green')
      .attr('stroke-width', 2)
      .attr('fill', 'none');
  
  }
      
  /**    
  vis.append('svg:path')
      .attr('d', lineGen(data0))
      .attr('stroke', 'green')
      .attr('stroke-width', 2)
      .attr('fill', 'none');
  vis.append('svg:path')
      .attr('d', lineGen(data1))
      .attr('stroke', 'blue')
      .attr('stroke-width', 2)
      .attr('fill', 'none');
    */

};

function pop_meta_data(data){
        var output="";
        output = "<b>The data on this page is from the following study:</b><br/><a href=\"";
        output += data.url;
        output += "\" target=\"_blank\">";
        output += data.citation;
        output += "</a> doi: ";
        output += data.doi;
        output += ".<br/>";
        output += "<b>Abstract:</b><br/>";
        output += data.abstract;
        output += "<br/>";
        document.getElementById("study_info").innerHTML=output;
};

</script>

</html>
