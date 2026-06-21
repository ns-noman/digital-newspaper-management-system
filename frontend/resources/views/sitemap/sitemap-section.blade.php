<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	@if(!empty($categories) && (count($categories)>0))
	@foreach($categories as $list)
	<url>
		<loc>{{url($list->title)}}</loc>
		<changefreq>hourly</changefreq>
	</url>
	@endforeach
	@endif
</urlset>