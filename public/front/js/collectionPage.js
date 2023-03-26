import { outputModalContact } from "./modalForm.js";

const body = document.querySelector('body');
const buttonContact = document.querySelector('.modal__table tr .modal__button__contact .modal__table__button__contact');
const buttonContactMobile = document.querySelector('.block__modal__slider__img .block__modal__header .block__img__slider .block__button__contact .button__contact__mobile');
const images = [...document.querySelectorAll('.block__list__collections .block__item__collection .block__img__collection img')];
const texts = [...document.querySelectorAll('.block__main__body .block__list__collections .block__item__collection p')];
const modalModificationText = document.querySelector('.block__modal__slider__img .block__modal__header .block__table .modal__table tr .td__desktop h3');
const modalModificationTextMobile = document.querySelector('.block__modal__slider__img .block__modal__header .block__table .modal__table tr .td__mobile h3');
const imagesClose = document.querySelector('.block__modal__slider__img .modal__table .table__close');
const modalSliderImg = document.querySelector('.block__modal__slider__img');
const counterImages = document.querySelector('.block__modal__header .block__table .modal__table .counter__images p');
const counterImagesMobile = document.querySelector('.block__modal__header .block__table .modal__table .td__mobile p');
const namesCollection = document.querySelectorAll('.block__main__body .block__name__collections .name__collection');
const modificationText = document.querySelector('.block__main__header .block__collection__text .text__links .modification');
const modificationHeaderText = document.querySelector('.block__main__header .block__collection__text h2 .modification');

namesCollection.forEach((item) => {
    item.addEventListener('click', () => {
        const nameCollectionActivated = document.querySelector('.block__main__body .block__name__collections .name__collection.link__active');
        nameCollectionActivated.classList.remove('link__active');
        item.classList.add('link__active');
        modificationText.innerHTML = `${item.outerText}`;
        modificationHeaderText.innerHTML = `${item.outerText}`;
    });

    if(item.classList.contains('link__active')) {
        modificationText.innerHTML = `${item.outerText}`;
        modificationHeaderText.innerHTML = `${item.outerText}`;
    }
});

let counter = 0;

function settingSlickSlider(initialSlide) {
    try {
        $('.collection__slider__bigImages').slick('slickGoTo', initialSlide)
            .on('beforeChange', function(event, slick, currentSlide, nextSlide){
                counterImages.innerHTML = `${nextSlide + 1} / ${images.length}`;
                counterImagesMobile.innerHTML = `${nextSlide + 1} / ${images.length}`;
                modalModificationText.innerHTML = `${texts[nextSlide].outerText}`;
                modalModificationTextMobile.innerHTML = `${texts[nextSlide].outerText}`;
            });
        $('.collection__slider__images').slick('slickGoTo', initialSlide);

    } catch (e){
        $('.collection__slider__bigImages').slick({
            arrows: true,           //Кнопки вкл/выкл,
            /*            responsive: [{
                            breakpoint: 992,
                            settings: {
                                arrows: false,
                                touchThreshold: 10
                            }
                        }, ],*/
            dots: false,             //Точки
            adaptiveHeight: false,  //Адаптивность высоты слайдов
            slidesToShow: 1,        //Количество показываемых слайдов
            slidesToScroll: 1,      //Количество слайдов при скроле
            infinite: true,         //Бесконечность слайдера
            autoplay: false,        //Автопроигрываение
            waitForAnimate: false,  //Возможность спамить переключениями слайда
            centerMode: false,       //Делает активный слайд центральным
            variableWidth: false,    //Автоматическая адаптивность слайдера
            fade: true,
            asNavFor: '.collection__slider__images',
            initialSlide: initialSlide,
            responsive: [{
                breakpoint: 991,
                settings: {
                    arrows : false,
                }
            }],
        })
            .on('beforeChange', function(event, slick, currentSlide, nextSlide){
                counterImages.innerHTML = `${nextSlide + 1} / ${images.length}`;
                counterImagesMobile.innerHTML = `${nextSlide + 1} / ${images.length}`;
                modalModificationText.innerHTML = `${texts[nextSlide].outerText}`;
                modalModificationTextMobile.innerHTML = `${texts[nextSlide].outerText}`;
            });

        $('.collection__slider__images').slick({
            arrows: false,           //Кнопки вкл/выкл,
            /*            responsive: [{
                            breakpoint: 992,
                            settings: {
                                arrows: false,
                                touchThreshold: 10
                            }
                        }, ],*/
            dots: false,             //Точки
            adaptiveHeight: false,  //Адаптивность высоты слайдов
            slidesToShow: 1,        //Количество показываемых слайдов
            slidesToScroll: 1,      //Количество слайдов при скроле
            infinite: true,         //Бесконечность слайдера
            autoplay: false,        //Автопроигрываение
            waitForAnimate: false,  //Возможность спамить переключениями слайда
            centerMode: true,       //Делает активный слайд центральным
            variableWidth: true,    //Автоматическая адаптивность слайдера
            focusOnSelect: true,
            asNavFor: '.collection__slider__bigImages',
            initialSlide: initialSlide,
        });

    }
}

images.forEach((item, i) => {
    const collectionSliderImages = document.querySelector('.block__modal__slider__img .block__modal__header .block__img__slider .block__slider__collection .collection__slider__images');
    const collectionSliderItem = document.createElement('div');
    collectionSliderItem.classList.add('collection__slider__item');
    collectionSliderItem.innerHTML = `${item.outerHTML}`;
    collectionSliderImages.append(collectionSliderItem);

    item.addEventListener('click', () => {
        counter = i + 1;
        settingSlickSlider(i);
        modalSliderImg.classList.toggle('open');
        body.classList.toggle('overflow__modal__slider');
        counterImages.innerHTML = `${counter} / ${images.length}`;
        counterImagesMobile.innerHTML = `${counter} / ${images.length}`;
        modalModificationText.innerHTML = `${texts[i].outerText}`;
        modalModificationTextMobile.innerHTML = `${texts[i].outerText}`;
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
