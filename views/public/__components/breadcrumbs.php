<?php
$path = $_SERVER['REQUEST_URI'];
$segments = array_values(array_filter(explode("/", $path)));
$count = count($segments);
?>
<?php if ($count > 0): ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class='breadcrumb-item'><a href='/'>Home</a></li>
            <?php
            if ($count > 0) {
                for ($x = 0; $x < $count; $x++) {
                    $title = $segments[$x];
                    $active = $x == $count - 1;
                    echo "<li class='breadcrumb-item'>";
                    echo $active ? "<span class='text-capitalize text-muted'>$title</span>" : "<a href='/$title' class='text-capitalize'>$title</a>";
                    echo "</li>";
                }
            }
            ?>
        </ol>
    </nav>
<?php endif; ?>