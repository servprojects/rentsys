
document.addEventListener('DOMContentLoaded', function () {
    const categorySelect = document.getElementById('item_category_id');
    const genericNameSelect = document.getElementById('item_generic_name_id');
    const brandSelect = document.getElementById('item_brand_id');
    const modelInput = document.getElementById('model');
    const descriptionInput = document.getElementById('description');

    function updateDescription() {
        const category = categorySelect.options[categorySelect.selectedIndex].text;
        const genericName = genericNameSelect.options[genericNameSelect.selectedIndex].text;
        const brand = brandSelect.options[brandSelect.selectedIndex].text;
        const model = modelInput.value;
        
        const description = ` ${genericName == 'Select' ? '' : genericName} ${brand== 'Select' ? '' : brand} ${model}`;
        descriptionInput.value = description;
    }

    categorySelect.addEventListener('change', updateDescription);
    genericNameSelect.addEventListener('change', updateDescription);
    brandSelect.addEventListener('change', updateDescription);
    modelInput.addEventListener('input', updateDescription);

    // Initialize the description on page load
    updateDescription();
});

