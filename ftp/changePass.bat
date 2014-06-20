@echo off &setlocal
net user %1 /delete
if NOT errorlevel 1 (
	find /V "%1" C:\ftp\Users.csv >C:\ftp\temp.csv
	more +2 C:\ftp\temp.csv > C:\ftp\Users.csv
	del C:\ftp\temp.csv
	net user %1 %2 /expire:%3 /add
	if NOT errorlevel 1 (
		echo %1,%2,%3,%4>>C:\ftp\Users.csv
	)
)
