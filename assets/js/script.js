(() => { 
  /*
  scripts to control the menu
  */
  const openNavMenu = document.querySelector('.open-nav-menu');
  const closeNavMenu = document.querySelector('.close-nav-menu');
  const navMenu = document.querySelector('.nav-menu');
  const menuOverlay = document.querySelector('.menu-overlay');
  const mediaSize = 991;

  const toggleNav = () => {
    navMenu.classList.toggle('open');
    menuOverlay.classList.toggle('active');
    document.body.classList.toggle('hidden-scrolling');
  };

  const collapseSubMenu = () => {
    navMenu
      .querySelector('.menu-item-has-children.active .sub-menu')
      .removeAttribute('style');
    navMenu
      .querySelector('.menu-item-has-children.active')
      .classList.remove('active');
  };

  openNavMenu.addEventListener('click', toggleNav);
  closeNavMenu.addEventListener('click', toggleNav);
  // close the navMenu by clicking outside
  menuOverlay.addEventListener('click', toggleNav);

  navMenu.addEventListener('click', (event) => {
    if (
      event.target.hasAttribute('data-toggle') && window.innerWidth <= mediaSize
    ) {
      // prevent default anchor click behavior
      event.preventDefault();
      const menuItemHasChildren = event.target.parentElement;
      // if menuItemHasChildren is already expanded, collapse it
      if (menuItemHasChildren.classList.contains('active')) {
        collapseSubMenu();
      } else {
        // collapse existing expanded menuItemHasChildren
        if (navMenu.querySelector('.menu-item-has-children.active')) {
          collapseSubMenu();
        }
        // expand new menuItemHasChildren
        menuItemHasChildren.classList.add('active');
        const subMenu = menuItemHasChildren.querySelector('.sub-menu');
        subMenu.style.maxHeight = `${subMenu.scrollHeight}px`;
      }
    }
  });

  const resizeFix = () => {
    if (this.innerWidth > mediaSize) {
      // if navMenu is open ,close it
      if (navMenu.classList.contains('open')) {
        toggleNav();
      }
      // if menuItemHasChildren is expanded , collapse it
      if (navMenu.querySelector('.menu-item-has-children.active')) {
        collapseSubMenu();
      }
    }
  };

  window.addEventListener('resize', resizeFix());
})();

/* newsletter button click */
const subscribeBtn = document.getElementById('subscribe-btn');
const subscriberSuccessAlert = document.getElementById('subscriber-text');
const subscriberEmailInput = document.getElementById('subscribe-email-input');

const subscribeNow = () => {
  const checkEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

  if (checkEmail.test(String(subscriberEmailInput.value).toLowerCase())) {
    subscriberSuccessAlert.style.display = 'block';
    subscriberEmailInput.value = '';
  } else {
    subscriberSuccessAlert.style.display = 'none';
  }
};

// subscribeBtn.addEventListener('click', subscribeNow);
