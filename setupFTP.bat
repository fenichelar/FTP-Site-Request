@echo off
net user %1 %2 /expire:%3 /add
if NOT errorlevel 1 (
	echo %1,%2,%3,%4>>C:\Users.csv
	mkdir F:\FTP\LocalUser\%1
)
