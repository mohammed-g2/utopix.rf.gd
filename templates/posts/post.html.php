<div class="container-fluid m-0 p-0 w-100">
    <div class="row m-0 p-0 w-100">
        <div class="col-lg-8 col-12 w-100 m-0 p-0">
            <div class="w-100" style="height:500px;">
                <img
                    src="<?=$post->img_url?>" 
                    style="width:100%; height:100%; overflow: hidden;">
            </div>
            <div class="p-5">
                <h2><?=$post->title?></h2>
                <?php $category = $post->getCategory(); ?>
                <h6><a href="/categories/get/<?=$category->id?>"><?=$category->name?></a></h6>
                <p>By <?=$post->getUser()->username?> - <?=$post->updated_at?></p>
                <hr>
                <div style="word-wrap: break-word;">
                    <?=$post->body?>
                </div>
            </div>
        </div>
    </div>
</div>