const header = document.querySelector('header');
function fixedNavbar() {
    header.classList.toggle('scrolled', window.pageYOffset > 0);
}
fixedNavbar();
window.addEventListener('scroll', fixedNavbar);

let menu = document.querySelector('#menu-btn');
let userBtn = document.querySelector('#user-btn');

menu.addEventListener('click', function(){
    let nav = document.querySelector('.navbar');
    nav.classList.toggle('active');
});
userBtn.addEventListener('click', function(){
    let userBox = document.querySelector('.user-box');
    userBox.classList.toggle('active');
});

/*--------testimonial slider-------------*/
"use strict";
const prevTestimonial = document.querySelector('.prev-testimonial'),
    nextTestimonial = document.querySelector('.next-testimonial'),
    testimonialContainer = document.querySelector('.testimonial-container');

/*--------scroll to next testimonial------------*/
function scrollNextTestimonial(){
    testimonialContainer.scrollBy({
        left: window.innerWidth,
        behavior: "smooth"
    });
}

/*--------scroll to previous testimonial------------*/
function scrollPrevTestimonial(){
    testimonialContainer.scrollBy({
        left: -window.innerWidth,
        behavior: "smooth"
    });
} 

/*--------scroll event------------*/ 
testimonialContainer.addEventListener("click", function (ev) {
    if (ev.target === prevTestimonial) {
        scrollPrevTestimonial();
    }
    if (ev.target === nextTestimonial) {
        scrollNextTestimonial();
    }
});
