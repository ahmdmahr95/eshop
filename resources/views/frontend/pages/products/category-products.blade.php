@extends('frontend.layouts.master')

@section('content')

  <!-- Quick View Modal Area -->
  <div class="modal fade" id="quickview" tabindex="-1" role="dialog" aria-labelledby="quickview" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <div class="quickview_body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-5">
                                <div class="quickview_pro_img">
                                    <img class="first_img" src="img/product-img/new-1-back.png" alt="">
                                    <img class="hover_img" src="img/product-img/new-1.png" alt="">
                                    <!-- Product Badge -->
                                    <div class="product_badge">
                                        <span class="badge-new">New</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-7">
                                <div class="quickview_pro_des">
                                    <h4 class="title">Boutique Silk Dress</h4>
                                    <div class="top_seller_product_rating mb-15">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </div>
                                    <h5 class="price">$120.99 <span>$130</span></h5>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia expedita quibusdam aspernatur, sapiente consectetur accusantium perspiciatis praesentium eligendi, in fugiat?</p>
                                    <a href="#">View Full Product Details</a>
                                </div>
                                <!-- Add to Cart Form -->
                                <form class="cart" method="post">
                                    <div class="quantity">
                                        <input type="number" class="qty-text" id="qty" step="1" min="1" max="12" name="quantity" value="1">
                                    </div>
                                    <button type="submit" name="addtocart" value="5" class="cart-submit">Add to cart</button>
                                    <!-- Wishlist -->
                                    <div class="modal_pro_wishlist">
                                        <a href="wishlist.html"><i class="icofont-heart"></i></a>
                                    </div>
                                    <!-- Compare -->
                                    <div class="modal_pro_compare">
                                        <a href="compare.html"><i class="icofont-exchange"></i></a>
                                    </div>
                                </form>
                                <!-- Share -->
                                <div class="share_wf mt-30">
                                    <p>Share with friends</p>
                                    <div class="_icon">
                                        <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Quick View Modal Area -->

<!-- Breadcumb Area -->
<div class="breadcumb_area">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <h5>Shop Grid</h5>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">{{$category->title}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Breadcumb Area -->

<section class="shop_grid_area section_padding_100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Shop Top Sidebar -->
                <div class="shop_top_sidebar_area d-flex flex-wrap align-items-center justify-content-between">
                    <div class="view_area d-flex">
                        <div class="grid_view">
                            <a href="shop-grid-left-sidebar.html" data-toggle="tooltip" data-placement="top" title="Grid View"><i class="icofont-layout"></i></a>
                        </div>
                        <div class="list_view ml-3">
                            <a href="shop-list-left-sidebar.html" data-toggle="tooltip" data-placement="top" title="List View"><i class="icofont-listine-dots"></i></a>
                        </div>
                    </div>
                    <select id="sortBy" name="sortBy" class="small right">
                        <option>Default</option>
                        <option value="priceAsc" {{old('sortBy') == "priceAsc"?'selected':''}}>Price - Lower to Higher</option>
                        <option value="priceDesc" {{ old('sortBy') == 'priceDesc' ? 'selected' : '' }}>Price - Higher to Lower</option>
                        <option value="titleAsc" {{ old('sortBy') == 'titleAsc' ? 'selected' : '' }}>Alphabetical Ascending</option>
                        <option value="titleDesc" {{ old('sortBy') == 'titleDesc' ? 'selected' : '' }}>Alphabetical Descending</option>
                        <option value="discAsc" {{ old('sortBy') == 'discAsc' ? 'selected' : '' }}>Discount - Lower to Higher</option>
                        <option value="discDesc" {{ old('sortBy') == 'discDesc' ? 'selected' : '' }}>Discount - Higher to Lower</option>
                    </select>
                </div>

                <div class="shop_grid_product_area">
                    <div class="row justify-content-center" id="products-data">
                        @foreach ($products as $item)
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                             @include('frontend.pages.products.products-list',['item'=>$item])
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="ajax-loader text-center" style="display: none">
                    <img src="{{asset('frontend/img/loader.gif')}}" alt="loader image" style="width: 6%;">
                </div>

                <div class="shop_pagination_area mt-30">
                    <nav aria-label="Page navigation">
                        {{ $products->links() }} 
                    </nav>
                </div>

                
            </div>
        </div>
    </div>
</section>

@endsection



@section('scripts')

<script>
    // Handle sorting
    $('#sortBy').change(function() {
        var sort = $('#sortBy').val();
        var current_url = "{{ url()->current() }}";
        var new_url = sort === 'Default' ? current_url : `${current_url}?sortBy=${sort}`;
        window.location.href = new_url; // Redirect to the new URL
    });
</script>
{{-- <script>
    var current_url = "{{ url()->current() }}";
    var canLoadMore = true;
    function loadmoreData(page) {
        console.log(current_url + '?page=' + page);
        $.ajax({
            url: current_url + '?page=' + page,
            type: 'GET',
            beforeSend: function() {
                $('.ajax-loader').show();
            }
        })
        .done(function(data) {
            if (data.html == '') {
                $('.ajax-loader').html('No more products available');
                canLoadMore = false;
                return; 
            }
            $('.ajax-loader').hide(); 
            $('#products-data').append(data.html); 
        })
        .fail(function() {
            alert('Something went wrong! Please try again.'); 
        });
    }

    var page = 1; 
    $(window).scroll(function() {
        // Check if user has scrolled to the bottom of the page
        if (canLoadMore && $(window).scrollTop() + $(window).height() + 120 >= $(document).height()) {
            page++; 
            loadmoreData(page); 
        }
    });
</script> --}}

{{-- Add To Cart --}}
<script>
    $(document).on('click','.add-to-cart',function(e){
        e.preventDefault();
        var product_id = $(this).data('product-id');
        var product_qty = $(this).data('quantity');

        // alert(product_qty);

        var token = "{{csrf_token()}}";
        var path = "{{route('user.cart.store')}}";

        $.ajax({
            url:path,
            type:"POST",
            data:{
                '_token':token,
                'product_id':product_id,
                'product_qty':product_qty
            },
            beforeSend:function(){
                $('#add-to-cart'+product_id).html('<i class="fa fa-spinner fa-spin"></i> loading...');
            },
            complete:function(){
                $('#add-to-cart'+product_id).html('<i class="fa fa-cart-plus"></i> Add to cart');
            },
            success:function(data){
                // console.log(data);
                if(data['status']){
                    $('body #header-ajax').html(data['header']);
                    $('body #cart_counter').html(data['cart_count']);
                    swal({
                    title: "Good job!",
                    text: data['message'],
                    icon: "success",
                    button: "Ok!",
                    });
                }
            },
            error:function(err){
                console.log(err);
            }
        });
    });
</script>

{{-- Add To Wishlist --}}
<script>
    $(document).on('click','.add-to-wishlist',function(e){
        e.preventDefault();
        var product_id = $(this).data('id');
        var product_qty = $(this).data('quantity');

        // alert(product_qty);

        var token = "{{csrf_token()}}";
        var path = "{{route('user.wishlist.store')}}";

        $.ajax({
            url:path,
            type:"POST",
            data:{
                '_token':token,
                'product_id':product_id,
                'product_qty':product_qty
            },
            beforeSend:function(){
                $('#add-to-wishlist-'+product_id).html('<i class="fa fa-spinner fa-spin"></i>');
            },
            complete:function(){
                $('#add-to-wishlist-'+product_id).html('<i class="fas fa-heart"></i> Add to cart');
            },
            success:function(data){
                // console.log(data);
                if(data['status']){
                    $('body #header-ajax').html(data['header']);
                    $('body #wishlist_counter').html(data['wishlist_count']);
                    swal({
                    title: "Good job!",
                    text: data['message'],
                    icon: "success",
                    button: "Ok!",
                    });
                }
                else if(data['exists']){
                    $('body #header-ajax').html(data['header']);
                    $('body #wishlist_counter').html(data['wishlist_count']);
                    swal({
                    title: "Good job!",
                    text: data['message'],
                    icon: "warning",
                    button: "Ok!",
                    });
                }
                else{
                    swal({
                    title: "Sorry!",
                    text: "You can't add that product",
                    icon: "error",
                    button: "Ok!",
                    });
                }
            },
            error:function(err){
                console.log(err);
            }
        });
    });
</script>
@endsection