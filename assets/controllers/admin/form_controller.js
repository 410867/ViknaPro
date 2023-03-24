import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {}
    remove(event){
        document.getElementById(event.params.id).remove()
    }
};