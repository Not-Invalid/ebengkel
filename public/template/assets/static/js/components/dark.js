const THEME_KEY = "theme"; // Kunci untuk menyimpan tema di localStorage

/**
 * Set theme to light
 * @param {"light"} theme
 * @param {boolean} persist Menyimpan pengaturan tema di localStorage
 */
function setTheme(theme, persist = false) {
    document.body.classList.add(theme); // Menambahkan kelas 'light' ke body
    document.documentElement.setAttribute("data-bs-theme", theme); // Menambahkan atribut untuk tema di HTML

    if (persist) {
        localStorage.setItem(THEME_KEY, theme); // Menyimpan tema di localStorage
    }
}

/**
 * Init theme, memastikan tema adalah light
 */
function initTheme() {
    // Set tema ke 'light' saat halaman dimuat
    setTheme("light", true);
}

// Menjalankan inisialisasi tema saat DOM selesai dimuat
window.addEventListener("DOMContentLoaded", () => {
    initTheme();
});
