<div id="users-add-modal" class="modal fade" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width:55%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="custom-width-modalLabel">添加分类</h4>
            </div>
            <div class="modal-body">

                <form class="cmxform form-horizontal tasi-form" id="users-add-form" method="post">
                    <div class="form-group ">
                        <label for="cname" class="control-label col-lg-2">分类名称</label>
                        <div class="col-lg-10">
                            <input class=" form-control" name="name" type="text" required="" aria-required="true">
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" id="users-add-submit" data-url="{{ route('admin.users.store') }}" class="btn btn-primary">保存</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>