
@section('content')

{{ HTML::script('packages/validator/bootstrapValidator.min.js') }}
{{ HTML::style('packages/validator/bootstrapValidator.min.css') }}

<div class="panel panel-info">
  <div class="panel-heading">
    <h4 class="panel-title">Add New {{Lang::get('ticket._name')}}</h4>
  </div>
  <div class="panel-body">
  	<!-- PANE CONTENT { -->
    <form id="TicketForm" class="form-inline" role="form" method="POST" action="{{ URL::to(route('tickets.store')) }}">
   	  <input type="hidden" name="_return_url" value="{{ URL::to(route('tickets.index')) }}" />
   	  <input type="hidden" name="Status" id="Status" value="{{ array_keys($auxdata['opt_Status'])[0] }}" />
   	  <input type="hidden" name="AccountID" id="AccountID" value="" />
	  <div class="form-group" id="remote">
	    <label class="sr-only" for="name">Name</label>
	    <input required type="text" class="form-control typeahead"  name="Name" id="Name" placeholder="Enter name">
	  </div>
	  <div class="form-group">
	    <label class="sr-only" for="name">Category</label>
	    {{ Form::select('Category', $auxdata['opt_Category'], null, array('class' => 'form-control')) }}
	  </div>
	  <div class="form-group">
	    <label class="sr-only" for="name">Note</label>
	    <input type="text" class="form-control" name="Note" id="Note" placeholder="Note">
	  </div>
	  <button type="submit" class="btn btn-default">Add {{Lang::get('ticket._name')}}</button>
	</form>
	<!-- } PANE CONTENT -->
  </div>
</div>

<div class="pull-right"><a href=""><span class="glyphicon glyphicon-download-alt"></span> CSV</a></div>
<table class="table table-striped">
	<thead> 
		<tr>
			<td class="col-date">Date</td>
			<td>{{Lang::get('ticket.Name')}}</td>
			<td>{{Lang::get('ticket.Category')}}</td>
			<td>{{Lang::get('ticket.Status')}}</td>
			<td>{{Lang::get('ticket.NotificationDate')}}</td>
			<td>{{Lang::get('ticket.Result')}}</td>
			<td>Action</td>
		</tr>
	</thead>
	<tbody> 
@foreach ($records as $ticket)
		<tr>
			<td>{{ $ticket->TicketDate }}</td>
			<td title="{{ $ticket->AccountID }}"><a href="{{ URL::to(route('accounts.show', array($ticket->AccountID))) }}">{{  $ticket->account->Name }}</a></td>
			<td >{{ $ticket->Category }}</td>
			<td>{{ $ticket->Status }}</td>
			<td>{{ $ticket->NotificationDate }}</td>
			<td>{{ $ticket->Result }}</td>
			<td>
				<a class="btn btn-warning" href="{{ URL::to(route('tickets.edit', array($ticket->ID))) }}">Details</a>
			</td>
		</tr>
@endforeach
	</tbody>
  <tfoot>
    <tr>
      <td colspan="6"><?php echo $records->links(); ?></td>
    </tr>
  </tfoot>
</table>

{{ HTML::script('js/typeahead.bundle.js') }}
<script>
$(document).ready(function() {
	$('.page-header').append(' <a class="btn btn-small btn-info" href="{{ URL::to(route('tickets.create')) }}"><span class="glyphicon glyphicon-plus"></span> New</a>')
	//$('#TicketForm').parsley();
	//$('#TicketForm').bootstrapValidator({

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