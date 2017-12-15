<div id="cards-excel-import-modal" class="modal fade" aria-labelledby="custom-width-modalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog" style="width:55%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="custom-width-modalLabel">导入数据</h4>
            </div>
            <div class="modal-body">

                <form class="cmxform form-horizontal tasi-form" action="{{ route('admin.card.excel.import') }}"
                      method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group ">
                        <label for="cname" class="control-label col-lg-2">导入数据</label>
                        <div class="col-lg-10">
                            <input id="fileId1" type="file" class=" form-control"
                                   accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                   name="excel"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <input type="submit" value="导入"/>
                    </div>
                </form>

            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>