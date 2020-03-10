<?php
queue_css_file("admin");
queue_js_file("jquery.min");
echo head(array(
    'title' => 'Add Banner',
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<style>
    #file {
        border: 1px solid red;
    }
</style>

<?php echo $form; ?>

<script>
    $(document).ready(() => {
        $("#file").change(function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#file + embed').remove();
                    $('#file').after('<embed src="' + e.target.result + '" width="450" height="300">');
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>

<?php echo foot(); ?>
