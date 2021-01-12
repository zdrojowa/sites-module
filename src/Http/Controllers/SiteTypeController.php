<?php

namespace Selene\Modules\SitesModule\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Selene\Modules\DashboardModule\ZdrojowaTable;
use Selene\Modules\Module;
use Selene\Modules\SitesModule\Http\Requests\SiteTypeStoreRequest;
use Selene\Modules\SitesModule\Http\Requests\SiteTypeUpdateRequest;
use Selene\Modules\SitesModule\Models\ContentGroup;
use Selene\Modules\SitesModule\Models\SiteType;

/**
 * Class SiteTypeController
 * @package Selene\Modules\SitesModule\Http\Controllers
 */
class SiteTypeController extends Module
{

    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('SitesModule::site-type.list');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function ajax(Request $request)
    {
        return ZdrojowaTable::response(SiteType::query(), $request);
    }

    /**
     * @param Request $request
     *
     * @param ContentGroup $contentGroup
     *
     * @return Factory|View
     */
    public function create(Request $request, ContentGroup $contentGroup)
    {
        $contentGroups = $contentGroup->select('_id', 'name')->pluck('name', '_id');

        return view('SitesModule::site-type.add', ['contentGroups' => $contentGroups]);
    }

    /**
     * @param SiteTypeStoreRequest $request
     *
     * @param SiteType $siteType
     *
     * @return RedirectResponse
     */
    public function store(SiteTypeStoreRequest $request, SiteType $siteType)
    {
        $siteType->create($siteType->prepareRequest());

        $request->session()->flash('alert-success', 'Rodzaj strony został pomyślnie dodany');

        return redirect()->route('SitesModule::site-types.create');
    }

    /**
     * @param SiteType $siteType
     * @param ContentGroup $contentGroup
     *
     * @return Factory|View
     */
    public function edit(SiteType $siteType, ContentGroup $contentGroup)
    {
        $contentGroups = $contentGroup->select('_id', 'name')->pluck('name', '_id');

        return view('SitesModule::site-type.edit', ['siteType' => $siteType, 'contentGroups' => $contentGroups]);
    }

    /**
     * @param SiteTypeUpdateRequest $request
     * @param SiteType $siteType
     *
     * @return RedirectResponse
     */
    public function update(SiteTypeUpdateRequest $request, SiteType $siteType)
    {
        $siteType->update($siteType->prepareRequest());

        $request->session()->flash('alert-success', 'Rodzaj strony został pomyślnie zaktualizowany');

        return redirect()->route('SitesModule::site-types.edit', ['siteType' => $siteType]);
    }

    /**
     * @param SiteType $siteType
     */
    public function destroy(SiteType $siteType)
    {
        $siteType->forceDelete();
    }
}
