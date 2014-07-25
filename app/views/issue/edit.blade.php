
<!-- app/views/account/edit.blade.php -->

@section('content')
<div class="container">

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

<!-- @todo: Make sure that the primaryKey column name is sid -->
{{ Form::model($record, array('route' => array('issues.update', $record->ID), 'method' => 'PUT', 'class' => 'form-horizontal')) }}

<!--
    @todo: Remove non-editable fields.
           Add client-side validation.
-->
	<input type="hidden" id="AccountID" name="AccountID" value="{{ $record->account->ID }}" />
	<div class="form-group">
		{{ Form::label('IssueDate', Lang::get('issue.IssueDate'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ $record->IssueDate }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('Name', Lang::get('account.Name'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ $record->account->Name }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('HandledBy', Lang::get('issue.HandledBy'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('HandledBy', null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('Category', Lang::get('issue.Category'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::select('Category', $auxdata['opt_Category'], null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('Description', Lang::get('issue.Description'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::textarea('Description', null, array('class' => 'form-control', 'size' => '50x5')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('Status', Lang::get('issue.Status'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::select('Status', $auxdata['opt_Status'], null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('Log', Lang::get('issue.Log'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::textarea('Log', null, array('class' => 'form-control', 'size' => '50x5')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('Result', Lang::get('issue.Result'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::textarea('Result', null, array('class' => 'form-control', 'size' => '50x5')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('NotificationSentDate', Lang::get('issue.NotificationSentDate'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('NotificationSentDate', null, array('class' => 'form-control date')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('Note', Lang::get('issue.Note'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::textarea('Note', null, array('class' => 'form-control', 'size' => '50x5')) }}
		</div>
	</div>

	<div class="form-group">
    	<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" value="save" class="btn btn-primary">{{ Lang::get('common.save') }}</button>
    		<button type="submit" value="save_return" class="btn btn-primary">{{ Lang::get('common.save_return') }}</button>
	    </div>
	</div>

{{ Form::close() }}

</div> <!-- container -->

{{ HTML::script('packages/datepicker/bootstrap-datepicker.js') }}
{{ HTML::style('packages/datepicker/datepicker3.css') }}
<script>
$(document).ready(function() {

	$('.date').datepicker({
		format: " yyyy-mm-dd",
		autoclose: true
	});

});
</script>

@show
