$( document ).ready(function() {


    window.works = $('.work');
    window.workcount = window.works.length;
    window.workNumber = 0;
    window.mainpic = $('#mainpic');
    window.tsource = $('#transparent');
  //  alert(JSON.stringify(tsource.attr('src')));
  // mainpic.attr('src', tsource.attr('src'));

  //  window.sequence = new TimelineLite({paused:true});

  //  window.sequence.to('.GalleryPic', 1, { opacity:.1, onComplete: runsequence});

  //  setTimeout(function(){ show(); }, 400);

  flip = setTimeout(flipMe, 3000);
});

let nextFadeIn=function() {
  console.log('In next fade.');
  window.mainpic.attr('src',window.newSource);
  console.log(window.newSource);
  fadeIn = new TimelineLite({paused: true});
  fadeIn.to(window.mainpic, 6, {opacity:1,});
  fadeIn.to(window.mainpic, 3, {opacity:1, onComplete: flipMe});
  fadeIn.play();
}
let flipMe=function() {
    window.workNumber++;
    if (window.workNumber >= window.workcount) {
        window.workNumber = 0;
    }
    //console.log('workNumber:' + window.workNumber);
    let newImage = window.works[window.workNumber];
    let newSource = newImage.src;
    window.newSource = newSource;
    fadeOut = new TimelineLite({paused: true});
    fadeOut.to(window.mainpic, 2, {opacity:.01, onComplete: nextFadeIn });
    fadeOut.play();


}

