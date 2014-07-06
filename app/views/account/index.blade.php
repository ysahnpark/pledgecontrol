
@section('content')
<form class="form-inline" role="form" mathod="GET" action="{{ URL::to(route('accounts.index')) }}">
  <div class="form-group">
    <label class="sr-only" for="name-like">Name</label>
    <input type="text" name="Name-like" class="form-control" id="Name" placeholder="Enter name" value="{{ $queryCtx->getQParamVal('Name-like') }}">
  </div>
  <button type="submit" class="btn btn-default">Search</button>
  <button id="btn_reset" class="btn btn-default">Reset</button>
</form>

<div class="pull-right"><a href="{{ URL::to(route('accounts.index')) }}?_format=csv&{{ $queryCtx->buildQueryString() }}">
	<span class="glyphicon glyphicon-download-alt"></span> CSV
	</a></div>
<table class="table table-striped">
	<thead> 
		<tr>
			<td>{{ Lang::get('account.Name') }}</td>
			<td>{{ Lang::get('account.PledgeAmount') }}</td>
			<td>{{ Lang::get('account.PledgeDate') }}</td>
			<td>{{ Lang::get('account.PaymentPeriod') }}</td>
			<td>{{ Lang::get('account.PaidAmount') }}</td>
			<td>{{ Lang::get('account.RemainingAmount') }}</td>
			<td>{{ Lang::get('account.RemindLetterSent') }}</td>
			<td>{{ Lang::get('account.RemindLetterSentDate') }}</td>
		</tr>
	</thead>
	<tbody> 
@foreach ($records as $account)
		<tr>
			<td><a href="{{ URL::to(route('accounts.show', array($account->ID))) }}">{{ $account->Name }}</a></td>
			<td class="col-amount">{{ $account->PledgeAmount }}</td>
			<td>{{ \DocuFlow\Helper\DfFormat::date($account->PledgeDate) }}</td>
			<td>{{ $account->PaymentPeriod }}</td>
			<td class="col-amount">{{ $account->PaidAmount }}</td>
			<td class="col-amount">{{ $account->RemainingAmount }}</td>
			<td>{{ $account->RemindLetterSent }}</td>
			<td>{{ \DocuFlow\Helper\DfFormat::date($account->RemindLetterSentDate) }}</td>
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
	$('#btn_reset').click(function() {
		$('#Name').val('');
	});
});
</script>


@show