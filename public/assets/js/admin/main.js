$(document).ready(function () {
    const msgClose = $('.msg-close');
    if (msgClose.length) {
        msgClose.click(function () {
            $(this).parent().slideUp();
        });
    }

    const dataTable = $('#dataTable');
    if (dataTable.length) {
        dataTable.DataTable({
            "language": {"url": "/assets/plugins/jquery/dataTables.polish.lang"},
            "lengthMenu": [ 10, 25, 50, 100 ],
            "order": [[ 1, "desc" ]]
        });
    }
});