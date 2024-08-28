<?php if (!empty($flashedMsgs)): ?>
    <div class="position-absolute start-50 top-50 translate-middle" style="z-index:100; min-width:400px;">
        <?php foreach ($flashedMsgs as $msg): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?= $msg ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>