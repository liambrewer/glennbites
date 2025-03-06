import.meta.glob([
    '../../images/**'
]);

import '../../../vendor/masmerise/livewire-toaster/resources/js/index.js';
import '../shared/bootstrap';

import { Livewire, Alpine } from '../../../vendor/livewire/livewire/dist/livewire.esm.js';
import mask from '@alpinejs/mask';

Alpine.plugin(mask);

Livewire.start();
