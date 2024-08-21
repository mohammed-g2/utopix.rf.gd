<div class="container my-5">
    <h2 class="mb-4 pb-2 border-bottom">All Posts</h2>
    <div class="row">
        <div class="col-lg-8 col-12">
            <?php foreach ($variables['posts'] as $post): ?>
                <div class="card mb-3 rounded-0 bg-transparent">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?=$post->img_url?>" class="img-fluid" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body bg-none pt-0">
                                <p class="card-text d-inline-block py-1 px-2 mt-md-0 mt-2"
                                    style="background-color:#8b1d15; color:#fff;">Category
                                </p>
                                <a href="<?= '/posts/get/' . $post->id ?>">
                                    <h5 class="card-title"><?=$post->title?></h5>
                                </a>
                                <p class="card-text">
                                    <small class="fst-italic">
                                        By <span class="text-danger me-2"><?=$post->getUser()->username?></span> /
                                        <i class="zmdi zmdi-time ms-2"></i> <span class="me-2 time"><?=$post->updated_at?></span> /
                                        <i class="zmdi zmdi-comments ms-2"></i> 15
                                    </small>
                                </p>
                                <p class="card-text"><?=substr($post->body, 0, 100)?>...</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <nav class="pagination-items my-5">
        <?php if ($variables['page'] > 1): ?>
            <a href="<?= '/posts/list?page=' . $variables['page'] - 1 ?>" class="text-white">&laquo;</a>
        <?php else: ?>
            <a href="#" class="text-white">&laquo;</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $variables['pages']; $i++): ?>
            <a href="/posts/list?page=<?= $i ?>" class="text-white"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($variables['page'] < $variables['pages']): ?>
            <a href="<?= '/posts/list?page=' . $variables['page'] + 1 ?>" class="text-white">&raquo;</a>
        <?php else: ?>
            <a href="#" class="text-white">&raquo;</a>
        <?php endif; ?>
        </ul>
    </nav>
</div>