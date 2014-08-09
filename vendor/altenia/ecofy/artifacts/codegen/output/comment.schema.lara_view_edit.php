
<!-- app/views/comment/edit.blade.php -->

@section('content')
<div class="container">

<!-- @todo: properly set the field name to be displayed as title -->
<h1>Edit {{ $record->name }}</h1>

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

<!-- @todo: Make sure that the primaryKey column name is sid -->
{{ Form::model($record, array('route' => array('comments.update', $record->sid), 'method' => 'PUT', 'class' => 'form-horizontal')) }}

<!--
    @todo: Remove non-editable fields.
           Add client-side validation.
-->
	<div class="form-group">
		{{ Form::label('uuid', Lang::get('comment.uuid'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('uuid', null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('domain_sid', Lang::get('comment.domain_sid'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('domain_sid', null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('domain_id', Lang::get('comment.domain_id'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('domain_id', null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('created_by', Lang::get('comment.created_by'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('created_by', null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('created_dt', Lang::get('comment.created_dt'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('created_dt', null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('updated_by', Lang::get('comment.updated_by'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('updated_by', null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('updated_dt', Lang::get('comment.updated_dt'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('updated_dt', null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('update_counter', Lang::get('comment.update_counter'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('update_counter', null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('lang', Lang::get('comment.lang'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('lang', null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('object_type', Lang::get('comment.object_type'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('object_type', null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('object_sid', Lang::get('comment.object_sid'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('object_sid', null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('title', Lang::get('comment.title'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('title', null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('content', Lang::get('comment.content'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('content', null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('attachments', Lang::get('comment.attachments'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('attachments', null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('privacy_level', Lang::get('comment.privacy_level'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('privacy_level', null, array('class' => 'form-control')) }}
		</div>
	</div>
	<div class="form-group">
		{{ Form::label('params_text', Lang::get('comment.params_text'), array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
		    {{ Form::text('params_text', null, array('class' => 'form-control')) }}
		</div>
	</div>

	<div class="form-group">
    	<div class="col-sm-offset-2 col-sm-10">
	{{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
	    </div>
	</div>

{{ Form::close() }}

</div> <!-- container -->
@show
