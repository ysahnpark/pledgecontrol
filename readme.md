PledgeControl
=============
Web application that facilitates pledge control for Church and other charitative organizations.

The application is implemented in PHP using Laravel Framework.

#Installation#

# Requirements #
Requirements are:
- PHP 5.4+
- MySQL 5.x


##Get it from git##
If you do not have a git client yet, download and insall one first. You can get the console git client from [github][1].

If you have git, go to the directory where you want to install the application and clone from git repo.

`git clone https://github.com/ysahnpark/pledgecontrol.git`

## Prepare database ##
The PledgeControl requires [MySQL 5.x][2].
Open MySQL console and create a database:

`CREATE DATABASE pledgecontrol DEFAULT CHARACTER SET utf8;`

Then grant privileges to the application user

`GRANT ALL PRIVILEGES ON pledgecontrol.* to pcapp@localhost IDENTIFIED by 'pcapp';`

## Prepare application ##
From the installation directory run
`php artisan migrate`
(If you get error about php not found, then you will need to add the php executable to the path.)

Now the tables in the `pledgecontrol` database should have been created.

now you can start the server by running:
`php artisan serve`


  [1]: http://git-scm.com/downloads
  [2]: http://www.mysql.com/
  

#Users Guide#

##Introduction##
There are three major components: 
- **Accounts**: Manages the pledge accounts. A pledge account includes information such as person data, pledge amount, payment period,  etc.
- **Transaction**: Manages the transactions, i.e. money collection data.
- **Ticket**: Manages the tickets to handle issues such as request for first payment, notify for overdue, etc.

##Basic Flow##
First, the account must be created. The pledge amount and pledge duration will determine the pledge amount per period.

Once the account is created, a staff can start registering transactions. When filling the form for adding a transaction, make sure that the account name is selected from dropdown.

The staff can create tickets if there is a task that requires follow-up such as notify for the first-payment of handle overdue situation.

##Reports##

The staff can monitor the pledge status and trend with the reports.
The accounts report lists all the accounts along with the pledge information and the current amount due. The orange [T] icon is shown for those overdue accounts to create tickets.
It is possible to filter the report by name and by amount due. For example if you want to list all the accounts that have overdue, you can type a number in the field "Amount Due >".

The general report provides summary information, histograms and time charts.