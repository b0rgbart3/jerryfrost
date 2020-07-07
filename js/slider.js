
$( document ).ready(function() {

    window.sliding =false;
    window.works = $('.work');
    window.work_count = window.works.length;

    window.titles = [];
    window.dates = [];
    window.sizes = [];
    window.solds = [];

    let choiceObject = getInfoFromURL();
    let choice = choiceObject['category'];
    window.category = choice;
    window.desiredWorkNumber = choiceObject['piece'];
    window.keyCount = 0;
    window.addEventListener('keydown', (e) => {
      if (!e.repeat) {
        window.keyCount=0;
        console.log('key:' +e.key);
      if (e.key && e.key=='ArrowDown' || e.key=='ArrowRight') {
        go_left();
      }
      if (e.key && e.key=='ArrowUp' || e.key=='ArrowLeft') {
        go_right();
      }
     } else {
       console.log('key repeating: ' + window.keyCount);
       window.keyCount++;
       if (window.keyCount >= 3) {
         window.keyCount =0;
         if (e.key && e.key=='ArrowDown' || e.key=='ArrowRight') {
          go_left();
        }
        if (e.key && e.key=='ArrowUp' || e.key=='ArrowLeft') {
          go_right();
        }
       }
     }
    });
    if (choice != 'all') {
    $('.titleTextBack h2').html(choice); } else
    {
      $('.titleTextBack h2').html('artist');
    }
    
    let bottom = $('#swiper').position().top + $('#swiper').height();

    $('.titleTag').css({'top':"-60px"});


    checkMobile();

    if (!window.isMobile) {
      
      // Mobile has a different layout / funcitonality - but I'm keeping this in here
      // so that we can mimic a 'swipe' event on desktop machines
      var myElement = document.getElementById('swiper');
     // document.addEventListener("wheel", wheelTrack);
      setupSlider();

      var hammertime = new Hammer(myElement);
      hammertime.on("swipeleft", go_left);
      hammertime.on("swiperight", go_right);
     
    }
    else {
      mobileSliderLayout();
    }
    slideFit();
});

let mobileSliderLayout = function() {

$('.titleTag').remove();
  $('.swiper').remove();
  $('.art_slider').remove();
  $('.slide').remove();
  $('.artContainer').remove();

$('.prev').hide();
$('.next').hide();


$('.work').each( function() {
  let image_path = $(this).data('source');
  if (image_path != '') {
  let domObject = "<img src='uploads/artwork/" + image_path + "'>";
  let titleObject = "<div class='titleBrass'>";
  titleObject += "<h1>";
  titleObject += $(this).data('title');
  titleObject += "</h1>";
  titleObject += "<p>";
  titleObject += $(this).data('width') +" x " + $(this).data('height');
  titleObject += "</p>";
  titleObject += "<p>";
  titleObject += $(this).data('created');
  titleObject += "</p>";
  titleObject += "</div>";
  $(this).append( domObject );
  $(this).append( titleObject );
  }
 });


$('.hiddenImages').css({'display':'block'});

console.log('currentId: ' + window.currentId);
if (window.currentId != null) {
console.log('have an id in mind.');

    window.location.href = "#"+window.currentId;

}

}
  
let loaded=function( ) {

  // use exact imageID instead of all this find BS

  sizeObject = sizeImage(window.c1, window.c1.find('img').attr('src'));
  window.c1.find('img').css(sizeObject);
  window.c1.css({opacity: 1});

}



let slideFit = function() {

  let title_div = $('#tt_title');

  var title_text = $(window.currentWork).data('title');
  console.log("Title: " + title_text);
   title_div.text(  title_text );
    let date_div = $("#tt_date");

   date_div.html( $(window.currentWork).data('created') );

   let size_div = $(".tt_size");

    size_div.html( $(window.currentWork).data('width') + " x " + $(window.currentWork).data('height'));

    let sold_div = $('.tt_sold');
    if ($(window.currentWork).data('sold')) {
      sold_div.html( "<span class='soldSpan'></span>"); 
    } else {
      sold_div.html("still available");
    }


      let thisImage = new Image();
      thisImage.src = window.c1.find('img').attr('src'); 
      if (thisImage.complete) {
          loaded();
        } else {
          thisImage.addEventListener('load', loaded  )
          thisImage.addEventListener('error', function() {
   
          })
        }
    
}


let slideDisplay = function() {
   console.log('in slideDisplay');
    let cW = window.currentId;
   // console.log(cW);
//console.log(window.c1.find('img').attr('src'));
  //  sizeObject = sizeImage(window.c1, window.c1.find('img').attr('src'));
  //   window.c1.find('img').css(sizeObject);
  // window.c1.firstChild.setAttribute("width", "200px");
  // window.c1.firstChild.setAttribute("height", "200px");

    //window.c1.style.setAttribute({ 'opacity': 1});
   // var centralImage = document.getElementById("art_slider");  //centralImage

    // centralImage.style.width = "100px";
    // centralImage.style.height = "100px";
    let title_div = $('.tt_title');
   title_div.html( $(window.currentWork).data('title') );
    let date_div = $(".tt_date");
   date_div.html( $(window.currentWork).data('created') );
   let size_div = $(".tt_size");
    size_div.html( $(window.currentWork).data('width') + " x " + $(window.currentWork).data('height'));
    let sold_div = $('.tt_sold');
    if ($(window.currentWork).data('sold')) {
      sold_div.html( "<span class='soldSpan'></span>"); 
    } else {
      sold_div.html("still available");
    }

}

let selectCategory=function(event) {
  getBaseURL();
 // console.log(window.baseURL);
  if (event && event.target && event.target.value) {
  let choice = event.target.value;
  document.location.href = window.baseURL + '/art.php?category='+choice;
}

}