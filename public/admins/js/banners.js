$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // 点击添加
    $('body').on('click', '#banners-add', function (e) {
        // 弹出添加模态框
        $("#banners-add-modal").modal('show');
    });

    // 点击修改
    $('body').on('click', '#banners-edit', function (e) {

        var _this = $(this);

        var url = _this.attr('data-url');
        var id = _this.attr('data-id');

        if (!url || !parseInt(id)) {
            sweetAlert("", "参数错误！", "error");
            return false;
        }

        // 循环处理数据
        $.ajax({
            url: url,
            data: {'id': id},
            type: 'get',
            success: function (res) {

                if (res.status == 200) {
                    console.log(res.data);

                    $('#banners-edit-modal').find("option[value="+res.data.category_id+"]").prop("selected",true);
                    $('#banners-edit-modal input[name=id]').val(res.data.id);
                    $('#banners-edit-modal input[name=name]').val(res.data.name);

                    // 弹出添加模态框
                    $("#banners-edit-modal").modal('show');

                } else {
                    sweetAlert("", "查询失败！", "error");
                    return false;
                }
            },
            error: function (res) {
                sweetAlert("", "查询失败！", "error");
                return false;
            }
        });
    });

    // 执行删除
    $('body').on('click', '#banners-destroy', function (e) {

        var _this = $(this);

        swal({
                title: "确定删除吗？",
                text: "你将无法恢复该虚拟文件！",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定删除！",
                closeOnConfirm: false
            },
            function(){

                var url = _this.attr('data-url');
                var id = _this.attr('data-id');

                if (!url || !parseInt(id)) {
                    sweetAlert("", "提交数据格式错误！", "error");
                    return false;
                }

                // 循环处理数据
                $.ajax({
                    url: url,
                    data: {'id' : id},
                    type: 'delete',
                    success: function (res) {

                        if (res.status == 200) {

                            _this.parent().parent().remove();
                            swal("删除成功！", "确定！","success")

                        } else {
                            sweetAlert("", "删除失败！", "error");
                            return false;
                        }
                    },
                    error: function (res) {
                        sweetAlert("", "删除失败！", "error");
                        return false;
                    }
                });

            });



    });
});