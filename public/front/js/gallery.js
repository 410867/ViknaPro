import { outputModalContact } from "./modalForm.js";

const buttonContact = document.querySelector('.block__windows .block__windows__text .button__contact');
buttonContact.onclick = () => {
    outputModalContact();
}