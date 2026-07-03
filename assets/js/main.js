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
    var forms = document.querySelectorAll('.rg-waitlist__form');

    forms.forEach(function (form) {
      form.addEventListener('submit', function () {
        var btn = form.querySelector('[type="submit"]');
        if (btn) {
          btn.dataset.label = btn.textContent;
          btn.disabled = true;
          btn.textContent = 'Invio in corso…';
        }
        // La submit nativa prosegue; ripristina in caso di errore/back
        setTimeout(function () {
          if (btn) { btn.disabled = false; btn.textContent = btn.dataset.label || 'Iscrivimi →'; }
        }, 8000);
      });
    });

    // Esito post-submit (flag rg_waitlist nell'URL, impostato dal server)
    var params = new URLSearchParams(window.location.search);
    var status = params.get('rg_waitlist');
    if (!status) return;

    var messages = {
      ok:      { text: 'Grazie! Ti avvisiamo appena Regolia è disponibile nella tua zona.', ok: true },
      invalid: { text: 'Controlla l’indirizzo email e riprova.', ok: false },
      error:   { text: 'Qualcosa è andato storto. Riprova tra poco.', ok: false }
    };
    var msg = messages[status];
    if (!msg) return;

    var anchor = document.querySelector('.rg-waitlist__form') ||
                 document.getElementById('waitlist') ||
                 document.querySelector('.rg-story__finale-form');
    if (!anchor) return;

    var banner = document.createElement('p');
    banner.setAttribute('role', 'status');
    banner.textContent = msg.text;
    banner.style.cssText =
      'margin:0 auto 1rem;max-width:520px;padding:.75rem 1rem;border-radius:.75rem;' +
      'font-weight:600;text-align:center;' +
      (msg.ok
        ? 'background:#E9F7F0;color:#0F6B4F;border:1px solid #9DE2C2;'
        : 'background:#FCEAEA;color:#B03636;border:1px solid #E7B4B4;');
    anchor.parentNode.insertBefore(banner, anchor);

    if (msg.ok) {
      var input = anchor.querySelector && anchor.querySelector('input[type="email"]');
      if (input) input.value = '';
    }
    banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
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
