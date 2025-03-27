<?php
require("../sistem/koneksi.php");

$hub = open_connection();
$a = @$_GET["a"];
$id = @$_GET["id"];
$sql = @$_POST["sql"];

switch ($sql) {
    case "create":
        create_prodi();
        break;
    case "update":
        update_prodi();
        break;
    case "delete":
        delete_prodi();
        break;
}

switch ($a) {
    case "list":
        read_data();
        break;
    case "input":
        input_data();
        break;
        case "edit":
            edit_data($id);
            break;
        case "hapus":
            hapus_data($id);
            break;
        default:
            read_data();
            break;
        }
        mysqli_close($hub);
        ?>
        
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f5f5f5;
        }

        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        /* Navigasi */
        nav {
            background-color: #004080;
            overflow: hidden;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        nav ul {
            list-style: none;
            text-align: center;
        }

        nav ul li {
            display: inline;
            padding: 10px 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table thead {
            background-color: #004080;
            color: white;
        }

        table th, table td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 10px;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        table a {
            text-decoration: none;
            font-weight: bold;
        }

        .edit-link {
            color: #007BFF;
        }

        .delete-link {
            color: #FF0000;
        }

        .edit-link:hover, .delete-link:hover {
            text-decoration: underline;
        }

        /* Footer */
        footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background-color: #004080;
            color: white;
            border-radius: 5px;
        }

        /* Tombol Tambah Data */
        .btn-primary {
            display: inline-block;
            background-color: #004080;
            color: #fff;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .btn-primary:hover {
            background-color: #003366;
        }
    </style>


        <?php
        function read_data() {
            global $hub;
            $query = "select * from dt_prodi";
            $result = mysqli_query($hub, $query); ?>
        
            <h2>Read Data Program Studi</h2>
            <table border=1 cellpadding=2>
                <tr>
                    <td colspan="5"><a href="curd_4.php?a=input">INPUT</a></td>
                </tr>
                <tr>
                    <td>ID</td>
                    <td>KODE</td>
                    <td>NAMA PRODI</td>
                    <td>AKREDITASI</td>
                    <td>AKSI</td>
                </tr>
                <?php while($row = mysqli_fetch_array($result)) { ?>
                <tr>
                    <td><?php echo $row['idprodi']; ?></td>
                    <td><?php echo $row['kdprodi']; ?></td>
                    <td><?php echo $row['nmprodi']; ?></td>
                    <td><?php echo $row['akreditasi']; ?></td>
                    <td>
                        <a href="curd_4.php?a=edit&id=<?php echo $row['idprodi']; ?>">EDIT</a>
                        <a href="curd_4.php?a=hapus&id=<?php echo $row['idprodi']; ?>">HAPUS</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        <?php } ?>
        <?php
function input_data() {
    $row = array(
        "kdprodi" => "",
        "nmprodi" => "",
        "akreditasi" => ""
    ); ?>

    <h2>Input Data Program Studi</h2>
    <form action="curd_4.php?a=list" method="post">
        <input type="hidden" name="sql" value="create">
        
        Kode Prodi
        <input type="text" name="kdprodi" maxlength="6" size="6"
        value="<?php echo trim($row['kdprodi']) ?>" />
        <br>
        
        Nama Prodi
        <input type="text" name="nmprodi" maxlength="70" size="70"
        value="<?php echo trim($row['nmprodi']) ?>" />
        <br>
        
        Akreditasi Prodi
        <input type="radio" name="akreditasi" value="-" <?php 
        if ($row['akreditasi']=='-' || $row['akreditasi']=='') { echo "checked=\"checked\""; } ?> > -
        
        <input type="radio" name="akreditasi" value="A" <?php 
        if ($row['akreditasi']=='A') { echo "checked=\"checked\""; } ?> > A
        
        <input type="radio" name="akreditasi" value="B" <?php 
        if ($row['akreditasi']=='B') { echo "checked=\"checked\""; } ?> > B
        
        <input type="radio" name="akreditasi" value="C" <?php 
        if ($row['akreditasi']=='C') { echo "checked=\"checked\""; } ?> > C
        <br>

        <input type="submit" name="action" value="Simpan">
    </form>
    
    <a href="curd_4.php?a=list">Batal</a>

<?php } ?>
<?php
function edit_data($id) {
    global $hub;
    $query = "select * from dt_prodi where idprodi = $id";
    $result = mysqli_query($hub, $query);
    $row = mysqli_fetch_array($result);
?>

<h2>Edit Data Program Studi</h2>
<form action="curd_4.php?a=list" method="post">
    <input type="hidden" name="sql" value="update">
    <input type="hidden" name="idprodi" value="<?php echo trim($id) ?>" />

    Kode Prodi
    <input type="text" name="kdprodi" maxlength="6" size="6"
    value="<?php echo trim($row['kdprodi']) ?>" />
    <br>

    Nama Prodi
    <input type="text" name="nmprodi" maxlength="70" size="70"
    value="<?php echo trim($row['nmprodi']) ?>" />
    <br>

    Akreditasi Prodi
    <input type="radio" name="akreditasi" value="-" <?php 
    if ($row['akreditasi']=='-' || $row['akreditasi']=='') { echo "checked=\"checked\""; } ?> > -

    <input type="radio" name="akreditasi" value="A" <?php 
    if ($row['akreditasi']=='A') { echo "checked=\"checked\""; } ?> > A

    <input type="radio" name="akreditasi" value="B" <?php 
    if ($row['akreditasi']=='B') { echo "checked=\"checked\""; } ?> > B

    <input type="radio" name="akreditasi" value="C" <?php 
    if ($row['akreditasi']=='C') { echo "checked=\"checked\""; } ?> > C
    <br>

    <input type="submit" name="action" value="Simpan">
</form>

<a href="curd_4.php?a=list">Batal</a>

<?php } ?>
<?php
function hapus_data($id) {
    global $hub;
    $query = "select * from dt_prodi where idprodi = $id";
    $result = mysqli_query($hub, $query);
    $row = mysqli_fetch_array($result);
?>

<h2>Hapus Data Program Studi</h2>
<form action="curd_4.php?a=list" method="post">
    <input type="hidden" name="sql" value="delete">
    <input type="hidden" name="idprodi" value="<?php echo trim($id) ?>" />
    <table>
        <tr>
            <td width=100>Kode</td>
            <td><?php echo trim($row['kdprodi']) ?></td>
        </tr>
        <tr>
            <td>Nama Prodi</td>
            <td><?php echo trim($row['nmprodi']) ?></td>
        </tr>
        <tr>
            <td>Akreditasi</td>
            <td><?php echo trim($row['akreditasi']) ?></td>
        </tr>
    </table>

    <input type="submit" name="action" value="Hapus">
</form>

<a href="curd_4.php?a=list">Batal</a>

<?php } ?>

<?php
function create_prodi() {
    global $hub;
    global $_POST;
    $query = "INSERT INTO dt_prodi (kdprodi, nmprodi, akreditasi) 
    VALUES ('".$_POST["kdprodi"]."', '".$_POST["nmprodi"]."', '".$_POST["akreditasi"]."')";
    mysqli_query($hub, $query) or die(mysqli_error($hub));
}
function update_prodi() {
    global $hub;
    global $_POST;
    $query = "UPDATE dt_prodi";
    $query .= " SET kdprodi='". $_POST["kdprodi"]."', nmprodi='".
    $_POST["nmprodi"]."', akreditasi='". $_POST["akreditasi"]."'";
    $query .= " WHERE idprodi = ".$_POST["idprodi"];
    mysqli_query($hub, $query) or die(mysqli_error());
}

function delete_prodi() {
    global $hub;
    global $_POST;
    $query = "DELETE FROM dt_prodi";
    $query .= " WHERE idprodi = ".$_POST["idprodi"];
    mysqli_query($hub, $query) or die(mysqli_error());
}
?>