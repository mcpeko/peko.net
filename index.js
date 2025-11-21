/* 
 * MC Peko
 * https://peko.net/index.js
 * https://peko.net/index.php
 */

// Function to collapse/expand DIVs

function toggleDiv(containerId) {
  const contentContainer = document.getElementById(containerId); // Get the relevant container

  if (contentContainer.classList.contains('collapsed')) {
    contentContainer.classList.remove('collapsed');
  } else {
    contentContainer.classList.add('collapsed');
  }
}

// Function to toggle light mode/dark mode

function toggleMode() {
  const htmlElement = document.documentElement;
  htmlElement.classList.toggle('invertColors');

  // Store mode preference in local storage
  if (htmlElement.classList.contains('invertColors')) {
    localStorage.setItem('mode', 'dark');
  } else {
    localStorage.setItem('mode', 'light');
  }
}

// Check for mode preference on page load
document.addEventListener('DOMContentLoaded', function() {
  const mode = localStorage.getItem('mode');
  if (mode === 'dark') {
    document.documentElement.classList.add('invertColors');
  }
});
