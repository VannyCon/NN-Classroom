const body = document.querySelector('body'),
      sidebar = body.querySelector('nav'),
      toggle = body.querySelector(".toggle"),
      searchBtn = body.querySelector(".search-box"),
      modeSwitch = body.querySelector(".toggle-switch"),
      modeText = body.querySelector(".mode-text");


// Load sidebar state from localStorage
if (localStorage.getItem("sidebarState") === "closed") {
    sidebar.classList.add("close");
} else {
    sidebar.classList.remove("close");
}

// Toggle sidebar open/close and save state to localStorage
toggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
    if (sidebar.classList.contains("close")) {
        localStorage.setItem("sidebarState", "closed");
    } else {
        localStorage.setItem("sidebarState", "open");
    }
});

// Ensure sidebar opens when search button is clicked and update localStorage
searchBtn.addEventListener("click", () => {
    sidebar.classList.remove("close");
    localStorage.setItem("sidebarState", "open");
});

modeSwitch.addEventListener("click" , () =>{
    body.classList.toggle("dark");

    if(body.classList.contains("dark")){
        modeText.innerText = "Light mode";
    }else{
        modeText.innerText = "Dark mode";

    }
});