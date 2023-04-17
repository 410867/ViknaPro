const divStart = document.createElement('div');
const divEnd = document.createElement('div');
const inputNumber = document.querySelector('.footer__block__info .block__connection .block__contactUs .footer__form .footer__input__number');
const labelRedText = document.querySelector('.footer__block__info .block__connection .block__contactUs .footer__form .footer__label__red__text');
const footerFormButton = document.querySelector('.footer__block__info .block__connection .block__contactUs .footer__form .footer__form__button');
const footerSlider = document.querySelector('.footer .block__footer .footer__slider');
const sliderItems = document.querySelectorAll('.footer .block__footer .footer__slider .slider__item');
divStart.classList.add('block__start__slider');
divEnd.classList.add('block__end__slider');

IMask(
    document.querySelector('.block__contactUs .footer__form .footer__input__number'),
    {
        mask: '+{38}(000)000-00-00'
    }
);

document.getElementById('catalog_footer_button').onclick = () => {
    document.getElementById('catalog_header_button').focus()
    document.getElementById('catalog_header_button').dispatchEvent(new Event('mouseenter'))
}

function renderingSliderMobile() {

    if (sliderItems.length > 5) {
        footerSlider.innerHTML = ``;
        sliderItems.forEach((item, i) => {
            if (i >= 5) {
                return;
            }
            footerSlider.append(item);
        });
        settingSlickSlider();
    } else if (sliderItems.length > 0) {
        settingSlickSlider();
    }
    settingSlickSlider();
}

function renderingSliderDesktop() {

    if (sliderItems.length > 40) {
        footerSlider.innerHTML = ``;
        sliderItems.forEach((item, i) => {
            if (i >= 40) {
                return;
            }
            footerSlider.append(item);
        });
        settingSlickSlider();
    } else if (sliderItems.length > 0) {
        footerSlider.innerHTML = ``;
        sliderItems.forEach((item, i) => {
            if (i >= 40) {
                return;
            }
            footerSlider.append(item);
        });
        settingSlickSlider();
    }
}

function settingSlickSlider() {
    $(document).ready(function () {
        $('.footer__slider').slick({
            arrows: true,           //Кнопки вкл/выкл,
            dots: true,             //Точки
            adaptiveHeight: false,  //Адаптивность высоты слайдов
            slidesToShow: 5,        //Количество показываемых слайдов
            slidesToScroll: 5,      //Количество слайдов при скроле
            infinite: true,         //Бесконечность слайдера
            autoplay: false,        //Автопроигрываение
            waitForAnimate: false,  //Возможность спамить переключениями слайда
            centerMode: false,       //Делает активный слайд центральным
            variableWidth: true,    //Автоматическая адаптивность слайдера
            responsive: [{
                breakpoint: 991,
                settings: {
                    slidesToShow: 1,        //Количество показываемых слайдов
                    slidesToScroll: 1,      //Количество слайдов при скроле
                    centerMode: true,       //Делает активный слайд центральным
                    arrows: false,
                }
            },],
        });
    });
}

const inputEvents = () => {
    inputNumber.oninput = () => {
        inputNumber.classList.remove('input__empty__field');
        labelRedText.classList.add('hide');
    }
}

export function addingAndDeleteSliderElement() {
    if (window.innerWidth > 991) {
        divStart.classList.remove('hide');
        divEnd.classList.remove('hide');
        renderingSliderDesktop();
        setTimeout(() => {
            const slickInitialized = document.querySelector('.footer .slick-initialized');
            slickInitialized.append(divStart, divEnd);
        }, 500);
    }

    if (window.innerWidth <= 991) {
        divStart.classList.add('hide');
        divEnd.classList.add('hide');

        divStart.remove();
        divEnd.remove();

        setTimeout(() => {
            renderingSliderMobile();
        }, 500)
    }
}

footerFormButton.addEventListener('click', (event) => {
    event.preventDefault();
    inputEvents();

    inputNumber.classList.remove('input__empty__field');
    labelRedText.classList.add('hide');

    if (inputNumber.value.length !== 17) {
        inputNumber.classList.add('input__empty__field');
        labelRedText.classList.remove('hide');
        event.preventDefault();
    } else {
        event.preventDefault();
        inputNumber.classList.remove('filling__input');
        inputNumber.value = '';
    }
});
