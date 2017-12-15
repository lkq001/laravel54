<aside class="left-panel">

    <!-- brand -->
    <div class="logo">
        <a href="{{ route('admin.index') }}" class="logo-expanded">
            <i class="ion-social-buffer"></i>
            <span class="nav-label">Velonic</span>
        </a>
    </div>
    <!-- / brand -->

    <!-- Navbar Start -->
    <nav class="navigation">
        <ul class="list-unstyled">
            <li class="active"><a href="{{ route('admin.index') }}"><i class="zmdi zmdi-view-dashboard"></i> <span class="nav-label">首页</span></a>
            </li>
            <li class="has-submenu">
                <a href="#"><i class="zmdi zmdi-format-underlined"></i> <span
                            class="nav-label">卡包管理</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{ route('admin.cards.index') }}">卡包列表</a></li>
                    <li><a href="{{ route('admin.cards.category.index') }}">卡包分类</a></li>
                    <li><a href="ui-buttons.html">卡包类型</a></li>
                    <li><a href="{{ route('admin.card.excel.index') }}">导入卡包列表</a></li>
                    <li><a href="ui-icons.html">用卡计划列表</a></li>
                </ul>
            </li>
            <li class="has-submenu"><a href="#"><i class="zmdi zmdi-album"></i> <span
                            class="nav-label">订单管理</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="components-grid.html">订单列表</a></li>
                </ul>
            </li>
            <li class="has-submenu"><a href="#"><i class="zmdi zmdi-collection-text"></i> <span
                            class="nav-label">用户管理</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="form-elements.html">用户列表</a></li>
                </ul>
            </li>
            <li class="has-submenu"><a href="#"><i class="zmdi zmdi-format-list-bulleted"></i> <span class="nav-label">管理员管理</span><span
                            class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="tables.html">管理员列表</a></li>
                </ul>
            </li>
            <li class="has-submenu"><a href="#"><i class="zmdi zmdi-chart"></i> <span
                            class="nav-label">广告管理</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="charts-morris.html">广告位列表</a></li>
                    <li><a href="charts-chartjs.html">图片广告</a></li>
                    <li><a href="charts-flot.html">文字广告</a></li>
                </ul>
            </li>
        </ul>
    </nav>

</aside>