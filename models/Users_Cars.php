<?php
// Definizione della classe users_cars per gestire le relazioni tra utenti e auto nel database.
class users_cars
{
    private $conn; // Proprietà per mantenere la connessione al database.

    // Costruttore che inizializza la connessione al database passata come parametro.
    public function __construct($db)
    {
        $this->conn = $db;
    }
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Metodo per creare una nuova associazione tra un utente e un'auto.
    function create($data)
    {
        try {
            // Preparazione della query SQL per inserire i dati nel database.
            $query = "INSERT INTO users_cars SET plate=:plate, email=:email";
            $stmt = $this->conn->prepare($query);

            // Assegnazione dei parametri ai valori forniti dall'array $data e dalla sessione.
            $stmt->bindParam(":plate", $data['plate'], PDO::PARAM_STR);
            $stmt->bindParam(":email", $_SESSION['email'], PDO::PARAM_STR); // Uso di $_SESSION per inserire l'email dell'utente loggato.

            // Esecuzione della query. Se va a buon fine, ritorna un messaggio di successo.
            if ($stmt->execute()) {
                return json_encode(['data'=>['err' => false,'message' => "Item added"]]);
            }
            // Se l'execute non va a buon fine, ritorna false.
            return false;
        }
        catch(PDOException $exception){
            // Gestione delle eccezioni con ritorno di un messaggio di errore in formato JSON.
            return json_encode(['data'=>['err' => true, 'message' => "Execution error: " . $exception->getMessage()]]);
        }
    }
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Metodo per leggere le auto associate all'utente loggato.
    function read()
    {
        try {
            // Preparazione della query SQL per selezionare le auto associate all'utente loggato.
            $query = "SELECT cars.plate, brand, model, capacity FROM cars 
                      LEFT JOIN users_cars ON cars.plate = users_cars.plate 
                      WHERE users_cars.email = :email";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $_SESSION['email'], PDO::PARAM_STR); // Uso di $_SESSION per utilizzare l'email dell'utente loggato.
            $stmt->execute();

            // Verifica se ci sono risultati.
            if ($stmt->rowCount() > 0) {
                // Se ci sono risultati, li ritorna in formato JSON.
                return json_encode(['data' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
            } else {
                // Se non ci sono risultati, ritorna un messaggio di "nessun record trovato".
                return json_encode(['data' => ['err' => false, 'message' => "No records found"]]);
            }
        }
        catch(PDOException $exception){
            // Gestione delle eccezioni con ritorno di un messaggio di errore in formato JSON.
            return json_encode(['data' => ['err' => true, 'message' => "Execution error: " . $exception->getMessage()]]);
        }
    }
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Metodo per aggiornare l'associazione auto-utente.
    function update($data)
    {
        try {
            // Preparazione della query SQL per aggiornare l'associazione specifica.
            $query = "UPDATE users_cars SET plate=:plate WHERE email=:email";
            $stmt = $this->conn->prepare($query);

            // Collegamento dei parametri ai valori.
            $stmt->bindParam(":plate", $data['plate'], PDO::PARAM_STR);
            $stmt->bindParam(":email", $_SESSION['email'], PDO::PARAM_STR); // Uso della sessione per identificare l'utente.

            // Esecuzione della query. Se va a buon fine, ritorna un messaggio di successo.
            if ($stmt->execute()) {
                return json_encode(['data'=>['err' => false, 'message' => "Item updated"]]);
            }
            // Se l'execute fallisce, ritorna false.
            return false;
        }
        catch(PDOException $exception){
            // Gestione delle eccezioni con ritorno di un messaggio di errore in formato JSON.
            return json_encode(['data'=>['err' => true, 'message' => "Execution error: " . $exception->getMessage()]]);
        }
    }
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Metodo per eliminare un'associazione auto-utente.
    function delete($data)
    {
        try {
            // Preparazione della query SQL per eliminare l'associazione specifica.
            $query = "DELETE FROM users_cars WHERE plate=:plate AND email=:email";
            $stmt = $this->conn->prepare($query);

            // Collegamento dei parametri ai valori.
            $stmt->bindParam(":plate", $data['plate'], PDO::PARAM_STR);
            $stmt->bindParam(":email", $_SESSION['email'], PDO::PARAM_STR); // Uso della sessione per identificare l'utente.

            // Esecuzione della query. Se va a buon fine, ritorna un messaggio di successo.
            if ($stmt->execute()) {
                return json_encode(['data'=>['err' => false, 'message' => "Item deleted"]]);
            }
            // Se l'execute fallisce, ritorna false.
            return false;
        }
        catch(PDOException $exception){
            // Gestione delle eccezioni con ritorno di un messaggio di errore in formato JSON.
            return json_encode(['data'=>['err' => true, 'message' => "Execution error: " . $exception->getMessage()]]);
        }
    }
}
?>