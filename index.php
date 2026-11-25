<?php
// INIZIALIZZAZIONE VARIABILI
$quaderno = "";
$penna = "";
$zaino = "";
$codiceSconto = "";
$prezzo = "";
$subtotale = "";
$totale = "";
$extra = array();
$carrelloVuoto = true;

$erroreQuaderno = "";
$errorePenna = "";
$erroreZaino = "";
$erroreCodiceSconto = "";
$erroreCarrelloVuoto = "";

$subtotaleIniziale = 0;
$subtotale = 0;
$prezzoQuaderno = 2.5;
$prezzoPenna = 1.2;
$prezzoZaino = 35;
$spesaQuaderno = 0;
$spesaPenna = 0;
$spesaZaino = 0;
$totale = 0;
$esito = "";


// CONTROLLO DELL'INVIO
if($_SERVER["REQUEST_METHOD"] == "POST"){
  
  // RECUPERO DATI
  $quaderno = isset($_POST["quaderno"]) ? trim($_POST["quaderno"]) : "";
  $penna = isset($_POST["penna"]) ? trim($_POST["penna"]) : "";
  $zaino = isset($_POST["zaino"]) ? trim($_POST["zaino"]) : "";
  $extra = isset($_POST["extra"]) ? $_POST["extra"] : array();    // checkbox
  $codiceSconto = isset($_POST["codiceSconto"]) ? trim($_POST["codiceSconto"]) : "";


  // CONTROLLI
  if($quaderno == "") $erroreQuaderno = "Inserisci il numero di quaderni";
  elseif(!is_numeric($quaderno)) $erroreQuaderno = "Il numero di quaderni deve essere numerico";
  elseif($quaderno != intval($quaderno)) $erroreQuaderno = "Il numero di quaderni deve essere intero";
  elseif($quaderno < 0) $erroreQuaderno = "La quantità non può essere negativa";

  if($penna == "") $errorePenna = "Inserisci il numero di penne";
  elseif(!is_numeric($penna)) $errorePenna = "Il numero di penne deve essere numerico";
  elseif($penna != intval($penna)) $errorePenna = "Il numero di penne deve essere intero";
  elseif($penna < 0) $errorePenna = "La quantità non può essere negativa";

  if($zaino == "") $erroreZaino = "Inserisci il numero di zaini";
  elseif(!is_numeric($zaino)) $erroreZaino = "Il numero di zaini deve essere numerico";
  elseif($zaino != intval($zaino)) $erroreZaino = "Il numero di zaini deve essere intero";
  elseif($zaino < 0) $erroreZaino = "La quantità non può essere negativa";

  // CONTROLLO QUANTITA' COMPLESSIVE
  if($quaderno == "0" && $penna == "0" && $zaino == "0") $erroreCarrelloVuoto = "Il carrello è vuoto";


  // CONTROLLO COMPLESSIVO
  if($erroreQuaderno == "" && $errorePenna == "" && $erroreZaino == "" && $erroreCarrelloVuoto == ""){
    
    $esito = "OK";


    // CALCOLO QUADERNO
    if($quaderno > 0){
      $spesaQuaderno = $quaderno * $prezzoQuaderno;
    }

    // CALCOLO PENNA
    if($penna > 0){
      $spesaPenna = $penna * $prezzoPenna;
    }

    // CALCOLO ZAINO
    if($zaino > 0){
      $spesaZaino = $zaino * $prezzoZaino;
    }


    // SUBTOTALE
    $subtotaleIniziale = $spesaQuaderno + $spesaPenna + $spesaZaino;
    $subtotale = $subtotaleIniziale;


    // CODICE SCONTO
    if($codiceSconto != ""){
      if($codiceSconto == "KTM50"){
        $subtotale = $subtotale / 2;
      }
      elseif($codiceSconto == "KTSM80"){
        $subtotale = $subtotale * 0.8;
      }
      else {
        $erroreCodiceSconto = "Codice sconto non valido";
      }
}

    
    // EXTRA
    if(in_array("regalo", $extra)) $subtotale = $subtotale + 3;
    if(in_array("express", $extra)) $subtotale = $subtotale + 7;

    
    // TOTALE
    $totale = $subtotale;
    
  }
  else $esito = "KO";
}

?>


<?php
if($esito == "OK"){
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  </head>
  <body>
    <h1>RISULTATO</h1>
    <br>
    <p>Quaderni: <?php echo htmlspecialchars($quaderno); ?></p>
    <br>
    <p>Prezzo: <?php echo $prezzoQuaderno; ?></p>
    <br>
    <br>
    <p>Penne: <?php echo htmlspecialchars($penna); ?></p>
    <br>
    <p>Prezzo: <?php echo $prezzoPenna; ?></p>
    <br>
    <br>
    <p>Zaini: <?php echo htmlspecialchars($zaino); ?></p>
    <br>
    <p>Prezzo: <?php echo $prezzoZaino; ?></p>
    <br>
    <br>
    <p>Subtotale: <?php echo $subtotale;?></p>
    <br>
    
  </body>
  </html>






<?php
}
?>