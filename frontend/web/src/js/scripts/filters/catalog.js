//Высота содержимого элементов фильтра
var heightFilterCatItems = document.getElementById('js-height-filter-cat-items');

if (heightFilterCatItems) {

    //ОПИСАНИЕ
    var heightBlockFilterCatItems = heightFilterCatItems.clientHeight;

    console.log(heightBlockFilterCatItems);

    if( heightBlockFilterCatItems < 291 ) {

        $(heightFilterCatItems).parent().css('height','auto');

        $(heightFilterCatItems).parent().next().css('display','none');

    } else {

        $(heightFilterCatItems).parent().next().css('display','flex');

    }

    if( heightBlockFilterCatItems < 2 ) {

        $(heightFilterCatItems).next().css('display','none');

    }

}

//Открыть дополнительный текст в ОПИСАНИИ
$(document).on('click', '.js-filter-cat-but', function () {

    $('.js-filter-cat-but').toggleClass('filter-cat__arrow--transform');
    $('.js-filter-cat-but').prev().toggleClass('filter-cat-items--show');

});