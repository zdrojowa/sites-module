<?php

namespace Selene\Modules\SitesModule\StructureManager;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Selene\Modules\SitesModule\Models\SiteType;
use Selene\Modules\SitesModule\SitesModule;
use stdClass;

/**
 * Class StructureManager
 * @package Selene\Modules\SitesModule\StructureManager
 */
class StructureManager
{

    /**
     * @var mixed
     */
    private $structure;
    /**
     * @var mixed
     */
    private $content;

    /**
     * StructureManager constructor.
     *
     * @param string $structure
     * @param string|null $content
     */
    private function __construct($structure, $content)
    {
        if(is_string($structure)) {
            $structure = json_decode($structure, JSON_OBJECT_AS_ARRAY);
        }

        if(is_string($content)) {
            $content = json_decode($content, JSON_OBJECT_AS_ARRAY);
        }

        $this->structure = $structure;
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function buildForm()
    {
        $form = '';

        if(isset($this->structure['SimpleType'])) {
            foreach ($this->structure['SimpleType'] as $structureItem) {
                $data = [
                    'type' => $structureItem['value'],
                    'name' => $structureItem['name'],
                    'content' => $this->getStructureItemContent($structureItem['name']),
                ];

                $typeClass = SitesModule::getSimpleTypes()[$structureItem['value']];
                $form .= (new $typeClass($data))->getHtml();
            }
        }

        return $form;
    }

    /**
     * @param string $structure
     * @param string|null $content
     *
     * @return string
     */
    public static function getForm($structure, $content = null)
    {
        return (new self($structure, $content))->buildForm();
    }

    /**
     * @param Request $request
     *
     * @return array|string|null
     */
    public static function getStructureFromRequest(Request $request)
    {
        if (!$request->input('structure')) {
            $request->merge(['structure' => json_encode(SiteType::find($request->input('site_type_id'))->structure)]);
        }

        return $request->input('structure');
    }

    /**
     * @param stdClass $structureItem
     *
     * @return bool
     */
    private function isSimpleType(stdClass $structureItem): bool
    {
        return $structureItem->type === 'SimpleType';
    }

    /**
     * @param string $key
     *
     * @return string|null
     */
    private function getStructureItemContent(string $key): ?string
    {
        return $this->content[$key] ?? null;
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public static function prepareContent(Request $request)
    {
        $content = [];

        foreach ($request->all() as $key => $probablyContent) {
            $explodedKey = explode('__', $key);

            if (count($explodedKey) === 1) continue;

            $type = $explodedKey[0];
            $name = $explodedKey[1];
            $value = $probablyContent;

            $typeClass = SitesModule::getSimpleTypes()[$type];

            $name = str_replace('_', ' ', $name);

            array_push($content, $typeClass::handle($name, $value));
        }

        return collect($content)->mapWithKeys(function($key) {
            return $key;
        })->toArray();
    }

}
