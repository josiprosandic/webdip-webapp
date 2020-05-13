<div class="forma">

    <form method="POST" action="">
        <div class="container">
            <h1>Registrirajte se</h1>
            <p>Sva polja su obvezna!</p>
            <span style="color: #9B410E;font-weight: bolder">{$greskePraznine}</span>
            <span style="color: green;font-size: 20px;font-weight: bold">{$porukaOUspjehu}</span>
            <hr>

            <label for="ime"><b>Ime</b></label>
            <input id="ime" type="text" placeholder="Unesite vaše ime" name="ime">

            <label for="prezime"><b>Prezime</b></label>
            <input id="prezime" type="text" placeholder="Unesite vaše prezime" name="prezime">

            <label for="korime"><b>Korisničko ime</b></label><br>
            <span style="color: red">{$korimeGreska}</span>
            <input id="korime" type="text" placeholder="Unesite vaše korisničko ime" name="korime">

            <label for="datrod"><b>Godina rođenja</b></label><br>
            <span>Odabrana godina:</span><span id="textInputGodina">niste odabrali godinu</span>
            <input id="datrod" type="range" min="1920" max="2020" name="godina">

            <label for="email"><b>E-mail</b></label><br>
            <span style="color: red">{$emailGreska}</span>
            <button type="button" name="btnAzurirajKorisnika" id="btnAzurirajKorisnika" style="visibility: hidden">Omogući ažuriranje</button>
            <input id="email" type="email" placeholder="Unesite Vaš e-mail" name="email">

            <label for="lozinka"><b>Lozinka</b></label>
            <input id="lozinka" type="password" placeholder="Unesite lozinku" name="lozinka">
            <button type="button" id="btnPokaziLozinku">Pokaži lozinku</button>

            <br>

            <label for="ponlozinka"><b>Potvrda lozinke</b></label>
            <input id="ponlozinka" type="password" placeholder="Ponovno unesite lozinku" name="ponlozinka">
            <hr>

            <button type="submit" class="btn" name="btnSubmitReg" id="btnSubmitReg">Pošaljite podatke</button>
        </div>

    </form>

</div>

