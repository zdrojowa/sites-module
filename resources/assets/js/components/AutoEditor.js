require('../ckeditor');
require('../ckeditor_pl');

if(window['ckeditorIds']) {
    ckeditorIds.forEach((id) => {
        ClassicEditor.create(document.getElementById(id), {
            toolbar: ['heading', '|', 'subscript', 'superscript', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'alignment', 'undo', 'redo'],
            language: 'pl'
        })
    })
}
