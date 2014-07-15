
<!-- app/views/account/edit.blade.php -->

@section('content')
<div class="container">

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

<!-- @todo: Make sure that the primaryKey column name is sid -->
{{ Form::open(array('route' => array('accounts.store'), 'class' => 'form-horizontal')) }}
<!--
    @todo: Remove non-editable fields.
           Add client-side validation.
-->
	<input type="hidden" id="PaymentPeriod" name="PaymentPeriod" />
	<input type="hidden" id="PeriodUnit" name="PeriodUnit" />
	<div class="form-group">
		{{ Form::label('SignupDate', Lang::get('account.SignupDate'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('SignupDate', Input::old('SignupDate'), array('class' => 'form-control date')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('Name', Lang::get('account.Name'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('Name', Input::old('Name'), array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('PledgeAmount', Lang::get('account.PledgeAmount'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('PledgeAmount', Input::old('PledgeAmount'), array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('PledgeStartDate', Lang::get('account.PledgeStartDate'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('PledgeStartDate', Input::old('PledgeStartDate'), array('class' => 'form-control date')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('Duration', Lang::get('account.Duration'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('Duration', Input::old('Duration'), array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('PaymentCycle', Lang::get('account.PaymentCycle'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::select('PaymentCycle', $auxdata['opt_PaymentCycle'], null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('AmountPerPeriod', Lang::get('account.AmountPerPeriod'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    <input type="number" id="AmountPerPeriod" name="AmountPerPeriod" class="form-control" readonly/>
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('Email', Lang::get('account.Email'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('Email', Input::old('Email'), array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('Phone', Lang::get('account.Phone'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('Phone', Input::old('Phone'), array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('Address', Lang::get('account.Address'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('Address', Input::old('Address'), array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('City', Lang::get('account.City'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('City', Input::old('City'), array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('State', Lang::get('account.State'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('State', Input::old('State'), array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('PostalCode', Lang::get('account.PostalCode'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('PostalCode', Input::old('PostalCode'), array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('Note', Lang::get('account.Note'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('Note', Input::old('Note'), array('class' => 'form-control')) }}
		</div>
	</div>


	<div class="form-group">
    	<div class="col-sm-offset-2 col-sm-10">
	{{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
	    </div>
	</div>

{{ Form::close() }}

</div> <!-- container -->

{{ HTML::script('packages/datepicker/bootstrap-datepicker.js') }}
{{ HTML::style('packages/datepicker/datepicker3.css') }}
{{ HTML::script('js/view/account_form.js') }}
<script>
$(document).ready(function() {

	parsePaymentCycle();

	$('.date').datepicker({
		format: " yyyy-mm-dd",
		autoclose: true
	});

	$('#PledgeAmount').change(function(){
		calcAmountPerPeriod();
	});

	$('#Duration').change(function(){
		calcAmountPerPeriod();
	});

	$('#PaymentCycle').change(function(){
		parsePaymentCycle();
		calcAmountPerPeriod();
	});


});
</script>
@show
