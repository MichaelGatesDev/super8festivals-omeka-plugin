<?php
$head = array(
    'title' => "Submit",
);
echo head($head);
?>

<?php echo flash(); ?>


<!--Section: Contact v.2-->
<section class="container">

    <!--Section heading-->
    <h2 class="h1-responsive font-weight-bold text-center my-4">Submit</h2>
    <!--Section description-->
    <p class="text-center w-responsive mx-auto mb-5">
        This project is possible thanks to all of the wonderful contributors who archived and sent information.<br/>
        Explain why they should contribute and what it means for this project, etc. <br/>
    </p>

    <div class="row">

        <!--Grid column-->
        <div class="col">
            <form id="contact-form" name="contact-form" action="mail.php" method="POST">

                <!--Grid row-->
                <div class="row">

                    <div class="col">
                        <input type="text" id="name" name="name" class="form-control">
                        <label for="name" class="">First Name</label>
                    </div>
                    <div class="col">
                        <input type="text" id="name" name="name" class="form-control">
                        <label for="name" class="">Last Name</label>
                    </div>

                    <div class="col">
                        <input type="text" id="email" name="email" class="form-control">
                        <label for="email" class="">Organization Name</label>
                    </div>

                </div>
                <!--Grid row-->

                <!--Grid row-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="md-form mb-0">
                            <label for="type" class="">Contribution Type</label>
                            <select name="type" id="type" class="title">
                                <?php foreach (get_db()->getTable("SuperEightFestivalsContributionType")->findAll() as $type): ?>
                                    <option value="<?= $type->name; ?>"><?= $type->name; ?></option>
                                <?php endforeach; ?>
                                <option>Other</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!--Grid row-->

                <!--Grid row-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="md-form mb-0">
                            <form action="file-upload.php" method="post" enctype="multipart/form-data">
                                <p>Select files to upload:</p>
                                <input name="userfile[]" type="file"/><br/>
                            </form>
                        </div>
                    </div>
                </div>
                <!--Grid row-->

            </form>

            <div class="text-center text-md-left">
                <a class="btn btn-primary" onclick="document.getElementById('contact-form').submit();">Submit</a>
            </div>
            <div class="status"></div>
        </div>
        <!--Grid column-->

    </div>

</section>


<?php echo foot(); ?>
