//User show wishlist and delete process

$(document).ready(function () {

    // Initial load
    loadWishlist();

    const wishlistContainer = $('#wishlist-container');
    const paginationBox = $('#pagination-box');
    const resultsInfo = $('.results-info');

    // Function to load wishlist items
  function loadWishlist(page = 1) {

    $.ajax({
        url: `/user/dashboard/wishlist-data?page=${page}`,
        type: 'GET',
        success: function (response) {

            wishlistContainer.empty();
            paginationBox.empty();
            resultsInfo.empty();

            if (response.status !== 'success') return;
            console.log(response);

            const wishlist = response.wishlist;

            if (wishlist.data.length === 0) {
                wishlistContainer.html(
                    '<div class="col-12 text-center"><p>No items found.</p></div>'
                );
                return;
            }

            wishlist.data.forEach(item => {
                wishlistContainer.append(`
                    <div class="col-lg-4 responsive-column-half">
                        <div class="card card-item">
                            <div class="card-body">
                                <h5>${item.course.course_name}</h5>
                                <p>${item.course.instructor.name}</p>
                                <button class="btn btn-danger btn-sm delete-wishlist-item"
                                    data-id="${item.id}">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                `);
            });

            // Pagination
            wishlist.links.forEach(link => {
                if (link.url !== null) {
                    paginationBox.append(`
                        <li class="page-item ${link.active ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${new URL(link.url).searchParams.get('page')}">
                                ${link.label}
                            </a>
                        </li>
                    `);
                }
            });

            // Results info
            resultsInfo.html(
                `Showing ${wishlist.from} - ${wishlist.to} of ${wishlist.total} results`
            );
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to load wishlist items.'
            });
        }
    });
}


    // Event listener for pagination
    paginationBox.on('click', '.page-link', function (e) {
        e.preventDefault();
        const page = $(this).data('page');
        loadWishlist(page);
    });



    // Function to calculate discount percentage
    function calculateDiscount(sellingPrice, discountPrice) {
        return ((sellingPrice - discountPrice) / sellingPrice * 100).toFixed(0);
    }

    // Function to get badge (Bestseller/Featured/HighestRated)
    function getBadge(course) {
        if (course.bestseller === 'yes') return 'Bestseller';
        if (course.featured === 'yes') return 'Featured';
        return 'HighestRated';
    }

    // Function to get price HTML
    function getPriceHtml(course) {
        if (course.discount_price) {
            return `
            <p class="card-price text-black font-weight-bold">
                $${course.discount_price}
                <span class="before-price font-weight-medium">${course.selling_price}</span>
            </p>`;
        }
        return `<span class="font-weight-medium">${course.selling_price}</span>`;
    }



    // Delete wishlist item
    wishlistContainer.on('click', '.delete-wishlist-item', function () {
        let wishlistId = $(this).data('id');
        let url = `/user/dashboard/wishlist/${wishlistId}`;

        // SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with AJAX request
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        // _token: '{{ csrf_token() }}' // CSRF token
                        _token: $('meta[name="csrf-token"]').attr('content')

                    },
                    success: function (response) {
                        console.log(response)
                        if (response.status === 'success') {



                            // Toast success alert
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });

                            loadWishlist(); // Reload wishlist after deletion
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message,
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to delete the item. Try again.',
                        });
                    }
                });
            }
        });
    });




    // Initial load
    loadWishlist();

    
});


//End
