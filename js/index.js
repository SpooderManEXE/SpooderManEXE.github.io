document.addEventListener("DOMContentLoaded", function(event) {
var app = document.getElementById('app');
var typewriter = new Typewriter(app, {
    autoStart: true,
    loop: true,
    deleteSpeed: 2,
});

typewriter.typeString('I am also a ')
    .typeString('<strong><u>Designer!</u></strong>')
    .pauseFor(700)
    .deleteChars(9)
    .typeString('<strong><u>Programmer!</u></strong>')
    .pauseFor(700)
    .deleteChars(11)
    .typeString('<strong><u>Youtuber!</u></strong>')
    .pauseFor(700)
    .deleteChars(9)
    .typeString('<strong><u>Gamer!</u></strong>')
    .pauseFor(700)
    .deleteChars(6)
    .typeString('<strong><u>Cook!</u></strong>')
    .pauseFor(700)
    .start();
});
