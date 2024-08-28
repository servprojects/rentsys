
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


$(document).ready(function() {
    // Initialize the selectpicker
    $('#client').selectpicker();

    // Function to populate the client select dropdown
    function populateClients(search = '', page = 1) {
        $.ajax({
            url: `/api/clients/all?page=${page}`,
            method: 'POST',
            data: { search: search },
            success: function(response) {
                const clients = response.data;
                const $clientSelect = $('#client');

                // Clear existing options before adding new ones
                $clientSelect.empty();

                // Add new options
                clients.forEach(function(client) {
                    let person = client.person;
                    let clientText = `${person.first_name} ${person.last_name}`;
                    
                    // Append new option with client ID as the value
                    $clientSelect.append(new Option(clientText, client.id));
                });

                // Refresh the selectpicker
                $clientSelect.selectpicker('refresh');
            },
            error: function() {
                console.log('Error fetching clients');
            }
        });
    }

    // Initially populate with the first page of clients
    populateClients();

    // Handle the selectpicker search input
    $(document).on('input', '.bs-searchbox input', function() {
        let searchTerm = $(this).val();
        populateClients(searchTerm);
    });
});