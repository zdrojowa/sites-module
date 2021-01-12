@extends('DashboardModule::dashboard.index')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Lista wszystkich rodzajów stron</h4>
                        <table class="table table-striped"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascripts')
    @parent

    <script>
        $('.table').zdrojowaTable({
            ajax: {
                url: "{{route('SitesModule::site-types.ajax')}}",
                method: "POST",
                data: {
                    "_token": "{{csrf_token()}}"
                },
            },
            headers: [
                {
                    name: 'L.p',
                    type: 'index'
                },
                {
                    name: 'Nazwa',
                    type: 'text',
                    ajax: 'name',
                    orderable: true,
                },
                {
                    name: 'Data utworzenia',
                    orderable: true,
                    ajax: 'created_at'
                },
                {
                    name: 'Data ostatniej modyfikacji',
                    orderable: true,
                    ajax: 'updated_at'
                },
                {
                    name: 'Akcje',
                    type: 'actions',
                    buttons: [
                        @permission('SitesModule.site-types.edit')
                        {
                            color: 'primary',
                            icon: 'mdi mdi-pencil',
                            class: 'edit',
                            url: '{{route('SitesModule::site-types.edit', ["siteType" => "%%id%%"])}}'
                        },
                        @endpermission
                        @permission('SitesModule.site-types.delete')
                        {
                            color: 'danger',
                            icon: 'mdi mdi-delete',
                            class: 'ZdrojowaTable--remove-action',
                            url: '{{route('SitesModule::site-types.destroy', ["siteType" => "%%id%%"])}}'
                        }
                        @endpermission
                    ]
                }
            ]
        });
    </script>
@endsection
