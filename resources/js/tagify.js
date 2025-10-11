import Tagify from '@yaireo/tagify';
import '@yaireo/tagify/dist/tagify.css';

document.addEventListener('DOMContentLoaded', function() {
    const input = document.querySelector('input[name="tags[]"]');
    const categories = document.querySelector('input[name="categories[]"]');
    const instructors = document.querySelector('input[name="instructors[]"]');
    
    if (categories) {
        const categoryInput = new Tagify(categories, {
            whitelist: window.categoryWhitelist,
            enforceWhitelist: true,
            maxTags: 10,
            dropdown: {
                maxItems: 20,
                classname: "tags-look",
                enabled: 1,
                closeOnSelect: false,
                searchKeys: ['name', 'value']
            },
            tagTextProp: 'value',
            templates: {
                dropdownItem: function(tagData) {
                    return `${tagData.value || tagData.name}`;
                }
            }
        });

        // Parse initial values if they exist
        if (categories.value) {
            try {
                const initialValues = JSON.parse(categories.value);
                categoryInput.addTags(initialValues);
            } catch (e) {
                console.error('Error parsing initial categories:', e);
            }
        }
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