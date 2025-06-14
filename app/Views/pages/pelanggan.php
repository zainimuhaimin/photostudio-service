<!-- get template -->
<?= $this->extend('template/layout'); ?>
<!-- end get template -->

<!-- initiate section or render page title page name and pageSlash -->
<?= $this->section('pageTitle'); ?>
Table Pelanggan
<?= $this->endSection(); ?>

<?= $this->section('page'); ?>
Table Pelanggan
<?= $this->endSection(); ?>

<?= $this->section('pageSlash'); ?>
Table Pelanggan
<?= $this->endSection(); ?>
<!-- end initiate -->

<?= $this->section('content'); ?>
<div class="flex flex-wrap -mx-2">
  <div class="flex-none w-full max-w-full px-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
      <div class="space-x-4 justify-between flex p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="dark:text-white">Tabel Pelanggan</h6>
        <?php if ($rola_name == "ADMIN"): ?>
          <a class="dark:text-white bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="<?= base_url() ?>pelanggan-add">
            Tambah Pelanggan </a>
        <?php endif; ?>
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
              <?php if (!empty($pelanggans)): ?>
                <?php $no = 1;
                foreach ($pelanggans as $val): ?>
                  <tr>
                    <td class="p-2 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent">
                      <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80"><?= $no++ ?></p>
                    </td>
                    <td class="p-2 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent">
                      <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80"><?= $val['nama'] ?></p>
                    </td>
                    <td class="p-2 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent">
                      <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80"><?= $val['alamat'] ?></p>
                    </td>
                    <td class="p-2 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent">
                      <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80"><?= $val['email'] ?></p>
                    </td>
                    <td class="p-2 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent">
                      <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80"><?= $val['no_telp'] ?></p>
                    </td>
                    <td class="p-2 align-middle bg-transparent dark:border-white/40 whitespace-nowrap shadow-transparent">
                      <div class="flex space-x-2 ">
                        <a id="edit-pelanggan" class="text-blue-500 hover:text-blue-700" href="<?= base_url() ?>pelanggan-edit/<?= $val['id_pelanggan'] ?>">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                          </svg>
                        </a>
                        <button onclick="deleteConfirmation(`Apakah Kamu Ingin Menghapus Data Ini ?`, <?= $val['id_pelanggan'] ?>)" id="delete-pelanggan" href="" class="text-red-500 hover:text-red-700">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                          </svg>
                        </button>
                      </div>
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
  // script kamu di sini
  const deleteAction = "DELETE";
  const baseUrl = "<?= base_url() ?>";

  function deleteConfirmation(message, id) {
    console.log(`action delete untuk id ${id} dengan pesan ${message}`);
    Swal.fire({
      title: message,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: "Ya",
      cancelButtonText: "Batal",
      customClass: {
        confirmButton: 'bg-blue text-black rounded px-4 py-2 hover:bg-blue-700',
        cancelButton: 'bg-gray text-black rounded px-4 py-2 hover:bg-gray-400'
      }
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        // ajax delete
        executeDelete(id);
        Swal.fire("Saved!", "", "success");
      }
    });
  }

  function executeDelete(id) {
    $.ajax({
      url: `${baseUrl}pelanggan-delete/${id}`,
      type: 'DELETE',
      success: function(response) {
        if (response.status === 200) {
          Swal.fire({
            title: 'Berhasil!',
            text: 'Data pelanggan berhasil dihapus',
            icon: 'success',
            confirmButtonText: 'OK',
            customClass: {
              confirmButton: 'bg-blue text-black rounded px-4 py-2 hover:bg-blue-700'
            },
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.reload();
            }
          });
        } else {
          Swal.fire({
            title: 'Gagal!',
            text: 'Terjadi kesalahan saat menghapus data',
            icon: 'error',
            confirmButtonText: 'OK',
            customClass: {
              confirmButton: 'bg-blue text-black rounded px-4 py-2 hover:bg-blue-700'
            }
          });
        }
      },
      error: function(xhr, status, error) {
        Swal.fire({
          title: 'Error!',
          text: 'Terjadi kesalahan pada server',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      }
    });
  }
</script>
<?= $this->endSection(); ?>