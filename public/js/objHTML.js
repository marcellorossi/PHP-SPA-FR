function makeAlert(typeAlert,message){
    return $("<div></div>")
        .addClass("m-3")
        .addClass("alert")
        .addClass("text-center")
        .addClass("shadow rounded")
        .addClass(typeAlert)
        .attr('role','alert')
        .html(message);
}
//----------------------------------------------------------------------------------------------------------------
function createTable(jsonData, index, text) {

    if (jsonData.length > 0) {

        const div = $("<div>")
            .empty()
            .addClass("shadow p-3 bg-body rounded")
            .attr('id', 'jsonTable-' + index);

        const table = $("<table>")
            .addClass("table table-striped table-hover")
            .appendTo(div);

        const thead = $("<thead>");
        const tbody = $("<tbody>");
        table.append(thead, tbody);
            
        let tr = $("<tr>");
            
        for (key in jsonData[0]) {        
            $("<th>")
                .attr("scope", "col")
                .text(key.replace("_", " "))
                .appendTo(tr);
        };
        
        tr.appendTo(thead);

        const wrapper = $('#wrapper'); 
        makeContainer(wrapper,index,text).append(div)       
       
    }
}

//------------------------------------------------------------------------------------------------------------------------------------------------
function populateTable(jsonData, index, addButton) {
    try {
        
        if (jsonData.length > 0) {

            let tbody = $("#jsonTable-" + index + " tbody");
            tbody.empty(); // Pulisce il corpo della tabella
            
            for (let item of jsonData) {
                let tr = $("<tr>")
                    .appendTo(tbody);

                for (let key in item) {
                    if (item.hasOwnProperty(key)) {
                        $("<td>")
                            .attr('key', key)
                            .text(item[key])
                            .appendTo(tr);
                    }
                }
                addButton(tr,item)
            }    
            
        };
    } catch (error) {
        console.error("Populate Error: ", error);
    }
}
//------------------------------------------------------------------------------------------------------------------------------------------------
function makeContainer(place,index, text){
    const container = $('<div></div>')
        .addClass("container shadow mt-3 p-2 bg-body rounded")
        .attr('id',"accordion-" + index)
        .appendTo(place);
    $("<h2>")
        .text(text)
        .appendTo(container);      
    return container          
}
//------------------------------------------------------------------------------------------------------------------------------------------------
function rowAddButton(tr, item){

    const editButton = createButton({
        className: "btn btn-primary btn-sm w-50",
        text: "+",
        onClick: function() {UsersCars({'query':'4','plate': item['plate']});}
    });

    $("<td>")
        .append(editButton)
        .appendTo(tr);

}
//-------------------------------------------------------------------------------------------------------------------------------------------------
function rowRemoveButton(tr, item){
    const editButton = createButton({
        className: "btn btn-primary btn-sm w-50",
        text: "-",
        onClick: function() {UsersCars({'query':'5','plate': item['plate']});}
    });

    $("<td>")
        .append(editButton)
        .appendTo(tr);
   
}
//---------------------------------------------------------------------------------------------------------------------------------------------------
function createButton({ className, text, onClick }) {
    
    const button = $("<button>")
        .attr("type", "button")
        .addClass (className)
        .text(text)
        .bind("click", onClick);

    const buttonContainer = $("<div>")
        .addClass("d-flex justify-content-center")
        .append(button);

    return buttonContainer;
}