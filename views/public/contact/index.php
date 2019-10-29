<?php
$head = array(
    'title' => "Contact",
);
echo head($head);
?>

<?php echo flash(); ?>


<!--Section: Contact v.2-->
<section class="container">

    <div class="row" style="margin-top: 50px;">
        <div class="col text-center">
            <h2>Contact Us</h2>
        </div>
    </div>

    <div class="row">
        <div class="col text-center">
            <p>Please do not hesitate to reach out to us at any time! We would love to hear from you.</p>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="well well-sm">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name (Personal/Organization)</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter name" required="required"/>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <div class="input-group">
                                    <input type="email" class="form-control" id="email" placeholder="Enter email" required="required"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="email" placeholder="Enter subject" required="required"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">
                                    Message</label>
                                <textarea name="message" id="message" class="form-control" rows="9" cols="25" required="required" placeholder="Message"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary pull-right" id="btnContactUs">
                                Send Message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>


<?php echo foot(); ?>
