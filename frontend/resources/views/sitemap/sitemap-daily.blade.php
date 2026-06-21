<urlset xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	@if(!empty($articles) && (count($articles)>0))
	@foreach($articles as $list)
	@php $article = \App\Models\Helper::processArticleShortly($list, 0); @endphp
	<url>
		<loc>{!! $article->url !!}</loc>
		<image:image>
			<image:loc>{!! $article->thumb !!}</image:loc>
			<image:caption>
				<![CDATA[ {{$article->headline}} ]]>
			</image:caption>
		</image:image>
		<changefreq>hourly</changefreq>
		<lastmod>{{date('c', strtotime($article->created_at))}}</lastmod>
	</url>
	@endforeach
	@endif
</urlset>