@extends('DashboardModule::dashboard.index')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tworzenie {{ $contentGroupName }}</h4>

                        <form method="POST" action="{{route('SitesModule::sites.content-group-item.store', ['site' => $site, 'contentGroup' => $contentGroup, 'contentGroupName' => $contentGroupName])}}" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="_order" value="0">
                            <input type="hidden" name="_active" value="false">

                            <div class="form-group @error('_name') has-danger @enderror">
                                <label for="">Nazwa</label>
                                <input type="text" class="form-control" name="_name" placeholder="Wpisz nazwe"
                                       value="{{old('_name')}}">
                                <small>Służy do indentyfikacji w panelu administracyjnym</small>
                                @error('_name')
                                <small class="error mt-1 text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

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
    <link rel="stylesheet" href="{{mix('/vendor/css/SitesModule.css')}}">
@endsection

@section('javascripts')
    <script src="{{mix('/vendor/js/SitesModule.js')}}"></script>
@endsection

