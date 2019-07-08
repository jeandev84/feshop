<!-- show code or name of actif currency -->
<option value="" class="label">
    <?= $this->currency['code'] ?>
</option>
<!-- end show code -->
<!-- show the rest of currencies -->
<?php foreach($this->currencies as $k => $v): ?>
    <?php if($k != $this->currency['code']): ?>
        <option value="<?= $k ?>"><?= $k ?></option>
    <?php endif; ?>
<?php endforeach; ?>
<!-- end rest -->

