@extends('DashboardModule::dashboard.index')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edytuj strone {{$site->name}}</h4>

                        <form method="POST" action="{{route('SitesModule::sites.update', ['site' => $site])}}" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="name" value="{{$request['name']}}">
                            <input type="hidden" name="slug" value="{{$request['slug']}}">
                            <input type="hidden" name="status" value="{{$request['status']}}">
                            <input type="hidden" name="blade" value="{{$request['blade']}}">
                            <input type="hidden" name="site_type_id" value="{{$request['site_type_id']}}">
                            <input type="hidden" name="structure" value="{{$request['structure']}}">

                            {!! $form !!}
                            <div>
                                <button class="btn btn-primary btn-sm mt-2 float-right">Zapisz</button>
                            </div>
                        </form>
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

