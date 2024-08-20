getMonthlyCounts();
getAdsNon();
getAvailableAssets();

document.addEventListener('DOMContentLoaded', function() {
    const datePicker = document.getElementById('date-picker');
    const availableDateText = document.getElementById('available-date');

    function updateDateText(date) {
        const today = new Date();
        const selectedDate = new Date(date);
        
        // Format the selected date to 'AUGUST 1, 2024'
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        const formattedDate = selectedDate.toLocaleDateString('en-US', options).toUpperCase();

        // Compare the selected date with the current date
        if (
            selectedDate.getDate() === today.getDate() &&
            selectedDate.getMonth() === today.getMonth() &&
            selectedDate.getFullYear() === today.getFullYear()
        ) {
            availableDateText.textContent = "Available TODAY";
        } else {
            availableDateText.textContent = `Available ${formattedDate}`;
        }
    }

    // Set the initial value based on the current date
    updateDateText(datePicker.value);

    // Add event listener to update the text when the date changes
    datePicker.addEventListener('change', function() {
        updateDateText(datePicker.value);
        getAvailableAssets();
    });
});



async function getMonthlyCounts() {
    try {
        const response = await fetch("/api/rentals/getmonthlycounts", {
            method: 'get',
            credentials: 'include', 
            headers: {
                'Content-Type': 'application/json'
            },
            // body: JSON.stringify(updateData)
        });
      
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }else{
            const result = await response.json();
       
            updateRentalOverview(result) 
        }

       

    } catch (error) {
        // Handle any errors that occurred during the fetch
        console.error('Error updating item:', error);
    }
}


// async function getAvailableAssets() {
//     try {
//         const response = await fetch("/api/rentals/getavailableassets", {
//             method: 'post',
//             credentials: 'include', 
//             headers: {
//                 'Content-Type': 'application/json'
//             },
//             // body: JSON.stringify(updateData)
//         });
      
//         if (!response.ok) {
//             throw new Error(`HTTP error! status: ${response.status}`);
//         }else{
//             const result = await response.json();
       
//            console.log("Available assets",result)
//         }

       

//     } catch (error) {
//         // Handle any errors that occurred during the fetch
//         console.error('Error updating item:', error);
//     }
// }

async function getAvailableAssets() {
    try {
        const datePicker = document.getElementById('date-picker');
        const response = await fetch("/api/rentals/getavailableassets", {
            method: 'post',
            credentials: 'include', 
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ date: datePicker.value })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        } else {
            const result = await response.json();
           console.log("Available assets",result)

            const listArea = document.querySelector('.list-area');
            listArea.innerHTML = ''; // Clear any existing content

            // Populate the list area with available assets
            result.forEach(item => {
                const assetButton = document.createElement('a');
                assetButton.href = '#';
                assetButton.className = 'btn btn-primary btn-icon-split btn-sm mb-2 mr-2'; // Added mb-2 for vertical spacing
                
                assetButton.innerHTML = `
                    <span class="icon text-white-50">
                        <i class="fas fa-flag"></i>
                    </span>
                    <span class="text">${item}</span>
                `;

                listArea.appendChild(assetButton);
            });
        }

    } catch (error) {
        // Handle any errors that occurred during the fetch
        console.error('Error updating item:', error);
    }
}




async function getCetegoryCounts() {
    try {
        const response = await fetch("/api/rentals/getcategorycounts", {
            method: 'get',
            credentials: 'include', 
            headers: {
                'Content-Type': 'application/json'
            },
            // body: JSON.stringify(updateData)
        });
      
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }else{
            const result = await response.json();
            console.log(result)
           
        }

       

    } catch (error) {
        // Handle any errors that occurred during the fetch
        console.error('Error updating item:', error);
    }
}

async function getAdsNon() {
    try {
        const response = await fetch("/api/rentals/getadscounts", {
            method: 'get',
            credentials: 'include', 
            headers: {
                'Content-Type': 'application/json'
            },
            // body: JSON.stringify(updateData)
        });
      
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }else{
            const result = await response.json();
            pieDate(result)
           
        }

       

    } catch (error) {
        // Handle any errors that occurred during the fetch
        console.error('Error updating item:', error);
    }
}



function updateRentalOverview(data) {
    var ctx = document.getElementById("myAreaChart");

    // Initialize an array with zeros for all months
    var rentalCounts = new Array(12).fill(0);

    // Populate the rentalCounts array with data from the response
    data.forEach(item => {
        var monthIndex = new Date(`${item.month} 1, ${new Date().getFullYear()}`).getMonth();
        rentalCounts[monthIndex] = item.count;
    });

    // Destroy the previous chart instance if it exists to avoid redundancy
    if (window.myLineChart) {
        window.myLineChart.destroy();
    }

    // Create a new chart instance
    window.myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Rentals",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: rentalCounts,
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        beginAtZero: true,
                        precision: 0, // Ensure integer steps
                        callback: function(value) {
                            return Number.isInteger(value) ? value : null;
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                    }
                }
            }
        }
    });
}


function pieDate(data){
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ["ADS", "ORGANIC"],
        datasets: [{
          data: [data.ads_count, data.non_ads_count], // Update with the fetched counts
          backgroundColor: ['#4e73df', '#1cc88a'], // Adjust colors as needed
          hoverBackgroundColor: ['#2e59d9', '#17a673'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: true // Show the legend if you want to display category names
        },
        cutoutPercentage: 80,
      },
    });
}