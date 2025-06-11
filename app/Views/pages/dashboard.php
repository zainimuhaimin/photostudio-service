<!-- get template -->
<?= $this->extend('template/layout'); ?>
<!-- end get template -->

<!-- initiate section or render page title page name and pageSlash -->
<?= $this->section('pageTitle');?>
Dashboard
<?= $this->endSection();?>

<?= $this->section('page');?>
Dashboard
<?= $this->endSection();?>

<?= $this->section('pageSlash');?>
Dashboard
<?= $this->endSection();?>
<!-- end initiate -->

<!-- render content -->
<?= $this->section('content');?>
<h1>Hello <?= session()->get('username')?></h1>
<?= $this->endSection();?>
<!-- end render content -->