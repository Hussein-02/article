document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("#signupForm");

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    const fullname = document.getElementById("fullname").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    try {
      const response = await axios.post(
        "http://15.188.75.137/article/article-server/api/v1/signup.php",
        {
          fullname: fullname,
          email: email,
          password: password,
        },
        {
          headers: {
            "Content-Type": "application/json",
          },
        }
      );

      if (response.data.success) {
        const token = response.data.token;
        localStorage.setItem("token", token);

        window.location.href = "/article/article-client/home.html";
      } else {
        alert(response.data.message);
      }
    } catch (error) {
      console.error("Error:", error);
    }
  });
});
