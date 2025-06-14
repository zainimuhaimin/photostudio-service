<!-- get template -->
<?= $this->extend('template/layout'); ?>
<!-- end get template -->

<!-- initiate section or render page title page name and pageSlash -->
<?= $this->section('pageTitle'); ?>
Table Pembayaran
<?= $this->endSection(); ?>

<?= $this->section('page'); ?>
Table Pembayaran
<?= $this->endSection(); ?>

<?= $this->section('pageSlash'); ?>
Table Pembayaran
<?= $this->endSection(); ?>
<!-- end initiate -->

<?= $this->section('content'); ?>
<div class="flex flex-wrap -mx-2">
  <div class="flex-none w-full max-w-full px-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
      <div class="space-x-4 justify-between flex p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="dark:text-white">Tabel Pembayaran</h6>
      </div>
      <div class="flex-auto px-0 pt-0 pb-2">
        <div class="p-2 overflow-x-auto">
          <!-- TODO USING PAGINATION -->
          <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
            <thead class="align-bottom">
              <tr>
                <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">No</th>
                <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Id Transaksi</th>
                <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Pembayaran</th>
                <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Jenis Pembayaran</th>
                <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Metode Pembayaran</th>
                <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status Pembayaran</th>
                <?php if (session()->get('role') == $roleUser['id_role']): ?>
                  <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Action</th>
                <?php endif; ?>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($pembayarans)): ?>
                <?php $no = 1;
                foreach ($pembayarans as $val): ?>
                  <tr>
                    <td class="p-2 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent">
                      <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80"><?= $no++ ?></p>
                    </td>
                    <td class="p-2 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent">
                      <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80"><?= $val['transaction_id'] ?></p>
                    </td>
                    <td class="p-2 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent">
                      <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80"><?= empty($val['nama_alat']) ? $val['nama_jasa'] :  $val['nama_alat'] ?></p>
                    </td>
                    <td class="p-2 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent">
                      <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80"><?= empty($val['nama_alat']) ? "Pemesanan Jasa" :  "Penyewaan Alat" ?></p>
                    </td>
                    <td class="p-2 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent">
                      <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80"><?= $val['metode_pembayaran'] ?></p>
                    </td>
                    <td class="p-2 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent">
                      <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80"><?= $val['status_pembayaran'] ?></p>
                    </td>
                    <td class="p-2 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent">
                      <?php if ($val['status_pembayaran'] == 'PAID' && session()->get('role_name') == "ADMIN"): ?>
                        <button onclick="doConfirmation(<?= $val['id_pembayaran'] ?>)" style="background-color:rgb(197, 178, 34); color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; text-decoration: none; display: inline-block; transition: background-color 0.2s;">Konfirmasi</button>
                      <?php endif; ?>
                      <?php if ($val['status_pembayaran'] != 'BOOKED'): ?>
                        <a href="<?= base_url() ?>pembayaran-receipt/<?= $val['id_pembayaran'] ?>" style="background-color: #22c55e; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; text-decoration: none; display: inline-block; transition: background-color 0.2s;">Lunas</a>
                      <?php else: ?>
                        <a href="<?= base_url() ?>pembayaran-detail/<?= $val['id_pembayaran'] ?>" style="background-color:rgb(34, 129, 197); color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; text-decoration: none; display: inline-block; transition: background-color 0.2s;">Bayar</a>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr colspan="5">
                  <td class="p-2 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent">
                    <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">Tidak Ada Data</p>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  const baseUrl = "<?= base_url() ?>";

  function doConfirmation(id) {
    console.log(id);
    $.ajax({
      url: `${baseUrl}pembayaran-confirm`,
      type: 'POST',
      data: {
        id: id
      },
      dataType: "json",
      success: function(response) {
        if (response.status === '200') {
          Swal.fire({
            title: "Berhasil !",
            text: "Berhasil Konfirmasi Pembayaran.",
            icon: "success"
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.reload();
            } else {
              window.location.reload();
            }
          })
        }
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);
        Swal.fire({
          title: "Gagal !",
          text: "Gagal Konfirmasi Pembayaran.",
          icon: "warning"
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.reload();
          } else {
            window.location.reload();
          }
        })
      }
    });
  }
</script>
<?= $this->endSection(); ?>