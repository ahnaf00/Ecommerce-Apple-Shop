<div class="login_register_wrap section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-10">
                <div class="login_wrap">
                    <div class="padding_eight_all bg-white">
                        <div class="heading_s1">
                            <h3>Login</h3>
                        </div>
                            <div class="form-group mb-3">
                                <input id="email" type="text" required="" class="form-control" name="email" placeholder="Your Email">
                            </div>
                            <div class="form-group mb-3">
                                <button onclick="Login()" type="submit" class="btn btn-fill-out btn-block" name="login">Next</button>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function Login()
    {
        let email = document.getElementById('email').value

        if(email.length == 0)
        {
            errorToast("Email required")
        }
        else
        {
            $(".preloader").delay(90).fadeIn(100).removeClass("loaded")
            let response = await axios.get(`/UserLogin/${email}`)
            if(response.status == 200)
            {
                sessionStorage.setItem('email', email);
                window.location.href = "/verify"
            }
            else
            {
                $(".preloader").delay(90).fadeIn(100).addClass("loaded")
                errorToast("Something went wrong")
            }
        }
    }
</script>
