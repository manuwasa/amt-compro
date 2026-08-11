import './bootstrap';

import Alpine from 'alpinejs';
import Quill from 'quill';
import 'quill/dist/quill.snow.css';

window.Alpine = Alpine;

Alpine.start();

// Wire up every [data-quill] container into a Quill rich-text editor that syncs
// its HTML into the hidden input named by [data-quill-target] on every edit,
// so the surrounding <form> submits plain HTML with no extra JS on the server side.
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-quill]').forEach((container) => {
        const hiddenInput = document.getElementById(container.dataset.quillTarget);

        if (! hiddenInput) {
            return;
        }

        const quill = new Quill(container, { theme: 'snow' });

        if (hiddenInput.value) {
            quill.clipboard.dangerouslyPasteHTML(hiddenInput.value);
        }

        quill.on('text-change', () => {
            hiddenInput.value = quill.root.innerHTML;
        });
    });
});

// Fade/rise-in reveal for any [data-reveal] element as it scrolls into view.
// [data-reveal-group] children get an automatic stagger via transition-delay,
// so a grid of cards animates in sequence rather than all at once.
document.addEventListener('DOMContentLoaded', () => {
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -60px 0px' });

    document.querySelectorAll('[data-reveal-group]').forEach((group) => {
        [...group.children].forEach((child, index) => {
            child.setAttribute('data-reveal', '');
            child.style.transitionDelay = `${Math.min(index * 80, 480)}ms`;
        });
    });

    const revealTargets = document.querySelectorAll('[data-reveal]');
    revealTargets.forEach((el) => revealObserver.observe(el));

    // Safety net: force everything visible after a delay regardless of the observer,
    // so a fast/odd scroll position or an automated tool that doesn't scroll never
    // leaves content permanently hidden.
    window.setTimeout(() => {
        revealTargets.forEach((el) => el.classList.add('is-visible'));
        revealObserver.disconnect();
    }, 2500);
});
