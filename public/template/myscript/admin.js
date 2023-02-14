// Jika tombol tambah barang di klik maka jalankan kode berikut
$("#tombolTambahBarang").on("click", function () {
  kodeBarang = $("#kodeBarang").val();
  namaBarang = $("#namaBarang").val();
  jenisBarang = $("#jenisBarang").val();
  stokBarang = $("#stokBarang").val();
  satuan = $("#satuan").val();

  if (
    kodeBarang &&
    namaBarang &&
    jenisBarang &&
    stokBarang != "" &&
    satuan != ""
  ) {
    $.ajax({
      url: "/admin/tambahBarang",
      type: "post",
      data: {
        kodeBarang,
        namaBarang,
        jenisBarang,
        stokBarang,
        satuan,
      },
      success: function (data) {
        if (data == "1") {
          ntf("Data berhasil ditambah");
          $("#kodeBarang").val("");
          $("#kodeBarang").focus();
        } else if (data == "2") {
          ntf("Data berhasil ditambah, stok barang ditambah ke stok lama");
          $("#kodeBarang").val("");
          $("#kodeBarang").focus();
        }
      },
      error: function (e) {
        console.log(e);
      },
    });
  } else {
    alt("error", "Maaf..", "Silakan lengkapi form !");
  }
});

$("#kodeBarang").on("change", function () {
  kodeBarang = $(this).val();

  $.ajax({
    url: "/admin/getDataBarangByKode",
    type: "post",
    data: { kodeBarang },
    dataType: "json",
    success: function (data) {
      if (data != "0") {
        console.log(data);
        $("#namaBarang").val(data.namaBarang);
        $("#jenisBarang").val(data.jenisBarang);
        $("#satuan").val(data.satuan);
        $("#stokBarang").focus();
        $(".target").attr(
          "class",
          "input-group input-group-outline mb-4 focused is-focused target"
        );
        $("#target2").html(
          "Kode barang telah diinputkan sebelumnya, jumlah barang akan ditambahkan ke stok"
        );
      }
      if (data == "0") {
        $("#namaBarang").val("");
        $("#jenisBarang").val("");
        $("#satuan").val("");
        $("#namaBarang").focus();
        $(".target").attr(
          "class",
          "input-group input-group-outline mb-4 target"
        );
        $("#target2").html("");
      }
    },
    error: function (e) {
      console.log(e);
    },
  });
});

// Jika tombol hapus satu barang di klik maka jalankan kode berikut
$(".tombolHapus").on("click", function () {
  id = $(this).data("id");
  nama = $(this).data("nama");
  konf(nama, id, "/admin/hapusBarang");
});

function alt(tipe, judul, teks) {
  Swal.fire({
    icon: tipe,
    title: judul,
    text: teks,
  });
}

function ntf(teks) {
  $(".toast").toast("show");
  $("#pesanSukses").html(teks);
}

// Function konfirmasi hapus data berdasarkan ID yang diinput degan ajax
function konf(nama, id, url) {
  Swal.fire({
    title: "Anda yakin menghapus data?",
    text: nama,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Hapus",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: url,
        type: "post",
        data: { id },
        success: function (data) {
          Swal.fire("Deleted!", "Data berhasil dihapus.", "success");

          setTimeout(function () {
            location.reload();
          }, 1000);
        },
      });
    }
  });
}

// Jika modal ditutup maka jalankan reload halaman tersebut
$("#modalTambahBarang, #modalPinjamBarangModal, #modalTambahPengguna").on(
  "hidden.bs.modal",
  function () {
    document.location.reload();
  }
);

$("#modalTambahBarang").on("shown.bs.modal", function () {
  $("#kodeBarang").focus();
});

$("#modalAmbilBarang").on("shown.bs.modal", function () {
  $("#amKodeBarang").focus();
});

$("#modalPinjamBarangModal").on("shown.bs.modal", function () {
  $("#pjKodeBarang").focus();
});

// Jika tombol ubah barang di klik, maka jalankan kode berikut
$(".tombolUbahBarang").on("click", function () {
  $("#modalUbahBarang").modal("show");
  id = $(this).data("id");
  $.ajax({
    url: "/admin/getDataBarang",
    type: "post",
    data: { id },
    dataType: "json",
    success: function (data) {
      $("#idUbahBarang").val(data.id);
      $("#ubahKodeBarang").val(data.kodeBarang);
      $("#ubahNamaBarang").val(data.namaBarang);
      $("#ubahJenisBarang").val(data.jenisBarang);
      $("#ubahStokBarang").val(data.stokBarang);
      $("#ubahJmlDimiliki").val(data.jmlDimiliki);
      $("#ubahSatuan").val(data.satuan);
    },
    error: function (e) {
      console.log(e);
    },
  });
});

// Jika tombol cetak barcode masing-masing barang di klik
$(".tombolCetakBarcode").on("click", function () {
  id = $(this).data("id");

  $.ajax({
    url: "/admin/generateBarcode",
    type: "post",
    data: { id },
    dataType: "json",
    success: function (data) {
      setTimeout(() => {
        $("#modalCetakBarcode").modal("show");
        $("#idBarcode").val(data.id);
        $("#kodeBrg").html(data.kodeBarang);
        $("#imgBarcode").attr("src", "/barcode/" + data.fileBarcode);
      }, 3000);
    },
    error: function (e) {
      console.log(e);
    },
  });
});

// Jika kode barang pada modal proses pinjam barang modal di isi
$("#pjKodeBarang").on("change", function () {
  kodeBarang = $(this).val();

  $.ajax({
    url: "/admin/getDataPjBr",
    type: "post",
    data: { kodeBarang },
    dataType: "json",
    success: function (data) {
      if (data != "0") {
        console.log(data);
        $("#pjIdBarang").val(data.id);
        $("#pjNamaBarang").val(data.namaBarang);
        $("#pjStokBarang").val(data.stokBarang);
        $("#pjSatuan").val(data.satuan);
      } else {
        alt(
          "warning",
          "Maaf !",
          "Data tidak ditemukan atau kode barang habis pakai"
        );
        setTimeout(() => {
          document.location.reload();
        }, 4000);
        $("#pjNamaBarang").val("");
        $("#pjStokBarang").val("");
      }
    },
    error: function (e) {
      console.log(e);
    },
  });
});

// Jika jumlah barang dipinjam (barang modal) diisi, cek apakah stok cukup
$("#jumlahBarang").on("change", function () {
  const pjStokBarang = $("#pjStokBarang").val();
  const jumlahBarang = $(this).val();
  if (jumlahBarang < 1) {
    $("#tombolSimpanPinjamBarang").attr("disabled", "disabled");
    alt("error", "Error", "Minimal jumlah pinjam adalah 1");
  } else if (Number(jumlahBarang) > Number(pjStokBarang)) {
    $("#tombolSimpanPinjamBarang").attr("disabled", "disabled");
    alt("error", "Error", "Maaf, Stok barang tidak cukup");
  } else {
    $("#tombolSimpanPinjamBarang").removeAttr("disabled");
  }
});

function cekProsesPinjamBarang() {
  pjKodeBarang = $("#pjKodeBarang").val();
  pjNamaBarang = $("#pjNamaBarang").val();
  pjStokBarang = $("#pjStokBarang").val();
  namaPeminjam = $("#namaPeminjam").val();
  jumlahBarang = $("#jumlahBarang").val();
  waktu = $("#filter-date-2").val();
  keperluan = $("#keperluan").val();

  if (pjKodeBarang === "") {
    $("#pjKodeBarang").focus();
    return false;
  }
  if (pjNamaBarang === "") {
    return false;
  }
  if (pjStokBarang === "") {
    return false;
  }
  if (namaPeminjam === "") {
    $("#namaPeminjam").focus();
    return false;
  }
  if (jumlahBarang === "") {
    $("#jumlahBarang").focus();
    return false;
  }
  if (waktu === "") {
    $("#filter-date-2").focus();
    return false;
  }
  if (keperluan === "") {
    $("#keperluan").focus();
    return false;
  }
  if (Number(jumlahBarang) > Number(pjStokBarang)) {
    alt("error", "Error", "Stok barang tidak cukup");
    $("#jumlahBarang").focus();
    return false;
  }
  if (Number(jumlahBarang) < 1) {
    alt("error", "Error", "Jumlah Pengambilan Minimal 1");
    $("#jumlahBarang").focus();
    return false;
  }
  if (Number(pjStokBarang) == "0") {
    alt("error", "Maaf !", "Stok Barang 0");
    return false;
  }
}

function cekProsesAmbilBarang() {
  amKodeBarang = $("#amKodeBarang").val();
  amNamaBarang = $("#amNamaBarang").val();
  amStokBarang = $("#amStokBarang").val();
  namaPengambil = $("#namaPengambil").val();
  amJumlahBarang = $("#amJumlahBarang").val();
  waktu = $("#filter-date-3").val();
  amKeperluan = $("#amKeperluan").val();

  if (amKodeBarang === "") {
    $("#amKodeBarang").focus();
    return false;
  }
  if (amNamaBarang === "") {
    return false;
  }
  if (amStokBarang === "") {
    return false;
  }
  if (namaPengambil === "") {
    $("#namaPengambil").focus();
    return false;
  }
  if (amJumlahBarang === "") {
    $("#amJumlahBarang").focus();
    return false;
  }
  if (waktu === "") {
    $("#filter-date-3").focus();
    return false;
  }
  if (amKeperluan === "") {
    $("#amKeperluan").focus();
    return false;
  }
  if (Number(amJumlahBarang) > Number(amStokBarang)) {
    alt("error", "Error", "Stok barang tidak cukup");
    $("#amJumlahBarang").focus();
    return false;
  }
  if (Number(amJumlahBarang) < 1) {
    alt("error", "Error", "Jumlah Pengambilan Minimal 1");
    $("#amJumlahBarang").focus();
    return false;
  }
  if (Number(amStokBarang) == "0") {
    alt("error", "Maaf !", "Stok Barang 0");
    return false;
  }
}

function cekProsesKembaliBarang() {
  kbKodeBarang = $("#kbKodeBarang").val();
  kbNamaPeminjam = $("#kbNamaPeminjam").val();
  kbNamaBarang = $("#kbNamaBarang").val();
  jumlahBarangKembali = $("#jumlahBarangKembali").val();
  kbJumlahDipinjam = $("#kbJumlahDipinjam").val();
  namaKembali = $("#namaKembali").val();
  waktu = $("#filter-date").val();

  if (kbKodeBarang === "") {
    $("#kbKodeBarang").focus();
    return false;
  }
  if (kbNamaPeminjam === "") {
    $("#kbNamaPeminjam").focus();
    return false;
  }
  if (kbNamaBarang === "") {
    return false;
  }
  if (jumlahBarangKembali === "") {
    $("#jumlahBarangKembali").focus();
    return false;
  }
  if (namaKembali === "") {
    $("#namaKembali").focus();
    return false;
  }
  if (waktu === "") {
    $("#filter-date").focus();
    return false;
  }
  if (Number(jumlahBarangKembali) < 1) {
    alt("error", "Error", "Jumlah Pengembalian Minimal 1");
    $("#jumlahBarangKembali").focus();
    return false;
  }
  if (Number(jumlahBarangKembali) > Number(kbJumlahDipinjam)) {
    alt("error", "Error", "Jumlah Pengembalian Minimal 1");
    $("#jumlahBarangKembali").focus();
    return false;
  }
}

// Jika tombol ubah status pesanan diklik, jalankan kode berikut
$(".tmbUbahStatusPesanan").on("click", function () {
  id = $(this).data("id");
  nama = $(this).data("nama");
  pemesan = $(this).data("pemesan");

  Swal.fire({
    title: "Anda yakin ?",
    text: "mengubah status pesanan " + nama + " dari " + pemesan,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Ubah",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "/admin/ubahStatusPesanan",
        type: "post",
        data: { id },
        success: function (data) {
          Swal.fire("Success!", "Data berhasil diubah.", "success");

          setTimeout(function () {
            location.reload();
          }, 1000);
        },
      });
    }
  });
});

// Jika tombol proses pesanan di klik, jalankan kode berikut
$(".tbmProsesPesanan").on("click", function () {
  idp = $(this).data("idp");

  $.ajax({
    url: "/admin/getJenisBarang",
    type: "post",
    data: { idp },
    dataType: "json",
    success: function (data) {
      console.log(data);

      if (data.jenisBarang == "1") {
        $("#modalPinjamBarangModal").modal("show");
        $("#pjIdBarang").val(data.idBarang);
        $("#pjIdPinjaman").val(data.idP);
        $("#pjKodeBarang").val(data.kodeBarang);
        $("#pjNamaBarang").val(data.namaBarang);
        $("#pjStokBarang").val(data.stokBarang);
        $("#namaPeminjam").val(data.nama);
        $("#jumlahBarang").val(data.jumlahBarang);
        $("#keperluan").val(data.keperluan);
      }
      if (data.jenisBarang == "2") {
        $("#modalAmbilBarang").modal("show");
        $("#amIdBarang").val(data.idBarang);
        $("#amIdAmbil").val(data.idP);
        $("#amKodeBarang").val(data.kodeBarang);
        $("#amNamaBarang").val(data.namaBarang);
        $("#amStokBarang").val(data.stokBarang);
        $("#namaPengambil").val(data.nama);
        $("#amJumlahBarang").val(data.jumlahBarang);
        $("#amKeperluan").val(data.keperluan);
      }
    },
    error: function (e) {
      console.log(e);
    },
  });
});

// Jika modal Kembalikan barang modal dibuka, kursor mengarah ke input kodebarang
$("#modalKembaliBarangModal").on("shown.bs.modal", function () {
  $("#kbKodeBarang").focus();
});

// Proses kembali barang modal. jika kode barang sudah diisi
$("#kbKodeBarang").on("change", function () {
  kodeBarang = $(this).val();

  $.ajax({
    url: "/admin/getPeminjam",
    type: "post",
    data: { kodeBarang },
    dataType: "json",
    success: function (data) {
      console.log(data);
      $("#kbNamaPeminjam").html(data);
    },
    error: function (e) {
      console.log(e);
    },
  });
});

// Proses kembali barang modal. jika nama peminjam sudah dipilih
$("#kbNamaPeminjam").on("change", function () {
  namaPeminjam = $(this).val();
  kodeBarang = $("#kbKodeBarang").val();

  $.ajax({
    url: "/admin/barangDipinjam",
    type: "post",
    data: { namaPeminjam, kodeBarang },
    dataType: "json",
    success: function (data) {
      console.log(data);
      $("#kbNamaBarang").val(data.namaBarang);
      $("#kbJumlahDipinjam").val(data.jumlahBarang);
      $("#jumlahBarangKembali").val(
        Number(data.jumlahBarang) - Number(data.jumlahKembali)
      );
      $("#kbIdBarang").val(data.idB);
      $("#kbIdPinjaman").val(data.idP);
    },
    error: function (e) {
      console.log(e);
    },
  });
});

// Jika kode barang pada modal ambil barang habis pakai di isi
$("#amKodeBarang").on("change", function () {
  kodeBarang = $(this).val();

  $.ajax({
    url: "/admin/getDataAmBr",
    type: "post",
    data: { kodeBarang },
    dataType: "json",
    success: function (data) {
      if (data != "0") {
        console.log(data);
        $("#amIdBarang").val(data.id);
        $("#amNamaBarang").val(data.namaBarang);
        $("#amStokBarang").val(data.stokBarang);
        $("#amSatuan").val(data.satuan);
      } else {
        alt("warning", "Maaf !", "Data tidak ditemukan atau kode barang modal");
        setTimeout(() => {
          document.location.reload();
        }, 4000);
        $("#amNamaBarang").val("");
        $("#amStokBarang").val("");
      }
    },
    error: function (e) {
      console.log(e);
    },
  });
});


$(".tbProsesKembaliBrg").on("click", function() {
  idP = $(this).data("id")

  $("#modalKembaliBarangModal").modal("show")

  $.ajax({
    url: '/admin/getDataBarangKembalikan',
    type: 'post',
    data: {idP},
    dataType: 'json',
    success: function(data) {
      console.log(data)
      $("#kbIdBarang").val(data.idBarang);
      $("#kbIdPinjaman").val(data.idP);
      $("#kbKodeBarang").val(data.kodeBarang);
      $("#kbNamaPeminjam").val(data.namaPeminjam);
      $("#kbNamaBarang").val(data.namaBarang);
      $("#kbJumlahDipinjam").val(data.jumlahBarang);
      $("#jumlahBarangKembali").val(
        Number(data.jumlahBarang) - Number(data.jumlahKembali)
      );

    },
    error: function(e) {
      console.log(e)
    }
  })
})

$("#tombolSimpanUser").on("click", function() {
  emailUser = $("#emailUser").val();
  namaUser = $("#namaUser").val();
  passwordUser = $("#passwordUser").val();
 
  if (
    emailUser != '' &&
    namaUser != '' &&
    passwordUser !=''
  ) {
    $.ajax({
      url: "/admin/tambahUser",
      type: "post",
      data: {
        emailUser,
        namaUser,
        passwordUser
      },
      success: function (data) {
        if (data == "1") {
          ntf("Data berhasil ditambah");
          $("#emailUser").focus();
        } else if (data == "2") {
          alt("error", "Maaf..", "Terjadi duplikasi data email !");         
          $("#emailUser").focus();
        }
      },
      error: function (e) {
        console.log(e);
      },
    });
  } else {
    alt("error", "Maaf..", "Silakan lengkapi form !");
  }
})

$(".tombolHapusUser").on("click", function () {
  id = $(this).data("id");
  nama = $(this).data("nama");
  konf(nama, id, "/admin/hapusUser");
});

$(".tombolUbahUser").on("click", function () {
  $("#modalUbahPengguna").modal("show");
  id = $(this).data("id");
  $.ajax({
    url: "/admin/getDataUser",
    type: "post",
    data: { id },
    dataType: "json",
    success: function (data) {
      $("#idUser").val(data.id);
      $("#u_emailUser").val(data.email);
      $("#u_namaUser").val(data.nama);
      
    },
    error: function (e) {
      console.log(e);
    },
  });
});


$(".tbTagih").on("click", function () {
  id = $(this).data("id");
  nama = $(this).data("nama");

  Swal.fire({
    title: "Anda akan mengingatkan "+ nama,
    text: "untuk mengembalikan barang ",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Kirim",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "/admin/tagihBarang",
        type: "post",
        data: { id },
        dataType : 'json',
        success: function (data) {

          console.log(data.status)

          if (data.status == true) {
            Swal.fire("Success!", "Pesan berhasil dikirim.", "success");
          } else {
            Swal.fire("Gagal!", "Pesan gagal dikirim.", "error");
          }

          setTimeout(function () {
            location.reload();
          }, 2000);
        },
      });
    }
  });
});

function pilihNama(nama) {
  $.ajax({
    url: "/admin/getNomorHp",
    type: "post",
    data: { nama },
    dataType: 'json',
    success: function (data) {
      if (data != "0") {
        $("#hpPeminjam").val(data.phone);
      } else {
        $("#hpPeminjam").val("");
      }
    },
    error: function (e) {
      console.log(e);
    },
  });
}
