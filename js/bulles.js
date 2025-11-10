/* ============================================================
  Ballons hélium – Vanilla JS (filtres de couleur)           
  ============================================================ */
  (() => {
  const MIN_WIDTH = 768;
  const mql = window.matchMedia(`(min-width: ${MIN_WIDTH}px)`);

  let mounted = false;
  let cleanup = null;
  let modeBtnOn = null;
  let modeBtnOff = null;
  let bubbleModeActive = true;

  function mount() {
    if (mounted) return;
    mounted = true;

    /************** Constantes & sélecteurs ****************/
    const scene = document.getElementById('scene');
    if (!scene) {
      mounted = false;
      return;
    }
    const filterBtns = [...document.querySelectorAll('#controls button[data-filter]')];
    let animationTimer = null;
    let animationFrameId = null;
    const ANIMATION_DURATION = 5000; // 5 secondes

    const sizeFactor = el => el.classList.contains('petit') ? 1.3 : el.classList.contains('petit') ? 1 : 0.75;

    document.body.classList.add('has-bubble-mode');

    const bubbles = [...scene.querySelectorAll('.bulle')].map(el => {
      return {
        el,
        x: 0,
        y: 0,
        r: el.offsetWidth / 2,
        vx: (Math.random() * 0.6 - 0.3),
        vy: 0,
        boost: sizeFactor(el),
        visible: true,
        get color() {
          if (el.classList.contains('rose')) return 'rose';
          if (el.classList.contains('bleu')) return 'bleu';
          if (el.classList.contains('marine')) return 'marine';
          return 'jaune';
        }
      };
    });

    const baseAccel = -0.2;
    const damping = 0.995;
    const boundsPad = 10;

    let visibility = {
      rose: true,
      bleu: true,
      jaune: true,
      marine: true
    };

    /************** Placement initial *************/
    function init() {
      const W = scene.offsetWidth;
      const H = scene.offsetHeight;
      bubbles.forEach(b => {
        b.r = b.el.offsetWidth / 2;
        b.x = Math.random() * (W - 2 * b.r) + b.r;
        b.y = H + Math.random() * 300;
        updateElement(b);
      });
    }

    /************** DOM *************************/
    function updateElement(b) {
      b.el.style.transform = `translate(${b.x-b.r}px,${b.y-b.r}px)`;
    }

    /************** Physique **********************/
    function animate() {
      physicsStep();
      animationFrameId = requestAnimationFrame(animate);
    }

    function stopAnimation() {
      if (animationFrameId) {
        cancelAnimationFrame(animationFrameId);
        animationFrameId = null;
      }
    }

    function startAnimationTimer() {
      stopAnimation();
      if (animationTimer) {
        clearTimeout(animationTimer);
      }
      animate();
      animationTimer = setTimeout(() => {
        stopAnimation();
      }, ANIMATION_DURATION);
    }

    function physicsStep() {
      const W = scene.offsetWidth;
      const H = scene.offsetHeight;

      for (const b of bubbles) {
        if (!b.visible || b.el.classList.contains('explode')) continue;
        if (b === dragging) continue;
        b.vy += baseAccel * b.boost;
        b.vx *= damping;
        b.vy *= damping;
        b.x += b.vx;
        b.y += b.vy;
        if (b.x - b.r < 0) {
          b.x = b.r;
          b.vx = Math.abs(b.vx);
        }
        if (b.x + b.r > W) {
          b.x = W - b.r;
          b.vx = -Math.abs(b.vx);
        }
        if (b.y - b.r < boundsPad) {
          b.y = boundsPad + b.r;
          b.vy = 0;
        }
      }

      for (let i = 0; i < bubbles.length; i++) {
        const A = bubbles[i];
        if (!A.visible || A.el.classList.contains('explode')) continue;
        for (let j = i + 1; j < bubbles.length; j++) {
          const B = bubbles[j];
          if (!B.visible || B.el.classList.contains('explode')) continue;
          const dx = B.x - A.x,
            dy = B.y - A.y,
            dist = Math.hypot(dx, dy),
            min = A.r + B.r;
          if (dist < min && dist > 0) {
            const overlap = min - dist,
              nx = dx / dist,
              ny = dy / dist;
            A.x -= nx * overlap / 2;
            A.y -= ny * overlap / 2;
            B.x += nx * overlap / 2;
            B.y += ny * overlap / 2;
            const va = A.vx * nx + A.vy * ny,
              vb = B.vx * nx + B.vy * ny,
              diff = vb - va;
            A.vx += diff * nx;
            A.vy += diff * ny;
            B.vx -= diff * nx;
            B.vy -= diff * ny;
          }
        }
      }

      bubbles.forEach(b => {
        if (b.visible) updateElement(b);
      });
    }

    /************** Visibilité / explosion ***********/
    function explode(list) {
      list.forEach(b => {
        b.visible = false;
        b.el.classList.add('explode');
        b.el.addEventListener('animationend', () => {
          b.el.style.display = 'none';
          b.el.classList.remove('explode');
        }, {
          once: true
        });
      });
    }

    function respawn(list) {
      list.forEach(b => {
        b.visible = true;
        b.el.style.display = '';
        b.vy = 0;
        updateElement(b);
      });
    }

    function applyFilter(filter) {
      filterBtns.forEach(b => b.classList.toggle('active', b.dataset.filter === filter));
      if (filter === 'all') {
        for (const col of ['rose', 'bleu', 'jaune', 'marine']) {
          if (!visibility[col]) {
            respawn(bubbles.filter(b => b.color === col));
          }
          visibility[col] = true;
        }
      } else {
        for (const col of ['rose', 'bleu', 'jaune', 'marine']) {
          const list = bubbles.filter(b => b.color === col);
          if (col === filter) {
            if (!visibility[col]) respawn(list);
            visibility[col] = true;
          } else {
            if (visibility[col]) explode(list);
            visibility[col] = false;
          }
        }
      }
      startAnimationTimer();
    }

    /************** Écouteurs (avec références pour cleanup) ***************/
    const clickHandlers = new Map();
    filterBtns.forEach(btn => {
      const h = () => applyFilter(btn.dataset.filter);
      btn.addEventListener('click', h);
      clickHandlers.set(btn, h);
    });

    let dragging = null, offsetX = 0, offsetY = 0;

    const mdHandler = e => {
      const t = e.target.closest('.bulle');
      if (!t) return;
      dragging = bubbles.find(b => b.el === t);
      offsetX = e.clientX - dragging.x;
      offsetY = e.clientY - dragging.y;
      t.style.cursor = 'grabbing';
      startAnimationTimer();
    };
    const mmHandler = e => {
      if (!dragging) return;
      dragging.x = e.clientX - offsetX;
      dragging.y = e.clientY - offsetY;
      dragging.vx = dragging.vy = 0;
      updateElement(dragging);
    };
    const muHandler = () => {
      if (!dragging) return;
      dragging.el.style.cursor = 'grab';
      dragging = null;
    };
    const rzHandler = () => {
      const W = scene.offsetWidth, H = scene.offsetHeight;
      bubbles.forEach(b => {
        b.x = Math.min(Math.max(b.r, b.x), W - b.r);
        b.y = Math.min(Math.max(boundsPad + b.r, b.y), H + 300);
      });
    };

    scene.addEventListener('mousedown', mdHandler);
    window.addEventListener('mousemove', mmHandler);
    window.addEventListener('mouseup', muHandler);
    window.addEventListener('resize', rzHandler);

    init();
    startAnimationTimer();

    // Définir le cleanup pour le démontage
    cleanup = () => {
      stopAnimation();
      if (animationTimer) {
        clearTimeout(animationTimer);
        animationTimer = null;
      }
      // Retirer écouteurs
      clickHandlers.forEach((h, btn) => btn.removeEventListener('click', h));
      scene.removeEventListener('mousedown', mdHandler);
      window.removeEventListener('mousemove', mmHandler);
      window.removeEventListener('mouseup', muHandler);
      window.removeEventListener('resize', rzHandler);

      document.body.classList.remove('has-bubble-mode');

      // Reset styles des bulles pour mobile
      scene.querySelectorAll('.bulle').forEach(el => {
        el.style.transform = '';
        el.style.cursor = '';
        el.style.display = '';
        el.classList.remove('explode');
      });

      mounted = false;
    };
  }

  function unmount() {
    if (!mounted) return;
    if (cleanup) cleanup();
    updateToggleUI();
  }

  function updateToggleUI() {
    const sceneEl = document.getElementById('scene');
    const controls = document.getElementById('controls');
    
    // Cacher #controls si #scene n'existe pas
    if (!sceneEl && controls) {
      controls.style.display = 'none';
      return;
    }
    
    if (!modeBtnOn || !modeBtnOff) return;
    const isDesktop = mql.matches;
    if (!isDesktop) {
      if (controls) controls.style.display = 'none';
      modeBtnOn.hidden = true;
      modeBtnOff.hidden = true;
      modeBtnOn.disabled = true;
      modeBtnOff.disabled = true;
      modeBtnOn.classList.remove('active');
      modeBtnOff.classList.remove('active');
      modeBtnOn.classList.add('off');
      modeBtnOff.classList.add('off');
      modeBtnOn.setAttribute('aria-pressed', 'false');
      modeBtnOff.setAttribute('aria-pressed', 'false');
      return;
    }
    if (controls) controls.style.display = 'flex';
    modeBtnOn.hidden = false;
    modeBtnOff.hidden = false;
    modeBtnOn.disabled = false;
    modeBtnOff.disabled = false;
    modeBtnOn.classList.toggle('active', bubbleModeActive);
    modeBtnOn.classList.toggle('off', !bubbleModeActive);
    modeBtnOff.classList.toggle('active', !bubbleModeActive);
    modeBtnOff.classList.toggle('off', bubbleModeActive);
    modeBtnOn.setAttribute('aria-pressed', bubbleModeActive ? 'true' : 'false');
    modeBtnOff.setAttribute('aria-pressed', !bubbleModeActive ? 'true' : 'false');
  }

  function setupToggleButton() {
    const sceneEl = document.getElementById('scene');
    
    // Ne pas créer les contrôles si #scene n'existe pas
    if (!sceneEl) {
      const existingControls = document.getElementById('controls');
      if (existingControls) {
        existingControls.style.display = 'none';
      }
      return;
    }
    
    let controls = document.getElementById('controls');
    if (!controls) {
      controls = document.createElement('div');
      controls.id = 'controls';
      if (sceneEl && sceneEl.parentNode) {
        sceneEl.parentNode.insertBefore(controls, sceneEl);
      } else {
        document.body.prepend(controls);
      }
    }
    modeBtnOn = controls.querySelector('[data-mode="bubbles-on"]');
    modeBtnOff = controls.querySelector('[data-mode="bubbles-off"]');
    if (!modeBtnOff) {
      modeBtnOff = document.createElement('button');
      modeBtnOff.type = 'button';
      modeBtnOff.dataset.mode = 'bubbles-on';
      modeBtnOff.className = 'mode-toggle mode-off';
      modeBtnOff.innerHTML = '<img src="/wp-content/themes/edelparc26/images/grid-icon.png" alt="Grille" class="grid-icon" width="20" height="20"> <span class="label">Vue liste</span>';
      controls.prepend(modeBtnOff);
    }
    if (!modeBtnOn) {
      modeBtnOn = document.createElement('button');
      modeBtnOn.type = 'button';
      modeBtnOn.dataset.mode = 'bubbles-off';
      modeBtnOn.className = 'mode-toggle mode-on';
      modeBtnOn.innerHTML = '<img src="/wp-content/themes/edelparc26/images/bubbles-icon.png" alt="Bulles" class="bubbles-icon" width="20" height="20"> <span class="label">Vue bulles</span>';
      controls.prepend(modeBtnOn);
    }
    if (!modeBtnOn.dataset.toggleReady) {
      modeBtnOn.addEventListener('click', () => {
        if (!mql.matches) return;
        if (!bubbleModeActive) {
          bubbleModeActive = true;
          mount();
          updateToggleUI();
        }
      });
      modeBtnOn.dataset.toggleReady = 'true';
    }
    if (!modeBtnOff.dataset.toggleReady) {
      modeBtnOff.addEventListener('click', () => {
        if (!mql.matches) return;
        if (bubbleModeActive) {
          bubbleModeActive = false;
          unmount();
          updateToggleUI();
        }
      });
      modeBtnOff.dataset.toggleReady = 'true';
    }
    updateToggleUI();
  }

  setupToggleButton();

  // Activer/désactiver en fonction de la largeur au chargement et sur changement
  if (mql.matches && bubbleModeActive) mount();
  updateToggleUI();
  mql.addEventListener('change', e => {
    if (e.matches) {
      if (bubbleModeActive) {
        mount();
      } else {
        unmount();
      }
    } else {
      unmount();
    }
    updateToggleUI();
  });
})();