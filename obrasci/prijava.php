<?php
$putanja = "../";
$stranica = "Prijava";
$ref_page_var = "prijava.php";
$page_name_var = "Prijava";
require_once "../baza.class.php";
require_once "../templates_c/head.php";
//---------------------------------------------------------------

$greska = "";
$poruka = "";
$autenticiran = false;
if (isset($_POST['btnPrijava'])){

    if ($_POST['korimePrijava'] == ""){
        $greska .= "Morate unijeti korisničko ime!"."<br>";
    }

    if ($_POST['lozinka'] == ""){
        $greska .= "Morate unijeti lozinku!"."<br>";
    }



    if ($greska == ""){
        $korisnickoIme = $_POST['korimePrijava'];
        $lozinka = $_POST['lozinka'];
        Baza::connect();
        $sql = "SELECT * FROM DZ4_KorisnickiPodaci WHERE KorisnickoIme = '$korisnickoIme' AND Lozinka = '$lozinka'";
        $result = Baza::select($sql);
        $red = mysqli_fetch_array($result);
        $tipKorisnika = $red['Uloga'];

        if (!is_null($result)){
            if ($tipKorisnika != 4){
                $autenticiran = true;
                $poruka = "Uspješna prijava u sustav!"."<br>";
                Sesija::kreirajKorisnika($korisnickoIme,$tipKorisnika);
                header("Location: http://barka.foi.hr/WebDiP/2019/zadaca_04/jrosandic/ostalo/popis.php");
            } else {
                $poruka .= "Morate se registrirati ili prijaviti!"."<br>";
            }

        } else {
            $poruka .= "Neuspjela prijava u sustav"."<br>";
        }
    }
}

//-----------------------------------------------------------------
require_once "../templates_c/zaglavlje.php";
$smarty->assign("autenticiran",$autenticiran);
$smarty->assign("ispisGreske",$greska);
$smarty->assign("porukaOPrijavi",$poruka);
$smarty->display('../templates_c/common/prijava.html.tpl');
require_once "../templates_c/podnozje.php";