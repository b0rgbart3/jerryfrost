// const categoriesArray = ['figurative', 'social-commentary', 'abstract', 'landscape', 'animals'];

var months = [
    'January', 'February', 'March', 'April',
    'May', 'June', 'July', 'August',
    'September', 'October', 'November', 'December'
  ];
var sortBy = 'entered'
var currentYear = '2024'
  
function addCategoryCheckboxes() {
    const categoriesDiv = document.getElementById('categoryBoxes');
    if (categoriesDiv) {
        console.log('Found categoryBoxes.');
        
    while (categoriesDiv.firstChild) {
        categoriesDiv.removeChild(categoriesDiv.firstChild);
    }
    
  

    categoriesArray.forEach(category => {
        // Create checkbox element
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.id = category; // You can set the id to the category name if needed
        checkbox.name = category;
        

        //checkbox.checked = true;

      
        // Create label element
        const label = document.createElement('label');
        label.htmlFor = category;
        label.classList.add('categoryLabel');
        label.appendChild(document.createTextNode(category));
      
        // Append checkbox and label to the div
        categoriesDiv.appendChild(checkbox);
        categoriesDiv.appendChild(label);
      
        // Add a line break for better formatting
        categoriesDiv.appendChild(document.createElement('br'));
      });
    }
}
  function generateYearSelector() {


        // Get a reference to the select element
        var yearSelect = document.getElementById('yearSelect');
        var monthSelect = document.getElementById('monthSelect');
        var monthOption = document.createElement('option');
        var daySelect = document.getElementById('daySelect');
        // monthOption.value = 'January'
        // monthOption.text = 'January'
        // monthSelect.appendChild(monthOption)
       

        var months = [
            'January', 'February', 'March', 'April',
            'May', 'June', 'July', 'August',
            'September', 'October', 'November', 'December'
          ];
          
          // Loop through the months and add options to the select element
          for (var i = 0; i < months.length; i++) {
            var option = document.createElement('option');
            option.value = months[i]; // Month values are typically 1-indexed
            option.text = months[i];
            monthSelect.add(option);
          }
          for (var i = 0; i <= 30; i++) {
            var option = document.createElement('option');
            option.value = i + 1;
            option.text = `${i+1}` ;
            daySelect.add(option);
          }

        
        // Get the current year
        var currentYear = new Date().getFullYear();
        
        // Create options for the select element from 1970 to the current year
        for (var year = 1975; year <= currentYear; year++) {
          var option = document.createElement('option');
          option.value = year;
          option.text = year;
          yearSelect.appendChild(option);
        }
        
        // Set a default selected year (e.g., current year)
        yearSelect.value = currentYear;
  }
   function showForm() {
        var inputForm = document.getElementById('inputForm')
        inputForm.classList.remove('hidden')

     

    

        // Get the reference to the div with id "categories"

     //   Loop through the array and create checkboxes
       
      
    }

    function hideForm() {
        var inputForm = document.getElementById('inputForm')
        inputForm.classList.add('hidden')
    }

    function hideEditButton() {
        var editInfo = document.getElementById('editInfo');
        editInfo.classList.add('hidden');
    }

    function showEditButton() {
        var editInfo = document.getElementById('editInfo');
        editInfo.classList.remove('hidden');
    }

    function showInfo() {
        var info = document.getElementById('info')
        info.classList.remove('hidden')
        generateYearSelector()
    }

    function hideInfo() {
        var info = document.getElementById('info')
        info.classList.add('hidden')
    }

    function editThisInfo(e) {
        var editorPic = document.getElementById("painting")
        var id = editorPic.getAttribute('data-id')
        hideInfo();
        hideEditButton();
        showForm();
    }

    function displayPaintings() {
        paintings.forEach(painting => {

            imageName = painting.id
            imageTitle = painting.title
            imageWidth = painting.width
            imageHeight = painting.height
            if (painting.month && painting.month !== '' && painting.month !== " ") {
                imageMonth= painting.month
            } else {
                imageMonth = 'January'
            }
            imageDay = painting.day
            imageYear = painting.year;
         
            imageCats = painting.categories;
            imageSold = painting.sold;
        


            const imgDiv = document.createElement('div');
            imgDiv.classList.add('iDiv');
  
            const img = document.createElement('img');
            img.setAttribute('data-id', imageName);
            img.setAttribute('data-title', imageTitle);
            img.setAttribute('data-width', imageWidth);
            img.setAttribute('data-height', imageHeight);
            img.setAttribute('data-month', imageMonth);
            if (imageDay && imageDay !== "") {img.setAttribute('data-day', imageDay);}
            img.setAttribute('data-year', imageYear);
            
            if (sortBy === 'date' && currentYear > imageYear) {
                currentYear = imageYear
                console.log('year: ',imageYear);
                const divider = document.createElement('div')
                const yearString = document.createElement('p')
                yearString.textContent = imageYear
                divider.appendChild(yearString)
                divider.classList.add('divider')
                imageGallery.appendChild(divider)
            }
            img.setAttribute('data-cats', imageCats);
            img.setAttribute('data-sold', imageSold);

            img.classList.add('painting');
            img.src = 'uploads/artwork/' + imageName + '.jpg';
         
            imgDiv.appendChild(img);
            

            // display the image and info when thumbnails are clicked
            imgDiv.addEventListener("click", function(e) {
                e.preventDefault();
                e.stopPropagation();
          
                hideForm();
                showInfo();
                var editPic = e.target.src;
                var editorPic = document.getElementById("painting");
                editorPic.src = editPic;
                editorPic.setAttribute('data-id', e.target.getAttribute('data-id'));
               // var id = editorPic.attributes('data-image-name');
                var inputId = document.getElementById('inputId');
                window.inputId = inputId;
                inputId.value = e.target.getAttribute('data-id');
                var title = e.target.getAttribute('data-title');
                var width = e.target.getAttribute('data-width');
                var height = e.target.getAttribute('data-height');
                var month = e.target.getAttribute('data-month');
                var day = e.target.getAttribute('data-day');
                var year = e.target.getAttribute('data-year');
                var cats = e.target.getAttribute('data-cats');
                var sold = e.target.getAttribute('data-sold');
              

                var editTitle = document.getElementById('pTitle');
                editTitle.textContent = title;
                var editWidth = document.getElementById('pWidth');
                editWidth.textContent = width;
                var editHeight= document.getElementById('pHeight');
                editHeight.textContent = height;

                var editMonth = document.getElementById('pMonth');
                editMonth.textContent = month
                if (day) {
                var editDay = document.getElementById('pDay');
              
                editDay.textContent = day
            
                } else {
                    var editDay = document.getElementById('pDay');
              
                    editDay.textContent = ""
                }
                var editYear = document.getElementById('pYear');
                editYear.textContent = year;

                
                
                var formTitle = document.getElementById('inputTitle');
                formTitle.value = title;
                var formWidth = document.getElementById('inputWidth');
                formWidth.value = width;
                var formHeight = document.getElementById('inputHeight');
                formHeight.value = height;
                
                var formMonth = document.getElementById('monthSelect');
                //console.log('Looking for: ', month);
                // const localIndex = window.months.indexOf( month)
                // console.log('index: ', localIndex);
                formMonth.value = month; // window.months.indexOf( month)
                var formDay = document.getElementById('daySelect');
                formDay.value = day;
                var formYear = document.getElementById('yearSelect');
                formYear.value = year;

                console.log('year: ', year)
  

                for (var i = 0; i < categoriesArray.length; i++) {

                    category= categoriesArray[i];
                  
                    var checkbox = document.getElementById(category);
                  

                    thisCatWasChosen = cats.includes(category);
                    if (checkbox && thisCatWasChosen) {
                        checkbox.checked = true;
                    } else {
                        checkbox.checked = false;
                    }
                    
                }

                var formSold = document.getElementById('sold');
      
                formSold.checked = false;
                if (sold === 'true') {
                    formSold.checked = true;
                }
                

                var sizeDiv = document.getElementById('theSize');
                if (!width || !height) {
                    sizeDiv.classList.add('hidden');
                } else {
                    sizeDiv.classList.remove('hidden');
                }
                var editInfoButton = document.getElementById('editInfo');
                editInfoButton.classList.remove('hidden');
             
            });
            //imgKill.appendChild(killImg);
           // imgDiv.appendChild(imgKill);
         
            imageGallery.appendChild(imgDiv);
        });
    }

    function sortByEntered() {
        sortBy = 'entered'
        console.log('BD: sort by entered.');
        clearAdminavigator()
        paintings = Array.from(originalset)
        displayPaintings()
    }


    function clearAdminavigator() {
        const mainNav = document.getElementById('image-gallery')
        if (mainNav) {
        mainNav.innerHTML='';
        }
    }


    function sortByDate() {
        sortBy = 'date'
        console.log('BD: sort by date.');
        clearAdminavigator()
        sortPaintingsByDate(paintings)
        displayPaintings()
    }
// JavaScript code to load and display images from a directory
    window.addEventListener('load', function() {
            const divider = ',-*-,';

            const imageGallery = document.getElementById('image-gallery');
            this.window.imageGallery = imageGallery;
            const imageDirectory = 'uploads/artwork/'; 

            addCategoryCheckboxes();


            fetch('get_json.php')  //names
            .then(response => response.json())
            .then(data => {

                data.paintings.reverse();  // start with the last one added
                paintings = data.paintings
                originalset = Array.from(paintings);
             //   sortPaintingsByDate(paintings)

               displayPaintings()
          })
            .catch(error => console.error('Error fetching data:', error));
  

        });


  