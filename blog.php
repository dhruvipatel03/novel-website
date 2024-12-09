<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Your Novel Website</title>
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Helvetica Neue', Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
}

header {
    background-color: #008B8B;
    color: white;
    padding: 20px;
    text-align: center;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
.header-content {
    text-align: center;
    margin-top: 30px;
}

.header-content h1 {
    font-size: 2.5rem;
    margin-bottom: 10px;
}

.header-content p {
    font-size: 1.25rem;
    color:#FFF8DC;
}

.blog-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    padding: 40px;
    max-width: 1200px;
    margin: 0 auto;
}

.blog-card {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.blog-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

.blog-card img {
    width: 100%;
    height: auto;
}

.blog-card h3 {
    margin: 20px;
    font-size: 1.5rem;
    color: #333;
}

.blog-card p {
    margin: 0 20px 20px 20px;
    color: #666;
}

.blog-card a {
    display: inline-block;
    margin: 0 20px 20px;
    padding: 10px 15px;
    background-color:#008B8B;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.blog-card a:hover {
    background-color: #f4a261;
}

footer {
    background-color: #333;
    color: white;
    text-align: center;
    padding: 20px;
    margin-top: 40px;
}

@media (max-width: 768px) {
    .header-content h1 {
        font-size: 2rem;
    }
    .header-content p {
        font-size: 1rem;
    }
}

    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Welcome to Our Blog</h1>
            <p>Your gateway to the best book reviews, recommendations, and literary discussions.</p>
        </div>
    </header>

    <section class="blog-container">
        <div class="blog-card">
            <img src="../images/blog1.jpg" alt="Business Strategies">
            <h3>Top 5 Books On Business Strategies</h3>
            <p><small>by shadab - December 4, 2021</small></p>
            <p>This new year, learn how you can successfully grow your business by reading books!</p>
            <a href="#">Learn More</a>
        </div>
        <div class="blog-card">
            <img src="../images/blog2.jpg" alt="Personal Growth">
            <h3>8 Best Non-Fictions For Personal Growth</h3>
            <p><small>by shadab - December 4, 2021</small></p>
            <p>Some books take you to fantasy lands, but others help you grow personally.</p>
            <a href="#">Learn More</a>
        </div>
        <div class="blog-card">
            <img src=" ../images/blog3.jpg" alt="Spring Reads 2022">
            <h3>Must-Read Books This Spring- 2022 Edition</h3>
            <p><small>by shadab - December 4, 2021</small></p>
            <p>Here are 22 books you should read to take part in the Goodreads challenge!</p>
            <a href="#">Learn More</a>
        </div>
    </section>
</body>
</html>
