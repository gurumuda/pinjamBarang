$("#tombolTambahBarang").on("click", function(){
    kodeBarang = $("#kodeBarang").val()
    namaBarang = $("#namaBarang").val()
    jenisBarang = $("#jenisBarang").val()
    stokBarang = $("#stokBarang").val()
    satuan = $("#satuan").val()

    if (kodeBarang && namaBarang && jenisBarang && stokBarang !="" && satuan !="") {
        $.ajax({
            url: "/admin/tambahBarang",
            type: "post",
            data: {
                kodeBarang, namaBarang, jenisBarang, stokBarang, satuan
            },
            success: function(data) {
                if (data == "1") {
                    ntf("Data berhasil ditambah")
                    $("#kodeBarang").val('')
                    $("#kodeBarang").focus()

                } else if (data == "2") {
                    alt("error", "Kode Barang Sudah Ada..", "stok barang diperbaharui")
                }
            },
            error: function(e){
                console.log(e)
            }
        })
    } else {
        alt("error", "Maaf..", "Silakan lengkapi form !")
    }
    
})

$(".tombolHapus").on("click", function(){
    id = $(this).data("id")
    nama = $(this).data("nama")
    konf(nama,id,"/admin/hapusBarang")
    
})

function alt(tipe,judul,teks){
    Swal.fire({
        icon: tipe,
        title: judul,
        text: teks
    })
}

function ntf(teks){
    $('.toast').toast('show');
    $("#pesanSukses").html(teks)
}

function konf(nama,id,url){
    Swal.fire({
        title: 'Anda yakin menghapus data?',
        text: nama,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "post",
                data: {id},
                success: function(data){
                    Swal.fire(
                      'Deleted!',
                      'Data berhasil dihapus.',
                      'success'
                    )

                    setTimeout(function() {
                        location.reload();
                    }, 1000)
                }
            })
        }
      })
}

$('#modalTambahBarang').on('hidden.bs.modal', function () {
    document.location.reload();
})

$("#modalTambahBarang").on("shown.bs.modal", function () { 
    $("#kodeBarang").focus()
});

$(".tombolUbahBarang").on("click", function() {
    $("#modalUbahBarang").modal("show")
    id = $(this).data("id")
    $.ajax({
        url: '/admin/getDataBarang',
        type: 'post',
        data: {id},
        dataType : 'json',
        success: function(data) {
            console.log(data.kodeBarang)
            $("#idUbahBarang").val(data.id)
            $("#ubahKodeBarang").val(data.kodeBarang)
            $("#ubahNamaBarang").val(data.namaBarang)
            $("#ubahJenisBarang").val(data.jenisBarang)
            $("#ubahStokBarang").val(data.stokBarang)
            $("#ubahSatuan").val(data.satuan)
        },
        error: function(e) {
            console.log(e)
        }
    })
    
})

$(".tombolCetakBarcode").on("click", function(){
    id = $(this).data("id")
    
    $.ajax({
        url: '/admin/generateBarcode',
        type: 'post',
        data: {id},
        dataType: 'json',
        success: function(data)
        {           
            setTimeout(() => {
                $("#modalCetakBarcode").modal("show")
                $("#idBarcode").val(data.id)
                $("#kodeBrg").html(data.kodeBarang)
                $('#imgBarcode').attr('src', '/barcode/'+data.fileBarcode);
            }, 3000);
        },
        error: function(e)
        {
            console.log(e)
        }
    })
})
