<form id="aff-reg-from" autocomplete="off" method="POST" action="/affiliate/reg-applications">
    @csrf
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="aff-name" class="control-label">Name<span class="text-danger">*</span></label>
                <input
                    id="aff-name"
                    name="name"
                    type="text"
                    class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}"
                    value="{{old('name')}}"
                    required
                />
                <div class="invalid-feedback">{{$errors->first('name')}}</div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label for="aff-email" class="control-label">Email<span class="text-danger">*</span></label>
                <input
                    id="aff-email"
                    name="email"
                    type="email"
                    class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}"
                    value="{{old('email')}}"
                    required
                />
                <div class="invalid-feedback">{{$errors->first('email')}}</div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="aff-text" class="control-label">
            Why do you think you'll be successful promoting Trademark Factory® services?
            <span class="text-danger">*</span>
        </label>
        <textarea
            id="aff-text"
            name="text"
            class="form-control {{$errors->has('text') ? 'is-invalid' : ''}}"
            required
        >{{old('text')}}</textarea>
        <div class="invalid-feedback">{{$errors->first('text')}}</div>
    </div>

    <div class="form-group">
        <div class="custom-control custom-checkbox">
            <input type='hidden' value='off' name='is_tmf_customer'>
            <input
                name="is_tmf_customer"
                type="checkbox"
                class="custom-control-input {{$errors->has('is_tmf_customer') ? 'is-invalid' : ''}}"
                id="aff-is-tmf-customer"
                {{old('is_tmf_customer') == 'on' ? 'checked' : ''}}
            />
            <label class="custom-control-label" for="aff-is-tmf-customer">
                I have purchased Trademark Factory® services myself before
            </label>
            <div class="invalid-feedback">{{$errors->first('is_tmf_customer')}}</div>
        </div>
    </div>

    <div class="form-group">
        <div class="custom-control custom-checkbox">
            <input id="aff-accept-agreement" type="checkbox" class="custom-control-input" required/>
            <label for="aff-accept-agreement" class="custom-control-label">
                YES, I have read, understood, and agree with the
                <a href="#terms">terms of Trademark Factory® Affiliate Program</a>
            </label>
        </div>
    </div>

    <div class="text-center">
        <button class="btn btn-success text-uppercase" type="submit">I WANT TO JOIN</button>
    </div>
</form>
