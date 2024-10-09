document.addEventListener('DOMContentLoaded', () => {
    const darkModeToggle = document.getElementById('darkModeToggle');
    const body = document.body;
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');
    const popup = document.getElementById('popup');
    const closePopup = document.querySelector('.close');
    const popupMessage = document.getElementById('popup-message');

    // menyimpan tema saat ini
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme) {
        body.classList.add(currentTheme);
    }

    // Dark mode toggle
    darkModeToggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        localStorage.setItem('theme', body.classList.contains('dark-mode') ? 'dark-mode' : 'light-mode');
    });

    // Hamburger menu
    hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });

    // Navigasi
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = e.target.getAttribute('href').substring(1);
            document.querySelectorAll('main > section').forEach(section => {
                section.style.display = 'none';
            });
            document.getElementById(targetId).style.display = 'block';
            navLinks.classList.remove('active');
        });
    });

    // Popup
    window.showPopup = (message) => {
        popupMessage.textContent = message;
        popup.style.display = 'block';
    };

    closePopup.addEventListener('click', () => {
        popup.style.display = 'none';
    });

    window.onclick = (event) => {
        if (event.target == popup) {
            popup.style.display = 'none';
        }
    };
});
