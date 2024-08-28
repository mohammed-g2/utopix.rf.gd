<!--################# Begin Hero Content #################-->
<div id="hero-image" class="row h-100 m-0" style="background-image: url(<?= $variables['hero']->img_url ?>);">
    <div class="col-md-6 col-12 d-flex align-items-center justify-content-center align-self-center">
        <?php if (isset($variables['hero'])): ?>
            <div class="ms-lg-5">
                <?php $heroCategory = $variables['hero']->getCategory(); ?>
                <a href="/categories/get/<?= $heroCategory->id ?>" class="px-3 py-2 d-inline-block mt-md-0 mt-5 mb-1" style="background-color:#8b1d15; color:#fff;">
                    <?= htmlspecialchars($heroCategory->name, ENT_QUOTES, 'UTF-8') ?>
                </a>
                <h1>
                    <a href="/posts/get/<?= $variables['hero']->id ?>" class="text-white">
                        <?= htmlspecialchars($variables['hero']->title, ENT_QUOTES, 'UTF-8') ?>
                    </a>
                </h1>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-md-6 col-12 p-lg-5 mt-4">
        <div class="p-4 mx-auto glass-bg" style="max-width:330px;">
            <h4><i class="zmdi zmdi-trending-up fw-bold mb-5" style="color:#9e0303;"></i> Trending Posts</h4>

            <?php if (isset($variables['trending'])): ?>
                <?php foreach ($variables['trending'] as $trending): ?>
                    <a class="d-flex align-items-center mb-3 d-block text-black" href="/posts/get/<?= $trending->id ?>">
                        <div class="h-100">
                            <img src="<?= $trending->img_url ?>" class="img-fluid thumbnail">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="m-0 p-0"><?= htmlspecialchars($trending->title, ENT_QUOTES, 'UTF-8') ?></h6>
                            <p class="m-0"><small><?= $trending->updated_at ?></small></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<!--################# End Hero Content #################-->



<!--################# Begin Updates section #################-->
<div class="row mt-5 p-0 m-0">
    <div class="col-12 p-0 m-0">

        <div class="container-fluid">
            <div class="row p-0 m-0 mx-lg-5">
                <div class="col-md-6 col-12 p-0 mb-4">

                    <a class="card text-bg-dark m-0 me-lg-2 h-100" href="/posts/get/<?= $variables['main'][0]->id ?>">
                        <img src="<?= $variables['main'][0]->img_url ?>" class="card-img rounded-0 h-100" alt="...">
                        <div class="card-img-overlay d-flex align-items-end p-0">
                            <div style="background-color:#8b1d1571;" class="p-3 w-100">
                                <h5 class="card-title d-flex">
                                    <span class="me-2">&#8284;</span>
                                    <span><?= htmlspecialchars($variables['main'][0]->title, ENT_QUOTES, 'UTF-8') ?></span>
                                </h5>
                                <p class="card-text">
                                    <small class="me-2">
                                        <i class="zmdi zmdi-time"></i>
                                        <span class="time me-2"><?= $variables['main'][0]->updated_at ?></span> /
                                        <i class="zmdi zmdi-comments ms-2"></i>
                                    </small>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-12 p-0 mb-4">
                    <a href="/posts/get/<?= $variables['main'][1]->id ?>" class="card text-bg-dark m-0 mb-3 ms-lg-2 d-flex h-100">
                        <img src="<?= $variables['main'][1]->img_url ?>" class="card-img rounded-0 h-100" alt="...">
                        <div class="card-img-overlay d-flex align-items-end p-0">
                            <div style="background-color:#8b1d1571;" class="p-3 w-100">
                                <h5 class="card-title d-flex">
                                    <span class="me-2">&#8284;</span>
                                    <span><?= htmlspecialchars($variables['main'][1]->title, ENT_QUOTES, 'UTF-8') ?></span>
                                </h5>
                                <p class="card-text">
                                    <small class="me-2">
                                        <i class="zmdi zmdi-time"></i>
                                        <span class="time me-2"><?= $variables['main'][1]->updated_at ?></span> /
                                        <i class="zmdi zmdi-comments ms-2"></i>
                                    </small>
                                </p>
                            </div>
                        </div>
                    </a>

                </div>
            </div>


            <div class="row p-0 m-0 px-lg-5">
                <div class="col-md-4 col-12 p-0 mb-4">
                    <a href="/posts/get/<?= $variables['main'][2]->id ?>" class="card text-bg-dark m-0 mb-3 h-100">
                        <img src="<?= $variables['main'][2]->img_url ?>" class="card-img rounded-0 h-100" alt="...">
                        <div class="card-img-overlay d-flex align-items-end p-0">
                            <div style="background-color:#8b1d1571;" class="p-3 w-100">
                                <h5 class="card-title d-flex">
                                    <span class="me-2">&#8284;</span>
                                    <span><?= htmlspecialchars($variables['main'][2]->title, ENT_QUOTES, 'UTF-8') ?></span>
                                </h5>
                                <p class="card-text">
                                    <small class="me-2">
                                        <i class="zmdi zmdi-time"></i>
                                        <span class="time me-2"><?= $variables['main'][2]->updated_at ?></span> /
                                        <i class="zmdi zmdi-comments ms-2"></i>
                                    </small>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 col-12 p-0 mb-4">
                    <a href="/posts/get/<?= $variables['main'][3]->id ?>" class="card text-bg-dark ms-md-2 m-0 mb-3 h-100">
                        <img src="<?= $variables['main'][3]->img_url ?>" class="card-img rounded-0 h-100" alt="...">
                        <div class="card-img-overlay d-flex align-items-end p-0">
                            <div style="background-color:#8b1d1571;" class="p-3 w-100">
                                <h5 class="card-title d-flex">
                                    <span class="me-2">&#8284;</span>
                                    <span><?= htmlspecialchars($variables['main'][3]->title, ENT_QUOTES, 'UTF-8') ?></span>
                                </h5>
                                <p class="card-text">
                                    <small class="me-2">
                                        <i class="zmdi zmdi-time"></i>
                                        <span class="time me-2"><?= $variables['main'][3]->updated_at ?></span> /
                                        <i class="zmdi zmdi-comments ms-2"></i>
                                    </small>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 col-12 p-0 mb-4">
                    <a href="/posts/get/<?= $variables['main'][4]->id ?>" class="card text-bg-dark ms-md-2 m-0 mb-3 h-100">
                        <img src="<?= $variables['main'][4]->img_url ?>" class="card-img rounded-0 h-100" alt="...">
                        <div class="card-img-overlay d-flex align-items-end p-0">
                            <div style="background-color:#8b1d1571;" class="p-3 w-100">
                                <h5 class="card-title d-flex">
                                    <span class="me-2">&#8284;</span>
                                    <span><?= htmlspecialchars($variables['main'][4]->title, ENT_QUOTES, 'UTF-8') ?></span>
                                </h5>
                                <p class="card-text">
                                    <small class="me-2">
                                        <i class="zmdi zmdi-time"></i>
                                        <span class="time me-2"><?= $variables['main'][4]->updated_at ?></span> /
                                        <i class="zmdi zmdi-comments ms-2"></i>
                                    </small>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-4 col-12"></div>
</div>
<!--################# End Updates section #################-->


<!--################# Begin Articles section #################-->
<div class="row mt-5 p-0 m-0 mx-md-5">
    <div class="col-lg-8 col-12 m-0">
        <h4 class="mb-5">&#8281; <span class="fst-italic">Articles</span></h4>

        <?php foreach ($variables['secondary'] as $secondary): ?>
            <div class="card mb-3 rounded-0 bg-transparent">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?= $secondary->img_url ?>" class="img-fluid" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body bg-none pt-0">
                            <p class="card-text d-inline-block py-1 px-2 mt-md-0 mt-2"
                                style="background-color:#8b1d15; color:#fff;">
                                <?php $secCategory = $secondary->getCategory() ?>
                                <?php if (isset($secCategory)): ?>
                                    <?= htmlspecialchars($secCategory->name, ENT_QUOTES, 'UTF-8') ?>
                                <?php else: ?>
                                    <?= 'None' ?>
                                <?php endif; ?>
                            </p>
                            <a href="/posts/get/<?= $secondary->id ?>" class="card-title d-block fs-5"><?= htmlspecialchars($secondary->title, ENT_QUOTES, 'UTF-8') ?></a>
                            <p class="card-text">
                                <small class="fst-italic">
                                    By <a class="text-danger me-2">
                                        <?= htmlspecialchars($secondary->getUser()->username, ENT_QUOTES, 'UTF-8') ?>
                                    </a> /
                                    <i class="zmdi zmdi-time ms-2"></i> <span class="me-2"><?= $secondary->updated_at ?></span> /
                                    <i class="zmdi zmdi-comments ms-2"></i> 15
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

    <!--################# Begin Articles side section #################-->

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
    <!--################# End Articles side section #################-->

</div>
<!--################# End Articles section #################-->