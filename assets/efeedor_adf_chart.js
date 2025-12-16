
var url = window.location.href;
var domain = url.replace(/^(?:https?:\/\/)?(?:www\.)?/, "");
domain = domain.split("/")[0];

/*patient_feedback_analysis*/
function patient_feedback_analysis(callback) {
  var xhr = new XMLHttpRequest();
  var apiUrl = "https://" + domain + "/analytics_adf/patient_feedback_analysis"; // Replace with your API endpoint
  xhr.open("GET", apiUrl, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var responseData = JSON.parse(xhr.responseText);
      callback(responseData); // Call the callback function with the API data
    }
  };
  xhr.send();
}

function createChartWithAPIResponse(apiData) {
  var labels = apiData.map(function (item) {
    return item.label_field; // Replace 'label_field' with the actual field name from the API response
  });
  var dataPoints = apiData.map(function (item) {
    return item.data_field; // Replace 'data_field' with the actual field name from the API response
  });

  // Create Chart.js chart
  var ctx = document.getElementById("patient_feedback_analysis").getContext("2d");
  var gradientFill = ctx.createLinearGradient(0, 0, 0, 640);
  gradientFill.addColorStop(0, "rgba(0, 128, 0, 1)"); // Start color (more solid)
  gradientFill.addColorStop(1, "rgba(0, 128, 0, 0.1)"); // End color (more transparent)

  // Create the Chart.js chart with responsive behavior
  var myChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Feedback Parameter Performance chart ( in %)",
          data: dataPoints,
          backgroundColor: gradientFill, // Use the gradient as the background color
          borderColor: "rgba(0, 128, 0, 1)",
          borderWidth: 1,
          pointHoverBackgroundColor: "rgba(0, 165, 0, 0.4)", // Orange color with reduced opacity
          pointHoverBorderColor: "rgba(0, 128, 0, 1)",
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        position: "top",
      },
      tooltips: {
        enabled: true,
        mode: "single",
        callbacks: {
          label: function (tooltipItems, data) {
            var multistringText = [];
            var dataIndex = tooltipItems.index; // Get the index of the hovered data point

            //var psat = data.datasets[tooltipItems.datasetIndex].data[dataIndex];


            var all_detail = apiData[dataIndex].all_detail;

            multistringText.push(all_detail.question);
            multistringText.push("Relative Performance:" + all_detail.data_field + '%');
            multistringText.push("Total Responses:" + all_detail.total_feedback);
            multistringText.push("Worst:" + all_detail.rated_1);
            multistringText.push("Poor:" + all_detail.rated_2);
            multistringText.push("Average:" + all_detail.rated_3);
            multistringText.push("Good:" + all_detail.rated_4);
            multistringText.push("Excellent:" + all_detail.rated_5);



            return multistringText;
          },
        },

      },
      hover: {
        mode: "nearest", // Use 'nearest' to highlight the data point closest to the cursor
        intersect: true, // Allow hovering over multiple data points if they are stacked on each other
      },
      title: {
        display: false,
        text: "Chart",
      },
      scales: {
        yAxes: [
          {
            ticks: {

              min: 0,
              max: 100,
              padding: 25,

              stepSize: 10,
            },
          },
        ],
        xAxes: [
          {
            ticks: {
              autoSkip: false,
            },
          },
        ],
      },
    },
  });
}

// Call the fetchDataFromAPI function and pass the callback function to create the chart
setTimeout(function () {
  patient_feedback_analysis(createChartWithAPIResponse);
}, 1000);
/*patient_feedback_analysis*/

/*patient_feedback_analysis*/
function patient_satisfaction_analysis(callback) {
  var xhr = new XMLHttpRequest();
  var apiUrl = "https://" + domain + "/analytics_adf/patient_satisfaction_analysis"; // Replace with your API endpoint
  xhr.open("GET", apiUrl, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var responseData = JSON.parse(xhr.responseText);
      callback(responseData); // Call the callback function with the API data
    }
  };
  xhr.send();
}

function patientSatisfactionAnalysis(apiData) {
  var labels = apiData.map(function (item) {
    return item.label_field; // Replace 'label_field' with the actual field name from the API response
  });
  var dataPoints = apiData.map(function (item) {
    return item.data_field; // Replace 'data_field' with the actual field name from the API response
  });
  if (dataPoints.length == 1) {

    dataPoints.push(null);
    labels.push(' ');
  }
  // Create Chart.js chart
  var ctx = document
    .getElementById("patient_satisfaction_analysis")
    .getContext("2d");
  ctx.canvas.parentNode.style.width = "100%"; // Set the container width to 100%
  ctx.canvas.parentNode.style.height = "100%";

  // Create a linear gradient fill for the chart

  var gradientFill = ctx.createLinearGradient(0, 0, 0, 400);
  gradientFill.addColorStop(0, "rgba(0, 128, 0, 0.8)"); // Start color
  gradientFill.addColorStop(1, "rgba(0, 128, 0, 0.1)"); // End color (more transparent)


  var myChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Patient Satisfaction Score (in %)",
          data: dataPoints,
          backgroundColor: gradientFill,
          borderColor: "rgba(0, 128, 0, 1)",
          borderWidth: 1,
          pointBackgroundColor: "rgba(0, 128, 0, 1)", // Green color with full opacity
          pointBorderColor: "rgba(0, 128, 0, 1)",
          pointHoverBackgroundColor: "rgba(255, 165, 0, 0.4)", // Orange color with reduced opacity
          pointHoverBorderColor: "rgba(0, 128, 0, 1)",
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
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

            var psat = data.datasets[tooltipItems.datasetIndex].data[dataIndex];
            multistringText.push("Patient Satisfaction Score: " + psat + "%");
            var all_detail = apiData[dataIndex].all_detail;
            multistringText.push("Satisfied Patients: " + all_detail.rating_bar_positive);
            multistringText.push("Unatisfied Patients: " + all_detail.rating_bar_negative);


            return multistringText;
          },
        },

      },
      title: {
        display: false,
        text: "Chart",
      },
      scales: {
        yAxes: [
          {
            ticks: {
              beginAtZero: true,
              min: 0,
              max: 100,
              padding: 25,
              // forces step size to be 5 units
              stepSize: 10,
            },
          },
        ],
        xAxes: [
          {
            ticks: {
              autoSkip: false,
            },
          },
        ],
      },
    },
  });
}

// Call the fetchDataFromAPI function and pass the callback function to create the chart
setTimeout(function () {
  patient_satisfaction_analysis(patientSatisfactionAnalysis);
}, 1000);
/*patient_feedback_analysis*/



/*patient_feedback_analysis*/
function net_permoter_analysis(callback) {
  var xhr = new XMLHttpRequest();
  var apiUrl = "https://" + domain + "/analytics_adf/net_permoter_analysis"; // Replace with your API endpoint
  xhr.open("GET", apiUrl, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var responseData = JSON.parse(xhr.responseText);
      callback(responseData); // Call the callback function with the API data
    }
  };
  xhr.send();
}

function netPermoterAnalysis(apiData) {
  var labels = apiData.map(function (item) {
    return item.label_field;
  });

  var dataPoints = apiData.map(function (item) {
    return item.data_field;
  });
  if (dataPoints.length == 1) {

    dataPoints.push(null);
    labels.push(' ');
  }
  // Create Chart.js chart
  var ctx = document.getElementById("net_permoter_analysis").getContext("2d");
  ctx.canvas.parentNode.style.width = "100%"; // Set the container width to 100%
  ctx.canvas.parentNode.style.height = "100%";

  // Create a linear gradient fill for the chart
  var gradientFill = ctx.createLinearGradient(0, 0, 0, 400);
  gradientFill.addColorStop(0, "rgba(0, 128, 0, 0.8)"); // Start color
  gradientFill.addColorStop(1, "rgba(0, 128, 0, 0.1)"); // End color (more transparent)



  var myChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Net Promoters Score (in %)",
          data: dataPoints,
          backgroundColor: gradientFill,
          borderColor: "rgba(0, 128, 0, 1)",
          borderWidth: 1,
          pointBackgroundColor: "rgba(0, 128, 0, 1)", // Green color with full opacity
          pointBorderColor: "rgba(0, 128, 0, 1)",
          pointHoverBackgroundColor: "rgba(255, 165, 0, 0.4)", // Orange color with reduced opacity
          pointHoverBorderColor: "rgba(0, 128, 0, 1)",
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
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

            var netPromoterScore = data.datasets[tooltipItems.datasetIndex].data[dataIndex];
            multistringText.push("Net Promoter Score: " + netPromoterScore + "%");

            var all_detail = apiData[dataIndex].all_detail;
            multistringText.push("Promoters: " + all_detail.permoter);
            multistringText.push("Passives: " + all_detail.passive);
            multistringText.push("Detractors: " + all_detail.demoter);

            return multistringText;
          },
        },
      },
      hover: {
        mode: "nearest",
        intersect: true,
      },
      scales: {
        xAxes: [
          {
            display: true,
            scaleLabel: {
              display: false,
              labelString: "Month",
            },
          },
        ],
        yAxes: [
          {
            display: true,
            scaleLabel: {
              display: false,
              labelString: "Value",
            },
            ticks: {
              max: 100,
              min: -100,
              padding: 25,
              // forces step size to be 5 units
              stepSize: 20,
            },
          },
        ],
      },
    },
  });
}

// Call the fetchDataFromAPI function and pass the callback function to create the chart
setTimeout(function () {
  net_permoter_analysis(netPermoterAnalysis);
}, 1000);
/*patient_feedback_analysis*/





/*why_patient_choose*/
function why_patient_choose(callback) {
  var xhr = new XMLHttpRequest();
  var apiUrl = "https://" + domain + "/analytics_adf/why_patient_choose"; // Replace with your API endpoint
  xhr.open("GET", apiUrl, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var responseData = JSON.parse(xhr.responseText);
      callback(responseData); // Call the callback function with the API data
    }
  };
  xhr.send();
}

function whyPatientChoose(apiData) {
  var labels = apiData.map(function (item) {
    return item.label_field;
  });
  var dataPoints = apiData.map(function (item) {
    return item.data_field;
  });

  // Create Chart.js chart
  var ctx = document.getElementById("why_patient_choose").getContext("2d");
  ctx.canvas.parentNode.style.width = "100%"; // Set the width to your desired value
  ctx.canvas.parentNode.style.height = "200px"; // Set the height to you

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
    type: "doughnut",
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

            var netPromoterScore = data.datasets[tooltipItems.datasetIndex].data[dataIndex];
            // multistringText.push("Net Promoter Score: " + netPromoterScore + "%");
            // multistringText.push("Net Promoter Score: " + netPromoterScore + "%");

            var all_detail = apiData[dataIndex];
            multistringText.push(all_detail.label_field);
            multistringText.push("Count: " + all_detail.data_field_count);
            // multistringText.push("Detractors: " + all_detail.demoter);

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
setTimeout(function () {
  why_patient_choose(whyPatientChoose);
}, 1000);
/*why_patient_choose*/





/*why_patient_choose*/
function tickets_recived_by_department(callback) {
  var xhr = new XMLHttpRequest();
  var apiUrl = "https://" + domain + "/analytics_adf/tickets_recived_by_department"; // Replace with your API endpoint
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
  ctx.canvas.parentNode.style.width = "100%"; // Set the container width to 100%
  ctx.canvas.parentNode.style.height = "200px";

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
            multistringText.push("Total Tickets: " + all_detail.data_field_count);
            // var all_detail = apiData[dataIndex].all_detail;
            multistringText.push("Open Tickets: " + all_detail.open_tickets);
            if (all_detail.addressed_tickets) {
              multistringText.push(
                "Addressed Tickets: " + all_detail.addressed_tickets
              );
            }
            multistringText.push("Closed Tickets: " + all_detail.closed_tickets);
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
setTimeout(function () {
  tickets_recived_by_department(ticketsRecivedByDepartment);
}, 1000);
/*why_patient_choose*/






function resposnsechart(callback) {
  var xhr = new XMLHttpRequest();
  var apiUrl = "https://" + domain + "/analytics_adf/resposnsechart"; // Replace with your API endpoint
  xhr.open("GET", apiUrl, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var responseData = JSON.parse(xhr.responseText);
      callback(responseData); // Call the callback function with the API data
    }
  };
  xhr.send();
}

function resposnseChart(apiData) {
  var labels = apiData.map(function (item) {
    return item.label_field;
  });

  var dataPoints = apiData.map(function (item) {
    return item.data_field;
  });
  if (dataPoints.length == 1) {

    dataPoints.push(null);
    labels.push(' ');
  }
  // Create Chart.js chart
  var ctx = document.getElementById("resposnsechart").getContext("2d");
  ctx.canvas.parentNode.style.width = "100%"; // Set the container width to 100%
  ctx.canvas.parentNode.style.height = "100%";

  // Create a linear gradient fill for the chart
  var gradientFill = ctx.createLinearGradient(0, 0, 0, 400);
  gradientFill.addColorStop(0, "rgba(0, 128, 0, 0.8)"); // Start color
  gradientFill.addColorStop(1, "rgba(0, 128, 0, 0.1)"); // End color (more transparent)



  var myChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Feedback/Responses Analysis",
          data: dataPoints,
          backgroundColor: gradientFill,
          borderColor: "rgba(0, 128, 0, 1)",
          borderWidth: 1,
          pointBackgroundColor: "rgba(0, 128, 0, 1)", // Green color with full opacity
          pointBorderColor: "rgba(0, 128, 0, 1)",
          pointHoverBackgroundColor: "rgba(255, 165, 0, 0.4)", // Orange color with reduced opacity
          pointHoverBorderColor: "rgba(0, 128, 0, 1)",
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
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
            var all_detail = apiData[dataIndex].all_detail;
            multistringText.push("Feedbacks Collected: " + all_detail.count);
            return multistringText;
          },
        },
      },
      hover: {
        mode: "nearest",
        intersect: true,
      },
      scales: {
        xAxes: [
          {
            display: true,
            scaleLabel: {
              display: false,
              labelString: "Month",
            },
          },
        ],
        yAxes: [
          {
            display: true,
            scaleLabel: {
              display: false,
              labelString: "Value",
            },
            ticks: {
              max: 100,
              min: 0,
              padding: 25,
              // forces step size to be 5 units
              stepSize: 20,
            },
          },
        ],
      },
    },
  });
}

// Call the fetchDataFromAPI function and pass the callback function to create the chart
setTimeout(function () {
  resposnsechart(resposnseChart);
}, 1000);
/*patient_feedback_analysis*/

