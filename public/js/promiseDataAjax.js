function UsersCarsPromise(parameters) {
    return new Promise((resolve, reject) => {
        $.ajax({
            async: true,
            method: "POST",
            url: "controllers/users_cars/",
            data: parameters,
            dataType: "json",
            contentType: "application/x-www-form-urlencoded; charset=UTF-8"
        })
        .done(function(data) {
            resolve(data)
        })
        .fail(function(xhr, status, error) {
            reject(new Error(`Ajax call failed: ${error.message}`));
        })
        .always(function() {
            console.log('Completed AJAX call for UsersCars');
        });
    });
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------
function carsPromise(parameters) {
    // Creazione di una nuova Promise
    return new Promise((resolve, reject) => {
        // Esecuzione della chiamata AJAX
        $.ajax({
            async: true,
            method: "POST",
            url: "controllers/cars/",
            data: parameters,
            dataType: "json",
            contentType: "application/x-www-form-urlencoded; charset=UTF-8"
        })
        .done(function(data) { // Gestione del successo della chiamata AJAX
            resolve(data);
        })
        .fail(function(xhr, status, error) { // Gestione degli errori della chiamata AJAX
            // Logghiamo l'errore e rifiutiamo la Promise con il messaggio di errore
            console.error('Error: ' + error.message);
            reject(new Error(`Ajax call failed: ${error.message}`));
        })
        .always(function() { // Codice eseguito sempre, sia dopo il successo che dopo il fallimento della chiamata
            console.log('Completed AJAX call for cars');
        });
    });
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------
function UsersCars(parameters){
    UsersCarsPromise(parameters)
        .then(data => {
            if (data['data']['err']) {
                $('#card1').append(makeAlert("alert-warning", data['data']['message']));
                reject(new Error(data['data']['message']));
            } else {
                $('#wrapper').children().remove();
                createTable(data['data'], 1, "User Cars");
                populateTable(data['data'], 1, rowRemoveButton);
                return carsPromise({"query":'2'})
            }
            console.log('UsersCars completed successfully:', data);
        })
        .then(data=>{
            if (data['data']['err']) {
                // Se c'è un errore nei dati ricevuti, appendiamo un avviso e rifiutiamo la Promise
                $('#wrapper').append(makeAlert("alert-warning", data['data']['message']));
                reject(new Error(data['data']['message']));
            } else {
                // Se tutto va bene, creiamo e popoliamo la tabella, poi risolviamo la Promise con i dati ricevuti
                createTable(data['data'], 2, "Shop Cars");
                populateTable(data['data'], 2, rowAddButton);
            }
        })
        .catch(error => {
            console.error('Failed to complete UsersCars:', error);
        });
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------    