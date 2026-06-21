<li class="sidebar-dropdown {{ Route::currentRouteName() == 'Posts' || Route::currentRouteName() == 'Posts Create' || Route::currentRouteName() == 'Posts Edit' || Route::currentRouteName() == 'Posts Selected' || Route::currentRouteName() == 'Posts LeadTop' || Route::currentRouteName() == 'Posts MyPost' || Route::currentRouteName() == 'Posts Photos' || Route::currentRouteName() == 'Posts Videos' || Route::currentRouteName() == 'Posts Audios' || Route::currentRouteName() == 'Posts Draft' || Route::currentRouteName() == 'Posts PaidPost' ? 'active' : '' }}">
  <a href="#">
    <i class="fa fa-wifi"></i>
    <span>Post</span>
  </a>
  <div class="sidebar-submenu">
    <ul>
      <li class="{{ Route::currentRouteName() == 'Posts Create' ? 'smenu-active' : '' }}"><a href="{{route('Posts Create')}}"><i class="fa fa-plus"></i> New Post</a></li>
      <li class="{{ Route::currentRouteName() == 'Posts' || Route::currentRouteName() == 'Posts Edit' ? 'smenu-active' : '' }}"><a href="{{route('Posts')}}"><i class="fa fa-list"></i> Post List</a></li>
      <li class="{{ Route::currentRouteName() == 'Posts LeadTop' ? 'smenu-active' : '' }}"><a href="{{route('Posts LeadTop')}}"><i class="fa fa-star"></i> Lead/Top List</a></li>
      <li class="{{ Route::currentRouteName() == 'Posts Selected' ? 'smenu-active' : '' }}"><a href="{{route('Posts Selected')}}"><i class="fa fa-check"></i> Selected List</a></li>
      <li class="{{ Route::currentRouteName() == 'Posts MyPost' || Route::currentRouteName() == 'Posts Edit' ? 'smenu-active' : '' }}"><a href="{{route('Posts MyPost')}}"><i class="fa fa-edit"></i> My Post</a></li>
      <li class="{{ Route::currentRouteName() == 'Posts Draft' ? 'smenu-active' : '' }}"><a href="{{route('Posts Draft')}}"><i class="fa fa-eye"></i> Unpublished List</a></li>
      <li class="{{ Route::currentRouteName() == 'Posts Photos' ? 'smenu-active' : '' }}"><a href="{{route('Posts Photos')}}"><i class="fa fa-photo"></i> Photos List</a></li>
      <li class="{{ Route::currentRouteName() == 'Posts Videos' ? 'smenu-active' : '' }}"><a href="{{route('Posts Videos')}}"><i class="fa fa-video-camera"></i> Videos List</a></li>
      <li class="{{ Route::currentRouteName() == 'Posts Audios' ? 'smenu-active' : '' }}"><a href="{{route('Posts Audios')}}"><i class="fa fa-music"></i> Audios List</a></li>
      <li class="{{ Route::currentRouteName() == 'Posts PaidPost' ? 'smenu-active' : '' }}"><a href="{{route('Posts PaidPost')}}"><i class="fa fa-money"></i> Paid Post</a></li>
    </ul>
  </div>
</li>

<li class="sidebar-dropdown {{ Route::currentRouteName() == 'Card' ? 'smenu-active active' : '' }}">
  <a href="#">
   <i class="fa fa-line-chart"></i>
   <span>Tools</span>
 </a>
 <div class="sidebar-submenu">
   <ul>
    <li class="{{ Route::currentRouteName() == 'Card' ? 'smenu-active' : '' }}"><a href="{{ route('Card') }}"><i class="fa fa-image"></i> Cards</a></li>
  </ul>
</div>
</li>

<li class="sidebar-dropdown {{ Request::is('todayspaper') || Request::is('todayspaper/create') || Request::is('todayspaper/bulk/create') || Request::is('todayspaper/unpublished') ? 'active' : '' }}">
  <a href="#">
   <i class="fa fa-file"></i>
   <span>Todays Paper</span>
 </a>
 <div class="sidebar-submenu">
   <ul>
    <li class="{{ Request::is('todayspaper/bulk/create') ? 'smenu-active' : '' }}"><a href="{{url('todayspaper/bulk/create')}}"><i class="fa fa-plus"></i> TP Create News Bulk</a></li>
    <li class="{{ Request::is('todayspaper/create') ? 'smenu-active' : '' }}"><a href="{{url('todayspaper/create')}}"><i class="fa fa-plus"></i> TP Create News</a></li>
    <li class="{{ Request::is('todayspaper') ? 'smenu-active' : '' }}"><a href="{{url('/todayspaper')}}"><i class="fa fa-list"></i> TP News List</a></li>
    <li class="{{ Request::is('todayspaper/unpublished') ? 'smenu-active' : '' }}"><a href="{{url('todayspaper/unpublished')}}"><i class="fa fa-edit"></i> TP Publish Now</a></li>
  </ul>
</div>
</li>

<li class="{{ Request::is('breakings') ? 'smenu-active' : '' }}">
  <a href="{{url('/breakings')}}">
   <i class="fa fa-list"></i>
   <span>Breaking & Justnow</span>
 </a>
</li>

<li class="{{ Request::is('popularnews') ? 'smenu-active' : '' }}">
  <a href="{{url('/popularnews')}}">
   <i class="fa fa-paper-plane"></i>
   <span>Popular News</span>
 </a>
</li>

<li class="{{ Request::is('liveupdates') ? 'smenu-active' : '' }}">
  <a href="{{url('/liveupdates')}}">
   <i class="fa fa-bullhorn"></i>
   <span>Live Updates</span>
 </a>
</li>

<li class="{{ Request::is('polls') ? 'smenu-active' : '' }}">
  <a href="{{url('/polls')}}">
   <i class="fa fa-pie-chart"></i>
   <span>Polls</span>
 </a>
</li>

<li class="{{ Request::is('events') || Route::currentRouteName() == 'Events News' ? 'smenu-active' : '' }}">
  <a href="{{url('/events')}}">
   <i class="fa fa-tag"></i>
   <span>Events</span>
 </a>
</li>

<li class="{{ Request::is('trendingtopics') ? 'smenu-active' : '' }}">
  <a href="{{url('/trendingtopics')}}">
   <i class="fa fa-tags"></i>
   <span>Trending Topics</span>
 </a>
</li>

<li class="sidebar-dropdown {{ Route::currentRouteName() == 'Seo Post Meta' || Route::currentRouteName() == 'Settings Page' || Route::currentRouteName() == 'ArchivedTopics' ? 'smenu-active active' : '' }}">
  <a href="#">
   <i class="fa fa-bar-chart"></i>
   <span>Social & Seo</span>
 </a>
 <div class="sidebar-submenu">
   <ul>
    <li class="{{ Route::currentRouteName() == 'ArchivedTopics' ? 'smenu-active' : '' }}"><a href="{{route('ArchivedTopics')}}"><i class="fa fa-tags"></i> Topics</a></li>
    <li class="{{ Route::currentRouteName() == 'Seo Post Meta' ? 'smenu-active' : '' }}"><a href="{{route('Seo Post Meta')}}"><i class="fa fa-tags"></i> Post Meta Tags</a></li>
    <li class="{{ Route::currentRouteName() == 'Settings Page' ? 'smenu-active' : '' }}"><a href="{{route('Settings Page')}}"><i class="fa fa-file-o"></i> Page Meta Tags</a></li>
  </ul>
</div>
</li>

<li class="{{ Request::is('authors') ? 'smenu-active' : '' }}">
  <a href="{{url('/authors')}}">
   <i class="fa fa-users"></i>
   <span>Authors</span>
 </a>
</li>

<li class="{{Route::currentRouteName() == 'Elections' || Route::currentRouteName() == 'Elections Figures' || Route::currentRouteName() == 'Elections Results'  ? 'smenu-active' : '' }}">
  <a href="{{route('Elections')}}">
    <i class="fa fa-thumbs-up"></i>
    <span>Election Result</span>
  </a>
</li>

<li class="sidebar-dropdown {{ Route::currentRouteName() == 'ImportantLinks' || Route::currentRouteName() == 'ImportantLinkCategories' ? 'smenu-active active' : '' }}">
  <a href="#">
   <i class="fa fa-link"></i>
   <span>Important Links</span>
 </a>
 <div class="sidebar-submenu">
   <ul>
    <li class="{{ Route::currentRouteName() == 'ImportantLinks' ? 'smenu-active' : '' }}"><a href="{{route('ImportantLinks')}}"><i class="fa fa-link"></i> Links</a></li>
    <li class="{{ Route::currentRouteName() == 'ImportantLinkCategories' ? 'smenu-active' : '' }}"><a href="{{route('ImportantLinkCategories')}}"><i class="fa fa-tags"></i> Link Category</a></li>
  </ul>
</div>
</li>

