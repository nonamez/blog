"use strict";

var dropdowns = document.querySelectorAll('[data-toggle=dropdown]');

for (var i = 0, dropdown; dropdown = dropdowns[i]; ++i) {
	dropdown.setAttribute('tabindex', '0'); // Fix to make onblur work in Chrome
	
	dropdown.addEventListener('click', function(event) {
		this.parentElement.classList.toggle('open');
		
		return false;
	});
	
	dropdown.addEventListener('blur', function(event) {
		this.parentElement.classList.toggle('open');
		
		var target = event.explicitOriginalTarget;
			target = target.nodeType == 3 ? target.parentElement : target; // If returned TextNode
		
		if (target.getAttribute('data-toggle') !== 'dropdown')
			target.click();
		
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