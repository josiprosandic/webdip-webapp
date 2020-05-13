<?php
$putanja = "../";
$stranica = "Popis";
$ref_page_var = "popis.php";
$page_name_var = "Popis";
require_once "../templates_c/head.php";
require_once "../templates_c/zaglavlje.php";
require_once "../baza.class.php";
//-----------------------------------------------------------------
//Dohvat podataka obrasca iz baze i prikaz u tablici

// Spajanje na bazu
Baza::connect();

// SQL upit
$sql = "SELECT idObrazacZaUnos, StazaDoDatoteke, DatumIVrijeme, PodrucjaObrade, Poveznica, Tehnologije, Boja, Telefon, Spol, Broj FROM `DZ4_ObrazacZaUnos`";
$tablica = "";
// Pohrana rezultata upita
$result = Baza::select($sql);

while (list($idObrazac, $staza, $datumVrijeme, $podrucjaObrade, $poveznica, $tehnologije, $boja, $telefon, $spol, $broj) = mysqli_fetch_array($result)) {

    $tablica .= "<tr><td>" . $idObrazac . "</td><td>" . $staza . "</td><td>" . $datumVrijeme . "</td><td>" . $podrucjaObrade . "</td><td>" . $poveznica . "</td><td>" . $tehnologije . "</td><td style='background-color:$boja'></td><td>" . $telefon . "</td><td>" . $spol . "</td><td>" . $broj . "</td><td><a href='http://barka.foi.hr/WebDiP/2019/zadaca_04/jrosandic/obrasci/obrazac.php?id=$idObrazac'><button id='btnAzuriraj' type=\"button\">Ažuriraj</button></a></td></tr>";

}

Baza::disconnect();

// Pretraživanje tablice
// --------------------------------------------------------------------
if (isset($_POST['searchButton'])) {
    $valueToSearch = $_POST['search'];
    if (empty($valueToSearch)) {
        header("Refresh:0");
    }
    // search in all table columns
    // using concat mysql function
    $query = "SELECT * FROM `DZ4_ObrazacZaUnos` WHERE CONCAT(`idObrazacZaUnos`, `StazaDoDatoteke`, `DatumIVrijeme`, `PodrucjaObrade`, `Poveznica`, `Tehnologije`,`Boja`,`Telefon`,`Spol`,`Broj`) LIKE '%" . $valueToSearch . "%'";
    $searchResult = filterTable($query);
    $tablica = "";
    while (list($idObrazac, $staza, $datumVrijeme, $podrucjaObrade, $poveznica, $tehnologije, $boja, $telefon, $spol, $broj) = mysqli_fetch_array($searchResult)) {
        $tablica .= "<tr><td>" . $idObrazac . "</td><td>" . $staza . "</td><td>" . $datumVrijeme . "</td><td>" . $podrucjaObrade . "</td><td>" . $poveznica . "</td><td>" . $tehnologije . "</td><td style='background-color:$boja'></td><td>" . $telefon . "</td><td>" . $spol . "</td><td>" . $broj . "</td><td><a href='http://barka.foi.hr/WebDiP/2019/zadaca_04/jrosandic/obrasci/obrazac.php?id=$idObrazac'><button id='btnAzuriraj' type='button'>Ažuriraj</button></a></td></tr>";
    }
    Baza::disconnect();
}
function filterTable($query)
{
    Baza::connect();
    $filter_Result = Baza::select($query);
    return $filter_Result;
}

// ---------------------------------------------------------------------

$smarty->assign("tablica", $tablica);
//----------------------------------------------------------------------
$smarty->display('../templates_c/common/popis.html.tpl');
require_once "../templates_c/podnozje.php";