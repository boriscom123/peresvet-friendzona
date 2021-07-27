console.log('blank');
// прокрутка
function scroll(){
    let scrollHeight = Math.max(
        document.body.scrollHeight, document.documentElement.scrollHeight,
        document.body.offsetHeight, document.documentElement.offsetHeight,
        document.body.clientHeight, document.documentElement.clientHeight
    );
    let totalSrcoll = scrollHeight - window.innerHeight;
    let scrollStep = totalSrcoll / 100;
    scrollBarEl[0].children[0].style.width = (window.pageYOffset / scrollStep) +'%';
}
let scrollBarEl = document.getElementsByClassName('header-progress-bar');
document.addEventListener('scroll',  function(){scroll(this)});
// прокрутка - конец
// бургер-меню
function burgerClick(el){
    if (el.status) {
        el.status = false;
    } else {
        el.status = true;
        modalsEl.classList.remove('d-none');
        modalsEl.children[0].classList.remove('d-none');
    }
}
function closeBurgerMenu(el){
    modalsEl.children[0].classList.add('d-none');
    modalsEl.classList.add('d-none');
    burgerMenuEl.status = false;
}
let closeBurgerMenuEl = document.getElementById('close-burger-menu');
if(closeBurgerMenuEl) {
    closeBurgerMenuEl.addEventListener('click', function (){ closeBurgerMenu(this) });
}
let modalsEl = document.getElementsByClassName('modals')[0];
let burgerMenuEl = document.getElementsByClassName('header-burger-menu')[0];
burgerMenuEl.addEventListener('click', function (){ burgerClick(this) });
// бургер-меню - конец
// блок 1 - слайдер
function sliderChangeLeft(el){
    for(let i=0; i<sliderPaginationBlock.children.length; i++){
        if(sliderPaginationBlock.children[i].classList.contains('active')) {
            if(i==0){
                sliderPaginationBlock.children[i].classList.remove('active');
                sliderPaginationBlock.children[sliderPaginationBlock.children.length - 1].classList.add('active');
                sliderImagesBlock.children[i].classList.add('d-none');
                sliderImagesBlock.children[sliderPaginationBlock.children.length - 1].classList.remove('d-none');
                sliderTextBlock.children[i].classList.add('d-none');
                sliderTextBlock.children[sliderPaginationBlock.children.length - 1].classList.remove('d-none');
                break;
            } else {
                sliderPaginationBlock.children[i].classList.remove('active');
                sliderPaginationBlock.children[i-1].classList.add('active');
                sliderImagesBlock.children[i].classList.add('d-none');
                sliderImagesBlock.children[i-1].classList.remove('d-none');
                sliderTextBlock.children[i].classList.add('d-none');
                sliderTextBlock.children[i-1].classList.remove('d-none');
            }
        }
    }
}
function sliderChangeRight(el){
    for(let i=0; i<sliderPaginationBlock.children.length; i++){
        if(sliderPaginationBlock.children[i].classList.contains('active')) {
            if(i== sliderPaginationBlock.children.length - 1){
                sliderPaginationBlock.children[i].classList.remove('active');
                sliderPaginationBlock.children[0].classList.add('active');
                sliderImagesBlock.children[i].classList.add('d-none');
                sliderImagesBlock.children[0].classList.remove('d-none');
                sliderTextBlock.children[i].classList.add('d-none');
                sliderTextBlock.children[0].classList.remove('d-none');
            } else {
                sliderPaginationBlock.children[i].classList.remove('active');
                sliderPaginationBlock.children[i+1].classList.add('active');
                sliderImagesBlock.children[i].classList.add('d-none');
                sliderImagesBlock.children[i+1].classList.remove('d-none');
                sliderTextBlock.children[i].classList.add('d-none');
                sliderTextBlock.children[i+1].classList.remove('d-none');
                break;
            }
        }
    }
}
let sliderLeftButtonEl = document.getElementById('slider-left-button');
if (sliderLeftButtonEl) {
    sliderLeftButtonEl.addEventListener('click', function (){ sliderChangeLeft(this) });

}
let sliderRightButtonEl = document.getElementById('slider-right-button');
if (sliderRightButtonEl) {
    sliderRightButtonEl.addEventListener('click', function (){ sliderChangeRight(this) });

}
let sliderPaginationBlock = document.getElementById('slider-pagination');
let sliderImagesBlock = document.getElementById('slider-images');
let sliderTextBlock = document.getElementById('slider-text');
// блок 1 - слайдер - конец
// закрытие модальных окон
function closeModal(el){
    modalsEl.classList.add('d-none');
    for(let i=0; i<modalsEl.children.length; i++){
        modalsEl.children[i].classList.add('d-none');
    }
}
let closeModalButtonEl = document.getElementsByClassName('close-modal');
for(let i=0; i<closeModalButtonEl.length; i++){
    closeModalButtonEl[i].addEventListener('click', function (){ closeModal(this) });
}
// закрытие модальных окон - конец
// кнопки входа
function showLoginModal(el){
    if(burgerMenuEl.status = true){
        modalsEl.children[0].classList.add('d-none');
        burgerMenuEl.status = false;
    }
    modalsEl.classList.remove('d-none');
    modalsEl.children[2].classList.remove('d-none');
}
let loginButtonsEl = document.getElementsByClassName('login-button');
for(let i=0; i<loginButtonsEl.length; i++){
    loginButtonsEl[i].addEventListener('click', function (){ showLoginModal(this) });
}
// кнопки входа - конец
// кнопки регистрации
function showRegistrationModal(el){
    if(burgerMenuEl.status = true){
        modalsEl.children[0].classList.add('d-none');
        burgerMenuEl.status = false;
    }
    modalsEl.classList.remove('d-none');
    modalsEl.children[1].classList.remove('d-none');
}
let registrationButtonsEl = document.getElementsByClassName('registration-button');
for(let i=0; i<registrationButtonsEl.length; i++){
    registrationButtonsEl[i].addEventListener('click', function (){ showRegistrationModal(this) });
}
// кнопки регистрации - конец
// ответы на вопросы
function questionAction(el){
    console.log(el);
    console.log('questionAction');
    if(el.classList.contains('brief')) {
        el.classList.remove('brief');
    } else {
        el.classList.add('brief');
    }
}
let questionEl = document.getElementsByClassName('item-question');
for(let i=0; i<questionEl.length; i++){
    questionEl[i].addEventListener('click', function (){ questionAction(this) });
}
// ответы на вопросы - конец