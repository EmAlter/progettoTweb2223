<!DOCTYPE html>
<html>

<!-- 
    info.txt contiene: nome del film, data e voto percentuale
    overview.png è l'immagine usata come locandina
    overview.txt contiene diverse informazioni riguardo al film
    review*.txt contiene: recensione, valutazione FRESH o ROTTEN, nome del recensore e pubblicazione
    (Ho inserito una nuova cartella chiamata "interstellar")
-->

<header>
    <link href="movie.css" type="text/css" rel="stylesheet">
</header>

<body>
    <div class="bannerpg">
        <div class="banner">
            <img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/banner.png" alt="Rancid Tomatoes">
        </div>
    </div>
    <?php
    /*
    La variabile $movie contiene il nome del film preso da un paramentro inserito nell'URL del browser 
    attraverso la funzione $_GET[]*/
    $movie = $_GET["film"];
    /*
    Salvo ogni riga del documento info.txt dentro la variabile $title 
    con l'utilizzo della funzione file()
    */
    $title = file($movie . "/info.txt");
    ?>
    <!--
        $title[0] contiene il nome del film
        $title[1] contiene la data di pubblicazione
    -->
    <h1><?= $title[0] . "(" . $title[1] . ")" ?></h1>

    <div class="areatesto">
        <div class="overview">
            <img src="<?= $movie . "/overview.png" ?>" alt="general overview">
            <dl>
                <?php
                /*
                Salvo ogni riga del documento overview.txt dentro la variabile $overview
                */
                $overview = file($movie . "/overview.txt");
                /*
                Divido ogni valore di $overview (quindi ogni riga del file overview.txt) in due parti che inserirò nella variabile $categorie
                La divisione viene fatta attraverso la funzione explode(), utilizzando ":" come delimitatore
                */
                foreach ($overview as $value) {
                    $categorie = explode(":", $value);

                ?>
                    <!--
                    $categorie[0] contiene il testo della riga fino a ":"
                    $categorei[1] contiene il testo della riga da ":" in poi
                -->
                    <dt><?= $categorie[0] ?></dt>
                    <dd><?= $categorie[1] ?> <br></dd>
                <?php } ?>
            </dl>


        </div>
        <div class="reviewsandrotten">
            <div class="rotten">
                <?php
                /*
                $title[2] contiene il voto percentuale del film
                Verifico con if/else se il valore è maggiore di 60 e salvo:
                    -freshbig.png in $voto, nel caso positivo
                    -rottenbig.png in $voto, nel caso negativo
                */
                if ($title[2] >= 60) {
                    $voto = "https://courses.cs.washington.edu/courses/cse190m/11sp/homework/2/freshbig.png";
                } else {
                    $voto = "https://courses.cs.washington.edu/courses/cse190m/11sp/homework/2/rottenbig.png";
                }
                ?>
                <!--
                    $voto contiene il link all'immagine da mostrare affianco al voto percentuale
                -->
                <img src="<?= $voto ?>" alt="Rotten">
                <span><?= $title[2] . "%" ?></span>
            </div>

            <?php
            /*
            $valutazionipercorso è un array che contiene il percorso di tutti i file nella cartella del film che hanno nome review*.txt
            tutto questo viene fatto grazie all funzione glob() indicando il percorso nel quale cercare
            $nVal indica la lunghezza dell'array $valutazionipercorso
            Viene poi diviso in due parti il numero di recensioni con la funzione array_slice():
                -$parteSX contiene le prime recensioni da 0 alla metà di $nVal --> la funzione ceil() è utilizzata per arrotondare per ecceso in caso $nVal sia dispari
                -$parteDX contiene le recensioni dalla metà fino in fondo la lunghezza di $valutazionipercorso
            */
            $valutazionipercorso = glob($movie . "/review*.txt");
            $nVal = count($valutazionipercorso);
            $parteSX = array_slice($valutazionipercorso, 0, ceil($nVal / 2));
            $parteDX = array_slice($valutazionipercorso, ceil($nVal / 2), $nVal);

            /*
            La funzione verify($param) ritorna l'URL della .gif di ogni recensione
            viene letto dal file review*.txt la riga che indica se la recensione è "FRESH" o "ROTTEN"
            */
            function verify($param)
            {
                if ($param == "FRESH") {
                    return "https://courses.cs.washington.edu/courses/cse190m/11sp/homework/2/fresh.gif";
                } else {
                    return "https://courses.cs.washington.edu/courses/cse190m/11sp/homework/2/rotten.gif";
                }
            }
            ?>

            <div class="columnL">
                <?php
                /*
                Il foreach mi permette di creare un div per ogni recensione e un div per ogni recensore
                in questo caso mi sto occupando solo delle recensioni della colonna di sinistra, cioè la prima metà delle recensioni
                */
                foreach ($parteSX as $value) {
                    $valSX = file($value, FILE_IGNORE_NEW_LINES);
                ?>

                    <div id="review">
                        <!--
                            $valSX[1] contiene la stringa "FRESH" o "ROTTEN"
                            $valSX[0] contiene il testo della recensione
                        -->
                        <img src="<?= verify($valSX[1]) ?>" alt="<?= $valSX ?>">
                        <p>

                            <q><?= $valSX[0] ?></q>
                        </p>
                    </div>


                    <div id="reviewer">
                        <!--
                            $valSX[2] contiene il nome del recensore
                            $valSX[3] contiene la pubblicazione
                        -->
                        <p>
                            <img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/critic.gif" alt="Critic">
                            <?= $valSX[2] ?> <br>
                            <?= $valSX[3] ?>
                        </p>
                    </div>
                <?php  } ?>
            </div>

            <div class="columnR">

                <?php
                /*
                Il foreach mi permette di creare un div per ogni recensione e un div per ogni recensore
                in questo caso mi sto occupando solo delle recensioni della colonna di destra, cioè la seconda metà delle recensioni
                */
                foreach ($parteDX as $value) {
                    $valDX = file($value, FILE_IGNORE_NEW_LINES);
                ?>

                    <div id="review">
                        <!--
                            $valSX[1] contiene la stringa "FRESH" o "ROTTEN"
                            $valSX[0] contiene il testo della recensione
                        -->
                        <img src="<?= verify($valDX[1]) ?>" alt="<?= $valDX ?>">
                        <p>

                            <q><?= $valDX[0] ?></q>
                        </p>
                    </div>
                    <div id="reviewer">
                        <!--
                            $valSX[2] contiene il nome del recensore
                            $valSX[3] contiene la pubblicazione
                        -->
                        <p>
                            <img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/critic.gif" alt="Critic">
                            <?= $valDX[2] ?> <br>
                            <?= $valDX[3] ?>
                        </p>
                    </div>


                <?php  } ?>
            </div>

        </div>
        <div class="pagina">
            <!--
                $nVal contiene il numero di recensioni
            -->
            <p>(1-<?= $nVal ?>) of <?= $nVal ?></p>
        </div>
    </div>

    <div class="check">
        <p>
            <a href="http://validator.w3.org/check/referer"><img width="88" src="https://upload.wikimedia.org/wikipedia/commons/b/bb/W3C_HTML5_certified.png" alt="Valid HTML5!"></a>
        <p> <br>
            <a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!"></a>
    </div>


</body>

</html>