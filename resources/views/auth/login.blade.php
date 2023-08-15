<!DOCTYPE html>
<html lang="en">
<head>
    <base href="../../../">
    <meta charset="utf-8"/>
    <title>
        Login Page | Ticket Hub</title>
    <meta name="description" content="Login page example"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="canonical" href="https://keenthemes.com/metronic"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    <link href="{{asset('admin/assets/css/pages/login/login-2.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin/assets/plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="shortcut icon" href="{{asset('admin/assets/media/logos/LOGO4.png')}}">
</head>
<body id="kt_body"
      class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
<div class="d-flex flex-column flex-root">
    <div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <!--begin::Aside-->
        <div class="login-aside order-2 order-lg-1 d-flex flex-row-auto position-relative overflow-hidden">
            <!--begin: Aside Container-->
            <div class="d-flex flex-column-fluid flex-column justify-content-between py-9 px-7 py-lg-13 px-lg-35">
                <!--begin::Logo-->
            {{--                <a href="#" class="text-center pt-2">--}}
            {{--                    <img src="assets/media/logos/logo.png" class="max-h-75px" alt="" />--}}
            {{--                </a>--}}
            <!--end::Logo-->
                <!--begin::Aside body-->
                <div class="d-flex flex-column-fluid flex-column flex-center">
                    <!--begin::Signin-->
                    <div class="login-form login-signin py-11">
                        <!--begin::Form-->
                        <form method="POST" action="{{ route('login') }}" class="form">
                        @csrf
                        <!--begin::Title-->
                            <div class="text-center pb-8">
                                <h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Sign In</h2>
                                <span class="text-muted font-weight-bold font-size-h4">Or
                                <a href="" class="text-primary font-weight-bolder" id="create-account-link">Create An Account</a></span>
                            </div>
                            <!--end::Title-->
                            <!--begin::Form group-->
                            <div class="form-group">
                                <label for="email" class="font-size-h6 font-weight-bolder text-dark">Email</label>
                                <input
                                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }} form-control-solid h-auto py-7 px-6 rounded-lg"
                                    type="text"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus/>
                                @if($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                            <!--end::Form group-->
                            <!--begin::Form group-->
                            <div class="form-group">
                                <div class="d-flex justify-content-between mt-n5">
                                    <label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
                                    <a href="javascript:;"
                                       class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5"
                                       id="kt_login_forgot">Forgot Password ?</a>
                                </div>
                                <input
                                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }} form-control-solid h-auto py-7 px-6 rounded-lg"
                                    type="password" name="password" required autocomplete="current-password"/>
                                @if($errors->has('password'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif
                            </div>
                            <!--end::Form group-->
                            <!--begin::Action-->
                            <div class="text-center pt-2">
                                <button type="submit" id="kt_login_signin_submit"
                                        class="btn btn-dark font-weight-bolder font-size-h6 px-8 py-4 my-3">Sign In
                                </button>
                            </div>
                            <!--end::Action-->
                        </form>
                        <!--end::Form-->
                        {{--                        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form"--}}
                        {{--                              action="{{ route('login') }}" method="POST">--}}
                        {{--                            @csrf--}}
                        {{--                            <!--begin::Heading-->--}}
                        {{--                            <div class="text-center mb-10">--}}
                        {{--                                <!--begin::Title-->--}}
                        {{--                                <h1 class="text-dark mb-3">{{ __('main.login') }}</h1>--}}
                        {{--                                <!--end::Title-->--}}
                        {{--                            </div>--}}
                        {{--                            <!--begin::Heading-->--}}
                        {{--                            <!--begin::Input group-->--}}
                        {{--                            <div class="fv-row mb-10">--}}
                        {{--                                <!--begin::Label-->--}}
                        {{--                                <label for="email" class="form-label fs-6 fw-bolder text-dark">{{ __('main.email') }}</label>--}}
                        {{--                                <!--end::Label-->--}}
                        {{--                                <!--begin::Input-->--}}
                        {{--                                <input--}}
                        {{--                                    class="form-control @error('email') is-invalid @enderror form-control-lg form-control-solid"--}}
                        {{--                                    style="text-align:--}}
                        {{--                            @if(app()->getLocale() == "ar")right @else left @endif"--}}
                        {{--                                    id="email" type="email" name="email" autocomplete="email" value="{{ old('email')}}" required--}}
                        {{--                                    autofocus/>--}}
                        {{--                                <!--end::Input-->--}}
                        {{--                                @error('email')--}}
                        {{--                                <span class="invalid-feedback" role="alert">--}}
                        {{--                            <strong>{{ $message }}</strong>--}}
                        {{--                            </span>--}}
                        {{--                                @enderror--}}
                        {{--                            </div>--}}
                        {{--                            <!--end::Input group-->--}}
                        {{--                            <!--begin::Input group-->--}}
                        {{--                            <div class="fv-row mb-3">--}}
                        {{--                                <label for="password"--}}
                        {{--                                       class="form-label fw-bolder text-dark fs-6 mb-0">{{ __('main.password') }}</label>--}}
                        {{--                                <input--}}
                        {{--                                    class="form-control @error('password') is-invalid @enderror form-control-lg form-control-solid"--}}
                        {{--                                    id="password" name="password" type="password"--}}
                        {{--                                    required autocomplete="current-password"/>--}}
                        {{--                                @error('password')--}}
                        {{--                                <span class="invalid-feedback" role="alert">--}}
                        {{--                            <strong>{{ $message }}</strong>--}}
                        {{--                            </span>--}}
                        {{--                                @enderror--}}
                        {{--                                <!--end::Input-->--}}
                        {{--                            </div>--}}
                        {{--                            <div class="fv-row mb-8">--}}
                        {{--                                <div class="form-check">--}}
                        {{--                                    <input class="form-check-input" type="checkbox" name="remember"--}}
                        {{--                                           id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

                        {{--                                    <label class="form-check-label" for="remember">--}}
                        {{--                                        {{ __('Remember Me') }}--}}
                        {{--                                    </label>--}}

                        {{--                                </div>--}}
                        {{--                            </div>--}}

                        {{--                            <!--end::Input group-->--}}

                        {{--                            <div class="fv-row mb-0">--}}
                        {{--                                <button type="submit" class="btn btn-primary">--}}
                        {{--                                    {{ __('Login') }}--}}
                        {{--                                </button>--}}
                        {{--                                @if (Route::has('password.request'))--}}
                        {{--                                    <a class="btn btn-link" href="{{ route('password.request') }}">--}}
                        {{--                                        {{ __('Forgot Your Password?') }}--}}
                        {{--                                    </a>--}}
                        {{--                                @endif--}}
                        {{--                            </div>--}}


                        {{--                            <!--end::Actions-->--}}
                        {{--                        </form>--}}

                    </div>
                    <!--end::Signin-->
                    <!--begin::Signup-->
                    <div class="login-form login-signup pt-11">
                        <!--begin::Form-->
                        <form class="form" novalidate="novalidate" id="kt_login_signup_form">
                            <!--begin::Title-->
                            <div class="text-center pb-8">
                                <h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Sign Up</h2>
                                <p class="text-muted font-weight-bold font-size-h4">Enter your details to create your
                                    account</p>
                            </div>
                            <!--end::Title-->
                            <!--begin::Form group-->
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6"
                                       type="text" placeholder="Fullname" name="fullname" autocomplete="off"/>
                            </div>
                            <!--end::Form group-->
                            <!--begin::Form group-->
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6"
                                       type="email" placeholder="Email" name="email" autocomplete="off"/>
                            </div>
                            <!--end::Form group-->
                            <!--begin::Form group-->
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6"
                                       type="password" placeholder="Password" name="password" autocomplete="off"/>
                            </div>
                            <!--end::Form group-->
                            <!--begin::Form group-->
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6"
                                       type="password" placeholder="Confirm password" name="cpassword"
                                       autocomplete="off"/>
                            </div>
                            <!--end::Form group-->
                            <!--begin::Form group-->
                            <div class="form-group">
                                <label class="checkbox mb-0">
                                    <input type="checkbox" name="agree"/>I Agree the
                                    <a href="#">terms and conditions</a>.
                                    <span></span></label>
                            </div>
                            <!--end::Form group-->
                            <!--begin::Form group-->
                            <div class="form-group d-flex flex-wrap flex-center pb-lg-0 pb-3">
                                <button type="button" id="kt_login_signup_submit"
                                        class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">
                                    Submit
                                </button>
                                <button type="button" id="back-to-login-link"
                                        class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">
                                    Cancel
                                </button>
                            </div>
                            <!--end::Form group-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Signup-->
                    <!--begin::Forgot-->
                    <div class="login-form login-forgot pt-11">
                        <!--begin::Form-->
                        <form class="form" novalidate="novalidate" id="kt_login_forgot_form">
                            <!--begin::Title-->
                            <div class="text-center pb-8">
                                <h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Forgotten Password
                                    ?</h2>
                                <p class="text-muted font-weight-bold font-size-h4">Enter your email to reset your
                                    password</p>
                            </div>
                            <!--end::Title-->
                            <!--begin::Form group-->
                            <div class="form-group">
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6"
                                       type="email" placeholder="Email" name="email" autocomplete="off"/>
                            </div>
                            <!--end::Form group-->
                            <!--begin::Form group-->
                            <div class="form-group d-flex flex-wrap flex-center pb-lg-0 pb-3">
                                <button type="button" id="kt_login_forgot_submit"
                                        class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">
                                    Submit
                                </button>
                                <button type="button" id="kt_login_forgot_cancel"
                                        class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">
                                    Cancel
                                </button>
                            </div>
                            <!--end::Form group-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Forgot-->
                </div>
                <!--end::Aside body-->
                <!--begin: Aside footer for desktop-->
                <div class="text-center">
                    <button type="button" class="btn btn-light-primary font-weight-bolder px-8 py-4 my-3 font-size-h6">
							<span class="svg-icon svg-icon-md">
								<!--begin::Svg Icon | path:assets/media/svg/social-icons/google.svg-->
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                     fill="none">
									<path
                                        d="M19.9895 10.1871C19.9895 9.36767 19.9214 8.76973 19.7742 8.14966H10.1992V11.848H15.8195C15.7062 12.7671 15.0943 14.1512 13.7346 15.0813L13.7155 15.2051L16.7429 17.4969L16.9527 17.5174C18.879 15.7789 19.9895 13.221 19.9895 10.1871Z"
                                        fill="#4285F4"/>
									<path
                                        d="M10.1993 19.9313C12.9527 19.9313 15.2643 19.0454 16.9527 17.5174L13.7346 15.0813C12.8734 15.6682 11.7176 16.0779 10.1993 16.0779C7.50243 16.0779 5.21352 14.3395 4.39759 11.9366L4.27799 11.9466L1.13003 14.3273L1.08887 14.4391C2.76588 17.6945 6.21061 19.9313 10.1993 19.9313Z"
                                        fill="#34A853"/>
									<path
                                        d="M4.39748 11.9366C4.18219 11.3166 4.05759 10.6521 4.05759 9.96565C4.05759 9.27909 4.18219 8.61473 4.38615 7.99466L4.38045 7.8626L1.19304 5.44366L1.08875 5.49214C0.397576 6.84305 0.000976562 8.36008 0.000976562 9.96565C0.000976562 11.5712 0.397576 13.0882 1.08875 14.4391L4.39748 11.9366Z"
                                        fill="#FBBC05"/>
									<path
                                        d="M10.1993 3.85336C12.1142 3.85336 13.406 4.66168 14.1425 5.33717L17.0207 2.59107C15.253 0.985496 12.9527 0 10.1993 0C6.2106 0 2.76588 2.23672 1.08887 5.49214L4.38626 7.99466C5.21352 5.59183 7.50242 3.85336 10.1993 3.85336Z"
                                        fill="#EB4335"/>
								</svg>
                                <!--end::Svg Icon-->
							</span>Sign in with Google
                    </button>
                </div>
                <!--end: Aside footer for desktop-->
            </div>
            <!--end: Aside Container-->
        </div>
        <!--begin::Aside-->
        <!--begin::Content-->
        <div class="content order-1 order-lg-2 d-flex flex-column w-100 pb-0" style="background-color: #B1DCED;">
            <!--begin::Title-->
            <div
                class="d-flex flex-column justify-content-center text-center pt-lg-40 pt-md-5 pt-sm-5 px-lg-0 pt-5 px-7">
                <h3 class="display4 font-weight-bolder my-7 text-dark" style="color: #986923;">Amazing Ticketing
                    Hub</h3>
                <p class="font-weight-bolder font-size-h2-md font-size-lg text-dark opacity-70">User Experience &amp;
                    Interface Design, Product Strategy
                    <br/>Web Application SaaS Solutions</p>
            </div>
            <!--end::Title-->
            <!--begin::Image-->
            <div class="content-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center"
                 style="background-image: url({{asset('admin/assets/media/svg/illustrations/login-visual-2.png')}});
                     margin-top: -180px">
            </div>
            <!--end::Content-->
        </div>
        <!--end::Login-->
    </div>
</div>
<!--end::Main-->
<script>document.getElementById("create-account-link").addEventListener("click", function (event) {
        event.preventDefault();
        document.getElementById("login-form").style.display = "none";
        document.getElementById("signup-form").style.display = "block";
    });

    document.getElementById("back-to-login-link").addEventListener("click", function (event) {
        event.preventDefault();
        document.getElementById("login-form").style.display = "block";
        document.getElementById("signup-form").style.display = "none";
    });
</script>
<script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
<script src="{{asset('admin/assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('admin/assets/plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
<script src="{{asset('admin/assets/js/scripts.bundle.js')}}"></script>
<script src="{{asset('admin/assets/js/pages/custom/login/login-general.js')}}"></script>

</body>
</html>
