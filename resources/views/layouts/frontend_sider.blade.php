<div class="col-md-4 sider-info">
    <div class="row">
        <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header  bg-black">
                <h3 class="widget-user-username">{{ $config['site_admin'] }}</h3>
                <h5 class="widget-user-desc">{{ $config['site_admin_info'] }}</h5>
            </div>
            <div class="widget-user-image">
                <img class="img-circle" src="{{asset('adminlte/dist/img/user1-128x128.jpg')}}" alt="用户头像">
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header"><i
                        class="fa fa-github-alt"></i></h5>
                            <span class="description-text"><a class="" href="{{ $config['site_admin_github'] }}">码云</a></span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header"><i
                        class="fa fa-weibo"></i></h5>
                            <span class="description-text"><a class="" href="{{ $config['site_admin_weibo'] }}">微博</a></span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                        <div class="description-block">
                            <h5 class="description-header"><i class="fa fa-envelope"></i></h5>
                            <span class="description-text"><a class="" href="{{ $config['site_admin_mail'] }}">邮箱</a></span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-arrow-up"></i>

                <h3 class="box-title">热门文章</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <ul class="list-group list-group-unbordered">
                    @foreach($article_list as $article)
                        <li class="list-group-item">
                            <i class="fa fa-hand-o-right"></i>
                            <a href="{{route('article',$article->id)}}"
                                class="">{{$article->title}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="row">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-tags"></i>

                <h3 class="box-title">标签云</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @foreach($tag_list as $t_list)
                <a href="{{route('tag',$t_list->id)}}" @switch(($t_list->id)%5) @case(0)class="tag btn btn-flat btn-xs bg-black" @break @case(1)class="tag btn btn-flat btn-xs bg-olive" @break @case(2)class="tag
                    btn btn-flat btn-xs bg-navy" @break @case(3)class="tag btn btn-flat btn-xs bg-purple" @break @default class="tag btn btn-flat btn-xs
                    bg-maroon" @endswitch>{{$t_list->name}}
                </a>
                @endforeach
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="row">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-link"></i>

                <h3 class="box-title">友情链接</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @foreach( $link_list as $l_list)
                <!-- <span class="simple_tag"> -->
                    <a href="{{$l_list->url}}" class="tag btn btn-flat btn-sm bg-navy" target="_blank">{{$l_list->name}}</a>
                <!-- </span> -->
                @endforeach
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="row">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-search"></i>

                <h3 class="box-title">全站搜索</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form action="{{route('search')}}" method="get">
                    <div class="form-group">
                        <input type="text" class="form-control" name="keyword" placeholder="搜索">
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>
