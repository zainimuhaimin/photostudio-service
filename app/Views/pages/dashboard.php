<!-- get template -->
<?= $this->extend('template/layout'); ?>
<!-- end get template -->

<!-- initiate section or render page title page name and pageSlash -->
<?= $this->section('pageTitle'); ?>
Dashboard
<?= $this->endSection(); ?>

<?= $this->section('page'); ?>
Dashboard
<?= $this->endSection(); ?>

<?= $this->section('pageSlash'); ?>
Dashboard
<?= $this->endSection(); ?>
<!-- end initiate -->

<!-- render content -->
<?= $this->section('content'); ?>
<div class="min-h-screen bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg shadow-lg p-6 mb-8">
            <h1 class="text-white text-2xl font-bold mb-2">Welcome back, <?= session()->get("username") ?>!</h1>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<!-- end render content -->