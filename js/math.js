/**
 * math functions used by the site. Almost all borrowed and slightly modified from other sources.
 */

/**
 * given the json descriptions for each group's distribution
 * generates data for plotting the probability density functions (bell curves)
 */
function gen_data(json, x){
  var data = {};
  
  //create a variable for each group, generate and save it's data
  for (var i = 0; i < json.group.length; i++){
    data[json.group[i].name] = get_gaus_data(json.group[i].mean, json.group[i].stddiv, x);
  }
  
  return data;
}

/**
 * given all populations defined in the json file, returns the best xs to draw our curves
 */
function get_x(json){
  //settings
  var points = 1000;
  var cutoff_deviations = 5;
  //internal variables
  var x = [];
  var tmp_first = [];
  var tmp_last = [];
  var tmp = 0;
  var first = 0;
  var last = 0;
  var step = 1; // a 0 here would cause infinite loops
  
  //find the ideal start and end for each series
  for (var i = 0; i < json.group.length; i++){
    tmp = json.group[i].stddiv * cutoff_deviations;    
    tmp_first.push(json.group[i].mean - tmp);
    tmp_last.push(json.group[i].mean + tmp);
  }
  
  //find the earliest start and latest end for all series, and make them ints
  first = Math.floor( Math.min.apply(null, tmp_first) );
  last = Math.ceil( Math.max.apply(null, tmp_last) );
  
  //find the step size to uniformly distribute out points over the range
  step = ( last - first ) / points;
  
  //populate an array of x values at which we want to display points
  for (var i = first; i < last; i += step){
    x.push(i);
  }
  
  return x;
}

/**
 * produces data for a plotting the probability densitiy of a single gaussian distribution 
 */
function get_gaus_data(mean, stddiv, x_vals){
  var data = [];
  var y = 0;
  
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

/** returns asample of interesting x values given two gaussian distributions
 * @depricated
 */
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
