@echo off &setlocal
net user %1 /delete
if NOT errorlevel 1 (
	find /V "%1" C:\Users.csv > C:\temp.csv
	more +2 C:\temp.csv > C:\Users.csv
	del C:\temp.csv
	net user %1 %2 /expire:%3 /add
	if NOT errorlevel 1 (
		echo %1,%2,%3,%4>>C:\Users.csv
	)
)
