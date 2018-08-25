<!-- Footer -->
<footer id="footer">
	&copy; <?=date('Y')?> <?=$storeName?>. <?=$this->translation('all rights reserved')?>
</footer>

<?php if(isset($_SESSION['toast']) && is_array($_SESSION['toast'])){ ?>
<script>
  document.addEventListener('DOMContentLoaded', function(){
    <?php foreach($_SESSION['toast'] as $value){ ?>
    //Materialize.toast('<?=$value?>', 10000);
    <?php } ?>
  });
</script>
<?php
  unset($_SESSION['toast']);
?>
<?php } ?>