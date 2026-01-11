(function(){
  // auto-hide toasts
  const toasts = document.querySelectorAll('.toast');
  if (toasts.length) {
    setTimeout(() => toasts.forEach(t => t.style.display = 'none'), 6000);
  }

  // Very small, dependency-free bar chart (canvas)
  window.renderSimpleBarChart = function(canvasId){
    const c = document.getElementById(canvasId);
    if (!c) return;
    const raw = c.getAttribute('data-chart');
    if (!raw) return;
    let data;
    try { data = JSON.parse(raw); } catch(e) { return; }
    if (!Array.isArray(data) || !data.length) return;

    const ctx = c.getContext('2d');
    const W = c.width, H = c.height;
    ctx.clearRect(0,0,W,H);

    const pad = 38;
    const max = Math.max(...data.map(d => Number(d.value)||0), 1);
    const barW = Math.max(30, (W - pad*2) / data.length - 14);

    // background grid
    ctx.globalAlpha = 0.25;
    for (let i=0;i<5;i++){
      const y = pad + (H - pad*2) * (i/4);
      ctx.beginPath();
      ctx.moveTo(pad, y);
      ctx.lineTo(W-pad, y);
      ctx.strokeStyle = '#6b7ab5';
      ctx.stroke();
    }
    ctx.globalAlpha = 1;

    // bars
    data.forEach((d, i) => {
      const val = Number(d.value)||0;
      const x = pad + i * (barW + 14);
      const h = (H - pad*2) * (val / max);
      const y = H - pad - h;

      // bar
      ctx.fillStyle = 'rgba(110,168,254,0.55)';
      ctx.strokeStyle = 'rgba(110,168,254,0.95)';
      ctx.lineWidth = 1;
      ctx.beginPath();
      ctx.roundRect(x, y, barW, h, 10);
      ctx.fill();
      ctx.stroke();

      // label
      ctx.fillStyle = 'rgba(232,236,255,0.9)';
      ctx.font = '12px ui-sans-serif, system-ui';
      const label = String(d.label ?? '').slice(0, 14);
      ctx.fillText(label, x, H - 14);

      // value
      ctx.fillStyle = 'rgba(232,236,255,0.85)';
      ctx.fillText(String(val), x, y - 6);
    });
  }
})();
