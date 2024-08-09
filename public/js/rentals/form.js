
document.addEventListener('DOMContentLoaded', () => {
    const assetSelect = document.querySelector('select[name="asset_id"]');
    const pickupDatetimeInput = document.getElementById('expected_pickup_datetime');
    const returnDatetimeInput = document.getElementById('expected_return_datetime');
   
    // Function to fetch conflicts
    async function getConflicts() {
       
        const assetId = assetSelect.value;
        const expectedPickup = pickupDatetimeInput.value;
        const expectedReturn = returnDatetimeInput.value;

        // Validate input
        if (!assetId || !expectedPickup || !expectedReturn) {
            console.warn('Please fill all required fields.');
            return;
        }

        const response = await fetch(`/api/rentals/conflicts`, {
            method: 'POST',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                expected_pickup_datetime: expectedPickup,
                expected_return_datetime: expectedReturn,
                asset_id: assetId
            })
        });
        console.log(response);
        if (response.ok) {
            const data = await response.json();
            console.log(data); // Handle the data as needed
            return data;
        } else {
            console.error('Failed to fetch conflicts');
            return null;
        }
    }

    // Attach event listeners to input fields and dropdown
    assetSelect.addEventListener('change', getConflicts());
    pickupDatetimeInput.addEventListener('change', getConflicts());
    returnDatetimeInput.addEventListener('change', getConflicts());
});
