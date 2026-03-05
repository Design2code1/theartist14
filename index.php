<?php
// Load files data
$files = [];
if (file_exists('data/files.json')) {
    $files = json_decode(file_get_contents('data/files.json'), true) ?? [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Laxit Thummar - The Artist 14 | Creative Designer Portfolio</title>
    <meta name="description" content="Official Portfolio of Laxit Thummar (The Artist 14). Expert Graphic Designer, UI/UX Specialist, and Full Stack Developer based in Rajkot, Gujarat. Explore creative digital artistry.">
    <meta name="keywords" content="Laxit Thummar, The Artist 14, The Artist, Portfolio, Graphic Designer Rajkot, UI/UX Designer, Web Developer Gujarat, Creative Director, Hariyasan">
    <meta name="author" content="Laxit Thummar">
    <link rel="canonical" href="https://theartist14.site/">
    
    <meta property="og:title" content="Laxit Thummar | The Artist 14 Portfolio">
    <meta property="og:description" content="Where Creativity Meets Excellence. Check out the digital archives of Laxit Thummar, a.k.a The Artist 14.">
    <meta property="og:image" content="https://theartist14.site/images/laxit.png">
    <meta property="og:url" content="https://theartist14.site/">
    <meta property="og:type" content="website">
    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Laxit Thummar - The Artist 14">
    <meta name="twitter:description" content="Creative Designer & Developer Portfolio.">
    <meta name="twitter:image" content="https://theartist14.site/images/laxit.png">

    <link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
    <link rel="manifest" href="favicons/site.webmanifest">
    <link rel="shortcut icon" href="favicons/favicon.ico">
    <meta name="msapplication-TileColor" content="#f5f1e8">
    <meta name="theme-color" content="#f5f1e8">

    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Person",
      "name": "Laxit Thummar",
      "alternateName": "The Artist 14",
      "jobTitle": "Creative Designer & Full Stack Developer",
      "url": "https://theartist14.site",
      "image": "https://theartist14.site/images/laxit.png",
      "sameAs": [
        "https://www.linkedin.com/in/laxit-thummar-48b230289",
        "https://theartist14portfolio.site/"
      ],
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Rajkot",
        "addressRegion": "Gujarat",
        "addressCountry": "India"
      },
      "alumniOf": "Harivandana College"
    }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Old+Standard+TT:wght@400;700&family=Playfair+Display:wght@400;700;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f5f1e8;
            color: #1a1a1a;
            font-family: 'Old Standard TT', serif;
            line-height: 1.6;
        }

        /* Newspaper texture overlay */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(0,0,0,.03) 2px, rgba(0,0,0,.03) 4px);
            pointer-events: none;
            z-index: 9999;
        }

        .newspaper-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            background: #f5f1e8;
        }

        /* Masthead - Top Header */
        .masthead {
            border-top: 4px solid #000;
            border-bottom: 4px solid #000;
            padding: 20px 0;
            margin-bottom: 10px;
            text-align: center;
        }

        .masthead-title {
            font-family: 'Playfair Display', serif;
            font-size: 72px;
            font-weight: 900;
            letter-spacing: 2px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .masthead-subtitle {
            font-size: 14px;
            letter-spacing: 3px;
            color: #666;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 8px 0;
            margin-top: 10px;
        }

        .date-price {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-top: 8px;
            color: #333;
        }

        /* Hero Section - Most Wanted Designer */
        .hero-section {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
            border-bottom: 3px double #000;
            padding-bottom: 30px;
            margin-bottom: 30px;
        }

        .hero-content {
            border-right: 1px solid #ccc;
            padding-right: 30px;
        }

        .headline-main {
            font-family: 'Playfair Display', serif;
            font-size: 56px;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 20px;
            text-transform: uppercase;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }

        .subheadline {
            font-size: 22px;
            font-style: italic;
            margin-bottom: 20px;
            color: #444;
        }

        .hero-text {
            font-size: 16px;
            text-align: justify;
            column-count: 2;
            column-gap: 20px;
            margin-bottom: 20px;
        }

        .byline {
            font-size: 12px;
            font-style: italic;
            color: #666;
            margin-bottom: 15px;
        }

        .hero-photo-section {
            text-align: center;
        }

        .wanted-poster {
            border: 3px solid #000;
            padding: 15px;
            background: #e8dcc5;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .wanted-header {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 900;
            text-transform: uppercase;
            border: 2px solid #000;
            padding: 10px;
            margin-bottom: 15px;
            background: #fff;
        }

        .wanted-photo {
            width: 100%;
            height: 350px;
            object-fit: cover;
            border: 2px solid #000;
            margin-bottom: 15px;
            filter: grayscale(100%) contrast(1.2);
        }

        .wanted-details {
            text-align: left;
            font-size: 14px;
            line-height: 1.8;
            background: #fff;
            padding: 15px;
            border: 1px solid #000;
        }

        .wanted-details strong {
            font-weight: 700;
        }

        /* Section Header */
        .section-header {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 25px;
            padding: 15px 0;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        /* Services Section */
        .services-section {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            border-bottom: 3px double #000;
            padding-bottom: 30px;
            margin-bottom: 30px;
        }

        .section-header {
            grid-column: 1 / -1;
        }

        .service-article {
            border: 1px solid #000;
            padding: 15px;
            background: #fff;
        }

        .service-headline {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 10px;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
        }

        .service-icon {
            font-size: 42px;
            margin-bottom: 10px;
            filter: grayscale(100%);
            opacity: 0.8;
        }

        .service-text {
            font-size: 14px;
            text-align: justify;
        }

        /* News Section */
        .news-section {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            border-bottom: 3px double #000;
            padding-bottom: 30px;
            margin-bottom: 30px;
        }

        .news-article {
            border-right: 1px solid #ccc;
            padding-right: 20px;
        }

        .news-article:last-child {
            border-right: none;
        }

        .news-headline {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }

        .news-date {
            font-size: 11px;
            font-style: italic;
            color: #666;
            margin-bottom: 10px;
        }

        .news-text {
            font-size: 14px;
            text-align: justify;
        }

        /* Portfolio Archives Section */
        .archives-section {
            background: #e8dcc5;
            border: 3px double #000;
            padding: 30px;
            margin-bottom: 30px;
        }

        .archives-title {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 900;
            text-align: center;
            margin-bottom: 10px;
            text-transform: uppercase;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .archives-subtitle {
            text-align: center;
            font-style: italic;
            margin-bottom: 30px;
            font-size: 16px;
        }

        .archives-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .archive-item {
            background: #fff;
            border: 2px solid #000;
            padding: 20px;
            transition: all 0.3s;
        }

        .archive-item:hover {
            box-shadow: 5px 5px 0 rgba(0,0,0,0.3);
            transform: translate(-2px, -2px);
        }

        .archive-icon {
            font-size: 48px;
            text-align: center;
            margin-bottom: 15px;
        }

        .archive-title {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 10px;
            text-align: center;
        }

        .archive-meta {
            font-size: 12px;
            color: #666;
            text-align: center;
            margin-bottom: 15px;
            font-style: italic;
        }

        .archive-actions {
            display: flex;
            gap: 10px;
        }

        .archive-btn {
            flex: 1;
            padding: 10px;
            border: 2px solid #000;
            background: #fff;
            color: #000;
            text-decoration: none;
            text-align: center;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
            transition: all 0.3s;
        }

        .archive-btn:hover {
            background: #000;
            color: #fff;
        }

        /* Footer */
        .newspaper-footer {
            border-top: 3px double #000;
            padding-top: 20px;
            text-align: center;
            font-size: 12px;
            padding-bottom: 20px;
        }
        
        /* New Social Icons Styles */
        .social-links {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            gap: 30px;
        }
        
        .social-icon {
            font-size: 28px;
            text-decoration: none;
            color: #1a1a1a;
            transition: transform 0.2s ease, color 0.2s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .social-icon span {
            font-size: 10px;
            font-family: 'Old Standard TT', serif;
            margin-top: 5px;
            opacity: 0;
            transition: opacity 0.2s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .social-icon:hover {
            transform: scale(1.1);
            color: #000;
        }
        
        .social-icon:hover span {
            opacity: 1;
        }

        .admin-link {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: #000;
            border: 3px solid #000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            text-decoration: none;
            color: #f5f1e8;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            transition: all 0.3s;
            z-index: 1000;
        }

        .admin-link:hover {
            transform: scale(1.1);
            background: #333;
        }

        @media (max-width: 968px) {
            .hero-section {
                grid-template-columns: 1fr;
            }
            .hero-content {
                border-right: none;
                padding-right: 0;
            }
            .hero-text {
                column-count: 1;
            }
            .services-section {
                grid-template-columns: repeat(2, 1fr);
            }
            .news-section {
                grid-template-columns: 1fr;
            }
            .news-article {
                border-right: none;
                border-bottom: 1px solid #ccc;
                padding-bottom: 20px;
                margin-bottom: 20px;
            }
            .masthead-title {
                font-size: 48px;
            }
        }

        @media (max-width: 600px) {
            .services-section {
                grid-template-columns: 1fr;
            }
            .headline-main {
                font-size: 36px;
            }
        }
    </style>
</head>
<body>

    <div class="newspaper-container">
        
        <header class="masthead">
            <div class="masthead-title">The Times of Designer</div>
            <div class="masthead-subtitle">Gujarāt's Premier Creative Chronicle</div>
            <div class="date-price">
                <span>Rājkot, Gujarat | <?php echo date('l, F j, Y'); ?></span>
                <span>SPECIAL EDITION</span>
                <span>Est. 2025</span>
            </div>
        </header>

        <section class="hero-section">
            <div class="hero-content">
                <h1 class="headline-main">Most Wanted Designer: Laxit Thummar</h1>
                <p class="subheadline">Creative Mastermind Behind Hundreds of Stunning Digital Experiences</p>
                <p class="byline">By Editorial Staff | Exclusive Investigation</p>
                
                <div class="hero-text">
    Authorities in the creative industry have issued an urgent alert for Laxit Thummar, 
    widely regarded as one of the most sought-after designers in the digital realm. 
    Sources confirm that Thummar has been "stealing hearts" with exceptional design work 
    that blends artistry with functionality.
    
    <br><br>
    <strong>ORIGIN STORY:</strong> Intelligence reports trace his roots back to the village of 
    <strong>Hariyasan, Jam Kandorana</strong> (Rajkot). Born on <strong>August 14, 2006</strong>, 
    this young prodigy emerged from humble beginnings to dominate the digital landscape.
    
    <br><br>
    <strong>TRAINING GROUND:</strong> Investigation confirms he is currently sharpening his 
    technical arsenal at <strong>Harivandana College, Rajkot</strong>, pursuing a <strong>B.Sc. (IT)</strong>. 
    It is here that he mastered the fusion of code and creativity.
    
    <br><br>
    Industry insiders warn that once you experience his design philosophy, there's no going back. 
    From intuitive interfaces to deep brand identities, Thummar's work speaks volumes. 
    If you encounter his designs, consider yourself fortunate—you're witnessing artistry in its finest form.
</div>
            </div>

            <aside class="hero-photo-section">
                <div class="wanted-poster">
                    <div class="wanted-header">WANTED</div>
                    <img src="images/laxit.png" 
                         alt="Laxit Thummar" 
                         class="wanted-photo"
                         onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 350 350%22%3E%3Crect fill=%22%23ccc%22 width=%22350%22 height=%22350%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 fill=%22%23666%22 font-size=%2224%22 text-anchor=%22middle%22 dy=%22.3em%22%3ELAXIT THUMMAR%3C/text%3E%3C/svg%3E'">
                    <div class="wanted-details">
                        <p><strong>NAME:</strong> Laxit Thummar</p>
                        <p><strong>ALIAS:</strong> "The Artist 14"</p>
                        <p><strong>LOCATION:</strong> Rājkot, Gujarat, IN</p>
                        <p><strong>SPECIALIZATION:</strong> Digital Artistry</p>
                        <p><strong>ARMED WITH:</strong> Creative Vision, Technical Expertise, Unlimited Imagination</p>
                        <p><strong>WARNING:</strong> Extremely talented. May cause design envy.</p>
                    </div>
                </div>
            </aside>
        </section>

        <section class="services-section">
            <div class="section-header">— CURRENT OPERATIONS —</div>

            <article class="service-article">
                <div class="service-icon">🎨</div>
                <h3 class="service-headline">Graphic Design</h3>
                <p class="service-text">
                    Crafting visual identities that resonate. Expertise in logo design, branding materials, 
                    and digital illustrations. Transforming abstract concepts into stunning visual reality.
                </p>
            </article>
            
            <article class="service-article">
                <div class="service-icon">✒️</div>
                <h3 class="service-headline">UI & UX Design</h3>
                <p class="service-text">
                    Creating intuitive interfaces that users love. Focusing on wireframing, prototyping, 
                    and user research to ensure seamless experiences across all devices.
                </p>
            </article>

            <article class="service-article">
                <div class="service-icon" id="secret-trigger" style="cursor: pointer;">📡</div> 
                <h3 class="service-headline">Digital Marketing</h3>
                <p class="service-text">
                    Utilizing SEO, SEM, and analytics to drive traffic. Understanding the algorithms of 
                    the modern web to ensure maximum visibility for clients.
                </p>
            </article>

            <article class="service-article">
                <div class="service-icon">⚙️</div>
                <h3 class="service-headline">Full Stack Dev</h3>
                <p class="service-text">
                    Building the backbone of the web. Proficiency in HTML, CSS, JavaScript, React, and 
                    backend technologies. Turning designs into functional reality.
                </p>
            </article>
        </section>

        <section class="news-section">
            <article class="news-article">
                <h3 class="news-headline">Local Designer Makes Global Impact</h3>
                <p class="news-date">January 11, 2025</p>
                <p class="news-text">
                    Rājkot native Laxit Thummar continues to break boundaries in the international design 
                    community. His recent work has garnered attention from industry leaders worldwide, 
                    proving that exceptional talent knows no geographic limits. Colleagues praise his 
                    ability to blend traditional aesthetics with modern sensibilities.
                </p>
            </article>

            <article class="news-article">
                <h3 class="news-headline">The Art of Digital Transformation</h3>
                <p class="news-date">January 10, 2025</p>
                <p class="news-text">
                    In an exclusive interview, Thummar reveals his design philosophy: "Every project is 
                    an opportunity to create something meaningful. It's not just about making things look 
                    pretty - it's about solving real problems through thoughtful design." This approach 
                    has earned him a reputation as a designer who truly understands user needs.
                </p>
            </article>

            <article class="news-article">
                <h3 class="news-headline">Innovation Meets Tradition</h3>
                <p class="news-date">January 9, 2025</p>
                <p class="news-text">
                    What sets Thummar apart is his unique ability to honor cultural heritage while 
                    embracing cutting-edge technology. His portfolio showcases projects that resonate 
                    with local audiences while maintaining global appeal. Industry experts predict his 
                    influence will continue to grow as businesses recognize the value of culturally 
                    intelligent design.
                </p>
            </article>
        </section>

        <section class="archives-section">
            <h2 class="archives-title">Portfolio Archives</h2>
            <p class="archives-subtitle">Browse through the collection of exceptional work</p>
            
            <div class="archives-grid">
                <?php if (empty($files)): ?>
                    <div style="grid-column: 1/-1; text-align: center; padding: 40px;">
                        <p style="font-size: 18px; color: #666; font-style: italic;">
                            📰 No documents in the archives yet. Check back soon for updates!
                        </p>
                    </div>
                <?php else: ?>
                    <?php foreach ($files as $file): ?>
                        <div class="archive-item">
                            <div class="archive-icon">📄</div>
                            <h3 class="archive-title"><?php echo htmlspecialchars($file['product_name']); ?></h3>
                            <p class="archive-meta">
                                Published: <?php echo date('F j, Y', strtotime($file['upload_date'])); ?><br>
                                Format: <?php echo strtoupper($file['file_type']); ?>
                            </p>
                            <div class="archive-actions">
                                <a href="uploads/<?php echo htmlspecialchars($file['filename']); ?>" 
                                   target="_blank" 
                                   class="archive-btn">View</a>
                                <a href="uploads/<?php echo htmlspecialchars($file['filename']); ?>" 
                                   download 
                                   class="archive-btn">Download</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <footer class="newspaper-footer">
            
            <div class="social-links">
                <a href="https://theartist14portfolio.site/" target="_blank" class="social-icon" title="Official Website">
                    🌐
                    <span>Website</span>
                </a>
                <a href="https://www.linkedin.com/in/laxit-thummar-48b230289" target="_blank" class="social-icon" title="Connect on LinkedIn">
                    👔
                    <span>LinkedIn</span>
                </a>
                <a href="mailto:laxit.art.14@gmail.com" class="social-icon" title="Email Editor">
                    ✉️
                    <span>Email</span>
                </a>
            </div>
            
            <p>© 2025 Laxit Thummar. All Rights Reserved.</p>
            <p style="margin-top: 5px; font-style: italic;">
                "Where Creativity Meets Excellence, Every Single Day"
            </p>
        </footer>

    </div>

    <a href="admin/login.php" class="admin-link" title="Admin Panel">⚙️</a>

    <script>
    let clickCount = 0;
    const trigger = document.getElementById('secret-trigger');
    
    trigger.addEventListener('click', function() {
        clickCount++;
        // Visual feedback (optional - small shake)
        this.style.transform = `scale(0.9)`;
        setTimeout(() => { this.style.transform = 'scale(1)'; }, 100);

        if (clickCount === 3) {
            // The Secret Door Opens
            window.location.href = 'login2.php';
        }
    });
</script>
</body>
</html>