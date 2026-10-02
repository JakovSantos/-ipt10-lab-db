<?php
require_once 'db_connect.php';
require_once 'validation.php';
$errors = [];
$d = clean_input([]);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $d = clean_input($_POST);
    $errors = validate_student($d);                              // TODO 10-12

    if (empty($errors)) {
        try {
            // TODO 13: 9 placeholders (id is UUID() in SQL)
            $stmt = $conn->prepare('INSERT INTO students
                (id, first_name, middle_name, last_name, birthday, sex, email,
                 student_number, program, enrolment_date)
                VALUES (UUID(), ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $middle = $d['middle_name'] === '' ? null : $d['middle_name'];
            // TODO 14: nine strings -> 'sssssssss'
            $stmt->bind_param('sssssssss', $d['first_name'], $middle, $d['last_name'],
                $d['birthday'], $d['sex'], $d['email'], $d['student_number'],
                $d['program'], $d['enrolment_date']);
            $stmt->execute();
            if ($stmt->affected_rows === 1) {                    // no insert_id with UUID
                $message = 'Student created successfully!';
                $d = clean_input([]);
            }
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) { $errors = duplicate_error($e->getMessage()); }
            else { error_log($e->getMessage()); $errors['sex'] = 'Could not save the record.'; }
        }
    }
}
require 'header.php';
?>
<h2>Add New Student</h2>
<?php if ($message): ?><div class="alert alert-success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
<?php $submitLabel = 'Save Student'; require '_form.php'; ?>
<?php $conn->close(); require 'footer.php'; ?>
