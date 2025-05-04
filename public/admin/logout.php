<?php
session_start();
session_destroy();
header('Location: /digita-marketing/connexion');
exit;
