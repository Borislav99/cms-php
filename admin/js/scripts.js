$(document).ready(function () {
    // EDITOR CKEDITOR
    ClassicEditor.create(document.querySelector('#body')).catch(error => {
        console.error(error);
    });
    var div_box = "<div id='load-screen'><div id='loading'></div></div>";
    $("body").prepend(div_box);
    $("#load-screen").delay(700).fadeOut(600, function () {
        $(this).remove();
    })
})
