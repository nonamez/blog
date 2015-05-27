"use strict";

var dropdowns = document.querySelectorAll('[data-toggle=dropdown]');

for (var i = 0, dropdown; dropdown = dropdowns[i]; ++i) {
	dropdown.addEventListener('click', function(event) {
		for (var i = 0, dropdown; dropdown = dropdowns[i]; ++i)
			dropdown.parentElement.classList.remove('open');
		
		this.parentElement.classList.toggle('open');
		
		return false;
	});
}

var top_element  = document.getElementById('back-to-top');

window.addEventListener('scroll', function() {
	var scrolled = window.pageYOffset || document.documentElement.scrollTop;
	
	if (scrolled > 100)
		top_element.style.display = 'block';
	else
		top_element.style.display = 'none';
})