$(document).ready(() => {
    $("#file").change(function () {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#file + embed').remove();
                // $('#file').after('<embed src="' + e.target.result + '" width="450" height="300" style="object-fit: cover;">');
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
});