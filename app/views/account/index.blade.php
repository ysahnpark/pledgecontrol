
@section('content')
<form class="form-inline" role="form" mathod="GET" action="{{ URL::to(route('accounts.index')) }}">
  <div class="form-group">
    <label class="sr-only" for="name-like">Name</label>
    <input type="text" name="Name-like" class="form-control" id="Name" placeholder="Enter name" value="{{ $queryCtx->getQParamVal('Name-like') }}">
  </div>
  <button type="submit" class="btn btn-default">Search</button>
</form>

<table class="table table-striped">
	<thead> 
		<tr>
			<td>Name</td>
			<td>PledgeAmount</td>
			<td>PledgeDate</td>
			<td>PaymentPeriod</td>
			<td>PaidAmount</td>
			<td>RemainingAmount</td>
			<td>RemindLetterSent</td>
			<td>RemindLetterSentDate</td>
		</tr>
	</thead>
	<tbody> 
@foreach ($records as $account)
		<tr>
			<td>{{ $account->Name }}</td>
			<td>{{ $account->PledgeAmount }}</td>
			<td>{{ \DocuFlow\Helper\DfFormat::date($account->PledgeDate) }}</td>
			<td>{{ $account->PaymentPeriod }}</td>
			<td>{{ $account->PaidAmount }}</td>
			<td>{{ $account->RemainingAmount }}</td>
			<td>{{ $account->RemindLetterSent }}</td>
			<td>{{ $account->RemindLetterSentDate }}</td>
		</tr>
@endforeach
	</tbody>
  <tfoot> 
    <tr>
      <td colspan="8">Pagination</td>
      </tr>    
  </tfoot> 
</table>

<script>
$(document).ready(function() {
	$('.page-header').append(' <a class="btn btn-small btn-info" href="{{ URL::to(route('accounts.create')) }}"><span class="glyphicon glyphicon-plus"></span> New</a>')
});
</script>


@show