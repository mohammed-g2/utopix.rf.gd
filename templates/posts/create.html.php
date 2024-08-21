<link rel="stylesheet" href="/assets/css/write.css">

<script src="/assets/libs/js/showdown.min.js"></script>
<script src="/assets/js/write.js"></script>

<div class="container-fluid px-0 mx-0 h-100">
    <form method="post">
        <div class="banner">
            <img src="" id="img-preview" class="img-preview">
            <input name="img" type="file" hidden="true" id="banner-upload" class="img-upload" accept="image/*" onclick="imgUpload()">
            <label for="banner-upload" class="banner-upload-btn">
                <i class="zmdi zmdi-upload"></i>
            </label>
        </div>

        <div class="blog">
            <input name="title" class="title" type="text" id="post-title" placeholder="Post Title...">
            <textarea name="body" class="article" id="post-body" placeholder='Start writing here...'></textarea>
        </div>

        <div class="blog-options">
            <button class="btn btn-success me-3 px-5">Publish</button>
            <a href="#" class="btn btn-warning me-3 px-5" onclick="previewPost()">Preview</a>

            <input name="img" type="file" id="image-upload" class="img-upload" hidden="true" accept="image/*" onclick="imgUpload()">
            <label for="image-upload" class="btn btn-secondary px-4">Upload Image</label>

            <select class="form-select form-select-sm ms-3" style="max-width:140px;">
                <option selected>Category</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
        </div>
    </form>

    <!-- error image upload modal -->
    <div id="upload-err" class="modal fade" style="color:#000;">
        <div class="modal-dialog">
            <div class="modal-content bg-warning border-0">
                <div class="modal-header border-bottom border-dark">
                    <span class="material-icons me-2">error_outline</span>
                    An Error ocurred
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Image shouldn't be larger than 1 MB.</div>
            </div>
        </div>
    </div>

    <!-- preview post modal -->
    <div id="preview-post" class="modal fade" style="color:#000;">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title"></h1>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = () => {
        document.getElementById('footer').outerHTML = '';
    };
</script>