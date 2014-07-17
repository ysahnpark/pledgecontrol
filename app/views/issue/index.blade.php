
@section('content')

{{ HTML::script('packages/validator/bootstrapValidator.min.js') }}
{{ HTML::style('packages/validator/bootstrapValidator.min.css') }}

<div class="panel panel-info">
  <div class="panel-heading">
    <h4 class="panel-title">Add New Issue</h4>
  </div>
  <div class="panel-body">
  	<!-- PANE CONTENT { -->
    <form id="IssueForm" class="form-inline" role="form" method="POST" action="{{ URL::to(route('issues.store')) }}">
   	  <input type="hidden" name="_return_url" value="{{ URL::to(route('issues.index')) }}" />
   	  <input type="hidden" name="AccountID" id="AccountID" value="" />
	  <div class="form-group" id="remote">
	    <label class="sr-only" for="name">Name</label>
	    <input required type="text" class="form-control typeahead"  name="Name" id="Name" placeholder="Enter name">
	  </div>
	  <div class="form-group">
	    <label class="sr-only" for="name">Category</label>
	    <input required type="text" class="form-control" name="Category" id="Amount" placeholder="Enter Category">
	  </div>
	  <div class="form-group">
	    <label class="sr-only" for="name">Note</label>
	    <input type="text" class="form-control" name="Note" id="Note" placeholder="Note">
	  </div>
	  <button type="submit" class="btn btn-default">Add issue</button>
	</form>
	<!-- } PANE CONTENT -->
  </div>
</div>

<div class="pull-right"><a href=""><span class="glyphicon glyphicon-download-alt"></span> CSV</a></div>
<table class="table table-striped">
	<thead> 
		<tr>
			<td class="col-date">Date</td>
			<td>Name</td>
			<td>Category</td>
			<td>Note</td>
		</tr>
	</thead>
	<tbody> 
@foreach ($records as $issue)
		<tr>
			<td>{{ $issue->IssueDate }}</td>
			<td title="{{ $issue->AccountID }}"><a href="{{ URL::to(route('accounts.show', array($issue->AccountID))) }}">{{ $issue->account->Name }}</a></td>
			<td >{{ $issue->Category }}</td>
			<td>{{ $issue->Note }}</td>
		</tr>
@endforeach
	</tbody>
  <tfoot>
    <tr>
      <td colspan="4"><?php echo $records->links(); ?></td>
    </tr>
  </tfoot>
</table>

{{ HTML::script('js/typeahead.bundle.js') }}
<script>
$(document).ready(function() {
	
	//$('#IssueForm').parsley();
	//$('#IssueForm').bootstrapValidator({

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