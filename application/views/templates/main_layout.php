<?php $this->load->view('templates/header'); ?>
<?php $this->load->view('templates/side_menubar'); ?>

<div class="main-content-wrapper overflow-hidden">

    <?php $this->load->view('templates/header_menu'); ?>
    <?= $content; ?>
</div>