import { outputModalContact } from "./modalForm.js";

const saveBlockProduction = document.querySelector('.block__main__production .block__production');
const buttonAddReview = document.querySelector('.block__main__slider__comments .block__slider__comments .btn__add__review');
const openingModal1 = document.querySelector('.main .block__header__main .block__background__text .block__text .text__link');
const openingModal2 = document.querySelector('.block__main__invitation .block__invitation .block__invitation__text button');
const body = document.querySelector('body');
const modalTitle = document.querySelector('.modal__window__review .popup__body .popup__content .block__form .modal_title');
const form = document.querySelector('.form__review');
const inputName = document.querySelector('.popup__content .block__form .form__review .block__name .input__name');
const textareaComment = document.querySelector('.popup__content .block__form .form__review .block__comment .textarea__comment');
const contactModalWindow = document.querySelector('.modal__window__review');
const contactModalButton = document.querySelector('.modal_button__post__review');
const buttonClose = document.querySelector('.modal__window__review .popup__body .popup__content .button__close.review');
const modalButtonClose = document.querySelector('.modal__window__review .popup__body .popup__content .block__form .modal__review__button__close');

export function blockServicesItemHover() {
    const blockServices = document.querySelectorAll('.block__services__item');
    const images = document.querySelectorAll('.block__services__item img');

    blockServices.forEach((serviceItem, i) => {
        addMouseEnterServiceItem(serviceItem, images, i);
        addMouseLeaveServiceItem(serviceItem, images, i);
        serviceItem.onclick = () => {
            location.href = serviceItem.getAttribute('data-href');
        }
    });
}

function addMouseEnterServiceItem(serviceItem, images, i) {
    serviceItem.addEventListener('mouseenter', () => {
        serviceItem.classList.add('block__services__item__hover');
        images[i].classList.add('img__arrow__right__hover');
    });
}

function addMouseLeaveServiceItem(serviceItem, images, i) {
    serviceItem.addEventListener('mouseleave', () => {
        serviceItem.classList.remove('block__services__item__hover');
        images[i].classList.remove('img__arrow__right__hover');
    });
}

function settingMainCommentSlickSlider() {
    $(document).ready(function () {
        $('.main__slider').slick({
            arrows: true,           //Кнопки вкл/выкл,
            dots: true,             //Точки
            adaptiveHeight: false,  //Адаптивность высоты слайдов
            slidesToShow: 2,        //Количество показываемых слайдов
            slidesToScroll: 2,      //Количество слайдов при скроле
            infinite: true,         //Бесконечность слайдера
            autoplay: false,        //Автопроигрываение
            waitForAnimate: false,  //Возможность спамить переключениями слайда
            centerMode: false,       //Делает активный слайд центральным
            variableWidth: false,    //Автоматическая адаптивность слайдера
            responsive: [{
                breakpoint: 991,
                settings: {
                    arrows : false,
                    variableWidth: true,
                    slidesToScroll: 1,
                    touchThreshold: 10,
                }
            }],
        });
    });
}

function settingMainProductionSlickSlider() {
    $(document).ready(function () {
        $('.block__production__list').slick({
            arrows: false,           //Кнопки вкл/выкл,
            dots: true,             //Точки
            adaptiveHeight: false,  //Адаптивность высоты слайдов
            slidesToShow: 1,        //Количество показываемых слайдов
            slidesToScroll: 1,      //Количество слайдов при скроле
            infinite: true,         //Бесконечность слайдера
            autoplay: false,        //Автопроигрываение
            waitForAnimate: false,  //Возможность спамить переключениями слайда
            centerMode: false,       //Делает активный слайд центральным
            variableWidth: true,    //Автоматическая адаптивность слайдера
            touchThreshold: 10,
        });
    });
}

function deleteMainProductionSlider() {
    const blockProduction = document.querySelector('.block__main__production');
    blockProduction.innerHTML = `${saveBlockProduction.outerHTML}`;
}

function settingMainProduction() {
    window.addEventListener('resize',function() {
        if(window.innerWidth > 991) {
            deleteMainProductionSlider();
        }
        if(window.innerWidth <= 991) {
            settingMainProductionSlickSlider();
        }
    });

    if(window.innerWidth > 991) {
        deleteMainProductionSlider();
    }
    if(window.innerWidth <= 991) {
        settingMainProductionSlickSlider();
    }
}

const inputEvents = () => {
    inputName.oninput = () => {
        if(inputName.value.length !== 0) {
            inputName.classList.add('filling__input');
        } else {
            inputName.classList.remove('filling__input');
        }
    }

    textareaComment.oninput = () => {
        if(textareaComment.value.length !== 0) {
            textareaComment.classList.add('filling__input');
        } else {
            textareaComment.classList.remove('filling__input');
        }
    }
}

function outputModalReview() {
    inputEvents();

    contactModalWindow.classList.add('open');
    body.classList.add('overflow__modal');

    contactModalWindow.addEventListener('click', ({ target }) => {
        if(target.closest('.popup__body') && !target.closest('.block__form')) {
            contactModalWindow.classList.remove('open');
            body.classList.remove('overflow__modal');
        }
    });
    buttonClose.onclick = () => {
        contactModalWindow.classList.remove('open');
        body.classList.remove('overflow__modal');
    }

    contactModalButton.addEventListener('submit', (event) => {
        event.preventDefault();
    });

    contactModalButton.addEventListener('click', (event) => {
        event.preventDefault();
        inputName.classList.remove('filling__input');
        textareaComment.classList.remove('filling__input');
        inputName.value = '';
        textareaComment.value = '';
        modalTitle.innerText = 'Отзыв отправлено';
        form.classList.add('hide');
        modalButtonClose.classList.remove('hide');

        contactModalWindow.addEventListener('click', ({target}) => {
            if (target.closest('.popup__body') && !target.closest('.block__form')) {
                contactModalWindow.classList.remove('open');
                body.classList.remove('overflow__modal');
                modalTitle.innerText = 'Оставить отзыв';
                form.classList.remove('hide');
                modalButtonClose.classList.add('hide');
            }
        });

        buttonClose.onclick = () => {
            contactModalWindow.classList.remove('open');
            body.classList.remove('overflow__modal');
            modalTitle.innerText = 'Оставить отзыв';
            form.classList.remove('hide');
            modalButtonClose.classList.add('hide');
        }

        modalButtonClose.onclick = () => {
            contactModalWindow.classList.remove('open');
            body.classList.remove('overflow__modal');
            modalTitle.innerText = 'Оставить отзыв';
            form.classList.remove('hide');
            modalButtonClose.classList.add('hide');
        }

    });
}



blockServicesItemHover();
settingMainCommentSlickSlider();
settingMainProduction();
buttonAddReview.onclick = () => {
    outputModalReview();
}
openingModal1.addEventListener('click', () => {
    outputModalContact();
});
openingModal2.addEventListener('click', () => {
    outputModalContact();
});
