$(document).ready(function () {
    let $collectionHolder;
    const $addFileButton = $('<button type="button" class="add-btn">Dodaj plik</button>');
    const $newLinkLi = $('<li></li>').append($addFileButton);

    $(document).ready(function() {
        $collectionHolder = $('ul.photos');
        $collectionHolder.append($newLinkLi);
        $collectionHolder.data('index', $collectionHolder.find(':input').length);
        $addFileButton.on('click', function(e) {
            addFileForm($collectionHolder, $newLinkLi);
        });
    });

    function addFileForm($collectionHolder, $newLinkLi) {
        const prototype = $collectionHolder.data('prototype');
        const index = $collectionHolder.data('index');

        let newForm = prototype;
        newForm = newForm.replace(/__name__/g, index);
        $collectionHolder.data('index', index + 1);

        const $newFormLi = $('<li></li>').append(newForm);
        $newLinkLi.before($newFormLi);
        addFileFormDeleteLink($newFormLi)
    }

    function addFileFormDeleteLink($tagFormLi) {
        const $removeFormButton = $('<button type="button" class="del-btn">Usuń</button>');
        $tagFormLi.append($removeFormButton);

        $removeFormButton.on('click', function(e) {
            $tagFormLi.remove();
            $collectionHolder.data('index', index - 1);
        });
    }
});