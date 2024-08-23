if (document.getElementById('modal')) {
    var modal = document.getElementById('modal');
    var btn = document.getElementById('modal-btn');
    var modalClose = document.getElementById('modal-close');

    btn.onclick = function () {
        modal.style.display = 'block';
    };

    modalClose.onclick = function () {
        modal.style.display = 'none';
    };

    window.onclick = function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };
}
