/*
import { blockServicesItemHover } from "./index.js";
*/

blockServicesItemHover();

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


blockServicesItemHover();