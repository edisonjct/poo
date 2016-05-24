<?php
session_start();
if(!isset($_SESSION['user_session']))
{header("Location: ../index.php");}
include '../controlador/Login.php';
include '../modelo/Bodegas.php';
