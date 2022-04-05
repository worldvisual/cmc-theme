(function (window) {
  function setImage(image) {
    const productImage = image;
    productImage.classList.add('product-img-zoom');
    productImage.style.backgroundImage = `url(${productImage.getAttribute('data-image')})`;
    productImage.style.backgroundSize = 'contain';
    productImage.style.backgroundPosition = 'center';
    productImage.style.backgroundRepeat = 'no-repeat';
    productImage.style.cursor = 'zoom-in';
  }

  if (document.querySelectorAll('.product-img').length > 0) {
    setImage(document.querySelectorAll('.product-img')[0]);
  }

  let ZOOMFACTOR = '250%';

  function init() {
    const Zoom = {};

    Zoom.init = function (config) {
      const elID = config.elementID;
      ZOOMFACTOR = config.zoomFactor || '250%';

      const container = elID !== '' ? document.getElementById(elID) : document;
      const focusImgs = container.querySelectorAll('.product-img-zoom');

      Array.from(focusImgs).forEach((img) => {
        img.addEventListener(
          'mouseenter',
          function () {
            this.style.backgroundSize = ZOOMFACTOR; // Not even a lexical 'this' :(
          },
          false,
        );

        img.addEventListener(
          'mousemove',
          function (e) {
            const imgDimensions = this.getBoundingClientRect();

            const x = e.clientX - imgDimensions.left;
            const y = e.clientY - imgDimensions.top;

            const percentX = Math.round(100 / (imgDimensions.width / x));
            const percentY = Math.round(100 / (imgDimensions.height / y));

            this.style.backgroundPosition = `${percentX}% ${percentY}%`;
          },
          false,
        );

        img.addEventListener(
          'mouseleave',
          function () {
            this.style.backgroundPosition = 'center';
            this.style.backgroundSize = 'contain';
          },
          false,
        );
      });
    };
    return Zoom;
  }

  if (typeof Zoom === 'undefined') window.Zoom = init();
}(window));

Zoom.init({
  elementID: '',
  zoomFactor: '200%',
});


/* 
	function goToContent - for product menu navigation
	search the term on the content, go to then with animation
    on menu https://www.comprarmicafetera.com/molinillos/cecotec-steelmill-2000-adjust/
	*/
window.goToContent = function (term) {
  const content = document.querySelector('.product-content');
  const elements = content.getElementsByTagName('h2');
  Array.from(elements).forEach((element) => {
    const text = element.textContent;
    if (text.indexOf(term) > -1) {
      window.scrollTo(0, element.offsetTop - 120); // 120px from header fixed
    }
  });
};
// goToContent();
