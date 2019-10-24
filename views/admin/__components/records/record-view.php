<?php if (!$this->records): ?>
    <p>
        <?php echo $this->msgNoRecordsFound; ?>
        <a href="<?php echo html_escape(url($this->urlAddRecord)); ?>"><?php echo $this->msgAskAddRecord; ?></a>
    </p>
<?php else: ?>
    <?php echo $this->viewPartial; ?>
<?php endif; ?>