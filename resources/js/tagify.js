import Tagify from '@yaireo/tagify';
import '@yaireo/tagify/dist/tagify.css';

document.addEventListener('DOMContentLoaded', function() {
    const input = document.querySelector('input[name="tags[]"]');
    const instructors = document.querySelector('input[name="tags2[]"]');
    
    if (input) {
        new Tagify(input, {
            whitelist: window.tagWhitelist,
            maxTags: 10,
            focusable:false ,
            dropdown: {
                maxItems: 20,
                classname: "tags-look",
                enabled: 0, 
                closeOnSelect: false
            }
        });
    } else {
        console.error('Could not find input element with name="tags[]"');
    }
});