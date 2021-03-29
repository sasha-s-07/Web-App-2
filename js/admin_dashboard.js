//FUNCTION FOR SIDE BAR MENU
function displaySidebar() {
    let sidebarNav = document.getElementById("sidebar_nav");
    sidebarNav.classList.toggle("d-block");
}

let sidebarNavBtn = document.getElementById("sidebar_nav_btn");
sidebarNavBtn.onclick = displaySidebar;


//FUNCTION FOR TOGGLE MENU INSIDE OF SIDE BAR
function displayPageMenu() {
    let pageMenuItem = document.getElementById("sidebar_toggle_menu");
    pageMenuItem.classList.toggle("d-block");
}
let sidebarToggleBtn = document.getElementById("sidebar_toggle_btn");
sidebarToggleBtn.onclick = displayPageMenu;


//FUNCTION TO OUTPUT MESSAGE FOR HELPDESK
/*
function displayHelpMsg() {
    let helpMsg = document.getElementById("helpMsg");
    helpMsg.classList.toggle("d-block");
}

let link1 = document.getElementById("link1");
link1.onclick = displayHelpMsg;
*/