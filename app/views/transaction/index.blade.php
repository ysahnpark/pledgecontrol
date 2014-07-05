
@section('content')

<div class="panel panel-info">
  <div class="panel-heading">
    <h4 class="panel-title">Add New Transaction</h4>
  </div>
  <div class="panel-body">
  	<!-- PANE CONTENT { -->
    <form class="form-inline" role="form" method="POST" action="{{ URL::to(route('transactions.store')) }}">
   	  <input type="hidden" name="_return_url" value="{{ URL::to(route('transactions.index')) }}" />
   	  <input type="hidden" name="AccountID" id="AccountID" value="" />
	  <div class="form-group" id="remote">
	    <label class="sr-only" for="name">Name</label>
	    <input type="text" class="form-control typeahead" name="Name" id="name" placeholder="Enter name">
	  </div>
	  <div class="form-group">
	    <label class="sr-only" for="name">Amount</label>
	    <input type="number" class="form-control" name="Amount" id="amount" placeholder="Enter amount">
	  </div>
	  <div class="form-group">
	    <label class="sr-only" for="name">Note</label>
	    <input type="text" class="form-control" name="Note" id="amount" placeholder="Note">
	  </div>
	  <button type="submit" class="btn btn-default">Add Trans</button>
	</form>
	<!-- } PANE CONTENT -->
  </div>
</div>


<table class="table table-striped">
	<thead> 
		<tr>
			<td>Date</td>
			<td>Name</td>
			<td>Amount</td>
			<td>Note</td>
		</tr>
	</thead>
	<tbody> 
@foreach ($records as $tranaction)
		<tr>
			<td>{{ $tranaction->PaymentDate }}</td>
			<td title="{{ $tranaction->AccountID }}">{{ $tranaction->Name }}</td>
			<td>{{ $tranaction->Amount }}</td>
			<td>{{ $tranaction->Note }}</td>
		</tr>
@endforeach
	</tbody>
  <tfoot> 
    <tr>
      <td colspan="4">Pagination</td>
      </tr>    
  </tfoot> 
</table>

{{ HTML::script('js/typeahead.bundle.js') }}
<script>
$(document).ready(function() {
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
	});
});
</script>

@show