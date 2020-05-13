<?php
$putanja = "../";
$stranica = "Multimedija";
$ref_page_var = "multimedija.php";
$page_name_var = "Multimedija";
require_once "../templates_c/head.php";
require_once "../templates_c/zaglavlje.php";
$smarty->display('../templates_c/common/multimedija.html.tpl');
require_once "../templates_c/podnozje.php";