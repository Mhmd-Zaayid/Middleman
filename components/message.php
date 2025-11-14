<?php
// Build a unified array of messages for custom toast notifications
$__all_toasts = [];
if(isset($success_msg)) { foreach($success_msg as $__m){ $__all_toasts[] = ['type'=>'success','text'=>$__m]; } }
if(isset($warning_msg)) { foreach($warning_msg as $__m){ $__all_toasts[] = ['type'=>'warning','text'=>$__m]; } }
if(isset($info_msg))    { foreach($info_msg as $__m){ $__all_toasts[] = ['type'=>'info','text'=>$__m]; } }
if(isset($error_msg))   { foreach($error_msg as $__m){ $__all_toasts[] = ['type'=>'error','text'=>$__m]; } }
?>

<?php if (!empty($__all_toasts)) : ?>
  <div class="toast-stack" id="toast-stack"></div>
  <script>
  (function(){
    const stack = document.getElementById('toast-stack');
    const toasts = <?php echo json_encode($__all_toasts); ?>;
    toasts.forEach((t,i)=>{
      const el = document.createElement('div');
      el.className = `toast toast-${t.type}`;
      el.innerHTML = `<span class="toast-icon">${iconForType(t.type)}</span><span class="toast-text"></span><button class="toast-close" aria-label="Close">&times;</button>`;
      el.querySelector('.toast-text').textContent = t.text;
      stack.appendChild(el);
      requestAnimationFrame(()=>{ el.classList.add('show'); });
      setTimeout(()=> dismissToast(el), 4500 + i*150);
    });
    stack.addEventListener('click', (e)=>{
      if(e.target.classList.contains('toast-close')){
        const toast = e.target.closest('.toast');
        dismissToast(toast);
      }
    });
    function dismissToast(el){ if(!el) return; el.classList.remove('show'); el.addEventListener('transitionend', ()=> el.remove()); }
    function iconForType(type){
      switch(type){
        case 'success': return '✔';
        case 'info': return 'ℹ';
        case 'warning': return '⚠';
        case 'error': return '✖';
        default: return '★';
      }
    }
  })();
  </script>
<?php endif; ?>

