    sliding = false;
    currentX = 0;
    prevX = 0;
    startingPosition = 0;
    filter = 'available';
    chosenCategory = 'all';
 

    function expandFilterBox(e) {
        e.preventDefault();
        e.stopPropagation();
        closeMenu()
        clearQuery()

    
        const filterBox = this.document.getElementById('queryWrapper');
        const queryForm = this.document.getElementById('queryForm');
        console.log('QF: ', queryForm);
        console.log('Expanded: ', window.expanded);
       const navigator = this.document.getElementById('navigatorWrapper');
       // navigator.scrollTop = 0;
        
        if (window.expanded) {
            console.log('contracting');
            filterBox.classList.remove('mobileFiltersPosition2');
            filterBox.classList.add('mobileFiltersPosition1');
            window.expanded = false;
            const pN = this.document.getElementById('paintingNavigator');
            // console.log('pN: ', pN);
            pN.classList.remove('mobileNavigator2');
            queryForm.classList.remove('mobileExpandedQuery');
            
            // sfb = document.getElementById('showFilterButton');
            // sfb.textContent = 'Show Filters';
        } else {
            console.log('expanding');
            window.expanded = true;
            filterBox.classList.add('mobileFiltersPosition2');
            filterBox.classList.remove('mobileFiltersPosition1');
            const pN = this.document.getElementById('paintingNavigator');
            // console.log('pN: ', pN);
            pN.classList.add('mobileNavigator2');
            queryForm.classList.add('mobileExpandedQuery');
            // sfb = document.getElementById('showFilterButton');
            // sfb.textContent = 'Hide Filters';
        }
      

    }

    function clearQuery() {
        window.queryString = '';
        const queryInput = this.document.getElementById('query');
        queryInput.value = "";
        displayNavigator()
        displayCategoryNavigation()
    }

    function updateCounter() {
        const counter = document.getElementById('counter');
        if (counter) {
            if (window.queryString && window.queryString !== '') {
            if (chosenCategory  && chosenCategory !== 'all') {
                sentenceFinisher = " in the title, within the " + chosenCategory + " category.";
            } else {
                sentenceFinisher = " in the title.";
            }
            } else {
                sentenceFinisher = '.';
            }
        if (window.paintings.length) {
           
        if (window.queryString && window.queryString !=='') {
            switch(window.filter) {
                // case 'available':
                //     counter.innerHTML =  'Viewing only the paintings that match: <strong>' + window.queryString + '</strong> and are still available: ( '+ window.paintings.length + ' out of ' + window.fullset.length + ' paintings )'
                //     break;
                // case 'sold':
                //     counter.innerHTML =  'Viewing only the paintings that match: <strong>' + window.queryString + '</strong> and have already been sold: ( '+ window.paintings.length + ' out of ' + window.fullset.length + ' paintings )'
                //     break;
                default:
                    counter.innerHTML =  'There are ' + window.paintings.length + ' paintings that match: <strong>' + window.queryString + '</strong>' + sentenceFinisher;
                    break;
            }
        } else {
        switch(window.filter) {
            // case 'available':
            //     counter.textContent =  'Viewing '+ window.paintings.length + ' paintings.'
            //     break;
            // case 'sold':
            //     counter.textContent =  'Viewing only the paintings that have already been sold: '+ window.paintings.length + ' out of ' + window.fullset.length + ' paintings.'
            //     break;
            default:
                counter.textContent =  'Viewing ' + window.paintings.length + ' paintings'  + sentenceFinisher;
                break;
        }
      }
      }
      else {
        tryChanging = '<br>Try changing your search word';

        if (chosenCategory  && chosenCategory !== 'all') {
            tryChanging += ', or the category.';
        } else {
            tryChanging += '.';
        }
        switch(window.filter) {
          case 'available': 
            counter.innerHTML =  'Didn\'t find any paintings with <strong>' + window.queryString + '</strong>'  + sentenceFinisher + tryChanging;
            break;
          case 'sold':
            counter.innerHTML =  'Didn\'t find any paintings with <strong>' + window.queryString + '</strong>'  + sentenceFinisher+ tryChanging;
            break;
          default: 
          counter.innerHTML =  'Didn\'t find any paintings with <strong>' + window.queryString + '</strong>'  + sentenceFinisher+ tryChanging;
          break;
        }
      }
    }
    }

    function filterFromQuery() {
        displayNavigator()
        displayCategoryNavigation()
    }



    function sortPaintingsByCategory(paintings, category) {
        let subset = [];
        if (category.toLowerCase() === 'all') {
            subset = fullset;
            clearChosen();
        }
        else {
        subset = paintings.filter((painting) => {
            console.log('painting: ', painting);
            var list = painting.categories;
            console.log('list: ', list);
            if (list && list.length) {
            var found = list.includes(category.toLowerCase());
            if (found && !painting.sold) {
                return painting;
            }
        }
        } )
        }
        // console.log('Query: ', query);
        // console.log('subset: ', subset);
        return subset
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
                console.log('slideID: ', slideID);

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


        function clearChosen() {
            var catlinks= Array.from(document.getElementsByClassName('catLink'));

            catlinks.forEach((catLink) => {
                catLink.classList = 'catLink';
            });
        }
        function displayCategoryNavigation() {

            let categoriesArray = ['all', 'figurative', 'social-commentary', 'abstract', 'landscape', 'animals'];
            let categorySelector = document.getElementById('categorySelector');
            categorySelector.innerHTML = '';

            categoriesArray.forEach((category) => {

                categoryLink = document.createElement('div');
                categoryLink.classList = 'catLink';
                categoryLink.innerText = category;
                categorySelector.appendChild(categoryLink);

                categoryLink.addEventListener('click', (e)=> {
  

                        clearChosen();
                    e.target.classList = 'catLink chosen';
                    var category = e.target.innerText.toLowerCase();
                    window.chosenCategory = category;
                    displayNavigator()
                    // paintings = sortPaintingsByQuery(paintings, category)
                    // window.paintings = paintings;
                })
            })
       

        }
        function displayNavigator() {

            console.log('About to display navigator.');
        clearNavigator();
        const mainNav = document.getElementById('paintingNavigator')
        
        if (mainNav) {
        var index = 0

        // console.log('There are ', window.fullset.length, ' paintings.');
        //     console.log('Mobile?: ', isMobile());
       // console.log('loaded json paintings: ', paintings);


        paintings = sortPaintingsByDate(window.fullset)
        

        if (window.chosenCategory) {
            console.log('sorting by: ', window.chosenCategory);
            paintings = sortPaintingsByCategory(paintings,window.chosenCategory);
        }

        if (window.queryString && window.queryString !== '') {
            paintings = sortPaintingsByQuery(paintings, window.queryString)
        } 
          
       // paintings = sortPaintingsByFilter(paintings, window.filter);
        
        window.paintings = paintings;
     
        updateCounter()

        paintings.forEach(painting => { 
            // console.log('adding painting')
            const slideNav = document.createElement('div')

            const slideNavStyle = isMobile() ? 'mobileSlideNav' : 'slideNav';
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
            slideNavImg.setAttribute('data-id', imageName)
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
                console.log('slide: ', slideNo)
                if (!isMobile()) {
                  bigImage(e)
                }
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

    function filterOutSold(paintings) {

        return paintings.filter((painting) => !painting.sold)
    }



    
    var slideNumber = 0
    const divider = ',-*-,';
    let menuOpen = false;



    startUp();


    window.addEventListener('load', function() {


            const imageGallery = document.getElementById('image-gallery');
            const imageDirectory = 'uploads/artwork/'; 
            
            console.log('About to fetch paingints...');

            fetch('get_json.php')
            .then(response => response.json())
            .then(data => {
                console.log('Got data...', data);
                this.window.paintings = data.paintings
                this.window.fullset = filterOutSold(data.paintings)
                paintings.reverse()
                window.fullset.reverse()

                this.window.slideTotal = data.paintings.length
                updateCounter();
                
                displayNavigator()
                displayCategoryNavigation()
            })


            


            if (isMobile()) 
            {
                // console.log("MOBILE.");

                // sfb = document.getElementById('showFilterButton');
                // sfb.classList.remove('hidden');
                const adminLink = this.document.getElementById('admin');
                adminLink.classList.add('hidden');

            //     const nW = document.getElementById('navigatorWrapper');
            // // console.log('NW: ', nW);
            // if (nW) {
            // nW.classList.add('mobileWrapper');
            // }

            // const pN = this.document.getElementById('paintingNavigator');
            // // console.log('pN: ', pN);
            // if (pN) {pN.classList.add('mobileNavigator');}

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
                const adminLink = this.document.getElementById('admin');
                adminLink.classList.remove('hidden');
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
                    displayCategoryNavigation()
                }
            });
        }




          
        })