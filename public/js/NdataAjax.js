
//-------------------------------------------------------------------------------------------------------------------------
function cars(parameters){
    try {
        let callCars = $.ajax({
            async: true,
            method: "POST",
            url: "controllers/cars/",
            data: parameters,
            dataType: "json",
            contentType: "application/x-www-form-urlencoded; charset=UTF-8"
        })
            .done(function(data) {
                if (data['data']['err']){
                    $('#wrapper').append(makeAlert("alert-warning",data['data']['message']));
                }else{
                    createTable(data['data'],2, "Shop Cars")
                    populateTable(data['data'],2,rowAddButton)
                }
            })
            
            .fail(function(e){console.log('Error:' + e.status);})
            .always(function(data){console.log(data);});  
        }
    catch (error) {
        console.error(error);
    }
}

//----------------------------------------------------------------------------------------------------------------
function UsersCars(parameters){
    try {
        console.log(parameters);
        let callUsersCars = $.ajax({
            async: true,
            method: "POST",
            url: "controllers/users_cars/",
            data: parameters,
            dataType: "json",
            contentType: "application/x-www-form-urlencoded; charset=UTF-8"
        })
            .done(function(data) {
                
                if (data['data']['err']){
                    $('#card1').append(makeAlert("alert-warning",data['data']['message']));
                }else{
                    $('#wrapper').children().remove();
                    createTable(data['data'],1,"User Cars")
                    populateTable(data['data'],1,rowRemoveButton)
                    cars({"query":'2'});
                }
            })
            
            .fail(function(e){console.log('Error:' + e.status);})
            .always(function(data){console.log(data);});  
        }
    catch (error) {
        console.error(error);
    }
}