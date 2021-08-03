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
    closeModal();
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
// показать все вопросы
function showAllQuestionsAction(el){
    if(el.show){
        el.show = false;
        for (let i=3; i < el.parentNode.parentNode.children.length - 1; i++){
            if(el.parentNode.parentNode.children[i].classList.contains('brief')){
                el.parentNode.parentNode.children[i].classList.remove('brief');
            }
            el.parentNode.parentNode.children[i].classList.add('hidden');
        }
        el.textContent = 'Смотреть еще';
    } else {
        el.show = true;
        for (let i=0; i < el.parentNode.parentNode.children.length; i++){
            if(el.parentNode.parentNode.children[i].classList.contains('hidden')){
                el.parentNode.parentNode.children[i].classList.remove('hidden');
                el.parentNode.parentNode.children[i].classList.add('brief');
            }
        }
        el.textContent = 'Скрыть';
    }
}
const showAllQuestionsButtonEl = document.getElementById('show-all-questions');
if(showAllQuestionsButtonEl) {
    showAllQuestionsButtonEl.addEventListener('click', function (){ showAllQuestionsAction(this) });
}
// показать все вопросы - конец
// воспроизведение видео
function playVideoSmall(el){
    videoContainerSmallEl.play();
}
let videoContainerSmallEl = document.getElementById('video-container-small');
let playVideoButtonSmallEl = document.getElementById('play-video-button-small');
if(playVideoButtonSmallEl) {
    playVideoButtonSmallEl.addEventListener('click', function (){ playVideoSmall(this) });
}
function playVideoBig(el){
    playVideoButtonBigEl.classList.add('d-none');
    videoContainerBigEl.play();
    videoContainerBigEl.controls = true;
    videoContainerBigEl.onended = () => {
        videoContainerBigEl.controls = false;
        playVideoButtonBigEl.classList.remove('d-none');
    }
}
let videoContainerBigEl = document.getElementById('video-container-big');
let playVideoButtonBigEl = document.getElementById('play-video-button-big');
if(playVideoButtonBigEl){
    playVideoButtonBigEl.addEventListener('click', function (){ playVideoBig(this) });
}
// воспроизведение видео - конец
// модальное окно регистрации
function modalRegistrationAction(el){
    if(!modalRegInputF.value){
        console.log('net familii');
        formRegistrationEl.confirmf = false;
    } else {
        formRegistrationEl.confirmf = true;
    }
    if(!modalRegInputI.value){
        console.log('net imeny');
        formRegistrationEl.confirmi = false;
    } else {
        formRegistrationEl.confirmi = true;
    }
    if(!modalRegInputTel.value){
        console.log('net telefona');
        formRegistrationEl.confirmtel = false;
    } else {
        formRegistrationEl.confirmtel = true;
    }
    if(formRegistrationRulesEl.checked) {
        console.log('checked');
        if(formRegistrationEl.confirmf && formRegistrationEl.confirmi && formRegistrationEl.confirmtel){
            formRegistrationEl.addEventListener('submit', (event)=>{ event.preventDefault(); });
            modalRegistrationInputsEl.classList.remove('d-flex');
            modalRegistrationInputsEl.classList.add('d-none');
            modalRegistrationTelCheckEl.classList.remove('d-none');
            modalRegistrationTelCheckEl.classList.add('d-flex');
        }
    } else {
        console.log('ne checked');
        formRegistrationEl.addEventListener('submit', (event)=>{ event.preventDefault(); });
    }
}
function modalRegistrationConfirmAction(el){
    if(!modalRegInputCode.value){
        console.log('net coda');
        modalRegInputCode.confirmcode = false;
    } else {
        formRegistrationEl.confirmcode = true;
    }
    if(formRegistrationEl.confirmf && formRegistrationEl.confirmi && formRegistrationEl.confirmtel && formRegistrationEl.confirmcode)
    {
        formRegistrationEl.addEventListener('submit', (event)=>{ formRegistrationEl.submit(); });
    }
}
const modalRegInputF = document.getElementById('form-reg-f');
const modalRegInputI = document.getElementById('form-reg-i');
const modalRegInputTel = document.getElementById('form-reg-tel');
const modalRegInputCode = document.getElementById('form-reg-code');
const modalRegistrationInputsEl = document.getElementsByClassName('reg-form-inputs')[0];
const modalRegistrationTelCheckEl = document.getElementsByClassName('reg-form-check-tel')[0];
const formRegistrationEl = document.getElementById('form-reg');
const formRegistrationRulesEl = document.getElementById('rules');
let modalRegistrationButtonEl = document.getElementById('modal-reg-button');
if(modalRegistrationButtonEl){
    modalRegistrationButtonEl.addEventListener('click', function (){ modalRegistrationAction(this) });
}
let modalRegistrationConfirmButtonEl = document.getElementById('modal-reg-button-confirm');
if(modalRegistrationConfirmButtonEl){
    modalRegistrationConfirmButtonEl.addEventListener('click', function (){ modalRegistrationConfirmAction(this) });
}
// модальное окно регистрации - конец
// модальное окно забыли пароль
function modalPassForget(el){
    closeModal();
    modalsEl.classList.remove('d-none');
    modalsEl.children[3].classList.remove('d-none');
}
const modalPassForgetEl = document.getElementById('modal-pass-forget');
modalPassForgetEl.addEventListener('click', function (){ modalPassForget(this) });
// модальное окно забыли пароль - конец
// модально окно задать вопрос
function modalQuestionAction(el){
    closeModal();
    modalsEl.classList.remove('d-none');
    modalsEl.children[5].classList.remove('d-none');
}
let userQuestionButtonEl = document.getElementById('user-question-button');
if(userQuestionButtonEl){
    userQuestionButtonEl.addEventListener('click', function (){ modalQuestionAction(this) });
}
// модально окно задать вопрос - конец
// модально окно вывести
function modalMoneyAction(el){
    console.log(el);
    console.log('modalMoneyAction');
    closeModal();
    modalsEl.classList.remove('d-none');
    modalsEl.children[4].classList.remove('d-none');
}
let userMoneyButtonEl = document.getElementById('user-money-button');
if(userMoneyButtonEl){
    userMoneyButtonEl.addEventListener('click', function (){ modalMoneyAction(this) });
}
// модально окно вывести - конец
// модальное окно подтверждения
function modalConfirmAction(el){
    closeModal();
    modalsEl.classList.remove('d-none');
    modalsEl.children[6].classList.remove('d-none');
    setTimeout(()=>{ closeModal(); }, 3000);
}
// модальное окно подтверждения - конец
// закрытие всплывающего меню при нажатии на ссылки-якоря
let userAncorLinkEl = document.getElementsByClassName('ancor-link');
for(let i=0; i<userAncorLinkEl.length; i++){
    userAncorLinkEl[i].addEventListener('click', function (){ closeModal(this); burgerMenuEl.status = false; });
}
// закрытие всплывающего меню при нажатии на ссылки-якоря - конец