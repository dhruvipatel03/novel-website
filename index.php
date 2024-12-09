<?php include 'includes/header.php'?>
<?php include 'includes/db_connect.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novelwebsite</title>
    <style>
* {box-sizing: border-box;}
body {font-family: Verdana, sans-serif;}
/* Caption text */
.text {
  color:white;
  font-size: 35px;
  font-weight: bolder;
  margin-top: -500px;
  padding: 0px 12px;
  position: absolute;
  width: 100%;
  text-align: center;
}
.slideimg{
    width: 100%;
    height: 580px;
}
.join{
  width: 15%;
  height: 80px;
  color: bisque;
  background-color: transparent;
  border:solid 2px white;
  padding: 20px;
  border-radius: 25px;
  font-size: 25px;
}
.join:hover{
  background-color: darkgray;
  color: chocolate;
  border-color: brown;
}
.buzz-container{
  width: 100%;
  height: auto;
  display: flex;
}
.row{
  width: 25%;
  margin-left: 20px;
}
.buzz-image{
  width: 100%;
  height: 430px;
  border-radius: 14%;
  padding: 20px;
}
.buzz-text{
  line-height: 20px;
  margin-top: -20px;
  width: 100%;
  height: auto;
  padding: 0px 40px;
}
.latest-buzz{
  text-align: center;
  font-size: 35px;
  font-weight: bolder;
  padding: 20px;
  color: indigo;
}
.txt{
  width: 100%;
  height: auto;
  font-size: 23px;
  padding: 0px 150px;
}
/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .text {font-size: 11px}
}
a{
  text-decoration: none;
  color: white;
}
</style>
</head>
<body>
<div class="slideshow-container">
<div class="mySlides fade">
  <img class="slideimg" src="images/main.jpg">
  <div class="text">
   <h1 style="color:blanchedalmond">Epic Reads</h1> 
   <h6>Dive into a universe where every page is a new adventure!</h6>
   <button class="join"><a href="/novelwebsite/pages/blog.php">About us</a></button>
 
  </div>
</div>
</div>
<p class="latest-buzz">Latest buzz</p>
<div class="buzz-container">
<div class="row">
  <img class="buzz-image" src="images/buzz1.jpeg" alt="">
  <div class="buzz-text">
  <h2>New Release: The Unseen Chronicles</h2>
  <p>August 25, 2024 </p>
  <p>
Get ready for a wild ride! This novel will twist your mind and tickle your funny bone. Don't miss it!</p>
</div>
</div>

<div class="row">
  <img class="buzz-image" src="images/buzz2.jpeg" alt="">
  <div class="buzz-text">
  <h2>Author Spotlight: Jane Wildheart</h2>
  <p> August 20, 2024</p>
  <p>Meet the genius behind the chaos! Jane’s latest book is a rollercoaster of emotions and sarcasm. Buckle up!</p>
</div>
</div>

<div class="row">
  <img class="buzz-image" src="images/buzz3.jpeg" alt="">
  <div class="buzz-text">
  <h2 >Genre Explosion: Sci-Fi Madness</h2>
  <p>August 15, 2024 </p>
  <p>Aliens, robots, and dystopian futures await! This genre is hotter than a jalapeño in a sauna. Get in on the action!</p>
</div>
</div>

<div class="row">
  <img class="buzz-image" src="images/buzz4.jpeg" alt="">
  <div class="buzz-text">
  <h2>Book Club: Join the Fun!</h2>
  <p>August 20, 2024 </p>
  <p>Love books? Hate boredom? Join our club for wild discussions and even wilder snacks! Don’t be shy!</p>
</div>
</div>
</div>
<p class="latest-buzz">Our Literary Odyssey</p>
<div class="txt">
<p>Welcome to the ultimate haven for book lovers! Here, we don’t just read novels; we live them, breathe them, and occasionally throw them across the room when the plot twist is too much to handle.</p>
<p>Our mission? To connect passionate readers with the stories that ignite their imaginations and keep them up at night. We believe that every book is a portal to another universe, and we’re here to help you find your next adventure.</p>
<p>Behind this literary revolution is a team of bookworms, caffeine addicts, and professional procrastinators who have dedicated their lives to curating the best novels. Join us as we embark on this wild ride through the pages of imagination!</p>
</div>
<p class="latest-buzz">Join Our Literary Adventure!</p>
</body>
</html>
<?php include 'includes/footer.php'?>