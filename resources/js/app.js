require('./bootstrap');

import Alpine from 'alpinejs';
import trap from '@alpinejs/trap';

window.Alpine = Alpine;

Alpine.plugin(trap);
Alpine.start();
