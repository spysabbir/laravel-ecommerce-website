@extends('frontend.layouts.frontend_master')

@section('title_bar')
Wishlist
@endsection

@section('body_content')
<!-- page-banner-area-start -->
<div class="page-banner-area page-banner-height-2" data-background="{{asset('frontend')}}/img/banner.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-banner-content text-center">
                    <h4 class="breadcrumb-title">Wishlist</h4>
                    <div class="breadcrumb-two">
                        <nav>
                            <nav class="breadcrumb-trail breadcrumbs">
                                <ul class="breadcrumb-menu">
                                    <li class="breadcrumb-trail">
                                        <a href="{{route('index')}}"><span>Home</span></a>
                                    </li>
                                    <li class="trail-item">
                                        <span>Wishlist</span>
                                    </li>
                                </ul>
                            </nav>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- page-banner-area-end -->

<!-- cart-area-start -->
<section class="cart-area pb-120 pt-120">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="#">
                    <div class="table-content table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">Images</th>
                                    <th class="cart-product-name">Product</th>
                                    <th class="product-price">Unit Price</th>
                                    <th class="product-quantity">Stock</th>
                                    <th class="product-remove">Action</th>
                                </tr>
                            </thead>
                            <tbody id="all_wishlist_data">

                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- cart-area-end -->
@endsection

@section('custom_script')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Read Data
        fetchAllWishlist();
        function fetchAllWishlist() {
            $.ajax({
                url: '{{ route('fetch.wishlist') }}',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    $('#all_wishlist_data').html(response.wishlists);
                }
            });
        }

        // Force Delete
        $(document).on('click', '.deleteWishlistBtn', function (e) {
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('wishlist.forcedelete', ":id") }}";
            url = url.replace(':id', id)

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
                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function (response) {
                            $('#header_wishlist_num').html(response.header_wishlist_num);
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-center',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter',
                                        Swal.stopTimer)
                                    toast.addEventListener('mouseleave',
                                        Swal.resumeTimer)
                                }
                            })
                            Toast.fire({
                                icon: 'warning',
                                title: 'Wishlist force delete successfully'
                            })
                            fetchAllWishlist();
                        }
                    });
                }
            })
        })

    });
</script>
@endsection
