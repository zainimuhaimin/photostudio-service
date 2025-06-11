<!-- get template -->
<?= $this->extend('template/layout'); ?>
<!-- end get template -->

<!-- initiate section or render page title page name and pageSlash -->
<?= $this->section('pageTitle');?>
Table Pelanggan
<?= $this->endSection();?>

<?= $this->section('page');?>
Table Pelanggan
<?= $this->endSection();?>

<?= $this->section('pageSlash');?>
Table Pelanggan
<?= $this->endSection();?>
<!-- end initiate -->

<?= $this->section('content');?>
<div class="flex flex-wrap -mx-2">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
            <div class="space-x-4 justify-between flex p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6 class="dark:text-white">Tabel Pelanggan</h6>
                <?php if ($rola_name == "ADMIN"):?>
                <a class="dark:text-white bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="<?=base_url()?>pelanggan-add">
                  Tambah Pelanggan </a>
                <?php endIf;?>
            </div>
            <div class="flex-auto px-0 pt-0 pb-2">
                <div class="p-2 overflow-x-auto">
                  <!-- TODO USING PAGINATION -->
                   <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                    <thead class="align-bottom">
                      <tr>
                        <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">No</th>
                        <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Nama</th>
                        <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Alamat</th>
                        <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Email</th>
                        <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Nomor HandPhone</th>
                        <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if(!empty($pelanggans)): ?>
                        <?php $no =1 ; foreach($pelanggans as $val):?>
                      <tr>
                        <td class="p-2 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent">
                          <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80"><?=$no++?></p>
                        </td>
                        <td class="p-2 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent">
                          <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80"><?=$val['nama']?></p>
                        </td>
                        <td class="p-2 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent">
                          <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80"><?=$val['alamat']?></p>
                        </td>
                        <td class="p-2 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent">
                          <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80"><?=$val['email']?></p>
                        </td>
                        <td class="p-2 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent">
                          <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80"><?=$val['no_telp']?></p>
                        </td>
                        <td class="p-2 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent">
                          <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">Details</p>
                        </td>
                      </tr>
                      <?php endforeach;?>
                      <?php else:?>
                        <tr colspan="5">
                          <td class="p-2 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent">
                            <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">Tidak Ada Data</p>
                          </td>
                        </tr>
                      <?php endif;?>
                    </tbody>
                  </table>
                </div>
            </div>
            </div>
        </div>
</div>
<?= $this->endSection();?>