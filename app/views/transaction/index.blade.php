
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
			<td>{{ $tranaction->Name }}</td>
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

@show