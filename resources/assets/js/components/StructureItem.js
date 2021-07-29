import Text from "./structureItems/Text";
import Textarea from "./structureItems/Textarea";
import Image from "./structureItems/Image";


const STRUCTURE_TEMPLATE = `
    <div class="structure-item col-md-12 d-flex structure-content" data-name="%%name%%" data-type="%%type%%">
        <div class="sortable">
            <i class="mdi mdi-sort"></i>
        </div>
        <div class="item-content bg-%%color%% d-flex justify-content-between align-items-center">
            <div class="info">%%name%%</div>
            <div class="actions">
                <i class="mdi mdi-pencil edit-structure-item"></i>
                <i class="mdi mdi-minus remove-structure-item"></i>
            </div>
        </div>
    
    </div>
`;

export const STRUCTURE_ITEMS = new Map([
    [
        'Text',
        Text
    ],
    [
        'Textarea',
        Textarea
    ],
    [
        'Image',
        Image
    ],
]);


class StructureItem {
    constructor(type, name) {
        if (!STRUCTURE_ITEMS.has(type)) {
            return;
        }

        this.name = name;
        this.type = type;
        this.structure = new (STRUCTURE_ITEMS.get(type));
    }

    getTemplate = () => {
        return STRUCTURE_TEMPLATE.split('%%color%%').join(this.structure.getColor()).split('%%name%%').join(this.name).split('%%type%%').join(this.type);
    };

    createElement() {
        const template = this.getTemplate();
        let element = document.createElement('div');

        element.innerHTML = template;

        return element;
    }

    appendTo = (selector) => {
        document.querySelector(selector).appendChild(this.createElement());
    }
}

export default StructureItem;
