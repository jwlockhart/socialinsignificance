/**
 * math functions used by the site. Almost all borrowed and slightly modified from other sources.
 */

function get_gaus_data(mean, stddiv, x_vals){
  //number of points on our line
  var data = [];
  var y = 0;
  var variance = stddiv * stddiv;
  
  for (var i = 0; i < x_vals.length; i++){
    y = pdf(i, mean, stddiv);
    point = {
      "x": i,
      "y": y
    };
    data.push(point);
  } 
  return data;
}

//returns asample of interesting x values given two gaussian distributions
function get_x_vals(m1, sd1, m2, sd2){
  var cutoff_deviations = 5;
  var points = 10000;
  var x = [];
  
  var first = m1 - (sd1 * cutoff_deviations);
  var tmp = m2 - (sd2 * cutoff_deviations);
  if (tmp < first){
    first = tmp;
  }

  var last = m1 + (sd1 * cutoff_deviations);
  tmp = m2 + (sd2 * cutoff_deviations);
  if (tmp > last){
    last = tmp;
  }
  
  var step = ( last - first ) / points;
  
  for (var i = first; i < last; i += step){
    x.push(i);
  }
  
  return x;
}

// from https://github.com/errcw/gaussian/blob/master/lib/gaussian.js
// probability density function
function pdf(x, mean, stddiv) {
    var m = stddiv * Math.sqrt(2 * Math.PI);
    var e = Math.exp(-Math.pow(x - mean, 2) / (2 * (stddiv * stddiv)));
    return e / m;
}
