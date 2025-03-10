document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("#questionForm");

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    const question = document.getElementById("question").value;
    const answer = document.getElementById("answer").value;
    try {
      const response = await axios.post(
        "http://localhost/article/article-server/api/v1/addQuestion.php",
        {
          question: question,
          answer: answer,
        },
        {
          headers: {
            "Content-Type": "application/json",
          },
        }
      );

      if (response.data.success) {
        window.location.href = "./home.html";
      } else {
        alert(response.data.message);
      }
    } catch (error) {
      console.error("There wan an error!", error);
      alert("Login failed. Please try again.");
    }
  });
});
