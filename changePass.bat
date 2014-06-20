@echo off &setlocal
net user %1 /delete
if NOT errorlevel 1 (
	find /V "%1" Users.csv > temp.csv
	more +2 temp.csv > Users.csv
	del C:\temp.csv
	net user %1 %2 /expire:%3 /add
	if NOT errorlevel 1 (
		echo %1,%2,%3,%4>>C:\Users.csv
	)
)
