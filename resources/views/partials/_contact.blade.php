<section id="contact" class="contact" style="background-color: #dee2e6;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>CONTACT US</span>
                    <h2>
                        Prêt à démarrer votre projet? <br />
                        Allons-y!
                    </h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-lg-7">
                <div class="row">
                    <div class="col-md-6 col-lg-12">
                        <div class="single-contact-info">
                            <div class="contact-icon">
                                <i class="lni lni-phone"></i>
                            </div>
                            <div class="contact-meta">
                                <h5>Contact</h5>
                                <p>+237 658758598</p>
                                <p><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                        data-cfemail="6e0f0a0307002e0b160f031e020b400d0103">{{ __('infos@techbriva.com') }}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12">
                        <div class="single-contact-info">
                            <div class="contact-icon">
                                <i class="lni lni-phone"></i>
                            </div>
                            <div class="contact-meta">
                                <h5>Address</h5>
                                <p>Yaoundé Simbock</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-5">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="contact-form-wrapper wow fadeInUp" data-wow-delay=".2s">
                    <h3 class="contact-form-title">{{ __('contact.title')}} </h3>
                    <form class="contact-form" method="POST" action="{{ route('contact.us.message') }}">
                        @csrf
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="fullName">Full Name*</label>
                            <input type="text" class="required" name="name" value="{{ old('name') }}"
                                placeholder="Adam Gelius" />

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <i>{{ $errors->first('name') }}</i>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">Email*</label>
                            <input type="email" class="required" name="email" value="{{ old('email') }}"
                                placeholder="example@yourmail.com" />

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <i>{{ $errors->first('email') }}</i>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('subject') ? ' has-error' : '' }}">
                            <label for="subject">Subject*</label>
                            <input type="text" class="required" value="{{ old('subject') }}" name="subject"
                                placeholder="Subject" />
                            @if ($errors->has('subject'))
                                <span class="help-block">
                                    <i>{{ $errors->first('subject') }}</i>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('message') ? ' has-error' : '' }}">
                            <label for="message">Message*</label>
                            <textarea name="message" class="required" rows="1" placeholder="Type your message here">{{ old('message') }} </textarea>
                            @if ($errors->has('message'))
                                <span class="help-block">
                                    <i>{{ $errors->first('message') }}</i>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 m-3">
                            <div class="captcha">
                                <span>{!! captcha_img() !!}</span>
                                <button type="button" class="btn btn-success btn-refresh"><i
                                        class="fa fa-refresh"></i></button>
                            </div>
                            <input id="captcha" type="text" class="form-control required {{ $errors->has('captcha') ? ' has-error' : '' }}""
                                placeholder="Enter Captcha" name="captcha">


                            @if ($errors->has('captcha'))
                                <span class="help-block">
                                    <i>{{ $errors->first('captcha') }}</i>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" id="submit_btn" class="main-btn">{{ __('contact.send')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="map-container">
        <object style="border: 0; height: 450px; width: 100%"
            data="https://maps.google.com/maps?q=carrefour simbock&t=k&z=10&ie=UTF8&iwloc=&output=embed"></object>
    </div>
</section>


@section('front-js')
    <script type="text/javascript">
        $('#submit_btn').click((e) => {
            e.preventDefault();

            

            if (ControlRequiredFields()) {
                $('form').submit();
            }
            return;
        });
    </script>
@endsection
