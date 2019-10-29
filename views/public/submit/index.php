<?php
$head = array(
    'title' => "Submit",
);
echo head($head);
?>

<?php echo flash(); ?>


<?php
$files = 1; //TODO implement 'add/remove' button to allow for multiple files AND/OR suggest zip uploads
?>

<!--Section: Contact v.2-->
<section class="container">

    <div class="row" style="margin-top: 50px;">
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
                            <label for="subject">Material Type</label>
                            <div class="input-group mb-3">
                                <select class="custom-select title" id="inputGroupSelect01">
                                    <option selected>Choose...</option>
                                    <?php foreach (get_db()->getTable("SuperEightFestivalsContributionType")->findAll() as $type): ?>
                                        <option value="<?= $type->name; ?>"><?= $type->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="message">Optional Message</label>
                            <textarea name="message" id="message" class="form-control" rows="9" cols="25" required="required" placeholder="Message"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!--File Column A-->
                    <div class="col">
                        <?php for ($i = 0; $i < $files; $i++): ?>
                            <!--File Row-->
                            <div class="row">
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="inputGroupFile01">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>


                </div>
                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-primary pull-right" style="width: 100%;" id="btnContactUs">
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</section>


<?php echo foot(); ?>
