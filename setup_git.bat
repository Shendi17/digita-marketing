@echo off
powershell -Command "Write-Host 'Configuration de Git...' -ForegroundColor Cyan"

REM Vérifier si Git est installé dans le chemin par défaut
set GIT_PATH="C:\Program Files\Git\cmd\git.exe"
if not exist %GIT_PATH% (
    powershell -Command "Write-Host '[ERREUR] Git n''est pas installé dans le chemin par défaut' -ForegroundColor Red"
    powershell -Command "Write-Host 'Veuillez installer Git depuis https://git-scm.com/download/win' -ForegroundColor Yellow"
    exit /b 1
)

REM Initialiser Git
%GIT_PATH% init

REM Configurer Git
powershell -Command "Write-Host 'Configuration de vos informations Git...' -ForegroundColor Yellow"
set /p GIT_NAME="Entrez votre nom pour Git: "
set /p GIT_EMAIL="Entrez votre email pour Git: "
%GIT_PATH% config --global user.name "%GIT_NAME%"
%GIT_PATH% config --global user.email "%GIT_EMAIL%"

REM Ajouter les fichiers
%GIT_PATH% add .

REM Premier commit
%GIT_PATH% commit -m "Initial commit"

powershell -Command "Write-Host 'Configuration locale terminée !' -ForegroundColor Green"
powershell -Command "Write-Host 'Pour connecter à GitHub :' -ForegroundColor Yellow"
powershell -Command "Write-Host '1. Créez un nouveau repository sur GitHub' -ForegroundColor Yellow"
powershell -Command "Write-Host '2. Entrez l''URL de votre repository ci-dessous' -ForegroundColor Yellow"
set /p REPO_URL="URL du repository GitHub (ex: https://github.com/username/repo.git): "

REM Ajouter le remote et push
%GIT_PATH% remote add origin %REPO_URL%
%GIT_PATH% branch -M main
%GIT_PATH% push -u origin main

powershell -Command "Write-Host 'Configuration terminée !' -ForegroundColor Cyan"
echo.
pause
