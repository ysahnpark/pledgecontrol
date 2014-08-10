<div>

@if (Auth::check())
<h5>User: <a href="{{ URL::to(route('users.show', array(Auth::user()->sid))) }}" >{{ Auth::user()->id }}</a><h5>
<ul>
	<li><a href="{{ URL::to('auth/signout') }}">Sign out</a></li>
</ul>
@endif

<h5>Book keeping<h5>
<ul>
	<li><a href="{{ URL::to(route('accounts.index')) }}">Accounts</a></li>
	<li><a href="{{ URL::to(route('transactions.index')) }}">Transactions</a></li>
	<li><a href="{{ URL::to(route('tickets.index')) }}">Tickets</a></li>
	<li><a href="{{ URL::to('import/form') }}">Import</a></li>
</ul>

@if (Auth::check() && Auth::user()->type == 'admin')
<h5>Admin<h5>
<ul>
	<li><a href="{{ URL::to(route('users.index')) }}">Users</a></li>
	<li><a href="{{ URL::to('accounts_report') }}">Accounts Report</a></li>
	<li><a href="{{ URL::to('report/general') }}">General Report</a></li>
</ul>
@endif
</div>
