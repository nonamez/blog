<?php
use Blog\Models\Post;
use Blog\Models\Tag;
use Blog\Models\TranslatedPost;

class FirstPostAndTagSeeder extends Seeder {
	public function run()
	{
		$t_post_en = new TranslatedPost;
		$t_post_en->title = 'Hello, %username%!';
		$t_post_en->slug = 'first_post';
		$t_post_en->locale = 'en';
		$t_post_en->status = 'published';
		$t_post_en->content = '<p>So, the blog is open! Yay <i class="fa fa-birthday-cake"></i>.</p><p>This is my first experience of creating a multilingual blog (swithc icon is in the heder), before that there were some attempts to create the it in Lithuanian and Russian.</p><p>The source code can be found at <a href="https://github.com/nonamez/blog" rel="nofollow">GitHub</a>. Blog is currently in development, so in near future there will be a lot of new features.</p>';
		$t_post_en->meta_description = 'The first post of the blog';
		$t_post_en->meta_keywords = 'blog, firs, post, start';
		
		$t_post_lt = new TranslatedPost;
		$t_post_lt->title = 'Sveikas, %username%!';
		$t_post_lt->slug = 'pirmasis_irashas';
		$t_post_lt->locale = 'lt';
		$t_post_lt->status = 'published';
		$t_post_lt->content = '<p>Taigi, blogas pagaliau paleistas! Yay <i class="fa fa-birthday-cake"></i>.</p><p>Man atrodo tai jau 3 mano bandimas pakurti blog`ą - tikekimes jis bus ir paskutinis. Skirtingai nuo kitų šitas yra daugiakalbis. Kalbų perjungimo ikonkė viršje.</p><p>Pamatyti <em>source</em> kodą galima čia <a href="https://github.com/nonamez/blog" rel="nofollow">GitHub</a>. Artimiausiu metu pridėsiu įvairių "skanuminų": <em>RSS</em>, <em>administravimo panėlę</em> ir t.t., žodžiu pakursiu pilną blog`ą.</p>';
		$t_post_lt->meta_description = 'Pirmasis įrašas bloge';
		$t_post_lt->meta_keywords = 'pirmasis, pirmas, įrašas';
		
		$t_post_ru = new TranslatedPost;
		$t_post_ru->title = 'Привет, %username%!';
		$t_post_ru->slug = 'pervaja_zapis';
		$t_post_ru->locale = 'ru';
		$t_post_ru->status = 'published';
		$t_post_ru->content = '<p>Итак, блог открыт! Ура <i class="fa fa-birthday-cake"></i>.</p><p>Это уже по моему 3 мой блог - он же надеюсь и последний. В отличии от предыдущих этот - многоязычный. Для переключения иконка в верху.</p><p>Блог самописный, исходники можно глянуть тут <a href="https://github.com/nonamez/blog" rel="nofollow">GitHub</a>. В ближайшее время добавлю разных плюшек, типа <em>RSS</em>, <em>админки</em> и так далее - в общем запилю полноценный блог.</p>';
		$t_post_ru->meta_description = 'Первая запись в блоге';
		$t_post_ru->meta_keywords = 'блог, начало, первая, запись, пост';
		
		$post = new Post;

		$hello_tag  = Tag::firstOrCreate(['slug' => 'hello_world', 'name' => 'Hello World']);
		$github_tag = Tag::firstOrCreate(['slug' => 'github', 'name' => 'GitHub']);

		$post->save();
		
		$post->translated()->save($t_post_en)->tags()->sync([$hello_tag->id, $github_tag->id]);
		$post->translated()->save($t_post_lt)->tags()->sync([$hello_tag->id, $github_tag->id]);
		$post->translated()->save($t_post_ru)->tags()->sync([$hello_tag->id, $github_tag->id]);
	}
}