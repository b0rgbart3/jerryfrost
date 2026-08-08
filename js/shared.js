menuCreated = false;
menuOpen = false;

function isMobile() {
    if (navigator.userAgent.match(/Android/i)
    || navigator.userAgent.match(/webOS/i)
    || navigator.userAgent.match(/iPhone/i)
    || navigator.userAgent.match(/iPad/i)
    || navigator.userAgent.match(/iPod/i)
    || navigator.userAgent.match(/BlackBerry/i)
    || navigator.userAgent.match(/Windows Phone/i)) {
       return true;
    } else {
       return false;
    }
}



function closeMenu() {
    console.log('close menu');
    menuOpen = false;
    const menuWrapper = document.getElementById('menuWrapper');
    menuWrapper.classList.add('hidden');
    const logo = document.getElementById('logo');
    logo.classList.remove('logoOn');
}

function setupMenu() {

    if (isMobile()) {
      logo = this.document.getElementById('logo');
      logo.classList.add('mobileLogo');
      const filterIcon = this.document.getElementById('filterIcon');
      if (filterIcon) {
      filterIcon.classList.remove('hidden');}
    } else {
        const filterIcon = this.document.getElementById('filterIcon');
        if (filterIcon) {
        filterIcon.classList.add('hidden');}
    }
    if (!menuCreated) {


    menuCreated = true;

    console.log('BD: SETTING UP MENU....');
    const logo = document.getElementById('logo');

    const logoWrapper = document.getElementById('logoWrapper');
    const burger = document.getElementById('burger')

    logoWrapper.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        console.log('target: ', e.target.id);

        switch(e.target.id) {
            case 'home':
                window.location.href = "./index.php";
                break;
            case 'gallery':
                window.location.href = "./gallery.php";
                break;
            case 'bio':
                window.location.href = "./bio.php";
                break;
            case 'statement':
                   window.location.href = "./statement.php";
                   break;
           case 'contact':
               window.location.href = "./contact.php";
               break;
           // case 'filter':
           //    // window.location.href='./index.php'
           //     closeMenu()
           //     expandFilterBox()
           //     break;
            case 'catalog':
               // window.location.href = "./catalog.php";
                break;
            case 'admin':
               window.location.href = "/admin"
            default:
                break;

        }
    })

    logo.addEventListener('click',(e) => {

        e.preventDefault();
     console.log('target: ', e.target.id);
    //  console.log('parent: ', e.target.parentElement.id);
     e.stopPropagation();
     
     switch(e.target.id) {
         case 'logo':
         case 'logoWrapper':
         case 'burger':
         case 'burger-image':
         case 'artist':
         case 'artist-span':
             if (!menuOpen) {
                console.log('open menu');
                 menuOpen = true;
                 const menuWrapper = document.getElementById('menuWrapper');
                 menuWrapper.classList.remove('hidden');
                 const logo = document.getElementById('logo');
                 logo.classList.add('logoOn');
             }   else {
                closeMenu();
             }
             break;
         case 'home':
             window.location.href = "./index.php";
             break;
         case 'bio':
             window.location.href = "./bio.php";
             break;
         case 'statement':
                window.location.href = "./statement.php";
                break;
        case 'contact':
            window.location.href = "./contact.php";
            break;
        // case 'filter':
        //    // window.location.href='./index.php'
        //     closeMenu()
        //     expandFilterBox()
        //     break;
         case 'catalog':
            // window.location.href = "./catalog.php";
             break;
         case 'admin':
            window.location.href = "/admin"
         default:
             break;

     }
    })

    const filters = Array.from(document.getElementsByClassName('filter'));
    console.log('FILTERS: ', filters);
    filters.forEach((filter) => {
        filter.addEventListener('click', function(event) {
            const filterId = event.target.getAttribute('data-filter');
            console.log('filterid: ', filterId);
            const filters = Array.from(document.getElementsByClassName('filter'));
            filters.forEach((filter) => {
                filter.classList.remove('filterOption');
            })
            event.target.classList.add('filterOption');
            window.filter = filterId;

            if (filterId === 'all') {
                clearQuery();
            }

            displayNavigator();

        });
    })
}


}


function startUp() {

    window.addEventListener('click', function(e) {
        // e.preventDefault();
        // e.stopPropagation();
       closeMenu();
    });

    window.addEventListener('load', function() {

          setupMenu();


        })



    }