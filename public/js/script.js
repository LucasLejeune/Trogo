window.addEventListener('load', function () {

    const header = this.document.getElementById('headerAll');
    if (window.location.pathname == "/") {
        header.style.display = "none";
        console.log("Oui");
    }

    setTimeout(function () {
        const loadingScreen = document.getElementById('loading-screen');
        loadingScreen.classList.add('fade-out');

        loadingScreen.addEventListener('transitionend', function () {
            loadingScreen.style.display = 'none';
        });

        document.getElementById('landing-page').style.display = 'flex';
    }, 300);

    document.getElementById('landing-page').addEventListener('click', function () {
        this.classList.add('slide-up');
        setTimeout(() => {
            document.getElementById('homepage').classList.add('show-homepage');
            header.style.display = "block";
        }, 500)
    });
});

