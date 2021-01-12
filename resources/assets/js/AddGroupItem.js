import {appendGroup, checkStructure, getGroupTemplate, getSelect} from "./components/helpers/StructureHelpers";

$("#add-group-item").click(function () {
    Swal.mixin({
        confirmButtonText: 'Dalej &rarr;',
        cancelButtonText: 'Anuluj',
        showCancelButton: true,
        progressSteps: ['1', '2']
    }).queue([
        {
            title: 'Wybierz grupe treści',
            input: 'select',
            inputOptions: contentGroups
        },
        {
            title: 'Wprowadź nazwe',
            input: 'text'
        }
    ]).then((result) => {
        if (result.value) {
            if(checkStructure(result.value[1])) {
                appendGroup(result.value[1], result.value[0], '.structure');
            }
        }
    })
});

$(".structure").on('click', '.edit-module-item', function() {
    const item = $(this).closest('.module-item');

    Swal.mixin({
        confirmButtonText: 'Dalej &rarr;',
        cancelButtonText: 'Anuluj',
        showCancelButton: true,
        progressSteps: ['1', '2']
    }).queue([
        {
            title: 'Wybierz grupe treści',
            input: 'select',
            inputOptions: contentGroups,
            inputValue: item.data('id')
        },
        {
            title: 'Wprowadź nazwe',
            input: 'text',
            inputValue: item.data('name')
        }
    ]).then((result) => {
        if (result.value) {
            if(checkStructure(result.value[1], item.data('name'))) {
                item.parent().replaceWith(getGroupTemplate(result.value[1], contentGroups[result.value[0]], result.value[0]));
            }
        }
    })
});

$(".modules").sortable({handle: '.sortable'});
