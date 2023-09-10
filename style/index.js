let menu = document.getElementById("menu");
let check = document.getElementById("check");
let ham2 = document.getElementById("ham2");
let nav_menu = document.getElementById("nav-menu");

window.onbeforeunload = function() {
  check.checked = false;
  if (check.checked) {
    menu.style.rotate = "180deg";
    nav_menu.classList = "nav-menu";
  } else {
    menu.style.rotate = "0deg";
    nav_menu.classList = "hide";
  }
};

check.addEventListener("click", function(){
    if (check.checked) {
      menu.style.rotate = "180deg";
      nav_menu.classList = "nav-menu";
      nav_menu.classList.add('muncul');
    } else { 
      menu.style.rotate = "0deg";
      nav_menu.classList = "hide";
    }
});