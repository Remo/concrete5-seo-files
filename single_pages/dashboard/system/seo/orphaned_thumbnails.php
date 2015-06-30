<?php
echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(
    t('Orphaned Thumbnails'), t('Shows thumbnails of files which have been deleted.'), 'span10 offset1', false);

?>
    <div class="ccm-pane-body">
        <table class="table">
            <?php foreach ($thumbnails as $thumbnail) { ?>
                <tr>
                    <td class="ccm-file-list-thumbnail-wrapper">
                        <a href="<?php echo REL_DIR_FILES_CACHE ?>/<?php echo $thumbnail['filename'] ?>"
                           target="_blank"><?php echo $thumbnail['filename'] ?></a>
                    </td>
                    <td>
                        <img src="<?php echo REL_DIR_FILES_CACHE ?>/<?php echo $thumbnail['filename'] ?>" height="40">
                    </td>
                    <td>
                        <?php echo $thumbnail['size'][0] . '×' . $thumbnail['size'][1] ?>
                    </td>
                    <td>
                        <button class="btn delete-file" data-filename="<?php echo $thumbnail['filename'] ?>"
                                data-fid="<?php echo $thumbnail['id'] ?>"><?php echo t('Delete') ?></button>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $(".delete-file").on("click", function (event) {
                $row = $(this).parents("tr");
                event.preventDefault();
                var data = {"filename": $(this).data("filename")};
                $.post("<?php echo $this->action('delete_file')?>", data, function (response) {
                    if (response == "") {
                        $row.remove();
                    }
                    else {
                        alert(response)
                    }
                });
            });
        });
    </script>
<?php

echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false);