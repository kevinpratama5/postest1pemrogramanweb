document.addEventListener('DOMContentLoaded', () => {
    const darkModeToggle = document.getElementById('darkModeToggle');
    const body = document.body;
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');
    const popup = document.getElementById('popup');
    const closePopup = document.querySelector('.close');
    const popupMessage = document.getElementById('popup-message');

    // Tema saat ini
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme) {
        body.classList.add(currentTheme);
    }

    // Toggle Dark Mode
    darkModeToggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        localStorage.setItem('theme', body.classList.contains('dark-mode') ? 'dark-mode' : 'light-mode');
    });

    // Toggle Hamburger Menu
    hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });

    // Navigasi Antar Halaman
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

    // Popup Handling
    if (popup) {
        closePopup.addEventListener('click', () => {
            popup.style.display = 'none';
        });

        window.onclick = (event) => {
            if (event.target == popup) {
                popup.style.display = 'none';
            }
        };
    }
});

function searchUser() {
    const keyword = document.getElementById('searchInput').value;

    // Membuat permintaan AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'search.php?keyword=' + encodeURIComponent(keyword), true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('searchResult').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}