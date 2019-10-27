<table class="full">
    <thead>
    <tr>
        <?php foreach ($this->headers as $header): ?>
            <th><span><?php echo $header ?></span></th>
        <?php endforeach; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($this->rows as $row): ?>
        <tr>
            <?php foreach ($row as $cell): ?>
                <?php if ($this->rows[0] == $row && $row[0] == $cell): ?>
                    <td>
                        <span><?php echo $cell; ?></span>
                        <ul class="action-links group">
                            <li>
                                <a href="edit/id/<?php echo $row[0]; ?>">
                                    <?php echo "Edit"; ?>
                                </a>
                            </li>
                        </ul>
                    </td>
                <?php else: ?>
                    <td><span><?php echo $cell; ?></span></td>
                <?php endif; ?>

            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
