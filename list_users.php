<?php

//☑️Definiamo una funzione chiamata displayUsersList() che recupera l'elenco degli utenti dal database e lo visualizza in una lista HTML, consentendo all'utente di cancellare gli utenti direttamente dalla lista.

//☑️CONNESSIONE AL DATABASE e recupero DELL'ELENCO degli utenti:
//1)Viene inclusa la classe Utente dal file utente.php.
//2)Viene istanziato un nuovo oggetto Utente.
function displayUsersList() {
    require_once 'utente.php';
    $utente = new Utente();

//3)l metodo getUsersList() dell'oggetto Utente per recuperare l'elenco degli utenti dal database. Questo metodo restituisce un array contenente le informazioni degli utenti.
    $users = $utente->getUsersList();
//4)Visualizzazione degli utenti
    echo "<ul class='list-group'>";
    foreach ($users as $user) {
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
        echo htmlspecialchars($user['username']);
        echo "<span>";
        echo "<form method='post' action='pannello.php' class='d-inline'>
                <input type='hidden' name='id' value='" . $user['id'] . "'>
                <button type='submit' name='deleteUser' class='btn btn-danger btn-sm'>Cancella</button>
              </form>";
        echo "</span>";
        echo "</li>";
    }
    echo "</ul>";
}
?>
