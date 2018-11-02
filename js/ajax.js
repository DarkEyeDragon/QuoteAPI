let infoSection = $("#infoSection");
let infoText = $("#infoText");

$(function () {
    let id = $("#form");
    $(id).submit(function (e) {
        console.log("SUBMIT");
        let form = $(this);
        let url = form.attr('action');

        $.ajax({
            type: "GET",
            url: url,
            dataType: 'html',
            data: form.serialize(), // serializes the form's elements.
            success: function (data) {
                infoSection.show();
                infoText.text("Quote submitted..."); // show response from the php script.
                infoSection.slideUp(1500);
                infoSection.removeClass("error");
                infoSection.addClass("success");
            },
        }).fail(function (jqXHR, textStatus) {
            infoSection.show();
            infoText.text("Quote submitted..."); // show response from the php script.
            infoSection.slideUp(1500);
            infoSection.removeClass("success");
            infoSection.addClass("error");
        });
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });
    console.log("Ajax ready");
});

function action(keep, id) {
    let href = $(this).attr('href');
    $.ajax({
        type: "GET",
        url: href,
        dataType: 'html',
        data: 'data=accept&id=' + id,
        success: function (data) {
            infoSection.show();
            infoText.text("Quote submitted..."); // show response from the php script.
            infoSection.slideUp(1500);
            infoSection.removeClass("error");
            infoSection.addClass("success");
        },
    }).fail(function (jqXHR, textStatus) {
        infoSection.show();
        infoText.text("Quote submitted..."); // show response from the php script.
        infoSection.slideUp(1500);
        infoSection.removeClass("success");
        infoSection.addClass("error");
    });
    e.preventDefault(); // avoid to execute the actual submit of the form.
    if (keep) {

    }
}
