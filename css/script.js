// $(document).ready(function() {
//     $('#formAjouterMenu').submit(function(event) {
//       event.preventDefault(); // Prevent the form from submitting normally
      
//       // Serialize the form data into a URL-encoded string
//       var formData = new FormData(this);
      
//       // Send an AJAX request to the server
//       $.ajax({
//         url: 'adminMenu.php?actionAjouterMenu', // Replace with the URL of your PHP script
//         type: 'POST',
//         data: formData,
//         processData: false,
//         contentType: false,
//         success: function(response) {
//           // If the server returns an error message, display it in the #error div
//           if (response.startsWith('Erreur: ')) {
//             $('#error').text(response.substr(8));
//           } else {
//             // Otherwise, display a success message
//             alert(response);
//           }
//         },
//         error: function() {
//           // If the AJAX request fails, display an error message
//           $('#error').text('Une erreur est survenue lors de la soumission du formulaire.');
//         }
//       });
//     });
//   });
 
  
document.addEventListener('DOMContentLoaded', function() {
    const navbarToggle = document.querySelector('.navbar-toggle');
    const nav = document.querySelector('nav');
  
    navbarToggle.addEventListener('click', function() {
      nav.classList.toggle('active');
    });
  });