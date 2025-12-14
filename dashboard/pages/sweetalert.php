<script>
  const urlParams = new URLSearchParams(window.location.search);
  const status = urlParams.get("status");
  const action = urlParams.get("action");
  const msg = urlParams.get("msg") || urlParams.get("message");

  if (status) {

    /* ===================== SUCCESS ===================== */
    if (status === "success") {

      if (action === "registered") {
        Swal.fire({
          icon: "success",
          title: "Registrasi Berhasil!",
          text: "Akun berhasil dibuat. Silakan login 💄",
          footer: "@ Makeup Artist Yola",
          timer: 3000,
          showConfirmButton: false
        });
      } else if (action === "register") {
        Swal.fire({
          icon: "success",
          title: "Berhasil!",
          text: "User baru berhasil ditambahkan 👤",
          footer: "@ Makeup Artist Yola",
          timer: 3000,
          showConfirmButton: false
        });
      } else if (action === "edituser") {
        Swal.fire({
          icon: "success",
          title: "Berhasil!",
          text: "Data akun berhasil diperbarui ✨",
          footer: "@ Makeup Artist Yola",
          timer: 3000,
          showConfirmButton: false
        });
      } else if (action === "deleteuser") {
        Swal.fire({
          icon: "success",
          title: "Berhasil!",
          text: "Akun berhasil dihapus 🗑️",
          footer: "@ Makeup Artist Yola",
          timer: 3000,
          showConfirmButton: false
        });
      } else if (action === "tambahbooking") {
        Swal.fire({
          icon: "success",
          title: "Booking Berhasil!",
          text: "Booking makeup berhasil dibuat. Tunggu konfirmasi admin 💄",
          footer: "@ Makeup Artist Yola",
          timer: 3000,
          showConfirmButton: false
        });
      } else if (action === "selesaikan") {
        Swal.fire({
          icon: "success",
          title: "Selesai!",
          text: "Booking berhasil ditandai selesai ✅",
          footer: "@ Makeup Artist Yola",
          timer: 3000,
          showConfirmButton: false
        });
      } else if (action === "updatestatus") {
        Swal.fire({
          icon: "success",
          title: "Berhasil!",
          text: "Status booking berhasil diperbarui 📋",
          footer: "@ Makeup Artist Yola",
          timer: 3000,
          showConfirmButton: false
        });
      } else if (action === "editbooking") {
        Swal.fire({
          icon: "success",
          title: "Berhasil!",
          text: "Data booking berhasil diperbarui ✨",
          footer: "@ Makeup Artist Yola",
          timer: 3000,
          showConfirmButton: false
        });
      } else if (action === "hapusbooking") {
        Swal.fire({
          icon: "success",
          title: "Berhasil!",
          text: "Booking berhasil dihapus 🗑️",
          footer: "@ Makeup Artist Yola",
          timer: 3000,
          showConfirmButton: false
        });
      } else if (action === "tambah") {
        Swal.fire({
          icon: "success",
          title: "Berhasil!",
          text: "Paket makeup berhasil ditambahkan 💄",
          footer: "@ Makeup Artist Yola",
          timer: 3000,
          showConfirmButton: false
        });
      } else if (action === "edit") {
        Swal.fire({
          icon: "success",
          title: "Berhasil!",
          text: "Paket makeup berhasil diperbarui ✨",
          footer: "@ Makeup Artist Yola",
          timer: 3000,
          showConfirmButton: false
        });
      } else if (action === "upload") {
        Swal.fire({
          icon: "success",
          title: "Berhasil!",
          text: "Foto galeri berhasil diunggah 📸",
          footer: "@ Makeup Artist Yola",
          timer: 3000,
          showConfirmButton: false
        });
      } else if (action === "deleteimg") {
        Swal.fire({
          icon: "success",
          title: "Berhasil!",
          text: "Foto galeri berhasil dihapus 🗑️",
          footer: "@ Makeup Artist Yola",
          timer: 3000,
          showConfirmButton: false
        });
      } else if (action === "delete") {
        Swal.fire({
          icon: "success",
          title: "Berhasil!",
          text: "Paket makeup berhasil dihapus 🗑️",
          footer: "@ Makeup Artist Yola",
          timer: 3000,
          showConfirmButton: false
        });
      }

    }

    /* ===================== ERROR ===================== */
    else if (status === "error") {

      Swal.fire({
        icon: "error",
        title: "Gagal!",
        text: msg || "Terjadi kesalahan. Silakan coba lagi 😥",
        footer: "@ Makeup Artist Yola",
        timer: 3000,
        showConfirmButton: false
      });

    }

    /* ===================== WARNING ===================== */
    else if (status === "warning") {

      if (action === "passwordnotsame") {
        Swal.fire({
          icon: "warning",
          title: "Peringatan!",
          text: "Konfirmasi password tidak sama 🤗",
          footer: "@ Makeup Artist Yola",
          timer: 3000,
          showConfirmButton: false
        });
      } else if (action === "userexist") {
        Swal.fire({
          icon: "warning",
          title: "Peringatan!",
          text: "Username sudah digunakan. Silakan ganti 🤗",
          footer: "@ Makeup Artist Yola",
          timer: 3000,
          showConfirmButton: false
        });
      } else {
        Swal.fire({
          icon: "warning",
          title: "Peringatan!",
          text: msg || "Data tidak valid 🤗",
          footer: "@ Makeup Artist Yola",
          timer: 3000,
          showConfirmButton: false
        });
      }

    }

    // Bersihkan URL agar alert tidak muncul ulang
    setTimeout(() => {
      window.history.replaceState({}, document.title, window.location.pathname);
    }, 100);
  }
</script>