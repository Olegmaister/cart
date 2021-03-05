function prevArrow(name) {
  if (name) {
    return (
      '<button type="button" class="slick-prev"><svg class="svg-icon ' +
      name +
      '"><use xlink:href="images/sprite.svg#' +
      name +
      '"></use></svg></button>'
    );
  } else {
    return '<button type="button" class="slick-prev"></button>';
  }
}

function nextArrow(name) {
  if (name) {
    return (
      '<button type="button" class="slick-next"><svg class="svg-icon ' +
      name +
      '"><use xlink:href="images/sprite.svg#' +
      name +
      '"></use></svg></button>'
    );
  } else {
    return '<button type="button" class="slick-next"></button>';
  }
}

function twoDigits(number) {
  return number < 10 ? '0' + number : number;
}

function createYoutubeVideo(element) {
  $(element).each(function () {
    const videoId = $(this).data('id');
    const height = $(this).outerHeight();

    new YT.Player($(element)[0], {
      width: '100%',
      height: height,
      videoId: videoId,
      events: {
        'onReady': function (event) {
          event.target.playVideo();
        }
      }
    });
  });
}
