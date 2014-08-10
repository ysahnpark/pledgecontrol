
<!-- app/views/users/show.blade.php -->

@section('content')
<div class="container">

<!-- @todo - the field to be displayed as title -->

<dl class="dl-horizontal">
    <dt>{{ Lang::get('user.org_name') }}</dt>
    <dd>{{ $record->org_name }}</dd>
    <dt>{{ Lang::get('user.created_dt') }}</dt>
    <dd>{{ $record->created_dt }}</dd>
    <dt>{{ Lang::get('user.updated_dt') }}</dt>
    <dd>{{ $record->updated_dt }}</dd>
    <dt>{{ Lang::get('user.updated_counter') }}</dt>
    <dd>{{ $record->updated_counter }}</dd>
    <dt>{{ Lang::get('user.uuid') }}</dt>
    <dd>{{ $record->uuid }}</dd>
    <dt>{{ Lang::get('user.original_domain_id') }}</dt>
    <dd>{{ $record->original_domain_id }}</dd>
    <dt>{{ Lang::get('user.id') }}</dt>
    <dd>{{ $record->id }}</dd>
    <dt>{{ Lang::get('user.first_name') }}</dt>
    <dd>{{ $record->first_name }}</dd>
    <dt>{{ Lang::get('user.middle_name') }}</dt>
    <dd>{{ $record->middle_name }}</dd>
    <dt>{{ Lang::get('user.last_name') }}</dt>
    <dd>{{ $record->last_name }}</dd>
    <dt>{{ Lang::get('user.lc_name') }}</dt>
    <dd>{{ $record->lc_name }}</dd>
    <dt>{{ Lang::get('user.display_name') }}</dt>
    <dd>{{ $record->display_name }}</dd>
    <dt>{{ Lang::get('user.bdate') }}</dt>
    <dd>{{ $record->bdate }}</dd>
    <dt>{{ Lang::get('user.phone') }}</dt>
    <dd>{{ $record->phone }}</dd>
    <dt>{{ Lang::get('user.email') }}</dt>
    <dd>{{ $record->email }}</dd>
    <dt>{{ Lang::get('user.permalink') }}</dt>
    <dd>{{ $record->permalink }}</dd>
    <dt>{{ Lang::get('user.activation_code') }}</dt>
    <dd>{{ $record->activation_code }}</dd>
    <dt>{{ Lang::get('user.security_question') }}</dt>
    <dd>{{ $record->security_question }}</dd>
    <dt>{{ Lang::get('user.security_answer') }}</dt>
    <dd>{{ $record->security_answer }}</dd>
    <dt>{{ Lang::get('user.login_fail_counter') }}</dt>
    <dd>{{ $record->login_fail_counter }}</dd>
    <dt>{{ Lang::get('user.status') }}</dt>
    <dd>{{ $record->status }}</dd>
    <dt>{{ Lang::get('user.default_lang_cd') }}</dt>
    <dd>{{ $record->default_lang_cd }}</dd>
    <dt>{{ Lang::get('user.timezone') }}</dt>
    <dd>{{ $record->timezone }}</dd>
    <dt>{{ Lang::get('user.expiry_dt') }}</dt>
    <dd>{{ $record->expiry_dt }}</dd>
    <dt>{{ Lang::get('user.active_project_sid') }}</dt>
    <dd>{{ $record->active_project_sid }}</dd>
    <dt>{{ Lang::get('user.type') }}</dt>
    <dd>{{ $record->type }}</dd>
    <dt>{{ Lang::get('user.role') }}</dt>
    <dd>{{ $record->role_name }}</dd>
    <dt>{{ Lang::get('user.params_text') }}</dt>
    <dd>{{ $record->params_text }}</dd>
</dl>

</div> <!-- container -->

<script>
$(document).ready(function() {
    $('.page-header').append(' <a title="Edit" href="{{ URL::to(route('users.edit', array($record->sid))) }}"><small><span class="glyphicon glyphicon-pencil"></span></small></a>')
} );
</script>

@show