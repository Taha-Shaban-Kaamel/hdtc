import Tagify from '@yaireo/tagify';
import '@yaireo/tagify/dist/tagify.css';

document.addEventListener('DOMContentLoaded', function() {
    const input = document.querySelector('input[name="tags[]"]');
    const categories = document.querySelector('input[name="categories[]"]');
    const instructors = document.querySelector('input[name="instructors[]"]');
    const roles = document.querySelector('input[name="roles[]"]');
    
    if (roles) {
        console.log(window.roleWhitelist);
        new Tagify(roles, {
            whitelist: window.roleWhitelist,
            maxTags: 10,
            focusable:false ,
            dropdown: {
                maxItems: 20,
                classname: "tags-look",
                enabled: 0, 
                closeOnSelect: false
            }
        });
    }
    if (categories) {
        new Tagify(categories, {
            whitelist: window.categoryWhitelist,
            maxTags: 10,
            focusable:false ,
            dropdown: {
                maxItems: 20,
                classname: "tags-look",
                enabled: 0, 
                closeOnSelect: false
            }
        });
    }
    if (instructors) {
        new Tagify(instructors, {
            whitelist: window.instructorWhitelist,
            maxTags: 10,
            focusable:false ,
            dropdown: {
                maxItems: 20,
                classname: "tags-look",
                enabled: 0, 
                closeOnSelect: false
            }
        });
    }

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