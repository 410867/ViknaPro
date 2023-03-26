import { outputModalContact } from "./modalForm.js";

const body = document.querySelector('body');
const buttonContact = document.querySelector('.modal__table tr .modal__button__contact .modal__table__button__contact');
const buttonContactMobile = document.querySelector('.block__modal__img .block__modal__header .block__button__contact .button__contact__mobile');
const images = [...document.querySelectorAll('.block__accessories__list .block__accessories__item .block__accessories__img img')];
const accessoriesNames = [...document.querySelectorAll('.block__accessories .block__accessories__list .block__accessories__item .accessories__text')];
const modalModificationText = document.querySelector('.block__modal__img .block__modal__header .block__table .modal__table tr .td__desktop h3');
const imagesClose = document.querySelector('.block__modal__img .modal__table .table__close');
const modalSliderImg = document.querySelector('.block__modal__img');

images.forEach((item, i) => {
    item.addEventListener('click', () => {
        const blockAccessoriesImages = document.querySelector('.block__modal__img .block__modal__header .block__img');
        const accessoriesNameMobile = document.createElement('p');
        const img = document.createElement('img');
        blockAccessoriesImages.innerHTML = ``;
        img.src = item.src;
        blockAccessoriesImages.append(img);
        blockAccessoriesImages.append(accessoriesNameMobile);
        modalModificationText.innerHTML = `${accessoriesNames[i].outerText}`;
        accessoriesNameMobile.innerHTML = `${accessoriesNames[i].outerText}`;

        modalSliderImg.classList.toggle('open');
        body.classList.toggle('overflow__modal__slider');
    });
});

imagesClose.addEventListener('click', () => {
    modalSliderImg.classList.toggle('open');
    body.classList.toggle('overflow__modal__slider');
});

buttonContact.addEventListener('click', () => {
    outputModalContact();
});

buttonContactMobile.addEventListener('click', () => {
    outputModalContact();
});

