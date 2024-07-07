<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1>Wish List</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">This Page</a></li>
                </ol>
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>



<div class="mt-5">
    <div class="container my-5">
        <div id="byList" class="row">
        </div>
    </div>
</div>


<script>

    async function WishList()
    {
        let response = await axios.get('/ProductWishList');
        $("#byList").empty();

        response.data['data'].forEach((item, i)=>{
            let eachItem = `
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="product">
                            <div class="product_img">
                                <a href="#">
                                    <img src="${item['product']['image']}" alt="product_img9">
                                </a>
                                <div class="product_action_box">
                                    <ul class="list_none pr_action_btn">
                                        <li><a href="/details?id=${item['product']['id']}" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>

                                        <li><a href="#" class="popup-ajax" onclick="removeWish(${item['product']['id']})" ><i class="icon-trash"></i></a></li>

                                    </ul>
                                </div>
                            </div>
                            <div class="product_info">
                                <h6 class="product_title"><a href="/details?id=${item['product']['id']}">${item['product']['title']}</a></h6>
                                <div class="product_price">
                                    <span class="price">$ ${item['product']['price']}</span>
                                </div>
                                <div class="rating_wrap">
                                    <div class="rating">
                                        <div class="product_rate" style="width:${item['product']['star']}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            `
            $("#byList").append(eachItem);
        })
    }

    async function removeWish(id)
    {
        let response = await axios.get(`/RemoveWishList/${id}`);

        if(response.status  == 200)
        {
            await WishList();
            successToast("Product removed from the wishlist")
        }
        else
        {
            errorToast("Something went wrong")
        }
    }
</script>
