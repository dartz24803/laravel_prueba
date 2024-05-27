
$(".img_post").click(function () {
    window.open($(this).attr("src"), 'popUpWindow', 
    "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
});


/*
$(".img_post").click(function () {
    window.open($(this).attr("src"), 'popUpWindow', 
    "height=500px,width=500px,resizable=yes,toolbar=yes,menubar=no')");
});
*/