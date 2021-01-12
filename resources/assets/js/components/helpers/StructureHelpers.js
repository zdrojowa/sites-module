import StructureItem, { STRUCTURE_ITEMS} from "../StructureItem";

export const LEGEND_TEMPLATE = `<div class="badge badge-sm badge-%%color%%">%%name%%</div>`;

export const GROUP_TEMPLATE = `
<div>
    <div class="module-item col-md-12 d-flex structure-content" data-name="%%name%%" data-module-name="%%moduleName%%" data-id="%%id%%">
        <div class="sortable">
            <i class="mdi mdi-sort"></i>
        </div>
        <div class="item-content bg-purple d-flex justify-content-between align-items-center">
            <div class="info">
                <div class="module-name">%%moduleName%%</div>
                <div class="module-item-name">%%name%%</div>
            </div>
            <div class="actions">
                <i class="mdi mdi-pencil edit-module-item"></i>
                <i class="mdi mdi-minus remove-structure-item"></i>
            </div>
        </div>
    
    </div>
</div>    
`;

export function appendGroup(name, id, selector) {
    $(selector).append(getGroupTemplate(name, contentGroups[id], id));
}

export function getSelect() {
    let select = [];

    STRUCTURE_ITEMS.forEach((value, key) => {
        const item = new value();

        select[key] = item.getName();
    });

    return select;
}

export function getGroupTemplate(name, moduleName, id) {
    return GROUP_TEMPLATE.split('%%name%%').join(name).split('%%moduleName%%').join(moduleName).split('%%id%%').join(id);
}

export function getNames() {
    let names = [];

    document.querySelectorAll('.structure-content').forEach((item) => {
        names.push(item.dataset.name);
    });

    return names;
}

export function hasName(name) {
    return getNames().indexOf(name) !== -1
}

export function getType(object) {
    return object.type;
}

export function generateStructure(content) {
    if(content) {
        Object.keys(content).forEach((type) => {
            Object.keys(content[type]).forEach((name) => {
                switch (type) {
                    case "SimpleType":
                        (new StructureItem(content[type][name].value, content[type][name].name)).appendTo('.structure');

                        break;
                    case 'ContentGroup':
                        appendGroup(content[type][name].name, content[type][name].value, '.structure');

                        break;
                }
            })
        });
    }
}

export function checkStructure(name, ignore = null) {
    if (!name) {
        Swal.fire({
            type: "error",
            text: "Nazwa nie może być pusta"
        });

        return false;
    }

    if (hasName(name)) {
        if(name !== ignore) {
            Swal.fire({
                type: "error",
                text: "Podana nazwa jest już zajęta"
            });

            return false;
        }
    }

    return true;
}

export function hasGroupName() {

}
export function generateLegend() {
    let legend = '';

    STRUCTURE_ITEMS.forEach((value, key) => {
        value = new value();
        legend += LEGEND_TEMPLATE.split('%%color%%').join(value.getColor()).split('%%name%%').join(value.getName());
    });

    return legend;
}
