/**
 * Created by Admin on 1/3/2018.
 */
$(document).on("ready", function () {
    $('[data-toggle=confirmation]').confirm({
        title: 'Xóa bản ghi?',
        theme: 'dark',
        icon: 'fa fa-question',
        content: 'Bạn có chắc chắc muốn xóa bản ghi này ? Mọi dữ liệu đã xóa không thể khôi phục lại.',
        autoClose: 'cancel|10000',
        buttons: {
            confirm: {
                text: 'Xác nhận',
                action: function (e) {
                    window.location.href = this.$target.attr('data-url');
                }
            },
            cancel: function () {
            }
        }
    })
})