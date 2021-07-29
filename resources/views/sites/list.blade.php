@extends('DashboardModule::dashboard.index')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            Strony
                        </h4>

                        <div class="col-3 p-0 mb-4">
                            <label>Wybierz wersje językową:</label>
                            <form action="" class="d-flex">
                                <select id="lang-options" name="language" class="form-control">
                                    @foreach($languages as $prefix => $language)
                                        <option value="{{$prefix}}" @if(app('request')->get('language') == $prefix) selected @endif>{{$language}}</option>
                                    @endforeach
                                </select>
                            </form>

                        </div>

                        @include('DashboardModule::partials.alerts')

                        <div class="sites">
                            @each('SitesModule::sites.partials.site', $sites, 'site')

                            <p class="text-gray mt-4 mb-1">Rodzaje stron</p>
                            @each('SitesModule::sites.partials.site-type', $siteTypes, 'siteType')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('stylesheets')
    @parent

    <link rel="stylesheet" href="{{mix('/vendor/css/SitesModule.css')}}">
@endsection

@section('javascripts')
    @parent

    <script src="{{mix('/vendor/js/SitesModule.js')}}"></script>
@endsection

