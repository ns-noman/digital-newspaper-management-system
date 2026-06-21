<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:xhtml="http://www.w3.org/1999/xhtml">
  @if(!empty($articles) && (count($articles)>0))
  @foreach($articles as $list)
  @php $article = \App\Models\Helper::processArticleShortly($list, 0); @endphp
  <url>
    <loc>{{$article->url}}</loc>
    <news:news>
      <news:publication>
        <news:name>{!! $settingsInfo->newspaper_name !!}</news:name>
        <news:language>bn</news:language>
      </news:publication>
      <news:publication_date>{{date('c', strtotime($article->created_at))}}</news:publication_date>
      <news:title>{!! $article->headline !!}</news:title>
    </news:news>
  </url>
  @endforeach
  @endif
</urlset>

