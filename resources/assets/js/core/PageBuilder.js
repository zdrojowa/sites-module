import { prepareStructure } from "./Forms";

$(".select").select2({
    language: 'pl'
});

$('select[name="site_type_id"]').trigger('change').on('change', function () {
   if($(this).val() !== "") {
        $("#structure").slideUp();
   }
   else {
       $("#structure").slideDown();
   }
});

$(".to-step-2").click(function (e) {
    e.preventDefault();

    const siteType = $('select[name="site_type_id"]');
    if(siteType.val() === "") {
        const structure = prepareStructure();

        if(structure.length === 0) {
            return;
        }

        $("input[name='structure']").val(JSON.stringify(structure));
    }
    else {
        $("input[name='structure']").val(null);
    }

    $("form.step-1").submit();
});

$(".dropify").dropify({
    messages: {
        'default': 'Przeciągnij tutaj lub kliknij',
        'replace': 'Przeciągnij tutaj lub kliknij aby zmienić',
        'remove':  'Usuń',
        'error':   'Wystąpił błąd.'
    },
    error: {
        'fileExtension': 'Złe rozszerzenie pliku ({{ value }} tylko).',
        'fileSize': 'Wybrany plik jest za duży ({{ value }} maksymalnie).',
    }
});
