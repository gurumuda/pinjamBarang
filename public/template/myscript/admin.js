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
          alt("error", "Kode Barang Sudah Ada..", "stok barang diperbaharui");
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
$("#modalTambahBarang, #modalPinjamBarangModal").on(
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

function cekJumlahbarang() {
  const pjStokBarang = $("#pjStokBarang").val();
  const jumlahBarang = $("#jumlahBarang").val();
  if (Number(jumlahBarang) < 1) {
    $("#tombolSimpanPinjamBarang").attr("disabled", "disabled");
    alt("error", "Error", "Minimal jumlah pinjam adalah 1");
    return false;
  } else if (Number(jumlahBarang) > Number(pjStokBarang)) {
    $("#tombolSimpanPinjamBarang").attr("disabled", "disabled");
    alt("error", "Error", "Stok barang tidak cukup");
    return false;
  } else {
    $("#tombolSimpanPinjamBarang").removeAttr("disabled");
  }
}

function cekJmlAmbBarang() {
  const amStokBarang = $("#amStokBarang").val();
  const amJumlahBarang = $("#amJumlahBarang").val();
  if (Number(amJumlahBarang) < 1) {
    $("#tombolSimpanAmbilBarang").attr("disabled", "disabled");
    alt("error", "Error", "Minimal jumlah pinjam adalah 1");
    return false;
  } else if (Number(amJumlahBarang) > Number(amStokBarang)) {
    $("#tombolSimpanAmbilBarang").attr("disabled", "disabled");
    alt("error", "Error", "Stok barang tidak cukup");
    return false;
  } else {
    $("#tombolSimpanAmbilBarang").removeAttr("disabled");
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

// Jika jumlah barang diambil (barang habis pakai) diisi, cek apakah stok cukup
$("#amJumlahBarang").on("change", function () {
  const amStokBarang = $("#amStokBarang").val();
  const jumlahBarang = $(this).val();
  if (jumlahBarang < 1) {
    $("#tombolSimpanAmbilBarang").attr("disabled", "disabled");
    alt("error", "Error", "Minimal jumlah ambil adalah 1");
  } else if (Number(jumlahBarang) > Number(amStokBarang)) {
    $("#tombolSimpanAmbilBarang").attr("disabled", "disabled");
    alt("error", "Error", "Maaf, Stok barang tidak cukup");
  } else {
    $("#tombolSimpanAmbilBarang").removeAttr("disabled");
  }
});
