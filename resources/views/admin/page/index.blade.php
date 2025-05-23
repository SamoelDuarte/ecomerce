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
    <h4 class="page-title">{{ __('All Pages') }}</h4>
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
        <a href="#">{{ __('Pages') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Additional Page') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('All Pages') }}</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-5">
              <div class="card-title d-inline-block">{{ __('All Pages') }}</div>
            </div>
            <div class="col-lg-2">
              @include('admin.partials.languages')
            </div>
            <div class="col-lg-5 mt-2 mt-lg-0">
              <a href="{{ route('admin.page.create') }}"
                class="btn btn-primary {{ $default->rtl == 1 ? 'float-lg-left' : 'float-lg-right' }} float-left btn-sm"><i
                  class="fas fa-plus"></i> {{ __('Add Page') }}</a>
              <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete"
                data-href="{{ route('admin.page.bulk.delete') }}"><i class="flaticon-interface-5"></i>
                {{ __('Delete') }}</button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($apages) == 0)
                <h2 class="text-center">{{ __('NO PAGE FOUND') }}</h2>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="basic-datatables">
                    <thead>
                      <tr>
                        <th scope="col">
                          <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">{{ __('Title') }}</th>
                        <th scope="col">{{ __('URL') }}</th>
                        <th scope="col">{{ __('Status') }}</th>
                        <th scope="col">{{ __('Actions') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($apages as $key => $apage)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{ $apage->id }}">
                          </td>
                          <td>{{ $apage->title }}</td>
                          <td width="20%"><a href="{{ route('front.dynamicPage', $apage->slug) }}"
                              target="_blank">{{ route('front.dynamicPage', $apage->slug) }}</a></td>
                          <td>
                            @if ($apage->status == 1)
                              <span class="badge badge-success">{{ __('Active') }}</span>
                            @elseif ($apage->status == 0)
                              <span class="badge badge-danger">{{ __('Deactive') }}</span>
                            @endif
                          </td>
                          <td>
                            <a class="btn btn-secondary btn-sm mb-1"
                              href="{{ route('admin.page.edit', $apage->id) . '?language=' . request()->input('language') }}">
                              <i class="fas fa-edit"></i>
                            </a>
                            <form class="d-inline-block deleteform" action="{{ route('admin.page.delete') }}"
                              method="post">
                              @csrf
                              <input type="hidden" name="pageid" value="{{ $apage->id }}">
                              <button type="submit" class="btn btn-danger btn-sm deletebtn mb-1">
                                <i class="fas fa-trash"></i>
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
