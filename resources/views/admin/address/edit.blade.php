<div id="address-edit-modal" class="modal fade" aria-labelledby="custom-width-modalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog" style="width:55%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="custom-width-modalLabel">修改省份</h4>
            </div>
            <div class="modal-body">

                <form class="cmxform form-horizontal tasi-form" action="{{ route('admin.address.update') }}" method="post"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="" />
                    <div class="form-group ">
                        <label for="cname" class="control-label col-lg-2">省份</label>
                        <div class="col-lg-10">
                            <input class=" form-control" name="province" type="text" required="" aria-required="true">
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