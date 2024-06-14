// function validation() {
//   let email = document.getElementById("email").value;
//   let emailPattern =
//   let password = document.getElementById("password").value;
//   let passPattern = "/^(07|01)d{8}$/";
//   let message = "";
//   if (!emailPattern.test(email)) {
//     message = "invalid Email!";
//     return false;
//   }
//   if (!passPattern.test(password)) {
//     message = " invalid password!";
//     return false;
//   }
//   return true;
// }
function validateEmail() {
  let email = document.getElementById("email").value;
  let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email)) {
    alert("please enter a valid email address");
    return false;
  }
  return true;
}
