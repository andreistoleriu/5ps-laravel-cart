<html>
    <head>
    
    <!-- Load the jQuery JS library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Custom JS script -->
    <script type="text/javascript">
        $(document).ready(function () {
            
            /**
            * A function that takes a products array and renders it's html
            * 
            * The products array must be in the form of
            * [{
            *     "title": "Product 1 title",
            *     "description": "Product 1 desc",
            *     "price": 1
            * },{
            *     "title": "Product 2 title",
            *     "description": "Product 2 desc",
            *     "price": 2
            * }]
            */
            function renderList(locationHash, products, price) {
                html = [
                    '<table class="table">',
                        '<thead class="thead-dark">',
                            '<tr>',
                                '<th></th>',
                                '<th> Title </th>',
                                '<th> Description </th>',
                                '<th> Price </th>'].join('')
                        if (locationHash[0] = '#products') {
                            html += [
                            '<th colspan="2"> Action </th>',
                            '</tr>'
                            ].join('');
                        } else {
                            html += [
                            '<th> Action </th>',
                            '</tr>',
                            '</thead>'
                            ].join('');
                        }
                
                $.each(products, function (key, product) {
                    html += '<tr>';
                    if (!product.image) {
                        html += '<td> No image available </td>'
                    } else {
                        html += '<td><img src="storage/images/' + product.image + '" width="150px"></td>';
                    }
                    html += [
                        '<td>' + product.title + '</td>',
                        '<td>' + product.description + '</td>',
                        '<td>' + product.price + '</td>'].join('');
                    switch (locationHash) {
                        case('#cart'):
                            html += '<td><button class="remove-from-cart btn btn-danger" data-id="' + product.id + '"> Remove </button></td>';
                            break;
                        case('#products'):
                            html += '<td><button class="edit-product btn btn-warning" data-id="' + product.id + '"> Edit </button></td>';
                            html += '<td><button class="delete-product btn btn-danger" data-id="' + product.id + '"> Delete </button></td>';                    
                            break;
                        default:
                            html += '<td><button class="add-to-cart btn btn-primary" data-id="' + product.id + '"> Add to cart </button></td>';
                            html += '<td><button class="view-details btn btn-warning" data-id="' + product.id + '"> View Details </button></td>';
                    };
                    html += '</tr>';
                });
                if (locationHash === '#cart' && price) {
                    html += [
                        '<tr>',
                            '<td colspan="3"><strong> Total price </strong></td>',
                            '<td colspan="2">' + price + '</td>',
                        '</tr>',
                        '</table>'
                    ].join('');
                }
                return html;
            };
            // A function that takes an orders array and renders it's html
            function renderOrders (orders) {
                    let html = [
                        '<table class="table">',
                            '<thead class="thead-dark">',
                                '<tr>',
                                    '<th> Order ID </th>',
                                    '<th> Name </th>',
                                    '<th> Contact Details </th>',
                                    '<th> Price </th>',
                                    '<th> Action </th>',
                                '</tr>',
                            '</thead>',
                            ].join('')
                    $.each(orders, function (key, order) {
                        html += [
                            '<tr>',
                                '<td>' + order.id + '</td>',
                                '<td>' + order.name + '</td>',
                                '<td>' + order.contact_details + '</td>',
                                '<td>' + order.price + '</td>',
                                '<td><button class="view-order btn btn-primary" data-id="' + order.id + '"> View details </button></td>',
                            '</tr>',
                        ].join('');
                    })
                    html += '</table>';
                    return html;
                }
            // A function that renders the individual order's products
            function renderOrderView (order) {
                console.log(order);
                html = [
                    '<p><strong> ID: </strong>' + order.id + '</p>',
                    '<p><strong>Name: </strong>' + order.name + '</p>',
                    '<p><strong>Contact details: </strong>' + order.contact_details + '</p>',
                    '<table class="table">',
                        '<thead class="thead-dark">',
                            '<tr>',
                                '<th> Image </th>',
                                '<th> Title </th>',
                                '<th> Description </th>',
                                '<th> Price </th>'].join('')
                $.each(order, function(key, product) {
                    html += [
                        '<tr>',
                            '<td><img src="storage/images/' + product.image + '" width="150px"></td>',
                            '<td>' + product.title + '</td>',
                            '<td>' + product.description + '</td>',
                            '<td>' + product.price + '</td>',
                        '</tr>',
                        '<tr>',
                            '<td colspan="3" align="center"><strong>Total price: </strong></tr>',
                        '</tr>'
                    ].join('');
                })
                html += '</table>'
                return html;
            }

            function redirectUnauthorised (response) {
                if (response.status === 401) {
                    window.location.hash = '#login';
                }
            };

            /**
            * URL hash change handler
            */
            window.onhashchange = function () {
                // First hide all the pages
                $('.page').hide();
                let locationHash = window.location.hash.split('/');
                switch(locationHash[0]) {
                    case '#cart':
                        // Show the cart page
                        $('.cart').show();
                        // Load the cart products from the server
                        $.ajax('/cart', {
                            dataType: 'json',
                            success: function (response) {
                                if (response.cart) {
                                    //Render the checkout form
                                    $('.cart .checkout-form').css('display', 'block');
                                    // Render the products in the cart list
                                    $('.cart .list').html(renderList(window.location.hash, response.products, response.price));
                                } else {
                                    //Don't render the checkout form
                                    $('.cart .checkout-form').hide();
                                    // Don't render the products if there is nothing in the cart
                                    $('.cart .list').html('<p class="text-danger"> Cart is empty </p>')

                                }
                            }
                        });
                    break;
                    case '#login':
                        $('.login').show();
                    break;
                    case '#logout':
                    $.ajax('/logout', {
                        type:'POST',
                        success: function() {
                            window.location.hash = '#'
                        }
                    })
                    break;
                    case '#products':
                            $.ajax('/products', {
                                dataType: 'json',
                                success: function (response) {
                                    $('.products').show();
                                    $('.products .list').html(renderList(window.location.hash, response));
                                },
                                error: function (response) {
                                    redirectUnauthorised(response);
                                }
                            })
                    break;
                    case '#product':
                        if (locationHash.length > 1) {
                            $('.page').hide();
                            if (locationHash[1] === 'create') {
                                $.ajax('/products', {
                                    dataType: 'json',
                                    success: function (response) {
                                        $('.products-create-edit').show();
                                        $('.product-update').hide();
                                        $('.product-create').show();
                                    },
                                    error: function (response) {
                                        redirectUnauthorised(response);
                                    }
                                })
                            }
                        }
                        if (locationHash[2] === 'edit') {
                            $.ajax(`/products/${locationHash[1]}/edit`, {
                                dataType: 'json',
                                success: function (response) {
                                    $('.products-create-edit').show();
                                    $('.product-update').show();
                                    $('.product-create').hide();
                                    $('#title').val(response.title);
                                    $('#description').val(response.description);
                                    $('#price').val(response.price);
                                    $('#product-id').val(response.id);
                                },
                                error: function (response) {
                                    redirectUnauthorised(response);
                                }
                            })
                        }
                    break;
                    case '#orders':
                        $.ajax('/orders', {
                            dataType: 'json',
                            success: function (response) {
                                $('.orders').show();
                                $('.orders .orders-list').html(renderOrders(response));
                            },
                            error: function (response) {
                                redirectUnauthorised(response);
                            }
                        });
                    break;
                    case '#order':
                        // Show the individual order page
                        $('.order').show();
                        if (locationHash.length > 1) {
                            $.ajax(`/order/${locationHash[1]}`, {
                                dataType: 'json',
                                success: function (response) {
                                    $('.order .order-list').html(renderOrderView(response.order))
                                },
                                error: function (response) {
                                    redirectUnauthorised(response);
                                    
                                }
                            })
                        }
                    break;
                    default:
                        // If all else fails, always default to index
                        // Show the index page
                        $('.index').show();
                        // Load the index products from the server
                        $.ajax('/', {
                            dataType: 'json',
                            success: function (response) {
                                if (!response.length) {
                                    // Don't render the products table if all products in cart
                                    $('.index .list').html('<p class="text-danger"> No products available </p>')
                                } else {
                                    // Render the products in the index list
                                    $('.index .list').html(renderList(window.location.hash, response));
                                }
                            }
                        });
                    break;
                    }
                }
                window.onhashchange();
            });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // add products to cart
        $(document).on('click', '.add-to-cart', function () {
            $.ajax('/', {
                type: 'POST',
                data: {
                    id: $(this).data('id')
                },
                dataType: 'json',
                success: function () {
                    window.onhashchange();
                }
            });
        });

        // remove products from cart
        $(document).on('click', '.remove-from-cart', function () {
            $.ajax('/cart', {
                type: 'POST',
                data: {
                    id: $(this).data('id'),
                },
                dataType: 'json',
                success: function () {
                    window.onhashchange();
                }
            });
        });

        function validationCheck(errorMessage, errorName, error) {
            errorName.css('display', 'block');
            errorName.html(errorMessage.errors[error]);
        }

        function productValidation(errorMessage) {
            if (errorMessage.errors.hasOwnProperty('title')) {
                let titleError = $('.title-error');
                validationCheck(errorMessage, titleError, 'title');
                $('#title').addClass('is-invalid');
            }
            if (errorMessage.errors.hasOwnProperty('description')) {
                let descriptionError = $('.description-error');
                validationCheck(errorMessage, descriptionError, 'description');
                $('#description').addClass('is-invalid');
            }
            if (errorMessage.errors.hasOwnProperty('price')) {
                let priceError = $('.price-error');
                validationCheck(errorMessage, priceError, 'price');
                $('#price').addClass('is-invalid');
            }
            if (errorMessage.errors.hasOwnProperty('image')) {
                let imageError = $('.image-error');
                validationCheck(errorMessage, imageError, 'image');
                $('#image').addClass('is-invalid');
            }
        }
        

        //checkout form functionality
        $(document).on('click', '.submit', function (e) {
            e.preventDefault();
            let data = new FormData();
            data.append('name', $('input[id=name]').val());
            data.append('contactDetails', $('input[id=contactDetails]').val());
            data.append('comments', $('textarea[id=comments]').val());
            $('.submit').prop('disabled', true);
            $.ajax('/cart/checkout', {
                type: 'POST',
                data: data,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (result) {
                    alert(result.success);
                    $('.checkout-form').each(function() {
                        this.reset();  
                    })
                    $('.submit').prop('disabled', false);
                    window.onhashchange();
            },
            error: function (error) {
                $('.submit').prop('disabled', false);
                $('.submit').html(' Checkout ');

                let errorMessage = JSON.parse(error.responseText)
                if (errorMessage.errors.hasOwnProperty('name')) {
                    let nameErr = $('.name-error');
                    validationCheck(errorMessage, nameErr, 'name');
                    $('#name').addClass('is-invalid');
                }
                if (errorMessage.errors.hasOwnProperty('contactDetails')) {
                    let contactDetailsErr = $('.contactDetails-error');
                    validationCheck(errorMessage, contactDetailsErr, 'contactDetails');
                    $('#contactDetails').addClass('is-invalid');
                }
            }
        })
            $('input[id=name]').keypress(function() {
                $('.name-error').hide();
                $('#name').removeClass('is-invalid');
            });
            $('input[id=contactDetails]').keypress(function() {
                $('.contactDetails-error').hide();
                $('#contactDetails').removeClass('is-invalid');
            });
        });
        // Handle login functionality
        $(document).on('click', '.login-submit', function (e) {
            e.preventDefault();
            let data = new FormData();
            data.append('username', $('input[id=username]').val());
            data.append('password', $('input[id=password]').val());
            $.ajax('/login', {
                type: 'POST',
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('.login-button').hide();
                    $('.logout-button').show();
                    window.location.hash = '#products';
                },
                error: function (error) {
                    let errorMessage = JSON.parse(error.responseText)
                    if (errorMessage.errors.hasOwnProperty('username')) {
                        let usernameError = $('.username-error');
                        validationCheck(errorMessage, usernameError, 'username');
                        $('#username').addClass('is-invalid');
                    }
                    if (errorMessage.errors.hasOwnProperty('password')) {
                        let passwordError = $('.password-error');
                        validationCheck(errorMessage, passwordError, 'password');
                        $('#password').addClass('is-invalid')
                    }
                }
            })
            $('input[id=username]').keypress(function () {
                $('.username-error').hide();
                $('#username').removeClass('is-invalid');
            });
            $('input[id=password]').keypress(function () {
                $('.password-error').hide();
                $('#password').removeClass('is-invalid');
            });
        });
        // Delete product from database functionality
        $(document).on('click', '.delete-product', function () {
                let id = $(this).data('id');
                $.ajax(`products/${id}`, {
                    type: 'DELETE',
                    data: {
                        id
                    },
                    dataType: 'json',
                    success: function () {
                        window.onhashchange();
                    },
                });
            })
            // Redirect to product edit page
        $(document).on('click', '.edit-product', function () {
            let id = $(this).data('id');
            window.location.hash = `#product/${id}/edit`;
        })
        // View the individual order
        $(document).on('click', '.view-order', function () {
            let id = $(this).data('id');
            $('.order .order-view').empty();
            $('.order .order-list').empty();
            window.location.hash = `#order/${id}`;
        });
        // Product create functionality
        $(document).on('click', '.product-create', function (e) {
            e.preventDefault();

            let data = new FormData();
            data.append('title', $('input[id=title]').val());
            data.append('description', $('input[id=description]').val());
            data.append('price', $('input[id=price]').val());
            if ($('#image').get(0).files.length !== 0) {
                data.append('image', $('#image')[0].files[0]);
            }
            
            $('.product-create').prop('disabled', true);
            $('.product-create').html('Please wait');
            $.ajax('/products', {
                type: 'POST',
                dataType: 'json',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function () {
                    $('.product-create').prop('disabled', false);
                    $('.product-create').html('Create');
                    $('.product-form').each(function () {
                        this.reset();
                    })
                    window.location.hash='#products';
                },
                error: function (error) {
                    $('.product-create').prop('disabled', false);
                    $('.product-create').html('Create');
                    let errorMessage = JSON.parse(error.responseText)
                    productValidation(errorMessage);
                }           
            })
            $('input[id=title]').keypress(function () {
                $('.title-error').hide();
                $('#title').removeClass('is-invalid');
            });
            $('input[id=description]').keypress(function () {
                $('.description-error').hide();
                $('#description').removeClass('is-invalid');
            });
            $('input[id=price]').keypress(function () {
                $('.price-error').hide();
                $('#price').removeClass('is-invalid');
            });
        });
        // Product update functionality
        $(document).on('click', '.product-update', function (e) {
            e.preventDefault();
            let data = new FormData();
            data.append('_method', 'PUT');
            data.append('title', $('input[id=title]').val());
            data.append('description', $('input[id=description]').val());
            data.append('price', $('input[id=price]').val());
            if ($('#image').get(0).files.length !== 0) {
                data.append('image', $('#image')[0].files[0]);
            }
            
            $('.product-update').prop('disabled', true);
            $('.product-update').html('Please wait');
            $.ajax('/products/' + parseInt($('input[id=product-id]').val()), {
                type: 'POST',
                dataType: 'json',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function () {
                    $('.product-update').prop('disabled', false);
                    $('.product-update').html('Update');
                    $('.product-form').each(function () {
                        this.reset();
                    })
                    window.location.hash='#products';
                },
                error: function (error) {
                    $('.product-update').prop('disabled', false);
                    $('.product-update').html('Update');
                    let errorMessage = JSON.parse(error.responseText)
                    productValidation(errorMessage);
                }
            })
            $('input[id=title]').keypress(function () {
                $('.title-error').hide();
                $('#title').removeClass('is-invalid');
            });
            $('input[id=description]').keypress(function () {
                $('.description-error').hide();
                $('#description').removeClass('is-invalid');
            });
            $('input[id=price]').keypress(function () {
                $('.price-error').hide();
                $('#price').removeClass('is-invalid');
            });
        });
        
    </script>
    </head>
    <body>
        <div class="container">
            <!-- The nav bar -->
            <nav class="nav justify-content-center">
                <a class="nav-link" href="#"> Home </a>
                <a class="nav-link" href="#cart"> Cart </a>
                <a class="nav-link" href="#products"> Products </a>
                <a class="nav-link" href="#orders"> Orders </a>
                <a style="display:none" class="logout-button btn btn-warning nav-link" id="logout-btn" href="#logout">Logout</a>   
                <a class="login-button btn btn-warning nav-link" id="login-btn" href="#login">Login </a>
            </nav>

            <!-- The index page -->
            <div class="page index">
                <!-- The index element where the products list is rendered -->
                <div class="list"></div>

                <!-- A link to go to the cart by changing the hash -->
                <a href="#cart" class="button btn btn-warning"> Go to cart </a>
            </div>

            <!-- The cart page -->
            <div class="page cart">
                <!-- The cart element where the products list is rendered -->
                <div class="list"></div>

                <!-- The checkout form -->
                <form class="checkout-form">
                    <div class="form-group">
                        <label for="name"> Name </label>
                        <input type="text" class="form-control" id="name" placeholder="Enter your name...">
                        <p class="name-error text-danger" style="display: none"></p>
                    </div>

                    <div class="form-group">
                        <label for="contactDetails"> Contact details </label>
                        <input type="text" class="form-control" id="contactDetails"
                            placeholder="Enter your contact details...">
                        <p class="contactDetails-error text-danger" style="display: none"></p>
                    </div>

                    <div class="form-group">
                        <label for="comments"> Comments </label>
                        <textarea class="form-control" id="comments" rows="3"
                            placeholder=" Insert any comment.."></textarea>
                        <p class="comments-error text-danger" style="display: none"></p>
                    </div>

                    <button type="submit" class="submit btn btn-primary"> Checkout </button>
                </form>

                <!-- A link to go to the index by changing the hash -->
                <a href="#" class="button btn btn-warning"> Go to index </a>
            </div>

            <!-- The login page -->
            <div class="page login">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header"> Login </div>
            
                            <div class="card-body">
                                <form class="login-form">
                                    @csrf
            
                                    <div class="form-group row">
                                        <label for="username" class="col-md-4 col-form-label text-md-right"> Username </label>
            
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="username" name="username" placeholder="{{ __('Username') }}">
                                            <p class="username-error text-danger" style="display: none"></p>
                                        </div>
                                    </div>
            
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right"> Password </label>
            
                                        <div class="col-md-6">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="{{ __('Password') }}">
                                            <p class="password-error text-danger" style="display: none"></p>
                                        </div>
                                    </div>
                        
                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" id="login-button" class="login-submit btn btn-primary">
                                                 Login
                                            </button>
            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- The products page -->
            <div class="page products">
                <div class="list mb-1"></div>
                <div>
                    <a href="#product/create" class="btn btn-primary"> Add a new product </a>
                </div>
            </div>

            <!-- The product create/edit page -->
            <div class="page products-create-edit">
                <form class="product-form form-group" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title"> Title </label>
                        <input type="text" class="form-control" id="title" placeholder=" Enter product title "
                            class="form-control">

                        <p class="title-error text-danger" style="display: none"></p>
                    </div>

                    <div class="form-group">
                        <label for="description"> Description </label>
                        <input type="text" class="form-control" id="description"
                            placeholder="Enter product description" class="form-control">

                        <p class="description-error text-danger" style="display: none"></p>
                    </div>

                    <div class="form-group">
                        <label for="price"> Price </label>
                        <input type="text" class="form-control" id="price" placeholder="Enter product price"
                            class="form-control">

                        <p class="price-error text-danger" style="display: none"></p>
                    </div>

                    <div>
                        <label for="image"> Image </label>
                        <input type="file" id="image">

                        <p class="image-error text-danger" style="display: none"></p>
                    </div>

                    <input type="hidden" id="product-id" value="">

                    <button type="button" class="product-create btn btn-primary"> Create </button>
                    <button type="button" class="product-update btn btn-warning"> Update </button>
                </form>
            </div>

            <!-- The Orders page -->
            <div class="page orders">
                <!-- The order element where the products list is rendered -->
                <div class="orders-list"></div>
            </div>

            <!-- The Order page -->
            <div class="page order">
                <div class="order-view"></div>

                <!-- The order element where the products list is rendered -->
                <div class="order-list"></div>
            </div>

        </div>
    </body>

</html>