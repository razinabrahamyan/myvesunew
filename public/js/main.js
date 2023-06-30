function openNav() {
    document.getElementById("leftSidenav").style.left = "0";
    document.getElementById("leftSidenav").style.overflowX = "visible";
    document.getElementById("navCloseButton").style.right = "-15px";
    is_on_screen = false;
    document.body.style.overflow = 'hidden';
}

function closeNav() {
    document.getElementById("leftSidenav").style.left = "-85vw";
    document.getElementById("leftSidenav").style.overflowX = "hidden";
    document.getElementById("navCloseButton").style.right = "0";
    document.body.style.overflow = 'scroll';
    is_on_screen = true;
}

$( ".sync_btn" ).click(function() {
    location.reload()
});
