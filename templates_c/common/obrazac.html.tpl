<form method="POST" action="">
    <div class="container">
        <h1>Obvezan unos</h1>
        <p>Ova polja obvezno morate ispuniti!</p>

        <hr>

        <label for="cv"><b> {({$sPopisa}) ? "Trenutna datoteka: {$cvFile}. Molimo, ponovno učitajte staru ili novu datoteku!": "Priložite svoj CV"}</b></label>
        <input id="cv" type="file" name="cvFile" value="File.txt" style="border: {({$sPopisa}) ? "solid green 2px": " "}">

        <label for="datetime"><b>Datum i vrijeme</b></label>
        <input id="datetime" type="datetime-local" name="datetime" value="1990-12-31T23:59:60">

        <label for="check"><b>Koja vas područja obrade podataka zanimaju?</b></label><br>
        <input type="checkbox" name="checkbox[]" value="Prikupljanje" {({$sPopisa}&&{$prikupljanjeF}) ? "checked": " "}>Prikupljanje
        <input type="checkbox" name="checkbox[]" value="Klasificiranje" {({$sPopisa}&&{$klasificiranjeF}) ? "checked": " "}> Klasificiranje
        <input type="checkbox" name="checkbox[]" value="Obrada" {({$sPopisa}&&{$obradaF}) ? "checked": " "}> Obrada
        <input type="checkbox" name="checkbox[]" value="Analiza i vizualizacija" {({$sPopisa}&&{$anaivF}) ? "checked": " "}> Analiza i vizualizacija
        <input type="checkbox" name="checkbox[]" value="Istraživanje" {({$sPopisa}&&{$istraF}) ? "checked": " "}> Istraživanje
        <input type="checkbox" name="checkbox[]" value="Kreiranje podataka" {({$sPopisa}&&{$krepodF}) ? "checked": " "}> Kreiranje podataka

        <hr>
    </div>

    <div class="container">
        <h1>Dodatni podaci</h1>
        <p>Ispunite dodatne podatke.</p>
        <hr>

        <label for="url"><b>Pošaljite nam poveznicu na vaš portfolio</b></label>
        <input id="url" type="text" placeholder="Unesite URL" name="url" value="{({$sPopisa}) ? {$poveznica}: " "}">

        <label for="technologies"><b>Tehnologije</b></label>
        <select id="technologies" multiple="multiple" size="5" name="technologies[]">
            <option style="font-size: 1.3em; font-weight: bold;">Odaberite tehnologije
                koje koristite
                (možete odabrati više)
            </option>
            <option {({$sPopisa}&&{$pyF}) ? "selected": " "}>Python</option>
            <option {({$sPopisa}&&{$ipynbF}) ? "selected": " "}>Jupyter Notebook</option>
            <option {({$sPopisa}&&{$kafkaF}) ? "selected": " "}>Kafka</option>
            <option {({$sPopisa}&&{$djangoF}) ? "selected": " "}>Django</option>
            <option {({$sPopisa}&&{$spssF}) ? "selected": " "}>SPSS</option>
        </select><br>

        <label for="color"><b>Odaberite najdražu boju</b></label>
        <input id="color" type="color" name="color" value="{({$sPopisa}) ? {$boja}: " "}"><br>

        <label for="telephone"><b>Telefon</b></label>
        <input id="telephone" type="tel" name="telephone"
               placeholder="+123456789012 ili 00123456789012" value="{({$sPopisa}) ? {$telefon}: " "}">

        <p><b>Spol</b></p>
        <input type="radio" id="male" name="gender" value="muški" {({$sPopisa&&$spol==='muški'}) ? "checked": " "}>
        <label for="male">Muški</label><br>
        <input type="radio" id="female" name="gender" value="ženski" {({$sPopisa&&$spol==='ženski'}) ? "checked": " "}>
        <label for="female">Ženski</label><br>
        <input type="radio" id="other" name="gender" value="ostalo" {({$sPopisa&&$spol==='ostalo'}) ? "checked": " "}>
        <label for="other">Ostalo</label> <br>

        <label for="quantity"><b>Odaberite broj</b></label>
        <input type="number" id="quantity" name="quantity" value="{({$sPopisa}) ? {$broj}: " "}"> <br>

        {if isset({$greska})}
            <p class='ispis-greske'
            ">{$greska}</p>
        {/if}
        {if isset({$poruka})}
            <p class='ispis-poruke'
            ">{$poruka}</p>
        {/if}
        <hr>
        <input type="submit" class="btn" name="submit"></input>

    </div>
</form>