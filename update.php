<?php

include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $nim = isset($_POST['nim']) ? $_POST['nim'] : '';
        $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $jurusan = isset($_POST['jurusan']) ? $_POST['jurusan'] : '';
        $fakultas = isset($_POST['fakultas']) ? $_POST['fakultas'] : '';
        $gambar = isset($_POST['gambar']) ? $_POST['gambar'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE mahasiswa SET id = ?, nim = ?, nama = ?, email = ?, jurusan = ?, fakultas = ?, gambar = ? WHERE id = ?');
        $stmt->execute([$id, $nim, $nama, $email, $jurusan, $fakultas, $gambar, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM mahasiswa WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update Contact #<?=$contact['id']?></h2>
    <form action="update.php?id=<?=$contact['id']?>" method="post">
        <label for="nim">Nim</label>
        <input type="text" name="nim" value="<?=$contact['nim']?>" id="nim">

        <label for="nama">Nama</label>
        <input type="text" name="nama" value="<?=$contact['nama']?>" id="nama">

        <label for="email">Email</label>
        <input type="text" name="email" value="<?=$contact['email']?>" id="email">

        <label for="jurusan">Jurusan</label>
        <input type="text" name="jurusan" value="<?=$contact['jurusan']?>" id="jurusan">

        <label for="fakultas">Fakultas</label>
        <input type="text" name="fakultas" value="<?=$contact['fakultas']?>" id="fakultas">

        <label for="gambar">Gambar</label>
        <input type="file" name="gambar" size="50"/>

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>