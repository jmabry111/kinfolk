import './bootstrap';

import Alpine from 'alpinejs';

document.addEventListener('alpine:init', () => {
    Alpine.store('dashboard', {
        showHolidays: localStorage.getItem('showHolidays') !== 'false',
        toggle() {
            this.showHolidays = !this.showHolidays;
            localStorage.setItem('showHolidays', this.showHolidays);
        }
    });
});

window.Alpine = Alpine;

Alpine.start();

import './tour.js';
