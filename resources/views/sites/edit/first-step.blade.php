@extends('DashboardModule::dashboard.index')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Kreator strony</h4>
                        @include('DashboardModule::partials.alerts')
                        <form method="POST" class="step-1" action="{{route('SitesModule::sites.edit.step-2', ['site' => $site])}}">
                            @csrf

                            <div class="form-group @error('name') has-danger @enderror">
                                <label for="">Nazwa</label>
                                <p>{{$site->name}}</p>
                                <input type="hidden" name="name" value="{{$site->name}}">
                                <small>Służy do indentyfikacji w panelu administracyjnym</small>
                                @error('name')
                                <small class="error mt-1 text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group @error('blade') has-danger @enderror">
                                <label for="">Szablon</label>
                                <input type="text" class="form-control" name="blade" placeholder=""
                                       value="{{$site->blade}}">
                                @error('blade')
                                <small class="error mt-1 text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group @error('slug') has-danger @enderror">
                                <label for="">Link</label>
                                <input type="text" class="form-control" name="slug" placeholder="Wpisz nazwe"
                                       value="{{$site->slug}}">
                                @error('slug')
                                <small class="error mt-1 text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group @error('status') has-danger @enderror">
                                <label for="">Status</label>
                                <select name="status" id="" class="select form-control">
                                    @foreach($statuses as $status)
                                        <option value="{{$status}}" @if($site->status === $status) selected @endif>{{__('SitesModule::statuses.'.$status)}}</option>
                                    @endforeach
                                </select>

                                @error('status')
                                <small class="error mt-1 text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group @error('site_type_id') has-danger @enderror">
                                <label for="">Rodzaj strony</label>
                                <select name="site_type_id" id="" class="select form-control">
                                    <option value="">Domyślny</option>
                                    @foreach($siteTypes as $siteType)
                                        <option value="{{$siteType->id}}" @if((int) $site->site_type_id === $siteType->id) selected @endif>{{$siteType->name}}</option>
                                    @endforeach
                                </select>

                                @error('site_type_id')
                                <small class="error mt-1 text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div id="structure" class="form-group @error('structure') has-danger @enderror">
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

                            <div>
                                <button class="btn btn-primary btn-sm mt-2 float-right to-step-2">Dalej</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @javascript('contentGroups', $contentGroups)
    @javascript('structure', json_decode($structure))
@endsection

@section('stylesheets')
    @parent

    <link rel="stylesheet" href="{{mix('/vendor/css/SitesModule.css')}}">
@endsection

@section('javascripts')
    @parent

    <script src="{{mix('/vendor/js/SitesModule.js')}}"></script>
@endsection

