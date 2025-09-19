<?php if ($this->session->flashdata('success')): ?>
    <div id="flash-alert" class="alert alert-success-soft show flex items-center mb-2 mt-3" role="alert">
        <i data-lucide="check-circle" class="w-6 h-6 mr-2"></i>
        <?= $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div id="flash-alert" class="alert alert-danger-soft show flex items-center mb-2 mt-3" role="alert">
        <i data-lucide="x-circle" class="w-6 h-6 mr-2"></i>
        <?= $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('warning')): ?>
    <div id="flash-alert" class="alert alert-warning-soft show flex items-center mb-2 mt-3" role="alert">
        <i data-lucide="alert-triangle" class="w-6 h-6 mr-2"></i>
        <?= $this->session->flashdata('warning'); ?>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('info')): ?>
    <div id="flash-alert" class="alert alert-info-soft show flex items-center mb-2 mt-3" role="alert">
        <i data-lucide="info" class="w-6 h-6 mr-2"></i>
        <?= $this->session->flashdata('info'); ?>
    </div>
<?php endif; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let alertBox = document.getElementById("flash-alert");
        if (alertBox) {
            setTimeout(() => {
                alertBox.style.transition = "opacity 0.5s ease";
                alertBox.style.opacity = "0";
                setTimeout(() => alertBox.remove(), 500);
            }, 3000); 
        }
    });
</script>
