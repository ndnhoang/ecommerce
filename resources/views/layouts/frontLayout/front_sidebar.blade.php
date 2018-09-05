<div class="left-sidebar">
    <h2>Category</h2>
    <div class="panel-group category-products" id="accordian"><!--category-productsr-->
        @foreach($categories as $category)
            <div class="panel panel-default">
                @if(count($category->categories) > 0 && $category->status == 1)
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordian" href="#{{ $category->id }}">
                                <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                {{ $category->name }}
                            </a>
                        </h4>
                    </div>
                    <div id="{{ $category->id }}" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ul>
                                @foreach($category->categories as $sub_category)
                                    @if($sub_category->status == 1)
                                        <li><a href="{{ url('/category/'.$sub_category->id) }}">{{ $sub_category->name }} </a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @elseif (count($category->categories) == 0 && $category->status == 1)
                    <div class="panel-heading">
                        <h4 class="panel-title"><a href="{{ url('/category/'.$category->id) }}">{{ $category->name }}</a></h4>
                    </div>
                @endif
            </div>
        @endforeach
    </div><!--/category-products-->

</div>
