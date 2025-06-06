@extends('admin.layout')
@php
  $type = $popup->type;
@endphp
@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Announcement Popup') }}</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{ route('admin.dashboard') }}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Basic Settings') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Announcement Popup') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Edit Popup') }} ({{ __('Type') }} - {{ $type }})</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-10">
              <div class="card-title">{{ __('Edit Popup') }} ({{ __('Type') }} - {{ $type }})</div>
            </div>
            <div class="col-lg-2 text-right">
              <a href="{{ route('admin.popup.index') . '?language=' . request()->input('language') }}"
                class="btn btn-primary btn-sm">{{ __('Back') }}</a>
            </div>
          </div>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 m-auto">

              <form id="ajaxForm" class="modal-form" action="{{ route('admin.popup.update') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="popup_id" value="{{ $popup->id }}">
                <input type="hidden" name="type" value="{{ $type }}">

                @if ($type == 1 || $type == 4 || $type == 5 || $type == 7)
                  {{-- Image Part --}}
                  <div class="form-group">
                    <div class="col-12 mb-2 pl-0 pr-0">
                      <label for="image"><strong>{{ __('Image') }}</strong></label>
                    </div>
                    <div class="col-md-12 showImage mb-3 pl-0 pr-0">
                      <img
                        src="{{ $popup->image ? asset('assets/front/img/popups/' . $popup->image) : asset('assets/admin/img/noimage.jpg') }}"
                        alt="..." class="img-thumbnail">
                    </div>

                    <div role="button" class="btn btn-primary btn-sm upload-btn" id="image">
                      {{ __('Choose Image') }}
                      <input type="file" class="img-input" name="image">
                    </div>

                    <p class="mb-0 text-warning">{{ __('Only png, jpg, jpeg image is allowed') }}</p>
                    <p id="errimage" class="mb-0 text-danger em"></p>
                  </div>
                @endif

                @if ($type == 2 || $type == 3 || $type == 6)
                  {{-- Background Image Part --}}
                  <div class="form-group">
                    <div class="col-12 mb-2 pl-0 pr-0">
                      <label for="image"><strong>{{ __('Background Image') }}</strong></label>
                    </div>
                    <div class="col-md-12 showImage mb-3 pl-0 pr-0">
                      <img
                        src="{{ $popup->background_image ? asset('assets/front/img/popups/' . $popup->background_image) : asset('assets/admin/img/noimage.jpg') }}"
                        alt="..." class="img-thumbnail">
                    </div>
                    <div role="button" class="btn btn-primary btn-sm upload-btn" id="image">
                      {{ __('Choose Image') }}
                      <input type="file" class="img-input" name="background_image">
                    </div>

                    <p class="mb-0 text-warning">{{ __('Only png, jpg, jpeg image is allowed') }}</p>
                    <p id="errimage" class="mb-0 text-danger em"></p>
                  </div>
                @endif

                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label for="">{{ __('Popup Name') }} <span class="text-danger">**</span></label>
                      <input type="text" class="form-control" name="name" value="{{ $popup->name }}"
                        placeholder="{{ __('Enter name') }}">
                      <p class="text-warning mb-0">
                        {{ __('This will not be shown in the popup in Website, it will help you to indentify the popup in Admin Panel.') }}
                      </p>
                      <p id="errname" class="mb-0 text-danger em"></p>
                    </div>
                  </div>
                </div>


                @if ($type == 2 || $type == 3 || $type == 4 || $type == 5 || $type == 6 || $type == 7)
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label for="">{{ __('Title') }} </label>
                        <input type="text" class="form-control" name="title" value="{{ $popup->title }}"
                          placeholder="{{ __('Enter Title') }}">
                        <p id="errtitle" class="mb-0 text-danger em"></p>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label for="">{{ __('Text') }} </label>
                        <textarea class="form-control" name="text" cols="30" rows="3" placeholder="{{ __('Enter Text') }}">{{ $popup->text }}</textarea>
                        <p id="errtext" class="mb-0 text-danger em"></p>
                      </div>
                    </div>
                  </div>
                @endif

                @if ($type == 6 || $type == 7)
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">{{ __('End Date') }} <span class="text-danger">**</span></label>
                        <input type="text" class="form-control ltr datepicker" name="end_date"
                          value="{{ $popup->end_date }}" placeholder="{{ __('Enter End Date') }}" autocomplete="off">
                        <p id="errend_date" class="mb-0 text-danger em"></p>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">{{ __('End Time') }} <span class="text-danger">**</span></label>
                        <input type="text" class="form-control ltr flatpickr" name="end_time"
                          value="{{ $popup->end_time }}" placeholder="{{ __('Enter End Time') }}" autocomplete="off">
                        <p id="errend_time" class="mb-0 text-danger em"></p>
                      </div>
                    </div>
                  </div>
                @endif

                @if ($type == 2 || $type == 3)
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label>{{ __('Background Color Code') }} <span class="text-danger">**</span></label>
                        <input class="jscolor form-control ltr" name="background_color"
                          value="{{ $popup->background_color }}">
                        <p class="em text-danger mb-0" id="errbackground_color"></p>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">{{ __('Background Color Opacity') }} <span
                            class="text-danger">**</span></label>
                        <input type="number" class="form-control ltr" name="background_opacity"
                          value="{{ $popup->background_opacity }}" placeholder="{{ __('Enter Opacity Value') }}">
                        <p id="errbackground_opacity" class="mb-0 text-danger em"></p>
                        <ul class="mb-0">
                          <li class="text-warning mb-0">{{ __('Value must be between 0 to 1') }}</li>
                          <li class="text-warning mb-0">
                            {{ __('The more the opacity value is, the less the trnsparency level will be.') }}</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                @endif

                @if ($type == 7)
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label>{{ __('Background Color Code') }} <span class="text-danger">**</span></label>
                        <input class="jscolor form-control ltr" name="background_color"
                          value="{{ $popup->background_color }}">
                        <p class="em text-danger mb-0" id="errbackground_color"></p>
                      </div>
                    </div>
                  </div>
                @endif

                @if ($type == 2 || $type == 3 || $type == 4 || $type == 5 || $type == 6 || $type == 7)
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">{{ __('Button Text') }} </label>
                        <input type="text" class="form-control" name="button_text"
                          value="{{ $popup->button_text }}" placeholder="{{ __('Enter Button Text') }}">
                        <p id="errbutton_text" class="mb-0 text-danger em"></p>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">{{ __('Button Color') }} </label>
                        <input type="text" class="form-control jscolor ltr" name="button_color"
                          value="{{ $popup->button_color }}" placeholder="{{ __('Enter Button Color') }}">
                        <p id="errbutton_color" class="mb-0 text-danger em"></p>
                      </div>
                    </div>
                  </div>
                @endif

                @if ($type == 2 || $type == 4 || $type == 6 || $type == 7)
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label for="">{{ __('Button URL') }} </label>
                        <input type="text" class="form-control ltr" name="button_url"
                          value="{{ $popup->button_url }}" placeholder="{{ __('Enter Button URL') }}">
                        <p id="errbutton_url" class="mb-0 text-danger em"></p>
                      </div>
                    </div>
                  </div>
                @endif

                <div class="form-group">
                  <label for="">{{ __('Delay (miliseconds)') }} <span class="text-danger">**</span></label>
                  <input type="number" class="form-control ltr" name="delay" value="{{ $popup->delay }}"
                    placeholder="{{ __('Enter Delay (miliseconds)') }}">
                  <p id="errdelay" class="mb-0 text-danger em"></p>
                  <p class="text-warning mb-0">{{ __('This will decide the delay time to show the popup') }}</p>
                </div>
                <div class="form-group">
                  <label for="">{{ __('Serial Number') }} <span class="text-danger">**</span></label>
                  <input type="number" class="form-control ltr" name="serial_number"
                    value="{{ $popup->serial_number }}" placeholder="{{ __('Enter Serial Number') }}">
                  <p id="errserial_number" class="mb-0 text-danger em"></p>
                  <ul>
                    <li class="text-warning mb-0">{{ __('If there are') }} <strong
                        class="text-info">{{ __('Multiple Active Popups') }}</strong>{{ __(', then the popups will be shown in the website according to') }}
                      <strong class="text-info">{{ __('Serial Number') }}</strong>
                    </li>
                    <li class="text-warning">
                      {{ __('The higher the serial number, the later the popups will be visible in Website') }}</li>
                  </ul>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="form-group from-show-notify row">
            <div class="col-12 text-center">
              <button id="submitBtn" type="button" class="btn btn-primary">{{ __('Submit') }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
