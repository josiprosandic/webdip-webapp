<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP test</title>
</head>
<body>

<?php
echo '<h2 class="\'text"\'>PHP</h2>';
// echo  phpinfo();

// Numerička polja
$polje = array();
$polje[] = "Josip"; // indeks 0
$polje[] = "Ana";  // indeks 1
$polje[] = "Lorena"; // indeks 2
//echo $polje[0];

var_dump($polje);
print_r($polje);

// Asocijativna polja
$polje2 = array("ime" => "Matija", "prezime" => "Kaniski");
echo $polje[0] . " " . $polje2["prezime"] . '<br>';
echo sizeof($polje) . '<br>';
echo 'Broj znakova prvog elementa je: ' . "" . strlen($polje[0]) . '<br>';

/*Funkcija za ispis polja
 * @param Array polje
 * */

$tekst = 'Ovo je tekst';
function IspisPolja($polje)
{
    global $tekst;
    if (isset($tekst)) {
        echo '<h2>' . $tekst . '</h2>';
    }
    if (!empty($polje)) {
        foreach ($polje as $key => $value) {
            echo "k:$key => v:$value<br>";
        }
    }
}

IspisPolja($polje);

//var_dump($_SERVER);

// Dohvat putanje do direktorija web aplikacije
$putanja = dirname($_SERVER["REQUEST_URI"]);
echo $putanja . '<br>';
// -----------------------------------------------------------------------------
// Rad s datumima i datotekama

echo "Danas je" . " " . date("d.m.yy") . '<br>';

// Dodaj zapis u .log
function DodajZapis()
{
    global $direktorij;
    $zapisiRef = $_SERVER["HTTP_CONNECTION"];
    $sada = date("d.m.Y H:i:s");
    $fp = fopen("test.log", "a+");
    fwrite($fp, $sada);
    fwrite($fp, ", ");
    fwrite($fp, $zapisiRef);
    fwrite($fp, "\n");
    fclose($fp);
}

echo "<p>Zapisi:</p>";
$ascPolje = VratiAscPolje("test.log");

DodajZapis();
// Vrati zapis iz .log
function VratiAscPolje($naziv)
{
    $fn = fopen($naziv, "r");
    $rezultat = fread($fn, filesize($naziv));
    fclose($fn);

    $polje = explode("\n", $rezultat);

}

?>

</body>
</html>