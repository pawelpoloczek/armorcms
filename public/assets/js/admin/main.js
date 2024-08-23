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
            "language": {"url": "/assets/js/admin/dataTables.polish.lang"},
            "lengthMenu": [ 10, 25, 50, 100 ],
            "order": [[ 1, "desc" ]]
        });
    }

    $('.tooltip').tooltipster({
        animation: 'fade',
        delay: 200,
        theme: 'tooltipster-borderless',
        trigger: 'click',
        maxWidth: 600
    });
});