<?php

if (isset($_POST['btnOdjava'])){
    Sesija::obrisiSesiju();
    header("Location: http://barka.foi.hr/WebDiP/2019/zadaca_04/jrosandic/index.php");
}

$smarty->assign("putanja",$putanja);
$smarty->assign("ref_page",$ref_page_var);
$smarty->assign("page_name",$page_name_var);
$smarty->display($putanja."templates_c/common/zaglavlje.html.tpl");


