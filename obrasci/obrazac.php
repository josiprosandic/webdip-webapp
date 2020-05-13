<?php
$putanja = "../";
$stranica = "Obrazac";
$ref_page_var = "obrazac.php";
$page_name_var = "Obrazac";
require_once "../templates_c/head.php";
require_once "../templates_c/zaglavlje.php";
require_once "../baza.class.php";

// Zabilježeni URL trenutne stranice
$protokol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$dohvacenURL = $protokol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$URLZaProvjeru = "http://barka.foi.hr/WebDiP/2019/zadaca_04/jrosandic/obrasci/obrazac.php";

//----------------------------------------------------------------------------------------------------------------------
//--------------------------------AŽURIRANJE AKO JE KLIKNUT GUMB--------------------------------------------------------
// Selekcija koja se odnosi na akcije ovisno o
// tomu s koje stranice se došlo na obrazac
if ($dohvacenURL === $URLZaProvjeru) {
    echo "Dodavanje novog zapisa!";
    $sPopisa = false;
} else {
    $sPopisa = true;
    echo "Ažuriranje postojećeg zapisa!";
    Baza::connect();

    $idZaDohvatIzBaze = substr($dohvacenURL, 75);
    //echo $idZaDohvatIzBaze;

    // SQL upit
    $sql = "SELECT idObrazacZaUnos, StazaDoDatoteke, DatumIVrijeme, PodrucjaObrade, Poveznica, Tehnologije, Boja, Telefon, Spol, Broj FROM `DZ4_ObrazacZaUnos` WHERE idObrazacZaUnos = '$idZaDohvatIzBaze'";

    // Pohrana rezultata upita
    $result = Baza::select($sql);

    $dohvacenoPolje = mysqli_fetch_array($result);

    // Pridruživanje varijabli Smartyju
    // ------------------------------------------------------------------
    $smarty->assign("cvFile", $dohvacenoPolje[1]);
    $smarty->assign("datumVrijeme", $dohvacenoPolje[2]);

    // ********************************Provjera checkboxa*************************************
    if (strpos($dohvacenoPolje[3], 'Prikupljanje') !== false) {
        $prikupljanjeFlag = true;
    } else {
        $prikupljanjeFlag = false;
    }
    if (strpos($dohvacenoPolje[3], 'Klasificiranje') !== false) {
        $klasificiranjeFlag = true;
    } else {
        $klasificiranjeFlag = false;
    }
    if (strpos($dohvacenoPolje[3], 'Obrada') !== false) {
        $obradaFlag = true;
    } else {
        $obradaFlag = false;
    }
    if (strpos($dohvacenoPolje[3], 'Analiza i vizualizacija') !== false) {
        $anaivFlag = true;
    } else {
        $anaivFlag = false;
    }
    if (strpos($dohvacenoPolje[3], 'Istraživanje') !== false) {
        $istraFlag = true;
    } else {
        $istraFlag = false;
    }
    if (strpos($dohvacenoPolje[3], 'Kreiranje podataka') !== false) {
        $krepodFlag = true;
    } else {
        $krepodFlag = false;
    }
    $smarty->assign("prikupljanjeF", $prikupljanjeFlag);
    $smarty->assign("klasificiranjeF", $klasificiranjeFlag);
    $smarty->assign("obradaF", $obradaFlag);
    $smarty->assign("anaivF", $anaivFlag);
    $smarty->assign("istraF", $istraFlag);
    $smarty->assign("krepodF", $krepodFlag);
    // *******************************Kraj provjere checkboxa**********************************

    $smarty->assign("poveznica", $dohvacenoPolje[4]);

    // ***********************Provjera dropdowna tehnologije*****************************
    if (strpos($dohvacenoPolje[5], 'Python') !== false) {
        $pyFlag = true;
    } else {
        $pyFlag = false;
    }
    if (strpos($dohvacenoPolje[5], 'Jupyter Notebook') !== false) {
        $ipynbFlag = true;
    } else {
        $ipynbFlag = false;
    }
    if (strpos($dohvacenoPolje[5], 'Kafka') !== false) {
        $kafkaFlag = true;
    } else {
        $kafkaFlag = false;
    }
    if (strpos($dohvacenoPolje[5], 'Django') !== false) {
        $djangoFlag = true;
    } else {
        $djangoFlag = false;
    }
    if (strpos($dohvacenoPolje[5], 'SPSS') !== false) {
        $spssFlag = true;
    } else {
        $spssFlag = false;
    }

    $smarty->assign("pyF", $pyFlag);
    $smarty->assign("ipynbF", $ipynbFlag);
    $smarty->assign("kafkaF", $kafkaFlag);
    $smarty->assign("djangoF", $djangoFlag);
    $smarty->assign("spssF", $spssFlag);
    //*********** Kraj provjere tehnologija******************

    $smarty->assign("boja", $dohvacenoPolje[6]);
    $smarty->assign("telefon", $dohvacenoPolje[7]);
    $smarty->assign("spol", $dohvacenoPolje[8]);
    $smarty->assign("broj", $dohvacenoPolje[9]);

    Baza::disconnect();

}

// Varijabla koja definira je li se na stranicu došlo sa stranice popis.php
$smarty->assign("sPopisa", $sPopisa);

//----------------------------------------------------------------------------------------------------------------------
//---------------------------PROVJERA GREŠAKA U OBRASCU (VALIDACIJA NA STRANI POSLUŽITELJA)-----------------------------
$greska = "";
$poruka = "";
$sveBrojke = true;

if (isset($_POST['submit'])) {
    foreach ($_POST as $key => $value) {
        if (empty($value)) {
            // Ako je bilo koji unos prazan
            $greska .= "Nije popunjeno:" . $key . '<br>';
        } else { //Ako su svi unosi popunjeni
            // Ako sadrži više subelemenata (ako je oblika array)
            if (is_array($value)) {
                if (count($value) < 2) {
                    $greska .= "Morate odabrati minimalno dva checkboxa kao i dvije tehnologije!" . "<br>";
                }
            }
            //Provjeri format telefonskog broja
            if ($key === "telephone") {
                if (strlen($value) > 14) {
                    $greska .= "Telefon mora imati maksimalno 14 znakova!" . "<br>";
                }
                if ($value[0] !== "+") {
                    if ($value[0] !== "0") {
                        $greska .= "Prvi znak mora biti plus ili nula!" . "<br>";
                    } elseif ($value[1] !== "0") {
                        $greska .= "Ako je prvi znak nula, drugi također mora biti nula!" . "<br>";
                    }
                }
                for ($i = 1; $i < strlen($value); $i++) {
                    if (is_numeric($value[$i]) === false) {
                        $sveBrojke = false;
                    }
                }
                if ($sveBrojke === false) {
                    $greska .= "Telefon mora sadržavati samo brojeve!" . "<br>";
                }
            }
            // Provjeri format URL-a
            if ($key === "url") {
                $uzorak = "/^(http:\/\/|https:\/\/|www\.)(\w+\.)?(\w+\.)?([-\w]+)(\.hr|\.org|\.com){1}$/";
                if (!preg_match($uzorak, $value)) {
                    $greska .= "URL adresa nije ispravnog formata!" . "<br>";
                }
            }
        }
    }

    // Ako nema zabilježenih grešaka
    if (empty($greska)) {
        // Poruka o tome da nema greške
        $poruka = "Nema greške!" . "<br>";

        // Dohvat vrijednosti svih polja

        //Dohvat naziva datoteke
        $StazaDatoteke = $_POST['cvFile'];

        // Dohvat datuma i vremena
        $DatumVrijeme = $_POST['datetime'];

        // Dohvat vrijednosti checkboxova područja
        $podrucjaString = "";
        $podrucja = $_POST['checkbox'];
        foreach ($podrucja as $podrucje) {
            $podrucjaString .= $podrucje . ";";
        }

        // Dohvat poveznice
        $poveznica = $_POST['url'];

        // Dohvat tehnologija (array())
        $tehnologijeString = "";
        $tehnologije = $_POST['technologies'];
        foreach ($tehnologije as $tehnologija) {
            $tehnologijeString .= $tehnologija . ";";
        }

        // Dohvat boje
        $boja = $_POST['color'];

        // Dohvat telefona
        $telefon = $_POST['telephone'];

        // Dohvat spola
        $spol = $_POST['gender'];

        // Dohvat broja
        $broj = $_POST['quantity'];

        // Spajanje na bazu
        Baza::connect();

        // SQL upit
        if ($sPopisa === true) {
            echo "S POPISA JE TRUE";
            $sql = "UPDATE DZ4_ObrazacZaUnos SET StazaDoDatoteke = '$StazaDatoteke' , PodrucjaObrade = '$podrucjaString' , Poveznica = '$poveznica' , Tehnologije = '$tehnologijeString' ,Boja = '$boja' ,Telefon = '$telefon' ,Spol = '$spol' , Broj = '$broj' WHERE idObrazacZaUnos = '$idZaDohvatIzBaze'";
            header('Location: http://barka.foi.hr/WebDiP/2019/zadaca_04/jrosandic/ostalo/popis.php');
        } else {
            echo "S POPISA JE FALSE";
            $sql = "INSERT INTO DZ4_ObrazacZaUnos(idObrazacZaUnos, StazaDoDatoteke, DatumIVrijeme,PodrucjaObrade,Poveznica,Tehnologije,Boja,Telefon,Spol,Broj) 
                VALUES (default,'$StazaDatoteke','$DatumVrijeme','$podrucjaString','$poveznica','$tehnologijeString','$boja','$telefon','$spol','$broj')";
        }

        // Unos u bazu
        if (Baza::query($sql) === true) {
            $poruka .= "Uspješan unos u bazu!" . "<br>";
        } else {
            $greska .= "Neuspješan unos u bazu!" . "<br>";
        };

        // Raskid veze s bazom
        Baza::disconnect();
    }
}
$smarty->assign("greska", $greska);
$smarty->assign("poruka", $poruka);
//$smarty->assign("greska",htmlspecialchars($greska,ENT_COMPAT,'UTF-8'));

//----------------------------------------------------------------------------------------------------------------------
$smarty->display('../templates_c/common/obrazac.html.tpl');
require_once "../templates_c/podnozje.php";
