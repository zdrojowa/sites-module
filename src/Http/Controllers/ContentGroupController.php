<?php

namespace Selene\Modules\SitesModule\Http\Controllers;

use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Selene\Modules\DashboardModule\ZdrojowaTable;
use Selene\Modules\SitesModule\Http\Requests\ContentTypeGroupStoreRequest;
use Selene\Modules\SitesModule\Http\Requests\ContentTypeGroupUpdateRequest;
use Selene\Modules\SitesModule\Models\ContentGroup;

/**
 * Class ContentGroupController
 * @package Selene\Modules\SitesModule\Http\Controllers
 */
class ContentGroupController extends Controller
{

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view("SitesModule::content-group.add");
    }

    /**
     * @param ContentTypeGroupStoreRequest $request
     *
     * @param ContentGroup $contentGroup
     *
     * @return RedirectResponse
     */
    public function store(ContentTypeGroupStoreRequest $request, ContentGroup $contentGroup)
    {
        $contentGroup->create($contentGroup->prepareRequest());

        $request->session()->flash('alert-success', 'Grupa treści została pomyślnie utworzona');

        return redirect()->route('SitesModule::content-type-group.create');
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('SitesModule::content-group.list');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function ajax(Request $request)
    {
        return ZdrojowaTable::response(ContentGroup::query(), $request);
    }

    /**
     * @param ContentGroup $contentGroup
     *
     * @return Factory|View
     */
    public function edit(ContentGroup $contentGroup)
    {
        return view('SitesModule::content-group.edit', ['contentGroup' => $contentGroup]);
    }

    /**
     * @param ContentTypeGroupUpdateRequest $request
     * @param ContentGroup $contentGroup
     *
     * @return RedirectResponse
     */
    public function update(ContentTypeGroupUpdateRequest $request, ContentGroup $contentGroup)
    {
        $contentGroup->update($contentGroup->prepareRequest());

        $request->session()->flash('alert-success', 'Grupa treści została pomyślnie zaktualizowana');

        return redirect()->route('SitesModule::content-type-group.edit', ["contentGroup" => $contentGroup]);
    }

    /**
     * @param ContentGroup $contentGroup
     *
     * @throws Exception
     */
    public function destroy(ContentGroup $contentGroup)
    {
        $contentGroup->delete();
    }
}
