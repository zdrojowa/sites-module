<div class="site" data-id="{{$site->_id}}">
    <div>
        <div class="show">
            <div class="arrow">
                @if($site->hasContentGroups())
                    <div></div>
                    <div></div>
                @endif
            </div>
        </div>
        <div class="site-content">
            <div class="site-info">
                {{ $site->name }}
            </div>
            <div class="actions">
                @permission('SitesModule.sites.translations')
                <a href="{{ route('SitesModule::sites.translations.checkMissing', ['site' => $site->_id]) }}"
                   class="mr-3 add-translation-btn" title="Dodaj wersje językową"
                   data-clone-route="{{ route('SitesModule::sites.clone', ['site' => $site->parent_id ?? $site->_id]) }}">
                    <i class="mdi mdi-translate"></i>
                    <span>Dodaj wersje jezykową</span>
                </a>
                @endpermission()
                @permission('SitesModule.sites.edit')
                <a href="{{route('SitesModule::sites.edit', ['site' => $site])}}">
                    <i class="mdi mdi-pencil"></i>
                </a>
                @endpermission()
                <a class="change-visibility" href="{{route('SitesModule::sites.visibility', ['site' => $site->_id])}}"
                   title="Włancz / Wyłancz">
                    @if($site->active)
                        <i class="mdi mdi-checkbox-marked-circle active"></i>
                    @else
                        <i class="mdi mdi-close-circle inactive"></i>
                    @endif
                </a>
            </div>
        </div>
    </div>
    <div class="additional-structure">
        @if($site->hasContentGroups())
            @foreach($site->getContentGroups() as $group)
                @include('SitesModule::sites.partials.group', ['group' => $group, 'site' => $site])
            @endforeach
        @endif
    </div>
</div>
