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
                <td><span><?php echo $cell; ?></span></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
