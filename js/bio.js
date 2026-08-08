


    startUp();

    window.addEventListener('load', () => {
        console.log('page loaded.');
        const page = document.getElementById('page');
        console.log('page: ', page);
        if (isMobile()) {
            page.classList.add('pageMobile');
                const adminLink = this.document.getElementById('admin');
                adminLink.classList.add('hidden');
        }
    })
