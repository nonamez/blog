"use strict";

function isDescendant(parent, child) {
	var node = child.parentNode;

	while (node != null) {
		if (node == parent)
			return true;

		node = node.parentNode;
	}

	return false;
}

var dropdowns = document.querySelectorAll('[data-toggle=dropdown]');

// Show menu
for (var i = 0, dropdown; dropdown = dropdowns[i]; ++i) {
	dropdown.addEventListener('click', function(event) {
		for (var i = 0, dropdown; dropdown = dropdowns[i]; ++i)
			dropdown.parentElement.classList.remove('open');
		
		this.parentElement.classList.toggle('open');
		
		return false;
	});
}

// Hide menu
document.addEventListener('click', function(event) {
	var open_menu = document.querySelector('.menu.open');

	if (open_menu != null) {
		var target = event.target || event.srcElement;

		if (isDescendant(open_menu, target) == false)
			open_menu.classList.remove('open');
	}
});

var top_element  = document.getElementById('back-to-top');

window.addEventListener('scroll', function() {
	var scrolled = window.pageYOffset || document.documentElement.scrollTop;
	
	if (scrolled > 100)
		top_element.style.display = 'block';
	else
		top_element.style.display = 'none';
})