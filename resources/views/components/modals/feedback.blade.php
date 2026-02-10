<dialog id="feedbackModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg" id="feedbackTitle"></h3>
        <p class="py-4" id="feedbackMessage"></p>
        <div class="modal-action">
            <form method="dialog">
                <button class="btn">Close</button>
            </form>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>

<script>
    window.showSuccess = function(message, title = 'Success', onClose = null) {
        const modal = document.getElementById('feedbackModal');
        const titleEl = document.getElementById('feedbackTitle');
        const msgEl = document.getElementById('feedbackMessage');
        
        titleEl.className = 'font-bold text-lg text-success';
        titleEl.textContent = title;
        msgEl.textContent = message;
        
        const closeHandler = function() {
            if (typeof onClose === 'function') onClose();
            modal.removeEventListener('close', closeHandler);
        };
        
        if (onClose) {
            modal.addEventListener('close', closeHandler);
        }
        
        modal.showModal();
    };

    window.showError = function(message, title = 'Error', onClose = null) {
        const modal = document.getElementById('feedbackModal');
        const titleEl = document.getElementById('feedbackTitle');
        const msgEl = document.getElementById('feedbackMessage');
        
        titleEl.className = 'font-bold text-lg text-error';
        titleEl.textContent = title;
        msgEl.textContent = message;
        
         const closeHandler = function() {
            if (typeof onClose === 'function') onClose();
            modal.removeEventListener('close', closeHandler);
        };
        
        if (onClose) {
            modal.addEventListener('close', closeHandler);
        }
        
        modal.showModal();
    };
</script>
