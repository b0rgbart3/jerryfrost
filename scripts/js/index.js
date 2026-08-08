    sliding = false;
    currentX = 0;
    prevX = 0;
    startingPosition = 0;
    filter = 'available';
 

    function expandFilterBox(e) {
        e.preventDefault();
        e.stopPropagation();
        closeMenu()
        const filterBox = this.document.getElementById('queryWrapper');
       const navigator = this.document.getElementById('navigatorWrapper');
       // navigator.scrollTop = 0;
        
        if (this.window.expanded) {
            console.log('contracting');
            filterBox.classList.remove('mobileFiltersPosition2');
            filterBox.classList.add('mobileFiltersPosition1');
            this.window.expanded = false;
            const pN = this.document.getElementById('paintingNavigator');
            // console.log('pN: ', pN);
            pN.classList.remove('mobileNavigator2');
            // sfb = document.getElementById('showFilterButton');
            // sfb.textContent = 'Show Filters';
        } else {
            console.log('expanding');
            this.window.expanded = true;
            filterBox.classList.add('mobileFiltersPosition2');
            filterBox.classList.remove('mobileFiltersPosition1');
            const pN = this.document.getElementById('paintingNavigator');
            // console.log('pN: ', pN);
            pN.classList.add('mobileNavigator2');
            // sfb = document.getElementById('showFilterButton');
            // sfb.textContent = 'Hide Filters';
        }
      

    }

    function clearQuery() {
        window.queryString = '';
        const queryInput = this.document.getElementById('query');
        queryInput.value = "";
    }

    function updateCounter() {
        const counter = document.getElementById('counter');
        if (counter) {
        if (window.paintings.length) {
        if (window.queryString && window.queryString !=='') {
            switch(window.filter) {
                case 'available':
                    counter.innerHTML =  'Viewing only the paintings that match: <strong>' + window.queryString + '</strong> and are still available: ( '+ window.paintings.length + ' out of ' + window.fullset.length + ' paintings )'
                    break;
                case 'sold':
                    counter.innerHTML =  'Viewing only the paintings that match: <strong>' + window.queryString + '</strong> and have already been sold: ( '+ window.paintings.length + ' out of ' + window.fullset.length + ' paintings )'
                    break;
                default:
                    counter.innerHTML =  'Viewing only the paintings that match: <strong>' + window.queryString + '</strong>  &nbsp;(' + window.paintings.length+' out of ' + window.fullset.length + ' paintings)'
                    break;
            }
        } else {
        switch(window.filter) {
            case 'available':
                counter.textContent =  'Viewing '+ window.paintings.length + ' paintings.'
                break;
            case 'sold':
                counter.textContent =  'Viewing only the paintings that have already been sold: '+ window.paintings.length + ' out of ' + window.fullset.length + ' paintings.'
                break;
            default:
                counter.textContent =  'Viewing ' + window.fullset.length + ' paintings.'
                break;
        }
      }
      }
      else {
        switch(window.filter) {
          case 'available': 
            counter.innerHTML =  'Didn\'t find any paintings with <strong>' + window.queryString + '</strong> in the title, that are also available.';
            break;
          case 'sold':
            counter.innerHTML =  'Didn\'t find any paintings with <strong>' + window.queryString + '</strong> in the title, that are also sold.';
            break;
          default: 
          counter.innerHTML =  'Didn\'t find any paintings with <strong>' + window.queryString + '</strong> in the title.';
          break;
        }
      }
    }
    }

    function filterFromQuery() {
        // console.log('Filter form query.');
        displayNavigator()
    }



      function sortPaintingsByQuery(paintings, query) {
        if (query && query !== '') {
            const subset = paintings.filter((painting) => (painting.title.toLowerCase().includes(query.toLowerCase())) )
            // console.log('Query: ', query);
            // console.log('subset: ', subset);
            return subset
        }
        else {
            // console.log('No query.');
            return paintings
        }
      }
    function sortPaintingsByFilter(paintings, filter) {
        switch (filter) {
            case 'sold':
                return paintings.filter(function(a) {
                    // Sort in descending order (true comes first)
                    return a.sold;
                });
            case 'available':
                return paintings.filter(function(a) {
                    // Sort in descending order (true comes first)
                    return !a.sold;
                });
            case 'all':
                // clearQuery();
                // return window.fullset;
                return paintings;
            default:
                return paintings;
        }
    }

    function bigImage(e) {


        const mainNavigator = document.getElementById('navigatorWrapper');
        mainNavigator.classList.add('hidden');

                const slideID = e.target.getAttribute('data-id');
                // console.log('slideID: ', slideID);

                const largeDisplaySlide = document.getElementById('largeDS');
                largeDisplaySlide.src = e.target.src;
                const largeDisplaySlideWrapper = document.getElementById('largeDSWrapper');
                largeDisplaySlideWrapper.classList.remove('hidden');

                largeDisplaySlideWrapper.addEventListener('click', (e) => {
                    const largeDisplaySlideWrapper = document.getElementById('largeDSWrapper');
                    largeDisplaySlideWrapper.classList.add('hidden');
                    const mainNavigator = document.getElementById('navigatorWrapper');
                    mainNavigator.classList.remove('hidden');
                })
               
        }
        
        function clearNavigator() {
            const mainNav = document.getElementById('paintingNavigator')
            if (mainNav) {
            mainNav.innerHTML='';
            }
        }

        function displayNavigator() {
        clearNavigator();
        const mainNav = document.getElementById('paintingNavigator')
        
        if (mainNav) {
        var index = 0

        // console.log('There are ', data.length, ' paintings.');
        //     console.log('Mobile?: ', isMobile());
       // console.log('loaded json paintings: ', paintings);


        paintings = sortPaintingsByDate(window.fullset)
       // console.log('DISPLAY WITH FILTER:', window.filter);

    //    console.log('Query: ', window.queryString);

        if (window.queryString && window.queryString !== '') {
            paintings = sortPaintingsByQuery(paintings, window.queryString)
        } 
          
        paintings = sortPaintingsByFilter(paintings, window.filter);
        
        window.paintings = paintings;

        // const categoriesDiv = document.getElementById('categoryBoxes');
        // if (categoriesDiv) {
        // while (categoriesDiv.firstChild) {
        //     categoriesDiv.removeChild(categoriesDiv.firstChild);
        //     }
        
        // categoriesArray.forEach(category => {
        //     // Create checkbox element
        //     const inputDiv = document.createElement('div');
        //     const checkbox = document.createElement('input');
        //     checkbox.type = 'checkbox';
        //     checkbox.id = category; // You can set the id to the category name if needed
        //     checkbox.name = category;
            
    
        //     //checkbox.checked = true;
    
          
        //     // Create label element
        //     const label = document.createElement('label');
        //     label.htmlFor = category;
        //     label.classList.add('categoryLabel');
        //     label.appendChild(document.createTextNode(category));
          
        //     // Append checkbox and label to the div
        //     inputDiv.appendChild(checkbox);
        //     inputDiv.appendChild(label);
        //     inputDiv.classList.add('catOption');

        //     categoriesDiv.appendChild(inputDiv);
          
        //     // Add a line break for better formatting
        //     categoriesDiv.appendChild(document.createElement('br'));
        //   });
        
        // }
        updateCounter()

        paintings.forEach(painting => { 
            // console.log('adding painting')
            const slideNav = document.createElement('div')

            const slideNavStyle = isMobile() ? 'mobileSlideNav' : 'slideNav'
            slideNav.classList.add(slideNavStyle)
            const slideNavImg = document.createElement('img')
            const imageName = painting.id; // painting.split(divider)[0];
            const slideInfo = document.createElement('div')
            const slideDate = document.createElement('div')
            const slideSold = document.createElement('div')
            slideSold.classList = 'soldMarker'

            const slideSize = document.createElement('div')
            slideSize.classList.add('slideSize')
            const slideTitle = document.createElement('div')
            slideInfo.classList.add('slideInfo')
            if (isMobile()) {
                slideInfo.classList.add('slideInfoMobile')
            } else {
                slideInfo.classList.remove('slideInfoMobile')
            }
            slideTitle.classList.add('slideTitle')
            slideDate.classList.add('slideDate')
            const paintingTitle = painting.title // painting.split(divider)[1]
            slideTitle.textContent = paintingTitle;

         

            if (painting.width && painting.height)
            {
                const thisPaintingWidth = parseFloat(painting.width);
                const thisPaintingHeight = parseFloat(painting.height);
                if (thisPaintingHeight > 0.0 && thisPaintingWidth > 0.0) {
                    slideSize.textContent = painting.width + "'' x " + painting.height + "'' "
                }
           
            }
        

            if (painting.month && painting.month !== "" && painting.month !== " " && painting.day !== "") {
                slideDate.textContent = painting.month + " " + painting.day + ", " + painting.year; //painting.split(divider)[4]
            }  else {
                slideDate.textContent = painting.year; //painting.split(divider)[4]
            }
          
            slideNavImg.src = slideNavImg.src = 'uploads/artwork/' + imageName + '.jpg';
            slideNavImg.setAttribute('data-slide-no', index)
            slideNav.appendChild(slideNavImg)
            slideInfo.appendChild(slideTitle)
            if (painting.sold) {
            slideInfo.appendChild(slideSold)
            }
            slideInfo.appendChild(slideDate)
         
            slideInfo.appendChild(slideSize)


            slideNav.appendChild(slideInfo)
            slideNavImg.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                const slideNo = e.target.getAttribute('data-slide-no')
                // console.log('slide: ', slideNo)
                bigImage(e)
            })
            mainNav.appendChild(slideNav)
          //  console.log('appending: ', slideNav)
            index++
        })
    }
    }
    

    function displaySlide(slideNo) {
        slideNumber = slideNo
        const slideInfo = data[slideNumber].split(divider);
        const slide = this.document.getElementById('slide');
        const filename = slideInfo[0];
        slide.src = 'uploads/artwork/' + filename + '.jpg';
        slide.setAttribute('data-id', filename);
        const slideTitle = this.document.getElementById('slideTitle');
        slideTitle.textContent = slideInfo[1];
    }



    
    var slideNumber = 0
    const divider = ',-*-,';
    let menuOpen = false;



    startUp();


    window.addEventListener('load', function() {


            const imageGallery = document.getElementById('image-gallery');
            const imageDirectory = 'uploads/artwork/'; 
     

            fetch('get_json.php')
            .then(response => response.json())
            .then(data => {
                this.window.paintings = data.paintings
                this.window.fullset = data.paintings
                paintings.reverse()
                window.fullset.reverse()

                this.window.slideTotal = data.paintings.length
                updateCounter();
                
                displayNavigator()
            })


            


            if (isMobile()) 
            {
                // console.log("MOBILE.");

                // sfb = document.getElementById('showFilterButton');
                // sfb.classList.remove('hidden');

                const nW = document.getElementById('navigatorWrapper');
            // console.log('NW: ', nW);
            if (nW) {
            nW.classList.add('mobileWrapper');
            }

            const pN = this.document.getElementById('paintingNavigator');
            // console.log('pN: ', pN);
            if (pN) {pN.classList.add('mobileNavigator');}

            // const qW = document.getElementById('queryWrapper');
            // qW.classList.add('mobileQuery');

            const q = document.getElementById('queryWrapper');
            if (q) {
            q.classList.add('mobileFiltersPosition1');}

            const e = document.getElementById('extras');
            if (e) {
            e.classList.add('extrasMobile');}


            // const flitersOption = document.getElementById('filter');
            // flitersOption.classList.remove('hidden');
  
            } else {
                // const flitersOption = document.getElementById('filter');
                // flitersOption.classList.add('hidden');
            }
               

            setupMenu();

            const queryInput = this.document.getElementById('query');
            // console.log('Query: ', query);
            // console.log('Found query Input: ', queryInput);
            if (queryInput) {
            queryInput.addEventListener('input', (event)=>{
                this.window.queryString = event.target.value
                // console.log('queryString: ', this.window.queryString);
            })
            queryInput.addEventListener('keydown', (event) => {
                // Check if the pressed key is Enter (key code 13)
                if (event.key === 'Enter') {
                    displayNavigator()
                }
            });
        }




          
        })