const body = document.querySelector('body');
const buttonClose = document.querySelector('.button__close');
const buttonContact = document.querySelector('.button__contact');
const contactModalWindow = document.querySelector('.modal__window__contact');
const contactModalButton = document.querySelector('.modal_button');
const modalButtonClose = document.querySelector('.modal__button__close');
const modalTitle = document.querySelector('.modal_title');
const form = document.querySelector('.form');
const imgContactButton = document.querySelector('.block__mobile__header .block__header__mobile .btn__contact__header__mobile');
const inputName = document.querySelector('.popup__content .block__form .form .block__name .input__name');
const textareaComment = document.querySelector('.popup__content .block__form .form .block__comment .textarea__comment');
const inputNumber = document.getElementById('inputNumber');
const labelRedText = document.querySelector('.popup__content .block__form .form .block__number .label__red__text');

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

    inputNumber.oninput = () => {
        if(inputNumber.value.length !== 0) {
            inputNumber.classList.add('filling__input');
        }
        setTimeout(() => {
            if (inputNumber.value.length === 0) {
                inputNumber.classList.remove('filling__input');
            }
        }, 100);
        inputNumber.classList.remove('input__empty__field');
        labelRedText.classList.add('hide');
    }
}

export const ButtonContact = () => {
    window.addEventListener('resize',function() {

        if(window.innerWidth > 991) {
            buttonContact.onclick = () => {
                outputModalContact();
            }
        }

        if(window.innerWidth <= 991) {
            imgContactButton.onclick = () => {
                outputModalContact();
            }
        }
    });

    if(window.innerWidth > 991) {
        buttonContact.onclick = () => {
            outputModalContact();
        }
    }

    if(window.innerWidth <= 991) {
        imgContactButton.onclick = () => {
            outputModalContact();
        }
    }
    IMask(
        document.querySelector('.popup__content .block__form .form .block__number .input__number'),
        {
            mask: '+{38}(000)000-00-00'
        }
    );
}

export function outputModalContact() {
    inputEvents();

    contactModalWindow.classList.add('open');
    body.classList.add('overflow__modal');
    inputNumber.classList.remove('input__empty__field');
    labelRedText.classList.add('hide');

    contactModalWindow.addEventListener('click', ({ target }) => {
        if(target.closest('.popup__body') && !target.closest('.block__form')) {
            contactModalWindow.classList.remove('open');
            body.classList.remove('overflow__modal');
            inputNumber.classList.remove('input__empty__field');
            labelRedText.classList.add('hide');
        }
    });
    buttonClose.onclick = () => {
        contactModalWindow.classList.remove('open');
        body.classList.remove('overflow__modal');
        inputNumber.classList.remove('input__empty__field');
        labelRedText.classList.add('hide');
    }

    contactModalButton.addEventListener('submit', (event) => {
        event.preventDefault();
    });

    contactModalButton.addEventListener('click', (event) => {
        inputNumber.classList.remove('input__empty__field');
        labelRedText.classList.add('hide');

        if(inputNumber.value.length !== 17) {
            inputNumber.classList.add('input__empty__field');
            labelRedText.classList.remove('hide');
            event.preventDefault();
        } else {
            event.preventDefault();
            inputName.classList.remove('filling__input');
            inputNumber.classList.remove('filling__input');
            textareaComment.classList.remove('filling__input');
            inputNumber.value = '';
            inputName.value = '';
            textareaComment.value = '';
            modalTitle.innerText = 'Сообщение отправлено';
            form.classList.add('hide');
            modalButtonClose.classList.remove('hide');

            contactModalWindow.addEventListener('click', ({target}) => {
                if (target.closest('.popup__body') && !target.closest('.block__form')) {
                    contactModalWindow.classList.remove('open');
                    body.classList.remove('overflow__modal');
                    modalTitle.innerText = 'Связаться с нами';
                    form.classList.remove('hide');
                    modalButtonClose.classList.add('hide');
                }
            });

            buttonClose.onclick = () => {
                contactModalWindow.classList.remove('open');
                body.classList.remove('overflow__modal');
                modalTitle.innerText = 'Связаться с нами';
                form.classList.remove('hide');
                modalButtonClose.classList.add('hide');
            }

            modalButtonClose.onclick = () => {
                contactModalWindow.classList.remove('open');
                body.classList.remove('overflow__modal');
                modalTitle.innerText = 'Связаться с нами';
                form.classList.remove('hide');
                modalButtonClose.classList.add('hide');
            }
        }
    });
}
