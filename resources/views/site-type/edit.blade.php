@extends('DashboardModule::dashboard.index')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @include('DashboardModule::partials.alerts')
                        <h4 class="card-title">Edytowanie rodzaju strony</h4>

                        <form class="content-type-form" method="POST"
                              action="{{route('SitesModule::site-types.update', ['siteType' => $siteType])}}">
                            @csrf
                            @method('PUT')
                            <div class="form-group @error('name') has-danger @enderror">
                                <label for="">Nazwa</label>
                                <input type="text" class="form-control" name="name" placeholder="Wpisz nazwe"
                                       value="{{$siteType->name}}">
                                <small>Służy do indentyfikacji w panelu administracyjnym</small>
                                @error('name')
                                <small class="error mt-1 text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group @error('blade') has-danger @enderror">
                                <label for="">Szablon</label>
                                <input type="text" class="form-control" name="blade" placeholder="Wpisz szablon" value="{{$siteType->blade}}">

                                @error('blade')
                                <small class="error mt-1 text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group @error('structure') has-danger @enderror">
                                <label for="">Struktura
                                    <button type="button" class="btn btn-sm btn-primary ml-2" id="add-item-structure">
                                        <i class="mdi mdi-plus"></i>
                                        <span>Dodaj typ prosty treści</span>
                                    </button>
                                    @if($contentGroups->count() > 0)
                                        <button type="button" class="btn btn-sm bg-purple text-white ml-2" id="add-group-item">
                                            <i class="mdi mdi-plus"></i>
                                            <span>Dodaj grupę treści</span>
                                        </button>
                                    @endif
                                </label>
                                <div class="legend mb-3"></div>
                                <input type="hidden" name="structure">
                                <div class="structure"></div>

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

    @javascript('contentGroups', $contentGroups)
    @javascript('structure', $siteType->structure)
@endsection

@section('stylesheets')
    @parent

    <link rel="stylesheet" href="{{mix('/vendor/css/SitesModule.css')}}">
@endsection

@section('javascripts')
    @parent

    <script src="{{mix('/vendor/js/SitesModule.js')}}"></script>
@endsection
