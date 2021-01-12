@if($siteType->sites->count() > 0)
<div class="site site--type">
    <div class="bg-warning">
        <div class="show">
            <div class="arrow">
                    <div></div>
                    <div></div>
            </div>
        </div>
        <div class="site-content">
            <div class="site-info text-white">
                {{ $siteType->name }}
            </div>
        </div>
    </div>
    <div class="additional-structure">
        @each('SitesModule::sites.partials.site', $siteType->sites, 'site')
    </div>

</div>
@endif
