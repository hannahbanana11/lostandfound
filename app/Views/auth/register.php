<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | LostAndFoundManagement</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card shadow-lg border-0 rounded-4">
          <div class="card-body p-4">
            <h3 class="text-center mb-4 text-success">📝 Register</h3>

            <form action="/auth/save" method="post">
              <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Enter username" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Register as</label>
                <select name="role" class="form-control" required>
                  <option value="user">Regular User</option>
                  <option value="admin">Admin</option>
                </select>
              </div>

              <button type="submit" class="btn btn-success w-100">Register</button>
            </form>

            <p class="text-center mt-3 mb-0">
              Already have an account?
              <a href="/auth" class="text-decoration-none">Login here</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
