import { ButtonContact } from "./modalForm.js";

const body = document.querySelector('body');
const catalogList = document.querySelector('.catalog__list');
const servicesList = document.querySelector('.services__list');
const headerLine = document.querySelector('.header__line');
const blockCatalogList = document.querySelector('.block__catalog__list');
const blockServicesList = document.querySelector('.block__services__list');
const blockShadow = document.querySelector('.block__shadow');
const divMain = document.querySelector('.main');
const divFooter = document.querySelector('.block__footer');
const desktopHeader = document.querySelector('.block__desktop__header');
const mobileHeader = document.querySelector('.block__mobile__header');
const mobileHeaderMenu = document.querySelector('.block__mobile__header__menu');

ButtonContact();
dropDownList();
renderingHeader();

function renderingHeader() {
    window.addEventListener('resize',function() {
        if(window.innerWidth > 991) {
            mobileHeader.classList.add('hide');
            desktopHeader.classList.remove('hide');
        }

        if(window.innerWidth <= 991) {
            desktopHeader.classList.add('hide');
            mobileHeader.classList.remove('hide');
            dropMenuMobile();
        }
    });

    if(window.innerWidth > 991) {
        mobileHeader.classList.add('hide');
        desktopHeader.classList.remove('hide');
    }


    if(window.innerWidth <= 991) {
        desktopHeader.classList.add('hide');
        mobileHeader.classList.remove('hide');
        dropMenuMobile();
    }
}

function dropDownList() {
/*    window.addEventListener('resize',function() {
        if(window.innerWidth > 991) {
            desktopDropDownList();
        }

        if(window.innerWidth <= 991) {
            mobileDropDownList();
        }
    });*/

    if(window.innerWidth > 991) {
        desktopDropDownList();
    }

    if(window.innerWidth <= 991) {
        mobileDropDownList();
    }
}

function desktopDropDownList() {
    catalogList.addEventListener('mouseenter', () => {
        blockServicesList.classList.add('hide');
        servicesList.classList.remove('list__menu');
        showsList(catalogList);
    });

    servicesList.addEventListener('mouseenter', () => {
        blockCatalogList.classList.add('hide');
        catalogList.classList.remove('list__menu');
        showsList(servicesList);
    });

    blockShadow.addEventListener('mouseenter', () => {
        hidesList(catalogList);
        hidesList(servicesList);
    });
}

function mobileDropDownList() {
/*    const div = document.querySelectorAll('.container__img');
    const img = document.querySelectorAll('.container__img .ourWork__item__img');

    div.forEach((item, i) => {
        item.height = img[i].height;
    });*/



    const menuList = document.querySelectorAll('.block__header__menu .menu__item');
    const menuUl = document.querySelectorAll('.block__header__menu .menu__ul');
    const imgMenuList = document.querySelectorAll('.block__header__menu .menu__arrow');

    menuList.forEach((item, i) => {
        item.addEventListener('click', () => {
            menuUl[i].classList.toggle('open');
            imgMenuList[i].classList.toggle('open');
        });
    });
}

function showsList(list) {
    divMain.classList.add('pointer__events__none');
    divFooter.classList.add('pointer__events__none');
    list.classList.add('list__menu');
    headerLine.classList.remove('hide');
    blockShadow.classList.add('shadow');
    body.classList.add('overflow__list');

    if(list === catalogList) {
        blockCatalogList.classList.remove('hide');
    }
    if(list === servicesList) {
        blockServicesList.classList.remove('hide');
    }
}

function hidesList(list) {
    divMain.classList.remove('pointer__events__none');
    divFooter.classList.remove('pointer__events__none');
    list.classList.remove('list__menu');
    headerLine.classList.add('hide');
    blockShadow.classList.remove('shadow');
    body.classList.remove('overflow__list');

    if(list === catalogList) {
        blockCatalogList.classList.add('hide');
    }
    if(list === servicesList) {
        blockServicesList.classList.add('hide');
    }
}

function dropMenuMobile() {
    const menuHeaderMobileImg = document.querySelector('.menu__header__mobile__img');

    menuHeaderMobileImg.addEventListener('click', () => {
        body.classList.toggle('overflow__modal');
        mobileHeaderMenu.classList.toggle('hide');
        menuHeaderMobileImg.classList.toggle('btn__close__menu');
    });
}

