@section('content')
    <div class="container">
      <!-- title row -->
      <div class="col-md-12" style="text-align: center">
        <h3>{{ Lang::get('site.signin') }}</h3>
      </div>

      <!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}
      <!-- Row of columns -->
      <div class="col-md-12 " >
@if (Session::has('message'))
			<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
      	{{ Form::open(array('url' => 'auth/signin', 'class' => 'form-horizontal form-signin')) }}
          <div class="form-group">
            {{ Form::label('loginId', 'ID or email', array('class' => 'col-sm-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('login_id', Input::old('login_id'), array('class' => 'form-control', 'placeholder' => 'ID or Email' )) }}
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('password', Lang::get('user.password'), array('class' => 'col-sm-2 control-label')) }}
            <div class="col-sm-10">
            	{{ Form::text('password', Input::old('password'), array('class' => 'form-control', 'placeholder'=>Lang::get('user.password') )) }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="checkbox">
                <label>
                  <input type="checkbox"> Remember me
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
            	{{ Form::submit(Lang::get('site.signin'), array('class' => 'btn btn-primary')) }}
            </div>
          </div>
        {{ Form::close() }}
      </div>

    </div> <!-- /container -->
@show
