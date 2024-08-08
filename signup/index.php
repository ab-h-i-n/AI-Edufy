<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../styles/global.css" />
  <link rel="stylesheet" href="../styles/login-signup.css" />
  <link rel="stylesheet" href="./signup.css" />
  <script src="../scripts/login-signup.js" defer></script>
  <title>Sign Up</title>
</head>

<body>
  <?php
  include ('../common/header.php')
    ?>
  <main>
      <form class="auth-form signup" method="post">
        <img src="../public/logo.svg" alt="logo" class="logo" />
        <p class="title">SIGN UP</p>
        <div class="inputs-container">
          <input class="form-input" type="text" name="name" placeholder="Name" />
          <input class="form-input" type="text" name="username" placeholder="Username" />
          <input class="form-input" type="email" name="email" placeholder="Email" />
          <div class="password-container">
            <input class="form-input" type="password" name="password" placeholder="Password" />
            <!-- eye images  -->
            <div class="eye-container">
              <img class="eye-open eye" src="../public/icons/eye-open.svg" alt="eye-open" />
              <img class="eye-closed eye hidden" src="../public/icons/eye-closed.svg" alt="eye-closed" />
            </div>
          </div>

          <select name="role">
            <option value="">Select Your Role</option>
            <option value="learner">Learner</option>
            <option value="mentor">Mentor</option>
          </select>

        </div>
        <button class="submit" type="submit">Sign Up</button>
    </section>
    </form>
  </main>
</body>

</html>