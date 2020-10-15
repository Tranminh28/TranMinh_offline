$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('#filter-bar select[name="filter_groupacp"]').change(function () {
        $('#filter-bar').submit();
    });

    $('#bulk-apply').click(function () {
        var countChecked = $('input[name="checkbox[]"]:checked').length;
        if (countChecked > 0) {
            var bulkActionValue = $('#bulk-action').val();
            var link = 'index.php?module=' + module + '&controller=' + controller;
            switch (bulkActionValue) {
                case 'active':
                    link += '&action=active';
                    if (!confirm('Bạn chắc chắn active các dòng dữ liệu đã chọn!')) return;
                    break;
                case 'inactive':
                    link += '&action=inactive';
                    if (!confirm('Bạn chắc chắn inactive các dòng dữ liệu đã chọn!')) return;
                    break;
                case 'delete':
                    link += '&action=multiDelete';
                    if (!confirm('Bạn chắc chắn xóa các dòng dữ liệu đã chọn!')) return;
                    break;
                default:
                    alert('Vui lòng chọn hành động cần thực hiện!');
                    return;
            }
            $('#form-table').attr('action', link);
            $('#form-table').submit();
        } else {
            alert('Vui lòng chọn ít nhất 1 dòng dữ liệu!');
        }
    });

    $('.btn-delete').click(function (e) {
        e.preventDefault();
        if (confirm('Bạn chắc chắn muốn xóa dữ liệu này!')) {
            window.location.href = $(this).attr('href');
        }
    });

    $('.btn-status').click(function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var btnStatus = $(this);
        $.get(
            url,
            function (data) {
                btnStatus.attr('href', data.link);
                $('.modified-' + data.id).html(data.modified);
                if (data.status == 'active') {
                    btnStatus.removeClass('btn-danger');
                    btnStatus.addClass('btn-success');
                    btnStatus.find('i').attr('class', 'fas fa-check');
                } else {
                    btnStatus.removeClass('btn-success');
                    btnStatus.addClass('btn-danger');
                    btnStatus.find('i').attr('class', 'fas fa-minus');
                }
            },
            'json'
        );
    });
});

function submitForm(link) {
    $('#admin-form').attr('action', link);
    $('#admin-form').submit();
}
