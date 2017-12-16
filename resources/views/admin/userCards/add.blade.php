<div id="user-cards-add-modal" class="modal fade" aria-labelledby="custom-width-modalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog" style="width:55%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="custom-width-modalLabel">添加宅配卡</h4>
            </div>
            <div class="modal-body">

                <form class="cmxform form-horizontal tasi-form" action="{{ route('admin.user.cards.store') }}" method="post"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
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
                            <input class=" form-control" name="image" type="file" required="" aria-required="true">
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="cname" class="control-label col-lg-2">宅配卡描述</label>
                        <div class="col-lg-10">
                            <div id="ueditor" class="edui-default">
                                @include('UEditor::head')
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <input type="submit" class="btn btn-primary" value="添加"/>
                    </div>
                </form>


            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>