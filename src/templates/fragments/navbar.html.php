<!--################# Begin Navbar #################-->
<nav 
        class="row navbar navbar-expand-lg m-0" 
        hx-replace-url="true" 
        hx-boost="true" 
        hx-indicator="#spinner" 
        hx-target="body">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/posts/list">Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/categories/list">Categories</a>
                </li>

                <li class="nav-item">
                    <button class="btn mt-md-5 rounded-0" id="search-btn" onclick="new bootstrap.Modal('#search-modal', {}).show();">
                        <i class="zmdi zmdi-hc-lg zmdi-search"></i>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!--################# End Navbar #################-->

<!-- search modal -->
<div id="search-modal" class="modal fade" style="color:#000;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form class="px-3 py-2" method="GET" action="">
                    <div class="mb-3">
                        <input type="text" class="form-control border-0" id="search-field" placeholder="Start typing here...">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>