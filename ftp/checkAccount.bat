@echo off

set "username=%1"
set "password=%2"
set "expiration=%3"
set "email=%4"

set "today=%DATE:~4,2%-%DATE:~7,2%-%DATE:~10,4%"
set "one=1"
set "ten=10"

echo Wscript.Echo #%expiration%# - #%today%# > tmp.vbs
for /f %%a in ('cscript /nologo tmp.vbs') do set "total=%%a"
del tmp.vbs

if %total% LSS %one% (
	net user %username% /delete
	if NOT errorlevel 1 (
		find /V "%username%" C:\ftp\Users.csv > C:\ftp\temp.csv
		more +2 C:\ftp\temp.csv > C:\ftp\Users.csv
		del C:\ftp\temp.csv
		echo %username%,%password%,%expiration%,%email% >> C:\ftp\ExpiredUsers.csv
	)
) else (
	if %total% LSS %ten% (
		php C:\ftp\sendEmail.php %username% %email% %expiration%
	)
)
