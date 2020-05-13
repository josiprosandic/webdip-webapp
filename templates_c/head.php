<?php

require_once($putanja."sesija.class.php");
require_once($putanja."vanjske_biblioteke/Smarty/libs/Smarty.class.php");
Sesija::kreirajSesiju();

$smarty = new Smarty();

if (isset($_SESSION['uloga'])) {
    $smarty->assign("sesija",$_SESSION['uloga']);
}
$smarty->assign("putanja",$putanja);
$smarty->assign("stranica",$stranica);
$smarty->display($putanja."templates_c/common/head.html.tpl");
