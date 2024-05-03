// SIDEBAR
const menuItems = document.querySelectorAll('.menu-item');

const changeActiveItem = () => {
  menuItems.forEach((item) => {
    item.classList.remove('active');
  });
};

menuItems.forEach((item) => {
  item.addEventListener('click', () => {
    changeActiveItem();
    item.classList.add('active');

    // Hide all other popups
    document.querySelectorAll('.notifications-popup').forEach((popup) => {
      if (popup !== item.querySelector('.notifications-popup')) {
        popup.style.display = 'none';
      }
    });

    const notificationsPopup = item.querySelector('.notifications-popup');

    if (notificationsPopup && notificationsPopup.style.display === 'block') {
      notificationsPopup.style.display = 'none';
    } else if (notificationsPopup) {
      notificationsPopup.style.display = 'block';
      // Clear notification count
      const notificationCount = item.querySelector('.notification-count');
      if (notificationCount) {
        notificationCount.textContent = ''; // Clear content
        notificationCount.style.backgroundColor = 'transparent'; // Remove background color
      }
    }
  });
});

/* ================================== MESSAGES ===========================*/
const messagesNotification = document.querySelector('#messages-notification');
const messages = document.querySelectorAll('.messages');

messagesNotification.addEventListener('click', () => {
  messages.forEach((message) => {
    message.style.boxShadow = '0 0 1rem var(--color-primary)';
    messagesNotification.querySelector('.notification-count').style.display =
      'none';
    setTimeout(() => {
      message.style.boxShadow = 'none'; // Remove box shadow after 2 seconds
    }, 2000);
  });
});

const messageSearch = document.querySelector('#message-search');

const searchMessage = () => {
  const val = messageSearch.value.toLowerCase();
  messages.forEach((message) => {
    const messageItems = message.querySelectorAll('.message');
    messageItems.forEach((chat) => {
      let name = chat.querySelector('h5').textContent.toLowerCase();
      if (name.indexOf(val) != -1) {
        chat.style.display = 'flex';
      } else {
        chat.style.display = 'none';
      }
    });
  });
};

messageSearch.addEventListener('keyup', searchMessage);

const theme = document.querySelector('#theme');
const themeModal = document.querySelector('.customize-theme');
const fontSizes = document.querySelectorAll('.choose-size span');
var root = document.querySelector(':root');

const openThemeModal = () => {
  themeModal.style.display = 'grid';
};

const closeThemeModel = (e) => {
  if (e.target.classList.contains('customize-theme')) {
    themeModal.style.display = 'none';
  }
};

themeModal.addEventListener('click', closeThemeModel);

theme.addEventListener('click', openThemeModal);

const removeSizeSelector = () => {
  fontSizes.entries((size) => {
    size.classList.remove('active');
  });
};

fontSizes.forEach((size) => {
  size.addEventListener('click', () => {
    removeSizeSelector();
    let fontSize;
    size.classList.toggle('active');

    if (size.classList.contains('font-size-1')) {
      fontSize = '10px';
      root.style.setProperty('----sticky-top-left', '5.4rem');
      root.style.setProperty('----sticky-top-right', '5.4rem');
    } else if (size.classList.contains('font-size-2')) {
      fontSize = '13px';
      root.style.setProperty('----sticky-top-left', '5.4rem');
      root.style.setProperty('----sticky-top-right', '-7rem');
    } else if (size.classList.contains('font-size-3')) {
      fontSize = '16px';
      root.style.setProperty('----sticky-top-left', '-2rem');
      root.style.setProperty('----sticky-top-right', '-17rem');
    } else if (size.classList.contains('font-size-4')) {
      fontSize = '19px';
      root.style.setProperty('----sticky-top-left', '-5rem');
      root.style.setProperty('----sticky-top-right', '-25rem');
    } else if (size.classList.contains('font-size-5')) {
      fontSize = '22px';
      root.style.setProperty('----sticky-top-left', '-12rem');
      root.style.setProperty('----sticky-top-right', '-35rem');
    }

    document.querySelector('html').style.fontSize = fontSize;
  });
});


