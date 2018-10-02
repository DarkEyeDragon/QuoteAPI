<?php
/**
 * Created by PhpStorm.
 * User: Joshua
 * Date: 10/1/2018
 * Time: 10:01 PM
 */
session_start();
session_destroy();
header("Location: login.php");