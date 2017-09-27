<?xml version="1.0" encoding="UTF-8" ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	@foreach($posts as $post)
	<sitemap>
		<loc>{{ route('sitemap.posts', $post->locale) }}</loc>
		<lastmod>{{ $post->updated_at->tz('UTC')->toAtomString() }}</lastmod>
	</sitemap>
	@endforeach
</sitemapindex>