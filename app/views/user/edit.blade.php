
<!-- app/views/users/edit.blade.php -->

@section('content')
<div class="container" ng-controller="UserFormCtrl">

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}
<!--include ('_partial/errors')-->

{{ Form::model($record, array('route' => array('users.update', $record->sid), 'method' => 'PUT', 'class' => 'form-horizontal')) }}
	{{ Form::hidden('organization_sid', null, array('id' => 'organization_sid')) }}
	

	<div class="form-group">
		{{ Form::label('id', Lang::get('user.id'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('id', null, array('class' => 'form-control')) }}
		</div>
	</div>

	<!--
	<div class="form-group">
		{{ Form::label('password', Lang::get('user.password'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('password', null, array('class' => 'form-control')) }}
		</div>
	</div>
	-->

	<div class="form-group">
		{{ Form::label('first_name', Lang::get('user.first_name'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('first_name', null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('last_name', Lang::get('user.last_name'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('last_name', null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('lc_name', Lang::get('user.lc_name'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('lc_name', null, array('class' => 'form-control')) }}
		</div>
	</div>
	<!--
	<div class="form-group">
		{{ Form::label('dob', Lang::get('users.dob'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('dob', null, array('class' => 'form-control')) }}
		</div>
	</div>
	-->
	<div class="form-group">
		{{ Form::label('phone', Lang::get('user.phone'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('phone', null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('email', Lang::get('user.email'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('email', null, array('class' => 'form-control')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('type', Lang::get('user.type'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('type', null, array('class' => 'form-control')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('params_text', 'Params_text', array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('params_text', null, array('class' => 'form-control')) }}
		</div>
	</div>

	<div class="form-group">
    	<div class="col-sm-offset-2 col-sm-10">
	    	<button name="_submit" type="submit" value="save" class="btn btn-primary">{{ Lang::get('common.save') }}</button>
    		<button name="_submit" type="submit" value="save_return" class="btn btn-primary">{{ Lang::get('common.save_return') }}</button>
    		<a href="{{ URL::to(route('users.show', array($record->sid))) }}" class="btn btn-primary">{{ Lang::get('common.return') }}</a>
		</div>
	</div>

{{ Form::close() }}


<script>
$(document).ready(function() {
	
});
</script>


@show