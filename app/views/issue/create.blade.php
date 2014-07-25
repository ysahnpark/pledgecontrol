
<!-- app/views/account/edit.blade.php -->
@section('content')
<div class="container">

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

<!-- @todo: Make sure that the primaryKey column name is sid -->
{{ Form::open(array('route' => array('issues.store'), 'class' => 'form-horizontal')) }}

<!--
    @todo: Remove non-editable fields.
           Add client-side validation.
-->
	<input type="hidden" id="AccountID" name="AccountID" value="{{ $auxdata['field']['AccountID'] }}" />

	<?php
	function getFieldVal($fieldName, $defaultVal) {
		$val = Input::old($fieldName);
		if (empty($val) && !empty($defaultVal)) {
			$val = $defaultVal;
		}
		return $val;
	}
	$nameVal = Input::old('Name');
	if (empty($nameVal) && isset($auxdata['field']['AccountName'])) {
		$nameVal = $auxdata['field']['AccountName'];
	}
	$categoryVal = getFieldVal('Category', $auxdata['field']['Category']);
	
	?>
	<div class="form-group">
		{{ Form::label('Name', Lang::get('account.Name'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('Name', $nameVal, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('HandledBy', Lang::get('issue.HandledBy'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('HandledBy', Input::old('HandledBy'), array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('Category', Lang::get('issue.Category'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::select('Category', $auxdata['opt_Category'], $categoryVal, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('Description', Lang::get('issue.Description'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::textarea('Description', Input::old('Description'), array('class' => 'form-control', 'size' => '50x5')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('Status', Lang::get('issue.Status'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::select('Status', $auxdata['opt_Status'], Input::old('Status'), array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('Log', Lang::get('issue.Log'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::textarea('Log', Input::old('Log'), array('class' => 'form-control', 'size' => '50x5')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('Result', Lang::get('issue.Result'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::textarea('Result', Input::old('Result'), array('class' => 'form-control', 'size' => '50x5')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('NotificationSentDate', Lang::get('issue.NotificationSentDate'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('NotificationSentDate', Input::old('NotificationSentDate'), array('class' => 'form-control date')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('Note', Lang::get('issue.Note'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::textarea('Note', Input::old('Note'), array('class' => 'form-control', 'size' => '50x5')) }}
		</div>
	</div>

	<div class="form-group">
    	<div class="col-sm-offset-2 col-sm-10">
	{{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
	    </div>
	</div>

{{ Form::close() }}

</div> <!-- container -->

{{ HTML::script('packages/datepicker/bootstrap-datepicker.js') }}
{{ HTML::style('packages/datepicker/datepicker3.css') }}
{{ HTML::script('js/typeahead.bundle.js') }}
<script>
$(document).ready(function() {

	$('.date').datepicker({
		format: " yyyy-mm-dd",
		autoclose: true
	});

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
