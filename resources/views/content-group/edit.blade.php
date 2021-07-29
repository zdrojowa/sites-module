@extends('DashboardModule::dashboard.index')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @include('DashboardModule::partials.alerts')
                        <h4 class="card-title">Edytowanie grupy treści</h4>

                        <form class="content-type-form" method="POST" action="{{route('SitesModule::content-type-group.update', ['contentGroup' => $contentGroup])}}">
                            @csrf
                            @method('PUT')
                            <div class="form-group @error('name') has-danger @enderror">
                                <label for="">Nazwa</label>
                                <input type="text" class="form-control" name="name" placeholder="Wpisz nazwe" value="{{ $contentGroup->name }}">
                                <small>Służy do indentyfikacji w panelu administracyjnym</small>
                                @error('name')
                                <small class="error mt-1 text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group @error('structure') has-danger @enderror">
                                <label for="">Struktura: <button type="button" class="btn btn-sm btn-primary" id="add-item-structure"><i class="mdi mdi-plus"></i></button></label>
                                <div class="legend mb-3"></div>
                                <input type="hidden" name="structure">
                                <div class="structure">
                                </div>
                                @error('structure')
                                <small class="error mt-1 text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="buttons">
                                <button class="btn btn-primary btn-sm mt-2 float-right save-button">Zapisz</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @javascript('structure', $contentGroup->structure)
@endsection

@section('stylesheets')
    @parent

    <link rel="stylesheet" href="{{mix('/vendor/css/SitesModule.css')}}">
@endsection

@section('javascripts')
    @parent

    <script src="{{mix('/vendor/js/SitesModule.js')}}"></script>
@endsection
