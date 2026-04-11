/* ═══════════════════════════════════════════
   REGOLIA WordPress Theme — main.js
   ═══════════════════════════════════════════ */

(function () {
  'use strict';

  /* ── Header scroll shadow ── */
  function initHeaderScroll() {
    var header = document.getElementById('site-header');
    if (!header) return;

    function onScroll() {
      if (window.scrollY > 10) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* ── Mobile menu toggle ── */
  function initMobileMenu() {
    var toggle = document.getElementById('menu-toggle') || document.getElementById('rg-burger');
    var nav    = document.getElementById('primary-nav') || document.getElementById('rg-nav');
    if (!toggle || !nav) return;

    toggle.addEventListener('click', function () {
      var isOpen = nav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      document.body.style.overflow = isOpen ? 'hidden' : '';
    });

    // Close on outside click
    document.addEventListener('click', function (e) {
      if (!nav.contains(e.target) && !toggle.contains(e.target)) {
        nav.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      }
    });

    // Close on Escape
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && nav.classList.contains('is-open')) {
        nav.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
        toggle.focus();
      }
    });
  }

  /* ── Smooth scroll for anchor links ── */
  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(function (link) {
      link.addEventListener('click', function (e) {
        var id = link.getAttribute('href').slice(1);
        if (!id) return;
        var target = document.getElementById(id);
        if (!target) return;
        e.preventDefault();

        var header = document.getElementById('site-header');
        var offset = header ? header.offsetHeight : 0;
        var top = target.getBoundingClientRect().top + window.scrollY - offset - 16;

        window.scrollTo({ top: top, behavior: 'smooth' });

        // Close mobile menu if open
        var nav = document.getElementById('primary-nav') || document.getElementById('rg-nav');
        var toggle = document.getElementById('menu-toggle') || document.getElementById('rg-burger');
        if (nav && nav.classList.contains('is-open')) {
          nav.classList.remove('is-open');
          if (toggle) toggle.setAttribute('aria-expanded', 'false');
          document.body.style.overflow = '';
        }
      });
    });
  }

  /* ── Waitlist form ── */
  function initWaitlistForm() {
    var form = document.querySelector('.rg-waitlist__form');
    if (!form) return;

    form.addEventListener('submit', function (e) {
      var btn = form.querySelector('[type="submit"]');
      if (btn) {
        btn.disabled = true;
        btn.textContent = 'Invio in corso…';
      }
      // Native form submission proceeds; re-enable on error
      setTimeout(function () {
        if (btn) { btn.disabled = false; btn.textContent = 'Iscrivimi →'; }
      }, 8000);
    });
  }

  /* ── Intersection observer: fade-in on scroll ── */
  function initFadeIn() {
    if (!window.IntersectionObserver) return;

    var style = document.createElement('style');
    style.textContent = [
      '.rg-fade-in { opacity: 0; transform: translateY(20px); transition: opacity 0.5s ease, transform 0.5s ease; }',
      '.rg-fade-in.is-visible { opacity: 1; transform: none; }',
    ].join('');
    document.head.appendChild(style);

    var targets = document.querySelectorAll(
      '.rg-step, .rg-feature-card, .rg-testimonial, .rg-trust__stat'
    );

    targets.forEach(function (el) {
      el.classList.add('rg-fade-in');
    });

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15 });

    targets.forEach(function (el) { observer.observe(el); });
  }

  /* ── Init ── */
  function init() {
    initHeaderScroll();
    initMobileMenu();
    initSmoothScroll();
    initWaitlistForm();
    initFadeIn();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
