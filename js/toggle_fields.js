// JavaScript Document
var rbut = document.getElementById('newsletter');
rbut.style.display = 'block';
var enterEmail = document.getElementById('yes');
var getNewsletter = document.getElementById('no');
enterEmail.onclick = function () {
    var email = document.getElementById('email');
    var sel = enterEmail.checked;
    email.parentNode.style.display = sel ? 'block' : 'none';
    var getMoreInfo = document.getElementById('getMoreInfo');
    var unsel = getNewsletter.checked;
    getMoreInfo.parentNode.style.display = unsel ? 'block' : 'none';
}
getNewsletter.onclick = function() {
     var getMoreInfo = document.getElementById('getMoreInfo');
     var sel = getNewsletter.checked;
     getMoreInfo.parentNode.style.display = sel ? 'block' : 'none';
     var email = document.getElementById('email');
     var unsel = enterEmail.checked;
     email.parentNode.style.display = unsel ? 'block' : 'none';
}
