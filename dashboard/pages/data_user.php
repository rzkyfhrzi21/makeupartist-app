<?php

// Memeriksa level user
if ($_SESSION['sesi_role'] !== 'admin') {
    return;
}

?>

<!-- Basic Tables start -->
<section class="section table">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                Data User
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="example1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID User</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include '../functions/koneksi.php';
                        $no = 1;

                        // Ambil semua user (kalau mau hanya klien, tambahkan WHERE role = 'klien')
                        $query     = "SELECT * FROM users ORDER BY id_user ASC";
                        $sql_query = mysqli_query($koneksi, $query);

                        while ($users = mysqli_fetch_array($sql_query)) :
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= htmlspecialchars($users['id_user'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars($users['nama_user'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars($users['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars($users['username'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="text-capitalize">
                                    <?= htmlspecialchars($users['role'], ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                                <td>
                                    <!-- Sesuaikan target page sesuai struktur project kamu -->
                                    <a href="admin?page=profile&id=<?= htmlspecialchars($users['id_user'], ENT_QUOTES, 'UTF-8'); ?>"
                                        class="btn btn-secondary btn-sm">
                                        Edit / Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- Basic Tables end -->