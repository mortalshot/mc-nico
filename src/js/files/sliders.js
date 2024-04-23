/*
Документация по работе в шаблоне: 
Документация слайдера: https://swiperjs.com/
Сниппет(HTML): swiper
*/

// Подключаем слайдер Swiper из node_modules
// При необходимости подключаем дополнительные модули слайдера, указывая их в {} через запятую
// Пример: { Navigation, Autoplay }
import Swiper, { Navigation, Pagination, Grid } from 'swiper';
/*
Основниые модули слайдера:
Navigation, Pagination, Autoplay, 
EffectFade, Lazy, Manipulation
Подробнее смотри https://swiperjs.com/
*/

// Стили Swiper
// Базовые стили
import "../../scss/base/swiper.scss";
// Полный набор стилей из scss/libs/swiper.scss
// import "../../scss/libs/swiper.scss";
// Полный набор стилей из node_modules
// import 'swiper/css';

function initSliders() {
	if (document.querySelector('.portfolio-widget__slider')) {
		new Swiper('.portfolio-widget__slider', {
			modules: [Navigation, Pagination],
			observer: true,
			observeParents: true,
			slidesPerView: 1,
			spaceBetween: 30,
			autoHeight: false,
			speed: 800,
			// mousewheel: true,

			//touchRatio: 0,
			//simulateTouch: false,
			//loop: true,

			/*
			// Эффекты
			effect: 'fade',
			autoplay: {
				delay: 3000,
				disableOnInteraction: false,
			},
			*/

			// Пагинация

			pagination: {
				el: '.portfolio-widget__slider .swiper-pagination',
				clickable: true,
			},


			// Скроллбар
			/*
			scrollbar: {
				el: '.swiper-scrollbar',
				draggable: true,
			},
			*/

			// Кнопки "влево/вправо"
			navigation: {
				prevEl: '.portfolio-widget__slider .swiper__arrow_left',
				nextEl: '.portfolio-widget__slider .swiper__arrow_right',
			},

			// Брейкпоинты

			breakpoints: {
				475: {
					slidesPerView: 2,
					spaceBetween: 30,
				},
				768: {
					slidesPerView: 3,
					spaceBetween: 30,
				},
				992: {
					slidesPerView: 4,
					spaceBetween: 24,
				},
				1280: {
					slidesPerView: 4,
					spaceBetween: 40,
				},
			},

			// События
			on: {

			}
		});
	}

	if (document.querySelector('.clients__slider')) {
		new Swiper('.clients__slider', {
			modules: [Navigation],
			observer: true,
			observeParents: true,
			slidesPerView: 3,
			spaceBetween: 30,
			autoHeight: false,
			speed: 800,

			// Кнопки "влево/вправо"
			navigation: {
				prevEl: '.clients__slider .swiper__arrow_left',
				nextEl: '.clients__slider .swiper__arrow_right',
			},

			// Брейкпоинты

			breakpoints: {
				480: {
					slidesPerView: 3,
					spaceBetween: 40,
				},
				575: {
					slidesPerView: 4,
					spaceBetween: 20,
				},
				768: {
					slidesPerView: 6,
					spaceBetween: 20,
				},
				992: {
					slidesPerView: 6,
					spaceBetween: 30,
				},
				1280: {
					slidesPerView: 6,
					spaceBetween: 40,
				},
			},

			// События
			on: {

			}
		});
	}

	if (document.querySelector('.news-widget__slider')) {
		new Swiper('.news-widget__slider', {
			modules: [Navigation, Pagination],
			observer: true,
			observeParents: true,
			slidesPerView: 1,
			spaceBetween: 50,
			autoHeight: false,
			speed: 800,

			//touchRatio: 0,
			//simulateTouch: false,
			//loop: true,

			/*
			// Эффекты
			effect: 'fade',
			autoplay: {
				delay: 3000,
				disableOnInteraction: false,
			},
			*/

			// Пагинация

			pagination: {
				el: '.news-widget__slider .swiper-pagination',
				clickable: true,
				// dynamicBullets: true,
			},


			// Скроллбар
			/*
			scrollbar: {
				el: '.swiper-scrollbar',
				draggable: true,
			},
			*/

			// Кнопки "влево/вправо"
			navigation: {
				prevEl: '.news-widget__slider .swiper__arrow_left',
				nextEl: '.news-widget__slider .swiper__arrow_right',
			},

			// Брейкпоинты

			breakpoints: {
				575: {
					slidesPerView: 2,
					spaceBetween: 50,
				},
				768: {
					slidesPerView: 3,
					spaceBetween: 50,
				},
				992: {
					slidesPerView: 3,
					spaceBetween: 60,
				},
				1280: {
					slidesPerView: 4,
					spaceBetween: 60,
				},
			},

			// События
			on: {

			}
		});
	}

	if (document.querySelector('.licenses__slider')) {
		let licensesMd3 = window.matchMedia('(max-width: 767.98px)');
		var init = false;
		let licenses;

		function clientsHandleMd2Change(e) {
			if (e.matches) {
				if (!init) {
					init = true;
					licenses = new Swiper('.licenses__slider', {
						modules: [Pagination, Navigation],
						observer: true,
						observeParents: true,
						slidesPerView: 2,
						spaceBetween: 30,
						speed: 800,

						// Пагинация
						pagination: {
							el: '.licenses__slider .swiper-pagination',
							clickable: true,
						},

						navigation: {
							prevEl: '.licenses__slider .swiper__arrow_left',
							nextEl: '.licenses__slider .swiper__arrow_right',
						},

						breakpoints: {
							480: {
								slidesPerView: 2.5,
								spaceBetween: 20,
							},
							575: {
								slidesPerView: 3,
								spaceBetween: 30,
							},
						},

						// События
						on: {
						}
					});
				}
			} else if (init) {
				licenses.destroy();
				init = false;
			}
		}
		licensesMd3.addEventListener('change', clientsHandleMd2Change);
		clientsHandleMd2Change(licensesMd3);
	}

	if (document.querySelector('.cases__slider')) {
		new Swiper('.cases__slider', {
			modules: [Navigation, Pagination, Grid],
			observer: true,
			observeParents: true,
			slidesPerView: 1,
			slidesPerGroup: 1,
			spaceBetween: 30,
			autoHeight: false,
			speed: 800,

			// Пагинация
			pagination: {
				el: '.cases__slider .swiper-pagination',
				clickable: true,
			},

			// Кнопки "влево/вправо"
			navigation: {
				prevEl: '.cases__slider .swiper__arrow_left',
				nextEl: '.cases__slider .swiper__arrow_right',
			},

			// Брейкпоинты

			breakpoints: {
				480: {
					slidesPerView: 2,
					slidesPerGroup: 2,
					grid: {
						rows: 2,
						fill: 'row',
					},
				},
				768: {
					slidesPerView: 3,
					slidesPerGroup: 3,
					grid: {
						rows: 3,
						fill: 'row',
					},
					dynamicBullets: false,
				},
				992: {
					slidesPerView: 4,
					slidesPerGroup: 4,
					grid: {
						rows: 3,
						fill: 'row',
					},
					dynamicBullets: false,
				},
			},

			// События
			on: {

			}
		});
	}
}
// Скролл на базе слайдера (по классу swiper_scroll для оболочки слайдера)
function initSlidersScroll() {
	let sliderScrollItems = document.querySelectorAll('.swiper_scroll');
	if (sliderScrollItems.length > 0) {
		for (let index = 0; index < sliderScrollItems.length; index++) {
			const sliderScrollItem = sliderScrollItems[index];
			const sliderScrollBar = sliderScrollItem.querySelector('.swiper-scrollbar');
			const sliderScroll = new Swiper(sliderScrollItem, {
				observer: true,
				observeParents: true,
				direction: 'vertical',
				slidesPerView: 'auto',
				freeMode: {
					enabled: true,
				},
				scrollbar: {
					el: sliderScrollBar,
					draggable: true,
					snapOnRelease: false
				},
				mousewheel: {
					releaseOnEdges: true,
				},
			});
			sliderScroll.scrollbar.updateSize();
		}
	}
}

window.addEventListener("load", function (e) {
	// Запуск инициализации слайдеров
	initSliders();
	// Запуск инициализации скролла на базе слайдера (по классу swiper_scroll)
	//initSlidersScroll();
});