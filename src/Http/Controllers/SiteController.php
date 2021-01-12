<?php

namespace Selene\Modules\SitesModule\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Selene\Modules\LanguageModule\Models\Language;
use Selene\Modules\SitesModule\Http\Requests\SiteStoreFirstStepRequest;
use Selene\Modules\SitesModule\Http\Requests\SiteUpdateFirstStepRequest;
use Selene\Modules\SitesModule\Models\ContentGroup;
use Selene\Modules\SitesModule\Models\Site;
use Selene\Modules\SitesModule\Models\SiteType;
use Selene\Modules\SitesModule\StructureManager\StructureManager;
use Selene\Modules\SitesModule\Support\ContentHelper;
use Selene\Modules\SitesModule\Support\Enums\SiteStatus;

/**
 * Class SiteController
 * @package Selene\Modules\SitesModule\Http\Controllers
 */
class SiteController extends Controller
{

    public function site(Request $request, Site $site, $slug = "/") {

        $slug = Str::start($slug, '/');
        $site = $site->where('slug', $slug)->where('language_short_name', app()->getLocale())->where('active', true)->first();
        if (!$site) abort(404);

        $content = [];

        foreach ($site->content as $key => $contentItem) {
            $content[camelCase($key)] = $contentItem;
        }

        $content['site'] = $site;

        return view($site->blade, $content);
    }

    /**
     * @param SiteType $siteType
     * @param Site $site
     *
     * @param Request $request
     *
     * @return Factory|View
     */
    public function index(SiteType $siteType, Site $site, Request $request)
    {
        $siteTypes = $siteType->with('sites')->get();
        $language_short_name = $request->get('language') ?? 'pl';
        $sites = $site->where('site_type_id', null)->where('language_short_name', $language_short_name)->get();

        return view('SitesModule::sites.list', [
            'sites' => $sites,
            'siteTypes' => $siteTypes,
            'languages' => Language::getSelectWithLanguageOptions()->toArray(),
        ]);
    }

    /**
     * @param ContentGroup $contentGroup
     *
     * @param SiteType $siteType
     *
     * @return Factory|View
     */
    public function createFirstStep(ContentGroup $contentGroup, SiteType $siteType)
    {
        if (Language::all()->count() === 0) {
            request()->session()->flash('alert-danger', 'Nie możesz utworzyć strony, ponieważ nie dodałeś języka! Dodaj nowy język i przejdź do formularza dodawania nowej strony.');

            return redirect()->route('LanguageModule::languages.create');
        }

        $contentGroups = $contentGroup->select('_id', 'name')->pluck('name', '_id');

        return view('SitesModule::sites.add', [
            'statuses' => SiteStatus::toArray(),
            'siteTypes' => $siteType->get(['_id', 'name']),
            'contentGroups' => $contentGroups,
        ]);
    }

    /**
     * @param SiteStoreFirstStepRequest $request
     *
     * @return Factory|View
     */
    public function createSecondStep(SiteStoreFirstStepRequest $request)
    {
        $form = StructureManager::getForm(StructureManager::getStructureFromRequest($request));

        return view('SitesModule::sites.add-step2', ["form" => $form, "request" => $request->except('_token')]);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->request->add(['active' => false, 'content' => StructureManager::prepareContent($request)]);

        if ($request->site_type_id) {
            $request->merge(['structure' => null]);
        } else {
            $request->merge(['structure' => json_decode($request->structure)]);
        }

        Site::create($request->all());
        $request->session()->flash('alert-success', 'Strona została pomyślnie utworzona');

        return redirect()->route('SitesModule::sites.create');
    }

    /**
     * @param Site $site
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function clone(Site $site, Request $request)
    {
        $siteClone = $site->replicate(['_id']);
        $siteClone->parent_id = $site->id;
        $siteClone->language_short_name = $request->get('language_short_name');
        $siteClone->active = false;
        $siteClone->save();

        return response()->json([
            'status' => 'success',
            'payload' => route('SitesModule::sites', ['language' => $request->get('language_short_name')]),
        ]);
    }

    /**
     * @param Site $site
     * @param ContentGroup $contentGroup
     * @param SiteType $siteType
     *
     * @return Factory|View
     */
    public function edit(Site $site, ContentGroup $contentGroup, SiteType $siteType)
    {
        $contentGroups = $contentGroup->select('_id', 'name')->pluck('name', '_id');

        return view('SitesModule::sites.edit.first-step', [
            'site' => $site,
            'statuses' => SiteStatus::toArray(),
            'siteTypes' => $siteType->get(['_id', 'name']),
            'contentGroups' => $contentGroups,
            'structure' => $site->structure,
        ]);
    }

    public function editSecondStep(Site $site, SiteUpdateFirstStepRequest $request)
    {
        $form = StructureManager::getForm(StructureManager::getStructureFromRequest($request), $site->content);

        return view('SitesModule::sites.edit.second-step', [
            'site' => $site,
            "form" => $form,
            "request" => $request->except('_token'),
        ]);
    }

    public function update(Site $site, Request $request)
    {
        if ($request->site_type_id) {
            $request->merge(['structure' => null]);
        } else {
            $request->merge(['structure' => json_decode($request->structure)]);
        }

        $content = collect($site->content);

        $content = $content->filter(function($item, $key) {
           return is_array($item);
        });

        $preparedContent = collect(StructureManager::prepareContent($request));

        $preparedContent = $preparedContent->map(function($item) {
           if($item === null) return '';

           return $item;
        });

        $content = $content->merge($preparedContent);

        $request->request->add(['content' => $content->toArray()]);
        $site->update($request->all());

        return redirect()->route('SitesModule::sites');
    }

    /**
     * @param Site $site
     *
     * @return JsonResponse
     */
    public function changeSiteVisibility(Site $site)
    {
        $site->update(['active' => !$site->active]);

        return response()->json([
            'status' => $site->active,
        ]);
    }

    public function checkMissingTranslations(Site $site)
    {
        $allLanguages = Language::where('short_name', '!=', 'pl')->get();
        $missingTranslations = new Collection;

        $siteId = $site->parent_id ?? $site->_id;

        foreach ($allLanguages as $language) {
            $result = $site->where('parent_id', $siteId)->where('language_short_name', $language->short_name)->exists();

            if (!$result) {
                $missingTranslations->put($language->short_name, $language->name);
            }
        }

        return response()->json([
            'status' => 'success',
            'payload' => $missingTranslations->toArray(),
        ]);
    }

    /**
     * @param Site $site
     * @param ContentGroup $contentGroup
     * @param $contentGroupName
     *
     * @return Factory|View
     */
    public function createContentGroup(Site $site, ContentGroup $contentGroup, $contentGroupName)
    {
        if (!$site->hasContentGroup($contentGroupName)) abort(404);

        $form = StructureManager::getForm($contentGroup->structure);

        return view('SitesModule::sites.create-content-group', [
            'form' => $form,
            'site' => $site,
            'contentGroup' => $contentGroup,
            'contentGroupName' => $contentGroupName,
        ]);
    }

    /**
     * @param Request $request
     * @param Site $site
     * @param ContentGroup $contentGroup
     * @param $contentGroupName
     *
     * @return RedirectResponse
     */
    public function storeContentGroup(Request $request, Site $site, ContentGroup $contentGroup, $contentGroupName)
    {
        if (!$site->hasContentGroup($contentGroupName)) abort(404);

        $contentGroupItemName = ContentHelper::dotNotation([$contentGroupName, $request->input('_name')]);;

        if ($site->getContent($contentGroupItemName)) return redirect()->back()->withErrors(['_name' => 'Nazwa musi być unikalna']);

        $site->updateContent($contentGroupItemName, ContentHelper::makeGroupItemContent($request));

        $request->session()->flash('alert-success', 'Zapisano pomyślnie');

        return redirect()->route('SitesModule::sites');
    }

    /**
     * @param Site $site
     * @param ContentGroup $contentGroup
     * @param $contentGroupName
     * @param $contentGroupItemName
     *
     * @return Factory|View
     */
    public function editContentGroupItem(Site $site, ContentGroup $contentGroup, $contentGroupName, $contentGroupItemName)
    {
        $contentString = ContentHelper::dotNotation([$contentGroupName, $contentGroupItemName]);

        if (!$site->hasContent($contentString)) abort(404);

        $content = $site->getContent($contentString);

        $form = StructureManager::getForm($contentGroup->structure, $content);

        return view('SitesModule::sites.edit-content-group-item', [
            'form' => $form,
            'site' => $site,
            'contentGroup' => $contentGroup,
            'contentGroupName' => $contentGroupName,
            'contentGroupItem' => $content,
        ]);
    }

    /**
     * @param Request $request
     * @param Site $site
     * @param ContentGroup $contentGroup
     * @param $contentGroupName
     * @param $contentGroupItemName
     *
     * @return RedirectResponse
     */
    public function updateContentGroupItem(Request $request, Site $site, ContentGroup $contentGroup, $contentGroupName, $contentGroupItemName)
    {
        //dd($request);
        $contentString = ContentHelper::dotNotation([$contentGroupName, $contentGroupItemName]);
        $contentStringFromName = ContentHelper::dotNotation([$contentGroupName, $request->input('_name')]);

        if (!$site->hasContent($contentString)) abort(404);

        if ($request->input('_name') !== $contentGroupItemName) {
            if ($site->getContent($contentStringFromName)) return redirect()->back()->withErrors(['_name' => 'Nazwa musi być unikalna']);
        }

        $site->deleteContent($contentString);
        $site->updateContent($contentStringFromName, ContentHelper::makeGroupItemContent($request));

        $request->session()->flash('alert-success', 'Zapisano pomyślnie');

        return redirect()->route('SitesModule::sites');
    }

    /**
     * @param Request $request
     * @param Site $site
     * @param ContentGroup $contentGroup
     * @param $contentGroupName
     * @param $contentGroupItemName
     *
     * @return JsonResponse
     */
    public function changeContentGroupItemVisibility(Request $request, Site $site, ContentGroup $contentGroup, $contentGroupName, $contentGroupItemName)
    {
        $contentString = ContentHelper::dotNotation([$contentGroupName, $contentGroupItemName]);

        if (!$site->hasContent($contentString)) abort(404);

        $activeString = ContentHelper::dotNotation(['_active'], $contentString);

        $active = $site->getContent($activeString);

        $site->updateContent($activeString, !$active);

        return response()->json([
            'status' => !$active,
        ]);
    }

    /**
     * @param Site $site
     * @param ContentGroup $contentGroup
     * @param $contentGroupName
     *
     * @return Factory|View
     */
    public function changeContentGroupOrder(Site $site, ContentGroup $contentGroup, $contentGroupName)
    {
        $contentString = ContentHelper::dotNotation([$contentGroupName]);

        if (!$site->hasContent($contentString)) abort(404);

        $contentGroupItems = ContentHelper::sortGroupItems($site->getContent($contentString));

        return view('SitesModule::sites.content-group-order', [
            'site' => $site,
            'contentGroup' => $contentGroup,
            'contentGroupName' => $contentGroupName,
            'contentGroupItems' => $contentGroupItems,
        ]);
    }

    /**
     * @param Request $request
     * @param Site $site
     * @param ContentGroup $contentGroup
     * @param $contentGroupName
     */
    public function updateContentGroupOrder(Request $request, Site $site, ContentGroup $contentGroup, $contentGroupName)
    {
        $contentString = ContentHelper::dotNotation([$contentGroupName]);

        if (!$site->hasContent($contentString)) abort(404);

        foreach ($request->orders as $contentItemName => $contentItemOrder) {
            $contentItemString = ContentHelper::dotNotation([$contentItemName, "_order"], $contentString);

            $site->updateContent($contentItemString, $contentItemOrder);
        }
    }
}
