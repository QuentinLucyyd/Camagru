var video = document.getElementById('video');
var prompt = document.getElementById('prompt');
var objects = [];
var crazy_links = ["http://www.pngmart.com/files/4/Crazy-PNG-Photos.png",
"https://openclipart.org/image/2400px/svg_to_png/169594/ndetavi-lc.png",
"http://vignette3.wikia.nocookie.net/trollpasta/images/1/1c/Squidward-Head-Funny.png/revision/latest?cb=20140924210814",
"http://25.media.tumblr.com/tumblr_mbje14ExV91qmsq48o1_1280.png"];
var x = new Number();
var y = new Number();
// Get access to the camera!
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
  // Not adding `{ audio: true }` since we only want video now
  navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
      video.src = window.URL.createObjectURL(stream);
      video.play();
  });
}
// Elements for taking the snapshot
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
var video = document.getElementById('video');

function addClass(el, className) {
  if (el.classList)
    el.classList.add(className);
  else if (!hasClass(el, className)) el.className += " " + className
}

function removeClass(el, className) {
  if (el.classList)
    el.classList.remove(className)
  else if (hasClass(el, className)) {
    var reg = new RegExp('(\\s|^)' + className + '(\\s|$)')
    el.className=el.className.replace(reg, ' ');
  }
}

document.getElementById("save").addEventListener("click", function() {
  var img = canvas.toDataURL("image/png");
  alert("Pressed");
  /*var element = document.getElementById('total');
  element.value = img;
  document.forms['submit-form'].submit();*/
  //document.getElementById("submit-form").submit();
});

document.getElementById("cat").addEventListener("click", function() {
var cat_img = new Image();
cat_img.src = "http://www.freeiconspng.com/uploads/cat-png-5.png";
objects.push(cat_img);
});
document.getElementById("rat").addEventListener("click", function() {
var rat_img = new Image();
rat_img.src = "http://pngimg.com/uploads/rat_mouse/rat_mouse_PNG23540.png";
objects.push(rat_img);
});
document.getElementById("rabbit").addEventListener("click", function() {
var rabbit = new Image();
rabbit.src = "http://pngimg.com/uploads/rabbit/rabbit_PNG3797.png";
objects.push(rabbit);
});
document.getElementById("crazy").addEventListener("click", function() {
var crazy = new Image();
crazy.src = crazy_links[Math.floor(Math.random() * crazy_links.length)];;
objects.push(crazy);
});
// Trigger photo take
document.getElementById("snap").addEventListener("click", function() {
  var test_img = new Image();
  test_img.scr = objects[0];
if (objects.length == 0){
  removeClass(prompt, "select-prompt");
}else{
  addClass(prompt, "select-prompt");
  x = Math.floor(Math.random() * canvas.width - 100) + 20;
  y = Math.floor(Math.random() * canvas.height - 100) + 20;
  context.drawImage(video, 0, 0, canvas.width, canvas.height);
  context.drawImage(objects[0], x, y, 150, 150);
  var img = canvas.toDataURL("image/png");
  var element = document.getElementById("total");
  element.value = img;
  document.getElementById("submit-form").submit();
}
});
