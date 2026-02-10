<dialog id="globalConfirmModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg" id="globalConfirmTitle">Confirm Action</h3>
        <p class="py-4" id="globalConfirmMessage">Are you sure?</p>
        <div class="modal-action">
            <form method="dialog">
                <button class="btn btn-ghost" id="globalConfirmCancel">Cancel</button>
            </form>
            <button class="btn btn-primary" id="globalConfirmBtn">Confirm</button>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>

<script>
    let globalConfirmCallback = null;

    window.showConfirm = function(message, onConfirm, title = 'Confirm Action', confirmText = 'Confirm', type = 'primary') {
        const modal = document.getElementById('globalConfirmModal');
        const titleEl = document.getElementById('globalConfirmTitle');
        const msgEl = document.getElementById('globalConfirmMessage');
        const btn = document.getElementById('globalConfirmBtn');
        
        titleEl.textContent = title;
        msgEl.textContent = message;
        btn.textContent = confirmText;
        
        // Reset classes
        btn.className = 'btn';
        if (type === 'error' || type === 'danger') btn.classList.add('btn-error');
        else if (type === 'warning') btn.classList.add('btn-warning');
        else btn.classList.add('btn-primary');

        // Unbind previous event
        const newBtn = btn.cloneNode(true);
        btn.parentNode.replaceChild(newBtn, btn);
        
        newBtn.addEventListener('click', function() {
            if (typeof onConfirm === 'function') {
               onConfirm();
            }
            modal.close();
        });

        modal.showModal();
    };
</script>
