<div class="modal fade" id="supcription_app" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">App de Gestion de stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" id="registerForm">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 mb-2">
                            <div class="form-group">
                                <label for="app_name">{{ __('home.subscription.app-name') }} <em>*</em></label>
                                <input type="text" class="form-control form-control-border border-width-2 required"
                                    name="name" id="app_name">
                            </div>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <div class="form-group">
                                <label for="app_phone">{{ __('home.subscription.app-phone') }} <em>*</em></label>
                                <input type="text" class="form-control form-control-border border-width-2 required"
                                    name="phone" id="app_phone">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-2">
                            <div class="form-group">
                                <label for="app_email">{{ __('home.subscription.app-email') }}</label>
                                <input type="email" class="form-control form-control-border border-width-2 required"
                                    name="email" id="app_email">
                            </div>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <div class="form-group">
                                <label for="app_address">{{ __('home.subscription.app-address') }}</label>
                                <input type="text" class="form-control form-control-border border-width-2"
                                    name="address" id="app_address">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mb-2">
                            <div class="form-group">
                                <label for="app_domain">{{ __('home.subscription.app-domain') }} <em>*</em></label>
                                <textarea type="text" name="activity" class="form-control form-control-border border-width-2 required" name="domain"
                                    id="app_domain"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2">
                            <div class="form-group">
                                <label for="app_logo">{{ __('home.subscription.app-logo') }}</label>
                                <input type="file" class="form-control form-control-border border-width-2"
                                    name="logo" id="app_logo">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 m-3">
                            <div class="captcha">
                                <span>{!! captcha_img() !!}</span>
                                <button type="button" class="btn btn-success btn-refresh"><i
                                        class="fa fa-refresh"></i></button>
                            </div>
                            <input id="captcha" type="text"
                                class="form-control required {{ $errors->has('captcha') ? ' has-error' : '' }}"
                                placeholder="Enter Captcha" name="captcha">
    
    
                            @if ($errors->has('captcha'))
                                <span class="help-block">
                                    <i>{{ $errors->first('captcha') }}</i>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <button type="button" id="btnSubmit" class="btn btn-primary btn-sm">Enregister</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>

