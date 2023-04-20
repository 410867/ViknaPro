import { ButtonContact, outputModalContact } from "./modalForm.js";

const body = document.querySelector('body');
const buttonContact = document.querySelector('.modal__table tr .modal__button__contact .modal__table__button__contact');
const buttonContactMobile = document.querySelector('.block__modal__slider__img .block__modal__header .block__img__slider .mobile .modal__table__button__contact');
const imagesSorted = [...document.querySelectorAll('.ourWorkCollection__item__img')];
const imagesClose = document.querySelector('.block__modal__slider__img .modal__table .table__close');
const modalSliderImg = document.querySelector('.block__modal__slider__img');
const counterImages = document.querySelector('.block__modal__header .block__table .modal__table .td__desktop p');
const counterImagesMobile = document.querySelector('.block__modal__header .block__table .modal__table .td__mobile p');
const imageList = document.querySelector('.main .block__ourWorkCollection .block__ourWorkCollection__image__list');
const videoList = document.querySelector('.main .block__ourWorkCollection .block__ourWorkCollection__video__list');
const buttonImage = document.querySelector('.block__ourWorkCollection .block__main__header .block__img__video__button .button__img');
const buttonVideo = document.querySelector('.block__ourWorkCollection .block__main__header .block__img__video__button .button__video');

let counter = 0;

buttonImage.onclick = () => {
    buttonImage.classList.add('enabled');
    buttonVideo.classList.remove('enabled');
    imageList.classList.remove('hide');
    videoList.classList.add('hide');
}

buttonVideo.onclick = () => {
    buttonVideo.classList.add('enabled');
    buttonImage.classList.remove('enabled');
    imageList.classList.add('hide');
    videoList.classList.remove('hide');
}

function settingSlickSlider(initialSlide) {
    try {
        $('.ourWorkCollection__slider__bigImages').slick('slickGoTo', initialSlide)
            .on('beforeChange', function(event, slick, currentSlide, nextSlide){
                counterImages.innerHTML = `${nextSlide + 1} / ${imagesSorted.length}`;
                counterImagesMobile.innerHTML = `${nextSlide + 1} / ${imagesSorted.length}`;
            });
        $('.ourWorkCollection__slider__images').slick('slickGoTo', initialSlide);

    } catch (e){
        $('.ourWorkCollection__slider__bigImages').slick({
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
            asNavFor: '.ourWorkCollection__slider__images',
            initialSlide: initialSlide,
            responsive: [{
                breakpoint: 991,
                settings: {
                    arrows : false,
                }
            }],
        })
            .on('beforeChange', function(event, slick, currentSlide, nextSlide){
                counterImages.innerHTML = `${nextSlide + 1} / ${imagesSorted.length}`;
                counterImagesMobile.innerHTML = `${nextSlide + 1} / ${imagesSorted.length}`;
        });

        $('.ourWorkCollection__slider__images').slick({
            arrows: false,           //Кнопки вкл/выкл,
            /*            responsive: [{
                            breakpoint: 992,
                            settings: {
                                arrows: false,
                                touchThreshold: 10
                            }
                        }, ],*/
            dots: false,             //Точки
            adaptiveHeight: true,  //Адаптивность высоты слайдов
            slidesToShow: 1,        //Количество показываемых слайдов
            slidesToScroll: 1,      //Количество слайдов при скроле
            infinite: true,         //Бесконечность слайдера
            autoplay: false,        //Автопроигрываение
            waitForAnimate: false,  //Возможность спамить переключениями слайда
            centerMode: true,       //Делает активный слайд центральным
            variableWidth: true,    //Автоматическая адаптивность слайдера
            focusOnSelect: true,
            asNavFor: '.ourWorkCollection__slider__bigImages',
            initialSlide: initialSlide,
        });
    }
}

function renderingImageForDesktop() {
    const ourWorkImagesList = document.querySelector('.main .block__ourWorkCollection .block__ourWorkCollection__image__list');
    const imagesSorted = [...document.querySelectorAll('.ourWorkCollection__item__img')];
    const lengthColumn = 5;
    let column = new Array(lengthColumn);

    for (let i = 0; i < column.length; i++) {
        column[i] = document.createElement('div');
        column[i].classList.add('column__img__ourWork__list');
    }

    ourWorkImagesList.innerHTML = ``;

    imagesSorted.forEach((item) => {
        let min = 10000000;
        let indexColumn = 0;

        column.forEach((item, index) => {
            if(item.offsetHeight < min) {
                min = item.offsetHeight;
                indexColumn = index;
            }
        });

        column[indexColumn].append(item);
        ourWorkImagesList.append(column[indexColumn]);
    });

    column.forEach((item) => {
        ourWorkImagesList.append(item);
    });
}

function renderingImageForMobileDevices() {
    const ourWorkImagesList = document.querySelector('.main .block__ourWorkCollection .block__ourWorkCollection__image__list');
    const imagesSorted = [...document.querySelectorAll('.ourWorkCollection__item__img')];
    const column1 = document.createElement('div');
    const column2 = document.createElement('div');
    column1.classList.add('column__img__ourWork__list');
    column2.classList.add('column__img__ourWork__list');

    ourWorkImagesList.innerHTML = ``;

    imagesSorted.forEach((item) => {

        if(column1.offsetHeight <= column2.offsetHeight) {
            column1.append(item);
            ourWorkImagesList.append(column1);
        } else if(column1.offsetHeight > column2.offsetHeight) {
            column2.append(item);
            ourWorkImagesList.append(column2);
        }
    });

    ourWorkImagesList.append(column1);
    ourWorkImagesList.append(column2);
}

function renderingImage() {
    imagesSorted.forEach((item, i) => {
        item.addEventListener('click', () => {
            counter = i + 1;
            settingSlickSlider(i);
            modalSliderImg.classList.toggle('open');
            body.classList.toggle('overflow__modal__slider');
            counterImages.innerHTML = `${counter} / ${imagesSorted.length}`;
            counterImagesMobile.innerHTML = `${counter} / ${imagesSorted.length}`;
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
}

ButtonContact();
renderingImage();

if(window.innerWidth > 991) {
    renderingImageForDesktop();
}
if(window.innerWidth <= 991) {
    renderingImageForMobileDevices();
}