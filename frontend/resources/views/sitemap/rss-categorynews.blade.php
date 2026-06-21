<rss xmlns:media="http://search.yahoo.com/mrss/" xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
  <channel>
    @if(!empty($articles) && (count($articles)>0))
    <title>{!! $settingsInfo->newspaper_name !!} | {!! ucwords(str_replace('-', ' ', $articles[0]->title ? $articles[0]->title : 'Latest News')) !!} | Rss Feed</title>
    <link>{!! $settingsInfo->domain !!}</link>
    <atom:link href="{!! Request::url() !!}" rel="self" type="application/rss+xml"/>
    <description>Rss News Feed For {!! ucwords(str_replace('-', ' ', $articles[0]->title ? $articles[0]->title : 'Latest News')) !!} Category</description>
    <language>bn-bd</language>
    <copyright>{{date('Y')}} {!! $settingsInfo->newspaper_name !!}</copyright>
    <lastBuildDate>{{date(DATE_RFC2822)}}</lastBuildDate>

    @foreach($articles as $key => $list)
    @php $article = \App\Models\Helper::processArticleShortly($list, 0); @endphp
    @if(!empty($article->url) && ($article->url != '#'))
    <item>
      <title>{!! $article->headline !!}</title>
      <link>{!! $article->url !!}</link>
      <guid isPermaLink="false">{!! $article->url !!}</guid>
      <pubDate>{!! date(DATE_RFC2822, strtotime($article->created_at)) !!}</pubDate>
      @if(!empty($article->thumb))
      <media:content medium="image" width="995" height="560" url="{!! $article->thumb !!}"/>
      @endif
      <description>{!! !empty($list->articleDetails) ? htmlspecialchars(strip_tags($list->articleDetails->body), ENT_QUOTES) : '' !!}</description>
    </item>
    @endif
    @endforeach
    @endif
  </channel>
</rss>