<?php
$putanja = "../";
$stranica = "Registracija";
$ref_page_var = "registracija.php";
$page_name_var = "Registracija";
require_once "../baza.class.php";
//-------------------------------------------------------------------

// Prihvat AJAX zahtjeva, dohvat iz baze i formiranje XML ili JSON objekta te slanje natrag
if (isset($_POST['ajax'])) {
    if (isset($_POST['korime'])) {
        $podatak = $_POST['korime'];
        Baza::connect();
        header('Content-Type: text/xml');
        $sql = "SELECT idKorisnik, Ime, Prezime, KorisnickoIme, GodinaRodenja, Email, Lozinka FROM DZ4_KorisnickiPodaci WHERE KorisnickoIme = '$podatak'";
        $result = Baza::select($sql);
        while (list($id, $ime, $prezime, $korisnickoIme, $godinaRodenja, $email, $lozinka) = mysqli_fetch_array($result)) {
            echo "
            <korisnik>
                <id>$id</id>
                <ime>$ime</ime>
                <prezime>$prezime</prezime>
                <korisnickoIme>$korisnickoIme</korisnickoIme>
                <godinaRodenja>$godinaRodenja</godinaRodenja>
                <email>$email</email>
                <lozinka>$lozinka</lozinka>
            </korisnik>";
        }
        Baza::disconnect();
    } else if (isset($_POST['email'])) {
        $podatak = $_POST['email'];
        header('Content-Type: application/json');
        Baza::connect();
        $sql = "SELECT idKorisnik, Ime, Prezime, KorisnickoIme, GodinaRodenja, Email, Lozinka FROM DZ4_KorisnickiPodaci WHERE Email = '$podatak'";
        $result = Baza::select($sql);
        while (list($id, $ime, $prezime, $korisnickoIme, $godinaRodenja, $email, $lozinka) = mysqli_fetch_array($result)) {
            $data = [
                'id' => $id,
                'ime' => $ime,
                'prezime' => $prezime,
                'korisnickoIme' => $korisnickoIme,
                'godinaRodenja' => $godinaRodenja,
                'email' => $email,
                'lozinka' => $lozinka
            ];
            echo json_encode($data);
        }
        Baza::disconnect();
    } else {
        echo "Invalid request";
        http_response_code(404);
    }
    exit;
}

// Dodatna provjera postojanja korisničkog imena i emaila prilikom klika na "Submit"
// Validacija novoga unosa u bazu i novi unos u bazu (INSERT INTO)
$korimeGreska = "";
$emailGreska = "";
$greskePriUnosu = "";
$porukaOUspjehu = "";
if (isset($_POST['btnSubmitReg'])) {

    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $korisnickoIme = $_POST['korime'];
    $email = $_POST['email'];
    $lozinka = $_POST['lozinka'];
    $godina = $_POST['godina'];
    $sol = 'a1b2c3d4e5f6';
    $SHA1lozinka = sha1($lozinka . $sol);

    Baza::connect();
    $sql = "SELECT KorisnickoIme FROM DZ4_KorisnickiPodaci WHERE KorisnickoIme = '$korisnickoIme'";
    $result = Baza::select($sql);

    if ($result != null) {
        $korimeGreska .= "Korisničko ime već postoji!" . "<br>";
    }

    $sql = "SELECT Email FROM DZ4_KorisnickiPodaci WHERE Email = '$email'";
    $result = Baza::select($sql);

    if ($result != null) {
        $emailGreska .= "Email već postoji!" . "<br>";
    }

    if ($ime == "") {
        $greskePriUnosu .= "Polje ime mora biti popunjeno!" . "<br>";
    }
    if ($prezime == "") {
        $greskePriUnosu .= "Polje prezime mora biti popunjeno!" . "<br>";
    }
    if ($korisnickoIme == "") {
        $greskePriUnosu .= "Polje ime mora biti popunjeno!" . "<br>";
    }
    if ($email == "") {
        $greskePriUnosu .= "Polje email mora biti popunjeno!" . "<br>";
    }
    if ($lozinka == "") {
        $greskePriUnosu .= "Polje lozinka mora biti popunjeno!" . "<br>";
    }
    if ($godina == "") {
        $greskePriUnosu .= "Polje godina mora biti popunjeno!" . "<br>";
    }

    if ($korimeGreska == "" && $emailGreska == "" && $greskePriUnosu == "") {

        $sql = "INSERT INTO DZ4_KorisnickiPodaci (Uloga, Ime, Prezime, KorisnickoIme, GodinaRodenja, Email, Lozinka, LozinkaSHA1) 
                VALUES (3,'$ime', '$prezime', '$korisnickoIme', '$godina', '$email', '$lozinka', '$SHA1lozinka')";
        $result = Baza::query($sql);
        if ($result) {
            $porukaOUspjehu .= "Uspješno ste registrirani!" . "<br>";
        }
    }

    Baza::disconnect();
}

// Dohvat podataka za ažuriranje korisnika (AJAX zahtjev)
if (isset($_POST['ajaxUpdate'])) {

    if (isset($_POST['emailUpdate']) && isset($_POST['korimeUpdate'])) {

        $emailPodatak = $_POST['emailUpdate'];
        $korisnickoImePodatak = $_POST['korimeUpdate'];

        header('Content-Type: application/json');
        Baza::connect();
        $sql = "SELECT idKorisnik, Ime, Prezime, KorisnickoIme, GodinaRodenja, Email, Lozinka FROM DZ4_KorisnickiPodaci WHERE Email = '$emailPodatak' AND KorisnickoIme = '$korisnickoImePodatak'";
        $result = Baza::select($sql);
        while (list($id, $ime, $prezime, $korisnickoIme, $godinaRodenja, $email, $lozinka) = mysqli_fetch_array($result)) {
            $data = [
                'id' => $id,
                'ime' => $ime,
                'prezime' => $prezime,
                'korisnickoIme' => $korisnickoIme,
                'godinaRodenja' => $godinaRodenja,
                'email' => $email,
                'lozinka' => $lozinka
            ];
            echo json_encode($data);
        }
        Baza::disconnect();
    } else {
        echo "Invalid request";
        http_response_code(404);
    }
    exit;
}

// Pohrana izmijenjenih podataka u bazu (UPDATE TABLE)
if (isset($_POST['btnSubmitUpdate'])) {

    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $korisnickoIme = $_POST['korime'];
    $email = $_POST['email'];
    $lozinka = $_POST['lozinka'];
    $godina = $_POST['godina'];
    $sol = 'a1b2c3d4e5f6';
    $SHA1lozinka = sha1($lozinka . $sol);

    Baza::connect();
    $sql = "UPDATE DZ4_KorisnickiPodaci  SET Ime = '$ime', Prezime = '$prezime', Lozinka = '$lozinka', LozinkaSHA1 = '$SHA1lozinka' WHERE KorisnickoIme = '$korisnickoIme' AND Email = '$email'";
    $result = Baza::query($sql);
    if ($result) {
        $porukaOUspjehu .= "Uspješno ažuriranje podataka!" . "<br>";
    }
    Baza::disconnect();
}

//----------------------------------------------------------------------
require_once "../templates_c/head.php";
require_once "../templates_c/zaglavlje.php";
$smarty->assign("greskePraznine", $greskePriUnosu);
$smarty->assign("porukaOUspjehu", $porukaOUspjehu);
$smarty->assign("korimeGreska", $korimeGreska);
$smarty->assign("emailGreska", $emailGreska);
$smarty->display('../templates_c/common/registracija.html.tpl');
require_once "../templates_c/podnozje.php";
