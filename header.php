<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Home</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-red: #b3001b;
      --secondary-red: #ff1e3c;
      --dark-black: #0d0d0d;
      --medium-black: #1a1a1a;
      --text-primary: #FFFFFF;
      --text-secondary: #cccccc;
      --shadow-red: 0 8px 25px rgba(255, 30, 60, 0.4);
      --transition-smooth: all 0.4s ease;
    }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, var(--dark-black), var(--medium-black));
      color: var(--text-primary);
    }

    header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 15px 5%;
      background: rgba(13, 13, 13, 0.85);
      backdrop-filter: blur(10px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
      position: sticky;
      top: 0;
      z-index: 1000;
      border-bottom: 1px solid rgba(255, 30, 60, 0.4);
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 12px;
      cursor: pointer;
      transition: var(--transition-smooth);
    }

    .logo-img {
      width: 55px;
      height: 55px;
      border-radius: 50%;
      overflow: hidden;
      border: 2px solid var(--primary-red);
      box-shadow: 0 0 15px rgba(255, 30, 60, 0.6);
      flex-shrink: 0;
      transition: var(--transition-smooth);
    }

    .logo-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .logo-text {
      font-weight: 600;
      font-size: 1.1rem;
      color: var(--text-primary);
      transition: var(--transition-smooth);
    }

    .logo:hover .logo-img {
      transform: scale(1.1);
    }

    .logo:hover .logo-text {
      color: var(--secondary-red);
      text-shadow: 0 0 10px rgba(255, 30, 60, 0.7);
    }

    .nav-links {
      display: flex;
      justify-content: center;
      flex: 2;
    }

    .nav-links a {
      margin: 0 18px;
      text-decoration: none;
      color: var(--text-secondary);
      font-weight: 500;
      position: relative;
      transition: var(--transition-smooth);
    }

    .nav-links a::after {
      content: "";
      display: block;
      width: 0;
      height: 2px;
      background: var(--primary-red);
      transition: var(--transition-smooth);
      position: absolute;
      bottom: -5px;
      left: 0;
    }

    .nav-links a:hover {
      color: var(--text-primary);
      transform: scale(1.05);
      text-shadow: 0 0 10px rgba(255, 30, 60, 0.7);
    }

    .nav-links a:hover::after {
      width: 100%;
    }

    .auth-buttons {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .auth-buttons button {
      padding: 10px 22px;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      font-weight: 600;
      transition: var(--transition-smooth);
      background: rgba(255, 255, 255, 0.08);
      color: var(--text-primary);
      border: 1px solid rgba(255, 30, 60, 0.4);
    }

    .auth-buttons button:hover {
      transform: translateY(-3px);
      background: rgba(255, 255, 255, 0.15);
      box-shadow: var(--shadow-red);
    }

    .signup-btn {
      background: linear-gradient(135deg, var(--primary-red), var(--secondary-red));
      color: #fff;
      box-shadow: var(--shadow-red);
    }

    .signup-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 30px rgba(255, 30, 60, 0.6);
    }

    .lang {
      display: flex;
      align-items: center;
      cursor: pointer;
      transition: var(--transition-smooth);
      color: var(--text-secondary);
      padding: 5px 10px;
      border-radius: 20px;
    }

    .lang img {
      width: 22px;
      margin-right: 6px;
      border-radius: 50%;
      box-shadow: 0 0 8px rgba(0, 0, 0, 0.3);
    }

    .lang:hover {
      color: var(--text-primary);
      background: rgba(255, 255, 255, 0.1);
      transform: scale(1.05);
    }

    .search-bar {
      display: flex;
      justify-content: center;
      max-width: 700px;
      margin: 50px auto;
      border-radius: 50px;
      overflow: hidden;
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 30, 60, 0.3);
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
    }

    .search-bar input[type="text"] {
      flex: 1;
      padding: 15px 25px;
      border: none;
      outline: none;
      background: transparent;
      color: var(--text-primary);
      font-size: 1rem;
    }

    .search-bar input[type="text"]::placeholder {
      color: rgba(255, 255, 255, 0.6);
    }

    .search-btn {
      padding: 0 25px;
      border: none;
      background: linear-gradient(135deg, var(--primary-red), var(--secondary-red));
      color: #fff;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition-smooth);
    }

    .search-btn:hover {
      transform: scale(1.05);
      box-shadow: 0 10px 25px rgba(255, 30, 60, 0.6);
    }

    @media (max-width: 768px) {
      header {
        flex-direction: column;
        padding: 15px 20px;
      }

      .nav-links {
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 10px;
      }

      .auth-buttons {
        margin-top: 15px;
      }

      .search-bar {
        margin: 30px 20px;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">
      <div class="logo-img">
        <img src="log.png" alt="Logo" />
      </div>
      <div class="logo-text">CH Office Track</div>
    </div>
    <nav class="nav-links">
      <a href="home.php">Home</a>
      <a href="contact.php">Contact Us</a>
      <a href="partner.php">Partner</a>
      <a href="aboutus.php">About Us</a>
    </nav>
    
  </header>

  <div class="search-bar">
    <input type="text" placeholder="Search for products, features..." />
    <button class="search-btn"><i class="fas fa-search"></i></button>
  </div>
</body>
</html>
