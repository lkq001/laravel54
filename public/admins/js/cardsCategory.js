$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // 点击添加
    $('body').on('click', '#cards-category-add', function (e) {
        // 弹出添加模态框
        $("#cards-category-add-modal").modal('show');
    });

    // 点击添加保存
    $('body').on('click', '#cards-category-add-submit', function (e) {
        var _this = $(this);

        var url = _this.attr('data-url');
        var data = $('#cards-category-add-form').serializeArray();

        var postData = postDataFunction(data);

        if (!postData['name']) {
            sweetAlert("", "分类名称不能为空！", "error");
            return false;
        }

        // 循环处理数据
        $.ajax({
            url: url,
            data: data,
            type: 'post',
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
                    sweetAlert("", "添加失败！", "error");
                    return false;
                }
            },
            error: function (res) {
                sweetAlert("", "添加失败！", "error");
                return false;
            }
        });

    });

    // 宅配卡编辑
    $('body').on('click', '#card-categorys-edit', function (e) {
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

                    $('#cards-category-edit-modal input[name=id]').val(res.data.id);
                    $('#cards-category-edit-modal input[name=name]').val(res.data.name);

                    $("#cards-category-edit-modal").modal('show');

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

    // 执行修改
    $('body').on('click', '#cards-category-update-submit', function (e) {
        var _this = $(this);

        var url = _this.attr('data-url');
        var data = $('#cards-category-edit-form').serializeArray();

        var postData = postDataFunction(data);

        if (!postData['name'] || !url || !postData['id']) {
            sweetAlert("", "提交数据格式错误！", "error");
            return false;
        }

        // 循环处理数据
        $.ajax({
            url: url,
            data: data,
            type: 'put',
            success: function (res) {
                if (res.status == 200) {

                    swal({
                            title: "修改成功!",
                            text: "点击确定刷新页面",
                            type: "success",
                            confirmButtonText: "确定",
                            closeOnConfirm: false
                        },
                        function () {
                            location.reload();
                        });

                } else {
                    sweetAlert("", "添加失败！", "error");
                    return false;
                }
            },
            error: function (res) {
                sweetAlert("", "添加失败！", "error");
                return false;
            }
        });

    });

    // 执行删除
    $('body').on('click', '#card-categorys-destroy', function (e) {

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

    function postDataFunction(data) {

        if (data) {
            var postData = [];

            $.each(data, function (k, v) {
                postData[this.name] = this.value;
            });

            return postData;
        } else {
            return [];
        }

    }

});