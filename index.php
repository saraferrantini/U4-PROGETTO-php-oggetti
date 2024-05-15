<?php

// il file utente.php contiene la definizione della classe Utente e le sue funzioni per gestire l'accesso degli utenti.

include 'utente.php'; 

//☑️GESTIONE RICHIESTE POST: il codice verifica se la richiesta HTTP è di tipo POST. Se sì, controlla i valori inviati dal modulo HTML.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["register"])) {
        
//☑️REGISTRAZIONE UTENTE
//se il pulsante registrati è stato premuto pulsante "register" è stato premuto), il codice recupera l'username e la password dal modulo e crea un nuovo oggetto Utente con questi dati. Quindi chiama il metodo register() dell'oggetto Utente per registrare l'utente nel database.

        $username = $_POST["username"];
        $password = $_POST["password"];

        $utente = new Utente($username, $password);
        $utente->register();
    } elseif (isset($_POST["login"])) {
// ☑️LOGIN utente
//se cliccato login  il codice recupera l'username e la password dal modulo e crea un nuovo oggetto Utente con questi dati. Quindi chiama il metodo login() dell'oggetto Utente per verificare le credenziali e autenticare l'utente.
        $username = $_POST["username"];
        $password = $_POST["password"];

        $utente = new Utente($username, $password);
        $utente->login();
    } elseif (isset($_POST["logout"])) {
//☑️LOGOUT utente
//se cliccato logout  il codice recupera l'username e la password dal modulo e crea un nuovo oggetto Utente con questi dati. Quindi chiama il metodo logout() dell'oggetto Utente per terminare la sessione dell'utente e reindirizzarlo alla pagina di login.
        $username = $_POST["username"];
        $password = $_POST["password"];

        $utente = new Utente($username, $password);
        $utente->logout();
    }
}

?>


<!-- ☑️Il codice HTML visualizza un modulo per il login o la registrazione dell'utente, a seconda del valore della variabile GET "register". Se "register" è impostato su "true",
 viene visualizzato il modulo di registrazione. Altrimenti, viene visualizzato il modulo di login. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login e Registrazione Utente</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Personalizzazione CSS */
        
        .container {
            margin-top: 50px;
            width: 400px;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <?php if (!isset($_GET["register"]) && !isset($_POST["register"])): ?>
            <h2 class="text-center">Welcome!</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="username" id="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary btn-block">Accedi</button>
            </form>
            <br>
            <p class="text-center">Non hai un account? <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?register=true">Registrati qui</a>.</p>
        <?php else: ?>
            <h2 class="text-center">Registrazione Utente</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="username" id="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <button type="submit" name="register" class="btn btn-primary btn-block">Registrati</button>
            </form>
            <br>
            <p class="text-center">Hai già un account? <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">Accedi qui</a>.</p>
        <?php endif; ?>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
