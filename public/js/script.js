window.addEventListener('load', function () {

    const header = this.document.getElementById('headerAll');
    header.style.display = "none";

    setTimeout(function () {
        const loadingScreen = document.getElementById('loading-screen');
        loadingScreen.classList.add('fade-out');

        loadingScreen.addEventListener('transitionend', function () {
            loadingScreen.style.display = 'none';
        });

        document.getElementById('landing-page').style.display = 'flex';
    }, 500);

    document.getElementById('landing-page').addEventListener('click', function () {
        this.classList.add('slide-up');
        setTimeout(() => {
            document.getElementById('homepage').classList.add('show-homepage');
            header.style.display = "block";
        }, 500)
    });
});
