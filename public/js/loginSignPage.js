
//------------------------------------------------------------------------------------------------------
function loginSignPage(place){
    let callback = {"signup": register, "login": login};
    let forms = document.getElementsByClassName('needs-validation');
    $.each(forms, function(index, form){
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // interrompere l'evento di submit
            //event.stopPropagation();// evitare bubbling
            if (form.checkValidity()) {callback[form.id](event);}
            form.classList.add('was-validated');
        }, false);
    });

}
//---------------------------------------------------------------------------------------------------
function login(event) {
    try {
        $.ajax({
            async: true,
            method: "POST",
            url: "controllers/login/", //crea problemi se non si inserisce l'ultimo backslash
            data: $(event.target).serialize(),
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            dataType: "json",
        })
            .done(function(info) {
                if (info['data']['err']){
                    $('body').append(makeAlert("alert-warning",info['data']['message']));
                }else{
                    window.sessionStorage.setItem("email", info['data']['email']);
                    UsersCars({'query':'2','email':info['data']['email']}); 
                }   
            })
            .fail(function(e){console.log('Error:' + e.status);})
            .always(function(data){console.log(data);});
    }
    catch(error) {
        console.error(error);
    }
}
//-----------------------------------------------------------------------------------------------------
function register(event){
    try {
        $.ajax({
            async: true,
            method: "POST",
            url: "controllers/register/", //crea problemi se non si inserisce l'ultimo backslash
            data: $(event.target).serialize(),
            dataType: "json",
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        })
            .done(function(info) {
                $("#signup div[role='alert']").addClass(info['data']['class']).html(info['data']['message']);
            })
            .fail(function(e){console.log('Error:' + e.status);})
            .always(function(data){console.log(data);});
    }
    catch (error) {
        console.error(error);
    }
}
