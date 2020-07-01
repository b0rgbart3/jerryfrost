
"use strict";
// This is my JS class definition for 'Artwork Objects'
class Artwork {

  constructor(id, title, category, created, image_filename, width, height, sold) {
    this.id = id;
    this.title = title;
    this.category = category;
    this.created = created;
    this.image_filename = image_filename;
    this.width = width;
    this.height = height;
    this.sold = sold;
  }  

  getSimpleDate() {
    let dateObject = new Date(this.created);
    return dateObject.toDateString();
  }

}

class liveImage {
  constructor(name) {
    this.name = name;
    this.image = null;
  }

}

// This is my JS class definition for a collection (mostly based on category) (except 'current')
class Collection {
  constructor(category) {
    this.category = category;
    this.works = [];
    this.liveImages = [];
  }



  domObjects() {
    let output = "";
    this.works.forEach((work, workIndex) => {
      if (work.image_filename != '') {
        output +="<a href='"+window.resourcepath+"/art.php?category="+this.category+"&id="+work.id+"'>";
      output += "<div class='catalogframe'>";
      output += "<div class='catalogimagecontainer'>";

      let path = '';

        path = 'uploads/thumbs/'+work.image_filename;

     
      output += "<img src='"+path+"' data-filename='"+work.image_filename+"' class='catalogImage' data-id='"+workIndex+"' data-category='"+work.category+"'>";
     // output += "<img src='uploads/artwork/"+work.image_filename+"'>";
      output += "</div>";
      output += "<div class='artworkBrass'>";
      output += "<p class='title'>"+work.title + "</p>";
      output += "<p class='date'>"+work.getSimpleDate() + "</p>";
      output += "<p class='size'>";
      output += work.width + " x " + work.height;
      output += "</p>";
      output += "</div>";
      output += "</div>";
      output += "</a>";
      }
    });
    return output;
  }
  // Look through all the work Objects on the page, and gather the ones that match this category
  gatherWorks() {

    window.workObjects.forEach((work, index) => { 
      
        if (work.category == this.category) { 
          if (work.image_filename != '') { 
            window.totalImages++;
          this.works.push(work);
          }
        }
    });
   
  }
 
   gatherOnlyCurrentWorks() {
     //console.log('Gathering only current');
    window.workObjects.forEach((work, index) => { 
      
       
        var today= new Date();
       // console.log(work.created);

        let dateString = work.created.split(' ');
        let objectDate = new Date(dateString[0]);
        //let diff = Math.abs(today-objectDate);
        //console.log(objectDate);
        let todayTime = today.getTime();
        let objectDateTime = objectDate.getTime();
      
        //console.log(work.created);

        //console.log(objectDateTime);
  
        let diff = Math.abs(todayTime-objectDateTime) / (24*60*60*1000);
      
        
        if (diff < 500) {
          //console.log('current');
          this.works.push(work);
         // console.log(work.title);
        } else {
         // console.log('not current');
        }
        
  });}

}



function createNewURL(category) {

    let newURL = 'catalog.php';
    newURL += "?cat="+category;
    return newURL;
}

function updateURL(change) {
  let newURL = createNewURL(change);

   window.history.pushState('Jerry Frost', 'Jerry Frost', newURL);

}

function getCatFromURL() {
  let currentURL = document.location.href;
  // console.log('currentURL: ' + currentURL);
    let splitatquestion = currentURL.split('?');
    let category = splitatquestion[1].split('='); 

    return category[1];
}

function imageDoneLoading(element) {

 let imageObects = $('.catalogImage');
 window.loadedImageCount++;
 window.completedImages.push(element.src);

  // for (let j = 0; j< imageObects.length; j++) {
    
  //   let thisImageObject = imageObects[j];
  //   let filename = $(thisImageObject).data('filename');
    
  //   let split = element.src.split('/');
  //   let loadedFilename = split[split.length-1];
  //  // console.log(loadedFilename + ', ' + filename);

  //   if (filename == loadedFilename) {
  //     window.loadedImageCount++;
  //     console.log("loaded: " + window.loadedImageCount);
  //     let info = "<p>Images Loaded: "+window.loadedImageCount+" </p>";
  //     $('#info').empty();
  //     $('#info').append(info);
  //     let parentFrame = $(thisImageObject).closest('.catalogframe');
  //     $(parentFrame).removeClass('tempHide');

  //     thisImageObject.src = element.src;
  //   }

    
  // }

}

// function loadImageArray() {
//   let info = "<p>Images Loaded: </p>";
//   $('#info').append(info);

//   window.categories.forEach(addImagesToPool);

//   //console.log('Pool length: ' + window.liveImages.length);
//  // loadImages();
// }

// function addImagesToPool(category) {
//     let collection = window.collections[category];

//     for (let i =0; i < collection.works.length; i++) {

//       let newName = collection.works[i].image_filename;
//       let newImage = new liveImage(newName);
//       window.liveImages.push(newImage);
//     }
// }

// function loadImages() {

//   let i = 0;
//   window.imageLoader = setTimeout( function loadImage() {
//     if (i >= window.liveImages.length) {
//       clearTimeout(window.imageLoader);
//     } else {
//       i++;
//       let image = new Image();  // this is a standard DOM object 
//       image.src = 'uploads/artwork/' + window.liveImages[i-1].name;
//    //   console.log(window.liveImages[i-1].name);
//       image.addEventListener('load', function() {
//         imageDoneLoading(this); 
//       });
//       setTimeout(loadImage, 300);
//     }
//   }, 300);
// }
// function loadImagesInThisCategory(category) {
//   console.log(category);
//   let collection = window.collections[category];
//   window.loadedImages[category] = [];
//   let i = 0;
//     window.imageLoader = setTimeout( function loadImage() {
    
//             if (i >= (collection.works.length) ) 
//             {
//                 clearTimeout(window.imageLoader);
//             } else 
//             {
//                 i++;
//             //    console.log(i);
//                 let image = new Image();
//                 image.src = 'uploads/artwork/' + collection.works[i-1].image_filename;
//                 image.addEventListener('load', function() { imageDoneLoading(this); } );
//                 window.loadedImages[category].push(image);
//                 // just storing the names so we can compare to see what's done loading
//                 window.imagesToLoad.push(collection.works[i-1].image_filename);

//                 setTimeout(loadImage, 50);
//             }
//         }, 50);

// }



function updatePageDisplay() {
    let category = window.category;
    updateURL(category);

    let collection = window.collections[window.category];

   // console.log('In updatePageDisplay: works:' + collection.works.length);

   // First - display some info:
   let targetDiv = $('#info');
   targetDiv.empty();
   let newDomObject = "<p>Number of paintings in this category: "+collection.works.length+"</p>";
   targetDiv.append(newDomObject);

    // Now we put in the actual thumbnail images
    targetDiv = $('.thumbContainer');
    targetDiv.empty();

    // Insert the collection of thumbnails into the page
    newDomObject = "" + collection.domObjects();
  //  console.log(newDomObject);
    targetDiv.append(newDomObject);

    // Set the highlighting on the category buttons
    $('.catalogNavItem').removeClass('catNavHigh');
    window.navButtonJQObjects.each( function( index, jqObject) {
    
      if ( $(jqObject).data('target') == category) {
         $(jqObject).addClass('catNavHigh');
      }
    });

    //console.log('loaded count:' + window.loadedImageCount);
    // if (window.loadedImageCount < window.workObjects.length) {
    // clearTimeout(window.imageLoader);
   
    // }

}

$( document ).ready(function() {
  console.log('doc ready.');
  window.completedImages = [];
  window.imagesToLoad = [];

  window.categories = ['social','abstract','figurative','landscape'];
  
  window.loadedImageCount = 0;
  window.loadedImages = [];
  window.totalImages = 0;
  console.log('page loaded.');
  // convert the hidden dom objects into a JS object
    let works = $('.workData');
    let workObjects = [];
    let collectionObjects = [];
    

    let navButtonJQObjects = $('.catalogNavItem');
    
    window.navButtonJQObjects = navButtonJQObjects;

    works.each( function( index, work ) {
  
      let workObject = $(work);
      let newWork = new Artwork(workObject.data('id'), workObject.data('title'), workObject.data('category'), workObject.data('date'), workObject.data('image_filename'), workObject.data('width'), workObject.data('height'), workObject.data('sold') );
      if (newWork.image_filename != '') {
      workObjects.push(newWork);}

    }) ;

   // console.log(workObjects);
    window.workObjects = workObjects;

   // console.log('total images we want: '+ window.workObjects.length);

    categories.forEach( function( category) {
      let collection = new Collection(category);
      
      collection.gatherWorks();
      collectionObjects[category] = collection;
     // console.log( category + ' works: ' + collection.works.length);
    });

    window.collections = collectionObjects;  // doing this twice intentionally
   // window.liveImages = [];
    //loadImageArray();

    // we have to manually create the current collection
    let collection = new Collection('current');

   // console.log('about to gather curren.t');
    collection.gatherOnlyCurrentWorks();
    //console.log('current works: ' + collection.works.length);
    collectionObjects['current'] = collection;

   // console.log(collectionObjects);

    window.collections = collectionObjects; // doing this twice intentionally

    let urlCategory = getCatFromURL();

    window.category= urlCategory;

    //console.log('starting category: ' + window.category);
   // console.log(window.collections['current']);
  
    updatePageDisplay();
    
    
    // window.checkProgress = setTimeout( function checkLoadProgress() {

    //   console.log('completed: ' + window.completedImages.length);
    //   console.log('total to load: ' + window.imagesToLoad.length);

    //   // console.log('Checking: ' + window.loadedImageCount);
    //   // console.log(window.totalImages);
    //   if (window.completedImages.length >= window.imagesToLoad.length) {
    //     console.log('ALL LOADED');
    //     clearTimeout(window.checkProgress);
    //   }
    //   else {
    //     setTimeout(checkLoadProgress, 1000);
    //   }
    // }, 1000);


    $('.catalogNavItem').on('click', function(event) {
      let category = $(event.target).data('target');
      window.category = category;
      updatePageDisplay();
      
    });

});

