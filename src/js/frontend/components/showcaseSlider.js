/**
 * Init for showcase slider.
 *
 * @param {Object} $    - The jQuery object.
 * @param {Object} vars - An object containing the necessary variables and elements.
 */
import { SigmaFrontendHelpers as helpers } from '../classes/SigmaFrontendHelpers';

export const showcaseSlider = ($, vars) => {
	if (!helpers.elementExists(vars.showcaseSlider)) {
		return false;
	}

	// let swiperAnimation = new SwiperAnimation();

	const container = $(vars.showcaseSlider),
		preLoader = container.find('.preloader'),
		isCarousel = container.find('.swiper');

	if (isCarousel.length) {
		isCarousel.imagesLoaded(() => {
			setTimeout(() => {
				isCarousel.each((_, el) => {
					const sliderElement = $(el),
						swiperOptions = {
							slidesPerView: 1,
							loop: true,
							spaceBetween: 0,
							slideToClickedSlide: true,
							autoplay: {
								delay: 7000,
							},
							speed: 1000,
							effect: 'slide',
							watchSlidesProgress: true,
							disableOnInteraction: true,
							parallax: true,
							on: {
								init() {
									this.slides.each((slide) => {
										$(slide)
											.find('.img-container')
											.attr({
												'data-swiper-parallax':
													0.75 * this.width,
												'data-swiper-parallax-opacity': 0.4,
											});
									});
									$(this.slides)
										.removeClass('active')
										.eq(this.activeIndex)
										.addClass('active');
									//swiperAnimation.init(this).animate();
								},
								transitionEnd() {
									$(this.slides)
										.removeClass('active')
										.eq(el.activeIndex)
										.addClass('active');
								},
								resize() {
									this.update();
								},
								// slideChange() {
									//swiperAnimation.init(this).animate();
								// },
							},
							pagination: {
								el: '.swiper-pagination',
								clickable: true,
								// dynamicBullets: true,
							},
							navigation: {
								nextEl: '.swiper-button-next',
								prevEl: '.swiper-button-prev',
							},
						};

					const heroSlider = new Swiper(
						sliderElement[0],
						swiperOptions
					);

					heroSlider.autoplay.start();
				});

				preLoader.fadeOut(1000, () => {
					$(preLoader).remove();
				});
			}, 2000);
		});
	}
};
