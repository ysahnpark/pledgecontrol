
<!-- app/views/account/edit.blade.php -->

@section('content')
<div class="container">

<!-- @todo: Make sure that the primaryKey column name is sid -->
{{ Form::open(array('url' => 'import/form', 'class' => 'form-horizontal')) }}

	<div class="form-group">
		{{ Form::label('Type', Lang::get('import.Type'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::select('Type', $auxdata['opt_Type'], $type, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('Data', Lang::get('import.Data'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::textarea('Data', $data, array('class' => 'form-control', 'size' => '50x5')) }}
		</div>
	</div>
	<div class="form-group">
    	<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" name="mode" value="validate" class="btn btn-primary">{{ Lang::get('import.validate') }}</button>
@if (isset($isvalid) && $isvalid )
    		<button type="submit" name="mode" value="process" class="btn btn-primary">{{ Lang::get('import.process') }}</button>
@endif
	    </div>
	</div>

{{ Form::close() }}

@if (!empty($rows))
<table class="table table-striped">
	<thead> 
		<tr>
@foreach ($rows[0] as $header => $dummy)
			<th>{{ $header }}</th>
@endforeach
		</tr>
	</thead>
	<tbody> 
@foreach ($rows as $row)
		<tr>
@foreach ($row as $name => $val)
			<td>{{ $val }}</td>
@endforeach
		</tr>
@endforeach
	</tbody>
</table>
@endif

@if (isset($result) )
	@if (!$isvalid )
<h4>Errors</h4>
<ul>
@foreach ($result['errors'] as $error)
	<li>Line {{ $error['line'] }}: 
		@if (is_array($error['message'])):
			@foreach ($error['message'] as $field => $detail)
			[{{ $field }}] - <?php print_r($detail) ?>
			@endforeach
		@else
			{{ $error['message'] }}
		@endif
	</li>
@endforeach
<ul>
	@else
<dt>Total count</dt>
<dd>{{ $result['items_count'] }}</dd>
<dt>Items processed</dt>
<dd>{{ $result['items_processed'] }}</dd>
	@endif
@endif

</div> <!-- container -->

<script>
$(document).ready(function() {

	
});
</script>

@show
