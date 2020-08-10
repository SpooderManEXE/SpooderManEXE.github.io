<html>
<script src="canvas2image.js"></script>
<link rel="stylesheet" href="bootstrap.min.css">
<meta name="viewport" content="width=device-width" />

<style>
@font-face {
  font-family: LEMONCAKE;
  src:     url('Lemon-Cake.ttf.woff') format('woff'),
    url('https://webfonts.ffonts.net/webfonts/L/E/Lemon-Cake/Lemon-Cake.ttf.svg#Lemon-Cake') format('svg'),
    url('https://webfonts.ffonts.net/webfonts/L/E/Lemon-Cake/Lemon-Cake.ttf.eot'),
    url('https://webfonts.ffonts.net/webfonts/L/E/Lemon-Cake/Lemon-Cake.ttf.eot?#iefix') format('embedded-opentype');
    font-weight: normal;
    font-style: normal;
}
body {
  background: #222;
  color: #fff;
  position:absolute;
  width: 100vw;
  text-align: center;
  font-size: 1rem;
  font-family: sans-serif;
  padding-bottom: 3em;
}
.page-wrap {
  display: inline-block;
  margin: 2em auto;
}
.controls {
  &__input {
    display: block;
    margin: 0 auto;
    background: none;
    border: none;
    font-size: 1em;
    padding-bottom: .5em;
    border-bottom: 2px solid #ccc;
    text-align: center;
    outline: none;
    color: #fff;
  }
  &__btn {
    background: dodgerblue;
    color: #fff;
    border: none;
    font-size: 1em;
  }
  &__label {
     display: block;
    font-size: .8em;
    padding-top: .3em;
    margin-bottom: 2em;
  }
}

canvas {
  background-color: #eee;
  // opacity: 0;
  transition: opacity .3s;
  &.show {
    opacity: 1;
  }
}
.canvas-wrap {
  margin-top: 50px;
  position: relative;
  width: 100vw;
}
#canvasID {
  z-index: 9999;
}

</style>


<div class="page-wrap">
  <div class="controls">
    <style>
    .mob{
        margin-top: 10%;
        font-size: 20px;
      }
    @media screen and (min-width: 768px){
      .mob{
        margin-top: unset;
        font-size: unset;
      }
    }
  </style>
<button type="button" id="download" class="btn btn-primary btn-lg btn-block mob">DOWNLOAD</button>
<h5><small id="passwordHelpBlock" class="form-text text-muted mb-4">
REFRESH if text has not loaded.    </small></h5>
<br><br>

  </div>
  <div id="canvas-wrap">
     <canvas style="display:block;margin-bottom:20px;width:100%;" id="imageCanvas" width=400px height=400px>
        <canvas id="canvasID"></canvas>
    </canvas>
  </div>

</div>
<script>
var nam="<?php echo $_GET["name"] ?>";
var wish="<?php echo $_GET["wish"] ?> ";

</script>
<script>

var text_title ="";
var imageLoader = document.getElementById('imageLoader');
    window.addEventListener('load', handleImage, false);
var canvas = document.getElementById('imageCanvas');
var ctx = canvas.getContext('2d');
var img = new Image();
img.crossOrigin="anonymous";

window.addEventListener('load', DrawPlaceholder)

function DrawPlaceholder() {
    img.onload = function() {
        DrawOverlay(img);
        DrawText();
        DynamicText(img)
    };
    //img.src = 'https://unsplash.it/400/400/?random';

}
function DrawOverlay(img) {
    ctx.drawImage(img,0,0);
    ctx.moveTo(150, 20);
    ctx.lineTo(150, 170);
    ctx.fillStyle = 'rgba(30, 144, 255, 0.0)';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
}
function DrawText() {
    ctx.fillStyle = "#ff0302";
    ctx.textBaseline = 'middle';
    ctx.font = "150px 'LEMONCAKE'";
    ctx.textAlign = "start";
    ctx.fillText("HAPPY ONAM!", 190, 700);
    ctx.textAlign = "center";
    ctx.fillStyle = "#00c2a0";
    ctx.font = "75px 'LEMONCAKE'";
    var x=550;
    var y=850;
    var words = wish.split(' ');
    var line = '';
    var firstY=y;
    var lineHeight=75*1.286; // a good approx for 10-18px sizes

    for(var n = 0; n < words.length; n++) {
      if(y<1300){
    var testLine = line + words[n] + ' ';
    var metrics = ctx.measureText(testLine);
    var testWidth = metrics.width;
    if(testWidth > 800) {
      ctx.fillText(line.toUpperCase(), x, y);
      if(n<words.length-1){
          line = words[n] + ' ';
          y += lineHeight;
      }
    }
    else {
      line = testLine;
    }
  }}
  ctx.fillText(line.toUpperCase(), x, y);
  var w=document.getElementById('wname');
  ctx.textAlign = "end";
  ctx.fillStyle = "#1f506e";
  ctx.font = "60px 'LEMONCAKE'";
  ctx.fillText("~ "+nam.toUpperCase(), x+350, 1400);

    //ctx.fillText(text_title, 1100, 500);
}
function DynamicText(img) {
  //document.getElementById('but').addEventListener('click', function() {
    setTimeout(function() {

    ctx.clearRect(0, 0, canvas.width, canvas.height);
    DrawOverlay(img);
    DrawText();
    text_title = this.value;
    wtext_title = w.value;
    //ctx.fillText(text_title, 1100, 500);
  }, 25);
}
function handleImage(e) {
  if(!window.location.hash) {
        window.location = window.location + '#loaded';
        window.location.reload();
    }
    var reader = new FileReader();
    var img = new Image();
        img.onload = function() {
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img,0,0);
        }
        img.src = "simg.jpg";
        var src = "simg.jpg";
        canvas.classList.add("show");
        DrawOverlay(img);
        DrawText();
        DynamicText(img);


    reader.readAsDataURL(e.target.files[0]);

}
function convertToImage() {
	window.open(canvas.toDataURL('png'));
}
document.getElementById('download').onclick = function download() {
		//convertToImage();
    Canvas2Image.saveAsPNG(canvas, 1080, 1920, "Wish_Insta")
}


</script>
</html>
