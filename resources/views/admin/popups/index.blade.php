@extends('admin.layout')

@php
  $selLang = \App\Models\Language::where('code', request()->input('language'))->first();
@endphp
@if (!empty($selLang) && $selLang->rtl == 1)
  @section('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/rtl.css') }}">
  @endsection
@endif

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Popups') }}</h4>
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
        <a href="#">{{ __('Announcement Popup') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Popups') }}</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-5">
              <div class="card-title d-inline-block">{{ __('Announcement Popups') }}</div>
            </div>
            <div class="col-lg-2">
              @include('admin.partials.languages')
            </div>
            <div class="col-lg-5 mt-2 mt-lg-0">
              <a href="{{ route('admin.popup.types') }}" class="btn btn-primary float-right btn-sm"><i
                  class="fas fa-plus"></i> {{ __('Add Popup') }}</a>
              <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete"
                data-href="{{ route('admin.popup.bulk.delete') }}"><i class="flaticon-interface-5"></i>
                {{ __('Delete') }}</button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($popups) == 0)
                <h3 class="text-center">{{ __('NO POPUP FOUND') }}</h3>
              @else
                <div class="row">
                  <div class="col-12 text-center">
                    <div class="alert alert-warning text-dark">
                      {{ __('All') }} <strong class="text-info">{{ __('Activated Popups') }}</strong>
                      {{ __('will be shown in website according to') }}
                      <strong class="text-info">{{ __('Serial Number') }}</strong>
                    </div>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="basic-datatables">
                    <thead>
                      <tr>
                        <th scope="col">
                          <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">{{ __('Image') }}</th>
                        <th scope="col">{{ __('Name') }}</th>
                        <th scope="col">{{ __('Status') }}</th>
                        <th scope="col">{{ __('Type') }}</th>
                        <th scope="col">{{ __('Serial Number') }}</th>
                        <th scope="col">{{ __('Actions') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($popups as $key => $popup)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{ $popup->id }}">
                          </td>
                          <td>
                            <div class="mb-2">
                              @if (!empty($popup->image))
                                <img src="{{ asset('assets/front/img/popups/' . $popup->image) }}" width="65">
                              @elseif (!empty($popup->background_image))
                                <img src="{{ asset('assets/front/img/popups/' . $popup->background_image) }}"
                                  width="65">
                              @endif
                            </div>
                          </td>
                          <td>
                            {{ strlen($popup->name) > 20 ? mb_substr($popup->name, 0, 20, 'utf-8') . '...' : $popup->name }}
                          </td>
                          <td>
                            <form id="statusForm{{ $popup->id }}" class="d-inline-block"
                              action="{{ route('admin.popup.status') }}" method="post">
                              @csrf
                              <input type="hidden" name="popup_id" value="{{ $popup->id }}">
                              <select
                                class="w-min-max-100 form-control form-control-sm
                                @if ($popup->status == 1) bg-success
                                @elseif ($popup->status == 0)
                                  bg-danger @endif
                                "
                                name="status"
                                onchange="document.getElementById('statusForm{{ $popup->id }}').submit();">
                                <option value="1" {{ $popup->status == 1 ? 'selected' : '' }}>{{ __('Active') }}
                                </option>
                                <option value="0" {{ $popup->status == 0 ? 'selected' : '' }}>{{ __('Deactive') }}
                                </option>
                              </select>
                            </form>
                          </td>
                          <td>
                            <img width="60"
                              src="{{ asset('assets/admin/img/popups/popup-' . $popup->type . '.jpg') }}">
                            <p class="mb-0">
                              {{ __('Type') . ' - ' }}{{ $popup->type }}
                            </p>
                          </td>
                          <td>{{ $popup->serial_number }}</td>
                          <td>
                            <a class="btn btn-secondary btn-sm mb-1"
                              href="{{ route('admin.popup.edit', $popup->id) . '?language=' . request()->input('language') }}">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                            </a>
                            <form class="deleteform d-inline-block" action="{{ route('admin.popup.delete') }}"
                              method="post">
                              @csrf
                              <input type="hidden" name="popup_id" value="{{ $popup->id }}">
                              <button type="submit" class="btn btn-danger btn-sm deletebtn mb-1">
                                <span class="btn-label">
                                  <i class="fas fa-trash"></i>
                                </span>
                              </button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
