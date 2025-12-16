
var url = window.location.href;
var domain = url.replace(/^(?:https?:\/\/)?(?:www\.)?/, "");
domain = domain.split("/")[0];


window.onload = function () {
  var canvas = document.getElementById("comment_ip");
  var apiUrl = "https://" + domain + "/wordcloud/ip_comment";

  fetch(apiUrl)
    .then(response => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then(wordArray => {
      console.log(wordArray);
      WordCloud(canvas, {
        list: wordArray,
        gridSize: 18,
        weightFactor: 3,
        rotateRatio: 0.5,
        rotationSteps: 2,
        fontFamily: "Times, serif",
        color: function (word, weight) {
          return weight > 40 ? "#f02222" : "#c09292";
        },
        backgroundColor: "#fff",
        drawOutOfBound: false,
      });
    })
    .catch(error => {
      console.error("There was an error:", error);
    });
};
