const getImagesRowList = (imagesSorted) => {
    if (!imagesSorted.length) {
        return [];
    }

    const row = getImagesRow(imagesSorted[0], imagesSorted.slice(1));

    return [
        row,
        ...getImagesRowList(
            arrayDiff(imagesSorted, row)
        )
    ];
}

const getImagesRow = (img, imagesSorted) => {
    let result = [img]
    let widthTotal = img.width

    imagesSorted.forEach((el) => {
        widthTotal += el.width
        if(widthTotal <= limit) {
            result.push(el);
        }
        if (widthTotal > limit) {
            widthTotal -= el.width;
        }
    })

    return result;
}

const arrayDiff = (firstArray, secondArray) => {
    return firstArray.filter(x => !secondArray.includes(x))
}

function renderImagesList() {
    setTimeout(() => {
        const imagesRowList = getImagesRowList(imagesSorted);
        const ourWorkList = document.querySelector('.block__ourWork__list');

        ourWorkList.innerHTML = ``;

        imagesRowList.forEach((item1) => {
            item1.forEach((item2, i) => {
                ourWorkList.append(item2);
            });
        });
    }, 500)
}

function limitChange() {
    renderImagesList();

    if(window.innerWidth > 1800) {
        limit = 1700;
    }

    if(window.innerWidth > 1400 && window.innerWidth <= 1600) {
        limit = 1400;
    }

    if(window.innerWidth > 1200 && window.innerWidth <= 1400) {
        limit = 1200;
    }

    if(window.innerWidth > 1000 && window.innerWidth <= 1200) {
        limit = 1000;
    }
}

let limit = 0;

window.addEventListener('resize',function() {
    limitChange();
});
limitChange();
