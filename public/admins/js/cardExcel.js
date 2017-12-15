$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // 点击添加
    $('body').on('click', '#cards-excel-import', function (e) {
        // 弹出添加模态框
        $("#cards-excel-import-modal").modal('show');
    });
});