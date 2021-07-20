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