document.getElementById("delete-form").addEventListener("submit", function (event) {
    if (!confirm("Are you sure you want to delete this group FOREVER?")) {
        event.preventDefault();        
    }
});