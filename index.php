<html>
<link rel="bookmark"  type="image/x-icon"  href="/Onam2020/sultan.png"/>
<link rel="shortcut icon" href="/Onam2020/sultan.png">

        <title>
  CraftCoder By Sulthan Nizarudin
  </title>
  <meta name="keywords" content="Sulthan Nizarudin,CraftCoder,Onam,Poster,Youtube" />
<meta name="viewport" content="width=device-width" />
<link rel="stylesheet" href="Onam2020/bootstrap.min.css">
<style>
.mob{
    margin:25% 0 10% 0;
  }
  body {
   background-image: url("Onam2020/bgs.jpg");
   background-color: white;
   background-size: contain;
  }

@media screen and (min-width: 768px){
  .mob{
    margin:8% 25%;
    -webkit-box-flex:0;
    -ms-flex:0 0 50%;
    flex:0 0 50%;
    max-width:50%;
    align-self:center!important;
  }
  body {
   background-image: url("Onam2020/bgw.jpg");
   background-color: white;
   background-size: cover;
  }
}
</style>
<body style="overflow: hidden">

<script>
function setLocation(element) {
        document.getElementById('PForm').action = element.value;
}

</script>

<div class="mob">
<form class="text-center border border-light p-5" id="PForm" action="#" method="get">

    <p class="h4 mb-4">ONAM CELEBRATION POSTER GENERATOR</p>


    <p class="h4 mb-2">NAME</p><input type="text" id="defaultLoginFormEmail" class="form-control mb-4" name="name">


    <p class="h4 mb-2">CUSTOM WISH</p><textarea type="text" name="wish" id="wish" class="form-control mb-2" maxlength=125 rows=4><?php
$a=array("Here’s wishing you health, wealth and happiness. May the spirit of Onam remain everywhere.","Let the sweet frangrance of flowers fill our homes and the aroma of home-cooked delicacies tease our senses.","On this joyous occasion of Onam, I wish you joy and good health and may you always enjoy the bounty of nature!", "May King Mahabali bless you with good health and happiness. May all your hopes, dreams and wishes come true.", "May the colours and joy of Onam fill your home and heart with happiness and prosperity. May you always enjoy a good fortune.");
shuffle($a);
$random_keys=array_rand($a,5);
echo $a[$random_keys[0]];
?></textarea>
    <h5><small id="passwordHelpBlock" class="form-text text-muted mb-4">
'Happy Onam' is already included    </small></h5>
    <div class="d-flex justify-content-around">
      <div class="form-check">
<input class="form-check-input" type="radio" name="t" id="exampleRadios1" value="Onam2020/wide.php" onclick="setLocation(this)">
<label class="form-check-label" for="exampleRadios1">
  Wide Poster
</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="t" id="exampleRadios2" value="Onam2020/story.php" onclick="setLocation(this)">
<label class="form-check-label" for="exampleRadios2">
  Long Story Poster
</label>
</div>
    </div>

    <button class="btn btn-info btn-block" type="submit">CREATE POSTER</button>

</form>
</div>
<footer class="page-footer font-small blue">

  <!-- Copyright -->
  <div class="footer-copyright text-center">Subscribe:
    <a href="https://www.youtube.com/channel/UCmszvVQKqM7v5PR_nMrm7YQ?sub_confirmation=1/"> CraftCoder by Sulthan Nizarudin</a>
  </div>
  <!-- Copyright -->

</footer>
</body>
</html>
