document.getElementById("registrationForm").addEventListener("submit", function (e) {
  e.preventDefault();

  let isValid = true;

  const get = (id) => document.getElementById(id);
  const name = get("regFullname").value;
  const email = get("regEmail").value.trim();
  const password = get("regPassword").value;
  const cPassword = get("regcPassword").value;
  const location = get("Location").value;
  const zip = get("Zip").value.trim();
  const city = get("LOPcity").value;
  const termsChecked = get("checkbox").checked;

  const fields = [
    ["regFullname", "nameError"],
    ["regEmail", "emailError"],
    ["regPassword", "passwordError"],
    ["regcPassword", "cPasswordError"],
    ["Location", "locationError"],
    ["Zip", "zipError"],
    ["LOPcity", "cityError"]
  ];

  fields.forEach(([inputId, errorId]) => {
    get(inputId).classList.remove("input-error");
    get(errorId).textContent = "";
  });
  get("termsError").textContent = "";

  const emailRegex = /^\d{2}-\d{5}-\d@student\.aiub\.edu$/;
  const zipRegex = /^\d{4}$/;

  if (!name) {
    get("nameError").textContent = "Name is required.";
    get("regFullname").classList.add("input-error");
    isValid = false;
  } else if (/^\s/.test(name) || /^[^A-Za-z]+/.test(name) || /\s{2,}/.test(name) || !/^[A-Za-z]+(?:\s[A-Za-z]+)*$/.test(name)) {
    get("nameError").textContent = "Invalid name format.";
    get("regFullname").classList.add("input-error");
    isValid = false;
  }

  if (!email || !emailRegex.test(email)) {
    get("emailError").textContent = "Use format: YY-XXXXX-Z@student.aiub.edu";
    get("regEmail").classList.add("input-error");
    isValid = false;
  }

  if (!password || password.length < 8) {
    get("passwordError").textContent = "Password must be at least 8 characters.";
    get("regPassword").classList.add("input-error");
    isValid = false;
  }

  if (!cPassword || cPassword !== password) {
    get("cPasswordError").textContent = "Passwords do not match.";
    get("regcPassword").classList.add("input-error");
    isValid = false;
  }

  if (!location) {
    get("locationError").textContent = "Location is required.";
    get("Location").classList.add("input-error");
    isValid = false;
  }

  if (!zip || !zipRegex.test(zip)) {
    get("zipError").textContent = "Zip must be 4 digits.";
    get("Zip").classList.add("input-error");
    isValid = false;
  }

  if (!city) {
    get("cityError").textContent = "Select a city.";
    get("LOPcity").classList.add("input-error");
    isValid = false;
  }

  if (!termsChecked) {
    get("termsError").textContent = "You must agree.";
    isValid = false;
  }

  if (!isValid) return;

  const successBox = document.createElement("div");
  successBox.textContent = "✅ Registration Successful!";
  successBox.style.backgroundColor = "#d4edda";
  successBox.style.color = "#155724";
  successBox.style.padding = "10px";
  successBox.style.border = "1px solid #c3e6cb";
  successBox.style.borderRadius = "5px";
  successBox.style.marginTop = "15px";
  successBox.style.textAlign = "center";

  const form = document.getElementById("registrationForm");
  form.insertAdjacentElement("afterend", successBox);

  setTimeout(() => {
    successBox.remove();
  }, 5000);

  form.reset();
});
