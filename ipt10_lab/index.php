<?php
require_once 'db_connect.php';
$sql = 'SELECT id, first_name, last_name, email, enrolment_date
        FROM students ORDER BY enrolment_date DESC, id DESC';   // TODO 4
$result = mysqli_query($conn, $sql);
require 'header.php';
?>
<div class="d-flex justify-content-between mb-3">
  <h2>All Student Records</h2>
  <a class="btn btn-success" href="create.php">Add Student</a>
</div>
<div class="table-responsive">
<table class="table table-striped table-bordered bg-white">
  <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Enrolled</th><th>Actions</th></tr></thead>
  <tbody>
  <?php while ($row = mysqli_fetch_assoc($result)): ?>   <!-- TODO 5 -->
    <tr>
      <td><?= htmlspecialchars($row['id']) ?></td>
      <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= htmlspecialchars($row['enrolment_date']) ?></td>
      <td>
        <a class="btn btn-sm btn-info" href="view.php?id=<?= urlencode($row['id']) ?>">View</a>
        <a class="btn btn-sm btn-warning" href="edit.php?id=<?= urlencode($row['id']) ?>">Edit</a>
        <a class="btn btn-sm btn-danger" href="delete.php?id=<?= urlencode($row['id']) ?>">Delete</a>
      </td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
</div>
<?php
mysqli_free_result($result);   // TODO 6: free the result first
mysqli_close($conn);           // then close the connection
require 'footer.php';
