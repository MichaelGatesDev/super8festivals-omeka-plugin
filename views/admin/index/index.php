<?php
$head = array('bodyclass' => 'simple-pages primary',
    'title' => html_escape(__('Super8Festivals | Index')),
    'content_class' => 'horizontal-nav');
echo head($head);
?>

<p>This is the primary control panel for the Super 8 Festivals website.</p>


<button>Countries</button>
<button>Cities</button>
<button>Filmmakers</button>

<?php echo foot(); ?>
