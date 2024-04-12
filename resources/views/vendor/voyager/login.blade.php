<!DOCTYPE html>
    <html dir="ltr" lang="fr">
        <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="robots" content="none" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="admin login">
        <title>@yield('title', 'Admin - '.Voyager::setting("admin.title"))</title>
            <!-- Stylesheets
            ============================================= -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        @if (__('voyager::generic.is_rtl') == 'true')
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.css">
            <link rel="stylesheet" href="{{ voyager_asset('css/rtl.css') }}">
        @endif
        <style>
            .divcenter {
                position: relative !important;
                float: none !important;
                margin-left: auto !important;
                margin-right: auto !important;
                vertical-align: middle !important;
                top: 10vh;
            }

            .center {
                text-align: center !important;
            }
        </style>

        @yield('pre_css')
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
        </head>
        <body class="stretched">
            <div id="wrapper" class="clearfix">
                <section id="content">
                    <div class="content-wrap nopadding">
                        <?php $admin_bg_image = Voyager::setting("admin.bg_image", ''); ?>
                        @if($admin_bg_image == '')
                            <div class="section nopadding nomargin" style="width: 100%; height: 100%; position: absolute; left: 0; top: 0;
                        background: url('{{asset('login-assets/bg.png')}}') center center no-repeat; background-size: cover;"></div>
                        @else
                            <div class="section nopadding nomargin" style="width: 100%; height: 100%; position: absolute; left: 0; top: 0;
                        background: url('{{asset('storage/'.$admin_bg_image)}}') center center no-repeat; background-size: cover;"></div>
                        @endif
                        <div class="section nobg full-screen nopadding nomargin">
                            <div class="container-fluid vertical-middle divcenter clearfix">
                                <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
                                <div class="card divcenter noradius noborder" style="max-width: 400px; background-color: rgba(255,255,255,0.93);">
                                    <div class="card-header" style="padding: 0px; max-height: 100px;">

                                        @if(trim($admin_logo_img) == '')
                                            <img class="img-responsive pull-left flip logo hidden-xs animated fadeIn" src="{{ asset('login-assets/vz-logo.png') }}" alt="{{env('APP_SUPPORT_NAME', 'VZ Technology')}}" style="max-height: 100px;">
                                        @else
                                            <img class="img-responsive pull-left flip logo hidden-xs animated fadeIn" src="{{asset('storage/'.setting('admin.icon_image')) }}" alt="{{env('APP_SUPPORT_NAME', 'VZ Technology')}}" style="max-height: 100px;">
                                        @endif
                                    </div>
                                    <div class="card-body" style="padding: 40px;">

                                        <div class="login-container">


                                            <form action="{{ route('voyager.login') }}" method="POST">
                                                {{ csrf_field() }}
                                                <div class="form-group form-group-default" id="emailGroup">
                                                    <label>{{ __('voyager::generic.email') }}</label>
                                                    <div class="controls">
                                                        <input type="text" name="email" id="email" value="{{ old('email') }}" placeholder="{{ __('voyager::generic.email') }}" class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="form-group form-group-default" id="passwordGroup">
                                                    <label>{{ __('voyager::generic.password') }}</label>
                                                    <div class="controls">
                                                        <input type="password" name="password" placeholder="{{ __('voyager::generic.password') }}" class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="form-group" id="rememberMeGroup">
                                                    <div class="controls">
                                                        <input type="checkbox" name="remember" id="remember" value="1"><label for="remember" class="remember-me-text">{{ __('voyager::generic.remember_me') }}</label>
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn-primary btn-block login-button">
                                                    <span class="signin">{{ __('voyager::generic.login') }}</span>
                                                </button>

                                            </form>

                                            <div style="clear:both"></div>

                                            @if(!$errors->isEmpty())
                                                <div class="alert alert-red">
                                                    <ul class="list-unstyled">
                                                        @foreach($errors->all() as $err)
                                                            <li>{{ $err }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                        </div> <!-- .login-container -->

                                        <div class="line line-sm"></div>

                                    </div>
                                    <div class="card-Footer" style="padding: 0px; max-height: 100px;">
                                        <div class="center dark"><small>Copyrights &copy; All Rights Reserved by <a href="{{Voyager::setting('admin.support_url', 'https://www.vzsite.com')}}">{{Voyager::setting('admin.support_name', 'VZ Technology')}}</a>.</small></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section><!-- #content end -->
            </div><!-- #wrapper end -->
        </body>
    </html>