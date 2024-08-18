document.addEventListener('DOMContentLoaded', function () {
    const list = document.querySelector('#foods-list ul');
    const addButton = document.createElement('button');
    addButton.type = 'button';
    addButton.innerText = 'Ajouter un aliment';

    list.append(addButton);

    addButton.addEventListener('click', function () {
        const prototype = list.dataset.prototype;
        const index = list.children.length - 1; // -1 to exclude the add button itself
        const newForm = prototype.replace(/__name__/g, index);

        const newLi = document.createElement('li');
        newLi.innerHTML = newForm;
        list.insertBefore(newLi, addButton);
    });
});
