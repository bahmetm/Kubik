// Select the button
const switch_theme_button = document.getElementById("dark_theme");
// Select the theme preference from localStorage
const current_theme = localStorage.getItem("theme");

// If the current theme in localStorage is "dark"...
if (current_theme == "dark") {
  // ...then use the .dark-theme class
  document.body.classList.add("dark_theme");
}

// Listen for a click on the button 
switch_theme_button.addEventListener("click", function() {
  // Toggle the .dark-theme class on each click
  document.body.classList.toggle("dark_theme");
  
  // Let's say the theme is equal to light
  let theme = "light";
  // If the body contains the .dark-theme class...
  if (document.body.classList.contains("dark_theme")) {
    // ...then let's make the theme dark
    theme = "dark";
  }
  // Then save the choice in localStorage
  localStorage.setItem("theme", theme);
});