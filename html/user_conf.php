<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

session_cache_expire(60);
session_start();
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit; }
include('init.php');

// initialize models
$lc_model = new LcModel($dbutil);
$user_model = new UserModel($dbutil);

// initialize controllers
$lc = new LcController($lc_model, $user_model);
$controller = new UserController($user_model, $lc);

$page_title = "Apedog: User Configuration";
$page_help = "
<h3>$page_title</h3>
<p>you can add, modify, remove Users or LCs</p>
<p>Each User belongs to one LC</p>
";

include('components/basic_form.php');

?>

