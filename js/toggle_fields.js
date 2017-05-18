// JavaScript Document
var cbox = document.getElementById('newsletter');
cbox.style.display = 'block';
var enterEmail = document.getElementById('yes');
enterEmail.onclick = function () {
    var email = document.getElementById('email');
    var sel = enterEmail.checked;
    email.parentNode.style.display = sel ? 'block' : 'none';
}
