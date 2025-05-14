favoriteButton = document.querySelector('#favorite-btn')

if (favoriteButton) {
    let timeoutId = null;
    let lastState = null;

    favoriteButton.addEventListener('click', function () {
        const icon = this.querySelector('i');
        const isActive = icon.classList.contains('fas');
        const lastState = !isActive;

        icon.classList.toggle('fas', !isActive);
        icon.classList.toggle('far', isActive);

        this.classList.remove('clicked');
        void this.offsetWidth;
        this.classList.add('clicked');

        const workoutId = parseInt(favoriteButton.dataset.id)

        if (timeoutId !== null) {
            clearTimeout(timeoutId);
        }

        timeoutId = setTimeout(() => {
            const url = '/workouts/' + workoutId + '/favorite'

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ favorited: lastState })
            })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        icon.classList.toggle('fas', !lastState);
                        icon.classList.toggle('far', lastState);
                        alert('Erreur côté serveur.');
                    }
                })
                .catch(err => {
                    icon.classList.toggle('fas', !lastState);
                    icon.classList.toggle('far', lastState);
                    console.error('Erreur fetch :', err);
                    alert('Problème de réseau.');
                });

            timeoutId = null;
            lastState = null;
        }, 200);

    });
}


