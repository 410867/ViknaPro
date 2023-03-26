settingSliders();

function settingSliders() {
    $(document).ready(function () {
        $('.slider_1').slick({
            arrows: true,           //Кнопки вкл/выкл,
            dots: false,             //Точки
            adaptiveHeight: true,  //Адаптивность высоты слайдов
            slidesToShow: 2,        //Количество показываемых слайдов
            slidesToScroll: 1,      //Количество слайдов при скроле
            infinite: true,         //Бесконечность слайдера
            autoplay: false,        //Автопроигрываение
            waitForAnimate: false,  //Возможность спамить переключениями слайда
            centerMode: true,       //Делает активный слайд центральным
            variableWidth: true,    //Автоматическая адаптивность слайдера
            responsive: [{
                breakpoint: 991,
                settings: {
                    arrows : false,
                    centerMode: false,
                }
            }],
        });
    });

    $(document).ready(function () {
        $('.slider_2').slick({
            arrows: true,           //Кнопки вкл/выкл,
            dots: false,             //Точки
            adaptiveHeight: true,  //Адаптивность высоты слайдов
            slidesToShow: 2,        //Количество показываемых слайдов
            slidesToScroll: 1,      //Количество слайдов при скроле
            infinite: true,         //Бесконечность слайдера
            autoplay: false,        //Автопроигрываение
            waitForAnimate: false,  //Возможность спамить переключениями слайда
            centerMode: true,       //Делает активный слайд центральным
            variableWidth: true,    //Автоматическая адаптивность слайдера
            responsive: [{
                breakpoint: 991,
                settings: {
                    arrows : false,
                    centerMode: false,
                }
            }],
        });
    });

    $(document).ready(function () {
        $('.slider_3').slick({
            arrows: true,           //Кнопки вкл/выкл,
            dots: false,             //Точки
            adaptiveHeight: true,  //Адаптивность высоты слайдов
            slidesToShow: 2,        //Количество показываемых слайдов
            slidesToScroll: 1,      //Количество слайдов при скроле
            infinite: true,         //Бесконечность слайдера
            autoplay: false,        //Автопроигрываение
            waitForAnimate: false,  //Возможность спамить переключениями слайда
            centerMode: true,       //Делает активный слайд центральным
            variableWidth: true,    //Автоматическая адаптивность слайдера
            responsive: [{
                breakpoint: 991,
                settings: {
                    arrows : false,
                    centerMode: false,
                }
            }],
        });
    });
}