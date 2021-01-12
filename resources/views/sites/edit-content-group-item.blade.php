@extends('DashboardModule::dashboard.index')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edytowanie {{ $contentGroupItem['_name'] }}</h4>

                        <form method="POST" action="{{route('SitesModule::sites.content-group-item.update', ['site' => $site, 'contentGroup' => $contentGroup, 'contentGroupName' => $contentGroupName, 'contentGroupItemName' => $contentGroupItem['_name'] ])}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="_order" value="{{$contentGroupItem['_order']}}">
                            <input type="hidden" name="_active" value="{{$contentGroupItem['_active']}}">

                            <div class="form-group @error('_name') has-danger @enderror">
                                <label for="">Nazwa</label>
                                <input type="text" class="form-control" name="_name" placeholder="Wpisz nazwe"
                                       value="{{$contentGroupItem['_name']}}">
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

