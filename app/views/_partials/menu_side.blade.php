<div>

<h5>Admin<h5>
<ul>
	<li><a href="{{ URL::to(route('accounts.index')) }}">Accounts</a></li>
	<li><a href="{{ URL::to(route('transactions.index')) }}">Transactions</a></li>
	<li><a href="{{ URL::to(route('tickets.index')) }}">Tickets</a></li>
	<li><a href="{{ URL::to('import/form') }}">Import</a></li>
</ul>

<h5>Reports<h5>
<ul>
	<li><a href="{{ URL::to('accounts_report') }}">Account</a></li>
	<li><a href="{{ URL::to('report/general') }}">General</a></li>
</ul>
</div>