@echo off
net user %1 %2 /expire:%3 /add
mkdir F:\FTP\LocalUser\%1