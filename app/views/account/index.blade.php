
@section('content')
<form class="form-inline" role="form" method="POST" action="">
  <div class="form-group">
    <label class="sr-only" for="name">Name</label>
    <input type="email" class="form-control" id="name" placeholder="Enter name">
  </div>
  <div class="form-group">
    <label class="sr-only" for="name">Amount</label>
    <input type="email" class="form-control" id="amount" placeholder="Enter amount">
  </div>
  <button type="submit" class="btn btn-default">Add Trans</button>
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
			<td>{{ $account->PledgeDate }}</td>
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