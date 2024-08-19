// for hover effect
const sidebarTabs = document.querySelectorAll('.sidebar .nav-item a');

sidebarTabs.forEach(tab => {
  tab.addEventListener('click', function () {
    sidebarTabs.forEach(tab => tab.classList.remove('active'));
    this.classList.add('active');
  });
});

// to display sidebar for smaller media screens
document.addEventListener("DOMContentLoaded", function () {
  const menuBtn = document.querySelectorAll(".menu-btn");
  const sidebar = document.querySelector(".sidebar");
  const bodyOverlay = document.querySelector(".body-overlay");
  const contentArea = document.getElementById("content-area");

  const showSidebar = () => {
    sidebar.classList.toggle('active');
    contentArea.classList.toggle('active');
    sidebar.classList.toggle('show-nav');
    bodyOverlay.classList.toggle('show-nav');
  };

  menuBtn.forEach(item => item.addEventListener('click', showSidebar));
  bodyOverlay.addEventListener('click', showSidebar);
});
