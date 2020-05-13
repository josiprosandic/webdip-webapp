$(document).ready(function () {
    console.log("Test javascripta!");
    ValidacijaKorisnickoIme();
    ValidacijaEmaila();
    PokaziLozinku();
    PrikaziRaspon();
})

function PrikaziRaspon() {
    $('#datrod').change(function () {
        $('#textInputGodina').html(this.value);
    })
}

// Funkcija koja prikazuje lozinku
function PokaziLozinku() {

    let vidljiva = false;

    $('#btnPokaziLozinku').click(function () {

        switch (vidljiva) {
            case false:
                $('#lozinka').attr("type", "text");
                vidljiva = true;
                break;
            case true:
                $('#lozinka').attr("type", "password");
                vidljiva = false;
                break;
        }
    })
}

var korisnickoImePostoji = false;
var emailPostoji = false;

function ValidacijaKorisnickoIme() {

    $('#korime').keyup(function () {

        let korisnickoIme = $('#korime').val();

        $.ajax({
            type: 'POST',
            data: {ajax: 1, korime: korisnickoIme},
            dataType: 'XML',
            error: function () {
                console.log("Greška je");
                $('#korime').css("border", "solid 1.5px green");
            },
            success: function (data) {
                $('#korime').css("border", "solid 1.5px red");
                korisnickoImePostoji = true;

                //console.log(data);
            }
        });
    })
}

function ValidacijaEmaila() {

    $('#email').keyup(function () {

        let email = $('#email').val();

        $.ajax({
            type: 'POST',
            data: {ajax: 1, email: email},
            dataType: 'JSON',
            error: function () {
                console.log("Greška je");
                $('#email').css("border", "solid 1.5px green");
            },
            success: function (data) {
                $('#email').css("border", "solid 1.5px red");
                emailPostoji = true;
                Azuriranje();
                //console.log(data);
            }
        });
    })
}

var azuriranjeUTijeku = false;

function Azuriranje() {

    if (korisnickoImePostoji && emailPostoji) {
        $('#btnAzurirajKorisnika').css("visibility", "visible");
    }

    $('#btnAzurirajKorisnika').click(function () {

        let korisnickoIme = $('#korime').val();
        let email = $('#email').val();

        $.ajax({
            type: 'POST',
            data: {ajaxUpdate: 1, korimeUpdate: korisnickoIme, emailUpdate: email},
            dataType: 'JSON',
            error: function () {
                console.log("Greška je");
            },
            success: function (data) {
                //console.log("Povrat podataka uspio");
                //console.log(data.ime);
                $('#ime').val(data.ime).css("border", "solid 1.5px rgba(52,152,219,0.50)");
                $('#prezime').val(data.prezime).css("border", "solid 1.5px rgba(52,152,219,0.50)");
                $('#korime').attr('readonly', true).css("border", "solid 1.5px rgba(52,152,219,0.50)");
                $('#datrod').val(data.datumRodenja);
                $('#email').attr('readonly', true).css("border", "solid 1.5px rgba(52,152,219,0.50)");
                $('#lozinka').val(data.lozinka).css("border", "solid 1.5px rgba(52,152,219,0.50)");
                $('#ponlozinka').val(data.lozinka).css("border", "solid 1.5px rgba(52,152,219,0.50)");
                $('#btnSubmitReg').html("Ažuriraj");
                $("#btnSubmitReg").attr("id", "btnSubmitUpdate");
                $("#btnSubmitUpdate").attr("name", "btnSubmitUpdate");
            }
        });
    })
}

