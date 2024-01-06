<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="/css/app.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="/js/app.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

        <title>Bookstore Library</title>

    </head>
    <body>
        <div class="modal fade" id="showBookModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="showBookModalTitle">Title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="placeholder.png" alt="book-cover" id="showBookModalCover">
                    </div>
                    <div class="modal-footer">
                        <p id="showBookModalAuthor"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="insertBookModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add a new book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="insertBookTitleInput" class="form-label">Title</label>
                            <input type="text" class="form-control" id="insertBookTitleInput">
                        </div>
                        <div class="mb-3">
                            <label for="insertBookAuthorInput" class="form-label">Author</label>
                            <input type="text" class="form-control" id="insertBookAuthorInput">
                        </div>
                        <div class="mb-3">
                            <label for="insertBookCoverInput" class="form-label">Cover image</label>
                            <input class="form-control" type="file" id="insertBookCoverInput">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="insertBookCloseBtn" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="insertBookSaveBtn">Save</button>
                </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="updateBookModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update a book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="updateBookTitleInput" class="form-label">Title</label>
                            <input type="text" class="form-control" id="updateBookTitleInput">
                        </div>
                        <div class="mb-3">
                            <label for="updateBookAuthorInput" class="form-label">Author</label>
                            <input type="text" class="form-control" id="updateBookAuthorInput">
                        </div>
                        <div class="mb-3">
                            <label for="updateBookCoverInput" class="form-label">Cover image</label>
                            <input class="form-control" type="file" id="updateBookCoverInput">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="updateBookCloseBtn" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateBookSaveBtn">Save</button>
                </div>
                </div>
            </div>
        </div>

        <header class="header">
            <div class="navbar mb-4">
                <div class="container d-flex justify-content-between">
                    <h3>Bookstore Library</h3>
                </div>
            </div>
        </header>
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-11">

                </div>
                <div class="col-md-1">
                    <a href="#" class="btn-add-book btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#insertBookModal">+ Add</a>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="d-flex flex-row bd-highlight">
                        <div class="pe-2 bd-highlight">
                            <h4>Sort by:</h4>
                        </div>
                        <div class="bd-highlight">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" id="sortByDropdownToggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Title
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item sort-by-dropdown-item" href="#">Title</a></li>
                                    <li><a class="dropdown-item sort-by-dropdown-item" href="#">Author</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="bd-highlight">
                            <button type="button" class="btn btn-primary" id="sortByBtn"><span>∧</span></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="float-end">
                        <div class="d-flex flex-row bd-highlight">
                            <input class="form-control me-2" type="text" id="searchBookInput" placeholder="Search...">
                            <button type="button" class="btn btn-primary" id="searchBookBtn">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row" id="bookstore">

            </div>
        </div>
    </body>
</html>
