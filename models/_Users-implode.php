<?php
// Questa riga inizia la sessione PHP, necessaria per mantenere le informazioni tra le varie pagine.
// session_start(); 

// Definizione della classe Users per la gestione degli utenti.
class Users
{
    private $conn; // Variabile per conservare la connessione al database.

    // Costruttore della classe che inizializza la connessione al database.
    public function __construct($db)
    {
        $this->conn = $db; // Assegnazione del database passato come parametro alla variabile conn.
    }
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Metodo per creare un nuovo utente.
    function create($data)
    {
        try {
            // Preparazione di una query per verificare se l'email dell'utente esiste già nel database.
            $stmt = $this->conn->prepare("SELECT email FROM users WHERE email = :email");
            $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR); // Assegnazione del parametro email alla query.
            $stmt->execute(); // Esecuzione della query.

            // Controllo se l'utente con l'email fornita non esiste già.
            if ($stmt->rowCount() == 0) {
                // Hashing della password utilizzando bcrypt, un algoritmo robusto per la sicurezza delle password.
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Creazione dinamica dei campi e dei placeholder per la query di inserimento.
                $fields = implode(", ", array_keys($data)); // Creazione di una stringa con i nomi dei campi.
                $placeholders = ':' . implode(', :', array_keys($data)); // Creazione di una stringa con i placeholder.

                // Preparazione della query di inserimento utilizzando i campi e i placeholder.
                $query = "INSERT INTO users ($fields) VALUES ($placeholders)";
                $stmt = $this->conn->prepare($query);

                // Assegnazione dei valori ai placeholder nella query.
                $this->bindParams($stmt, $data);
                $stmt->execute(); // Esecuzione della query di inserimento.

                // Ritorno di una risposta JSON che indica il successo dell'operazione.
                return json_encode(['data' => ['err' => false, 'auth' => false, 'message' => "User added successfully", 'class' => 'alert-success']]);
            } else {
                // Ritorno di una risposta JSON che indica la presenza di un utente esistente con la stessa email.
                return json_encode(['data' => ['err' => true, 'auth' => false, 'message' => "Existing user", 'class' => 'alert-warning']]);
            }
        } catch (PDOException $exception) {
            // Gestione dell'eccezione e ritorno di una risposta JSON con il messaggio di errore.
            return json_encode(['data' => ['err' => true, 'message' => "Execution error: " . $exception->getMessage(), 'class' => 'alert-danger']]);
        }
    }
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Metodo per autenticare un utente basato sull'email e sulla password.
    function read($data)
    {
        try {
            // Preparazione di una query per ottenere la password hashata dell'utente.
            $stmt = $this->conn->prepare("SELECT password FROM users WHERE email = :email");
            $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR); // Assegnazione del parametro email.
            $stmt->execute(); // Esecuzione della query.

            // Controllo se esiste un utente con l'email fornita.
            if ($stmt->rowCount() == 1) {
                // Recupero della password hashata dal database.
                $hashed_password = $stmt->fetchColumn();

                // Verifica della corrispondenza della password fornita con quella hashata nel database.
                if (password_verify($data['password'], $hashed_password)) {
                    // Impostazione della sessione come autenticata e salvataggio dell'email.
                    $_SESSION['auth'] = true;
                    $_SESSION['email'] = $data['email'];

                    // Ritorno di una risposta JSON che indica che l'utente è autorizzato.
                    return json_encode(['data' => ['err' => false, 'auth' => true, 'message' => "Authorized User", 'class' => 'alert-success', 'email' => $data['email']]]);
                } else {
                    // Se la password non corrisponde, impostazione della sessione come non autenticata.
                    $_SESSION['auth'] = false;
                    // Ritorno di una risposta JSON che indica una password errata.
                    return json_encode(['data' => ['err' => true, 'auth' => false, 'message' => "Incorrect password", 'class' => 'alert-warning']]);
                }
            } else {
                // Se non viene trovato nessun utente, ritorno di una risposta JSON che indica che l'utente non è trovato.
                return json_encode(['data' => ['err' => true, 'auth' => false, 'message' => "User not found", 'class' => 'alert-warning']]);
            }
        } catch (PDOException $exception) {
            // Gestione dell'eccezione e ritorno di una risposta JSON con il messaggio di errore.
            return json_encode(['data' => ['err' => true, 'message' => "Execution error: " . $exception->getMessage(), 'class' => 'alert-danger']]);
        }
    }
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Metodo privato per collegare i parametri alla query SQL preparata.
    private function bindParams($stmt, $params)
    {
        foreach ($params as $key => $value) {
            // Collegamento dinamico dei parametri in base al loro tipo.
            $stmt->bindParam(':' . $key, $params[$key], is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
    }

    // Qui si possono aggiungere altri metodi come update() e delete() se necessario.
}

?>