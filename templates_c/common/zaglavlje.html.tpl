<body>

<div class="wrapper">

    <header class="hdr">
        <a href="http://barka.foi.hr/WebDiP/2019/zadaca_04/jrosandic/index.html"><img src="{$putanja}multimedija/code.svg" width="80" height="80" alt="logo"
                                     style="float: left;"></a>
        <h1 style="font-size:3em;color: #333;float:inline-start;margin-left: 5%;margin-bottom: 0px;margin-top: 10px;">
            {$stranica}</h1>

        <div class="search-container">
            <form action="" method="POST">
                <input type="text" placeholder="Unesite pojam" name="search">
                <button type="submit" name="searchButton">Traži</button>
            </form>
        </div>
        <form action="" method="POST">
            <div class="logof">
                <button type="submit" name="btnOdjava">Odjavi se</button>
            </div>
        </form>
    </header>

    <nav class="main-nav">
        <ul>
            <li>
                <a href="{$putanja}index.php">Početna</a>
            </li>

            {if isset($sesija) && ($sesija < 4)}
            <li>
                <a href="{$putanja}ostalo/popis.php">Popis</a>
            </li>
            {/if}
            {if isset($sesija) && ($sesija < 3)}
            <li>
                <a href="{$putanja}ostalo/multimedija.php">Multimedija</a>
            </li>
            {/if}
            {if isset($sesija) && ($sesija == 1)}
            <li>
                <a href="{$putanja}obrasci/obrazac.php">Unos novog sadržaja</a>
            </li>
            {/if}
            {if !isset($sesija)}
            <li>
                <a href="{$putanja}obrasci/registracija.php">Registracija</a>
            </li>
            <li>
                <a href="{$putanja}obrasci/prijava.php">Prijava</a>
            </li>
            {/if}
        </ul>
    </nav>

