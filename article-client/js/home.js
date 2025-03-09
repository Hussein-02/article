//to get questions using api
async function fetchQuestions() {
  try {
    const response = await axios.get(
      "http://15.188.75.137/article/article-server/api/v1/getQuestions.php"
    );
    const data = response.data;
    if (data.success) {
      displayQuestions(data.questions);
    } else {
      console.error("failed to fetch questions");
    }
  } catch (error) {
    console.error("Error fetching questions");
  }
}

//to display the questions as cards
function displayQuestions(questions) {
  const cardsContainer = document.getElementById("question-cards");
  //clear container
  cardsContainer.innerHTML = "";

  questions.forEach((question) => {
    const card = document.createElement("div");
    card.className = "question-card";
    card.innerHTML = `
        <h3>${question.question}</h3>
        <p>${question.answer}</p>`;
    cardsContainer.appendChild(card);
  });
}

//to be used when text is entered in search bar
function filterQuestions() {
  const searchInput = document.querySelector(".search-bar").value.toLowerCase();
  const cards = document.querySelectorAll(".question-card");

  cards.forEach((card) => {
    const questionText = card.querySelector("h3").textContent.toLowerCase();
    const answerText = card.querySelector("p").textContent.toLowerCase();

    if (questionText.includes(searchInput) || answerText.includes(searchInput)) {
      card.style.display = "block";
    } else {
      card.style.display = "none";
    }
  });
}

//to fetch questions when the page loads
window.onload = fetchQuestions;
