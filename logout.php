<?php
//File per gestire l'operazione di logout dell'utente.
//Quando un utente decide di uscire dal suo account o di terminare la sua sessione attiva, il server esegue questo file per eseguire il logout.

//1)Terminare la sessione dell'utente.
//2)Pulire tutte le informazioni di sessione associate a quell'utente
//3)Reindirizzare l'utente a una pagina di login o a una pagina principale del sito web.
session_start();
session_destroy();
header('Location: index.php');
exit();
?>
