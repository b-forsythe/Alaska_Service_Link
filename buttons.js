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

    handleButtonClick("login", function() {
        window.location.href = "/login";
    });

    handleButtonClick("contractor_login", function() {
        console.log("Logging in as Contractor");
    });

    handleButtonClick("client_login", function() {
        console.log("Logging in as User");
    });

    handleButtonClick("admin_login", function() {
        console.log("Logging in as Admin");
    });

    handleButtonClick("home", function() {
        window.location.href="/index";
    });

    handleButtonClick("browse", function() {
        window.location.href="/browse";
    });

});
