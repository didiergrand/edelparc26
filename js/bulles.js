  /* ============================================================
   Ballons hélium – Vanilla JS (filtres de couleur)           
   ============================================================ */
   (() => {
    /************** Constantes & sélecteurs ****************/
    const scene = document.getElementById('scene');
    const btns = [...document.querySelectorAll('#controls button')];
    let lastFrameTime = 0;
    const frameInterval = 1000 / 60; // 60 FPS max
    let isPageVisible = true;

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
    let collisionGrid = [];
    const gridCellSize = 100; // Taille de la cellule de la grille

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
    function animate(currentTime) {
      if (!isPageVisible) {
        requestAnimationFrame(animate);
        return;
      }

      const deltaTime = currentTime - lastFrameTime;
      if (deltaTime < frameInterval) {
        requestAnimationFrame(animate);
        return;
      }

      lastFrameTime = currentTime;
      physicsStep();
      requestAnimationFrame(animate);
    }

    function updateCollisionGrid() {
      const W = scene.offsetWidth;
      const H = scene.offsetHeight;
      const gridWidth = Math.ceil(W / gridCellSize);
      const gridHeight = Math.ceil(H / gridCellSize);
      
      collisionGrid = Array(gridWidth).fill().map(() => Array(gridHeight).fill().map(() => []));
      
      bubbles.forEach(b => {
        if (!b.visible || b.el.classList.contains('explode')) return;
        const cellX = Math.floor(b.x / gridCellSize);
        const cellY = Math.floor(b.y / gridCellSize);
        if (cellX >= 0 && cellX < gridWidth && cellY >= 0 && cellY < gridHeight) {
          collisionGrid[cellX][cellY].push(b);
        }
      });
    }

    function physicsStep() {
      const W = scene.offsetWidth;
      const H = scene.offsetHeight;

      // Mise à jour de la grille de collision
      updateCollisionGrid();

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

      // Vérification des collisions uniquement dans les cellules adjacentes
      for (let i = 0; i < collisionGrid.length; i++) {
        for (let j = 0; j < collisionGrid[i].length; j++) {
          const cell = collisionGrid[i][j];
          for (let k = 0; k < cell.length; k++) {
            const A = cell[k];
            if (!A.visible || A.el.classList.contains('explode')) continue;
            
            // Vérifier les collisions avec les bulles dans la même cellule
            for (let l = k + 1; l < cell.length; l++) {
              const B = cell[l];
              if (!B.visible || B.el.classList.contains('explode')) continue;
              checkCollision(A, B);
            }
            
            // Vérifier les collisions avec les bulles dans les cellules adjacentes
            for (let di = -1; di <= 1; di++) {
              for (let dj = -1; dj <= 1; dj++) {
                if (di === 0 && dj === 0) continue;
                const ni = i + di;
                const nj = j + dj;
                if (ni >= 0 && ni < collisionGrid.length && nj >= 0 && nj < collisionGrid[ni].length) {
                  const adjacentCell = collisionGrid[ni][nj];
                  for (const B of adjacentCell) {
                    if (!B.visible || B.el.classList.contains('explode')) continue;
                    checkCollision(A, B);
                  }
                }
              }
            }
          }
        }
      }

      bubbles.forEach(b => {
        if (b.visible) updateElement(b);
      });
    }

    function checkCollision(A, B) {
      const dx = B.x - A.x;
      const dy = B.y - A.y;
      const dist = Math.hypot(dx, dy);
      const min = A.r + B.r;
      
      if (dist < min && dist > 0) {
        const overlap = min - dist;
        const nx = dx / dist;
        const ny = dy / dist;
        A.x -= nx * overlap / 2;
        A.y -= ny * overlap / 2;
        B.x += nx * overlap / 2;
        B.y += ny * overlap / 2;
        const va = A.vx * nx + A.vy * ny;
        const vb = B.vx * nx + B.vy * ny;
        const diff = vb - va;
        A.vx += diff * nx;
        A.vy += diff * ny;
        B.vx -= diff * nx;
        B.vy -= diff * ny;
      }
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
        b.vy = 0; // on remet la vitesse verticale à 0 pour qu'elles repartent directement vers le haut
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

    /************** Drag & Drop ***********************/
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

    // Ajout de la détection de visibilité de la page
    document.addEventListener('visibilitychange', () => {
      isPageVisible = document.visibilityState === 'visible';
    });

    init();
    requestAnimationFrame(animate);
  })();