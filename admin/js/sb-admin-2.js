document.querySelector('.navbar-search button').addEventListener('click', function() {
  // Ambil nilai input pencarian
  var searchTerm = document.querySelector('.navbar-search input').value.toLowerCase();

  // Cari semua elemen di halaman yang memiliki teks
  var pageContent = document.body.innerText.toLowerCase();

  // Periksa apakah teks pencarian ada dalam konten halaman
  if (pageContent.includes(searchTerm)) {
      alert('Teks ditemukan: ' + searchTerm);
  } else {
      alert('Teks tidak ditemukan.');
  }
});

// Jika ingin mencari teks dalam elemen tertentu, seperti div dengan kelas tertentu
function searchInElements() {
  var searchTerm = document.querySelector('.navbar-search input').value.toLowerCase();
  var elements = document.querySelectorAll('.searchable-text'); // Ganti .searchable-text dengan kelas yang sesuai

  elements.forEach(function(element) {
      if (element.innerText.toLowerCase().includes(searchTerm)) {
          element.style.backgroundColor = 'yellow'; // Tandai elemen yang ditemukan
      } else {
          element.style.backgroundColor = ''; // Reset background jika tidak ditemukan
      }
  });
}

// Opsional: Menambahkan event listener untuk mencari saat mengetik di input
document.querySelector('.navbar-search input').addEventListener('input', searchInElements);

(function($) {
  "use strict"; // Start of use strict

  // Toggle the side navigation
  $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
    $("body").toggleClass("sidebar-toggled");
    $(".sidebar").toggleClass("toggled");
    if ($(".sidebar").hasClass("toggled")) {
      $('.sidebar .collapse').collapse('hide');
    };
  });

  // Close any open menu accordions when window is resized below 768px
  $(window).resize(function() {
    if ($(window).width() < 768) {
      $('.sidebar .collapse').collapse('hide');
    };
    
    // Toggle the side navigation when window is resized below 480px
    if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
      $("body").addClass("sidebar-toggled");
      $(".sidebar").addClass("toggled");
      $('.sidebar .collapse').collapse('hide');
    };
  });

  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
  $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
    if ($(window).width() > 768) {
      var e0 = e.originalEvent,
        delta = e0.wheelDelta || -e0.detail;
      this.scrollTop += (delta < 0 ? 1 : -1) * 30;
      e.preventDefault();
    }
  });

  // Scroll to top button appear
  $(document).on('scroll', function() {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
      $('.scroll-to-top').fadeIn();
    } else {
      $('.scroll-to-top').fadeOut();
    }
  });

  // Smooth scrolling using jQuery easing
  $(document).on('click', 'a.scroll-to-top', function(e) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    e.preventDefault();
  });

})(jQuery); // End of use strict

document.querySelector('.navbar-search button').addEventListener('click', function() {
  var searchTerm = document.querySelector('.navbar-search input').value;
  alert('Searching for: ' + searchTerm);
  // Tambahkan logika pencarian di sini, seperti mengarahkan ke halaman pencarian atau menampilkan hasil.
});

