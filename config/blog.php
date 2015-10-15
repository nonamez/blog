<?php

return array(
	'allowed_files'    => ['jpeg', 'bmp', 'png', 'zip', 'pdf'],
	'tags_in_header'   => 10,
	'posts_per_page'   => 10,
	'google_analytics' => env('GOOGLE_ANALYTICS', FALSE),
	'disqus_shortname' => env('DISQUS_SHORTNAME', FALSE),
	'disqus_publickey' => env('DISQUS_PUBLICKEY', FALSE)
);