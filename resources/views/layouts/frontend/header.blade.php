@php
    use App\Models\Category;
    use App\Models\FrontMenu;
    use App\Models\News;

    $leadNews = News::select('id', 'HomepageTitle', 'NewsSummary', 'NewsCategoryID', 'Thumbimage', 'MediumImage', 'TileUrl', 'CategoryName', 'CategoryBngName', 'ImageTag', 'Date')->where(['IsActive'=>1,'IsTop'=>1])->orderBy('Priority')->orderBy('id', 'desc')->first()->toArray();
    $megamenu = FrontMenu::where(['ParentID'=>1,'IsActive'=>1])->orderBy('Priority','asc')->get()->toArray();
    $menu = FrontMenu::select('id', 'Caption as name', 'MenuLink', 'ParentID as parent_menu_id', 'LinkType')->where('MenuGroup', 1)->where('IsActive', 1)->orderBy('Priority', 'asc')->limit(100)->offset(0)->get();
@endphp
<div class="header-top-section">
    <div class="container">
	    <div class="row  hidden-xs">
		    <div class="col-md-13 col-sm-16">
			    <ul class="side-1">
				    <li><span class="gregorian-calendar"></span> | <span class="bengali-calender"></span> | <span class="arabic-date"></span></li>
					<li class="weather"></li>
				</ul>
			</div>
			<div class="col-md-11 col-sm-8 text-right">
			    <ul class="side-2">
				    <li><a target="_blank" href="http://epaper.bangladesherkhabor.net">ই- পেপার</a></li>
					<li><a href="{{ route('archives.index') }}">আর্কাইভ</a></li>
					
					<li><a class="searchtoggl"><i class="fa fa-search" aria-hidden="true"></i><span class="hidden hidden-sm"> অনুসন্ধান</span></a></li>
				</ul>								
				<div class="searchbar clearfix">
					<form class="searchform" action="{{ route('search.index') }}" method="get">						
						<input type="search" name="q"  placeholder="সার্চ..." autocomplete="off">
						<button type="submit"   class="fa fa-search searchsubmit"></button>						
					</form>
				</div>
			</div>
		</div>
		<div class="row  visible-xs">
		    <div class="col-md-12">
				<ul class="side-1">
				    <li><span class="gregorian-calendar"></span> | <span class="bengali-calender"></span> | <span class="arabic-date"></span></li>
				</ul>
				<ul class="side-2">
				    <li><a target="_blank" href="http://epaper.bangladesherkhabor.net">ই- পেপার</a></li>
					<li><a href="{{ route('archives.index') }}">আর্কাইভ</a></li>
					 
					<li><a class="searchtoggl" href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>
				</ul>
				<div class="searchbar clearfix">
					<form class="searchform" method="get" action="searchpage.php">						
						<input type="search" name="s"  placeholder="Keywords..." autocomplete="off">
						<button type="submit"   class="fa fa-search searchsubmit"></button>						
					</form>
				</div>

		    </div>
	    </div>
	</div>	
</div>
<div class="header-menu-section">
    <nav class="navbar navbar-default" id="nav">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('home.index') }}">
                    <img class="img-responsive-2" src="{{ asset('public/uploads/basic-info/logo2.png') }}" alt="বাংলাদেশের খবর">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="{{ route('categories.categories', ['todayspaper',1]) }}" class="dropdown-toggle disabled" data-toggle="dropdown">আজকের পত্রিকা<b class="caret"></b></a>
                        <div class="dropdown-menu mega-menu">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="row side-1">
                                        <div class="col-md-8">
                                            <ul>
                                                @foreach($megamenu as $key => $mega_menu)
                                                    @if($key < 5)
                                                        <li><a href="{{ route('categories.categories', explode('/',$mega_menu['MenuLink'])) }}">{{ $mega_menu['Caption'] }}</a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="col-md-8">
                                            <ul>
                                                @foreach($megamenu as $key => $mega_menu)
                                                    @if($key > 4 && $key < 10)
                                                        <li><a href="{{ route('categories.categories', explode('/',$mega_menu['MenuLink'])) }}">{{ $mega_menu['Caption'] }}</a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="col-md-8">
                                            <ul>
                                                @foreach($megamenu as $key => $mega_menu)
                                                    @if($key > 9)
                                                        <li><a href="{{ route('categories.categories', explode('/',$mega_menu['MenuLink'])) }}">{{ $mega_menu['Caption'] }}</a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-14">
                                    <div class="row side-2">
                                        <div class="col-md-12">
                                            <img src="{{ asset('public/uploads/news/'.$leadNews['MediumImage']) }}" alt="">
                                        </div>
                                        <div class="col-md-12">
                                            <h3>
                                                <li><a href="{{ route('news.news',implode('-',[$leadNews['TileUrl'],$leadNews['id']])) }}">{{ $leadNews['HomepageTitle'] }}</a></li>
                                            </h3>
                                            <p>@wordLimiter($leadNews['NewsSummary'], 25, '...')</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @php
                        global $menuItems;
                        global $parentMenuIds;

                        foreach($menu as $parentId) {
                            $parentMenuIds[] = $parentId["parent_menu_id"];
                        }

                        $menuItems = $menu;

                        function generate_menu($parent) {
                            global $menuItems;
                            global $parentMenuIds;

                            $has_childs = false;

                            foreach($menuItems as $key => $value) {
                                if ($value["parent_menu_id"] == $parent) {
                                    $menu_id = $value['id'];
                                    $menu_name = $value['name'];
                                    $menu_link = $value['MenuLink'];
                                    $LinkType = $value['LinkType'];
                                    $target = ($LinkType == 'InternalLink') ? "" : "_blank";
                                    $menu_link = route('categories.categories', explode('/',$value['MenuLink']));
                                    $class = (url()->full() == $menu_link) ? "current_menu_item" : "";
                                    if ($has_childs === false) {
                                        $has_childs = true;
                                        if ($parent != 0) {
                                            echo '<ul class="dropdown-menu">';
                                        }
                                    }

                                    if ($value["parent_menu_id"] == 0 && in_array($value["id"], $parentMenuIds)) {
                                        echo '<li class="dropdown ' . $class . '"><a class="dropdown-toggle disabled" data-toggle="dropdown" href="' . $menu_link . '">' . $value["name"] . '<span class="caret"></span></a>';
                                    } else if ($value["parent_menu_id"] != 0 && in_array($value["id"], $parentMenuIds)) {
                                        echo '<li class="dropdown-menu"><a href="' . $menu_link . '">' . $value["name"] . '</a>';
                                    } else {
                                        echo '<li class="' . $class . '"><a href="' . $menu_link . '">' . $value["name"] . '</a>';
                                    }

                                    generate_menu($value["id"]);
                                    echo '</li>';
                                }
                            }

                            if ($has_childs === true) {
                                echo '</ul>';
                            }
                        }
                        generate_menu(0);
                    @endphp
                </ul>
            </div>
        </div>
    </nav>
</div>
<div class="header-ad-section {{ isset($gallerydetailpage) ? 'gallery-page-bk hidden' : '' }}"> 
    <!-- <div class="container text-center">
	    <a href="http://www.bdg-magura.com/" target="_blank"><img src="" alt="ads"> </a>
	</div> -->
</div>
