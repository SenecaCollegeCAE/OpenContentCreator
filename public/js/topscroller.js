window.onscroll = scroll;

var bAppended = false; 
var oBookmark = document.createElement("div");
oBookmark.id = "arrowUp";
oBookmark.innerHTML = "<a href=\"#\" title=\"Top of the page.\">&uarr;<\/a>";

function scroll () {
	 // note: you can use window.innerWidth and window.innerHeight to access the width and height of the viewing area
	var nVScroll = document.documentElement.scrollTop || document.body.scrollTop;
  
	bAppended = nVScroll > 500 ? bAppended || (document.body.appendChild(oBookmark), true) : bAppended && (document.body.removeChild(oBookmark), false);
}