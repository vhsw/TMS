@ECHO OFF

SETLOCAL ENABLEEXTENSIONS
SETLOCAL DISABLEDELAYEDEXPANSION

:Menu
CLS

ECHO.
Call :Color 3 "    ######" C " Uhlelo Tool System " 3 "###### " \n
Call :Color 3 "    #                              # " \n
Call :Color 3 "    #   " C "(1  Install / Reinstall" 3 "    # " \n
Call :Color 3 "    #   " C "(2  Check for Update" 3 "       # " \n
Call :Color 3 "    #   " C "(3  Set Environment" 3 "        # " \n
Call :Color 3 "    #   " C "(4  Exit" 3 "                   # " \n
Call :Color 3 "    #                              # " \n
Call :Color 3 "    ################################ " \n
ECHO.
ECHO.

set /p M=Option: 
IF %M%==1 GOTO Install
IF %M%==2 GOTO End
IF %M%==3 GOTO SetEnvironment
IF %M%==4 GOTO End



:Install
WHERE composer --version >nul 2>nul 
IF %ERRORLEVEL% NEQ 0 (
	Call :Color C "Error: Could Not Find Composer" \n
	GOTO End
)
WHERE git --version >nul 2>nul 
IF %ERRORLEVEL% NEQ 0 (
	Call :Color C "Error: Could Not Find Git" \n
	GOTO End
)
GOTO SetVersion


:SetVersion
ECHO.
FOR /f "tokens=3 delims= " %%a in ('composer --version') DO SET versioncomposer=%%a
Call :Color A "Composer Found! Version: %versioncomposer:~5%" \n

FOR /f "tokens=3 delims= " %%a in ('git --version') DO SET versiongit=%%a
Call :Color A "Git Found! Version: %versiongit%" \n

IF EXIST E:\www\test (
	ECHO.
	Call :Color C "Error: Directory Already Exist" \n
	GOTO End
)

CD E:\www
CMD /C composer -q create-project laravel/laravel test "5.1.*"
CD E:\www\test
git init
git remote add origin git@github.com:matapuna/uhlelo.git
git fetch --all
git branch master origin/master
git checkout master
git reset --hard origin/master
CMD /C composer update --no-scripts
GOTO Menu


:SetEnvironment
ECHO.
SET fileEnv=E:\www\test\.env

for /f "tokens=*" %%a in ('findstr "DB_HOST" %fileEnv%') do set _resHost=%%a
for /f "tokens=*" %%a in ('findstr "DB_DATABASE" %fileEnv%') do set _resDatabase=%%a
for /f "tokens=*" %%a in ('findstr "DB_USERNAME" %fileEnv%') do set _resUsername=%%a
for /f "tokens=*" %%a in ('findstr "DB_PASSWORD" %fileEnv%') do set _resPassword=%%a

call jrepl "\%_resHost%\b" "DB_HOST=localhost" /f %fileEnv% /o -
call jrepl "\%_resDatabase%\b" "DB_DATABASE=tms" /f %fileEnv% /o -
call jrepl "\%_resUsername%\b" "DB_USERNAME=root" /f %fileEnv% /o -
call jrepl "\%_resPassword%\b" "DB_PASSWORD=" /f %fileEnv% /o -

Call :Color A Environment have been set \n
ECHO.
pause
GOTO Menu


:End
ECHO.
pause
exit




:Color
:: v23c
:: Arguments: hexColor text [\n] ...
:: \n -> newline ... -> repeat
:: Supported in windows XP, 7, 8.
:: This version works using Cmd /U
:: In XP extended ascii characters are printed as dots.
:: For print quotes, use empty text.
SetLocal EnableExtensions EnableDelayedExpansion
Subst `: "!Temp!" >Nul &`: &Cd \
SetLocal DisableDelayedExpansion
Echo(|(Pause >Nul &Findstr "^" >`)
Cmd /A /D /C Set /P "=." >>` <Nul
For /F %%# In (
'"Prompt $H &For %%_ In (_) Do Rem"') Do (
Cmd /A /D /C Set /P "=%%# %%#" <Nul >`.1
Copy /Y `.1 /B + `.1 /B + `.1 /B `.3 /B >Nul
Copy /Y `.1 /B + `.1 /B + `.3 /B `.5 /B >Nul
Copy /Y `.1 /B + `.1 /B + `.5 /B `.7 /B >Nul
)
:__Color
Set "Text=%~2"
If Not Defined Text (Set Text=^")
SetLocal EnableDelayedExpansion
For %%_ In ("&" "|" ">" "<"
) Do Set "Text=!Text:%%~_=^%%~_!"
Set /P "LF=" <` &Set "LF=!LF:~0,1!"
For %%# in ("!LF!") Do For %%_ In (
\ / :) Do Set "Text=!Text:%%_=%%~#%%_%%~#!"
For /F delims^=^ eol^= %%# in ("!Text!") Do (
If #==#! EndLocal
If \==%%# (Findstr /A:%~1 . \` Nul
Type `.3) Else If /==%%# (Findstr /A:%~1 . /.\` Nul
Type `.5) Else (Cmd /A /D /C Echo %%#\..\`>`.dat
Findstr /F:`.dat /A:%~1 .
Type `.7))
If "\n"=="%~3" (Shift
Echo()
Shift
Shift
If ""=="%~1" Del ` `.1 `.3 `.5 `.7 `.dat &Goto :Eof
Goto :__Color