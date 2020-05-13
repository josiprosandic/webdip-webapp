<?php
$putanja = "./";
$stranica = "Početna";
$ref_page_var = "index.php";
$page_name_var = "Index";
require_once "templates_c/head.php";
require_once "templates_c/zaglavlje.php";
$smarty->display('templates_c/common/index.html.tpl');
require_once "templates_c/podnozje.php";
