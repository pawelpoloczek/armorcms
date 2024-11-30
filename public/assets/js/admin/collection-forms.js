function addTagFormDeleteLink(item) {
    const removeFormButton = document.createElement('button');
    removeFormButton.innerHTML = '<i class="fa fa-times" aria-hidden="true"></i>';

    item.append(removeFormButton);

    removeFormButton.addEventListener('click', (e) => {
        e.preventDefault();
        // remove the li for the tag form
        item.remove();
    });
}

function addFormToCollection(e) {
    const collectionHolder = document.querySelector(
        '.' + e.currentTarget.dataset.collectionHolderClass
    );
    const item = document.createElement('li');

    item.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(
            /__name__/g,
            collectionHolder.dataset.index
        );

    collectionHolder.appendChild(item);
    collectionHolder.dataset.index++;
    addTagFormDeleteLink(item);
}

document
    .querySelectorAll('ul.collection li')
    .forEach((tag) => {
        addTagFormDeleteLink(tag)
    })

document
    .querySelectorAll('.collection-btn')
    .forEach(btn => {
        btn.addEventListener("click", addFormToCollection)
    });