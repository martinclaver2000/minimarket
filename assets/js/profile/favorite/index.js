
document.addEventListener('DOMContentLoaded', function() {
    const favoriteIcons = document.querySelectorAll('i.favorite-toggle');
    const phoneNumbers = document.querySelectorAll('a.phone-numbers');
    const contactsBySms = document.querySelectorAll('a.contacts-by-sms'); 
    const contactsByWhatsapp = document.querySelectorAll('a.contacts-by-whatsapp');

    phoneNumbers.forEach(phoneNumber => {
        phoneNumber.addEventListener('click', function(){
            number = this.getAttribute('data-phone-number');
            url = this.getAttribute('data-url');
            this.textContent = number;
                            
            // Envoie de la requête AJAX
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest' // Pour indiquer que c'est une requête AJAX
                },
            })
            .then(response => response.json())
            .then(data => {
                console.log('done!');
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        });
    });

    if (contactBySms !== null) {
        contactBySms.addEventListener('click', function(){
            url = this.getAttribute('data-url');                                
            // Envoie de la requête AJAX
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest' // Pour indiquer que c'est une requête AJAX
                },
            })
            .then(response => response.json())
            .then(data => {
                console.log('sms done!');
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        });
    }

    if (contactByWhatsapp !== null) {
        contactByWhatsapp.addEventListener('click', function(){
            url = this.getAttribute('data-url');                                
            // Envoie de la requête AJAX
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest' // Pour indiquer que c'est une requête AJAX
                },
            })
            .then(response => response.json())
            .then(data => {
                console.log('whatsapp done!');
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        });
    }
    
    favoriteIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const url = icon.getAttribute('data-url');
            
            // Envoie de la requête AJAX
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest' // Pour indiquer que c'est une requête AJAX
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.isFavorite) {
                    // Marquer comme favori (ajouter la classe fa-solid)
                    icon.classList.remove('fa-regular');
                    icon.classList.add('fa-solid');
                } else {
                    // Enlever des favoris (remettre la classe fa-regular)
                    icon.classList.remove('fa-solid');
                    icon.classList.add('fa-regular');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        });
    });
});