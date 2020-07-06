<?php
$flashMsg = flash();
?>
<?php if ($flashMsg): ?>
    <?php
    $dom = new DOMDocument();
    $dom->loadHTML($flashMsg);
    $lis = $dom->getElementsByTagName("li");
    ?>
    <?php foreach ($lis as $li): ?>
        <?php
        $alertLevel = $li->getAttribute("class");
        $alertColorClass = "";
        switch (strtolower($alertLevel)) {
            case "default":
                $alertColorClass = "alert-info";
                break;
            case "success":
                $alertColorClass = "alert-success";
                break;
            case "error":
                $alertColorClass = "alert-danger";
                break;
        }
        ?>
        <div class="row">
            <div class="col">
                <div class="alert <?= $alertColorClass; ?> alert-dismissible fade show mt-4" role="alert">
                    <?= $li->textContent; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>