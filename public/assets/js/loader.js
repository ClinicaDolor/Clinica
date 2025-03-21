$(window).on("pageshow", function (event) {
    if (event.originalEvent.persisted) {  
        $(".LoaderPage").fadeIn(0).fadeOut("slow");
    }
});

$(document).ready(function() {
    $(".LoaderPage").fadeOut("slow");
});
