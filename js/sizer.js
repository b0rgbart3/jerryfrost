
let TimeHandler = function() {
 // alert('waited.');
}

window.timehandler = TimeHandler;

let sizeImage=function(sliderDiv, activeImage) {
    let thisImage = new Image();
    thisImage.src = activeImage; 

    console.log("This Image width: " + thisImage.width);
    let margins = 20;
    let originalwidth = thisImage.width;
    let originalheight = thisImage.height;


    let divWidth = sliderDiv.width();
    let divHeight = sliderDiv.height();
    let topMargin = 0;
   // console.log('original width: ' + originalwidth);
   // console.log('activeImage: '+activeImage);
   
   
//    if (originalwidth < 300) {
//       // This probably means the image has just not loaded yet,
//       // so let's wait until it finishes loading.
      
//       let waitTimer = setTimeout( window.timehandler, 3000);
//       window.waiter = waitTimer;
//    }
   


   
    if (thisImage.width > thisImage.height) {
        //console.log('landscape');
        thisImage.width = divWidth  - (margins*2);
        let percentage = thisImage.width / originalwidth;
        let newheight = thisImage.height * percentage;
        thisImage.height = newheight;
        if (thisImage.height > (divHeight-(margins*2) )) {
            thisImage.height = divHeight - (margins*2);
            let percentage = thisImage.height / originalheight;
            let newwidth = originalwidth * percentage - (margins*2);
            thisImage.width = newwidth;
        }
        // adjust the top margin if the work is a wide rectangle
        if ((divHeight - thisImage.height) > 10) {
            topMargin = (divHeight - thisImage.height) / 4;
        }
    } else {
        //console.log('portrait');
        thisImage.height = divHeight - (margins*2);
        let percentage = thisImage.height / originalheight;
        let newwidth = thisImage.width * percentage;
        thisImage.width = newwidth;

        if (thisImage.width > divWidth) {
            thisImage.width = divWidth - (margins*2);
            percentage = thisImage.width / originalwidth;
            thisImage.height = originalheight * percentage;
        }   
    }
    // assign these new calculations to the image in the DOM
   // let imageToChange = sliderDiv.find('img');
    let returnObject = {width: thisImage.width, height: thisImage.height, top: topMargin}
    
    if (thisImage.width < 10 ) {
        // If this image didn't load yet, then we are going to 'refresh' it after
        // it finishes loading.

        thisImage.onload = function() {
        console.log('loaded this image: ' + this.width);
            location.reload();
        };
    }
    
    return (returnObject);
}

