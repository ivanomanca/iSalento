<?php
// testo dell'email di conferma da inviare nella fase di iscrizione

$PART1 = "<body style=\"margin: 10px;\">
<div style=\"width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><br><br>Ciao ";

//$nome_utente,

$PART2 = ",<br><br>ti chiediamo di confermare la richiesta di registrazione del tuo account cliccando sul link riportato di seguito.
<br><br>http://";

//www.isalento.it

$PART3 = "/index.php?component=Authenticate&task=emailConfirm&fp=";

//$fp_utente

$PART4 = "<br><br>Se il link sopra non funziona, copialo e incollalo in una nuova finestra del browser e segui le istruzioni.<br>
<br><br>
ATTENZIONE: se hai ricevuto questo messaggio per errore, ti e' sufficiente ignorarlo per far si che il tuo indirizzo non venga associato ad alcun account.
<br><br>
iSalento Staff.
<br><br>
(PS:  Non rispondere a questo indirizzo e-mail ;).
</body>";
?>