document.getElementById("registrationForm").addEventListener("submit", function (e) {
    e.preventDefault();
  
    let isValid = true;
  
    const name = document.getElementById("regFullname").value.trim();
    const email = document.getElementById("regEmail").value.trim();
    const password = document.getElementById("regPassword").value;
    const cPassword = document.getElementById("regcPassword").value;
    const location = document.getElementById("Location").value.trim();
    const zip = document.getElementById("Zip").value.trim();
    const city = document.getElementById("LOPcity").value;
    const termsChecked = document.getElementById("checkbox").checked;
  
    const nameRegex = /^[A-Za-z\s]+$/;
    const emailRegex = /^\d{2}-\d{5}-\d@student\.aiub\.edu$/;
    const zipRegex = /^\d{4}$/;
  
    if (!name || !email || !password || !cPassword || !location || !zip || !city) {
      alert("All fields must be filled.");
      return;
    }
  
    if (!nameRegex.test(name)) {
      alert("Name should not contain special characters or numbers.");
      return;
    }
  
    if (!email) {
      alert('Please enter an email.');
      isValid = false;
    } else if (!emailRegex.test(email)) {
      alert('Email must follow this format: YY-XXXXX-Z@student.aiub.edu');
      isValid = false;
    }
  
    if (!password) {
      alert('Please enter a password.');
      isValid = false;
    } else if (password.length < 8) {
      alert('Password must be at least 8 characters long.');
      isValid = false;
    }
  
    if (!cPassword) {
      alert('Please confirm your password.');
      isValid = false;
    } else if (password !== cPassword) {
      alert('Passwords do not match.');
      isValid = false;
    }
  
    if (!zipRegex.test(zip)) {
      alert("Zip code must be exactly 4 digits.");
      return;
    }
  
    if (!termsChecked) {
      alert("You must agree to the Terms and Conditions.");
      return;
    }
  
    if (!isValid) {
      return;
    }
  
    console.log('Full Name:', name);
    console.log('Email:', email);
    console.log('Location:', location);
    console.log('Zip:', zip);
    console.log('Preferred City:', city);
    console.log('Terms Agreed:', termsChecked);
  
    alert('Registration Successful!');
    document.getElementById("registrationForm").reset();
  });
  
  document.getElementById("bgColor").addEventListener("input", function () {
    document.getElementById("regBox").style.backgroundColor = this.value;
  });
  