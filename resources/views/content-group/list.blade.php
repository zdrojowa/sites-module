@extends('DashboardModule::dashboard.index')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Lista wszystkich grup treści</h4>
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
                url: "{{route('SitesModule::content-type-group.ajax')}}",
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
                        @permission('SitesModule.content-type-group.edit')
                        {
                            color: 'primary',
                            icon: 'mdi mdi-pencil',
                            class: 'edit',
                            url: '{{route('SitesModule::content-type-group.edit', ["contentGroup" => "%%id%%"])}}'
                        },
                        @endpermission
                        @permission('SitesModule.content-type-group.delete')
                        {
                            color: 'danger',
                            icon: 'mdi mdi-delete',
                            class: 'ZdrojowaTable--remove-action',
                            url: '{{route('SitesModule::content-type-group.destroy', ["contentGroup" => "%%id%%"])}}'
                        }
                        @endpermission
                    ]
                }
            ]
        });
    </script>
@endsection
