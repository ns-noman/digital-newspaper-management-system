<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	@if(!empty($articles) && (count($articles)>0))
	@foreach($articles as $list)
	@php $article = \App\Models\Helper::processArticleShortly($list, 0); @endphp
	<url>
		<loc>{!! $article->url !!}</loc>
	</url>
	@endforeach
	@endif
</urlset>