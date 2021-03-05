// setTimeout(initLoader, 400);

initLoader();
function initLoader() {
  var body = document.querySelector('body');
  body.classList.remove('loader-is-run');
  body.querySelector('.loader').remove();
}
