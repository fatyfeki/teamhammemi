<?php include("header.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Why Choose CH Office Track? Discover the Key Benefits!</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Bordeaux Palette */
            --primary-bordeaux: #8b0000;
            --secondary-bordeaux: #5a0000;
            --accent-bordeaux: #a52a2a;
            --dark-bordeaux: #4B0000;
            --light-bordeaux: #B03060;
            --bordeaux-glow: rgba(139, 0, 0, 0.3);
            --bordeaux-soft: rgba(139, 0, 0, 0.1);
            
            /* Gray Palette */
            --dark-gray: #1A1A1A;
            --medium-gray: #2D2D2D;
            --light-gray: #3A3A3A;
            --soft-gray: #4A4A4A;
            --text-gray: #B0B0B0;
            --border-gray: #333333;
            
            /* Text Colors */
            --text-primary: #FFFFFF;
            --text-secondary: #E0E0E0;
            --text-muted: #A0A0A0;
            
            /* Gradients */
            --gradient-bordeaux: linear-gradient(135deg, var(--primary-bordeaux) 0%, var(--secondary-bordeaux) 100%);
            --gradient-bordeaux-soft: linear-gradient(135deg, var(--bordeaux-soft) 0%, var(--bordeaux-glow) 100%);
            --gradient-dark: linear-gradient(135deg, var(--dark-bordeaux) 0%, var(--primary-bordeaux) 100%);
            --gradient-card: linear-gradient(145deg, var(--dark-gray) 0%, var(--medium-gray) 100%);
            
            /* Shadows */
            --shadow-soft: 0 4px 20px rgba(0, 0, 0, 0.1);
            --shadow-medium: 0 8px 30px rgba(0, 0, 0, 0.15);
            --shadow-strong: 0 12px 40px rgba(0, 0, 0, 0.2);
            --shadow-bordeaux: 0 8px 25px rgba(139, 0, 0, 0.3);
            --shadow-bordeaux-hover: 0 12px 35px rgba(139, 0, 0, 0.4);
            
            /* Transitions */
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-bounce: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #000000 0%, #1a0000 50%, #2b2b2b 100%);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 30%, var(--bordeaux-glow) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, var(--bordeaux-glow) 0%, transparent 50%);
            opacity: 0.3;
            z-index: -1;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
        }
        
        /* Enhanced Page Header */
        .page-header {
            text-align: center;
            margin-bottom: 80px;
            position: relative;
        }
        
        .page-header::before {
            content: '';
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 6px;
            background: var(--gradient-bordeaux);
            border-radius: 3px;
            box-shadow: var(--shadow-bordeaux);
        }
        
        .page-title {
            font-family: 'Poppins', sans-serif;
            font-size: 3.2rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 20px;
            line-height: 1.2;
            background: linear-gradient(45deg, #fff, var(--primary-bordeaux));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            display: inline-block;
            text-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        
        .page-subtitle {
            font-size: 1.2rem;
            color: var(--text-secondary);
            font-weight: 400;
            margin-top: 15px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            opacity: 0.9;
        }
        
        /* Enhanced Benefits Section */
        .benefits-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 40px;
            margin-bottom: 80px;
        }
        
        .benefit-card {
            background: rgba(37, 37, 37, 0.9);
            border-radius: 24px;
            padding: 40px 35px;
            box-shadow: var(--shadow-medium);
            transition: var(--transition-bounce);
            position: relative;
            overflow: hidden;
            border: 1px solid var(--border-gray);
            backdrop-filter: blur(10px);
        }
        
        .benefit-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--gradient-bordeaux);
            border-radius: 24px 24px 0 0;
        }
        
        .benefit-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
            opacity: 0.3;
        }
        
        .benefit-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: var(--shadow-strong);
        }
        
        .benefit-card > * {
            position: relative;
            z-index: 2;
        }
        
        .icon-container {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            color: var(--primary-bordeaux);
            margin-bottom: 25px;
            transition: var(--transition-bounce);
            border: 2px solid var(--bordeaux-glow);
            box-shadow: var(--shadow-bordeaux);
            backdrop-filter: blur(10px);
        }
        
        .benefit-card:hover .icon-container {
            transform: scale(1.1) rotate(5deg);
            background: var(--gradient-bordeaux);
            color: white;
            box-shadow: var(--shadow-bordeaux-hover);
        }
        
        .benefit-card h2,
        .benefit-card h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 15px;
            line-height: 1.3;
        }
        
        .benefit-card p {
            color: var(--text-secondary);
            font-size: 1.05rem;
            line-height: 1.7;
            margin-bottom: 20px;
            opacity: 0.8;
        }
        
        .divider {
            height: 2px;
            background: var(--gradient-bordeaux);
            margin: 25px 0;
            border-radius: 2px;
            opacity: 0.3;
            transition: var(--transition-smooth);
        }
        
        .benefit-card:hover .divider {
            opacity: 1;
            box-shadow: 0 0 10px var(--bordeaux-glow);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        /* Enhanced Stats Section */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin: 60px auto;
            max-width: 1100px;
        }
        
        .stat-item {
            background: rgba(37, 37, 37, 0.9);
            border-radius: 20px;
            padding: 35px 30px;
            display: flex;
            align-items: center;
            gap: 25px;
            transition: var(--transition-bounce);
            border: 1px solid var(--border-gray);
            box-shadow: var(--shadow-medium);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }
        
        .stat-item::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--gradient-bordeaux);
            transform: translateY(100%);
            transition: var(--transition-smooth);
        }
        
        .stat-item:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: var(--shadow-strong);
        }
        
        .stat-item:hover::before {
            transform: translateY(0);
        }
        
        .stat-icon {
            width: 75px;
            height: 75px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--primary-bordeaux);
            transition: var(--transition-bounce);
            border: 2px solid var(--bordeaux-glow);
            box-shadow: var(--shadow-bordeaux);
            backdrop-filter: blur(10px);
        }
        
        .stat-item:hover .stat-icon {
            transform: scale(1.1);
            background: var(--gradient-bordeaux);
            color: white;
            box-shadow: var(--shadow-bordeaux-hover);
        }
        
        .stat-content {
            flex: 1;
        }
        
        .stat-number {
            font-family: 'Poppins', sans-serif;
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--primary-bordeaux);
            line-height: 1;
            margin-bottom: 8px;
            text-shadow: 0 0 20px var(--bordeaux-glow);
        }
        
        .stat-label {
            font-size: 1.1rem;
            color: var(--text-secondary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.8;
        }

        /* 3D Carousel Section - Updated with TB style */
        .carousel-section {
            width: 100%;
            padding: 100px 0;
            background: linear-gradient(135deg, #000000 0%, #1a0000 50%, #2b2b2b 100%);
            margin-top: 40px;
            position: relative;
            border-top: 1px solid var(--border-gray);
        }
        
        .carousel-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 30%, var(--bordeaux-glow) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, var(--bordeaux-glow) 0%, transparent 50%);
            opacity: 0.3;
        }
        
        .carousel-wrapper {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            perspective: 1000px;
            transform-style: preserve-3d;
            color: white;
            padding: 0 5%;
            max-width: 1400px;
            margin: 0 auto;
            min-height: 600px;
            position: relative;
            z-index: 2;
        }
        
        .welcome-section {
            width: 40%;
            min-width: 400px;
            padding: 50px;
            background: rgba(37, 37, 37, 0.9);
            border-radius: 30px;
            border: 1px solid var(--border-gray);
            box-shadow: var(--shadow-strong);
            margin-right: 5%;
            position: relative;
            backdrop-filter: blur(20px);
        }
        
        .welcome-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--gradient-bordeaux);
            border-radius: 30px 30px 0 0;
        }

        .welcome-section::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
            opacity: 0.3;
        }
        
        .welcome-section h1 {
            font-family: 'Poppins', sans-serif;
            color: white;
            margin-bottom: 25px;
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(45deg, #fff, var(--primary-bordeaux));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        
        .welcome-section p {
            color: var(--text-secondary);
            margin-bottom: 35px;
            line-height: 1.8;
            font-size: 1.15rem;
            font-weight: 400;
            opacity: 0.8;
        }
        
        .btn {
            display: inline-block;
            padding: 15px 40px;
            background: var(--gradient-bordeaux);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: var(--transition-bounce);
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            box-shadow: var(--shadow-bordeaux);
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: var(--transition-smooth);
            z-index: -1;
        }
        
        .btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: var(--shadow-bordeaux-hover);
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .carousel-container {
            width: 60%;
            height: 500px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        #drag-container, #spin-container {
            position: relative;
            display: flex;
            margin: auto;
            transform-style: preserve-3d;
            transform: rotateX(-10deg);
            width: 100%;
            height: 100%;
        }
        
        #spin-container {
            animation: spin 30s infinite linear;
        }
        
        #drag-container img {
            transform-style: preserve-3d;
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            background: var(--light-gray);
            padding: 4px;
            border-radius: 24px;
            -webkit-box-reflect: below 15px linear-gradient(transparent, transparent, rgba(0, 0, 0, 0.3));
            box-shadow: 0 0 25px var(--bordeaux-glow);
            transition: all 0.5s ease;
            filter: brightness(0.9);
            border: 2px solid var(--primary-bordeaux);
        }
        
        #drag-container img:hover {
            transform: scale(1.2) translateZ(70px);
            box-shadow: 0 0 50px var(--primary-bordeaux);
            -webkit-box-reflect: below 25px linear-gradient(transparent, transparent, rgba(0, 0, 0, 0.4));
            filter: brightness(1.2) drop-shadow(0 0 30px var(--primary-bordeaux));
            z-index: 100;
            border: 3px solid var(--primary-bordeaux);
        }
        
        #drag-container p {
            position: absolute;
            top: 120%;
            left: 50%;
            transform: translate(-50%, -50%) rotateX(90deg);
            color: var(--primary-bordeaux);
            font-size: 48px;
            font-weight: 800;
            text-shadow: 0 0 30px var(--primary-bordeaux);
            letter-spacing: 6px;
            text-transform: uppercase;
            font-family: 'Poppins', sans-serif;
        }
        
        #ground {
            width: 1200px;
            height: 1200px;
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translate(-50%, -50%) rotateX(90deg);
            background: radial-gradient(ellipse at center, var(--bordeaux-glow) 0%, transparent 70%);
        }
        
        @keyframes spin {
            from { transform: rotateY(0deg); }
            to { transform: rotateY(360deg); }
        }
        
        /* Responsive Design */
        @media (max-width: 1200px) {
            .page-title {
                font-size: 2.8rem;
            }
            
            .benefits-row {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 1024px) {
            .carousel-wrapper {
                flex-direction: column;
                padding: 40px;
                min-height: auto;
            }
            
            .welcome-section {
                width: 85%;
                margin-right: 0;
                margin-bottom: 60px;
                min-width: 300px;
            }
            
            .carousel-container {
                width: 100%;
                height: 400px;
            }
            
            .page-title {
                font-size: 2.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 40px 15px;
            }
            
            .welcome-section {
                width: 95%;
                padding: 35px;
            }
            
            .welcome-section h1 {
                font-size: 2.5rem;
            }
            
            .page-title {
                font-size: 2.2rem;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .benefit-card {
                padding: 30px 25px;
            }
        }
        
        @media (max-width: 480px) {
            .page-title {
                font-size: 2rem;
            }
            
            .welcome-section h1 {
                font-size: 2rem;
            }
            
            .welcome-section {
                min-width: 280px;
                padding: 30px;
            }
            
            .icon-container,
            .stat-icon {
                width: 65px;
                height: 65px;
                font-size: 1.8rem;
            }
            
            .stat-number {
                font-size: 2.2rem;
            }
    
        }
 * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            line-height: 1.6;
        }

      /* Section Nos Marques - Corrections */
.brands-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #000000 0%, #1a0000 50%, #2b2b2b 100%);
    border-top: 1px solid var(--border-gray);
    border-bottom: 1px solid var(--border-gray);
    width: 100vw;
    margin-left: calc(-50vw + 50%);
    position: relative;
    overflow: hidden;
}

.brands-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 30%, var(--bordeaux-glow) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, var(--bordeaux-glow) 0%, transparent 50%);
    opacity: 0.3;
}

.brands-title {
    text-align: center;
    margin-bottom: 60px;
    position: relative;
    z-index: 2;
}

.brands-title h2 {
    font-family: 'Poppins', sans-serif;
    font-size: 3rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 3px;
    background: linear-gradient(45deg, #fff, var(--primary-bordeaux));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: 0 4px 20px rgba(0,0,0,0.2);
}

.brands-title p {
    font-size: 1.2rem;
    color: var(--text-secondary);
    max-width: 600px;
    margin: 0 auto;
    font-weight: 400;
    opacity: 0.9;
}

.slider-container {
    width: 100%;
    overflow: hidden;
    padding: 40px 0;
    position: relative;
    z-index: 2;
}

.slider {
    width: fit-content;
    display: flex;
    align-items: center;
}

.slider-track {
    display: inline-flex;
    animation: slide 30s linear infinite;
    align-items: center;
}

.slide {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin: 0 15px;
    padding: 20px 25px;
    background: rgba(37, 37, 37, 0.9);
    border-radius: 20px;
    box-shadow: var(--shadow-medium);
    transition: var(--transition-bounce);
    flex-shrink: 0;
    border: 1px solid var(--border-gray);
    min-height: 80px;
    backdrop-filter: blur(10px);
    position: relative;
    overflow: hidden;
}

.slide::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-bordeaux);
    border-radius: 20px 20px 0 0;
    transform: scaleX(0);
    transition: var(--transition-smooth);
}

.slide:hover {
    transform: translateY(-8px) scale(1.05);
    box-shadow: var(--shadow-strong);
    border-color: var(--primary-bordeaux);
}

.slide:hover::before {
    transform: scaleX(1);
}

.slide-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    min-width: 80px;
}

.slide img {
    width: 40px;
    height: 40px;
    object-fit: contain;
    filter: grayscale(20%) opacity(0.8);
    transition: var(--transition-bounce);
}

.slide:hover img {
    filter: grayscale(0%) opacity(1);
    transform: scale(1.15);
}

.slide p {
    font-size: 12px;
    margin: 0;
    color: var(--text-secondary);
    font-weight: 600;
    text-align: center;
    letter-spacing: 1px;
    text-transform: uppercase;
    font-family: 'Poppins', sans-serif;
    transition: var(--transition-smooth);
}

.slide:hover p {
    color: var(--primary-bordeaux);
}

@keyframes slide {
    0% { 
        transform: translateX(0); 
    }
    100% { 
        transform: translateX(-50%); 
    }
}

.slider-container:hover .slider-track {
    animation-play-state: paused;
}

/* Stats Container - Corrections */
.stats-container {
            display: flex;
            gap: 20px;
            flex-wrap: nowrap;
            justify-content: center;
            max-width: 1200px;
            width: 100%;
        }

.stat-item {
    background: rgba(37, 37, 37, 0.9);
    border-radius: 24px;
    padding: 40px 35px;
    display: flex;
    align-items: center;
    gap: 30px;
    transition: var(--transition-bounce);
    border: 1px solid var(--border-gray);
    box-shadow: var(--shadow-medium);
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(10px);
}

.stat-item::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 6px;
    background: var(--gradient-bordeaux);
    transform: translateY(100%);
    transition: var(--transition-smooth);
}

.stat-item::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: float 6s ease-in-out infinite;
    opacity: 0.3;
}

.stat-item:hover {
    transform: translateY(-12px) scale(1.03);
    box-shadow: var(--shadow-strong);
    border-color: var(--primary-bordeaux);
}

.stat-item:hover::before {
    transform: translateY(0);
}

.stat-icon {
    width: 85px;
    height: 85px;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.2rem;
    color: var(--primary-bordeaux);
    transition: var(--transition-bounce);
    border: 2px solid var(--bordeaux-glow);
    box-shadow: var(--shadow-bordeaux);
    backdrop-filter: blur(10px);
    position: relative;
    z-index: 2;
}

.stat-item:hover .stat-icon {
    transform: scale(1.1) rotate(5deg);
    background: var(--gradient-bordeaux);
    color: white;
    box-shadow: var(--shadow-bordeaux-hover);
}

.stat-content {
    flex: 1;
    position: relative;
    z-index: 2;
}

.stat-number {
    font-family: 'Poppins', sans-serif;
    font-size: 3.2rem;
    font-weight: 800;
    color: var(--primary-bordeaux);
    line-height: 1;
    margin-bottom: 10px;
    text-shadow: 0 0 20px var(--bordeaux-glow);
    transition: var(--transition-smooth);
}

.stat-item:hover .stat-number {
    color: var(--text-primary);
    text-shadow: 0 0 30px var(--primary-bordeaux);
}

.stat-label {
    font-size: 1.2rem;
    color: var(--text-secondary);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-family: 'Poppins', sans-serif;
    opacity: 0.8;
    transition: var(--transition-smooth);
}

.stat-item:hover .stat-label {
    color: var(--text-primary);
    opacity: 1;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .brands-title h2 {
        font-size: 2.5rem;
    }
    
    .slide {
        margin: 0 10px;
        padding: 15px 20px;
        min-height: 70px;
    }
    
    .slide img {
        width: 35px;
        height: 35px;
    }
    
    .stats-container {
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
        margin: 80px auto 60px;
    }
    
    .stat-item {
        padding: 30px 25px;
        gap: 25px;
    }
    
    .stat-icon {
        width: 75px;
        height: 75px;
        font-size: 2rem;
    }
    
    .stat-number {
        font-size: 2.8rem;
    }
}

@media (max-width: 480px) {
    .brands-title h2 {
        font-size: 2rem;
    }
    
    .stats-container {
        grid-template-columns: 1fr;
        gap: 25px;
    }
    
    .stat-item {
        padding: 25px 20px;
        gap: 20px;
    }
    
    .stat-icon {
        width: 65px;
        height: 65px;
        font-size: 1.8rem;
    }
    
    .stat-number {
        font-size: 2.5rem;
    }
    
    .stat-label {
        font-size: 1.1rem;
    }
}
    </style>
    
</head>
<body>
    
    <!-- 3D Carousel Section -->
    <div class="carousel-section">
        <div class="carousel-wrapper">
            <div class="welcome-section">
                <h1>OfficeTrack</h1>
                <p>Smart office supply management solution. Track inventory, manage orders, and optimize your office resources in one place with our cutting-edge technology.</p>
                <a href="login.php" class="btn">Get Started</a>
            </div>

            <div class="carousel-container">
                <div id="drag-container">
                    <div id="spin-container">
                        <img src="images/pub0.png" alt="Dashboard">
                        <img src="images/pub1.png" alt="Inventory">
                        <img src="images/pub2.png" alt="Orders">
                        <img src="images/pub3.png" alt="Reports">
                        <img src="images/pub4.png" alt="Settings">
                        <p>OfficeTrack</p>
                    </div>
                    <div id="ground"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Why Choose CH Office Track? Discover the Key Benefits!</h1>
            <p class="page-subtitle">Experience the future of office supply management with our innovative features designed to streamline your workflow and boost productivity.</p>
        </div>
        
        <div class="benefits-row">
            <div class="benefit-card">
                <div class="icon-container">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h2>Accurate Stock Tracking</h2>
                <p>With CH Office Track, you always know exactly what you have in stock. Real-time updates, automatic alerts for low levels, and precise records help you avoid shortages and eliminate manual errors.</p>
                <div class="divider"></div>
            </div>
            
            <div class="benefit-card">
                <div class="icon-container">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h3>Cost Reduction</h3>
                <p>Control your spending and avoid waste. By preventing overstocking and unnecessary purchases, you cut costs and make smarter, more efficient buying decisions.</p>
                <div class="divider"></div>
            </div>
            
            <div class="benefit-card">
                <div class="icon-container">
                    <i class="fas fa-clock"></i>
                </div>
                <h2>Time Saving</h2>
                <p>Simplify every step of your supply management. Fast, intuitive requests, automated approvals, and easy tracking save valuable time for both employees and managers.</p>
                <div class="divider"></div>
            </div>
        </div>
<section class="brands-section">
    <div class="brands-title">
        <h2>NOS MARQUES</h2>
        <p>Découvrez notre sélection de marques partenaires de confiance pour tous vos besoins de bureau</p>
    </div>
    
    <div class="slider-container">
        <div class="slider">
            <div class="slider-track">
                <!-- Première série de slides -->
                <div class="slide">
                    <div class="slide-content">
                        <img src="staedtler.png" alt="Staedtler">
                        <p>Staedtler</p>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <img src="sharp.png" alt="Sharp">
                        <p>Sharp</p>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <img src="selecta.jpg" alt="Selecta">
                        <p>Selecta</p>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <img src="maped.png" alt="Maped">
                        <p>Maped</p>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <img src="scotch.png" alt="Scotch">
                        <p>Scotch</p>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <img src="hp.png" alt="HP">
                        <p>HP</p>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <img src="dell.png" alt="Dell">
                        <p>Dell</p>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <img src="casio.png" alt="Casio">
                        <p>Casio</p>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <img src="bic.png" alt="Bic">
                        <p>Bic</p>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <img src="canon.jpg" alt="Canon">
                        <p>Canon</p>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <img src="epson.png" alt="Epson">
                        <p>Epson</p>
                    </div>
                </div>
                
                <!-- Duplication pour l'effet infini -->
                <div class="slide">
                    <div class="slide-content">
                        <img src="staedtler.png" alt="Staedtler">
                        <p>Staedtler</p>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <img src="sharp.png" alt="Sharp">
                        <p>Sharp</p>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <img src="selecta.jpg" alt="Selecta">
                        <p>Selecta</p>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <img src="maped.png" alt="Maped">
                        <p>Maped</p>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <img src="scotch.png" alt="Scotch">
                        <p>Scotch</p>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <img src="hp.png" alt="HP">
                        <p>HP</p>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <img src="dell.png" alt="Dell">
                        <p>Dell</p>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <img src="casio.png" alt="Casio">
                        <p>Casio</p>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <img src="bic.png" alt="Bic">
                        <p>Bic</p>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <img src="canon.jpg" alt="Canon">
                        <p>Canon</p>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <img src="epson.png" alt="Epson">
                        <p>Epson</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">70</div>
                    <div class="stat-label">Products</div>
                </div>
            </div>
            
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">12</div>
                    <div class="stat-label">Partnerships</div>
                </div>
            </div>
            
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">5</div>
                    <div class="stat-label">Certificates</div>
                </div>
            </div>
            
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">3000</div>
                    <div class="stat-label">Reviews</div>
                </div>
            </div>
        </div>
    </div>
</section>
    <script>
        // Configuration for 3D Carousel
        const radius = 350;
        const imgWidth = 220;
        const imgHeight = 280;

        // Initialize elements
        const odrag = document.getElementById('drag-container');
        const ospin = document.getElementById('spin-container');
        const aImg = ospin.getElementsByTagName('img');
        const aEle = [...aImg];
        const ground = document.getElementById('ground');

        // Set initial sizes
        ospin.style.width = `${imgWidth}px`;
        ospin.style.height = `${imgHeight}px`;
        ground.style.width = `${radius * 3.5}px`;
        ground.style.height = `${radius * 3.5}px`;

        // Position images in 3D space
        function init() {
            aEle.forEach((ele, i) => {
                const angle = (i * (360 / aEle.length));
                ele.style.transform = `rotateY(${angle}deg) translateZ(${radius}px)`;
            });
        }

        // Mouse movement tracking
        let mouseX = 0;
        let mouseY = 0;
        let currentX = 0;
        let currentY = 0;
        const smoothFactor = 0.05;

        function updateRotation() {
            const targetX = (mouseY / window.innerHeight) * 180 - 90;
            const targetY = (mouseX / window.innerWidth) * 360;
            
            currentX += (targetX - currentX) * smoothFactor;
            currentY += (targetY - currentY) * smoothFactor;
            
            const constrainedX = Math.max(-30, Math.min(30, currentX));
            odrag.style.transform = `rotateX(${-constrainedX}deg) rotateY(${currentY}deg)`;
            
            requestAnimationFrame(updateRotation);
        }

        // Track mouse position
        document.addEventListener('mousemove', (e) => {
            mouseX = e.clientX;
            mouseY = e.clientY;
        });

        // Initialize and start animation
        setTimeout(init, 500);
        updateRotation();

        // Pause auto-rotation when interacting
        ospin.addEventListener('mouseenter', () => {
            ospin.style.animationPlayState = 'paused';
        });
        
        ospin.addEventListener('mouseleave', () => {
            ospin.style.animationPlayState = 'running';
        });

        // Counter animation for stats
        document.addEventListener('DOMContentLoaded', function() {
            const statNumbers = document.querySelectorAll('.stat-number');
            statNumbers.forEach(numberElement => {
                const target = parseInt(numberElement.textContent);
                const duration = 1500;
                const step = target / (duration / 16);
                let current = 0;
                
                const counter = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        clearInterval(counter);
                        numberElement.textContent = target;
                    } else {
                        numberElement.textContent = Math.floor(current);
                    }
                }, 16);
            });
        });
    </script>
<?php include 'footer.php'; ?>
</body>
</html>