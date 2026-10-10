import './bootstrap';
import Alpine from 'alpinejs';
import { holidayApp } from './holidays/app.js';

Alpine.data('holidayApp', (translations) => holidayApp(translations));

window.Alpine = Alpine;
Alpine.start();
