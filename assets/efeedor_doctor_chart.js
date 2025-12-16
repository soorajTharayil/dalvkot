var url = window.location.href;
var domain = url.replace(/^(?:https?:\/\/)?(?:www\.)?/, "");
domain = domain.split("/")[0];

/*patient_feedback_analysis*/
function patient_feedback_analysis(callback) {
  var xhr = new XMLHttpRequest();
  var apiUrl = "https://" + domain + "/analytics_doctor/patient_feedback_analysis"; // Replace with your API endpoint
  xhr.open("GET", apiUrl, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var responseData = JSON.parse(xhr.responseText);
      callback(responseData); // Call the callback function with the API data
    }
  };
  xhr.send();
}
let ebook_ip_bar = '';

function createChartWithAPIResponse(apiData) {
 
  var labels = apiData.map(function (item) {
    return item.label_field; // Replace 'label_field' with the actual field name from the API response
  });
  var dataPoints = apiData.map(function (item) {
    return item.data_field; // Replace 'data_field' with the actual field name from the API response
  });

  // Create Chart.js chart
  var ctx = document
    .getElementById("patient_feedback_analysis")
    .getContext("2d");
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
      onClick: function (event, elements) {
        if (elements.length) {
          // Use elements[0].index to get the index of the clicked bar in newer Chart.js versions
          var firstElementIndex = elements[0]._index;
      
          // Retrieve the data associated with the clicked bar
         
          var clickedData = apiData[firstElementIndex];
          
          // Redirect to the desired URL using the clicked data
          handleBarClick(clickedData);
        }
      },
      
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
            multistringText.push(
              "Relative Performance:" + all_detail.data_field + "%"
            );
            multistringText.push(
              "Total Responses:" + all_detail.total_feedback
            );
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



  setTimeout(function () {
    var url = myChart.toBase64Image();
    // ip_hospital_selection = url;
    type = "ebook_ip_bar";
    handleRequest(url, type);
    // var ip_hospital_selection = url;

  }, 2000);
}

function handleBarClick(clickData) {
  console.log(clickData);
  var url = "https://" + domain + "/doctor/trend_analytic/" + clickData.type;
  window.location = url;

}

// Call the fetchDataFromAPI function and pass the callback function to create the chart
setTimeout(function () {
  patient_feedback_analysis(createChartWithAPIResponse);
}, 1000);
/*patient_feedback_analysis*/

/*patient_feedback_analysis*/
function patient_satisfaction_analysis(callback) {
  var xhr = new XMLHttpRequest();
  var apiUrl = "https://" + domain + "/analytics_doctor/patient_satisfaction_analysis"; // Replace with your API endpoint
  xhr.open("GET", apiUrl, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var responseData = JSON.parse(xhr.responseText);
      callback(responseData); // Call the callback function with the API data
    }
  };
  xhr.send();
}

let ebook_ip_psat = '';

function patientSatisfactionAnalysis(apiData) {
  var labels = apiData.map(function (item) {
    return item.label_field; // Replace 'label_field' with the actual field name from the API response
  });
  var dataPoints = apiData.map(function (item) {
    return item.data_field; // Replace 'data_field' with the actual field name from the API response
  });
  if (dataPoints.length == 1) {
    dataPoints.push(null);
    labels.push(" ");
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
          label: "Doctor Satisfaction Score (in %)",
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
            multistringText.push("Doctors Satisfaction Score: " + psat + "%");
            var all_detail = apiData[dataIndex].all_detail;
            multistringText.push(
              "Satisfied Feedbacks: " + all_detail.rating_bar_positive
            );
            multistringText.push(
              "Unatisfied Feedbacks: " + all_detail.rating_bar_negative
            );

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
  setTimeout(function () {
    var url = myChart.toBase64Image();
    // ebook_ip_psat = url;
    type = "ebook_ip_psat";

    handleRequest(url, type);
  }, 2000);


}

// Call the fetchDataFromAPI function and pass the callback function to create the chart
setTimeout(function () {
  patient_satisfaction_analysis(patientSatisfactionAnalysis);
}, 1000);
/*patient_feedback_analysis*/

/*patient_feedback_analysis*/
function net_permoter_analysis(callback) {
  var xhr = new XMLHttpRequest();
  var apiUrl = "https://" + domain + "/analytics_doctor/net_permoter_analysis"; // Replace with your API endpoint
  xhr.open("GET", apiUrl, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var responseData = JSON.parse(xhr.responseText);
      callback(responseData); // Call the callback function with the API data
    }
  };
  xhr.send();
}

let ebook_ip_nps = '';

function netPermoterAnalysis(apiData) {
  var labels = apiData.map(function (item) {
    return item.label_field;
  });

  var dataPoints = apiData.map(function (item) {
    return item.data_field;
  });
  if (dataPoints.length == 1) {
    dataPoints.push(null);
    labels.push(" ");
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

            var netPromoterScore =
              data.datasets[tooltipItems.datasetIndex].data[dataIndex];
            multistringText.push(
              "Net Promoter Score: " + netPromoterScore + "%"
            );

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
  setTimeout(function () {
    var url = myChart.toBase64Image();
    // ip_hospital_selection = url;
    type = "ebook_ip_nps";
    handleRequest(url, type);

  }, 2000);
}

// Call the fetchDataFromAPI function and pass the callback function to create the chart
setTimeout(function () {
  net_permoter_analysis(netPermoterAnalysis);
}, 1000);
/*patient_feedback_analysis*/

/*why_patient_choose*/
function why_patient_choose(callback) {
  var xhr = new XMLHttpRequest();
  var apiUrl = "https://" + domain + "/analytics_doctor/why_patient_choose"; // Replace with your API endpoint
  xhr.open("GET", apiUrl, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var responseData = JSON.parse(xhr.responseText);
      callback(responseData); // Call the callback function with the API data
    }
  };
  xhr.send();
}

let ip_hospital_selection = '';

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
  setTimeout(function () {
    var url = myChart.toBase64Image();
    // ip_hospital_selection = url;
    type = "ip_hospital_selection";
    handleRequest(url, type);

  }, 2000);


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
  var apiUrl = "https://" + domain + "/analytics_doctor/tickets_recived_by_department"; // Replace with your API endpoint
  xhr.open("GET", apiUrl, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var responseData = JSON.parse(xhr.responseText);
      callback(responseData); // Call the callback function with the API data
    }
  };
  xhr.send();
}

let ebook_ip_tickets = '';

function ticketsRecivedByDepartment(apiData) {
  var labels = apiData.map(function (item) {
    return item.label_field;
  });
  var dataPoints = apiData.map(function (item) {
    return item.data_field;
  });

  // Create Chart.js chart
  var ctx = document
    .getElementById("tickets_recived_by_department")
    .getContext("2d");
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
            multistringText.push(
              "Total Tickets: " + all_detail.data_field_count
            );
            // var all_detail = apiData[dataIndex].all_detail;
            multistringText.push("Open Tickets: " + all_detail.open_tickets);
            if (all_detail.addressed_tickets) {
              multistringText.push(
                "Addressed Tickets: " + all_detail.addressed_tickets
              );
            }
            multistringText.push(
              "Closed Tickets: " + all_detail.closed_tickets
            );
            multistringText.push(
              "Resolution Rate: " + all_detail.tr_rate + "%"
            );

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

  setTimeout(function () {
    var url = myChart.toBase64Image();
    // ip_hospital_selection = url;
    type = "ebook_ip_tickets";
    handleRequest(url, type);

  }, 2000);

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
  var apiUrl = "https://" + domain + "/analytics_doctor/resposnsechart"; // Replace with your API endpoint
  xhr.open("GET", apiUrl, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var responseData = JSON.parse(xhr.responseText);
      callback(responseData); // Call the callback function with the API data
    }
  };
  xhr.send();
}
let ip_response_chart = '';


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



  // Create a linear gradient fill for the chart
  var gradientFill = ctx.createLinearGradient(0, 0, 0, 400);
  gradientFill.addColorStop(0, "rgba(0, 128, 0, 0.8)"); // Start color
  gradientFill.addColorStop(1, "rgba(0, 128, 0, 0.1)"); // End color (more transparent)
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
          label: "Feedback/Response Analysis",
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
  setTimeout(function () {
    var url = myChart.toBase64Image();
    // ip_hospital_selection = url;
    type = "ip_response_chart";
    handleRequest(url, type);
  }, 2000);
}

// Call the fetchDataFromAPI function and pass the callback function to create the chart
setTimeout(function () {
  resposnsechart(resposnseChart);
}, 1000);
/*patient_feedback_analysis*/


// wordcloud chart
/*
document.addEventListener("DOMContentLoaded", function () {
  // Initial call to render the WordCloud
  // renderWordCloud();

  const dropdownButton = document.getElementById("dropdownButton");
  const wordcloudDropdown = document.getElementById("wordcloudDropdown");

  wordcloudDropdown.addEventListener("change", function () {
    renderWordCloud(this.value);
  });

  document
    .querySelectorAll("#wordcloudDropdown .dropdown-item")
    .forEach(function (item) {
      item.addEventListener("click", function (e) {
        e.preventDefault(); // prevent the default link click action
        handleDropdownChange(this.getAttribute("data-value"));

        updateDropdownDisplay(
          this.textContent,
          this.getAttribute("data-value")
        );
      });
    });

  document
    .getElementById("wordcloudDropdown")
    .addEventListener("change", function () {
      renderWordCloud(this.value);
    });

  // function updateDropdownDisplay(text, value) {
  //   // var dropdownButton = document.getElementById("dropdownButton");
  //   // dropdownButton.innerHTML =
  //   //   text +
  //   //   ' <i class="fa fa-angle-down" aria-hidden="true" style="margin-right:0px;"></i>';
  //   // renderWordCloud(value);
  //   $("#dropdownButton").html("HI");
  //   alert(1);
  // }

  function handleDropdownChange(value) {
    if (value) {
      var url = " https://" + domain + "/ipd/comments?set=" + value;
      window.location.href = url;
      //renderWordCloud(value);
    } else {
      // https://" + domain + "/ipd/comments";
      var url = " https://" + domain + "/ipd/comments";
      window.location.href = url;

      renderWordCloud();
    }
  }
});

var wordsPositions = [];

function renderWordCloud(type = null) {
  var canvas = document.getElementById("comment_ip");
  var ctx = canvas.getContext("2d");
  var apiUrlBase = "https://" + domain + "/wordcloud/ip_comment";
  var apiUrl = type ? `${apiUrlBase}?set=${type}` : apiUrlBase;
  var fontSize = 20;

  fetch(apiUrl)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then((wordArray) => {
      wordArray = wordArray.sort((a, b) => b.count - a.count).slice(0, 25);
      console.log(wordArray);
      WordCloud(canvas, {
        list: wordArray,
        gridSize: 18,
        weightFactor: 3,
        fontFamily: "Times, serif",
        // color: function (word, weight) {
        //   if (weight > 500) {
        //     return "#f02222"; // Red for weights above 50
        //   } else if (weight > 400) {
        //     return "#f06522"; // Orange for weights between 41 and 50
        //   } else if (weight > 300) {
        //     return "#f0a322"; // Gold for weights between 31 and 40
        //   } else if (weight > 200) {
        //     return "#f0df22"; // Yellow for weights between 21 and 30
        //   } else if (weight > 100) {
        //     return "#92c092"; // Light green for weights between 11 and 20
        //   } else {
        //     return "#c09292"; // Default color for weights 10 and below
        //   }
        // },

        color: function (word) {
          // Array of 10 predefined colors
          var colors = [
            "#f02222", // Red
            "#f06522", // Orange
            "#f0a322", // Gold
            "#f0df22", // Yellow
            "#92c092", // Light green
            "#c09292", // Default color
            "#6200ea", // Indigo
            "#03dac6", // Teal
            "#bb86fc", // Purple
            "#3700b3", // Dark blue
          ];

          // Select a random color from the array for each word
          var randomColor = colors[Math.floor(Math.random() * colors.length)];
          return randomColor;
        },
        backgroundColor: "#fff",
        drawOutOfBound: false,
      });

      // Approximate word positions after generating the WordCloud
      wordsPositions = wordArray.map((word) => {
        return {
          word: word[0],
          count: word[1],
          width: ctx.measureText(word[0]).width,
          height: fontSize,
        };
      });

      var allWords = wordsPositions
        .map((wordPosition) => `${wordPosition.word}-${wordPosition.count}`)
        .join("&#160;&#160;&#160;");
      document.getElementById("wordLabel").innerHTML = allWords;
      document.getElementById("wordLabel").style.display = "block";
      document.getElementById("wordLabel").style.fontFamily =
        "Helvetica Neue, Helvetica, sans-serif";
      document.getElementById("wordLabel").style.fontSize = "15px";
      // document.getElementById("wordLabel").style.textAlign = "center";
      document.getElementById("wordLabel").style.marginTop = "5px";
      document.getElementById("wordLabel").style.marginBottom = "5px";
      document.getElementById("wordLabel").style.marginLeft = "5px";
      document.getElementById("wordLabel").style.marginRight = "5px";
    })
    .catch((error) => {
      console.error("There was an error:", error);
    });
}

var queryStr = window.location.search;

var SET = queryStr.substr(1).split("=");
if (SET.length > 1) {
  renderWordCloud(SET[1]);
  document
    .querySelectorAll("#wordcloudDropdown .dropdown-item")
    .forEach(function (item) {
      // console.log(item);
      // console.log(item.getAttribute("data-value"));
      if (SET[1] == item.getAttribute("data-value")) {
        $("#dropdownButton").html(
          item.textContent +
          ' <i class="fa fa-angle-down" aria-hidden="true" style="margin-right:0px;"></i>'
        );
      }
    });
} else {
  renderWordCloud();
}
*/


// function load_ip_hospital_selection(url) {
//   console.log(url);
//   console.log(ip_hospital_selection);
//   var xhr = new XMLHttpRequest();
//   xhr.open("POST", "https://" + domain + "/process_image.php", true);
//   xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//   xhr.onreadystatechange = function () {
//     if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
//       console.log("Response from server: " + this.responseText);
//     }
//   }
//   xhr.send("ip_hospital_selection=" + encodeURIComponent(ip_hospital_selection));
// }

// function load_ebook_ip_psat(url) {
//   console.log(url);
//   console.log(ebook_ip_psat);
//   var xhr = new XMLHttpRequest();
//     xhr.open("POST", "https://" + domain+"/process_image.php", true);
//     xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//     xhr.onreadystatechange = function() {
//         if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
//             console.log("Response from server: " + this.responseText);
//         }
//     }
//     xhr.send("ebook_ip_psat=" + encodeURIComponent(ebook_ip_psat));
//   }


function handleRequest(url, type) {
  console.log(type);

  // Send one request with all image data
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "https://" + domain + "/process_image.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      console.log("Response from server: " + this.responseText);
    }
  }
  xhr.send(type + '=' + encodeURIComponent(url));
};
