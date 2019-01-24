// // random number function
function rndNum(min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}
// variables
var bodyWidth = $("body").width();
var body = document.querySelector("body");
var rainArray = [];
var dropCount = 300;
var n;
var speed = 30;
// create new span add drop class
function createRain() {
  var span = document.createElement("span");
  span.className = "drop";
  span.style.left = rndNum(0, bodyWidth) + "px";
  span.style.top = rndNum(-10, -1000) + "px";
  span.style.height = rndNum(10, 30) + "px";
  return span;
}
// add span to body
for (var i = 0; i < dropCount; i++) {
  rainArray[i] = createRain();
  body.appendChild(rainArray[i]);
  // body.appendChild(createRain());
  
}
// add top++ each rain drop
function rainDrop() {
  for (var i = 0; i < dropCount; i++) {
    n = Number(rainArray[i].style.top.split("px")[0]);
    n += speed;
    rainArray[i].style.top = n + "px";
    if (n >= 1000) {
      rainArray[i].style.top = rndNum(-10, -300) + "px";
    }
  }
}
// interval
setInterval(rainDrop, 10);

















// var speedArr = document.getElementsByName("speed");
// var countArr = document.getElementsByName("count");

// // click events 
// for(let i=0; i<speedArr.length; i++){
//   speedArr[i].addEventListener("click",function(e){
//     speed = e.target.value;
//   });
// }
// for(let i=0; i<countArr.length; i++){
//   countArr[i].addEventListener("click",function(e){
//     dropCount = e.target.value
//   });
// }
