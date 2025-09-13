function isAllowedCharacter(keyChar, event) {

    const allowedChars = "abcdefghijklmnopqrstuvwxyz0123456789-_";


    return allowedChars.includes(keyChar) ||
        (event.shiftKey && keyChar === '_');
}

function restrictSpacesforSlug(event) {
    const keyCode = event.which || event.keyCode;
    const keyChar = String.fromCharCode(keyCode).toLowerCase();

    if (keyCode === 32 || !isAllowedCharacter(keyChar, event)) {
        event.preventDefault();
        document.getElementById("removespacesforslug").innerHTML =
            "Special Character and Spaces are not allowed in the slug. <small class='text-success'>you can use <strong>-</strong> and <strong>_</strong> </small>";
    } else {

        document.getElementById("removespacesforslug").innerHTML = "";
    }
}

function restrictSpacesfortags(event) {
    if (event.key === ' ' || event.keyCode === 32) {
        event.preventDefault();
        document.getElementById("removespacesfortags").innerHTML = "Spaces are not allowed in the tags.";
    } else {

        document.getElementById("removespacesfortags").innerHTML = "";
    }

}

function previewMainImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const imagePreview = document.getElementById('mainImagePreview');
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
            imagePreview.style.maxWidth = '30%';
            imagePreview.style.maxHeight = '30%';
            imagePreview.style.objectFit = 'contain';
            imagePreview.style.marginRight = '10px';
            imagePreview.style.border = '1px dotted var(--border-color)';
        };
        reader.readAsDataURL(file);
    }
}


// function generateSlug() {
//     var packageName = document.getElementById('blogSlug').value;
//     var packageSlug = packageName
//         .trim()
//         .toLowerCase()
//         .replace(/[^a-z0-9äöüß]+/g, '-') 
//         .replace(/^-|-$/g, '');

//     document.getElementById('actual_slug').value = packageSlug;
// }


function slugify(text) {
    return text
        .toString()
        .toLowerCase()
        .trim()
        .replace(/[\s\W-]+/g, '-')  // Replace spaces and non-word chars with -
        .replace(/^-+|-+$/g, '');   // Trim leading/trailing dashes
}




document.addEventListener('DOMContentLoaded', function () {
    const slugInput = document.getElementById('blogSlug');
    const actualSlugPreview = document.getElementById('actual_slug');

    if (slugInput && actualSlugPreview) {
        function updateSlugPreview() {
            const cleanSlug = slugify(slugInput.value);
            actualSlugPreview.value = cleanSlug;
        }

        slugInput.addEventListener('input', updateSlugPreview);

        // Initialize once
        updateSlugPreview();
    }

});