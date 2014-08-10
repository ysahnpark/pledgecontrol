<!-- app/views/users/edit.blade.php -->

@section('content')
<div class="container">

<h1>Create New</h1>

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

<!-- Make sure that the primaryKey column name is sid -->
{{ Form::open(array('url' => 'users', 'class' => 'form-horizontal')) }}


	<div class="form-group">
		{{ Form::label('id', Lang::get('user.id'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('id', Input::old('id'), array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('password', Lang::get('user.password'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('password', Input::old('password'), array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('password_confirmation', 'Password Confirmation', array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm Password')) }}
		</div>
	</div>
 
	<div class="form-group">
		{{ Form::label('first_name', Lang::get('user.first_name'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('first_name', Input::old('first_name'), array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('last_name', Lang::get('user.last_name'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('last_name', Input::old('last_name'), array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('lc_name', Lang::get('user.lc_name'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('lc_name', Input::old('lc_name'), array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('phone', Lang::get('user.phone'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('phone', Input::old('phone'), array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('email', Lang::get('user.email'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('email', Input::old('email'), array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('type', Lang::get('user.type'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('type', Input::old('type'), array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('params_text', Lang::get('user.params_text'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('params_text', Input::old('params_text'), array('class' => 'form-control')) }}
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