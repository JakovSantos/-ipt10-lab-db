<?php
function clean_input(array $src): array {
    $keys = ['first_name','middle_name','last_name','birthday','sex','email',
             'student_number','program','enrolment_date'];
    $d = [];
    foreach ($keys as $k) { $d[$k] = trim((string)($src[$k] ?? '')); }
    return $d;
}

function valid_date(string $v): bool {
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $v)) return false;
    [$y, $m, $d] = array_map('intval', explode('-', $v));
    return checkdate($m, $d, $y);
}

function validate_student(array $d): array {
    $e = [];
    foreach (['first_name' => 'First name', 'last_name' => 'Last name'] as $f => $label) {
        $len = strlen($d[$f]);
        if ($d[$f] === '')                              $e[$f] = "$label is required.";
        elseif ($len < 2 || $len > 100)                 $e[$f] = "$label must be 2 to 100 characters.";
        elseif (!preg_match('/^[A-Za-z\s]+$/', $d[$f])) $e[$f] = "$label must contain letters and spaces only.";
    }
    if ($d['middle_name'] !== '' &&
        (strlen($d['middle_name']) > 100 || !preg_match('/^[A-Za-z\s]+$/', $d['middle_name']))) {
        $e['middle_name'] = 'Middle name must be letters and spaces only (max 100).';
    }
    if ($d['email'] === '')                                  $e['email'] = 'Email is required.';
    elseif (!filter_var($d['email'], FILTER_VALIDATE_EMAIL)
            || strlen($d['email']) > 150)                    $e['email'] = 'Enter a valid email address.';

    if ($d['birthday'] === '')            $e['birthday'] = 'Birthday is required.';
    elseif (!valid_date($d['birthday']))  $e['birthday'] = 'Use a real date in YYYY-MM-DD format.';

    if (!in_array($d['sex'], ['Male', 'Female'], true)) $e['sex'] = 'Select Male or Female.';

    // The column is NOT NULL UNIQUE, so it is required in practice.
    if ($d['student_number'] === '')                              $e['student_number'] = 'Student number is required.';
    elseif (!preg_match('/^[A-Za-z0-9]+$/', $d['student_number'])
            || strlen($d['student_number']) > 50)                 $e['student_number'] = 'Alphanumeric only, max 50 characters.';

    if (strlen($d['program']) > 200) $e['program'] = 'Program must be 200 characters or fewer.';

    if ($d['enrolment_date'] === '')            $e['enrolment_date'] = 'Enrolment date is required.';
    elseif (!valid_date($d['enrolment_date']))  $e['enrolment_date'] = 'Use a real date in YYYY-MM-DD format.';
    return $e;
}

// Turns a MySQL duplicate-key message (error 1062) into a field error.
function duplicate_error(string $msg): array {
    if (stripos($msg, 'email') !== false)          return ['email' => 'This email is already used.'];
    if (stripos($msg, 'student_number') !== false) return ['student_number' => 'This student number is already used.'];
    return ['email' => 'Duplicate record.'];
}
