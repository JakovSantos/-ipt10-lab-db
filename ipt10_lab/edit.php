<?php
require_once 'db_connect.php';
require_once 'validation.php';
$id = trim($_GET['id'] ?? '');
if ($id === '') { die('Invalid student ID'); }

$errors = [];
$message = '';

$s = $conn->prepare('SELECT * FROM students WHERE id = ?');
$s->bind_param('s', $id);
$s->execute();
$existing = $s->get_result()->fetch_assoc();
$s->close();

require 'header.php';
if (!$existing) {
    echo '<div class="alert alert-warning">Student not found.</div><a href="index.php">Back</a>';
    $conn->close(); require 'footer.php'; exit;
}

$d = clean_input($existing);   // pre-fill from the database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $d = clean_input($_POST);                                    // TODO 15
    $errors = validate_student($d);

    if (empty($errors)) {
        try {
            $stmt = $conn->prepare('UPDATE students SET first_name = ?, middle_name = ?,
                last_name = ?, birthday = ?, sex = ?, email = ?, student_number = ?,
                program = ?, enrolment_date = ? WHERE id = ?');  // TODO 16
            $middle = $d['middle_name'] === '' ? null : $d['middle_name'];
            $stmt->bind_param('ssssssssss', $d['first_name'], $middle, $d['last_name'],
                $d['birthday'], $d['sex'], $d['email'], $d['student_number'],
                $d['program'], $d['enrolment_date'], $id);
            $stmt->execute();
            // TODO 17: affected_rows
            if ($stmt->affected_rows === 1) {
                $message = 'Student updated successfully.';
            } else {
                $message = 'No changes were made (the submitted values match the saved record).';
            }
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) { $errors = duplicate_error($e->getMessage()); }
            else { error_log($e->getMessage()); $errors['sex'] = 'Could not update the record.'; }
        }
    }
}
?>
<h2>Edit Student</h2>
<?php if ($message): ?><div class="alert alert-info"><?= htmlspecialchars($message) ?></div><?php endif; ?>
<?php $submitLabel = 'Update Student'; require '_form.php'; ?>
<?php $conn->close(); require 'footer.php'; ?>
