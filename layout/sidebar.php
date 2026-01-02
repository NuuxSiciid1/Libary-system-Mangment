

<!-- Sidebar -->
<div class="d-flex">
  <nav class="flex-shrink-0 p-3 bg-dark text-white" style="width: 280px; min-height: 100vh;">
    <a href="dashboard.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
      <span class="fs-4">Library System</span>
    </a>
    <hr>

    <ul class="nav nav-pills flex-column mb-auto">

      <!-- DASHBOARD -->
      <li class="nav-item">
        <a href="../pages/dashboard.php" class="nav-link text-white">
          Dashboard
        </a>
      </li>

      <!-- BOOK MANAGEMENT -->
      <li class="nav-item mt-2 text-secondary fw-bold small">BOOKS</li>
      <li><a href="../pages/book.php" class="nav-link text-white">Books</a></li>
      <li><a href="../pages/categories.php" class="nav-link text-white">Categories</a></li>
      <li><a href="../pages/authors.php" class="nav-link text-white">Authors</a></li>
      <li><a href="../pages/publishers.php" class="nav-link text-white">Publishers</a></li>
      <li><a href="../pages/book_locations.php" class="nav-link text-white">Book Locations</a></li>

      <!-- MEMBERS -->
      <li class="nav-item mt-3 text-secondary fw-bold small">MEMBERS</li>
      <li><a href="../pages/members.php" class="nav-link text-white">Members</a></li>
      <li><a href="../pages/membership_plans.php" class="nav-link text-white">Membership Plans</a></li>

      <!-- TRANSACTIONS -->
      <li class="nav-item mt-3 text-secondary fw-bold small">TRANSACTIONS</li>
      <li><a href="../pages/borrow.php" class="nav-link text-white">Borrow book</a></li>
      <li><a href="../pages/late_fees.php" class="nav-link text-white">Late Fees</a></li>

      <!-- FINANCE -->
      <li class="nav-item mt-3 text-secondary fw-bold small">FINANCE</li>
      <li><a href="../pages/payments.php" class="nav-link text-white">Payments</a></li>

      <!-- STAFF & USERS -->
      <li class="nav-item mt-3 text-secondary fw-bold small">ADMIN</li>
      <li><a href="../pages/users.php" class="nav-link text-white">Users</a></li>
      <li><a href="../pages/role.php" class="nav-link text-white">Roles</a></li>

      <!-- REPORTS -->
      <li class="nav-item mt-3 text-secondary fw-bold small">REPORTS</li>
      <li><a href="../reports/book_catalog.php" class="nav-link text-white">Book Catalog</a></li>
      <li><a href="../reports/MemberReport.php" class="nav-link text-white">Member Report</a></li>
      <li><a href="../reports/borrowed.php" class="nav-link text-white">Borrowed Books</a></li>
      <li><a href="../reports/category.php" class="nav-link text-white">Category Report</a></li>
      <li><a href="../reports/new_books.php" class="nav-link text-white">New Books</a></li>

    </ul>

    <hr>

    <!-- LOGOUT -->
    <a href="../auth/logout.php" class="btn btn-outline-light w-100">
      Logout
    </a>
  </nav>

  <!-- MAIN CONTENT -->
  <div class="flex-grow-1 p-4">
    <!-- page content here -->
  </div>
</div>
