<div class="forma">

    <form method="POST" action="">
        <div class="container">
            <h1>Prijavite se</h1>
            <p>Unesite svoje podatke za prijavu.</p>
            <hr>
            <span style="color: #C0392B;font-weight: bold">{$ispisGreske}</span>
            <span style="color: {({$autenticiran}) ? "green": "#C0392B"};font-weight: bold">{$porukaOPrijavi}</span>

            <label for="korime"><b>Korisničko ime</b></label>
            <input id="korimePrijava" type="text" placeholder="Unesite vaše korisničko ime" maxlength="15" name="korimePrijava">

            <label for="loz"><b>Lozinka</b></label>
            <input id="loz" type="password" placeholder="Unesite lozinku" name="lozinka">

            <hr>

            <button type="submit" class="btn" name="btnPrijava">Pošaljite podatke</button>
            <button type="reset" class="btn">Inicijalizirajte unos</button>
        </div>

    </form>

</div>