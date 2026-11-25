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

  if($penna == "") $errorePenna = "Inserisci il numero di penne";
  elseif(!is_numeric($penna)) $errorePenna = "Il numero di penne deve essere numerico";
  elseif($penna != intval($penna)) $errorePenna = "Il numero di penne deve essere intero";

  if($zaino == "") $erroreZaino = "Inserisci il numero di zaini";
  elseif(!is_numeric($zaino)) $erroreZaino = "Il numero di zaini deve essere numerico";
  elseif($zaino != intval($zaino)) $erroreZaino = "Il numero di zaini deve essere intero";

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
        $subtotale = $subtotale * 0.2;
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
  else {
    $esito = "KO";
    
    if($erroreQuaderno != "") echo "<p class='error'>$erroreQuaderno</p>";
    if($errorePenna != "") echo "<p class='error'>$errorePenna</p>";
    if($erroreZaino != "") echo "<p class='error'>$erroreZaino</p>";
    if($erroreCarrelloVuoto != "") echo "<p class='error'>$erroreCarrelloVuoto</p>";
}
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
    <style>
    body {
      font-family: sans-serif;
      max-width: 32rem;
      margin: 2rem auto;
      padding: 0 1rem;
      color: #1c1e22;
      background: #f7f6f2;
    }

    h1 {
      margin-bottom: 0.2rem;
    }

    .negozio {
      margin-top: 0;
      color: #555b66;
    }

    form {
      background: #fff;
      border: 1px solid #d6d3cb;
      border-radius: 8px;
      padding: 1rem 1.2rem;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      text-align: left;
      padding: 0.4rem 0.3rem;
      border-bottom: 1px solid #e6e3dc;
    }

    td.prezzo {
      white-space: nowrap;
    }

    input[type="number"] {
      width: 4rem;
    }

    fieldset {
      margin: 1rem 0;
      border: 1px solid #d6d3cb;
      border-radius: 6px;
    }

    label {
      display: block;
      margin: 0.3rem 0;
    }

    button {
      font-size: 1rem;
      padding: 0.5rem 1.2rem;
      border: 0;
      border-radius: 6px;
      background: #1f5fbf;
      color: #fff;
      cursor: pointer;
    }

    .error {
      color: red;
    }
  </style>
  </head>
  <body>
    <h1>RISULTATO</h1>
    <br>
    <p>Quaderni: <?php echo htmlspecialchars($quaderno); ?> x Prezzo: <?php echo $prezzoQuaderno; ?> = <?php echo $subtotale;?>€</p>
    <p>Prezzo: <?php echo $prezzoQuaderno; ?></p>
    <br>
    <p>Penne: <?php echo htmlspecialchars($penna); ?></p>
    <p>Prezzo: <?php echo $prezzoPenna; ?></p>
    <br>
    <p>Zaini: <?php echo htmlspecialchars($zaino); ?></p>
    <p>Prezzo: <?php echo $prezzoZaino; ?></p>
    <br>
    <p>Subtotale: <?php echo number_format($subtotaleIniziale, 2, ".", ",");?></p>
    <?php
    if($erroreCodiceSconto != ""){
      echo "<br>";
      echo "<p class='error'>$erroreCodiceSconto</p>";
    }
    ?>
    <br>
    <p>Totale: <?php echo number_format($totale, 2, ".", ",");?></p>
    
  </body>
  </html>






<?php
}
?>