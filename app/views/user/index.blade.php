
@section('content')

<form class="form-inline" role="form" mathod="GET" action="{{ URL::to(route('users.index')) }}">
  <div class="form-group">
    <label class="sr-only" for="name-like">Name</label>
    <input type="text" name="first_name-like" class="form-control" id="Name" placeholder="Enter name" value="{{ $queryCtx->getQParamVal('first_name-like') }}">
  </div>
  <button type="submit" class="btn btn-default">Search</button>
  <button id="btn_reset" class="btn btn-default">Reset</button>
</form>

<div class="pull-right"><a href=""><span class="glyphicon glyphicon-download-alt"></span> CSV</a></div>
<table class="table table-striped">
	<thead> 
		<tr>
			<td>{{ Lang::get('common.created_dt') }}</td>
			<td>{{ Lang::get('user.id') }}</td>
			<td>{{ Lang::get('user.name') }}</td>
			<td>{{ Lang::get('user.email') }}</td>
			<td>{{ Lang::get('user.status') }}</td>
			<td>{{ Lang::get('user.type') }}</td>
			<td class="actions_col">{{ Lang::get('common.actions') }}</td>
		</tr>
	</thead>
	<tbody>
@foreach ($records as $record)
		<tr>
			<td title="Updated: {{ $record->updated_dt }}">{{ \Altenia\Ecofy\Util\DataFormat::date($record->created_dt) }}</td>
			<td><a href="users/{{ $record->sid }}">{{ $record->id }}</a></td>
			<td>{{ $record->first_name }} {{ $record->middle_name }} {{ $record->last_name }}</td>
			<td>{{ $record->email }}</td>
			<td>{{ $record->status }}</td>
			<td>{{ $record->type }}</td>

			<!-- we will also add show, edit, and delete buttons -->
			<td>
				<a class="btn btn-small btn-info" href="{{ URL::to('users/' . $record->sid . '/edit') }}"><span class="glyphicon glyphicon-pencil"></span></a>

				<!-- delete the record (uses the destroy method DESTROY /nerds/{id} -->
				{{ Form::open(array('url' => 'users/' . $record->sid, 'class' => 'pull-right')) }}
					{{ Form::hidden('_method', 'DELETE') }}
					<button title="Delete" type="button" class="btn btn-small btn-danger">
					  <span class="glyphicon glyphicon-trash"></span>
					</button>
				{{ Form::close() }}
			</td>
		</tr>
@endforeach
	</tbody>
	<tfoot>
    <tr>
      <td colspan="7"><?php echo $records->links(); ?></td>
    </tr>
  </tfoot>
</table>

{{ HTML::script('packages/datepicker/bootstrap-datepicker.js') }}
{{ HTML::style('packages/datepicker/datepicker3.css') }}
{{ HTML::script('js/typeahead.bundle.js') }}
<script>
$(document).ready(function() {
	$('.page-header').append(' <a class="btn btn-small btn-info" href="{{ URL::to(route('users.create')) }}"><span class="glyphicon glyphicon-plus"></span> New</a>')
	$('#btn_reset').click(function() {
		$('#Name').val('');
	});
});
</script>

@show