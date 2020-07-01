"use strict";


class collection {

    constructor() {
        this.currentCategory = 'social';
        this.posters = [];  
        this.currentCategory = window.artquery.cat;
        this.currentSort = window.artquery.sort;
        this.posters = null; // these are the artwork objects
        // and the cRow dom elements are stored in the Row parameter of
        // each artwork object.
        
      //  console.log('constructing collection: cat='+this.currentCategory);
      console.log('sort: ' + this.currentSort);


    }
    setPosters(posters) {
        this.posters = posters;
      //  console.log(this.posters);
    }

    display() {
        console.log('colleciton displaying');
        $('#collection').show();
        $('#categoryButtons').show();
        $('.categoryButtons ul li').removeClass('buttonSelected');
       // $('.adminContent').show();
       
        $('#abstract').hide();
        $('#figurative').hide();
        $('#landscape').hide();    
      //  console.log('here');
        this.displaySection(this.currentCategory);
    }
    changeFilter(filter) {
        let filterString = filter.split('_');
        let newFilter = filterString[0];
        this.currentSort = newFilter;
        console.log(newFilter);
        window.artquery.setSort(newFilter);
        this.displaySection(this.currentCategory);

    }
    sortByTitleAsc() {

        this.posters.sort(function(a, b){
            console.log('Type is:'  );
            console.log(typeof a.title)
            let title1 = a.title.toString().toLowerCase();
            let title2 = b.title.toString().toLowerCase();

            
            if(title1 < title2) 
                return -1;
            
            if(title1 > title2) 
                return 1;
            
            return 0;
        });
    }
    sortByTitleDesc() {
            this.posters.sort(function(a, b){
             //   console.log('In sortByTitleDesc Type is:'  );
              //  console.log(typeof a.title)
                let title1 = a.title.toString().toLowerCase();
                let title2 = b.title.toString().toLowerCase();

                if(title1 > title2) return -1;
                if(title2 < title1) return 1;
                return 0;
            }); 
    }

    sortByCreatedAsc() {
        this.posters.sort(function(a, b){
            let date1 = new Date(a.created);
            let date2 = new Date(b.created);
            
            if(date1 < date2) 
                return -1;
            
            if(date1 > date2) 
                return 1;
            
            return 0;
        });
    }
    sortByCreatedDesc() {
        this.posters.sort(function(a, b){

            let date1 = new Date(a.created);
            let date2 = new Date(b.created);

            if(date1 > date2) return -1;
            if(date1 < date2) return 1;
            return 0;
        }); 
}

    sortPosters() {
        switch(this.currentSort) {
            case 'newest':
                this.sortByCreatedDesc();
                break;
            case 'created':
              this.sortByCreatedAsc();
            break;
            case 'title':
               // console.log('In sortPosters: ');
              //  console.log(typeof this);
               // console.log(": type");
              this.sortByTitleAsc();
            break;
            default:break;
        }
    }

    displaySection(section) {
        $('#collection').show();
        this.currentCategory = section;
        //console.log('display:'+section);
        $('.categoryButtons ul li').removeClass('buttonSelected');
        $('#'+section+'Button').addClass('buttonSelected');
       
        this.sortPosters();

        $('.cRow').remove();
        // $('.cRow').each( function(key,cRow) {
        //     let cat = $(cRow).attr('data-cat');
            
        //     if (cat == section) {
        //         $(cRow).css({'display':'inline-block'});
        //     }
        // });
        this.posters.forEach( function (poster, index) {
            if (poster.category == section) {
               // let newDom =  '<div class="cRow action" data-action="edit">' + $(poster.row).html() + '</div>';
                let string = $(poster.row).html();
                let newDom = $("<div class='cRow action' data-archived='"+poster.archived+"' data-action='edit' data-id='"+ poster.id+"'>" + string + "</div>");
                $('#collection').append(newDom);
                newDom.css({'display':'inline-block'});
                
            }
        });

        if (window.artquery) {
            window.artquery.setCat(section);
        }
        $('#newest_filter').removeClass('filter_on');
        $('#created_filter').removeClass('filter_on');
        $('#title_filter').removeClass('filter_on');

        switch(this.currentSort) {
            case 'newest':
                $('#newest_filter').addClass('filter_on');
                break;
            case 'created':
            $('#created_filter').addClass('filter_on');
            //console.log('turn on created');
            break;
            case 'title':
            console.log('turn on title');
            $('#title_filter').addClass('filter_on');
            break;
            default:break;
        }

        window.activatePosters();
    }
    
}