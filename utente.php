<?php

//☑️definiamo una classe chiamata Utente che gestisce le operazioni legate agli utenti e ai loro libri nel database.
//☑️Proprietà della classe Utente
class Utente {
    private $username; //memorizza l'username dell'utente.
    private $password; //memorizza la password dell'utente.
    private $conn;//memorizza l'oggetto di connessione al database.

//☑️METODO COSTRUTTORE: viene chiamato ogni volta che un nuovo oggetto Utente viene istanziato.Si occupa di inizializzare le proprietà $username e $password, e di stabilire una connessione al database utilizzando PDO.
    public function __construct($username = null, $password = null) {
        $this->username = $username;
        $this->password = $password;

        // Connessione al database
        try {
            $this->conn = new PDO("mysql:host=localhost;dbname=login", "root", "");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger' role='alert'>Errore di connessione: " . $e->getMessage() . "</div>";
        }
    }
//☑️METODO REGISTER: prepara e esegue una query SQL per inserire un nuovo utente nel database con l'username e la password forniti.
    public function register() {
        $stmt = $this->conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);

        try {
            $stmt->execute();
            echo "<div class='alert alert-success' role='alert'>Registrazione completata con successo.</div>";
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger' role='alert'>Errore durante la registrazione: " . $e->getMessage() . "</div>";
        }
    }

 //☑️METODO LOGIN: Verifica se le credenziali di accesso fornite corrispondono a quelle presenti nel database.Se le credenziali sono corrette, avvia una sessione, imposta l'username dell'utente nella sessione e reindirizza l'utente alla pagina "pannello.php".Altrimenti, mostra un messaggio di errore.
    public function login() {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            session_start();
            $_SESSION['username'] = $this->username;

            header('Location: pannello.php');
            exit();
        } else {
            echo "<div class='alert alert-danger' role='alert'>Credenziali non valide.</div>";
        }
    }
//☑️METODO LOGOUT: termina la sessione corrente e reindirizza l'utente alla pagina di login.
    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php');
        exit();
    }

 //☑️getUsersList(): recupera l'elenco degli utenti dal database.
    public function getUsersList() {
        $stmt = $this->conn->prepare("SELECT id, username FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
//☑️deleteUser($id): elimina un utente dal database in base al suo ID.
    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
            echo "<div class='alert alert-success' role='alert'>Utente eliminato con successo.</div>";
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger' role='alert'>Errore durante l'eliminazione: " . $e->getMessage() . "</div>";
        }
    }
//☑️updateUser($id, $newUsername, $newPassword): aggiorna l'username e/o la password di un utente nel database.
    public function updateUser($id, $newUsername, $newPassword) {
        $stmt = $this->conn->prepare("UPDATE users SET username = :username, password = :password WHERE id = :id");
        $stmt->bindParam(':username', $newUsername);
        $stmt->bindParam(':password', $newPassword);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
            echo "<div class='alert alert-success' role='alert'>Utente aggiornato con successo.</div>";
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger' role='alert'>Errore durante l'aggiornamento: " . $e->getMessage() . "</div>";
        }
    }

    private function getUserId() {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user['id'];
    }
//☑️METODI per gestire i LIBRI degli utenti
//1)recupera l'elenco dei libri di un utente dal database.
    public function getBooks() {
        $stmt = $this->conn->prepare("SELECT * FROM books WHERE user_id = :user_id");
        $userId = $this->getUserId();
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

   
//2)aggiunge un nuovo libro per l'utente corrente nel database.
    public function addBook($title) {
        $userId = $this->getUserId();
    
        // Utilizza una variabile separata per memorizzare il valore
        $userIdValue = $userId;
    
        $stmt = $this->conn->prepare("INSERT INTO books (user_id, title) VALUES (:user_id, :title)");
        $stmt->bindParam(':user_id', $userIdValue); // Passa la variabile per riferimento
        $stmt->bindParam(':title', $title);
    
        try {
            $stmt->execute();
            echo "<div class='alert alert-success' role='alert'>Libro aggiunto con successo.</div>";
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger' role='alert'>Errore durante l'aggiunta del libro: " . $e->getMessage() . "</div>";
        }
    }
    
   //3)aggiorna il titolo di un libro dell'utente corrente nel database.
    public function updateBook($id, $title) {
        $stmt = $this->conn->prepare("UPDATE books SET title = :title WHERE id = :id AND user_id = :user_id");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $this->getUserId());

        try {
            $stmt->execute();
            echo "<div class='alert alert-success' role='alert'>Libro aggiornato con successo.</div>";
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger' role='alert'>Errore durante l'aggiornamento del libro: " . $e->getMessage() . "</div>";
        }
    }
  //4)elimina un libro dell'utente corrente dal database.
    public function deleteBook($id) {
        $stmt = $this->conn->prepare("DELETE FROM books WHERE id = :id AND user_id = :user_id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $this->getUserId());

        try {
            $stmt->execute();
            echo "<div class='alert alert-success' role='alert'>Libro eliminato con successo.</div>";
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger' role='alert'>Errore durante l'eliminazione del libro: " . $e->getMessage() . "</div>";
        }
    }
}
?>
