/* 
 * MC Peko
 * https://peko.net/index.js
 * https://peko.net/index.php
 */

// Function to collapse/expand DIVs

function toggleDiv(containerId) {
  const contentContainer = document.getElementById(containerId); // Get the relevant container
  if (!contentContainer) return;

  if (contentContainer.classList.contains('collapsed')) {
    contentContainer.classList.remove('collapsed');
  } else {
    contentContainer.classList.add('collapsed');
  }
}

function toggleMenu() {
  const menu = document.getElementById('toc');
  if (!menu) return;

  if (!isDesktopSidebarLayout()) {
    document.getElementById('settings-panel')?.classList.remove('settings-panel-open');
  }
  menu.classList.toggle('toc-open');
  syncSidebarState();
}

function isDesktopSidebarLayout() {
  return window.matchMedia('(min-width: 800px)').matches;
}

function syncSidebarState() {
  const menu = document.getElementById('toc');
  const panel = document.getElementById('settings-panel');
  const menuOpen = menu?.classList.contains('toc-open') || false;
  const settingsOpen = panel?.classList.contains('settings-panel-open') || false;

  if (panel) panel.hidden = !settingsOpen;
  document.getElementById('toggle-menu-button')?.setAttribute('aria-expanded', String(menuOpen));
  document.getElementById('toggle-settings-panel-button')?.setAttribute('aria-expanded', String(settingsOpen));
  document.body.classList.toggle('toc-sidebar-open', menuOpen);
  document.body.classList.toggle('settings-sidebar-open', settingsOpen);
  document.body.classList.toggle('toc-lock', menuOpen && !isDesktopSidebarLayout());
  document.body.classList.toggle('settings-lock', settingsOpen && !isDesktopSidebarLayout());

  if (isDesktopSidebarLayout()) {
    localStorage.setItem('global.toc_sidebar_open', String(menuOpen));
    localStorage.setItem('global.settings_sidebar_open', String(settingsOpen));
  }
}

function restoreSidebarState() {
  const menu = document.getElementById('toc');
  const panel = document.getElementById('settings-panel');
  if (!menu || !panel) return;

  const desktop = isDesktopSidebarLayout();
  const savedMenuOpen = localStorage.getItem('global.toc_sidebar_open');
  const savedSettingsOpen = localStorage.getItem('global.settings_sidebar_open');
  menu.classList.toggle('toc-open', desktop && (savedMenuOpen === null || savedMenuOpen === 'true'));
  panel.classList.toggle('settings-panel-open', desktop && (savedSettingsOpen === null || savedSettingsOpen === 'true'));
  syncSidebarState();
}

function closeMenu() {
  document.getElementById('toc')?.classList.remove('toc-open');
  syncSidebarState();
}

function closeSettingsPanel() {
  document.getElementById('settings-panel')?.classList.remove('settings-panel-open');
  syncSidebarState();
}

function closeMobileSidebars() {
  if (isDesktopSidebarLayout()) return;
  document.getElementById('toc')?.classList.remove('toc-open');
  document.getElementById('settings-panel')?.classList.remove('settings-panel-open');
  syncSidebarState();
}

function toggleSettingsPanel() {
  const panel = document.getElementById('settings-panel');
  if (!panel) return;

  if (!isDesktopSidebarLayout()) {
    document.getElementById('toc')?.classList.remove('toc-open');
  }
  panel.classList.toggle('settings-panel-open');
  syncSidebarState();
}

function updateModeButtonState() {
  const button = document.getElementById('toggle-mode-button');
  if (!button) return;
  const active = !document.documentElement.classList.contains('invert-colors');
  button.classList.toggle('button-on', active);
  button.setAttribute('aria-pressed', String(active));
}

function updateFullscreenButtonState() {
  const button = document.getElementById('toggle-fullscreen-button');
  if (!button) return;
  const active = Boolean(document.fullscreenElement);
  button.classList.toggle('button-on', active);
  button.setAttribute('aria-pressed', String(active));
}

function showSettingsFeedback(message) {
  const feedback = document.getElementById('settings-feedback');
  if (!feedback) return;
  feedback.textContent = message;
  feedback.hidden = false;
}

async function toggleFullscreen() {
  try {
    if (!document.fullscreenElement) {
      await document.documentElement.requestFullscreen();
    } else {
      await document.exitFullscreen();
    }
  } catch (error) {
    console.error('Unable to change fullscreen mode', error);
    showSettingsFeedback('Unable to change fullscreen mode.');
  }
}

async function shareCurrentPage() {
  const shareUrl = window.location.href;
  const shareTitle = document.title || 'MC Peko';

  if (navigator.share) {
    try {
      await navigator.share({ title: shareTitle, text: shareTitle, url: shareUrl });
      return;
    } catch (error) {
      if (error?.name === 'AbortError') return;
      console.warn('Unable to share page', error);
    }
  }

  if (navigator.clipboard && typeof navigator.clipboard.writeText === 'function') {
    try {
      await navigator.clipboard.writeText(shareUrl);
      showSettingsFeedback('Link copied.');
      return;
    } catch (error) {
      console.warn('Unable to copy share URL', error);
    }
  }

  window.prompt('Copy this link:', shareUrl);
}

function resetSettings() {
  localStorage.clear();
  window.location.reload();
}

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('input[name="release-type"]').forEach(input => {
    input.addEventListener('change', () => {
      document.querySelectorAll('[data-release-type]').forEach(entry => {
        entry.hidden = input.value !== 'all' && entry.dataset.releaseType !== input.value;
      });
    });
  });

  const actions = {
    'toggle-menu-button': toggleMenu,
    'toggle-menu-close-button': () => {
      closeMenu();
      document.getElementById('toggle-menu-button')?.focus();
    },
    'toggle-settings-panel-button': toggleSettingsPanel,
    'toggle-settings-panel-close-button': () => {
      closeSettingsPanel();
      document.getElementById('toggle-settings-panel-button')?.focus();
    },
    'toggle-mode-button': toggleMode,
    'toggle-fullscreen-button': toggleFullscreen,
    'share-settings-button': shareCurrentPage,
    'reset-settings-button': resetSettings
  };
  Object.entries(actions).forEach(([id, action]) => {
    document.getElementById(id)?.addEventListener('click', action);
  });

  const fullscreenButton = document.getElementById('toggle-fullscreen-button');
  if (fullscreenButton) {
    fullscreenButton.disabled = !document.documentElement.requestFullscreen || document.fullscreenEnabled === false;
  }

  const mode = localStorage.getItem('mode');
  if (mode === 'dark') document.documentElement.classList.add('invert-colors');
  else document.documentElement.classList.remove('invert-colors');
  updateModeButtonState();
  updateFullscreenButtonState();
  restoreSidebarState();
});

document.addEventListener('fullscreenchange', updateFullscreenButtonState);
window.addEventListener('resize', restoreSidebarState);
window.addEventListener('pagehide', closeMobileSidebars);
window.addEventListener('pageshow', closeMobileSidebars);

document.addEventListener('click', event => {
  if (!event.isTrusted || isDesktopSidebarLayout()) return;

  const menu = document.getElementById('toc');
  const menuContainer = document.getElementById('burger-container');
  const settings = document.getElementById('settings-panel');
  const settingsContainer = document.getElementById('settings-menu-container');
  if (menu?.classList.contains('toc-open') && !menu.contains(event.target) && !menuContainer?.contains(event.target)) {
    closeMenu();
  }
  if (settings && !settings.hidden && !settings.contains(event.target) && !settingsContainer?.contains(event.target)) {
    closeSettingsPanel();
  }
  if (event.target.closest?.('#toc a')) closeMobileSidebars();
});

document.addEventListener('keydown', event => {
  if (event.key !== 'Escape' || isDesktopSidebarLayout()) return;

  const settings = document.getElementById('settings-panel');
  if (settings && !settings.hidden) {
    closeSettingsPanel();
    document.getElementById('toggle-settings-panel-button')?.focus();
    return;
  }

  const menu = document.getElementById('toc');
  if (menu?.classList.contains('toc-open')) {
    closeMenu();
    document.getElementById('toggle-menu-button')?.focus();
  }
});

// Function to toggle light mode/dark mode

function toggleMode() {
  const htmlElement = document.documentElement;
  htmlElement.classList.toggle('invert-colors');

  // Store mode preference in local storage
  if (htmlElement.classList.contains('invert-colors')) {
    localStorage.setItem('mode', 'dark');
  } else {
    localStorage.setItem('mode', 'light');
  }
  updateModeButtonState();
}
