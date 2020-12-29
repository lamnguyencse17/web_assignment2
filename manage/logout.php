<?php
session_start();
unset($_SESSION["account_id"]);
header('Refresh: 2; URL = ../index.php');
