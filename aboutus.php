<?php
// about-us.php
require_once('header.php');
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
    
    .about-section {
        background-color: white;
        padding: 80px 0;
    }
    
    .about-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        font-family: 'Poppins', sans-serif;
        color: #2d3436;
    }
    
    .about-content-wrapper {
        display: flex;
        gap: 60px;
        align-items: center;
    }
    
    .about-text {
        flex: 1;
        line-height: 1.8;
        font-size: 16px;
        letter-spacing: 0.3px;
        padding: 40px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(218, 49, 58, 0.1);
        border: 1px solid rgba(218, 49, 58, 0.1);
        position: relative;
        overflow: hidden;
    }
    
    .about-text::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(to bottom, #da313a, #f02f49);
    }
    
    .about-header {
        margin-bottom: 40px;
    }
    
    .about-header h1 {
        font-size: 42px;
        color: #da313a;
        margin-bottom: 20px;
        font-weight: 700;
        position: relative;
        display: inline-block;
        text-shadow: 2px 2px 4px rgba(218, 49, 58, 0.2);
    }
    
    .about-header h1:after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -10px;
        width: 60%;
        height: 4px;
        background: linear-gradient(90deg, #fc2d2d, #f82530);
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(252, 45, 45, 0.3);
    }
    
    .about-text p {
        margin-bottom: 25px;
        padding-left: 15px;
        position: relative;
    }
    
    .about-text p::before {
        content: '•';
        color: #da313a;
        font-weight: bold;
        font-size: 20px;
        position: absolute;
        left: -5px;
        top: 0;
    }
    
    .about-images {
        flex: 1;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        position: relative;
    }
    
    .circle-image {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        z-index: 1;
        filter: brightness(0.95);
    }
    
    .circle-image:hover {
        transform: scale(1.1) translateY(-10px);
        box-shadow: 0 15px 35px rgba(218, 49, 58, 0.3);
        filter: brightness(1);
        z-index: 2;
    }
    
    .circle-image::after {
        content: '';
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        border-radius: 50%;
        border: 2px dashed rgba(218, 49, 58, 0.3);
        pointer-events: none;
        transition: all 0.4s ease;
    }
    
    .circle-image:hover::after {
        transform: rotate(15deg);
        border-color: rgba(218, 49, 58, 0.6);
    }
    
    /* Floating animation for images */
    .image-1 {
        animation: float 6s ease-in-out infinite;
    }
    
    .image-2 {
        animation: float 5s ease-in-out infinite 0.5s;
    }
    
    .image-3 {
        animation: float 7s ease-in-out infinite 0.3s;
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }
    
    /* Decorative elements */
    .circle-dots {
        position: absolute;
        width: 20px;
        height: 20px;
        background: rgba(218, 49, 58, 0.2);
        border-radius: 50%;
    }
    
    .dot-1 {
        top: 20px;
        left: 30px;
        animation: pulse 3s infinite;
    }
    
    .dot-2 {
        bottom: 40px;
        right: 20px;
        width: 15px;
        height: 15px;
        animation: pulse 4s infinite 0.5s;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); opacity: 0.6; }
        50% { transform: scale(1.3); opacity: 0.3; }
        100% { transform: scale(1); opacity: 0.6; }
    }
    
    @media (max-width: 768px) {
        .about-content-wrapper {
            flex-direction: column;
        }
        
        .about-images {
            margin-top: 40px;
            gap: 20px;
        }
        
        .circle-image {
            width: 140px;
            height: 140px;
        }
    }
</style>

<section class="about-section">
    <div class="about-container">
        <div class="about-content-wrapper">
            <div class="about-text">
                <div class="about-header">
                    <h1>About Us</h1>
                </div>
                
                <p>CH Office Track is a smart and user-friendly application designed to strengthen the management of office supplies and furniture. Built for businesses, institutions, and administrative teams, our mission is to help you save time, reduce costs, and gain full control over your stock.</p>
                
                <p>From one-time inventory tracking to easy required submissions, supplier orders, and detailed reports — CH Office Track brings everything you need into one simple, financial platform.</p>
                
                <p>Developed in India with a focus on local needs, we proudly partner with trusted suppliers and office furniture stores in size to ensure that our procurement across.</p>
                
                <p>Whether you're managing a small office or a large organization, CH Office Track helps you organize better, spend smarter, and work further.</p>
            </div>
            
            <div class="about-images">
                <div class="circle-dots dot-1"></div>
                <div class="circle-dots dot-2"></div>
                
                <img src="log.png" alt="Office Management" class="circle-image image-1">
                <img src="CH.png" alt="Office Team" class="circle-image image-2">
                <img src="GH.jpg" alt="Office Space" class="circle-image image-3">
            </div>
        </div>
    </div>
</section>

<?php
require_once('footer.php');
?>