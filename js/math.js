// code borrowed and slightly adapted from: 
// http://bl.ocks.org/phil-pedruco/88cb8a51cdce45f13c7e

function getGausData(mean, sigma) {
var data = [];

// loop to populate data array with 
// probabily - quantile pairs
for (var i = 0; i < 100000; i++) {
    q = normal() // calc random draw from normal dist
    p = gaussian(q, mean, sigma) // calc prob of rand draw
    el = {
        "q": q,
        "p": p
    }
    data.push(el)
};

// need to sort for plotting
//https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/sort
data.sort(function(x, y) {
    return x.q - y.q;
});	

return data;
}

// from http://bl.ocks.org/mbostock/4349187
// Sample from a normal distribution with mean 0, stddev 1.
function normal() {
    var x = 0,
        y = 0,
        rds, c;
    do {
        x = Math.random() * 2 - 1;
        y = Math.random() * 2 - 1;
        rds = x * x + y * y;
    } while (rds == 0 || rds > 1);
    c = Math.sqrt(-2 * Math.log(rds) / rds); // Box-Muller transform
    return x * c; // throw away extra sample y * c
}

//taken from Jason Davies science library
// https://github.com/jasondavies/science.js/
function gaussian(x, mean, sigma) {
    var gaussianConstant = 1 / Math.sqrt(2 * Math.PI)

    x = (x - mean) / sigma;
    return gaussianConstant * Math.exp(-.5 * x * x) / sigma;
};