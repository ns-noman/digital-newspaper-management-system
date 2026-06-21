<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	@if(!empty($topics) && (count($topics)>0))
	@foreach($topics as $list)
	<url>
		<loc>{!! env('Website').'/news-issue/'.$list->topic_slug !!}</loc>
	</url>
	@endforeach
	@endif
</urlset>