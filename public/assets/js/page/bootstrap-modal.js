$('.btn-read').on('click', function(e) {
  e.preventDefault();

  const url = $(this).data('url');

  $.ajax({
    url: url,
    method: 'GET',
    success: function(data) {
      let scoreRows = '';

      data.scores.forEach(function(score) {
        scoreRows += `
          <tr>
            <th>${score.criteria}</th>
            <td class="text-right">${score.value}</td>
          </tr>
        `;
      });

      const modalContent = `
        <table class="table table-striped">
          <tr><th>Tahun Ajaran</th><td class="text-right">${data.period}</td></tr>
          <tr><th>Nama Siswa</th><td class="text-right">${data.student}</td></tr>
          ${scoreRows}
        </table>
      `;

      const $trigger = $('<div>').appendTo('body');

      $trigger.fireModal({
        title: 'Detail Nilai Siswa',
        body: modalContent,
        footerClass: 'bg-whitesmoke',
        buttons: [
          {
            text: 'Tutup',
            class: 'btn btn-danger',
            handler: function(modal) {
              $.destroyModal(modal);
            }
          }
        ]
      });

      $trigger.click();
    },
    error: function() {
      alert('Gagal mengambil data.');
    }
  });
});
