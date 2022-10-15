
<style>
    .board {
        grid-template-columns: repeat(<?= $type ?>, auto)
    }
</style>

<div class="board" id="board">
    <?php for ($i=0; $i < ($type * $type )  ; $i++) {  ?>
        <div class="cell" data-cell>  </div>
    <?php } ?>
</div>
