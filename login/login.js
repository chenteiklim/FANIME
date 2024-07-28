
// Retrieve the value of the 'success' query parameter from the URL
const urlParams = new URLSearchParams(window.location.search);
const Param = urlParams.get('success');

window.onload = function() {
    var urlParams = new URLSearchParams(window.location.search);
    const Param = urlParams.get('success');

    if (Param === '5') {
      var messageContainer = document.getElementById("messageContainer");
      messageContainer.textContent = 'Invalid email or password!';
      messageContainer.style.display = "block";
      messageContainer.classList.add("message-container");
      
      setTimeout(function() {
        messageContainer.style.display = "none";
        messageContainer.classList.remove("message-container");
    }, 5000); // 10,000 milliseconds = 10 seconds
    }
  };
const signUPBtn=document.getElementById('signUpBtn');
const forgotBtn=document.getElementById('forgotBtn');

  signUPBtn.addEventListener('click', function (event) {
    window.location.href="../signUp/signUp.html"
  })
  forgotBtn.addEventListener('click', function (event) {
    window.location.href="../verify/verify.html"
  })
  
  const togglePasswordBtn = document.getElementById('show');
  const passwordInput = document.getElementById('password');

  togglePasswordBtn.addEventListener('click', function (event) {
      event.preventDefault(); // Prevent form submission
      if (togglePasswordBtn.textContent === 'Show') {
          passwordInput.type = 'text';
          togglePasswordBtn.textContent = 'Hide';
      } else {
          passwordInput.type = 'password';
          togglePasswordBtn.textContent = 'Show';
      }
  });

