function showLoading(){
    $(".div-loading").css({
        "right":"0",
        "bottom":"0",
        "width":"auto",
        "height":"auto",
        "opacity": "1"
    });
}
function unshowLoading(){
    $(".div-loading").css({
        "right":"100",
        "bottom":"100",
        "width":"0",
        "height":"0",
        "opacity": "0"
    });
}