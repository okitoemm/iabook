import '../css/app.css'
import './bootstrap';
import Alpine from 'alpinejs/dist/module.esm.js';
import focus from '@alpinejs/focus';
 
window.Alpine = Alpine;
Alpine.plugin(focus);
Alpine.start();
