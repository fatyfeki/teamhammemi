<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Notre Entreprise</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: white !important; /* Fond blanc forcé */
        }
        .reviews-section {
            max-width: 1000px; /* ou 500px si tu veux plus petit */
            width: 100%;
            margin: 0 auto;
            padding: 1.5rem;
        }
        .contact-form {
            max-width: 1000px; /* ou 500px si tu veux plus petit */
            width: 100%;
            margin: 0 auto;
            padding: 1.5rem;
        }


        /* Ajout de !important pour s'assurer que le style ne sera pas écrasé */
        .container, .hero, .main-content, .reviews-section, 
        .contact-form, .stats-section, footer {
            background-color: inherit !important;
        }

        
     
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
            color: white;
            padding: 4rem 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Main Content */
        .main-content {
            padding: 3rem 0;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            margin-top: 3rem;
        }

        /* Reviews Section */
        .reviews-section {
            background: white !important;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-left:4px;
        }

        .reviews-section h2 {
            color: #1a1a1a !important; /* Correction de la couleur du texte */
            margin-bottom: 2rem;
            font-size: 2rem;
            text-align: center;
        }

        .review-card {
            background: #f8f9fa !important;
            padding: 1.5rem;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            border-left: 2px solid #dc3545;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .review-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(220, 53, 69, 0.1);
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .reviewer-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .reviewer-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #dc3545, #c82333);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .reviewer-name {
            font-weight: 600;
            color: #1a1a1a;
        }

        .stars {
            color: #ffc107;
            font-size: 1.2rem;
        }

        .review-text {
            color: #666;
            line-height: 1.6;
            font-style: italic;
        }

        .review-date {
            color: #999;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        /* Contact Form */
        .contact-form {
            background: white !important;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);

        }

        .contact-form h2 {
            color: #1a1a1a;
            margin-bottom: 2rem;
            font-size: 2rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 600;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .submit-btn {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(220, 53, 69, 0.3);
        }

        /* Stats Section */
        .stats-section {
            background: #1a1a1a !important;
            color: white;
            padding: 3rem 0;
            margin-top: 4rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-card {
            padding: 2rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            color: #dc3545;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Footer */
        footer {
            background: #1a1a1a !important;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            color: #dc3545;
            margin-bottom: 1rem;
        }

        .footer-section p,
        .footer-section a {
            color: #ccc;
            text-decoration: none;
            line-height: 1.6;
        }

        .footer-section a:hover {
            color: #dc3545;
        }

        .footer-bottom {
            border-top: 1px solid #333;
            padding-top: 1rem;
            color: #999;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .header-content {
                flex-direction: column;
                gap: 1rem;
            }

            nav ul {
                gap: 1rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
   <?php include 'header.php'; ?>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Contact us</h1>
            <p>We are here to answer your questions and support you in your projects. Do not hesitate to contact us!</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="main-content">
        <div class="container">
            <div class="content-grid">
                <!-- Reviews Section -->
                <div class="reviews-section">
                    <h2>Customers Reviews</h2>
                    
                    <div class="review-card">
                        <div class="review-header">
                            <div class="reviewer-info">
                                <div class="reviewer-avatar">AS</div>
                                <div>
                                    <div class="reviewer-name">Ahmed Salem</div>
                                    <div class="stars">★★★★★</div>
                                </div>
                            </div>
                        </div>
                        <div class="review-text">
                            "Exceptional service! The team is very professional and responsive. They exceeded my expectations in every way."                        </div>
                        <div class="review-date">2 days ago</div>
                    </div>

                    <div class="review-card">
                        <div class="review-header">
                            <div class="reviewer-info">
                                <div class="reviewer-avatar">FB</div>
                                <div>
                                    <div class="reviewer-name">Fatima Ben Ali</div>
                                    <div class="stars">★★★★★</div>
                                </div>
                            </div>
                        </div>
                        <div class="review-text">
                            "Excellent work! Perfect communication and results beyond my expectations. I highly recommend."
                        </div>
                        <div class="review-date">5 days ago</div>
                    </div>

                    <div class="review-card">
                        <div class="review-header">
                            <div class="reviewer-info">
                                <div class="reviewer-avatar">MK</div>
                                <div>
                                    <div class="reviewer-name">Mohamed Khalil</div>
                                    <div class="stars">★★★★☆</div>
                                </div>
                            </div>
                        </div>
                        <div class="review-text">
                            "Very satisfied with the service provided. Competent and attentive team. Deadlines respected."
                        </div>
                        <div class="review-date"> 1 week ago</div>
                    </div>

                    <div class="review-card">
                        <div class="review-header">
                            <div class="reviewer-info">
                                <div class="reviewer-avatar">LT</div>
                                <div>
                                    <div class="reviewer-name">Leila Trabelsi</div>
                                    <div class="stars">★★★★★</div>
                                </div>
                            </div>
                        </div>
                        <div class="review-text">
                            "A great experience! Outstanding customer service and high-level technical expertise."                        </div>
                        <div class="review-date">1 week ago </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="contact-form">
                    <h2>Envoyez-nous un message</h2>
                    
                    <form id="contactForm">
                        <div class="form-group">
                            <label for="nom">Nom *</label>
                            <input type="text" id="nom" name="nom" required placeholder="Name">
                        </div>

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" required placeholder="Your@email.com">
                        </div>

                        <div class="form-group">
                            <label for="telephone">Téléphone</label>
                            <input type="tel" id="telephone" name="telephone" placeholder="Your phone number">
                        </div>

                        <div class="form-group">
                            <label for="sujet">Sujet *</label>
                            <input type="text" id="sujet" name="sujet" required placeholder="Object of message">
                        </div>

                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea id="message" name="message" required placeholder="Describe your request or project..."></textarea>
                        </div>

                        <button type="submit" class="submit-btn">Envoyer le message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Satisfied customers</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Satisfaction rate</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">24h</div>
                    <div class="stat-label">Response time</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">5+</div>
                    <div class="stat-label">Years of experience</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
 <?php include 'footer.php'; ?>
    <script>
        // Form submission handling
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });
            
            // Simulate form submission
            const submitBtn = this.querySelector('.submit-btn');
            const originalText = submitBtn.textContent;
            
            submitBtn.textContent = 'Envoi en cours...';
            submitBtn.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                alert('Message envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.');
                this.reset();
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe review cards
        document.querySelectorAll('.review-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    </script>
</body>
</html>