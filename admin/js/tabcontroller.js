"use strict";


class tabController {

    constructor() {
 
        this.currentTab = window.artquery.tab;

    }


display() {  
    let tab = window.artquery.tab;
   // console.log('tab controller : ' + tab);
    $('.tab').removeClass('tab_selected');
    $('#'+tab+'Tab').addClass('tab_selected');
    $('#showsPanel').hide();
    $('#list').hide();
    $('#archive').hide();
    $('#shows').hide();
    $('#collection').hide();
    switch(tab) {
        case 'collection':
            window.collection.display();
            break;
        case 'archive':
            $('#categoryButtons').hide();
            window.archive.display();
            break;
        case 'shows':
            $('#categoryButtons').hide();
            $('#showsPanel').show();
            break;
        case 'list':
            $('#categoryButtons').hide();
           window.list.display();
            break;
        default: 
            break;
    }
    // if (window.artquery) {
    // window.artquery.setTab(tab);
    // }
}

 moveToTab(tab) {
    //console.log('about to move to tab: ' + tab);
    $('.tab').removeClass('tab_selected');
    window.artquery.setTab(tab);
    this.display();
}

}