document.getElementById("notify-form").addEventListener("submit", function(e) {
  e.preventDefault();
  const email = document.getElementById("email").value;
  const response = document.getElementById("response");
  response.classList.remove("hidden");
  response.innerText = `Thank you! We'll notify you at ${email} when we launch.`;
  document.getElementById("email").value = "";
});
