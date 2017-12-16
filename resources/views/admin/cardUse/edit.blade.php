<div id="cards-edit-modal" class="modal fade" aria-labelledby="custom-width-modalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog" style="width:55%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="custom-width-modalLabel">添加宅配卡</h4>
            </div>
            <div class="modal-body">

                <form class="cmxform form-horizontal tasi-form" action="{{ route('admin.cards.update') }}" method="post"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="" />
                    <div class=" form-group">
                        <label for="cname" class="control-label col-lg-2">分类选择</label>
                        <div class="col-lg-10">
                            <select class="form-control" name="category_id">
                                @if(count($categorys) > 0)
                                    @foreach($categorys as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @else
                                    <option value="0">请添加分类</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="cname" class="control-label col-lg-2">宅配卡名称</label>
                        <div class="col-lg-10">
                            <input class=" form-control" name="name" type="text" required="" aria-required="true">
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="cname" class="control-label col-lg-2">价格</label>
                        <div class="col-lg-10">
                            <input class=" form-control" name="price" type="text" required="" aria-required="true">
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="cname" class="control-label col-lg-2">次数</label>
                        <div class="col-lg-10">
                            <input class=" form-control" name="number" type="text" required="" aria-required="true">
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="cname" class="control-label col-lg-2">图片</label>
                        <div class="col-lg-10">
                            <input class=" form-control" name="image" type="file" />
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="cname" class="control-label col-lg-2">宅配卡描述</label>
                        <div class="col-lg-10">
                            <div id="editueditor" class="edui-default">
                                @include('UEditor::head')
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <input type="submit" class="btn btn-primary" value="修改"/>
                    </div>
                </form>


            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>