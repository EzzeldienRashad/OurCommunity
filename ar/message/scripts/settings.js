document.getElementById("delete-form").addEventListener("submit", function (event) {
    if (!confirm("هل أنت متأكد من أنك تريد حذف المجموعة؟")) {
        event.preventDefault();        
    }
});