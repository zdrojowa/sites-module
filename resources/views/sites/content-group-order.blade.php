@extends('DashboardModule::dashboard.index')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            Zmiana kolejności
                        </h4>

                        @include('DashboardModule::partials.alerts')

                        <div class="content-group-items-sortable">
                            @each('SitesModule::sites.partials.group-item-order', $contentGroupItems, 'item')
                        </div>

                        <button data-loading-text="<i class='mdi mdi-spin mdi-loading'></i> Trwa zapisywanie" class=" btn btn-primary btn-sm float-right mt-4 save-content-group-items-order" data-ajax="false" data-url="{{route('SitesModule::sites.content-group.order.update', ['site' => $site, 'contentGroup' => $contentGroup, 'contentGroupName' => $contentGroupName])}}">Zapisz kolejność</button>
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

