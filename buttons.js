document.addEventListener("DOMContentLoaded", function() {
    // Helper function to handle clicks
    function handleButtonClick(id, action) {
        const button = document.getElementById(id);
        if (button) {
            button.addEventListener("click", action);
        }
    }

    // Event listeners for each button
    handleButtonClick("how_work", function() {
        console.log("HOW IT WORKS!");
    });

    handleButtonClick("_register", function() {
        window.location.href="/register.html";
    });
    handleButtonClick("_contractorlogin", function() {
        window.location.href="/login.html";
    });

    handleButtonClick("client_login", function() {
        console.log("Logging in as User");
    });

    handleButtonClick("admin_login", function() {
        console.log("Logging in as Admin");
    });

    handleButtonClick("home", function() {
        window.location.href="/index.html";
    });

    handleButtonClick("browse", function() {
        window.location.href="/browse.html";
    });

    handleButtonClick("FAQ", function(){
        window.location.href="/faq.html";
    });

});
