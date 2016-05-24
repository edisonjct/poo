<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
unset($_SESSION['user_session']);

if (session_destroy()) {
    header("Location: ../index.php");
}

