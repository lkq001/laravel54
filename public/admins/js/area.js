$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // 点击添加
    $('body').on('click', '#area-add', function (e) {
        var pid = $(this).attr('data-pid');
        $('input[name=name]').val('');
        $('input[name=pid]').val(pid);
        // 弹出添加模态框
        $("#area-add-modal").modal('show');
    });

    // 点击添加
    $('body').on('click', '.changeEdit', function (e) {
        var that = $(this);
        // 弹出添加模态框
        var id = that.attr('data-id');
        var name = that.attr('data-name');
        $('input[name=name]').val(name);
        $('input[name=id]').val(id);
        // 弹出添加模态框
        $("#area-edit-modal").modal('show');
    });


    // 状态修改
    $('body').on('click', '.changeStatus', function (e) {
        var that = $(this);
        // 弹出添加模态框
        var id = that.attr('data-id');

        var url = that.attr('data-url');
        var status = that.attr('data-status');

        // 循环处理数据
        $.ajax({
            url: url,
            data: {'id': id, 'status': status},
            type: 'POST',
            success: function (res) {
                if (res.status == 200) {
                    swal({
                            title: "添加成功!",
                            text: "点击确定刷新页面",
                            type: "success",
                            confirmButtonText: "确定",
                            closeOnConfirm: false
                        },
                        function () {
                            location.reload();
                        });
                } else {
                    sweetAlert("", "修改失败！", "error");
                    return false;
                }
            },
            error: function (res) {
                sweetAlert("", "查询失败！", "error");
                return false;
            }
        });

    })

    // 删除
    $('body').on('click', '.destroy', function (e) {
        var that = $(this);
        // 弹出添加模态框
        var id = that.attr('data-id');

        var url = that.attr('data-url');

        // 循环处理数据
        $.ajax({
            url: url,
            data: {'id': id},
            type: 'POST',
            success: function (res) {
                if (res.status == 200) {
                    swal({
                            title: "删除成功!",
                            text: "点击确定刷新页面",
                            type: "success",
                            confirmButtonText: "确定",
                            closeOnConfirm: false
                        },
                        function () {
                            location.reload();
                        });
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

    })


});