<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                <div class="product-image">
                    <div class="product_img_box">
                        <img id="product_img1" class="w-100" src='assets/images/product_img1.jpg' />
                    </div>
                    <div class="row p-2">
                        <a href="#" class="col-3 product_img_box p-1">
                            <img id="img1" src="assets/images/product_small_img3.jpg"/>
                        </a>
                        <a href="#" class="col-3 product_img_box p-1">
                            <img id="img2" src="assets/images/product_small_img3.jpg"/>
                        </a>
                        <a href="#" class="col-3 product_img_box p-1">
                            <img id="img3" src="assets/images/product_small_img3.jpg" alt="product_small_img3" />
                        </a>
                        <a href="#" class="col-3 product_img_box p-1">
                            <img id="img4" src="assets/images/product_small_img3.jpg" alt="product_small_img3" />
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="pr_detail">
                    <div class="product_description">
                        <h4 id="p_title" class="product_title"></h4>
                        <h1 id="p_price"  class="price"></h1>
                    </div>
                    <div>
                        <p id="p_des"></p>
                    </div>
                    </div>


                    <label class="form-label">Size</label>
                    <select id="p_size" class="form-select">
                    </select>

                    <label class="form-label">Color</label>
                    <select id="p_color" class="form-select">

                    </select>

                    <hr />
                    <div class="cart_extra">
                        <div class="cart-product-quantity">
                            <div class="quantity">
                                <input type="button" value="-" class="minus" onclick="decrement()">
                                <input id="p_qty" type="text" name="quantity" value="1" title="Qty" class="qty" size="4">
                                <input type="button" value="+" class="plus" onclick="increment()">
                            </div>
                        </div>
                        <div class="cart_btn">
                            <button onclick="AddToCart()" class="btn btn-fill-out btn-addtocart" type="button"><i class="icon-basket-loaded"></i> Add to cart</button>
                            <a class="add_wishlist" onclick="AddToWishList()" href="#"><i class="icon-heart"></i></a>
                        </div>
                    </div>
                    <hr />
                </div>
            </div>
        </div>
</div>


<script>
    function increment()
    {
        let quantityInput       = document.getElementById('p_qty')
        let quantity            = parseInt(quantityInput.value)
        quantityInput.value     = quantity+1
    }

    function decrement()
    {
        let quantityInput       = document.getElementById('p_qty')
        let quantity            = parseInt(quantityInput.value)

        if(quantity > 1)
        {
            quantityInput.value = quantity-1
        }
    }

    let searchParams = new URLSearchParams(window.location.search);
    let id = searchParams.get('id');

    async function productDetails()
    {
        let response = await axios.get(`/ProductDetailsById/${id}`);
        let details = response.data['data'];

        document.getElementById('product_img1').src = details[0]['img1'];

        document.getElementById('img1').src = details[0]['img1'];
        document.getElementById('img2').src = details[0]['img2'];
        document.getElementById('img3').src = details[0]['img3'];
        document.getElementById('img4').src = details[0]['img4'];

        document.getElementById('p_title').innerText        = details[0]['product']['title'];
        document.getElementById('p_price').innerText        = details[0]['product']['price'];
        document.getElementById('p_des').innerText          = details[0]['product']['short_des'];
        document.getElementById('p_details').innerHTML      = details[0]['des'];

        let size         = details[0]['size'].split(',');
        let color        = details[0]['color'].split(',');

        let sizeOption   = `<option value="">Choose Size</option>`
        $("#p_size").append(sizeOption)
        size.forEach((item)=>{
            let option = `<option value="${item}">${item}</option>`
            $("#p_size").append(option)
        })

        let colorOption = `<option value="">Choose Color<option>`
        $("#p_color").append(colorOption)
        color.forEach((item)=>{
            let option  = `<option value="${item}">${item}<option>`
            $("#p_color").append(option)
        })

        $("#img1").on('click', function(){
            $("#product_img1").attr('src', details[0]['img1'])
        });

        $("#img2").on('click', function(){
            $("#product_img1").attr('src', details[0]['img2'])
        });

        $("#img3").on('click', function(){
            $("#product_img1").attr('src', details[0]['img3'])
        });

        $("#img4").on('click', function(){
            $("#product_img1").attr('src', details[0]['img1'])
        });

    }

    async function AddToCart()
    {
        try
        {
            let p_color = document.getElementById('p_color').value
            let p_size  = document.getElementById('p_size').value
            let p_qty   = document.getElementById('p_qty').value

            if(p_size.length == 0)
            {
                errorToast("Product size required")
            }
            else if(p_color.length == 0)
            {
                errorToast("Product color required")
            }
            else if(p_qty.length == 0)
            {
                errorToast("Product Quantity required")
            }
            else
            {
                // $(".preloader").delay(90).fadeIn(100).removeClass("loaded")
                let response  = await axios.post("/CreateCartList", {
                    "product_id":id,
                    "color":p_color,
                    "size":p_size,
                    "qty":p_qty
                })
                // $(".preloader").delay(90).fadeIn(100).addClass("loaded")

                if(response.status == 200)
                {
                    successToast("Product added to cart successfully")
                }
            }

        }
        catch(exception)
        {
            // if(exception.response.status == 401)
            // {
            //     sessionStorage.setItem("last_location", window.location.href);
            //     window.location.href = "/login"
            // }

            console.error("An error occurred while adding to cart:", exception);
            if (exception.response && exception.response.status == 401) {
                sessionStorage.setItem("last_location", window.location.href);
                window.location.href = "/login";
            }
        }
    }

    async function AddToWishList()
    {
        try
        {
            // $(".preloader").delay(90).fadeIn(100).removeClass('loaded')
            let response = await axios.get(`/CreateWishList/${id}`)
            // $(".preloader").delay(90).fadeIn(100).addClass('loaded')

            if(response.status === 200)
            {
                successToast("Product Added To wishlist")
            }

        }
        catch(exception)
        {
            // if(exception.response.status == 401)
            // {
            //     sessionStorage.setItem("last_location", window.location.href)
            //     window.location.href = "/login"
            // }

            console.error("An error occurred while adding to cart:", exception);
            if (exception.response && exception.response.status == 401) {
                sessionStorage.setItem("last_location", window.location.href);
                window.location.href = "/login";
            }
        }
    }

    async function productReview()
    {
        let response = await axios.get(`/ListReviewByProduct/${id}`);
        let details = response.data['data']

        $("#reviewList").empty()

        details.forEach((item, i)=>{
            let review = `
                <li class="list-group-item">
                    <h6>${item['profile']['cus_name']}</h6>
                    <p class="m-0 p-0">${item['description']}</p>
                    <div class="rating_wrap">
                        <div class="rating">
                            <div class="product_rate" style="width:${parseFloat(item['rating'])}%"></div>
                        </div>
                    </div>
                </li>
            `
            $("#reviewList").append(review)
        })

    }

    async function AddReview()
    {
        let reviewTextID = document.getElementById('reviewTextID').value
        let reviewScore = document.getElementById('reviewScore').value

        if(reviewTextID.length == 0)
        {
            errorToast("Review Is required")
        }
        else if(reviewScore.length == 0)
        {
            errorToast("Score is required")
        }
        else
        {
            let postBody =
            {
                description :   reviewTextID,
                product_id  :   reviewScore,
                rating      :   reviewScore,
            }
            let response = await axios.post("/CreateProductReview", postBody)

            if(response.status  == 200)
            {
                productReview()
                successToast("Review added successfully")
            }
            else
            {
                errorToast("Something went wrong")
            }
        }
    }

</script>

