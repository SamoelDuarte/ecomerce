<!-- Create Gallery Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Add Admin') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="ajaxForm" class="" action="{{ route('admin.user.store') }}" method="POST">
          @csrf

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="image"><strong>{{ __('Image') }} <span class="text-danger">**</span></strong></label>
                <div class="col-md-12 showImage mb-3 pl-0 pr-0">
                  <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="..." class="img-thumbnail">
                </div>

                <div role="button" class="btn btn-primary btn-sm upload-btn" id="image">
                  {{ __('Choose Image') }}
                  <input type="file" class="img-input" name="image">
                </div>

                <p id="errimage" class="mb-0 text-danger em"></p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">{{ __('Username') }} <span class="text-danger">**</span></label>
                <input type="text" class="form-control" name="username" placeholder="{{ __('Enter username') }}"
                  value="">
                <p id="errusername" class="mb-0 text-danger em"></p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">{{ __('Email') }} <span class="text-danger">**</span></label>
                <input type="text" class="form-control" name="email" placeholder="{{ __('Enter email') }}"
                  value="">
                <p id="erremail" class="mb-0 text-danger em"></p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">{{ __('First Name') }} <span class="text-danger">**</span></label>
                <input type="text" class="form-control" name="first_name" placeholder="{{ __('Enter first name') }}"
                  value="">
                <p id="errfirst_name" class="mb-0 text-danger em"></p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">{{ __('Last Name') }} <span class="text-danger">**</span></label>
                <input type="text" class="form-control" name="last_name" placeholder="{{ __('Enter last name') }}"
                  value="">
                <p id="errlast_name" class="mb-0 text-danger em"></p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">{{ __('Password') }} <span class="text-danger">**</span></label>
                <input type="password" class="form-control" name="password" placeholder="{{ __('Enter password') }}"
                  value="">
                <p id="errpassword" class="mb-0 text-danger em"></p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">{{ __('Re-type Password') }} <span class="text-danger">**</span></label>
                <input type="password" class="form-control" name="password_confirmation"
                  placeholder="{{ __('Enter your password again') }}" value="">
                <p id="errpassword_confirmation" class="mb-0 text-danger em"></p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <label for="">{{ __('Role') }} <span class="text-danger">**</span></label>
                <select class="form-control" name="role_id">
                  <option value="" selected disabled>{{ __('Select a Role') }}</option>
                  @foreach ($roles as $key => $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                  @endforeach
                </select>
                <p id="errrole_id" class="mb-0 text-danger em"></p>
              </div>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
        <button id="submitBtn" type="button" class="btn btn-primary">{{ __('Submit') }}</button>
      </div>
    </div>
  </div>
</div>
