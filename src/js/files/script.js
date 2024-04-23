// Подключение функционала 
import { isMobile, removeClasses, _slideUp, _slideToggle } from "./functions.js";
// Подключение списка активных модулей
import { flsModules } from "./modules.js";

document.addEventListener('click', function (e) {
   const targetElement = e.target;

   // Показываем выпадающее меню при клике на стрелку
   if (window.innerWidth > 767.98) {
      if (targetElement.classList.contains('menu__arrow')) {
         targetElement.closest('.menu-item').classList.toggle('_hover');
      }
      if (!targetElement.closest('.menu-item') && document.querySelectorAll('.menu-item._hover').length > 0) {
         removeClasses(document.querySelectorAll('.menu-item._hover'), "_hover");
      }
   }

   if (window.innerWidth < 767.98) {
      if (targetElement.classList.contains('menu__arrow')) {
         const arrowParent = targetElement.closest('.menu-item');
         const list = arrowParent.querySelector('ul');
         _slideToggle(list);
         arrowParent.classList.toggle('_hover');
      }
   }
})

// Прячем меню на мобильных устройствах
if (window.innerWidth < 767.98) {
   const menuItemsHasChildren = document.querySelectorAll('.menu__list .menu-item-has-children');
   if (menuItemsHasChildren.length > 0) {
      menuItemsHasChildren.forEach(element => {
         const menuList = element.querySelector('ul');
         _slideUp(menuList, 0);
      });
   }
}

// Выравниваем высоту заголовков у portfolio card
const portfolioCards = document.querySelectorAll('.portfolio-card');
if (portfolioCards.length > 0) {
   changePortfolioCartTitleHeight();
   window.addEventListener('resize', changePortfolioCartTitleHeight());
}

// Выравниваем высоту заголовков у portfolio card
function changePortfolioCartTitleHeight() {
   setTimeout(() => {
      let titleHeight = 0;

      portfolioCards.forEach(element => {
         const elementTitle = element.querySelector('.portfolio-card__title');
         const elementTitleOffsetHeight = elementTitle.offsetHeight;
         elementTitleOffsetHeight > titleHeight ? titleHeight = elementTitleOffsetHeight : null;
      });

      portfolioCards.forEach(element => {
         const elementTitle = element.querySelector('.portfolio-card__title');
         elementTitle.style.height = titleHeight + 'px';
      });
   }, 500);
}

// Заполняем значениями скрытые инпуты
const expertiseType = document.getElementById('order-expertise-type');
const requestExpertiseType = document.getElementById('request-expertise-type');

document.addEventListener("selectCallback", function (e) {
   // Селект 
   const currentSelect = e.detail.select;

   // Добавляем в скрытый инпут значение селекта
   if (expertiseType) {
      expertiseType.value = currentSelect.value;
   }

   if (expertiseType) {
      requestExpertiseType.value = currentSelect.value;
   }
});

// Добавляем в скрытый инпут выбранный мессенджер
const connectionType = document.getElementById('order-connection-type');
const connectionOptions = document.querySelectorAll('.connection__options .options__item input');
if (connectionType) {
   connectionOptions.forEach(element => {
      element.addEventListener('change', function () {
         connectionType.value = element.value;
      })
   });
}

// Удаляем слово "экспертиза" из списка услуг на главной
const template1ServicesItems = document.querySelectorAll('.home .template1-services__item');
if (template1ServicesItems.length > 0) {
   template1ServicesItems.forEach(element => {
      const lineTag = element.querySelector('span');
      let str = lineTag.innerHTML;
      str = str.replace("экспертиза", "");
      lineTag.innerHTML = str;
   });
}