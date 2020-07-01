




$( function() {
    window.artquery = new artQuery();
    window.tabController = new tabController();
    window.collection = new collection();
    window.archive = new archive();
    window.list = new list();
    //let rows = [];
    let works = [];
    let posters = [];
    $('.filter').on('click', function(event) {
        let filter = event.target.id;
       // console.log(filter);
        window.collection.changeFilter(filter);
      });

    $('.cRow').each( function(index,row) {
        
        // note: this is a bit redundant - because we are doing the same
        // thing with the rows in the list -- but for now I want to have
        // the collection and the list have their own array of artwork

        let poster = new Work( $(row).data('id'), $(row).data('title'),  
        $(row).data('created'),  $(row).data('cat'), $(row).data('archived'), row  );
       // console.log(row);
        posters.push(poster);
    });
    window.collection.setPosters(posters);
    window.archive.setPosters(posters);

    $('.listRow').each( function(index,row) {
        //let rowObject = $(row);
        //rows.push(row);  // am I still using these rows - or not?
        // I think everything might be happening with the works
        // (which also store the row );

        let work = new Work( $(row).data('id'), $(row).data('title'),  
            $(row).data('created'),  $(row).data('category'), $(row).data('archived'),  row  );
        works.push(work);
    });

    for (var i=0; i<5; i++) {
        let work = works[i];
      //  console.log(work);
    }

   // window.list.setRows(rows);
    window.list.setWorks(works);

    window.tabController.display();

    // These are the large file folder tabs for collection vs. archive vs shows
    $('.tab').on('click', function(event) {
    $('#updateNotice').hide();
    let tab = '';
    if (event && event.target && event.target.dataset) {
        tab = event.target.dataset['tab'];
    //   console.log('tab: ' + tab);
    //   window.tab = tab;
    }
    window.tabController.moveToTab(tab);
    event.preventDefault();
    event.stopPropagation();
});

    if (!window.interrupt) {
        $('#updateNotice').hide();
      }
    

    // These are the smaller tabs that I'm calling Buttons - for the various categories / sections
    $('.categoryButtons ul li').on('click',function(event){
        // $('.categoryButtons ul li').removeClass('buttonSelected');
        // $(event.target).addClass('buttonSelected');
        let cat = $(event.target).html().toLowerCase();
        event.preventDefault();
        event.stopPropagation();
     //   console.log('chose: ' + cat);
        window.collection.displaySection(cat);
    });
    $('.remove_show').on('click', function(event) {
        console.log('removing show if confirmed.');
        let id = '';
        let element = $(event.target);
        
        id = $(element).data('id');
        ok_to_remove = confirm("Are you sure you want to remove this show, with id: " + id + " ?");
    
            if (ok_to_remove) {
                location.href='remove_show.php?id='+id;
            } else {
                location.href='dashboard.php';
            }
    });

    $('.editshow').on('click',function(event) {
        let element = $(event.target);
        // console.log('element: ' + JSON.stringify(element) );
         event.preventDefault();
       event.stopPropagation();
       if (!element.hasClass('editshow')) {
         element = element.closest('.editshow');
       }
       let id = element.data('id');
       //console.log(id);
       let newURL = "edit_show.php?id="+id;
       console.log(newURL);
       location.href=newURL;

    });

   


  });


  window.activatePosters=function() {
    $('.action').on('click', function(event) {
        console.log('got action: '+event.target);
         let element = $(event.target);
         console.log('element: ' + JSON.stringify(element) );

         let action = '';
         let id = '';
        if (!element.hasClass('actButton')) {
            let cRow = element.closest('.cRow');
          //  console.log(cRow);
   
           id = $(cRow).data('id');
           action = $(cRow).data('action');
        } else {
            id = element.data('id');
           action = element.data('action');
        }
        

       let ok_to_remove = false;
       event.preventDefault();
       event.stopPropagation();
   
        switch(action) {
            case "addimages":
            location.href='addimages.php?id='+id;
            break;
            case "addvideo":
            location.href='addvideo.php?id='+id;
            break;
            case "edit":
            location.href='edit.php?id='+id;
            break;
            case "edit_show":
            location.href='edit_show.php?id='+id;
            break;
            case "archive":
            location.href='archivethis.php?id='+id;
            break;
            case "unarchive":
            location.href='unarchivethis.php?id='+id;
            break;
            case "remove":
            ok_to_remove = confirm("Are you sure you want to remove this piece, with id: " + id + " from the collection?");
        
                if (ok_to_remove) {
                    location.href='remove.php?id='+id+'&tab='+window.tab;
                } else {
                    location.href='dashboard.php';
                }
                break;
            case "remove_show":
            // console.log('removing show');
           
            // ok_to_remove = confirm("Are you sure you want to remove this show, with id: " + id + " from the collection?");
        
            //     if (ok_to_remove) {
            //         location.href='remove_show.php?id='+id;
            //     } else {
            //         location.href='dashboard.php';
            //     }
                break;
            default:
            break;
        }
    });
  }
