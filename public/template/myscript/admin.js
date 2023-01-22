$("#tombolTambahBarang").on("click", function(){
    kodeBarang = $("#kodeBarang").val()
    namaBarang = $("#namaBarang").val()
    jenisBarang = $("#jenisBarang").val()
    stokBarang = $("#stokBarang").val()

    if (kodeBarang && namaBarang && jenisBarang && stokBarang !="") {
        $.ajax({
            url: "/admin/tambahBarang",
            type: "post",
            data: {
                kodeBarang, namaBarang, jenisBarang, stokBarang
            },
            success: function(data) {
                if (data == "1") {
                    ntf("Data berhasil ditambah")
                } else if (data == "2") {
                    alt("error", "Data gagal ditambah..", "ada duplikasi kode barang")
                    
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
    Toastify({
        text: teks,
        style: {
          background: "linear-gradient(to right, #00b09b, #96c93d)",
          position : "absolute",
          right : "10px",
          padding : "10px",
          borderRadius : "5px",
          zIndex : "100"
        }
      }).showToast();
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

$('#modalTambahBarang').on('hidden', function () {
    document.location.reload();
  })




