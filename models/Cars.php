<?php

// Definizione della classe Cars.
class Cars
{
    private $conn; // Proprietà privata per mantenere la connessione al database.

    // Costruttore che accetta un parametro database e assegna alla proprietà conn.
    public function __construct($db)
    {
        $this->conn = $db;
    }
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Metodo per creare un record di un'auto nel database.
    function create($data)
    {
        try {
            // Preparazione della query SQL per inserire i dati.
            $query = "INSERT INTO cars SET plate=:plate, brand=:brand, model=:model, capacity=:capacity";
            $stmt = $this->conn->prepare($query);

            // Collegamento dei parametri con i valori specificati, usando bindParam per evitare SQL injection.
            $stmt->bindParam(":plate", $data['plate'], PDO::PARAM_STR);
            $stmt->bindParam(":brand", $data['brand'], PDO::PARAM_STR);
            $stmt->bindParam(":model", $data['model'], PDO::PARAM_STR);
            $stmt->bindParam(":capacity", $data['capacity'], PDO::PARAM_STR);

            // Esecuzione della query preparata.
            if ($stmt->execute()) {
                // Ritorno di un messaggio di successo in formato JSON se l'operazione va a buon fine.
                return json_encode(['data' => ['err' => false, 'message' => "Item added"]]);
            }
            // Ritorno false se l'execute fallisce.
            return false;
        } catch (PDOException $exception) {
            // Gestione dell'eccezione e ritorno di un messaggio di errore in formato JSON.
            return json_encode(['data' => ['err' => true, 'message' => "Execution error: " . $exception->getMessage()]]);
        }
    }
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Metodo per leggere i dati delle auto che non sono assegnate agli utenti.
    function read()
    {
        try {
            // Query SQL che seleziona le auto non assegnate.
            $query = "SELECT cars.plate, brand, model, capacity FROM cars 
                      LEFT JOIN users_cars ON users_cars.plate = cars.plate 
                      WHERE users_cars.plate IS NULL";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            // Verifica se ci sono record trovati.
            if ($stmt->rowCount() > 0) {
                // Ritorno dei dati in formato JSON se ci sono record.
                return json_encode(['data' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
            } else {
                // Messaggio di "nessun record trovato" se non ci sono dati.
                return json_encode(['data' => ['err' => false, 'message' => "No records found"]]);
            }
        } catch (PDOException $exception) {
            // Gestione dell'eccezione e ritorno di un messaggio di errore.
            return json_encode(['data' => ['err' => true, 'message' => "Execution error: " . $exception->getMessage()]]);
        }
    }
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Metodo per aggiornare i dati di un'auto esistente.
    function update($data)
    {
        try {
            // Query SQL per aggiornare i dati di un'auto specifica.
            $query = "UPDATE cars SET brand=:brand, model=:model, capacity=:capacity WHERE plate=:plate";
            $stmt = $this->conn->prepare($query);

            // Collegamento dei parametri ai valori forniti.
            $stmt->bindParam(":plate", $data['plate'], PDO::PARAM_STR);
            $stmt->bindParam(":brand", $data['brand'], PDO::PARAM_STR);
            $stmt->bindParam(":model", $data['model'], PDO::PARAM_STR);
            $stmt->bindParam(":capacity", $data['capacity'], PDO::PARAM_STR);

            // Esecuzione della query.
            if ($stmt->execute()) {
                // Ritorno di un messaggio di successo se l'aggiornamento è riuscito.
                return json_encode(['data' => ['err' => false, 'message' => "Item updated"]]);
            }
            // Ritorno false se l'execute fallisce.
            return false;
        } catch (PDOException $exception) {
            // Gestione dell'eccezione e ritorno di un messaggio di errore.
            return json_encode(['data' => ['err' => true, 'message' => "Execution error: " . $exception->getMessage()]]);
        }
    }
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Metodo per eliminare un record di auto dal database.
    function delete($data)
    {
        try {
            // Query SQL per eliminare un'auto specifica.
            $query = "DELETE FROM cars WHERE plate=:plate";
            $stmt = $this->conn->prepare($query);

            // Collegamento del parametro plate.
            $stmt->bindParam(":plate", $data['plate'], PDO::PARAM_STR);

            // Esecuzione della query.
            if ($stmt->execute()) {
                // Ritorno di un messaggio di successo se la cancellazione è riuscita.
                return json_encode(['data' => ['err' => false, 'message' => "Item deleted"]]);
            }
            // Ritorno false se l'execute fallisce.
            return false;
        } catch (PDOException $exception) {
            // Gestione dell'eccezione e ritorno di un messaggio di errore.
            return json_encode(['data' => ['err' => true, 'message' => "Execution error: " . $exception->getMessage()]]);
        }
    }
}
?>