
document.addEventListener('DOMContentLoaded', function() {
  var menuIcon = document.getElementById('menu-icon');
  var navbar = document.getElementById('navbar');
  if (menuIcon && navbar) {
    menuIcon.addEventListener('click', function() {
      if (navbar.style.display === 'none' || navbar.style.display === '') {
        navbar.style.display = 'flex';
      } else {
        navbar.style.display = 'none';
      }
    });
  }
});

// document.addEventListener('DOMContentLoaded', function() {
//     document.getElementById('menu-icon').addEventListener('click', function() {
//         var navbar = document.getElementById('navbar');

//         if (navbar.style.display === 'block' || navbar.style.display === '') {
//             navbar.style.display = 'block';
            

//         } else {
//             navbar.style.display = 'none';
        

//         }
//     });
// });
