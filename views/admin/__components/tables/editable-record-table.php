<?php
if ($headers == null) $headers = array();
set_loop_records($recordsVar, get_records($recordType));
?>


<table class="full">
    <thead>
    <tr>
        <?php foreach ($headers as $header): ?>
            <th><?php echo $header; ?></th>
        <?php endforeach; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach (loop($recordsVar) as $record): ?>
        <tr>
            <td>
                <span class="title">
                    <a href="<?php echo record_url($recordsVar); ?>">
                        <?php echo metadata($recordsVar, $titleVar); ?>
                    </a>
                </span>
                <ul class="action-links group">
                    <!-- Edit Item-->
                    <li>
                        <a href="<?php echo "edit/id/$record->id"; ?>">
                            Edit
                        </a>
                    </li>
                    <!-- Delete Item-->
                    <li>
                        <a href="<?php echo "delete-confirm/id/$record->id"; ?>">
                            Delete
                        </a>
                    </li>
                </ul>
            </td>
            <?php foreach ($metaKeys as $meta): ?>
                <td><?php echo metadata($recordsVar, $meta); ?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>