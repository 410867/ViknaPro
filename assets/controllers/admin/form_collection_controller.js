import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["collectionContainer"]

    static values = {
        index    : Number,
        prototype: String,
    }

    remove(event){
        document.getElementById(event.params.id).remove()
    }

    addCollectionElement(event)
    {
        const row = document.getElementById(event.params.id)
        const index = Number(row.getAttribute('data-index'))
        const item = row.getAttribute('data-prototype').replace(/__name__/g, String(index))

        $(row).append($(item))

        row.setAttribute('data-index', String(index + 1))
    }
};