$(document).ready(function () {

    let selectedID, elementText;

    console.log("Loaded.");
    $(document).on("click", ".10", function (event) {
        selectedID = event.target.id;
        let element = $("#" + selectedID);
        let text = element.text();
        element.replaceWith("<input id='editing' value='" + text + "'>");
        elementText = text;
        console.log("TEST");
    });
    $(document).on("click", function (event) {
        console.log(event.target.id);
        if (event.target.id === "editing") {
            console.log("MES2");
            $("#editing").replaceWith("<p class='edit' id=''>" + elementText + "</p>");
        }
    });
});