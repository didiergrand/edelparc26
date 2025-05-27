  /* ============================================================
   Ballons hélium – Vanilla JS (filtres de couleur)           
   ============================================================ */
   (() => {
    /************** Constantes & sélecteurs ****************/
    const scene = document.getElementById('scene');
    const btns = [...document.querySelectorAll('#controls button')];

    const sizeFactor = el => el.classList.contains('petit') ? 1.3 : el.classList.contains('petit') ? 1 : 0.75;

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
      requestAnimationFrame(animate);
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
      // Ré‑affiche les bulles exactement là où elles étaient gelées
      list.forEach(b => {
        b.visible = true;
        b.el.style.display = '';
        b.vy = 0; // on remet la vitesse verticale à 0 pour qu’elles repartent directement vers le haut
        updateElement(b); // appliquer immédiatement la position mémorisée
      });
    }

    function applyFilter(filter) {
      btns.forEach(b => b.classList.toggle('active', b.dataset.filter === filter));
      if (filter === 'all') {
        for (const col of ['rose', 'bleu', 'jaune', 'marine']) {
          if (!visibility[col]) {
            respawn(bubbles.filter(b => b.color === col));
          }
          visibility[col] = true;
        }
        return;
      }
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

    btns.forEach(btn => btn.addEventListener('click', () => applyFilter(btn.dataset.filter)));

    /************** Drag & Drop ***********************/
    let dragging = null,
      offsetX = 0,
      offsetY = 0;
    scene.addEventListener('mousedown', e => {
      const t = e.target.closest('.bulle');
      if (!t) return;
      dragging = bubbles.find(b => b.el === t);
      offsetX = e.clientX - dragging.x;
      offsetY = e.clientY - dragging.y;
      t.style.cursor = 'grabbing';
    });
    window.addEventListener('mousemove', e => {
      if (!dragging) return;
      dragging.x = e.clientX - offsetX;
      dragging.y = e.clientY - offsetY;
      dragging.vx = dragging.vy = 0;
      updateElement(dragging);
    });
    window.addEventListener('mouseup', () => {
      if (!dragging) return;
      dragging.el.style.cursor = 'grab';
      dragging = null;
    });

    window.addEventListener('resize', () => {
      const W = scene.offsetWidth,
        H = scene.offsetHeight;
      bubbles.forEach(b => {
        b.x = Math.min(Math.max(b.r, b.x), W - b.r);
        b.y = Math.min(Math.max(boundsPad + b.r, b.y), H + 300);
      });
    });

    init();
    animate();
  })();