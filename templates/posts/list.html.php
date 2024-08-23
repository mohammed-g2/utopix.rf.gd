<div class="container my-5">
    <h2 class="mb-4 pb-2 border-bottom">
        <?php if (isset($variables['category'])): ?>
            <?=$variables['category']->name?>
        <?php else: ?>
            All Posts
        <?php endif; ?>
    </h2>
    <div class="row">
        <div class="col-lg-8 col-12">
            <?php foreach ($variables['posts'] as $post): ?>
                <div class="card mb-3 rounded-0 bg-transparent">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?= $post->img_url ?>" class="img-fluid" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body bg-none pt-0">
                                <p class="card-text d-inline-block py-1 px-2 mt-md-0 mt-2"
                                    style="background-color:#8b1d15; color:#fff;">
                                    <?= $post->getCategory()->name ?? 'None' ?>
                                </p>

                                <a href="<?= '/posts/get/' . $post->id ?>">
                                    <h5 class="card-title"><?= $post->title ?></h5>
                                </a>
                                <p class="card-text">
                                    <small class="fst-italic">
                                        By <span class="text-danger me-2"><?= $post->getUser()->username ?></span> /
                                        <i class="zmdi zmdi-time ms-2"></i> <span class="me-2 time"><?= $post->updated_at ?></span> /
                                        <i class="zmdi zmdi-comments ms-2"></i> 15
                                    </small>
                                </p>
                                <p class="card-text"><?= substr($post->body, 0, 100) ?>...</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <nav class="pagination-items my-5">
                <?php if ($variables['page'] > 1): ?>
                    <a href="<?= $variables['url'] . '?page=' . $variables['page'] - 1 ?>" class="text-white">&laquo;</a>
                <?php else: ?>
                    <a href="#" class="text-white">&laquo;</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $variables['pages']; $i++): ?>
                    <a href="<?= $variables['url'] . '?page='?><?= $i ?>" class="text-white"><?= $i ?></a>
                <?php endfor; ?>

                <?php if ($variables['page'] < $variables['pages']): ?>
                    <a href="<?= $variables['url'] . '?page=' . $variables['page'] + 1 ?>" class="text-white">&raquo;</a>
                <?php else: ?>
                    <a href="#" class="text-white">&raquo;</a>
                <?php endif; ?>
                </ul>
            </nav>

        </div>
        <div class="col-lg-4 col-12 p-0 m-0">
            <div class="ms-lg-3 mx-lg-0 mx-4">
                <h4 class="mb-4">&#8281; <span class="fst-italic">Social Media</span></h4>
                <p class="p-0 social-media skew">
                    <span class="bg-dark d-inline-block py-3 px-3 me-3 text-white"><i class="zmdi zmdi-facebook-box zmdi-hc-lg"></i>
                    </span>
                    Facebook
                </p>
                <p class="p-0 social-media skew">
                    <span class="bg-dark d-inline-block py-3 px-3 me-3 text-white"><i class="zmdi zmdi-twitter zmdi-hc-lg"></i></span>
                    Twitter
                </p>
            </div>
            <hr>

            <div class="ms-lg-3 mx-lg-0 mx-4 mb-4">
                <h4 class="mb-4 mt-4">&#8281; <span class="fst-italic">Subscribe</span></h4>
                <p class="fst-italic">Join our newsletter</p>
                <form>
                    <div class="mb-3">
                        <label for="subscribe" class="form-label">Email</label>
                        <input type="email" class="form-control" id="subscribe" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-red px-5">Join</button>
                    </div>
                </form>
            </div>
            <hr class="mb-5">
        </div>
    </div>
</div>