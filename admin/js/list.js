"use strict";


class list {

    constructor() {
        $('.sorter').on('click',function(event){
            let sort = $(event.target).data('sort');
            window.artquery.setSort(sort);
            window.list.displaySort(sort);
           
        });
        this.sort = window.artquery.sort;

     //   this.rows = [];   // the TR dom elements (output in PHP)
        this.works = [];  // a list-local copy of the full works array
        this.order = 'ASC';
    }
    // setRows(rows) {
    //     this.rows = rows;
    // }
    setWorks(works) {
        this.works = works;
    }

    display() {
        $('#list').show();

        if (window.changeMade) {
            $('#updateNotice').show();
        } else {
            $('#updateNotice').hide();
        }
       // console.log('in ShowList method.');
        window.interrupt = true;
        this.displaySort(this.sort);
        //window.artquery.setTab('list');
        //window.tabController.display();
    }

    displaySort(sort) {
        $('.sorter').removeClass('sortSelected');
        $('#sort_'+sort).addClass('sortSelected');
       // console.log(sort);

       //console.log(this.rows);
       $('.listRow').hide();
       this.sort = sort;
       this.order = window.artquery.order;
       console.log('ORDER: '+this.order);
       this.sortRows();
       
       // oK - now we have to do the heavy lifting of actually sorting
       // the list (sorting the existing dom elements??)
       
    }
    sortByTitleAsc() {

        this.works.sort(function(a, b){
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
            this.works.sort(function(a, b){


                let title1 = a.title.toString().toLowerCase();
                let title2 = b.title.toString().toLowerCase();

                if(title1 > title2) return -1;
                if(title2 < title1) return 1;
                return 0;
            }); 
    }
    sortByCatAsc() {

        this.works.sort(function(a, b){
            let title1 = a.category.toLowerCase();
            let title2 = b.category.toLowerCase();
            
            if(title1 < title2) 
                return -1;
            
            if(title1 > title2) 
                return 1;
            
            return 0;
        });
    }
    sortByCatDesc() {
            this.works.sort(function(a, b){

                let title1 = a.category.toLowerCase();
                let title2 = b.category.toLowerCase();

                if(title1 > title2) return -1;
                if(title2 < title1) return 1;
                return 0;
            }); 
    }
    sortByCreatedAsc() {

        this.works.sort(function(a, b){
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
            this.works.sort(function(a, b){

                let date1 = new Date(a.created);
                let date2 = new Date(b.created);

                if(date1 > date2) return -1;
                if(date1 < date2) return 1;
                return 0;
            }); 
    }
    sortRows() {
        
        this.works.forEach( function(item,index) {
            $('.listRow').remove();
        });
        switch(this.sort) {
            case 'title':
        //    console.log('sort order: '+this.order);
                if (this.order=='ASC') {
                  this.sortByTitleAsc();
                } else {
                    this.sortByTitleDesc();
                }

            break;
            case 'created':
            if (this.order=='ASC') {
                this.sortByCreatedAsc();
              } else {
                  this.sortByCreatedDesc();
              }
            break;
            case 'category':
            if (this.order=='ASC') {
                this.sortByCatAsc();
              } else {
                  this.sortByCatDesc();
              }
            break;
        }

       
        this.works.forEach( function(item,index) {
            let newDom = "<tr class='listRow'>"+ $(item.row).html() + "</tr>";
           // console.log(newDom);
            $('.listtable').append(newDom);
        });

    }

    search(event) {
        let criteria = event.target.value;
        
        let inputs = $('input[type=text]');
        let titles = [];
        let found = [];
        $('input').removeClass('found');
        if (criteria!='') {
        $.each( inputs, function(i, input) {
            let firstpart = input.name.split('_')[0];
            if (firstpart == 'title') {
                titles.push(input);
            }
        });
        $.each(titles, function(i, title) {
           let lowerVersion = title.value.toLowerCase();
           let lowerCriteria = criteria.toLowerCase();
          let n = lowerVersion.indexOf(lowerCriteria);
          if (n != -1) {
              // found one
              found.push(title);
          }
        });
        $.each(found, function(i, input) {
      
          $(input).addClass('found');
          input.scrollIntoView({alignToTop:false, block: "end", inline: "nearest"});
        });
       }
      }
}