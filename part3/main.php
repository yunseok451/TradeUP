<?php
// main.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TradeUp - Latest and Trending Products</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    

    <main>
        <div class="main-container">
            <!-- Latest Products Section -->
            <section class="latest-products">
                <h2>Latest Products</h2>
                <div class="product-grid">
                    <div class="product">
                        <img src="images/Supreme Box Logo Hooded Sweatshirt Navy.jpg" alt="Latest Product 1">
                        <h3>Supreme Box Logo Hooded Sweatshirt Navy</h3>
                        <p>₩129,000</p>
                    </div>
                    <div class="product">
                        <img src="images/Onitsuka Tiger GSM Cream Hiking Green.jpg" alt="Latest Product 2">
                        <h3>Onitsuka Tiger GSM Cream Hiking Green</h3>
                        <p>₩256,000</p>
                    </div>
                    <div class="product">
                        <img src="images/Levi's x Oasis Deca Logo T-Shirt Black.jpg" alt="Latest Product 3">
                        <h3>Levi's x Oasis Deca Logo T-Shirt Black</h3>
                        <p>₩120,000</p>
                    </div>
                </div>
            </section>

            <!-- Trending Products Section -->
            <section class="trending-products">
                <h2>Trending Products</h2>
                <div class="product-grid">
                    <div class="product">
                        <img src="images/Nike x Supreme Air Force 1 Low White Speed Red.jpg" alt="Trending Product 1">
                        <h3>Nike x Supreme Air Force 1 Low White Speed Red</h3>
                        <p>₩99,000</p>
                    </div>
                    <div class="product">
                        <img src="images/(W) Matin Kim Matin Stitch Point Crop Cardigan Black.jpg" alt="Trending Product 2">
                        <h3>(W) Matin Kim Matin Stitch Point Crop Cardigan Black</h3>
                        <p>₩159,000</p>
                    </div>
                    <div class="product">
                        <img src="images/Palace Italia Zip Funnel Black.jpg" alt="Trending Product 3">
                        <h3>Palace Italia Zip Funnel Black</h3>
                        <p>₩182,000</p>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .main-container {
            padding: 20px;
        }
        section {
            margin-bottom: 40px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        .product {
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            background-color: #fff;
        }
        .product img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .product h3 {
            margin: 10px 0;
            font-size: 18px;
        }
        .product p {
            color: #555;
            font-size: 16px;
        }
    </style>
</body>
</html>
