<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IPT10 - AUF CCS Student Records</title>
  
  <!-- Inter Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
  
  <!-- Bootstrap 5 & Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  
  <!-- Modern AUF Crimson Styling & Lowkey PDO Indicators -->
  <style>
    :root {
      /* AUF Crimson Palette */
      --auf-red-primary: #dc2626;
      --auf-red-dark: #991b1b;
      --auf-red-light: #f87171;
      --red-gradient: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
      --red-gradient-hover: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
      
      --bg-gradient: radial-gradient(circle at 0% 0%, #fef2f2 0%, #f1f5f9 100%);
      --card-bg: rgba(255, 255, 255, 0.92);
      --border-color: rgba(254, 202, 202, 0.6);
      
      --text-main: #0f172a;
      --text-muted: #64748b;
      
      /* Dynamic Shadows */
      --shadow-sm: 0 2px 4px rgba(153, 27, 27, 0.04);
      --shadow-md: 0 10px 15px -3px rgba(153, 27, 27, 0.05), 0 4px 6px -4px rgba(153, 27, 27, 0.03);
      --shadow-hover: 0 20px 25px -5px rgba(220, 38, 38, 0.18), 0 8px 10px -6px rgba(220, 38, 38, 0.1);

      /* Physics Curve */
      --transition-fast: cubic-bezier(0.16, 1, 0.3, 1);
    }

    body {
      font-family: 'Inter', system-ui, -apple-system, sans-serif;
      background: var(--bg-gradient);
      color: var(--text-main);
      min-height: 100vh;
      -webkit-font-smoothing: antialiased;
    }

    /* Code Font for PDO Tags */
    .font-mono {
      font-family: 'JetBrains Mono', monospace;
    }

    /* Navbar Styling */
    .navbar-custom {
      background: rgba(15, 23, 42, 0.94);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-bottom: 2px solid var(--auf-red-primary);
      padding: 0.85rem 0;
    }

    .navbar-custom .navbar-brand {
      font-weight: 800;
      letter-spacing: -0.025em;
      font-size: 1.25rem;
      color: #ffffff;
      display: inline-flex;
      align-items: center;
      gap: 0.6rem;
      transition: transform 0.3s var(--transition-fast);
    }

    .navbar-custom .navbar-brand:hover {
      transform: translateY(-1px);
    }

    /* AUF Crimson Brand Badge */
    .navbar-custom .brand-badge {
      background: var(--red-gradient);
      color: #ffffff;
      padding: 0.25rem 0.6rem;
      border-radius: 6px;
      font-size: 0.8rem;
      font-weight: 700;
      letter-spacing: 0.05em;
      box-shadow: 0 2px 8px rgba(220, 38, 38, 0.4);
    }

    .navbar-custom .navbar-brand span.title-text {
      background: linear-gradient(135deg, #ffffff 0%, #fca5a5 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    /* Lowkey PDO Connection Indicator */
    .pdo-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid rgba(255, 255, 255, 0.12);
      border-radius: 20px;
      padding: 0.25rem 0.7rem;
      font-size: 0.75rem;
      color: #cbd5e1;
      letter-spacing: 0.02em;
      transition: all 0.2s ease;
    }

    .pdo-badge:hover {
      background: rgba(255, 255, 255, 0.1);
      border-color: rgba(254, 202, 202, 0.3);
      color: #f1f5f9;
    }

    .pdo-dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background-color: #22c55e;
      box-shadow: 0 0 6px #22c55e;
    }

    /* Card Styling */
    .card {
      background: var(--card-bg);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1px solid var(--border-color);
      border-radius: 16px;
      box-shadow: var(--shadow-md);
      transition: transform 0.3s var(--transition-fast), 
                  box-shadow 0.3s var(--transition-fast), 
                  border-color 0.3s var(--transition-fast);
      will-change: transform, box-shadow;
    }

    .card:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow-hover);
      border-color: rgba(220, 38, 38, 0.35);
    }

    /* Buttons */
    .btn-primary {
      background: var(--red-gradient);
      border: none;
      border-radius: 10px;
      font-weight: 600;
      padding: 0.65rem 1.35rem;
      color: #ffffff;
      box-shadow: 0 4px 14px rgba(220, 38, 38, 0.3);
      transition: transform 0.25s var(--transition-fast), 
                  box-shadow 0.25s var(--transition-fast), 
                  filter 0.25s ease;
    }

    .btn-primary:hover {
      background: var(--red-gradient-hover);
      filter: brightness(1.05);
      transform: translateY(-2px);
      box-shadow: 0 8px 22px rgba(220, 38, 38, 0.45);
    }

    .btn-primary:active {
      transform: translateY(0);
      box-shadow: 0 2px 8px rgba(220, 38, 38, 0.25);
    }

    /* Form Inputs */
    .form-control, .form-select {
      border-radius: 10px;
      border: 1px solid #cbd5e1;
      padding: 0.65rem 0.9rem;
      font-size: 0.95rem;
      background-color: #ffffff;
      transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }

    .form-control:hover, .form-select:hover {
      border-color: #fca5a5;
    }

    .form-control:focus, .form-select:focus {
      border-color: var(--auf-red-primary);
      box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.15);
      transform: translateY(-1px);
    }

    /* Tables */
    .table-responsive {
      border-radius: 16px;
      border: 1px solid var(--border-color);
      background: #ffffff;
      overflow: hidden;
      box-shadow: var(--shadow-md);
      transition: box-shadow 0.3s var(--transition-fast);
    }

    .table-responsive:hover {
      box-shadow: var(--shadow-hover);
    }

    .table {
      margin-bottom: 0;
    }

    .table thead th {
      background-color: #fef2f2;
      color: var(--auf-red-dark);
      font-weight: 700;
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      border-bottom: 2px solid #fecaca;
      padding: 1rem 1.25rem;
    }

    .table tbody tr {
      transition: background-color 0.2s ease;
    }

    .table tbody tr:hover {
      background-color: rgba(220, 38, 38, 0.04);
    }

    .table tbody td {
      padding: 1rem 1.25rem;
      vertical-align: middle;
      color: var(--text-main);
      border-bottom: 1px solid #f1f5f9;
    }

    .table tbody tr:last-child td {
      border-bottom: none;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom sticky-top mb-4">
  <div class="container d-flex justify-content-between align-items-center">
    <a class="navbar-brand" href="index.php">
      <span class="brand-badge">AUF CCS</span>
      <span class="title-text">Student Records</span>
    </a>

    <!-- Lowkey PDO Driver Indicator -->
    <div class="pdo-badge font-mono" title="Connected via PHP Data Objects (PDO)">
      <span class="pdo-dot"></span>
      <span>PDO: MySQL</span>
    </div>
  </div>
</nav>

<div class="container pb-5">