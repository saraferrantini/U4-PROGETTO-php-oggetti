<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pannello Utente</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!--☑️ PANNELLO UTENTE, che offre diverse funzionalità agli utenti autenticati: -->
    <div class="container">
        <h1 class="mt-5">Pannello Utente</h1>
        <form action="logout.php" method="post">
<!-- Logout Button: Mostra un pulsante che permette all'utente di eseguire il logout dal sistema. Il pulsante invia una richiesta POST al file logout.php per terminare la sessione dell'utente -->
            <button type="submit" class="btn btn-primary mb-3">Logout</button>
        </form>
<!-- Lista Utenti Registrati: Visualizza la lista degli utenti registrati nel sistema. Utilizza la funzione displayUsersList() definita nel file list_users.php. -->
        <h2>Lista Utenti Registrati</h2>
        <?php
        require_once 'list_users.php';
        displayUsersList();
        ?>
<!-- Gestione Libri: Permette all'utente di aggiungere, aggiornare e eliminare libri associati al proprio account. Mostra anche la lista dei libri già aggiunti dall'utente.   -->
        <h2>Gestione Libri</h2>
        <?php
        session_start();
        require_once 'utente.php';
        $utente = new Utente($_SESSION['username'], null);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['addBook'])) {
                $title = $_POST['title'];
                $utente->addBook($title);
            } elseif (isset($_POST['updateBook'])) {
                $id = $_POST['id'];
                $title = $_POST['title'];
                $utente->updateBook($id, $title);
            } elseif (isset($_POST['deleteBook'])) {
                $id = $_POST['id'];
                $utente->deleteBook($id);
            } elseif (isset($_POST['deleteUser'])) {
                $id = $_POST['id'];
                $utente->deleteUser($id);
            }
        }

        $books = $utente->getBooks();
        if (count($books) > 0) {
            echo "<ul class='list-group'>";
            foreach ($books as $book) {
                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                echo htmlspecialchars($book['title']);
                echo "<span>";
                echo "<form method='post' class='d-inline'>
                        <input type='hidden' name='id' value='" . $book['id'] . "'>
                        <input type='text' name='title' value='" . $book['title'] . "' required>
                        <button type='submit' name='updateBook' class='btn btn-warning btn-sm'>Aggiorna</button>
                    </form>";
                echo "<form method='post' class='d-inline'>
                        <input type='hidden' name='id' value='" . $book['id'] . "'>
                        <button type='submit' name='deleteBook' class='btn btn-danger btn-sm'>Cancella</button>
                    </form>";
                echo "</span>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<div class='alert alert-info' role='alert'>Nessun libro trovato.</div>";
        }
        ?>

<!-- Aggiungi Libro: Form per aggiungere un nuovo libro. L'utente può inserire il titolo del libro e inviare il modulo tramite il pulsante "Aggiungi". -->

<!--☑️Ogni volta che l'utente aggiunge, aggiorna o elimina un libro, vengono inviate richieste POST al file corrente (pannello.php) per gestire queste azioni utilizzando il codice PHP. -->

        <h3>Aggiungi Libro</h3>
        <form method="post">
            <div class="form-group">
                <label for="title">Titolo</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <button type="submit" name="addBook" class="btn btn-primary">Aggiungi</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
