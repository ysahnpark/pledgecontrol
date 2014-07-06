

<table class="table table-striped">
	<thead> 
		<tr>
			<td class="col-date">Date</td>
			<td>Name</td>
			<td>Amount</td>
			<td>Note</td>
		</tr>
	</thead>
	<tbody> 
@foreach ($transactions as $transaction)
		<tr>
			<td>{{ $transaction->PaymentDate }}</td>
			<td title="{{ $transaction->AccountID }}">{{ $transaction->Name }}</td>
			<td>{{ $transaction->Amount }}</td>
			<td>{{ $transaction->Note }}</td>
		</tr>
@endforeach
	</tbody>
  <tfoot> 
    <tr>
      <td colspan="4">Pagination</td>
      </tr>    
  </tfoot> 
</table>