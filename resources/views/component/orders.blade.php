<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
           <div class="table-responsive">
               <table class="table">
                   <thead>
                   <tr>
                       <th>No</th>
                       <th>Payable</th>
                       <th>Shipping</th>
                       <th>Delivery</th>
                       <th>Payment</th>
                       <th>More</th>
                   </tr>
                   </thead>
                   <tbody id="OrderList">

                   </tbody>
               </table>
           </div>
        </div>
    </div>
</div>

<div class="modal" id="InvoiceProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fs-6" id="exampleModalLabel">Products</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <table class="table">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                    </thead>
                    <tbody id="productList">

                    </tbody>
                </table>



            </div>
        </div>
    </div>
</div>


<script>
    async function OrderListRequest()
    {
        let response = await axios.get("/InvoiceList")
        let jsonData = response.data;

        $("#OrderList").empty()

        if(jsonData.length !==0)
        {
            jsonData.forEach((item, i)=>{
                let rows = `
                    <tr>
                       <td>${item['id']}</td>
                       <td>$ ${item['payable']} </td>
                       <td>${item['ship_details']}</td>
                       <td>${item['delivery_status']}</td>
                       <td>${item['payment_status']}</td>
                       <td><button onclick="InvoiceProductList(${item['id']})" class="btn more btn-danger btn-sm">More</button></td>
                   </tr>
                `
                $("#OrderList").append(rows)
            })
        }
    }

    async function InvoiceProductList(id)
    {
        let response = await axios.get(`/InvoiceProductList/${id}`)
        $("#InvoiceProductModal").modal('show');

        $("#productList").empty();

        response.data.forEach((item, i)=>{
            let rows = `
                <tr>
                    <td>${item['product']['title']}</td>
                    <td>${item['qty']}</td>
                    <td>$ ${item['sale_price']}</td>
                </tr>
            `

            $("#productList").append(rows)
        })

    }
</script>
