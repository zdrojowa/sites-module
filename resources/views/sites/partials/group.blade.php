@inject('contentHelper', 'Selene\Modules\SitesModule\Support\ContentHelper')

<div class="site content-group" data-id="{{$group['value']}}">
    <div>
        <div class="show">
            <div class="arrow">
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="site-content">
            <div class="site-info">
                {{ $group['name'] }}
            </div>
            <div class="actions">
                <a href="{{route("SitesModule::sites.content-group-item.create", ["site" => $site->_id, "contentGroup" => $group['value'], 'contentGroupName' => $group['name']])}}">
                    <i class="mdi mdi-plus"></i>
                </a>

                @if(count($site->getContent($group['name']) ?? []) > 0)
                    <a title="Zmień kolejność" href="{{route('SitesModule::sites.content-group.order', ["site" => $site->_id, "contentGroup" => $group['value'], "contentGroupName" => $group['name']])}}">
                        <i class="mdi mdi-format-list-bulleted-square text-warning"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
    <div class="additional-structure">
        @foreach($contentHelper::sortGroupItems($site->getContent($group['name']) ?? []) as $groupItem)
            @include('SitesModule::sites.partials.group-item', ['site' => $site, 'group' => $group, 'groupItem' => $groupItem])
        @endforeach
    </div>
</div>
