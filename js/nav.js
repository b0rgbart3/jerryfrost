let getInfoFromURL = function() {
    let currentURL = document.location.href;
    // console.log('currentURL: ' + currentURL);
      let splitatquestion = currentURL.split('?');
     // console.log('split: ' + splitatquestion[0]);
      let splitatampersand = splitatquestion[splitatquestion.length-1].split('&');
    //  console.log(splitatampersand);
      let categoryparts = splitatampersand[0].split('=');
      let category = categoryparts[1];
    //  console.log('category parts' + categoryparts);
      let pieceparts = splitatampersand[1].split('=');
      let id = pieceparts[1];
      let infoObject = { 'category': category, 'id': id };
    //  console.log(infoObject);

      return infoObject;
}

let getBaseURL = function() {
    let currentURL = document.location.href;
    //  console.log('currentURL: ' + currentURL);
      let everythingbeforethelastslash = currentURL.split('/');
      let everythingpiececount = everythingbeforethelastslash.length;
    //  console.log('count = ' + everythingpiececount);
      let leftover = everythingbeforethelastslash[everythingpiececount-1];

      everythingbeforethelastslash.splice(-1,1)
      let baseURL = everythingbeforethelastslash.join('/');
    //  console.log('base url: ' + baseURL);
      window.baseURL = baseURL;
}
let selecting = false;
let hideSelections = function() {
    window.selecting = false;
   // console.log('hiding');
     $(".mySelections").hide();
}
let showSelections = function() {
    window.selecting = true;  
  //  console.log('showing');    
    $(".mySelections").show();
}

let toggleSelections = function() {
    
     if (window.selecting) {
         hideSelections();
     } else {
         showSelections();
     }
     
}
let navigate = function(event) {
    event.preventDefault();
    event.stopPropagation();
    if (window.burgerNavShowing) {
        window.burgerNavShowing = false;
        $('.mySelector').show();
        $('.navigation').hide();
        $('.burger').removeClass('burgerSelected');
    } else {
        if (window.innerWidth < 820) {
            $('.mySelector').hide();
            $('.navigation').css({'max-width':'100%', 'position':'static', 'float':'none'});
         } else {
                $('.navigation').css({'width':'400','max-width':'400px', 'z-index':'4','position':'absolute', 'right':'0' });
            }
       // $('.mySelector').hide();
        $(".mySelections").hide();
        window.burgerNavShowing = true;
        $('.burger').addClass('burgerSelected');
        $('.navigation ul li').css({'display':'block', 'padding-top':'24px', 'padding-bottom':'14px','border-bottom':'2px solid #444444', 'z-index':'400' });
        $('.navigation').show();
    }
}
$( document ).ready(function() {
    $('.prev').on('click', function() {
        go_left();
        event.preventDefault();
        event.stopPropagation();
    });
    $('.next').on('click', function(event) {
        go_right();
        event.preventDefault();
        event.stopPropagation();
    });
    hideSelections();
    $('.homePhoto').on('click', function() {
        let number = window.workNumber + 2;
        document.location.href='/art.php?category=current&piece='+number;
    });
    $('.admin').on('click', function() {
        document.location.href='admin/index.php';
    });
    $(".burger").on('click',function(event) {
        
        navigate(event);
    });
    

//     $(window).on('click', function() {
//    //     hideSelections();
//     });
    $('.mySelectorTop').on('click', function(event) {
        toggleSelections();
        $('.navigation').hide();
        event.stopPropagation();
        event.preventDefault();
       // console.log('click');
    });

    // $('.mySelectorTop').on('click', function(event) {
    //     toggleSelections();
    // });
    $('.artContainer').mouseup(function (e)
    {
        var container = $("#mySelections");
  
        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
           // container.hide();
            hideSelections();
           //  console.log('hiding on mouseup');
        }
    });

    $('.mySelectorItem').on('click', function(event) {
        getBaseURL();
        let baseURL = window.baseURL;

        let choice = $(event.target).data('choice');
       
        document.location.href = baseURL + '/art.php?category='+choice+'&id=' +
          $(event.target).data('id');
        
    });
    $('.hot').on('click',function( event ) {
       
        getBaseURL();
        let baseURL = window.baseURL;

        let destination = $(event.target).data('destination');
   //     console.log('destination: ' + destination);
        if (!destination) {
            destination = 'home';
        }
        switch(destination) {
            case 'home': 
            document.location.href = baseURL;
              break;
            case 'shows':
                document.location.href=baseURL + '#upcoming';
                break;
            case 'contact': 
               document.location.href= baseURL + '#contact';
              break;
            case 'bio':
                document.location.href=baseURL + '#bio';
                break;
            case 'catalog':
                document.location.href=baseURL + '/catalog.php?category=current';
                break;
            default: 
               document.location.href = baseURL + '/art.php?category='+destination+'&id=' + $(event.target).data('id');
              break;
        }

    //     if (desire === 'contact') {
    //        document.location.href= baseURL + '#contact';
    //     } else {
    //      document.location.href = baseURL + '?work='+desire;
    //  }
    });

    $(window).on('click', function(event) {
       
   //    console.log('got this hit');
       hideSelections();
       if (window.burgerNavShowing) {
        window.burgerNavShowing = false;
        $('.mySelector').show();
        $('.navigation').hide();
        $('.burger').removeClass('burgerSelected');
    } 
    });
});