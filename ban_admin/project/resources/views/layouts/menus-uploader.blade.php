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

<li class="{{ Request::is('polls') ? 'smenu-active' : '' }}">
  <a href="{{url('/polls')}}">
   <i class="fa fa-pie-chart"></i>
   <span>Polls</span>
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