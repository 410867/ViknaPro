import { outputModalContact } from "./modalForm.js";

const buttonModalContact = document.querySelector('.block__contacts .block__contacts__text .button__contact');
const headerTop = document.querySelector('.header__top');
headerTop.classList.add('hide');

buttonModalContact.addEventListener('click', () => {
    outputModalContact();
});

