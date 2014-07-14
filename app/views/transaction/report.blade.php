
@section('content')

<h4>Amount per month</h4>
<div id="chart_amount">
	<svg></svg>
</div>

<h4>Transactions per month</h4>
<div id="chart_count">
	<svg></svg>
</div>

{{ HTML::script('js/d3.min.js') }}
{{ HTML::style('packages/nvd3/nv.d3.min.css') }}
{{ HTML::script('packages/nvd3/nv.d3.min.js') }}
<script>
$(document).ready(function() {
	
nv.addGraph(function() {
  var chart = nv.models.discreteBarChart()
      .x(function(d) { return d.Year + "/" + d.Month  })    //Specify the data accessors.
      .y(function(d) { return parseFloat(d.MonthTotal) })
      .staggerLabels(true)    //Too many bars and not enough room? Try staggering labels.
      .tooltips(false)        //Don't show tooltips
      .showValues(true)       //...instead, show the bar value right on top of each bar.
      .transitionDuration(350)
      ;

  d3.select('#chart_amount svg')
      .datum(exampleData())
      .call(chart);

  nv.utils.windowResize(chart.update);

  return chart;
});

//Each bar represents a single discrete quantity.
function exampleData() {
 return  [ 
    {
      key: "Cumulative Return",
      values: {{ json_encode($records) }}
    }
  ]
}
//////////////

nv.addGraph(function() {
  var chart = nv.models.discreteBarChart()
      .x(function(d) { return d.Year + "/" + d.Month  })    //Specify the data accessors.
      .y(function(d) { return parseFloat(d.TransCount) })
      .staggerLabels(true)    //Too many bars and not enough room? Try staggering labels.
      .tooltips(false)        //Don't show tooltips
      .showValues(true)       //...instead, show the bar value right on top of each bar.
      .transitionDuration(350)
      ;

  d3.select('#chart_count svg')
      .datum(exampleData())
      .call(chart);

  nv.utils.windowResize(chart.update);

  return chart;
});

//Each bar represents a single discrete quantity.
function exampleData() {
 return  [ 
    {
      key: "Cumulative Return",
      values: {{ json_encode($records) }}
    }
  ]
}

});
</script>

@show