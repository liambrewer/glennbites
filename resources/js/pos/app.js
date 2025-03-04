import '../../../vendor/masmerise/livewire-toaster/resources/js/index.js';
import '../shared/bootstrap';

import dayjs from 'dayjs';
import timezone from 'dayjs/plugin/timezone';
import utc from 'dayjs/plugin/utc';

dayjs.extend(utc);
dayjs.extend(timezone);

import { Alpine, Livewire } from '../../../vendor/livewire/livewire/dist/livewire.esm.js';

Alpine.data('duration', (startedAt) => ({
    timer: null,
    startedAt: dayjs.tz(startedAt, 'America/Chicago'),
    timeElapsed: '',

    init() {
        this.syncTime();

        this.timer = setInterval(() => {
            this.syncTime();
        }, 10);
    },

    syncTime() {
        this.timeElapsed = formatTime(dayjs().tz('America/Chicago').diff(this.startedAt, 'seconds'));
    },

    destroy() {
        if (this.timer) {
            clearInterval(this.timer);
        }
    },
}));

Alpine.data('orderPrinter', (orderId) => ({
    printing: false,

    printPdf() {
        const iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        iframe.src = `/orders/${orderId}/pickup-label.pdf`;

        this.printing = true;

        iframe.onload = () => {
            if (iframe.contentDocument.title.indexOf('404') >= 0) throw new Error('Failed to find order.');

            const iframeWindow = iframe.contentWindow;

            iframeWindow.focus();
            iframeWindow.print();

            setTimeout(() => {
                if (document.body.contains(iframe)) {
                    this.printing = false;
                    document.body.removeChild(iframe);
                }
            }, 1000 * 10); // 10 second wait
        };

        document.body.appendChild(iframe);
    },
}));

function formatTime(seconds) {
    const h = Math.floor(seconds / 3600)
        .toString()
        .padStart(2, '0');
    const m = Math.floor((seconds % 3600) / 60)
        .toString()
        .padStart(2, '0');
    const s = (seconds % 60).toString().padStart(2, '0');
    return `${h}:${m}:${s}`;
}

Livewire.start();
