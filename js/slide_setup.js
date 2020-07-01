
let setupSlider = function() {
    console.log('setting up slide');
    window.sliding = false;
    let wwidth = $('.artContainer').width(); // window.innerWidth;
    let wheight = $('.artContainer').height(); //window.innerHeight;
    //$('.art_slider').css({height: wheight*.94});
    let maxheight = $('.art_slider').height() * .96;
    let mainwidth = wwidth*.9;
    let mainheight = maxheight;
    let c1 = $('.c1');
    let centerl = (wwidth /2);
    let c1left = centerl - (mainwidth / 2);
    let c1top = c1.position().top;

    c1.css({left: c1left, width: mainwidth, height:mainheight, top:10});
    window.c1left = c1left;

    window.mainwidth = mainwidth;
    window.mainheight = mainheight;
    window.c1 = c1;
  
  
    window.currentId = getInfoFromURL().id;// need id

    window.currentWork = findWork();

    slideDisplay();

    
    
}


