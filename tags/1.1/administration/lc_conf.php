<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

session_cache_expire(60);
session_start();
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit; }
include('init.php');

$model = new LcModel($dbutil);
$user_model = new UserModel($dbutil);
$controller = new LcController($model, $user_model);


$page_title = "Apedog: LC Configuration";
$page_help = "
<h3>$page_title</h3>
<p>you can add, modify, remove Users or LCs</p>
<p>Each User belongs to one LC</p>
";
include('components/basic_form.php');

?>
