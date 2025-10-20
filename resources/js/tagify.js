import Tagify from '@yaireo/tagify';
import '@yaireo/tagify/dist/tagify.css';

document.addEventListener('DOMContentLoaded', function() {
    const input = document.querySelector('input[name="tags[]"]');
    // const categories = document.querySelector('input[name="categories[]"]');
    // const instructors = document.querySelector('input[name="instructors[]"]');
    // const roles = document.querySelector('input[name="roles[]"]');
    const prerequisiteCourses = document.querySelector('input[name="prerequisite_courses[]"]');
    

    
    // if (roles) {
    //     new Tagify(roles, {
    //         whitelist: window.roleWhitelist,
    //         maxTags: 10,
    //         focusable:false ,
    //         dropdown: {
    //             maxItems: 20,
    //             classname: "tags-look",
    //             enabled: 0, 
    //             closeOnSelect: false
    //         }
    //     });
    // }
    // if (categories) {
    //     new Tagify(categories, {
    //         whitelist: window.categoryWhitelist,
    //         maxTags: 10,
    //         focusable:false ,
    //         dropdown: {
    //             maxItems: 20,
    //             classname: "tags-look",
    //             enabled: 0, 
    //             closeOnSelect: false
    //         }
    //     });
    // }
    // if (instructors) {
    //     new Tagify(instructors, {
    //         whitelist: window.instructorWhitelist,
    //         maxTags: 10,
    //         focusable:false ,
    //         dropdown: {
    //             maxItems: 20,
    //             classname: "tags-look",
    //             enabled: 0, 
    //             closeOnSelect: false
    //         }
    //     });
    // }

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


    if (prerequisiteCourses) {
        // Convert the window.PrerequisiteCourses object to the format Tagify expects
        const tagifyWhitelist = Object.entries(window.PrerequisiteCourses || {}).map(([name, id]) => ({
            id: id,
            value: name
        }));


        const tagify = new Tagify(prerequisiteCourses, {
            tagTextProp: 'value',  // Show this field in the tag
            enforceWhitelist: true,
            whitelist: tagifyWhitelist,
            maxTags: 10,
            dropdown: {
                maxItems: 20,
                classname: "tags-look",
                enabled: 0,  // Show suggestions on focus
                closeOnSelect: false
            }
        });

        tagify.on('add', function(e) {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'prerequisite_course_ids[]';
            hiddenInput.value = e.detail.data.id;
            prerequisiteCourses.parentNode.insertBefore(hiddenInput, prerequisiteCourses.nextSibling);
        });

        tagify.on('remove', function(e) {
            const hiddenInputs = document.querySelectorAll('input[name="prerequisite_course_ids[]"]');
            hiddenInputs.forEach(input => {
                if (input.value === e.detail.data.id) {
                    input.remove();
                }
            });
        });

        if (window.ExistingPrerequisites) {
            const existingTags = window.ExistingPrerequisites.map(id => {
                const course = tagifyWhitelist.find(c => c.id == id);
                return course ? { id: course.id, value: course.value } : null;
            }).filter(Boolean);
            
            if (existingTags.length) {
                tagify.addTags(existingTags);
            }
        }
    } else {
        console.log('Could not find input element with name="prerequisite_courses[]"');
    }
});