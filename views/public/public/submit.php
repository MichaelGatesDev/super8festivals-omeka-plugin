<?php
$head = array(
    'title' => "Submit",
);
echo head($head);
?>

<?php echo flash(); ?>

<?php
$files = 1; //TODO implement 'add/remove' button to allow for multiple files AND/OR suggest zip uploads

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    function died($error)
    {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error . "<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }

    // validation expected data exists
    if (
        !isset($_POST['name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['materialType'])
    ) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');
    }

    $name = $_POST['name']; // required
    $email = $_POST['email']; // required
    $subject = "Super8Festivals.org -- contribution received"; // required
    $materialType = $_POST['materialType']; // required
    $message = $_POST['optionalMessage']; // required

    $to = is_localhost() ? 'mgate005@plattsburgh.edu' : "super8festivals@gmail.com";
    $headers = array(
        'From' => $email,
        'Reply-To' => $email,
        'X-Mailer' => 'PHP/' . phpversion()
    );
    mail($to, $subject, $message, $headers);
}
?>

<!--Section: Contact v.2-->
<section class="container my-5">

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div class="row">
            <div class="col text-center">
                <div class="alert alert-primary" role="alert">
                    Thank you for your submission, <?= $name; ?>!<br/>
                    We will email you back at <a href="mailto:<?= $email; ?>" class="alert-link"><?= $email; ?></a> as soon as we can.
                    <hr/>
                    <div class="row">
                        <div class="col text-left">
                            <p>Name: <?= $name ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-left">
                            <p>Material Type: <?= $materialType ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-left">
                            <p>Message: <?= $message ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col text-center">
            <h2>Submit</h2>
        </div>
    </div>

    <div class="row">
        <div class="col text-center">
            <p>If you have any type of information that you would like to share to help this project grow, please submit it down below.</p>
        </div>
    </div>

    <div class="row">
        <div class="col">

            <form action="submit" method="POST">
                <div class="row">
                    <!--Info-->
                    <div class="col">
                        <div class="form-group mb-4">
                            <label for="name">Name (Personal/Organization)</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter name" required="required" name="name"/>
                        </div>
                        <div class="form-group mb-4">
                            <label for="email">Email Address</label>
                            <div class="input-group">
                                <input type="email" class="form-control" id="email" placeholder="Enter email" required="required" name="email"/>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="materialType">Material Type</label>
                            <div class="input-group mb-3">
                                <select class="form-select title" id="materialType" name="materialType" required="required">
                                    <option value="" selected>Select...</option>
                                    <option value="" class="text-capitalize">Placeholder</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-file mb-4">
                            <input type="file" class="form-file-input" id="file"/>
                            <label class="form-file-label" for="file">
                                <span class="form-file-text">Choose file...</span>
                                <span class="form-file-button">Browse</span>
                            </label>
                        </div
                    </div>
                </div>
                <!--Message-->
                <div class="col">
                    <div class="form-group">
                        <label for="message">Optional Message</label>
                        <textarea name="optionalMessage" id="message" class="form-control" rows="9" cols="25" placeholder="Message"></textarea>
                    </div>
                </div>
                <!--Submit Button-->
                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-primary w-100 mb-4" id="submit">
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</section>


<?php echo foot(); ?>
