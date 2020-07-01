"use strict";


class artQuery {
    constructor() {
        this.tab = 'collection';
        this.cat = 'social';
        this.sort= 'title';
        this.order='ASC';  // ascending order
        this.getQueryFromURL();
        console.log('finished constructing the query: cat='+this.cat);
        if (this.cat == '') {
            this.cat = 'social';
        }
    }

    log() {
        console.log("Art Query:");
        console.log('tab: '+this.tab);
        console.log('cat: '+this.cat);
        console.log('sort: '+this.sort);
        console.log('order: '+this.order);
           
    }
    // the first time our artQuery object is instantiated, we want to
    // grab the args from the url

    getQueryFromURL() {
        let tab = 'collection';
        let cat = 'social';
        let sort= 'title';
        let order='ASC';  // ascending order

        let currentURL = document.location.href;
       //  console.log('currentURL: ' + currentURL);
          let args = currentURL.split('?');
        //  console.log('split: ' + args[0]);
          if (args.length < 2) {
            //  console.log('no args');
             // displayTab('collection');
          } else {
          let splitArgs = args[args.length-1].split('&');
          
        //  console.log(splitArgs);
          
          if (splitArgs) {
          if(splitArgs.length>3) {
              // then we have a category value
              tab = splitArgs[0].split('=')[1];
              cat = splitArgs[1].split('=')[1];
              sort = splitArgs[2].split('=')[1];
              order = splitArgs[3].split('=')[1];
          } else {
              // no category value
              tab = splitArgs[0].split('=')[1];
              cat = '';
              if (splitArgs[1]) {
              sort = splitArgs[1].split('=')[1];
              order = splitArgs[2].split('=')[1];
              }
          }


          }
        }
        this.tab = tab;
        this.cat = cat;
        this.sort = sort;
        this.order = order;
     //  console.log('Tab='+tab);
      // console.log('Sort='+sort);
      // console.log('Order='+order);
    }


    setCat(category) {
        this.cat = category;
        this.updateURL();
    }
    presetSort(presort) {
        this.sort = presort;
        displaySort(this.sort);
    }
    setSort(sort) {
        if (sort == this.sort) {
            if (this.order=='ASC') {
                this.order='DESC';
            } else {
                this.order='ASC';
            }
         }
            
        this.sort = sort;
  
       // this.sortByKey(window.works, sort)

       // For sorting we do a HARD url update - which will pass the heavy lifting
       // of the sort order to PHP (and the MYSQL database)
        //let newURL = this.createNewURL();
       // this.updateURL();
        //console.log('NewURL: ' + newURL);
         this.updateURL();
    }
    setTab(tab) {
        let change = false;
        if (this.tab != tab) {
            change = true;
        }
        this.tab = tab;
        
        switch(tab) {
            case 'collection':
                this.cat = 'social'; // we always start out at the first tab
                this.sort='title';
                this.order='ASC';
            break;
            case 'list':
                this.cat = '';  // if we're on the big list, then we don't separate the categories
            break;
            case 'archive':
                this.cat = '';
                this.sort = 'title';
                this.order='';
            break;
            
            default: break;
        }
 
        this.updateURL(change);
    }
   getBaseURL() {
        let currentURL = document.location.href;
     //   alert(currentURL);
// console.log('currentURL: ' + currentURL);
          let everythingbeforethelastslash = currentURL.split('/');
          let everythingpiececount = everythingbeforethelastslash.length;
         // console.log('count = ' + everythingpiececount);
          let leftover = everythingbeforethelastslash[everythingpiececount-1];
    
          everythingbeforethelastslash.splice(-1,1)
          let baseURL = everythingbeforethelastslash.join('/');
         // console.log('base url: ' + baseURL);
          if (window.resourcepath) {
            //  baseURL += window.resourcepath;
          }
          
          return baseURL;
    }

    hasargs() {
        if ((this.tab != '') || (this.cat != '') || (this.sort != '') || (this.order !='') ) {
            return true;
        } else {
            return false;
        }
    }
    
    createNewURL() {
      //  console.log('creating');
       // let newURL = this.getBaseURL() + "/dashboard.php?";
        let newURL = this.getBaseURL() + "/dashboard.php?";
        //if (this.hasargs()) { newURL += "?";}
        if (this.tab != '') { newURL += "tab="+this.tab; }
        
        if (this.cat != '' && this.tab !='list') { newURL += "&cat="+this.cat; }
        if (this.sort != '') { newURL += "&sort="+this.sort; }
        if (this.order != 'ASC' && (this.order!= 'DESC')) {
            this.order = 'ASC';
        }
        if (this.order != '') { newURL += "&order="+this.order; }
        return newURL;
    }
    // This does a "soft" update on the URL to reflect what's happening 
    // but note this does not do a hard refresh, so JS is taking care of most of the functionality
    // rather than passing it on to PHP 
    updateURL(change) {
        let newURL = this.createNewURL();

        //if (change) {
          //  document.location.href = newURL;
       // } else {
         window.history.pushState('Jerry Frost', 'Jerry Frost', newURL);
        //}
         //document.location.href = newURL;
    }


    sortByKey(array, key) {
        return array.sort(function(a, b) {
            var x = a[key];
            var y = b[key];

            if (typeof x == "string")
            {
                x = (""+x).toLowerCase(); 
            }
            if (typeof y == "string")
            {
                y = (""+y).toLowerCase();
            }

            return ((x < y) ? -1 : ((x > y) ? 1 : 0));
        });
    }

}
