"use strict";


class archive {

    constructor() {
  
        this.posters = null;
    }
    setPosters(posters) {
        this.posters = posters;
    }
    display() {
    
        $('#archive').show();
       // $('#archive .cRow').css({'display':'inline-block'});

         $('.cRow').remove();

         let count = 0;
        this.posters.forEach( function (poster, index) {
            
            if (poster.archived == 1) {
                count++;
                let string = $(poster.row).html();
                console.log(string);
                let newDom = $("<div class='cRow action' data-action='edit' data-archived='"+ poster.archived+"' data-id='"+ poster.id+"'>" + string + "</div>");
                $('#archive').append(newDom);
                newDom.css({'display':'inline-block'});
                
            }
        });
        console.log('count: ' + count);
        window.activatePosters();
    }




    
}