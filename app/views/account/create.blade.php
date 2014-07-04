
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
		{{ Form::label('PledgeDate', Lang::get('account.PledgeDate'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('PledgeDate', Input::old('PledgeDate'), array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('PaymentPeriod', Lang::get('account.PaymentPeriod'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::select('PaymentPeriod', $auxdata['opt_PaymentPeriod'], Input::old('PaymentPeriod'), array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('LastPaymentDate', Lang::get('account.LastPaymentDate'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('LastPaymentDate', Input::old('LastPaymentDate'), array('class' => 'form-control')) }}
		</div>
	</div>


	<div class="form-group">
    	<div class="col-sm-offset-2 col-sm-10">
	{{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
	    </div>
	</div>

{{ Form::close() }}

</div> <!-- container -->
@show
