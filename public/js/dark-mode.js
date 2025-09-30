// Dark Mode Control Script (without toggle button)
// This script allows manual control of dark mode via browser console or other methods

function setDarkMode(enabled) {
    const html = document.documentElement;
    const theme = enabled ? 'dark' : 'light';
    
    html.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
    
    console.log(`Dark mode ${enabled ? 'enabled' : 'disabled'}`);
}

function toggleDarkMode() {
    const html = document.documentElement;
    const currentTheme = html.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    setDarkMode(newTheme === 'dark');
}

function getCurrentTheme() {
    const html = document.documentElement;
    return html.getAttribute('data-theme') || 'light';
}

// Initialize theme on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    setDarkMode(savedTheme === 'dark');
});

// Make functions available globally for console access
window.setDarkMode = setDarkMode;
window.toggleDarkMode = toggleDarkMode;
window.getCurrentTheme = getCurrentTheme;

// Console instructions
console.log('Dark Mode Controls:');
console.log('- setDarkMode(true)  : Enable dark mode');
console.log('- setDarkMode(false) : Disable dark mode');
console.log('- toggleDarkMode()   : Toggle between light/dark');
console.log('- getCurrentTheme()  : Get current theme');





