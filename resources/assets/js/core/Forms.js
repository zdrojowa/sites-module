import {generateLegend, generateStructure, getSelect, hasName} from "../components/helpers/StructureHelpers";
import StructureItem from "../components/StructureItem";

$(".structure").sortable({handle: '.sortable'}).on("click", ".remove-structure-item", function () {
    $(this).closest('.structure-content').parent().remove();
});

$(".structure").on("click", ".edit-structure-item", function () {
    const item = $(this).closest('.structure-item');

    Swal.mixin({
        confirmButtonText: 'Dalej &rarr;',
        cancelButtonText: 'Anuluj',
        showCancelButton: true,
        progressSteps: ['1', '2']
    }).queue([
        {
            title: 'Wybierz typ',
            input: 'select',
            inputOptions: getSelect(),
            inputValue: item.data('type')
        },
        {
            title: 'Wprowadź nazwe',
            input: 'text',
            inputValue: item.data('name')
        }
    ]).then((result) => {
        if (result.value) {
            item.parent().replaceWith(renderStructure(result.value[0], result.value[1], item.data('name'), true));
        }
    })
});

$("#add-item-structure").click(function () {
    Swal.mixin({
        confirmButtonText: 'Dalej &rarr;',
        cancelButtonText: 'Anuluj',
        showCancelButton: true,
        progressSteps: ['1', '2']
    }).queue([
        {
            title: 'Wybierz typ',
            input: 'select',
            inputOptions: getSelect()
        },
        {
            title: 'Wprowadź nazwe',
            input: 'text'
        }
    ]).then((result) => {
        if (result.value) {
            renderStructure(result.value[0], result.value[1]);
        }
    })
});

function renderStructure(type, name, ignore = null, getElement = false) {
    if (!name) {
        Swal.fire({
            type: "error",
            text: "Nazwa nie może być pusta"
        });

        return;
    }

    if (hasName(name)) {
        if(name !== ignore) {
            Swal.fire({
                type: "error",
                text: "Podana nazwa jest już zajęta"
            });

            return;
        }
    }

    const item = new StructureItem(type, name);

    if (!getElement) {
        item.appendTo('.structure');
    } else {
        return item.createElement();
    }
}


$(".save-button").click(function (e) {
    e.preventDefault();

    $("input[name='structure']").val(JSON.stringify(prepareStructure()));
    $("form.content-type-form").submit();
});

export function prepareStructure() {
    let structure = {};

    $(".structure-content").each(function () {
        if($(this).hasClass('structure-item')) {
            let object = {};

            object.type = 'SimpleType';
            object.value = $(this).data('type');
            object.name = $(this).data('name');

            if(!structure[object.type]) {
                structure[object.type] = {}
            }

            structure[object.type][object.name] = object;
        }
        else if($(this).hasClass('module-item')) {
            let object = {};

            object.type = 'ContentGroup';
            object.value = $(this).data('id');
            object.name = $(this).data('name');

            if(!structure[object.type]) {
                structure[object.type] = {}
            }

            structure[object.type][object.name] = object;
        }
    });

    return structure;
}

if(typeof structure !== 'undefined') {
    generateStructure(structure);
}
$(".legend").append(generateLegend());
