console.log('blank');
// обработка всех кликов
function documentClickListener(el, event){
    if(document.click){
        document.click++
    } else {
        document.click = 1;
    }
    console.log('document.click', document.click);
    if(document.showUserInfo) {
        for(let i=0; i<showUserInfoEl.length; i++){
            showUserInfoEl[i].lastElementChild.classList.remove('d-flex');
            showUserInfoEl[i].lastElementChild.classList.add('d-none');
        }
        document.showUserInfo = false;
    } else {
    }
}
document.addEventListener('click',  function(){documentClickListener(this, event)} );
// обработка всех кликов - конец
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
// модальное окно Вход
function checkLoginTelInputElAction(){
    let value = modalLoginInputTel.value;
    // console.log('Телефон: ', value);
    let re = /^\+?[78][-\(]?\d{3}\)?-?\d{3}-?\d{2}-?\d{2}$/;
    let valid = re.test(modalLoginInputTel.value);
    if(value && valid) {
        formLoginEl.confirmlogintel = true;
        if(modalLoginInputTel.classList.contains('alert')) {
            modalLoginInputTel.classList.remove('alert');
        }
        if(!modalLoginInputTel.classList.contains('ok')) {
            modalLoginInputTel.classList.add('ok');
        }
    } else {
        formLoginEl.confirmlogintel = false;
        if(modalLoginInputTel.classList.contains('ok')) {
            modalLoginInputTel.classList.remove('ok');
        }
        if(!modalLoginInputTel.classList.contains('alert')) {
            modalLoginInputTel.classList.add('alert');
        }
    }
}
function checkPassInputElAction(){
    // console.log('Проверяем пароль');
    if(modalLoginInputPass.value.length >= 6) {
        formLoginEl.confirmpass = true;
        if(modalLoginInputPass.classList.contains('alert')) {
            modalLoginInputPass.classList.remove('alert');
        }
        if(!modalLoginInputPass.classList.contains('ok')) {
            modalLoginInputPass.classList.add('ok');
        }
    } else {
        formLoginEl.confirmpass = false;
        if(modalLoginInputPass.classList.contains('ok')) {
            modalLoginInputPass.classList.remove('ok');
        }
        if(!modalLoginInputPass.classList.contains('alert')) {
            modalLoginInputPass.classList.add('alert');
        }
    }
}
function formLoginChekValues(){
    console.log('formLoginChekValues');
    checkLoginTelInputElAction();
    checkPassInputElAction();
    formLoginEl.addEventListener('submit', (event)=>{ event.preventDefault(); });
    if(formLoginEl.confirmlogintel && formLoginEl.confirmpass){
        console.log('Отправляем данные AJAX для проверки логина и пароля пользователя');
        let formData = new FormData();
        formData.set('action', 'user-login');
        formData.set('u-tel', modalLoginInputTel.value);
        formData.set('u-pass', modalLoginInputPass.value);
        let request = fetch(siteAjaxUrl, {
            method: 'POST',
            body: formData
        }).then(response => response.text()).then((response)=> {
            console.log(response);
            if(response === 'ok'){
                console.log('Данные пользователя совпали. Подтверждаем вход для пользователя');
                formLoginEl.submit();
            } else {
                console.log('Данные пользователя Не совпали');
                showPopUpMessageEl('alert', 'Неправильный логин или пароль');
                setTimeout(()=>{ closePopUpMessageEl(); }, 3000);
            }
        });
    }
}
const modalLoginInputTel = document.getElementById('form-login-u-login');
modalLoginInputTel.addEventListener('keyup', function (){ checkLoginTelInputElAction() });
const modalLoginInputPass = document.getElementById('form-login-u-pass');
modalLoginInputPass.addEventListener('keyup', function (){ checkPassInputElAction() });
const formLoginEl = document.getElementById('form-login');
let modalLoginConfirmButtonEl = document.getElementById('form-login-submit');
if(modalLoginConfirmButtonEl){
    modalLoginConfirmButtonEl.addEventListener('click', function (){ formLoginChekValues(this) });
}
// модальное окно Вход - конец
// модальное окно регистрации
function checkFInputElAction(){
    let value = modalRegInputF.value;
    console.log('Фамилия: ', value);
    if(value && value.length > 2) {
        formRegistrationEl.confirmf = true;
        if(modalRegInputF.classList.contains('alert')) {
            modalRegInputF.classList.remove('alert');
        }
        if(!modalRegInputF.classList.contains('ok')) {
            modalRegInputF.classList.add('ok');
        }
    } else {
        formRegistrationEl.confirmf = false;
        if(modalRegInputF.classList.contains('ok')) {
            modalRegInputF.classList.remove('ok');
        }
        if(!modalRegInputF.classList.contains('alert')) {
            modalRegInputF.classList.add('alert');
        }
    }
}
function checkIInputElAction(){
    let value = modalRegInputI.value;
    console.log('Имя: ', value);
    if(value && value.length > 1) {
        formRegistrationEl.confirmi = true;
        if(modalRegInputI.classList.contains('alert')) {
            modalRegInputI.classList.remove('alert');
        }
        if(!modalRegInputI.classList.contains('ok')) {
            modalRegInputI.classList.add('ok');
        }
    } else {
        formRegistrationEl.confirmi = false;
        if(modalRegInputI.classList.contains('ok')) {
            modalRegInputI.classList.remove('ok');
        }
        if(!modalRegInputI.classList.contains('alert')) {
            modalRegInputI.classList.add('alert');
        }
    }
}
function checkTelInputElAction(){
    let value = modalRegInputTel.value;
    console.log('Телефон: ', value);
    let re = /^\+?[78][-\(]?\d{3}\)?-?\d{3}-?\d{2}-?\d{2}$/;
    let valid = re.test(modalRegInputTel.value);
    if(value && valid) {
        formRegistrationEl.confirmtel = true;
        if(modalRegInputTel.classList.contains('alert')) {
            modalRegInputTel.classList.remove('alert');
        }
        if(!modalRegInputTel.classList.contains('ok')) {
            modalRegInputTel.classList.add('ok');
        }
    } else {
        formRegistrationEl.confirmtel = false;
        if(modalRegInputTel.classList.contains('ok')) {
            modalRegInputTel.classList.remove('ok');
        }
        if(!modalRegInputTel.classList.contains('alert')) {
            modalRegInputTel.classList.add('alert');
        }
    }
}
function modalRegistrationAction(el){
    checkFInputElAction();
    checkIInputElAction();
    checkTelInputElAction();
    if(formRegistrationRulesEl.checked) {
        // console.log('checked');
        formRegistrationEl.addEventListener('submit', (event)=>{ event.preventDefault(); });
        // подготавливаем номер телефона в формате: +7 (912) 345-67-89
        let tel = '';
        for (let i = 0; i < modalRegInputTel.value.length; i++){
            if(i == 0) {
                if (modalRegInputTel.value[i] === '+') { tel += '+7'; i++; continue; }
                else if (modalRegInputTel.value[i] === '8') { tel += '+7'; continue; }
            }
            if(!isNaN(modalRegInputTel.value[i])) {
                tel += modalRegInputTel.value[i];
            }
        }
        tel = tel.slice(0, 2) + ' (' + tel.slice(2, 5) + ') ' + tel.slice(5, 8) + '-' + tel.slice(8, 10) + '-' + tel.slice(10);
        // подготавливаем и отправляем запрос на проверку номера телефона
        let formData = new FormData();
        formData.set('action', 'registration');
        formData.set('tel', tel);
        let request = fetch(siteAjaxUrl, {
            method: 'POST',
            body: formData
        }).then(response => response.text()).then((response)=> {
            console.log(response);
            response = response.slice(0, 2)
            if(response === 'error') {
                console.log('Номер занят');
                if(modalRegInputTel.classList.contains('ok')) {
                    modalRegInputTel.classList.remove('ok');
                }
                if(!modalRegInputTel.classList.contains('alert')) {
                    modalRegInputTel.classList.add('alert');
                }
            }
            else if (response === 'ok') {
                console.log('Номер свободен');
                if(formRegistrationEl.confirmf && formRegistrationEl.confirmi && formRegistrationEl.confirmtel){
                    modalRegistrationInputsEl.classList.remove('d-flex');
                    modalRegistrationInputsEl.classList.add('d-none');
                    modalRegistrationTelCheckEl.classList.remove('d-none');
                    modalRegistrationTelCheckEl.classList.add('d-flex');
                    modalRegistrationTelCheckEl.children[1].children[1].textContent = tel;
                    let count = modalRegistrationTelCheckEl.children[3].children[0].children[0].textContent;
                    let timerId = setInterval(() => {
                        count--;
                        modalRegistrationTelCheckEl.children[3].children[0].children[0].textContent = count;
                        if(count == 0) {
                            clearInterval(timerId);
                            modalRegistrationTelCheckEl.children[3].children[0].addEventListener('click', reSendTelCode );
                        }
                    }, 1000);
                }
            }
        });
    } else {
        console.log('ne checked');
        formRegistrationEl.addEventListener('submit', (event)=>{ event.preventDefault(); });
    }
}
function reSendTelCode(){
    modalRegistrationTelCheckEl.children[3].children[0].children[0].textContent = 60;
    modalRegistrationAction();
    modalRegistrationTelCheckEl.children[3].children[0].removeEventListener('click', reSendTelCode );
}
function modalRegistrationConfirmAction(el){
    if(!modalRegInputCode.value){
        console.log('net coda');
        modalRegInputCode.confirmcode = false;
        if(modalRegInputCode.classList.contains('ok')) {
            modalRegInputCode.classList.remove('ok');
        }
        if(!modalRegInputCode.classList.contains('alert')) {
            modalRegInputCode.classList.add('alert');
        }
    } else {
        if(modalRegInputCode.value.length === 6){
            // formRegistrationEl.confirmcode = true;
            console.log('Проверяем код с зарегистрированным пользователем');
            let formData = new FormData();
            formData.set('action', 'code-check');
            formData.set('tel', modalRegistrationTelCheckEl.children[1].children[1].textContent);
            formData.set('code', modalRegInputCode.value);
            let request = fetch(siteAjaxUrl, {
                method: 'POST',
                body: formData
            }).then(response => response.text()).then((response)=> {
                console.log(response);
                if(response === 'ok'){
                    console.log('Код совпал. Подтверждаем регистрацию для пользователя');
                    formRegistrationEl.submit();
                } else if (response === 'error') {
                    console.log('Код Не совпал. Попробуйте еще раз');
                    if(modalRegInputCode.classList.contains('ok')) {
                        modalRegInputCode.classList.remove('ok');
                    }
                    if(!modalRegInputCode.classList.contains('alert')) {
                        modalRegInputCode.classList.add('alert');
                    }
                }
            });
        } else {
            console.log('Неправильная длина кода');
        }
    }
    if(formRegistrationEl.confirmf && formRegistrationEl.confirmi && formRegistrationEl.confirmtel && formRegistrationEl.confirmcode)
    {
        formRegistrationEl.addEventListener('submit', (event)=>{ formRegistrationEl.submit(); });
    }
}
const modalRegInputF = document.getElementById('form-reg-f');
modalRegInputF.addEventListener('keyup', function (){ checkFInputElAction() });
const modalRegInputI = document.getElementById('form-reg-i');
modalRegInputI.addEventListener('keyup', function (){ checkIInputElAction() });
const modalRegInputTel = document.getElementById('form-reg-tel');
modalRegInputTel.addEventListener('keyup', function (){ checkTelInputElAction() });
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
const formPassRestoreEl = document.getElementById('form-pass-restore');
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
// показать больше новостей
function showMoreNewsAction(el){
    let count = 0;
    for (let i = 3; i < el.parentNode.parentNode.previousElementSibling.children[0].children.length; i++){
        if(count > 2) { break; }
        if(el.parentNode.parentNode.previousElementSibling.children[0].children[i].classList.contains('hidden')){
            el.parentNode.parentNode.previousElementSibling.children[0].children[i].classList.remove('hidden');
            count++;
        }
    }
    if(!el.parentNode.parentNode.previousElementSibling.children[0].lastElementChild.classList.contains('hidden')){
        el.classList.add('d-none');
    }
}
const showMoreNewsButtonEl = document.getElementById('show-more-news');
if(showMoreNewsButtonEl){
    showMoreNewsButtonEl.addEventListener('click', function (){ showMoreNewsAction(this); });
}
// показать больше новостей - конец
// показать меню пользователя
function userInfoAction(el){
    if(document.showUserInfo){
        document.showUserInfo = false;
        for(let i=0; i<showUserInfoEl.length; i++){
            showUserInfoEl[i].lastElementChild.classList.remove('d-flex');
            showUserInfoEl[i].lastElementChild.classList.add('d-none');
        }
    } else {
        document.showUserInfo = true;
        for(let i=0; i<showUserInfoEl.length; i++){
            showUserInfoEl[i].lastElementChild.classList.remove('d-none');
            showUserInfoEl[i].lastElementChild.classList.add('d-flex');
        }
    }
    event.stopPropagation();
}
const showUserInfoEl = document.getElementsByClassName('user-info');
for(let i=0; i<showUserInfoEl.length; i++){
    showUserInfoEl[i].addEventListener('click', function (){ userInfoAction(this); });
}
// показать меню пользователя - конец
// асинхронные запросы
function ajaxRequest(url, data){
    let requestUrl = url;
    console.log('URL: ', requestUrl);
    let requestData = data;
    console.log('DATA: ', requestData);
    let formData = new FormData();
    for (let key in requestData) {
        formData.set(key, requestData[key]);
    }
    let request = fetch(requestUrl, {
        method: 'POST',
        // headers: { 'Content-Type': 'text/plain;charset=utf-8' },
        body: formData
    }).then(response => response.text()).then((response)=> { console.log(response); return response; });
}
let siteAjaxUrl = 'http://bynextpr.ru/ajax/';
// асинхронные запросы - конец
// pop-up сообщения
function closePopUpMessageEl(){
    console.log('closePopUpMessageEl');
    console.log('Скрываем информационное сообщение');
    if(!popUpEl.classList.contains('d-none')){
        popUpEl.classList.add('d-none');
    }
    if(popUpEl.children[0].classList.contains('ok')){
        popUpEl.children[0].classList.remove('ok');
    }
    if(popUpEl.children[0].classList.contains('alert')){
        popUpEl.children[0].classList.remove('alert');
    }
}
function showPopUpMessageEl(status, message){
    popUpEl.classList.remove('d-none');
    if(status === 'ok'){
        popUpEl.children[0].classList.add('ok');
    }
    if(status === 'alert'){
        popUpEl.children[0].classList.add('alert');
    }
    popUpEl.children[0].children[1].textContent = message;
}
const popUpEl = document.getElementById('pop-up');
// pop-up сообщения - конец