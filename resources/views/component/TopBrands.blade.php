<div class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="heading_s4 text-center">
                    <h2>Top Brands</h2>
                </div>
                <p class="text-center leads">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim Nullam nunc varius.</p>
            </div>
        </div>
        <div id="TopBrandItem" class="row align-items-center">


        </div>
    </div>
</div>

<script>
    async function TopBrands()
    {
        let response = await axios.get('/BrandList');
        $("#TopBrandItem").empty()
        response.data['data'].forEach((item, i)=>{
            let eachItem = `
                <div class="col-md-3">
                    <div class="product_slider carousel_slider owl-carousel owl-theme nav_style1" data-loop="true" data-dots="false" data-nav="true" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
                        <div class="item">
                            <div class="product">
                                <div class="product_img text-center">
                                    <a href="/by-brand?id=${item['id']}">
                                        <img src="${item['brandImg']}" alt="product_img1">
                                    </a>
                                </div>
                                <div class="product_info">
                                    <h5 class="product_title text-center"><a href="/by-brand?id=${item['id']}">${item['brandName']}</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `
            $("#TopBrandItem").append(eachItem)
        })

    }
</script>
