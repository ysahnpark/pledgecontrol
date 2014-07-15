
@section('content')

<h2  style="color: green">Pledge</h2>
<h4>Participation</h4>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Participation</th><th>Goal</th><th>Actual</th><th>Diff</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Registered Family</td>
        <td>{{ $report_data['demographics']['registered'] }}</td>
        <td>{{ $report_data['demographics']['registered'] }}</td>
        <td></td>
      </tr>
      <tr>
        <td>Pledge Participating Family</td>
        <td>{{ $report_data['demographics']['goal'] }}</td>
        <td>{{ $report_data['demographics']['participating'] }}</td>
        <td>{{ $report_data['demographics']['goal'] - $report_data['demographics']['participating'] }}</td>
      </tr>
      <tr>
        <td>Percentage</td>
        <td>{{ $report_data['demographics']['goal'] / $report_data['demographics']['registered'] * 100 }}%</td>
        <td>{{ $report_data['demographics']['participating']  / $report_data['demographics']['registered'] * 100 }}%</td>
        <td>{{ $report_data['demographics']['goal'] - $report_data['demographics']['participating'] }}</td>
      </tr>    </tbody>
  </table>

<!-- -->
<h4>Collection Status</h4>
  <table class="table table-striped">
    <thead>
      <tr>
        <th></th><th>Amount</th><th>Goal</th><th>Diff</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Total Pledge</td>
        <td>{{ \DocuFlow\Helper\DfFormat::currency($report_data['totals']['TotalPledgeAmount']) }}</td>
        <td>xx</td>
        <td>xx</td>
      </tr>
      <tr>
        <td>Accumulated</td>
        <td>{{ \DocuFlow\Helper\DfFormat::currency($report_data['totals']['TotalPaidAmount']) }}</td>
        <td>xx</td>
        <td>xx</td>
      </tr>
      <tr>
        <td>Expected</td>
        <td>{{ \DocuFlow\Helper\DfFormat::currency($report_data['totals']['TotalAmountExpectedNow']) }}</td>
        <td>xx</td>
        <td>xx</td>
      </tr>
    </tbody>
  </table>

<!-- -->
<h4>Pledge Trend</h4>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Date</th><th>Signup count</th>
      </tr>
    </thead>
    <tbody>
@foreach ($report_data['signup_trend'] as $signup_date)
      <tr>
        <td>{{ $signup_date->PledgeStartDateYear }} / {{ $signup_date->PledgeStartDateMonth }}</td>
        <td>{{ $signup_date->SignupCount }}</td>
      </tr>
@endforeach
    </tbody>
  </table>


<h2>Delinquents</h2>
<!-- -->
<h4>Distribution of Delinquent Donors</h4>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Category</th><th>Frequency</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Category</td>
        <td>num</td>
      </tr>
      <tr>
        <td>Category</td>
        <td>num</td>
      </tr>
    </tbody>
  </table>

<!-- -->
<h4>Reminder Letter Delivery</h4>
  <table class="table table-striped">
    <thead>
      <tr>
        <th></th><th></th><th>Letter sent</th><th>No letter</th><th>Response</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>No Date set</td>
        <td>10</td>
        <td>9</td>
        <td>3</td>
        <td></td>
      </tr>
      <tr>
        <td>Missed first payment</td>
        <td>10</td>
        <td>9</td>
        <td>3</td>
        <td></td>
      </tr>
    </tbody>
  </table>

<!-- -->
<h4>Delinquent</h4>

<!-- -->
<h4>Thank You Letter</h4>

<h2>Monthly Graph</h2>

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
      values: {{ json_encode($report_data['transactions_monthly']) }}
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


});
</script>

@show