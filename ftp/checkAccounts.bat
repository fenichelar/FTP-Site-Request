@echo off
for /f "tokens=1,2,3,4 delims=," %%a in (C:\ftp\Users.csv) do (
	set "username=%%a"
	set "password=%%b"
	set "expiration=%%c"
	set "email=%%d"

	C:\ftp\adminCheckAccount.lnk %%a %%b %%c %%d
	
)
