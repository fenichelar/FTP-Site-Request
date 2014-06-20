@echo off
for /f "tokens=1,2,3,4 delims=," %%a in (C:\ftp\Users.csv) do (
    echo Username = %%a
    echo Password = %%b
    echo Expiration = %%c
    echo Email = %%d
)
