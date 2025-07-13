"use strict";

  $("#toastr-1").click(function () {
    iziToast.info({
      title: 'Informasi',
      message: 'Notifikasi ini memberikan informasi penting kepada pengguna.',
      position: 'topRight'
    });
  });

  $("#toastr-2").click(function () {
    iziToast.success({
      title: 'Berhasil!',
      message: 'Aksi Anda telah berhasil diproses dengan baik.',
      position: 'topRight'
    });
  });

  $("#toastr-3").click(function () {
    iziToast.warning({
      title: 'Peringatan',
      message: 'Ada sesuatu yang perlu Anda periksa kembali.',
      position: 'topRight'
    });
  });

  $("#toastr-4").click(function () {
    iziToast.error({
      title: 'Terjadi Kesalahan',
      message: 'Maaf, terjadi kesalahan saat memproses permintaan Anda.',
      position: 'topRight'
    });
  });
