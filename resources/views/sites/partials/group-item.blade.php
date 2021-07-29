<div class="site content-group" data-name="{{$groupItem['_name']}}">
    <div>
        <div class="show">
            <div class="arrow"></div>
        </div>
        <div class="site-content">
            <div class="site-info">
                {{ $groupItem['_name'] }}
            </div>
            <div class="actions">
                <a href="{{route("SitesModule::sites.content-group-item.edit", ["site" => $site->_id, "contentGroup" => $group['value'], 'contentGroupName' => $group['name'], 'contentGroupItemName' => $groupItem['_name']])}}">
                    <i class="mdi mdi-pencil"></i>
                </a>
                <a class="change-visibility" href="{{route('SitesModule::sites.content-group-item.visibility', ['site' => $site->_id, "contentGroup" => $group['value'], 'contentGroupName' => $group['name'], 'contentGroupItemName' => $groupItem['_name']])}}" title="Włancz / Wyłancz">
                    @if($groupItem['_active'])
                        <i class="mdi mdi-checkbox-marked-circle active"></i>
                    @else
                        <i class="mdi mdi-close-circle inactive"></i>
                    @endif
                </a>
            </div>
        </div>
    </div>
    <div class="additional-structure">

    </div>
</div>
