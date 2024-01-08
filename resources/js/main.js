const Main = {

    baseUrl : '/api/books',

    books : [],

    sortByField : 'title',

    sortByAsc : true,

    init : function () {
        $(document).ready(function() {
            Main.registerEvents();
        });
        this.getBooks();
    },

    /**
     * Register click events
     */
    registerEvents : function () {
        $('#insertBookSaveBtn').click(function () {
            Main.insertBook();
        })
        $('.sort-by-dropdown-item').click(function () {
            const sortByText = $(this).text()
            $('#sortByDropdownToggle').text(sortByText)
            Main.sortByField = sortByText.toLowerCase();
            Main.getBooks();
        })
        $('#sortByBtn').click(function () {
            Main.sortByAsc = !Main.sortByAsc;
            $('#sortByBtn span').text((Main.sortByAsc) ? '∧' : '∨')
            Main.getBooks();
        })
        $('#searchBookBtn').click(function () {
            Main.getBooks();
        })
        $('#bookstore').on('click', '.book-item', function (event) {
            if (!$(event.target).hasClass('btn')) {
                Main.openBookModal($(this));
            }
        })
        $('#bookstore').on('click', '.btn-edit-book', function () {
            Main.showUpdateBook($(this))
        })
        $('#bookstore').on('click', '.btn-delete-book', function () {
            Main.deleteBook($(this).data('id'))
        })
        $('#updateBookSaveBtn').click(function () {
            Main.updateBook($(this).attr('data-id'));
        })
    },

    /**
     * Show modal when clicking an individual book
     * @param {*} element 
     */
    openBookModal : function (element) {
        const showBookModal = $('#showBookModal')
        const title = element.find('h5').text();
        const author = element.find('p').text();
        const img_src = element.find('img').attr('src')
        $('#showBookModalTitle').text(title);
        $('#showBookModalAuthor').text(`by ${author}`);
        $('#showBookModalCover').attr('src', img_src);
        showBookModal.modal('show');
    },

    /**
     * Get all books based on search and sort by criteria
     */
    getBooks : function () {
        $('#bookstore').empty();
        $.ajax({
            method : 'GET',
            url    : this.baseUrl,
            data: {
                'field': Main.sortByField,
                'sort' : (Main.sortByAsc) ? 'asc' : 'desc',
                'search' : $('#searchBookInput').val()
            }
        }).done(function (res) {
            Main.books = res;
            Main.populateBookstore();
        })
    },

    /**
     * Helper function get populated element
     * @param {*} book 
     * @returns 
     */
    getPopulateElement : function (book) {
        return `
            <div class="col-md-4 book-item" data-id="${book.id}">
                <div class="card mb-4 shadow-sm">
                    <img src="${book.cover_img}" alt="book-cover">
                    <div class="card-body">
                        <h5 class="card-title">${book.title}</h5>
                        <p class="card-text">${book.author}</p>
                        <a class="btn-edit-book btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateBookModal" data-id="${book.id}">Edit</a>
                        <a class="btn-delete-book btn btn-danger" data-id="${book.id}">Delete</a>
                    </div>
                </div>
            </div>
        `;
    },

    /**
     * Fill out bookstore with populated element
     */
    populateBookstore : function () {
        const bookstore = $('#bookstore');
        Main.books.forEach((book) => {
            const populateElement = Main.getPopulateElement(book);
            bookstore.append(populateElement)
        })
    },

    /**
     * Prepare form data for insert and update
     * @param {*} method 
     * @returns 
     */
    prepareFormData : function (method) {

        const bookTitleInputSelector = $(`#${method}BookTitleInput`);
        const bookAuthorInputSelector = $(`#${method}BookAuthorInput`);
        const bookCoverInputSelector = $(`#${method}BookCoverInput`);
        const bookTitleValue = bookTitleInputSelector.val();
        const bookAuthorValue = bookAuthorInputSelector.val();
        const bookCoverValue = bookCoverInputSelector[0].files[0];

        let formData = new FormData();
        formData.append('title', bookTitleValue)
        formData.append('author', bookAuthorValue)
        formData.append('cover_img', bookCoverValue)

        return formData;
    },

    /**
     * Actions to be done after insert and update
     * @param {*} method 
     */
    concludeDataChange : function (method) {
        Main.getBooks()
        $(`#${method}BookCloseBtn`).click();
        $(`#${method}BookTitleInput`).val('')
        $(`#${method}BookAuthorInput`).val('')
        $(`#${method}BookCoverInput`).val('')
    },

    /**
     * Inset book
     */
    insertBook : function () {
        $.ajax({
            method : 'POST',
            url    : this.baseUrl,
            data   : Main.prepareFormData('insert'),
            processData: false,
            contentType: false
        }).done(function (res) {
            Main.concludeDataChange('insert')
        }).fail(function (res) {
            alert('Something went wrong with the request.')
        });
    },

    /**
     * Show update book modal
     * @param {*} element 
     */
    showUpdateBook : function (element) {
        $(`#updateBookCoverInput`).val('')
        const title = element.siblings('h5').first().text();
        const author = element.siblings('p').first().text();
        $('#updateBookTitleInput').val(title);
        $('#updateBookAuthorInput').val(author);
        $('#updateBookSaveBtn').attr('data-id', element.data('id'));
    },

    /**
     * Update book
     * @param {*} id 
     */
    updateBook : function (id) {
        let data = Main.prepareFormData('update');
        $.ajax({
            method : 'POST',
            url    : `${this.baseUrl}/${id}/?_method=PUT`,
            data   : data,
            processData: false,
            contentType: false
        }).done(function (res) {
            Main.concludeDataChange('update')
        }).fail(function (res) {
            alert('Something went wrong with the request.')
        });
    },

    /**
     * Delete book
     * @param {*} id 
     */
    deleteBook : function (id) {
        if (confirm('Are you sure you want to delete this book?')) {
            $.ajax({
                method : 'POST',
                url    : `${this.baseUrl}/${id}/?_method=DELETE`
            }).done(function (res) {
                $(`.book-item[data-id="${id}"]`).remove()
            }).fail(function (res) {
                alert('Something went wrong with the request.')
            });
        }
    }

}
Main.init();

export default Main;