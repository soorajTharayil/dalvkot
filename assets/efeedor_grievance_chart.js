var url = window.location.href;
var domain = url.replace(/^(?:https?:\/\/)?(?:www\.)?/, "");
domain = domain.split("/")[0];



/*why_patient_choose*/
function tickets_recived_by_department(callback) {
  var xhr = new XMLHttpRequest();
  var apiUrl = "https://" + domain + "/analytics_grievance/tickets_recived_by_department"; // Replace with your API endpoint
  xhr.open("GET", apiUrl, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var responseData = JSON.parse(xhr.responseText);
      callback(responseData); // Call the callback function with the API data
    }
  };
  xhr.send();
}

function ticketsRecivedByDepartment(apiData) {
  var labels = apiData.map(function (item) {
    return item.label_field;
  });
  var dataPoints = apiData.map(function (item) {
    return item.data_field;
  });

  // Create Chart.js chart
  var ctx = document.getElementById("tickets_recived_by_department").getContext("2d");
  //ctx.canvas.parentNode.style.width = "100%"; // Set the container width to 100%
  //ctx.canvas.parentNode.style.height = "200px";

  // Define an array of colors for each section of the pie chart
  var colors = [
    "rgba(255, 99, 132, 1)",
    "rgba(255, 159, 64, 1)",
    "rgba(255, 255, 0, 1)",
    "rgba(55, 160, 0, 1)",
    "rgba(54, 162, 235, 1)",
    "rgba(153, 102, 255, 1)",
    "rgba(201, 203, 207, 1)",
    "rgba(128, 128, 0, 1)",
    "rgba(77, 201, 246, 1)",
    "rgba(246, 112, 25, 1)",
    "rgba(245, 55, 148, 1)",
    "rgba(88, 89, 91, 1)",
    "rgba(133, 73, 186, 1)",
    "rgba(240, 230, 140, 1)",
  ];




  // Create the Chart.js chart
  var myChart = new Chart(ctx, {
    type: "pie",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Net Promoters Rate (in %)",
          data: dataPoints,
          backgroundColor: colors,
          borderColor: "rgba(0, 128, 0, 1)",
          borderWidth: 0,
          pointBackgroundColor: "rgba(0, 128, 0, 1)", // Green color with full opacity
          pointBorderColor: "rgba(0, 128, 0, 1)",
          pointHoverBackgroundColor: "rgba(255, 165, 0, 0.4)", // Orange color with reduced opacity
          pointHoverBorderColor: "rgba(0, 128, 0, 1)",
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      title: {
        display: false,
        text: "Chart.js Line Chart",
      },
      tooltips: {
        enabled: true,
        mode: "single",
        callbacks: {
          label: function (tooltipItems, data) {
            var multistringText = [];
            var dataIndex = tooltipItems.index; // Get the index of the hovered data point


            var all_detail = apiData[dataIndex];
            multistringText.push(all_detail.label_field);
            multistringText.push("Total Grievances: " + all_detail.data_field_count);
            multistringText.push("Open Grievances: " + all_detail.open_tickets);
            if (all_detail.addressed_tickets) {
              multistringText.push(
                "Addressed Grievances: " + all_detail.addressed_tickets
              );
            }
            multistringText.push("Closed Grievances: " + all_detail.closed_tickets);
            multistringText.push("Resolution Rate: " + all_detail.tr_rate + "%");

            return multistringText;
          },
        },
      },
      hover: {
        mode: "nearest",
        intersect: true,
      },
    },
  });
}

// Example usage with your provided apiData
// whyPatientChoose(apiData);


// Call the fetchDataFromAPI function and pass the callback function to create the chart
tickets_recived_by_department(ticketsRecivedByDepartment);
/*why_patient_choose*/