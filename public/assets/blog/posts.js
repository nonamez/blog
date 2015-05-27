"use strict";

function getHeight(el) {
	var s = el.style;
	
	var v   = s.visibility;
	var p   = s.position;
	var d   = s.display;
	var m_h = s.maxHeight;
	
	s.visibility = 'hidden';
	s.position   = 'absolute';
	s.display    = 'block';
	s.maxHeight  = 'none';
	
	var h = el.clientHeight;
	
	s.display    = d;
	s.position   = p;
	s.visibility = v;
	s.maxHeight  = m_h;
	
	return h;
}

var articles = document.querySelectorAll('article');

for (var i = 0, article; article = articles[i]; ++i) {
	var post_content = article.querySelector('section.post-content');
		post_content.setAttribute('data-real-heigt', getHeight(post_content) + 30); // Sometimes with a bigger text there comes some bug with height so we add some extra as a fix...

	article.querySelector('header.post-header').addEventListener('click', function() {
		var article = this.parentNode;
		var post_content = article.querySelector('section.post-content');
		
		if (article.classList.contains('open')) {
			article.classList.remove('open');
			
			post_content.style.maxHeight = 0;
		} else {
			var opened_articles = document.querySelectorAll('article.post.open');
			
			if (opened_articles.length > 0) {
				for (var i = 0, o_article; o_article = opened_articles[i]; ++i) {
					o_article.classList.remove('open');
				
					o_article.querySelector('section.post-content').style.maxHeight = 0;
				}
			}
		
			article.classList.add('open');
			
			post_content.style.maxHeight = post_content.getAttribute('data-real-heigt') + 'px';
		}
	});
}