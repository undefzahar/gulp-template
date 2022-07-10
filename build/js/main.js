// JS fragment import example
import * as functions from "./modules/functions.js";
functions.isWebp();


// NPM Swiper installation example

/*
import Swiper, { Navigation, Pagination } from 'swiper';

// init Swiper:
const swiper = new Swiper('.swiper', {
	// configure Swiper to use modules
	modules: [Navigation, Pagination],
	...
});
*/


// JS fragment import example

var mobile = window.matchMedia('(min-width: 0px) and (max-width: 768px)');
var tablet = window.matchMedia('(min-width: 769px) and (max-width: 1023px)');
var desktop = window.matchMedia('(min-width: 1023px) and (max-width: 1279px)'); // Enable (for mobile)
var desktop_pc = window.matchMedia('(min-width: 1280px)');


// ANCHOR VARIABLES
// ==============================================  
let isDesk = $('body').hasClass('desktop'),
	isIE = $('body').hasClass('isIe'),
	menuOpen = false;

// ANCHOR HEADER SCROLL LISTENER
// ==============================================  
let st = $(window).scrollTop(),
	prevSt = st;

window.st = st;

// hide header if page was alredy scrolled after loading

if (mobile.matches && $(document).scrollTop() > 200) {
	$("header").addClass("header--scrolled");
} else if ($(document).scrollTop() > 800) {
	$("header").addClass("header--scrolled");
}

$(document).scroll(() => {
	st = $(window).scrollTop();
	window.st = st;

	if (!window.autoscrolling) {
		// check if scroll not happening during anchor scrolling
		if (st < prevSt && prevSt - st < 500) {
			// scroll UP
			$('header').removeClass("header--hide");
		} else {
			// scroll DOWN
			if (st > $('header').height()) {
				$('header').addClass("header--hide");
			}
		}
	} else {
		$('header').addClass("header--hide");
	}

	if (mobile.matches) {
		if (window.scrollY > 200) {
			$('header').addClass("header--scrolled");
		} else {
			$('header').removeClass("header--scrolled");
		}
	} else {
		if (window.scrollY > 800) {
			$('header').addClass("header--scrolled");
		} else {
			$('header').removeClass("header--scrolled");
		}
	}

	prevSt = st;
});

$(document).ready(function () {
	$('.header__burger').on('click', function() {
		if(!$('body').hasClass('menu-open')) {
			$('body').addClass('menu-open');
			//$('.header__menu').slideDown();
		} else {
			$('body').removeClass('menu-open');
			//$('.header__menu').slideUp();
		}
	});

	$('.header__menu-list a').on('click', function() {
		$('.header__burger').removeClass('active');
		$('body').removeClass('menu-open');
		//$('.header__menu').slideUp();
	});
});