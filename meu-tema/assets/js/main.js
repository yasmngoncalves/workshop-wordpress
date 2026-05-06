/**
 * main.js — JavaScript do Dev Folio.
 *
 * Vanilla JS puro — sem jQuery, sem dependências externas.
 * Carregado com `defer` via functions.php (DOM já pronto na execução).
 *
 * ÍNDICE
 * 1. initHeaderScroll  — adiciona .is-scrolled após 80px
 * 2. initMobileMenu    — toggle do menu hamburguer
 * 3. initFadeIn        — IntersectionObserver para [data-animate]
 * 4. initSmoothScroll  — scroll suave para âncoras com offset do header
 * 5. init              — ponto de entrada
 */

'use strict';

/* Atalhos de seletor — evita repetição de querySelector */
const $ = (sel, ctx = document) => ctx.querySelector(sel);
const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];


/* ============================================================
   1. HEADER SCROLL
   Adiciona/remove .is-scrolled no #site-header ao rolar.
   O CSS usa essa classe para adicionar sombra sutil.
   ============================================================ */

function initHeaderScroll() {
    const header = $('#site-header');
    if (!header) return;

    const THRESHOLD = 80;

    function onScroll() {
        header.classList.toggle('is-scrolled', window.scrollY > THRESHOLD);
    }

    // passive: true melhora performance — informa ao browser que não há preventDefault
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll(); // roda na carga caso a página já esteja rolada
}


/* ============================================================
   2. MENU MOBILE
   Toggle de .is-open no #site-nav e .is-active no #nav-toggle.
   Fecha com Esc e ao clicar fora — acessibilidade por teclado.
   ============================================================ */

function initMobileMenu() {
    const toggle = $('#nav-toggle');
    const nav    = $('#site-nav');
    if (!toggle || !nav) return;

    function openMenu() {
        nav.classList.add('is-open');
        toggle.classList.add('is-active');
        toggle.setAttribute('aria-expanded', 'true');
        toggle.setAttribute('aria-label', 'Fechar menu');
    }

    function closeMenu() {
        nav.classList.remove('is-open');
        toggle.classList.remove('is-active');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'Abrir menu');
    }

    toggle.addEventListener('click', () => {
        nav.classList.contains('is-open') ? closeMenu() : openMenu();
    });

    // Fecha com Esc e devolve o foco para o botão
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && nav.classList.contains('is-open')) {
            closeMenu();
            toggle.focus();
        }
    });

    // Fecha ao clicar em um link do menu (navegação SPA-like)
    $$('.nav__link', nav).forEach(link => {
        link.addEventListener('click', closeMenu);
    });

    // Fecha ao clicar fora do menu e do botão
    document.addEventListener('click', (e) => {
        if (!nav.contains(e.target) && !toggle.contains(e.target)) {
            if (nav.classList.contains('is-open')) closeMenu();
        }
    });
}


/* ============================================================
   3. ANIMAÇÕES DE ENTRADA (IntersectionObserver)
   Elementos com [data-animate] recebem .is-visible ao entrar
   na viewport. O CSS (transition) faz a animação.
   Para de observar após animar — sem custo contínuo.
   ============================================================ */

function initFadeIn() {
    const elements = $$('[data-animate]');
    if (!elements.length) return;

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target); // para de observar após animar
                }
            });
        },
        { threshold: 0.1 }
    );

    elements.forEach(el => observer.observe(el));
}


/* ============================================================
   4. SMOOTH SCROLL
   Intercepta cliques em a[href*="#"] da mesma página.
   Aplica offset pelo altura do header fixo.
   ============================================================ */

function initSmoothScroll() {
    const anchorLinks = $$('a[href*="#"]').filter(link => {
        // Só links que apontam para âncoras na página atual
        return link.href.split('#')[0] === window.location.href.split('#')[0];
    });

    anchorLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            const targetId = link.getAttribute('href').split('#')[1];
            if (!targetId) return;

            const target = document.getElementById(targetId);
            if (!target) return;

            e.preventDefault();

            const headerHeight = $('#site-header')?.offsetHeight ?? 72;
            const targetTop    = target.getBoundingClientRect().top + window.scrollY - headerHeight;

            window.scrollTo({ top: targetTop, behavior: 'smooth' });
        });
    });
}


/* ============================================================
   5. INIT — ponto de entrada
   ============================================================ */

function init() {
    initHeaderScroll();
    initMobileMenu();
    initFadeIn();
    initSmoothScroll();

    if (location.hostname === 'localhost' || location.hostname.includes('.local')) {
        console.log('%c Dev Folio carregado', 'font-family:monospace; color:#16a34a');
    }
}

// defer garante que o DOM está pronto; o addEventListener é fallback
document.readyState === 'loading'
    ? document.addEventListener('DOMContentLoaded', init)
    : init();
