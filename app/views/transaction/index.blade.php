
@section('content')

{{ HTML::script('packages/validator/bootstrapValidator.min.js') }}
{{ HTML::style('packages/validator/bootstrapValidator.min.css') }}

<div class="panel panel-info">
  <div class="panel-heading">
    <h4 class="panel-title">Add New Transaction</h4>
  </div>
  <div class="panel-body">

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

  	<!-- PANE CONTENT { -->
    <form id="TransactionForm" class="form-inline" role="form" method="POST" action="{{ URL::to(route('transactions.store')) }}">
   	  <input type="hidden" name="_return_url" value="{{ URL::to(route('transactions.index')) }}" />
   	  <input type="hidden" name="AccountID" id="AccountID" value="" />
	  <div class="form-group" id="remote">
	    <label class="sr-only" for="name">Name</label>
	    <input required type="text" class="form-control typeahead"  name="Name" id="Name" placeholder="Enter name">
	  </div>
	  <div class="form-group">
	    <label class="sr-only" for="name">Amount</label>
	    <input required type="number" step="any" min="1" class="form-control" name="Amount" id="Amount" placeholder="Enter amount">
	  </div>
	  <div class="form-group">
	  	<label class="sr-only" for="name">Lang::get('transaction.Method')</label>
		<div class="col-sm-10">
		    {{ Form::select('Method', $auxdata['opt_Method'], null, array('class' => 'form-control')) }}
		</div>
	  </div>
	  <div class="form-group">
	    <label class="sr-only" for="name">Note</label>
	    <input type="text" class="form-control" name="Note" id="Note" placeholder="Note">
	  </div>
	  <button type="submit" class="btn btn-default">Add Trans</button>
	</form>
	<!-- } PANE CONTENT -->
  </div>
</div>

<div class="pull-right"><a href=""><span class="glyphicon glyphicon-download-alt"></span> CSV</a></div>
<table class="table table-striped">
	<thead> 
		<tr>
			<td class="col-date">Date</td>
			<td>{{Lang::get('transaction.Name')}}</td>
			<td>{{Lang::get('transaction.Amount')}}</td>
			<td>{{Lang::get('transaction.Method')}}</td>
			<td>{{Lang::get('transaction.Note')}}</td>
		</tr>
	</thead>
	<tbody> 
@foreach ($records as $transaction)
		<tr>
			<td>{{ $transaction->PaymentDate }}</td>
			<td title="{{ $transaction->AccountID }}"><a href="{{ URL::to(route('accounts.show', array($transaction->AccountID))) }}">{{ $transaction->Name }}</a></td>
			<td class="col-amount">{{ \DocuFlow\Helper\DfFormat::currency($transaction->Amount) }}</td>
			<td >{{ $transaction->Method }}</td>
			<td>{{ $transaction->Note }}</td>
		</tr>
@endforeach
	</tbody>
  <tfoot>
    <tr>
      <td colspan="5"><?php echo $records->links(); ?></td>
    </tr>
  </tfoot>
</table>

{{ HTML::script('js/typeahead.bundle.js') }}
<script>
$(document).ready(function() {
	
	//$('#TransactionForm').parsley();
	//$('#TransactionForm').bootstrapValidator({

	var accountName = new Bloodhound({
	  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
	  queryTokenizer: Bloodhound.tokenizers.whitespace,
	  remote: 'api/accounts?Name-like=%QUERY%'
	});
	 
	accountName.initialize();
	 
	$('#remote .typeahead').typeahead(null, {
	  name: 'name',
	  displayKey: 'Name',
	  source: accountName.ttAdapter()
	});

	$('#remote .typeahead').bind('typeahead:selected', function(obj, datum, name) {      
        $('#AccountID').val(datum.ID);
        $('#Amount').val(datum.AmountPerPeriod);
	});
});
</script>

@show